<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<body>
<header>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">

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
                    <li><img src="css/img/phone.png" alt="Phone" height="30px" class="top-right-navbar-phone"><a
                            href="#" style="display: inline-block;"></img>079 846 29 84</a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li class="active hidden-sm"><a href="#premierePage">Accueil</a></li>
                    <li><a href="#deuxiemePage">Prestations</a></li>
                    <li><a href="#troisiemePage">Nos véhicules</a></li>
                    <li><a href="#quatriemePage">Nous contacter</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right hidden-sm">
                    <li><a href="#" style="display: inline-block; padding: 0px; padding-top: 20px;"
                           class="facebook-top-right-container"><img src="css/img/facebook-navbar.png" height="30px"
                                                                     alt="Facebook" class="facebook-top-right"/></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<section id="fullpage">
    <?php include("section1.php"); ?>
    <?php include("section2.php"); ?>
    <?php include("section3.php"); ?>
    <?php include("section4.php"); ?>
</section>

<script>
    var map;
    var marker;
    jQuery(document).ready(function () {


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

            marker = new google.maps.Marker({
                position: pos,
                map: map,
                title: '',
                draggable: true
            });
        }

        function erreurPosition(error) {
            var info = "Erreur lors de la géolocalisation : ";
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
                // Pas de support, proposer une alternative ?
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
            $(".popup-position").removeClass("fadeIn animated");
            $(".popup-position").removeClass("fadeOut animated");
            var position_left = $("#position").offset().left;
            var position_top = $("#input_position").offset().top + $("#position").height();
            var position_width = $("#input_position").width();
            $(".popup-position").css({"left": position_left, "top": position_top, "width": position_width});

            if ($(".popup-position").has("li").length)
                $(".popup-position").removeClass("deactivated");
        });

        $("#taxi_vehicle").click(function () {
            $("#vehicles span[class='text']").text("Taxi (7 places)");
            $(".popup-vehicles").addClass("deactivated");
            $(".popup-vehicles").removeClass("fadeOut animated");
        });

        $("#minibus_vehicle").click(function () {
            $("#vehicles span[class='text']").text("Minibus (15 places)");
            $(".popup-vehicles").addClass("deactivated");
            $(".popup-vehicles").removeClass("fadeOut animated");
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
            $("#position").val($(this).text());
            $(".popup-position").addClass("deactivated");

            var pos = {lat: $(this).data('lat'), lng: $(this).data('lng')};
            map.setCenter({
                lat: $(this).data('lat'),
                lng: $(this).data('lng')
            });

            map.setZoom(16);

            marker = new google.maps.Marker({
                position: pos,
                map: map,
                title: '',
                draggable: true
            });

        });


        /*$('#section1').fadeTo('slow', 0.3, function()
         {

         }).delay(1000).fadeTo('slow', 1);*/


        $("#position").keyup(function () {
            var text = $(this).val();
            delay(function () {
                var m_data;
                $.getJSON("query.php?text=" + text, function (data) {
                    m_data = data;
                })
                    .done(function () {
                        $(".popup-position").empty();
                        var obj = m_data;
                        for (var i in obj) {
                            $(".popup-position").append("<li class=\"pop-text\" data-lat=\"" + obj[i].lat + "\" data-lng=\"" + obj[i].lng + "\"><span class=\"flaticon-location-pin\"></span>" + obj[i].description + "</li>");
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
            var text = $(this).val();
            delay(function () {
                var m_data;
                $.getJSON("query.php?text=" + text, function (data) {
                    m_data = data;
                })
                    .done(function () {
                        $(".popup-position").empty();
                        var obj = m_data;
                        for (var i in obj) {
                            $(".popup-position").append("<li class=\"pop-text\" data-lat=\"" + obj[i].lat + "\" data-lng=\"" + obj[i].lng + "\"><span class=\"flaticon-location-pin\"></span>" + obj[i].description + "</li>");
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

    });




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

        var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});

        map = new google.maps.Map(document.getElementById('map-map'), {
            zoom: 8,
            center: new google.maps.LatLng(46.7622711, 6.4146287),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });


        //Associate the styled map with the MapTypeId and set it to display.
        map.mapTypes.set('map_style', styledMap);
        map.setMapTypeId('map_style');

    }


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

    $('#showmap_from').on('click', function () {
        $('#position-windows').css({"visibility": "visible"});

        $('#position-windows-input').attr("placeholder", "Où êtes-vous actuellement ?");
        if ($('#position').val()) {
            $('#position-windows-input').val($('#position').val());
        }

        $('#position-windows').css({"visibility": "visible"});
        $('.btn-localize').css({"visibility": "visible"});
    });

    $('#showmap_to').on('click', function () {
        $('#position-windows-input').attr("placeholder", "Où voulez-vous aller ?");
        if ($('#position').val()) {
            $('#position-windows-input').val($('#position').val());
        }
        $('#position-windows').css({"visibility": "visible"});
        $('.btn-localize').css({"visibility": "hidden"});
    });

    function addEntries(data) {
    }


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

</script>


</body>
</html>