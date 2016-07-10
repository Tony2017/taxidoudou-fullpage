$(document).ready(function() {
		$('#fullpage').fullpage({
				anchors: ['premierePage', 'deuxiemePage', 'troisiemePage'], //anchor names for the menu
				sectionsColor: ['#1E1E1E', 'white', '#E9534B'], //bgcolor of the section
				navigation: false,
				navigationPosition: 'right',
				navigationTooltips: ['Première page', 'Deuxième page', 'Troisième page'], //hover text of the menu
				onLeave: function(index, nextIndex, direction){
					if(nextIndex == 3){
						$('nav').addClass('deactivated');
					}else{
						$('nav').removeClass('deactivated');
					}
		        },
		        afterLoad: function(anchorLink, index){
		        	if(index != 3){
		        		$('nav').removeClass('deactivated');
		        	}
		        }
		});
});