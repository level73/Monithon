var MonithonReport = {

    init: function(){
        this.setReportMap();

    },

    // Set Map location and marker
    setReportMap: function(){
        var lat = $('#lat').text();
        var lon = $('#lon').text();

        var LocationMap = L.map('report-map').setView([lat,lon], 12);

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoibHZsNzMiLCJhIjoiY2swdzllbHd4MDB1ejNpbW1tMXk0eHY5MSJ9.7pGmC5RA3CQQYsgXLknlZg'
        }).addTo(LocationMap);

        new L.marker([lat, lon], { draggable: true} ).addTo(LocationMap);



        console.log(lat + ', ' + lon);
    },



}

MonithonReport.init();