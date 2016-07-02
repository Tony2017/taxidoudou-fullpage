<div class="section" id="section1">
	<div id="subnav">
		<div class="container">
			<div class="col-md-3">
				<div class="flaticon-frontal-taxi-cab flaticon"></div><h4 class="subtitle">Simple et rapide</h4>
			</div>
			<div class="col-md-5" id="where_go">
				<div class="flaticon-location-pin flaticon"></div>
				<h4 class="subtitle">Dans toute la suisse</h4>
			</div>
			<div class="col-md-3 subtitle">
				<div class="flaticon-24-hour-service flaticon"></div><h4 class="subtitle">Service 24H/24</h4>
			</div>
		</div>
	</div>




	<div class="col-md-offset-1 col-md-11 titles-container">
		<div class="container">
			<h1>Taxi Doudou</h1>
			<h3>Choisissez votre destination</h3>
			<div class="form-inline form-bg col-md-11">
				<div class="row">
				  <div class="form-group col-md-7" style="padding-right: 0px;">
				    <label class="sr-only" for="exampleInputAmount">Endroit où vous voulez aller</label>
					<div class="input-group col-md-12" id="input_position">
						<input type="text" class="form-control" id="position" placeholder="Où voulez-vous aller ?">
						<div class="input-group-addon addon">
							<span class="flaticon-location-pin"></span>
						</div>
					</div>
				  </div>

				  <div class="form-group col-md-4" style="padding-right: 0px;">

				    <label class="sr-only" for="exampleInputAmount">Véhicule à utiliser</label>
					<div class="input-group col-md-12" id="input_vehicles">
						
						<button type="text" class="form-control" id="vehicles" type="button">
						<span class="text">Véhicule à utiliser</span>
						<div class="addon" style="float: right">
							<span class="flaticon-minibus"></span>
						</div>
						</button>
					</div>
				  </div>
				  <div class="search-button col-md-1">
				  	<button class="btn btn-go" type="button">Go</button>
				  </div>
				</div>
			</div>
		</div>	
	</div>
	<ul class="popup-vehicles deactivated">
			<li class="title">Véhicules <span class="flaticon-close-cross" id="exit_menu"></span></li>
			<li class="pop-text" id="minibus_vehicle"><span class="flaticon-minibus"></span>Minibus (1 à 15 personnes)</li>
			<li class="pop-text" id="taxi_vehicle"><span class="flaticon-frontal-taxi-cab"></span>Taxi (1 à 4 personnes)</li>
	</ul>

	<ul class="popup-position deactivated">
	</ul>

</div>