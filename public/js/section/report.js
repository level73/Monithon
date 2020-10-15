var MonithonReport = {

    init: function(){
        this.setReportMap();

    },

    // Set Map location and marker
    setReportMap: function(){
        var lat = $('#lat').text();
        var lon = $('#lon').text();

        var LocationMap = L.map('report-map').setView([lat,lon], 12);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            tileSize: 512,
            maxZoom: 18,
            zoomOffset: -1,
            id: 'mapbox/streets-v11',
            accessToken: 'pk.eyJ1IjoibHZsNzMiLCJhIjoiY2swdzllbHd4MDB1ejNpbW1tMXk0eHY5MSJ9.7pGmC5RA3CQQYsgXLknlZg'
        }).addTo(LocationMap);

        new L.marker([lat, lon], { draggable: true} ).addTo(LocationMap);

    },
}

MonithonReport.init();