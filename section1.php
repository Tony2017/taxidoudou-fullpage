<div class="section" id="section1">

<div id="position-windows">
	<div id="position-windows-subnav">
		<div class="container">
			<div class="row">
				<div class="form-group col-md-7 col-sm-12 col-xs-12">
					<label class="sr-only">Où êtes-vous ?</label>
					<div class="input-group col-md-12 col-sm-12 col-xs-12">
						<input type="text" class="form-control" id="position-windows-input" placeholder="Où êtes-vous ?">
						<div class="input-group-addon addon">
							<a href="#" id="showmap_to2"><span class="flaticon-location-pin"></span></a>
						</div>
					</div>
				</div>
				<div class="col-md-2 col-sm-12 col-xs-12 position-windows-search">Localiser</div>
				<div id="position-windows-exit" class="col-md-1 col-sm-12 col-xs-12"></div>
			</div>
		</div>
	</div>
	<div id="map-map"></div>
	<div class="btn-localize">
		<a href="#" id="localizemenow">Me localiser</a>
	</div>
</div>
	<div id="subnav">
		<div class="container" style="height: 100%;">
			<div class="col-md-5 col-sm-5 col-xs-5" id="where_go">
				<div class="flaticon-location-pin flaticon"></div>
				<h4 class="subtitle">Choisissez l'endroit</h4>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3">
				<div class="flaticon-frontal-taxi-cab flaticon"></div><h4 class="subtitle">Choisissez le véhicule</h4>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3 subtitle">
				<div class="flaticon-travel flaticon"></div><h4 class="subtitle">Voyagez</h4>
			</div>

			<div class="col-md-3 col-sm-3 col-xs-3">
				<div class="flaticon-frontal-taxi-cab flaticon"></div><h4 class="subtitle">Simple et rapide</h4>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3 subtitle">
				<div class="flaticon-24-hour-service flaticon"></div><h4 class="subtitle">Service 24H/24</h4>
			</div>
			<div class="col-md-5 col-sm-5 col-xs-5" id="where_go">
				<div class="flaticon-sale flaticon"></div>
				<h4 class="subtitle">Tarifs spéciaux</h4>
			</div>
			
		</div>
	</div>
	<div class="col-md-12 titles-container">
		<div class="container">
			<h1>Taxi Doudou</h1>
			<div class="postiion-container">
				<h3 class="col-md-12 no-padding">Choisissez votre destination</h3>
				<div class="form-bg col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="form-group col-md-4 col-sm-12 col-xs-12">
							<label class="sr-only" for="exampleInputAmount">Où voulez-vous aller ?</label>
							<div class="input-group col-md-12 col-sm-12 col-xs-12" id="input_position">
								<input type="text" class="form-control" id="position" placeholder="Où voulez-vous aller ?">
								<div class="input-group-addon addon">
									<a href="#" id="showmap_to"><span class="flaticon-location-pin"></span></a>
								</div>
							</div>
					  	</div>
						<div class="form-group col-md-3 col-sm-12 col-xs-12">
							<label class="sr-only" for="exampleInputAmount">Où êtes-vous ?</label>
							<div class="input-group col-md-12 col-sm-12 col-xs-12" id="input_localizeme">
								<input type="text" class="form-control" id="localizeme" placeholder="Où êtes-vous ?">
								<div class="input-group-addon addon">
									<a href="#" id="showmap_from"><span class="flaticon-location-pin"></span></a>
								</div>
							</div>
						</div>
					  <div class="form-group col-md-3 col-sm-12 col-xs-12">
					    <label class="sr-only" for="exampleInputAmount">Véhicules</label>
						<div class="input-group col-md-12 col-sm-12 col-xs-12" id="input_vehicles">
							<button type="text" class="form-control" id="vehicles" type="button">
							<span class="text">Véhicules</span>
							<div class="addon" style="float: right">
								<span class="flaticon-minibus"></span>
							</div>
							</button>
						</div>
					  </div>
					  <div class="search-button col-md-2">
					  	<button class="btn btn-go" type="button" disabled>Calculer le prix</button>
					  </div>
					</div>
				</div>
			</div>
		</div>	
	</div>
	<div class="col-md-12 bottom-box">
		<div class="container">
			<div class="call-container">
					<h3 class="no-padding" style="display: inline-block; margin-right: 3vh;">Ou appelez-nous au</h3>
					<a class="center" href="tel:+41798462984">079 846 29 84</a>
			</div>
		</div>
	</div>
	<ul class="popup-vehicles deactivated">
			<li class="title">Véhicules <span class="flaticon-close-cross" id="exit_menu"></span></li>
			<li class="pop-text" id="minibus_vehicle"><span class="flaticon-minibus"></span>TaxiBus (15 places)</li>
			<li class="pop-text" id="taxi_vehicle"><span class="flaticon-frontal-taxi-cab"></span>TaxiTouran (7 places)</li>
		<li class="pop-text" id="taxi_vehicle"><span class="flaticon-frontal-taxi-cab"></span>TaxiMercedes (5 places)</li>
	</ul>

	<ul class="popup-position deactivated">
	</ul>

</div>