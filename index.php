<!DOCTYPE html>
<html>
<?php include("head.php"); ?>
<body> 
<header>
	<nav class="navbar navbar-default navbar-fixed-top">
	  <div class="container">
	    <div class="navbar-header">
	      
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
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
	        <li><img src="css/img/phone.png" alt="Phone" height="30px" class="top-right-navbar-phone"><a href="#" style="display: inline-block;"></img>079 846 29 84</a></li>
	      </ul>
	      <ul class="nav navbar-nav">
	        <li class="active hidden-sm"><a href="#">Accueil</a></li>
	        <li><a href="#">Prestations</a></li>
	        <li><a href="#">Nous trouver</a></li>
	        <li><a href="#">Nous contacter</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right hidden-sm">
	        <li><a href="#" style="display: inline-block; padding: 0px; padding-top: 20px;" class="facebook-top-right-container"><img src="css/img/facebook-navbar.png" height="30px" alt="Facebook" class="facebook-top-right"  /></a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
</header>

    <section id="fullpage">  
        <?php include("section1.php"); ?> 
        <?php include("section2.php"); ?> 
        <?php include("section3.php"); ?> 
    </section>    

    <script>
    jQuery(document).ready(function(){
    	
        var delay = (function(){
          var timer = 0;
          return function(callback, ms){
            clearTimeout (timer);
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

    	$("#vehicles").click(function() {
    		var vehicles_left = $("#vehicles").offset().left;
    		/*var vehicles_top  = $(".form-bg").offset().top - $(".popup-vehicles").height();*/
            var vehicles_top  = $("#vehicles").offset().top ;
    		var vehicles_width = $("#input_vehicles").width();
    		$(".popup-vehicles").css({"left":vehicles_left, "top":vehicles_top, "width":vehicles_width});
    		$(".popup-vehicles").removeClass("deactivated");

    	});

    	$("#position").click(function() {
            $(".popup-position").removeClass("fadeIn animated");
            $(".popup-position").removeClass("fadeOut animated");
    		var position_left = $("#position").offset().left;
    		var position_top  = $("#input_position").offset().top + $("#position").height();
    		var position_width = $("#input_position").width();
    		$(".popup-position").css({"left":position_left, "top":position_top, "width":position_width});
    		
            if($(".popup-position").has("li").length)
                $(".popup-position").removeClass("deactivated");
    	});
    	
    	$("#taxi_vehicle").click(function() {
    		$("#vehicles span[class='text']").text("Taxi (1 à 4 places)");
    		$(".popup-vehicles").addClass("deactivated");
            $(".popup-vehicles").removeClass("fadeOut animated");
    	});

    	$("#minibus_vehicle").click(function() {
    		$("#vehicles span[class='text']").text("Minibus (1 à 15 places)");
            $(".popup-vehicles").addClass("deactivated");
            $(".popup-vehicles").removeClass("fadeOut animated");
    	});

    	$(document).mouseup(function (e)
		{
		    var container = $("#vehicle, .popup-vehicles, #position, .popup-position");

		    if (!container.is(e.target) // if the target of the click isn't the container...
		        && container.has(e.target).length === 0) // ... nor a descendant of the container
		    {
		        $(".popup-vehicles").addClass("deactivated");
                $(".popup-position").addClass("deactivated");

		    }

		});

		$("#exit_menu").click(function() {
			$(".popup-vehicles").addClass("deactivated");
		});


        $(".popup-position").on("click", "li", function(event){
            $("#position").val($(this).text());
            $(".popup-position").addClass("deactivated");
        });


        

        /*$('#section1').fadeTo('slow', 0.3, function()
        {
            
        }).delay(1000).fadeTo('slow', 1);*/


    	$("#position").keyup(function() {
    		var text = $(this).val();
    		delay(function(){
    			var m_data;
    			$.getJSON("query.php?text=" + text, function( data ) {
    				m_data = data;
				})
    			.done(function() {
    			$( ".popup-position").empty();
    			var obj = m_data;  			
    			for(var i in obj){
					$( ".popup-position").append("<li class=\"pop-text\"><span class=\"flaticon-location-pin\"></span>" + obj[i].description + "</li>");
				}
				var position_left = $("#position").offset().left;
                var position_top  = $("#input_position").offset().top + $("#input_position").height() + 1;
                var position_width = $("#input_position").width();
	    		$(".popup-position").css({"left":position_left, "top":position_top, "width":position_width});
	    		$(".popup-position").removeClass("deactivated");
                $(".popup-position").removeClass("fadeOut animated");
                $(".popup-position").addClass("fadeIn animated");
    			})
    			.fail(function(){
    				$( ".popup-position").empty();
                    $(".popup-position").removeClass("fadeIn animated");

    			});
    		}, 300 );
    	});
  	});
	
	function addEntries(data){
	}
	
    </script>
</body>
</html>