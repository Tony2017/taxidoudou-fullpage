$(document).ready(function () {
    $('#fullpage').fullpage({
        anchors: ['Accueil', 'Prestations', 'Vehicules', 'Contact'], //anchor names for the menu
        navigation: false,
        navigationPosition: 'right',
        normalScrollElements: '#map-map',
        afterRender: function () {
            //Start the whole shabang when DOM and APIs are ready by calling initialize()
            initMap();
        },
        onLeave: function (index, nextIndex, direction) {
            $(".nav.navbar-nav > li.active").removeClass('active');
            $(".nav.navbar-nav > li").eq(nextIndex).addClass('active');

            if (nextIndex == 5) {
                $('nav').addClass('deactivated');
            } else {
                $('nav').removeClass('deactivated');
            }
        },
        afterLoad: function (anchorLink, index) {
            if (index != 4) {
                $('nav').removeClass('deactivated');
            }
        }
    });
});