var ProfileMap = L.map('profile-map').setView([42.088,12.564], 6);
var LatLngs = [];
var profile = $('.prf').text();

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    tileSize: 512,
    maxZoom: 18,
    zoomOffset: -1,
    id: 'mapbox/streets-v11',
    accessToken: 'pk.eyJ1IjoibHZsNzMiLCJhIjoiY2swdzllbHd4MDB1ejNpbW1tMXk0eHY5MSJ9.7pGmC5RA3CQQYsgXLknlZg'
}).addTo(ProfileMap);

$.getJSON('/ajax/profile_map_reports/' + profile, { profile: profile }, function(data){

    $.each(data, function(i, v){
        var marker = L.marker([v.lat_, v.lon_]).addTo(ProfileMap);
        var popup = '<div><h3>' + v.titolo + '</h3><a href="/report/view/' + v.idreport_basic + '">Visualizza Report</a></div>';
        marker.bindPopup(popup);
        var latlng = [ parseFloat(v.lat_), parseFloat(v.lon_) ];
        LatLngs[i] = latlng;
    });

    if(LatLngs.length > 1){
        ProfileMap.fitBounds(LatLngs);
    }
    else {
        var lat = LatLngs[0];
        var lon = LatLngs[1];

        ProfileMap.setView(LatLngs[0], 10);
    }
});


/** Little donut chart for quick evaluations **/
/*
var chartData = $('#chart-data').text().split(',');
var chartLabels = $('#chart-labels').text().split(',');

var options = {
    colors: [ '#6bc2e6', '#6be6ca', '#f3788e', '#d52d4b', '#68c59a', '#9a1946' ],
    chart: {
        type: 'pie'
    },
    series: chartData,
    labels: chartLabels,
    legend: {
        position: 'bottom'
    },
}

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();*/