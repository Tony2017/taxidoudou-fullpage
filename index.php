<?php session_start();
require('Classes.php');
if (!isset($_SESSION['user'])) {
    $user = new User();
    $_SESSION['user'] = serialize($user);
}
if (!isset($_SESSION['race'])) {
    $race = new Race();
    $_SESSION['race'] = serialize($race);
}


?>
<!DOCTYPE html>
<html lang="fr">
<?php include("head.php"); ?>

<body>
<header>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <ul class="facebook-topleft hidden-md hidden-lg hidden-sm">
                    <li><a href="#" style="display: inline-block; padding: 0px; padding-top: 20px;"
                           class="facebook-top-right-container"><img src="css/img/facebook-navbar.png" height="30"
                                                                     alt="Facebook" class="facebook-top-right"/></a>
                    </li>
                </ul>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--<a class="navbar-brand" href="#">
                  <img src="css/img/TaxiDoudou.png" alt="TaxiDoudou" style="margin-top: -7px; max-width:100px;" />
                </a> -->
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li><img src="css/img/phone.png" alt="Phone" height="30" class="top-right-navbar-phone"/><a
                            href="#" style="display: inline-block;">079 846 29 84</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li class="active hidden-sm"><a href="#Accueil">Accueil</a></li>
                    <li><a href="#Prestations">Prestations</a></li>
                    <li><a href="#Vehicules">Nos véhicules</a></li>
                    <li><a href="#Contact">Nous contacter</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right hidden-sm">
                    <li><a href="#" style="display: inline-block; padding: 0px; padding-top: 20px;"
                           class="facebook-top-right-container hidden-xs"><img src="css/img/facebook-navbar.png"
                                                                               height="30"
                                                                               alt="Facebook"
                                                                               class="facebook-top-right"/></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Localisation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <p>Veuillez activer la localisation sur votre téléphone avant de continuer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<section id="fullpage">
    <?php include("section1.php"); ?>
    <?php include("section2bis.php"); ?>
    <?php include("section3.php"); ?>
    <?php include("section5.php"); ?>
</section>

<script>
    var map, mapLocal;
    var lastWrittingInputDiv;
    jQuery(document).ready(function () {
        // On affiche une fenêtre poussant l'utilisateur a activer sa géolocalisation

        var marker = new google.maps.Marker({
            position: {lat: 0, lng: 0},
            map: map,
            title: ''
        });

        function maPosition(position) {
            var infopos = "Position déterminée :\n";
            infopos += "Latitude : " + position.coords.latitude + "\n";
            infopos += "Longitude: " + position.coords.longitude + "\n";
            infopos += "Altitude : " + position.coords.altitude + "\n";
            console.log(infopos);
            map.setCenter({
                lat: position.coords.latitude,
                lng: position.coords.longitude
            });

            map.setZoom(14);
            var pos = {lat: position.coords.latitude, lng: position.coords.longitude};
            marker.setMap(null);
            marker = new google.maps.Marker({
                position: pos,
                map: map,
                title: ''
            });

            $.getJSON("query.php?type=geocoding&latlng=" + pos.lat + ',' + pos.lng, function (data) {
                m_posName = data;
            })
                .done(function () {
                    var obj = m_posName;

                    $('#position-windows-input').val(obj[0].formatted_address);
                    $('#localizeme').val(obj[0].formatted_address);
                    $.getJSON("query.php?type=address&place_id=" + obj[0].place_id + "&start_or_end=start", function (data) {
                        m_posData = data;
                    }).done(function () {
                    }).fail(function () {
                    });
                })
                .fail(function () {

                });
        }

        function erreurPosition(error) {
            var info = "Erreur lors de la géolocalisation : ";
            $('#myModal').modal();
            switch (error.code) {
                case error.TIMEOUT:
                    info += "Timeout !";
                    break;
                case error.PERMISSION_DENIED:
                    info += "Vous n’avez pas donné la permission";
                    break;
                case error.POSITION_UNAVAILABLE:
                    info += "La position n’a pu être déterminée";
                    break;
                case error.UNKNOWN_ERROR:
                    info += "Erreur inconnue";
                    break;
            }
        }

        $('#localizemenow, .btn-localize').on('click', function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(maPosition, erreurPosition, {enableHighAccuracy: true});

            } else {
                $('#myModal').modal();
            }
        });


        var delay = (function () {
            var timer = 0;
            return function (callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();

        $('#subnav .container').slick({
            dots: false,
            arrows: false,
            slidesToShow: 3,
            slidesToScroll: 3,
            autoplay: true,
            autoplaySpeed: 6000,
        });

        $("#vehicles").click(function () {
            var vehicles_left = $("#vehicles").offset().left;
            /*var vehicles_top  = $(".form-bg").offset().top - $(".popup-vehicles").height();*/
            var vehicles_top = $("#vehicles").offset().top;
            var vehicles_width = $("#input_vehicles").width();
            $(".popup-vehicles").css({"left": vehicles_left, "top": vehicles_top, "width": vehicles_width});
            $(".popup-vehicles").removeClass("deactivated");

        });

        $("#position").click(function () {
            if (lastWrittingInputDiv != "#position") {
                return;
            }
            lastWrittingInputDiv = "#position";
            $(".popup-position").removeClass("fadeIn animated");
            $(".popup-position").removeClass("fadeOut animated");
            var position_left = $("#position").offset().left;
            var position_top = $("#input_position").offset().top + $("#position").height();
            var position_width = $("#input_position").width();
            $(".popup-position").css({"left": position_left, "top": position_top, "width": position_width});

            if ($(".popup-position").has("li").length)
                $(".popup-position").removeClass("deactivated");
        });

        $("#localizeme").click(function () {
            if (lastWrittingInputDiv != "#localizeme") {
                return;
            }
            lastWrittingInputDiv = "#localizeme";
            $(".popup-position").removeClass("fadeIn animated");
            $(".popup-position").removeClass("fadeOut animated");
            var position_left = $("#localizeme").offset().left;
            var position_top = $("#input_localizeme").offset().top + $("#localizeme").height();
            var position_width = $("#input_localizeme").width();
            $(".popup-position").css({"left": position_left, "top": position_top, "width": position_width});

            if ($(".popup-position").has("li").length)
                $(".popup-position").removeClass("deactivated");
        });

        $("#taxi_vehicle").click(function () {
            $("#vehicles span[class='text']").text("Taxi (7 places)");
            $(".popup-vehicles").addClass("deactivated");
            $(".popup-vehicles").removeClass("fadeOut animated");
            $.getJSON("query.php?type=vehicle&vehicle_ref=2", function (data) {
                m_posData = data;
            }).done(function () {
            }).fail(function () {
            });
        });

        $("#minibus_vehicle").click(function () {
            $("#vehicles span[class='text']").text("Taxibus (15 places)");
            $(".popup-vehicles").addClass("deactivated");
            $(".popup-vehicles").removeClass("fadeOut animated");
            $.getJSON("query.php?type=vehicle&vehicle_ref=1", function (data) {
                m_posData = data;
            }).done(function () {
            }).fail(function () {
            });
        });

        $("#taxi_mercedes").click(function () {
            $("#vehicles span[class='text']").text("Taxi (5 places)");
            $(".popup-vehicles").addClass("deactivated");
            $(".popup-vehicles").removeClass("fadeOut animated");
            $.getJSON("query.php?type=vehicle&vehicle_ref=3", function (data) {
                m_posData = data;
            }).done(function () {
            }).fail(function () {
            });
        });


        $(document).mouseup(function (e) {
            var container = $("#vehicle, .popup-vehicles, #position, .popup-position");

            if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
            {
                $(".popup-vehicles").addClass("deactivated");
                $(".popup-position").addClass("deactivated");

            }

        });

        $("#exit_menu").click(function () {
            $(".popup-vehicles").addClass("deactivated");
        });


        $(".popup-position").on("click", "li", function (event) {
            $(lastWrittingInputDiv).val($(this).text());
            if (lastWrittingInputDiv == "#position-windows-input" && $('#position-windows-input').attr("placeholder") == "Où voulez-vous aller ?") {
                $('#position').val($(this).text());
            } else if (lastWrittingInputDiv == "#position-windows-input" && $('#position-windows-input').attr("placeholder") == "Où êtes-vous actuellement ?") {
                $('#localizeme').val($(this).text());
            }
            $(".popup-position").addClass("deactivated");

            loadingAnimation(lastWrittingInputDiv);
            var m_posData;
            var place_id = $(this).data("placeid");
            var m_posName;
            var start_or_end;
            if ((lastWrittingInputDiv == "#position") || (lastWrittingInputDiv == "#position-windows-input" && $('#position-windows-input').attr("placeholder") == "Où voulez-vous aller ?")) {
                start_or_end = "end";
            } else if ((lastWrittingInputDiv == "#localizeme") || (lastWrittingInputDiv == "#position-windows-input" && $('#position-windows-input').attr("placeholder") == "Où êtes-vous actuellement ?")) {
                start_or_end = "start";
            }

            $.getJSON("query.php?type=address&place_id=" + place_id + "&start_or_end=" + start_or_end, function (data) {
                m_posData = data;
            }).done(function () {
            }).fail(function () {
            });
            $.getJSON("query.php?type=details&place_id=" + place_id, function (data) {
                m_posData = data;
            })
                .done(function () {
                    var obj = m_posData;

                    var pos = {lat: obj[0].lat, lng: obj[0].lng};
                    map.setCenter({
                        lat: obj[0].lat,
                        lng: obj[0].lng
                    });

                    map.setZoom(16);

                    marker.setMap(null);
                    marker = new google.maps.Marker({
                        position: pos,
                        map: map,
                        title: ''
                    });
                    if (lastWrittingInputDiv == "#position") {
                        $("#input_position > .input-group-addon.addon > .spinner").remove();
                        $("#input_position > .input-group-addon.addon > #showmap_to").css({"visibility": "visible"});
                    } else if (lastWrittingInputDiv == "#localizeme") {
                        $("#input_localizeme > .input-group-addon.addon > .spinner").remove();
                        $("#input_localizeme > .input-group-addon.addon > #showmap_from").css({"visibility": "visible"});
                    }

                })
                .fail(function () {

                });
        });


        /*$('#section1').fadeTo('slow', 0.3, function()
         {

         }).delay(1000).fadeTo('slow', 1);*/


        $("#position").keyup(function () {
            lastWrittingInputDiv = "#position";
            var text = $(this).val();
            delay(function () {
                var m_data;
                $.getJSON("query.php?type=place&text=" + text, function (data) {
                    m_data = data;
                })
                    .done(function () {
                        $(".popup-position").empty();
                        var obj = m_data;
                        for (var i in obj) {
                            $(".popup-position").append("<li class=\"pop-text\" data-placeId=\"" + obj[i].place_id + "\" data-lat=\"" + obj[i].lat + "\" data-lng=\"" + obj[i].lng + "\"><span class=\"flaticon-location-pin\"></span>" + obj[i].description + "</li>");
                        }
                        var position_left = $("#position").offset().left;
                        var position_top = $("#input_position").offset().top + $("#input_position").height() + 1;
                        var position_width = $("#input_position").width();
                        $(".popup-position").css({"left": position_left, "top": position_top, "width": position_width});
                        $(".popup-position").removeClass("deactivated");
                        $(".popup-position").removeClass("fadeOut animated");
                        $(".popup-position").addClass("fadeIn animated");

                    })
                    .fail(function () {
                        $(".popup-position").empty();
                        $(".popup-position").removeClass("fadeIn animated");

                    });
            }, 300);
        });

        $("#localizeme").keyup(function () {
            lastWrittingInputDiv = "#localizeme";
            var text = $(this).val();
            delay(function () {
                var m_data;
                $.getJSON("query.php?type=place&text=" + text, function (data) {
                    m_data = data;
                })
                    .done(function () {
                        $(".popup-position").empty();
                        var obj = m_data;
                        for (var i in obj) {
                            $(".popup-position").append("<li class=\"pop-text\" data-placeId=\"" + obj[i].place_id + "\"  data-lat=\"" + obj[i].lat + "\" data-lng=\"" + obj[i].lng + "\"><span class=\"flaticon-location-pin\"></span>" + obj[i].description + "</li>");
                        }
                        var position_left = $("#localizeme").offset().left;
                        var position_top = $("#input_localizeme").offset().top + $("#input_localizeme").height() + 1;
                        var position_width = $("#input_localizeme").width();
                        $(".popup-position").css({"left": position_left, "top": position_top, "width": position_width});
                        $(".popup-position").removeClass("deactivated");
                        $(".popup-position").removeClass("fadeOut animated");
                        $(".popup-position").addClass("fadeIn animated");
                    })
                    .fail(function () {
                        $(".popup-position").empty();
                        $(".popup-position").removeClass("fadeIn animated");

                    });
            }, 300);
        });

        $("#position-windows-input").keyup(function () {
            lastWrittingInputDiv = "#position-windows-input";
            var text = $(this).val();
            delay(function () {
                var m_data;
                $.getJSON("query.php?type=place&text=" + text, function (data) {
                    m_data = data;
                })
                    .done(function () {
                        $(".popup-position").empty();
                        var obj = m_data;
                        for (var i in obj) {
                            $(".popup-position").append("<li class=\"pop-text\" data-placeId=\"" + obj[i].place_id + "\"  data-lat=\"" + obj[i].lat + "\" data-lng=\"" + obj[i].lng + "\"><span class=\"flaticon-location-pin\"></span>" + obj[i].description + "</li>");
                        }
                        var position_left = $("#position-windows-input").offset().left;
                        var position_top = $("#position-windows-subnav").offset().top + $("#position-windows-subnav").outerHeight(true) + 1;
                        var position_width = $("#position-windows-input").width();
                        $(".popup-position").css({
                            "left": position_left,
                            "top": position_top,
                            "width": position_width,
                            "z-index": 1200
                        });
                        $(".popup-position").removeClass("deactivated");
                        $(".popup-position").removeClass("fadeOut animated");
                        $(".popup-position").addClass("fadeIn animated");


                    })
                    .fail(function () {
                        $(".popup-position").empty();
                        $(".popup-position").removeClass("fadeIn animated");

                    });
            }, 300);
        });

        $('#navbar').on('hidden.bs.collapse', function () {
            console.log("Collapsed !");
        });

        $('#showmap_from').on('click', function () {
            lastWrittingInputDiv = "#showmap_from";
            $('#position-windows').css({"visibility": "visible"});

            $('#position-windows-input').attr("placeholder", "Où êtes-vous actuellement ?");
            if ($('#localizeme').val()) {
                $('#position-windows-input').val($('#localizeme').val());
            }

            if ($('#position-windows-input').val()) {
                if ($('#position-windows-input').val() != $('#localizeme').val()) {
                    $('#position-windows-input').val("");
                }
            }

            $('#position-windows').css({"visibility": "visible"});
            $('.btn-localize').css({"visibility": "visible"});
        });

        $('#showmap_to').on('click', function () {
            lastWrittingInputDiv = "#showmap_to";
            $('#position-windows-input').attr("placeholder", "Où voulez-vous aller ?");
            if ($('#position').val()) {
                $('#position-windows-input').val($('#position').val());
            }

            if ($('#position-windows-input').val()) {
                if ($('#position-windows-input').val() != $('#position').val()) {
                    $('#position-windows-input').val("");
                }
            }

            $('#position-windows').css({"visibility": "visible"});
            $('.btn-localize').css({"visibility": "hidden"});
        });

        $('#nom_prenom, #email, #message').on('input', function () {
            if ($('#nom_prenom').val() && $('#email').val() && $('#message').val()) {
                $('#envoyer').css({"visibility": "visible"});
            } else {
                $('#envoyer').css({"visibility": "hidden"});
            }
        });

        $('#position-windows-exit').on('click', function () {
            $('#position-windows').css({"visibility": "hidden"});
            $('.btn-localize').css({"visibility": "hidden"});
        });

        // Select all tabs
        $('.nav-tabs a').click(function () {
            $(this).tab('show');
        })

        // Select tab by name
        $('.nav-tabs a[href="#home"]').tab('show');

        // Select first tab
        $('.nav-tabs a:first').tab('show');

        // Select last tab
        $('.nav-tabs a:last').tab('show');

        // Select fourth tab (zero-based)
        $('.nav-tabs li:eq(3) a').tab('show');

    })
    ;


    function loadingAnimation(lastWrittingInputDiv) {
        if (lastWrittingInputDiv == "#position") {
            $("#input_position > .input-group-addon.addon > #showmap_to").css({"visibility": "hidden"});
            $("#input_position > .input-group-addon.addon").append("<div class=\"spinner\"></div>");
        } else if (lastWrittingInputDiv == "#localizeme") {
            $("#input_localizeme > .input-group-addon.addon > #showmap_from").css({"visibility": "hidden"});
            $("#input_localizeme > .input-group-addon.addon").append("<div class=\"spinner\"></div>");
        }
    }


    function initMap() {
        //Setup map

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

        map = new google.maps.Map(document.getElementById('map-map'), {
            zoom: 8,
            center: new google.maps.LatLng(46.7622711, 6.4146287),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        //Associate the styled map with the MapTypeId and set it to display.
        map.mapTypes.set('map_style', styledMap);
        map.setMapTypeId('map_style');

        mapLocal = new google.maps.Map(document.getElementById('map-local'), {
            zoom: 11,
            center: new google.maps.LatLng(46.7438815, 6.8156835),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var marker = new google.maps.Marker({
            position: {lat: 46.844846, lng: 6.84278},
            map: mapLocal,
            title: 'TaxiDoudou'
        });

        mapLocal.mapTypes.set('map_style2', styledMap);
        mapLocal.setMapTypeId('map_style2');
    }


    function addEntries(data) {
    }

</script>


</body>
</html>