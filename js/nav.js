$(document).ready(function() {
			$('#fullpage').fullpage({
				anchors: ['premierePage', 'deuxiemePage', 'troisiemePage'], //anchor names for the menu
				sectionsColor: ['#1E1E1E', 'white', '#1E1E1E'], //bgcolor of the section
				navigation: false,
				navigationPosition: 'right',
				navigationTooltips: ['Première page', 'Deuxième page', 'Troisième page'] //hover text of the menu
			});
		});