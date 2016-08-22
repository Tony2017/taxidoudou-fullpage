<?php

if (isset($_GET['text']) && !empty($_GET['text'])) {
    $urlEncoded = urlencode($_GET['text']);

    if (isset($_GET['type']) && $_GET['type'] === "place") {
        $json = file_get_contents('https://maps.googleapis.com/maps/api/place/autocomplete/json?input=' . $urlEncoded . '&components=country:ch&location=0,0&radius=20000000&language=fr_CH&key=AIzaSyDjYfntYI75cqHJlntIO6w8uZKQooRnaIQ');
//        print_r($json);
        $obj = json_decode($json, true)["predictions"];

        $numb_of_arrays = count($obj);

        for ($i = 0; $i < $numb_of_arrays; $i++) {
//			$json_position = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($obj[$i]['description']) . '&components=country:ch');
//			$obj2 = json_decode($json_position, true)["results"];
//
//			$lat = $obj2[0]["geometry"]["location"]["lat"];
//			$lng = $obj2[0]["geometry"]["location"]["lng"];

            $lat = 0;
            $lng = 0;

            $encoded_array[] = array("description" => $obj[$i]['description'], "lat" => $lat, "lng" => $lng);
        }
        /*

                $fileContents= file_get_contents('https://tel.search.ch/api/?was='. $urlEncoded .'&privat=0&lang=fr&key=061f9c5a9ced3d385d7169be73c3f58f');
                $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
                $fileContents = str_replace("tel:", "", $fileContents);
                $fileContents = trim(str_replace('"', "'", $fileContents));
                $simpleXml = simplexml_load_string($fileContents);
                $json = json_encode($simpleXml);
                $obj_telSearchResults = json_decode($json, true)["entry"];

                $numb_of_arrays = count($obj_telSearchResults);

                for($i = 0; $i < $numb_of_arrays; $i++){
                    $encoded_array[] = array("description" => $obj_telSearchResults[$i]['name'], "lat" => 0, "lng" => 0);
                }


                $fileContents= file_get_contents('https://tel.search.ch/api/?wo='. $urlEncoded .'&privat=0&lang=fr&key=061f9c5a9ced3d385d7169be73c3f58f');
                $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
                $fileContents = str_replace("tel:", "", $fileContents);
                $fileContents = trim(str_replace('"', "'", $fileContents));
                $simpleXml = simplexml_load_string($fileContents);
                $json = json_encode($simpleXml);
                $obj_telSearchResults = json_decode($json, true)["entry"];

                $numb_of_arrays = count($obj_telSearchResults);

                for($i = 0; $i < $numb_of_arrays; $i++){
                    $encoded_array[] = array("description" => $obj_telSearchResults[$i]['name'], "lat" => 0, "lng" => 0);
                }
        */
        //print_r($obj_telSearchResults);

        echo json_encode($encoded_array);

        /*
        Possibilité d'utiliser ajax-getstop.exe de CFF au lien suivant
        http://fahrplan.sbb.ch/bin/ajax-getstop.exe/fny?start=1&tpl=suggest2json&encoding=utf-8&REQ0JourneyStopsS0A=7&getstop=1&noSession=yes&REQ0JourneyStopsB=10&REQ0JourneyStopsS0G=ICI_LA_VILLE%3F&js=true&
        */

    } else if (isset($_GET['type']) && $_GET['type'] === "geocode") {
        $urlEncoded = urlencode($_GET['text']);
        $json_position = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($urlEncoded) . '&components=country:CH');
        $obj2 = json_decode($json_position, true)["results"];

        $lat = $obj2[0]["geometry"]["location"]["lat"];
        $lng = $obj2[0]["geometry"]["location"]["lng"];

        $encoded_array[] = array("description" => $urlEncoded, "lat" => $lat, "lng" => $lng);

        echo json_encode($encoded_array);

//         print_r($obj2);
    }

}
?>