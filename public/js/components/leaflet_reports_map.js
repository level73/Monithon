var ReportMap = L.map('report-map').setView([42.088,12.564], 6);

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    tileSize: 512,
    maxZoom: 18,
    zoomOffset: -1,
    id: 'mapbox/streets-v11',
    accessToken: 'pk.eyJ1IjoibHZsNzMiLCJhIjoiY2swdzllbHd4MDB1ejNpbW1tMXk0eHY5MSJ9.7pGmC5RA3CQQYsgXLknlZg'
}).addTo(ReportMap);

$.getJSON('/ajax/map_reports', null, function(data){
    $.each(data, function(i, v){

        var marker = L.marker([v.lat_, v.lon_]).addTo(ReportMap);
        var popup = '<div><h3>' + v.titolo + '</h3><a href="/report/view/' + v.id + '">Visualizza Report</a></div>';
        marker.bindPopup(popup);

    });
});