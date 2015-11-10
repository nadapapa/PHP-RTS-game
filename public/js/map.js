var highlight1 = L.icon({
    iconUrl: '/img/map/tiles/highlight.png',

    iconSize: [9, 9], // size of the icon

    iconAnchor: [4.5, 4.5] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var highlight2 = L.icon({
    iconUrl: '/img/map/tiles/highlight.png',

    iconSize: [18, 18], // size of the icon

    iconAnchor: [9, 9] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var highlight3 = L.icon({
    iconUrl: '/img/map/tiles/highlight.png',

    iconSize: [36, 36], // size of the icon

    iconAnchor: [18, 18] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var highlight4 = L.icon({
    iconUrl: '/img/map/tiles/highlight.png',

    iconSize: [72, 72], // size of the icon

    iconAnchor: [36, 36] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

function init() {
    var mapMinZoom = 1;
    var mapMaxZoom = 4;

    var img = [
        2231,  // original width of image
        2988   // original height of image
    ];

    map = L.map('map', {
        maxZoom: mapMaxZoom,
        minZoom: mapMinZoom,
        crs: L.CRS.Simple
    }).setView([0, 0], mapMinZoom);

    rc = new L.RasterCoords(map, img);

    var mapBounds = new L.LatLngBounds(
        map.unproject([0, 2231], mapMaxZoom),
        map.unproject([2988, 0], mapMaxZoom));

    map.fitBounds(mapBounds);

    L.tileLayer('http://localhost/img/map/{z}/{x}/{y}.png', {
        minZoom: mapMinZoom,
        maxZoom: mapMaxZoom,
        continuousWorld: true,
        bounds: mapBounds,
        noWrap: true
        //tms: false
    }).addTo(map);

    var minimap = new L.TileLayer('/img/map/{z}/{x}/{y}.png', {
        minZoom: 0,
        maxZoom: mapMaxZoom,
        continuousWorld: true,
        bounds: mapBounds
    });
    new L.Control.MiniMap(minimap, {
        toggleDisplay: true,
        position: 'topright',
        height: 200
    }).addTo(map);

    map.on('click', onMapClick);

    map.on('zoomend', function () {
        if (typeof highlightMarker == 'undefined') {
            return false;
        }
        switch (map.getZoom()) {
            case 1:
                highlightMarker.setIcon(highlight1);
                break;
            case 2:
                highlightMarker.setIcon(highlight2);
                break;
            case 3:
                highlightMarker.setIcon(highlight3);
                break;
            case 4:
                highlightMarker.setIcon(highlight4);
                break;
        }
    });
}

function onMapClick(e) {
    console.log(rc.project(e.latlng));

    if (typeof highlightMarker != 'undefined') {
        map.removeLayer(highlightMarker);
    }
    switch (map.getZoom()) {
        case 1:
            var highlight = highlight1;
            break;
        case 2:
            var highlight = highlight2;
            break;
        case 3:
            var highlight = highlight3;
            break;
        case 4:
            var highlight = highlight4;
            break;
    }
    highlightMarker = L.marker(e.latlng, {icon: highlight}).addTo(map);
}
