
var LocationMap = L.map('location_map').setView([42.088,12.564], 6);

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}.png?access_token={accessToken}', {
	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    tileSize: 512,
    maxZoom: 18,
    zoomOffset: -1,
    id: 'mapbox/streets-v11',
	accessToken: 'pk.eyJ1IjoibHZsNzMiLCJhIjoiY2swdzllbHd4MDB1ejNpbW1tMXk0eHY5MSJ9.7pGmC5RA3CQQYsgXLknlZg'
}).addTo(LocationMap);

var LocationMarker;

function setLocationCoords(latlng){
  var lat = latlng.lat;
  var lon = latlng.lng;
  $('#lat').val(lat);
  $('#lon').val(lon);
}

function addMarkerToMap(latlng){
  if(LocationMarker){
    LocationMap.removeLayer(LocationMarker);
  }
  LocationMarker = new L.marker(latlng, { draggable: true} ).addTo(LocationMap);
  LocationMarker.on('move', function(ev){ setLocationCoords(ev.latlng); });
}

function searchGeocode(ev){
  ev.preventDefault();
  var address = $('#indirizzo').val() + ', ' + $('#cap').val();
	console.log(address);
  $.getJSON( 'https://nominatim.openstreetmap.org/search?format=json&q=' + address, function(data){
		console.log(data);
    if(data.length > 0){
      LocationMap.setView([data[0].lat, data[0].lon], 15);
      addMarkerToMap([data[0].lat, data[0].lon]);
      setLocationCoords( { 'lat': data[0].lat, 'lng': data[0].lon } );
    }
    else {
      alert('Questo indirizzo non appare nei nostri database. Controllane l\'ortografia o prova con un altro indirizzo.');
    }
  });
  return false;
}


// We need this to tackle the "Enter" keypress to search for the address
function registerKeypress(ev) {
  var code = (ev.keyCode ? ev.keyCode : ev.which);
  if (code == 13) {
    searchGeocode(ev);
  }
};
$('#indirizzo').bind("keypress", {}, registerKeypress);

$('#indirizzo_lookup').on('click', function(ev){
  searchGeocode(ev);
});

LocationMap.on('click', function(ev){
  var latlng = ev.latlng;
  addMarkerToMap(latlng);
  setLocationCoords(latlng)
});

if($('#lat').val() > 0 && $('#lon').val() > 0){
	var latlng = [ $('#lat').val(), $('#lon').val()];
	addMarkerToMap(latlng);
}
