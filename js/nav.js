$(document).ready(function() {
			$('#fullpage').fullpage({
				anchors: ['firstPage', 'secondPage', '3rdPage'], //anchor names for the menu
				sectionsColor: ['#1E1E1E', '#c0392b', '#1E1E1E'], //bgcolor of the section
				navigation: true,
				navigationPosition: 'right',
				navigationTooltips: ['First page', 'Second page', 'Third and last page'] //hover text of the menu
			});
		});