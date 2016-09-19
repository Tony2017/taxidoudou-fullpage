<?php session_start();
require('Classes.php');

/* Normally this should not happen because 'race' is declared in index.php
This can happen only with direct access to the query page */
if (!isset($_SESSION['race'])) return;

$race = unserialize($_SESSION['race']);

$start_latlng = $race->getStartAddress();
$end_latlng = $race->getEndAddress();
?>
<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<body>
<section id="fullpage">
    <div class="section" id="section1">
        <div class="col-md-offset-1 col-md-11 titles-container">
            <div class="container">
                <div class="map-infos">
                    <span class="flaticon-gps flaticon" id="map" style="opacity: 0.7"></span>
                    <div class="map-location">
                        <div class="pos-text"><p>De</p></div>
                        <div class="map-from pos-line"><input type="text" name="from"
                                                              value="<?php echo $start_latlng["start_formatted_address"] ?>"
                                                              readonly></div>
                        <div class="pos-text"><p>A</p></div>
                        <div class="map-to pos-line"><input type="text" name="to"
                                                            value="<?php echo $end_latlng["end_formatted_address"] ?>"
                                                            readonly></div>
                        <div class="pos-text"><p>Km</p></div>
                        <div class="map-to pos-line"><input type="text" name="to" id="km"
                                                            value="<?php echo $race->getDistanceKm() ?>" readonly></div>
                        <div class="pos-text"><p>Prix</p></div>
                        <div class="map-to pos-line"><input type="text" name="to"
                                                            value="<?php echo $race->getPriceCourse(); ?>" readonly>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-12 bottom-box">
                <div class="container">
                    <div class="call-container">
                        <h3 class="no-padding" style="display: inline-block; margin-right: 3vh;">
                            Pour continuer, appelez-nous au</h3>
                        <a class="center" href="tel:+41798462984">079 846 29 84</a>
                    </div>
                </div>
            </div>
        </div>
</section>
<script>
    function initMap() {
        var styles = [{
            "featureType": "administrative",
            "elementType": "labels.text.fill",
            "stylers": [{"color": "#444444"}]
        }, {"featureType": "landscape", "elementType": "all", "stylers": [{"color": "#f2f2f2"}]}, {
            "featureType": "poi",
            "elementType": "all",
            "stylers": [{"visibility": "off"}]
        }, {
            "featureType": "poi.business",
            "elementType": "geometry.fill",
            "stylers": [{"visibility": "on"}]
        }, {
            "featureType": "road",
            "elementType": "all",
            "stylers": [{"saturation": -100}, {"lightness": 45}]
        }, {
            "featureType": "road.highway",
            "elementType": "all",
            "stylers": [{"visibility": "simplified"}]
        }, {
            "featureType": "road.arterial",
            "elementType": "labels.icon",
            "stylers": [{"visibility": "off"}]
        }, {
            "featureType": "transit",
            "elementType": "all",
            "stylers": [{"visibility": "off"}]
        }, {"featureType": "water", "elementType": "all", "stylers": [{"color": "#b4d4e1"}, {"visibility": "on"}]}];

        var styledMap = new google.maps.StyledMapType(styles, {name: "TaxiDoudou Map"});

        var directionsDisplay = new google.maps.DirectionsRenderer;
        var directionsService = new google.maps.DirectionsService;
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: {lat: 37.77, lng: -122.447},
            disableDefaultUI: true
        });

        map.mapTypes.set('map_style', styledMap);
        map.setMapTypeId('map_style');
        directionsDisplay.setMap(map);

        directionsDisplay.addListener('directions_changed', function () {
            computeTotalDistance(directionsDisplay.getDirections());
        });


        calculateAndDisplayRoute(directionsService, directionsDisplay);

    }

    function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        directionsService.route({
            origin: {lat: <?php echo $start_latlng["lat"] ?>, lng: <?php echo $start_latlng["lng"] ?>},  // Haight.
            destination: {lat: <?php echo $end_latlng["lat"] ?>, lng: <?php echo $end_latlng["lng"] ?>},  // Ocean Beach.

            travelMode: google.maps.TravelMode.DRIVING
        }, function (response, status) {
            console.log(response);
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    }

    function computeTotalDistance(result) {
        var total = 0;
        var myroute = result.routes[0];
        for (var i = 0; i < myroute.legs.length; i++) {
            total += myroute.legs[i].distance.value;
        }
        total = total / 1000;
        console.log(total);
        document.getElementById('km').value = total.toFixed(1) + ' km';
    }
</script>
</body>
</html>