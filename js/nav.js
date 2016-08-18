$(document).ready(function() {
		$('#fullpage').fullpage({
				anchors: ['premierePage', 'deuxiemePage', 'troisiemePage', 'quatriemePage'], //anchor names for the menu
				sectionsColor: ['#1E1E1E', 'white', 'white', '#E9534B'], //bgcolor of the section
				navigation: false,
				navigationPosition: 'right',
				navigationTooltips: ['Première page', 'Deuxième page', 'Troisième page', 'Quatrième page'], //hover text of the menu
				afterRender: function () {
			        //Start the whole shabang when DOM and APIs are ready by calling initialize()
			        initMap();
			    },
				onLeave: function(index, nextIndex, direction){
					$( ".nav.navbar-nav > li.active" ).removeClass('active');
					$( ".nav.navbar-nav > li" ).eq( nextIndex ).addClass('active');

					if(nextIndex == 4){
						$('nav').addClass('deactivated');
					}else{
						$('nav').removeClass('deactivated');
					}
		        },
		        afterLoad: function(anchorLink, index){
		        	if(index != 4){
		        		$('nav').removeClass('deactivated');
		        	}
		        }
		});
});