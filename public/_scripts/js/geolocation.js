// User's location and location of the CAPITOLE 
// WRITTEN BY STEFAAN CHRISTIAENS
//LAST MODIFIED DATE 19/06/12
//*************************************************
var Googlemap;

var currentMarker;

var locationCurrent;

var ghentlocation = new google.maps.LatLng(51.05866,3.763161);



function display(){
		 var myOptions = {
	    	zoom: 13,
	    	center: ghentlocation,
	   	 	mapTypeId: google.maps.MapTypeId.ROADMAP,
			mapTypeControl: false,
			zoomControl: true,
			navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL}
	  	}
		Googlemap = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                window.Googlemap = Googlemap;
		
		
}

//GET LOCATION OF USER THROUGH WIFI OR 3G
//FALLBACK FROM HTML5 GEOLOCATION GOOGLE AJAX API THROUGH MAXMIND'S GEOLOCATION API
function getGeolocation(){
		if(Modernizr.geolocation)
		{
			console.log('geolocation works');
			navigator.geolocation.getCurrentPosition(geoLocationSuccess, geoLocationError);
		}
		else
		{
			
			var geocoder = new google.maps.Geocoder()
			if(google.loader.ClientLocation != null)
			{
				locationCurrent = new google.maps.LatLng(google.loader.ClientLocation.latitude,google.loader.ClientLocation.longitude);
				displayMap();	
			}
			else{
				locationCurrent = new google.maps.LatLng(geoip_latitude(),geoip_longitude());
				displayMap();
			}

		}
}

function geoLocationSuccess(position){
	locationCurrent = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
	displayMap();
	
}

function geoLocationError(err){
	locationCurrent = ghentlocation;
	displayMap();
}

//DISPLAY GOOGLE MAP
function displayMap(){
	
	
		zoomin = 11;
	
	
	
	Googlemap.setZoom(zoomin);
	
	

	if(locationCurrent != ghentlocation)
	{
		currentMarker = new google.maps.Marker({
			position: locationCurrent, 
			map: Googlemap, 
			title:'Your current position'
		});
		currentMarker.setAnimation(google.maps.Animation.DROP);
		google.maps.event.addListener(currentMarker, 'click', function() {
				Googlemap.panTo(locationCurrent);
			});
		
	}
		
}

//function showMarker(marker){
//			switch(marker){
//				case 'capitole': Googlemap.panTo(ghentlocation);
//								if(!routeDisplay)
//								{$("#markers").append("<br />Distance to Capitole is: "+ getDistanceToCapitole() + "km.");
//								displayRoute();
//								routeDisplay = true;}
//					break;
//				case 'current': Googlemap.panTo(locationCurrent);
//					break;
//			}
//}


//

//DOCUMENT READY
$(document).ready(function(){
	
	display();
	getGeolocation();
	
	
		
});

	