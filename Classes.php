<?php

class User
{
    private $_ip;
    private $_language;

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->_ip = $ip;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->_language = $language;
    }
}

class Race
{
    private $_start_address;
    private $_end_address;
    private $_vehicle;
    private $_distance_km;
    private $_price_course;

    /**
     * @return mixed
     */
    public function getAreAllParametersSet()
    {
        return ($this->_start_address && $this->_end_address && $this->_vehicle);
    }

    /**
     * @param mixed $start_address
     */
    public function setStartAddress($start_address)
    {
        $this->_start_address = $start_address;
    }

    /**
     * @return mixed
     */
    public function getStartAddress()
    {
        return $this->_start_address;
    }

    /**
     * @param mixed $end_address
     */
    public function setEndAddress($end_address)
    {
        $this->_end_address = $end_address;
    }

    /**
     * @return mixed
     */
    public function getEndAddress()
    {
        return $this->_end_address;
    }

    /**
     * @param mixed $vehicle
     */
    public function setVehicle($vehicle)
    {
        $this->_vehicle = $vehicle;
    }

    /**
     * @return mixed
     */
    public function getVehicle()
    {
        return $this->_vehicle;
    }

    /**
     * @return mixed
     */
    public function getTextVehicle()
    {
        $array = Array("TaxiBus (15 places)", "TaxiTouran (7 places)", "TaxiMercedes (5 places)");
        if ($this->_vehicle != null)
            return $array[(int)$this->_vehicle - 1];
        else
            return "Véhicules";
    }

    /**
     * @param mixed $distance_km
     */
    public function setDistanceKm($distance_km)
    {
        $this->_distance_km = $distance_km;
    }

    /**
     * @return mixed
     */
    public function getDistanceKm()
    {
        return $this->_distance_km;
    }


    /**
     * @param mixed $price_course
     */
    public function setPriceCourse($price_course)
    {
        $this->_price_course = $price_course;
    }

    /**
     * @return mixed
     */
    public function getPriceCourse()
    {
        return $this->_price_course;
    }
}

class MapRequest
{
    private $_link;
    private $_obj;
    private $_json;

    /**
     * @param $place
     * @return arrayg
     * Return a list of places resembling to the $place parameter
     */
    public function getPlaces($place)
    {
        $this->_link = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?input=' . $place . '&components=country:ch&location=0,0&radius=&location=0,0&radius=20000000&types=geocode&language=fr&key=AIzaSyDjYfntYI75cqHJlntIO6w8uZKQooRnaIQ';

        $this->_json = $this->getRequestResponse($this->_link);

        $this->_obj = json_decode($this->_json, true)["predictions"];

        $numb_of_arrays = count($this->_obj);

        if ($numb_of_arrays == 0) return;

        for ($i = 0; $i < $numb_of_arrays; $i++) {
            $lat = -1;
            $lng = -1;
            $encoded_array[] = array("description" => $this->_obj[$i]['description'], "lat" => $lat, "lng" => $lng, "place_id" => $this->_obj[$i]['place_id']);

        }

        return $encoded_array;
    }


    /**
     * @param $place_id
     * @return array
     * Return details for a place known as $place_id
     * @see $this->getPlaces()
     */
    public function getDetails($place_id)
    {
        $this->_link = 'https://maps.googleapis.com/maps/api/place/details/json?placeid=' . $place_id . '&language=fr&key=AIzaSyDjYfntYI75cqHJlntIO6w8uZKQooRnaIQ';
        $this->_json = $this->getRequestResponse($this->_link);
        $this->_obj = json_decode($this->_json, true)["result"];

        $lat = $this->_obj["geometry"]["location"]["lat"];
        $lng = $this->_obj["geometry"]["location"]["lng"];

        $encoded_array[] = array("lat" => $lat, "lng" => $lng, "formatted_address" => $this->_obj["formatted_address"], "name" => $this->_obj["name"]);

        return $encoded_array;
    }

    /**
     * @param $latlng
     * @return array
     * Return address from latitude and longitude points
     */
    public function getGeocoding($latlng)
    {
        $this->_link = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $latlng . '&language=fr&key=AIzaSyDjYfntYI75cqHJlntIO6w8uZKQooRnaIQ';
        $this->_json = $this->getRequestResponse($this->_link);

        $this->_obj = json_decode($this->_json, true)["results"];

        $encoded_array[] = array("formatted_address" => $this->_obj[0]["formatted_address"], "place_id" => $this->_obj[0]["place_id"]);

        return $encoded_array;
    }

    /**
     * @param $url
     * @return string
     * Return GET response for $url request
     */
    public function getRequestResponse($url)
    {
        return file_get_contents($url);
    }
}

?>