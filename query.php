<?php
session_start();
require('Classes.php');

/* Normally this should not happen because 'race' is declared in index.php
   This can happen only with direct access to the query page */
if (!isset($_SESSION['race'])) return;

$race = unserialize($_SESSION['race']);
$mapRequest = new MapRequest();

// List of required $_GET[...] for each action
$required_arg = Array(
    "place" => Array("text"),
    "details" => Array("place_id"),
    "geocoding" => Array("latlng"),
    "address" => Array("place_id", "start_or_end"),
    "vehicle" => Array("vehicle_ref"),
    "parameters" => Array("test"));


if (isOk("place", $required_arg)) {
    echo json_encode($mapRequest->getPlaces(urlencode($_GET['text'])));
} else if (isOk("details", $required_arg)) {
    echo json_encode($mapRequest->getDetails(urlencode($_GET['place_id'])));
} else if (isOk("geocoding", $required_arg)) {
    echo json_encode($mapRequest->getGeocoding($_GET['latlng']));
} else if (isOk("address", $required_arg)) {
    /*  We need longitude and latitude informations about the place
    We use $mapRequest->getDetails to get them*/
    $place_details = $mapRequest->getDetails($_GET['place_id']);
    $lat = $place_details[0]["lat"];
    $lng = $place_details[0]["lng"];
    $formatted_address = $place_details[0]["formatted_address"];
    $name = $place_details[0]["name"];

    // Due to some name localisation problem, we need to check if the formatted_address equals to Switzerland. If yes, we prefer to take the name result
    if ($formatted_address === "Switzerland")
        $formatted_address = $name;

    if ($_GET['start_or_end'] == "start") {
        $start_address = Array("start_formatted_address" => $formatted_address, "lat" => $lat, "lng" => $lng);
        $race->setStartAddress($start_address);;
    } else if ($_GET['start_or_end'] == "end") {
        $end_address = Array("end_formatted_address" => $formatted_address, "lat" => $lat, "lng" => $lng);
        $race->setEndAddress($end_address);
    }

    $_SESSION['race'] = serialize($race);
} else if (isOk("vehicle", $required_arg)) {
    $race->setVehicle($_GET['vehicle_ref']);
    $_SESSION['race'] = serialize($race);
} else if(isOk("parameters", $required_arg)){
    echo json_encode($race->getAreAllParametersSet());
} else {
    echo "ERROR";
}

function isOk($arg, $list)
{
    if (!isset($_GET['type']) || $_GET['type'] != $arg) return false;
    $pos = array_search($arg, array_keys($list), true);
    foreach ($list[$arg] as $_arg) {
        if (!isset($_GET[$_arg]) || empty($_GET[$_arg]))
            return false;
    }
    return true;
}