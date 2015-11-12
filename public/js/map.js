var highlight1 = L.icon({
    iconUrl: '/img/map/tiles/highlight.png',

    iconSize: [9, 9], // size of the icon

    iconAnchor: [0, 0] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var highlight2 = L.icon({
    iconUrl: '/img/map/tiles/highlight.png',

    iconSize: [18, 18], // size of the icon

    iconAnchor: [0, 0] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var highlight3 = L.icon({
    iconUrl: '/img/map/tiles/highlight.png',

    iconSize: [36, 36], // size of the icon

    iconAnchor: [0, 0] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var highlight4 = L.icon({
    iconUrl: '/img/map/tiles/highlight.png',

    iconSize: [72, 72], // size of the icon

    iconAnchor: [0, 0] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var city1 = L.icon({
    iconUrl: '/img/map/tiles/city.png',

    iconSize: [9, 9], // size of the icon

    iconAnchor: [0, 0] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var city2 = L.icon({
    iconUrl: '/img/map/tiles/city.png',

    iconSize: [18, 18], // size of the icon

    iconAnchor: [0, 0] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var city3 = L.icon({
    iconUrl: '/img/map/tiles/city.png',

    iconSize: [36, 36], // size of the icon

    iconAnchor: [0, 0] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var city4 = L.icon({
    iconUrl: '/img/map/tiles/city.png',

    iconSize: [72, 72], // size of the icon

    iconAnchor: [0, 0] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

// some constants
var margin_x = 27;
var margin_y = 36;
var HEX_HEIGHT = 72;
var HEX_SCALED_HEIGHT = HEX_HEIGHT * 1.0;
var HEX_SIDE = HEX_SCALED_HEIGHT / 2;
var firstLoad = true;


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
        map.unproject([0, 3000], mapMaxZoom),
        map.unproject([3000, 0], mapMaxZoom));

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
    map.panBy([1, 0]);
    //L.Util.requestAnimFrame(map.invalidateSize, map, !1, map._container);

    $.ajaxSetup({cache: false});
    $.getJSON("/map/get_cities", function (data) {
        console.log(data);
        //var cities = JSON.parse(data);

        for (var i in data) {
            tx = data[i].x * HEX_SIDE * 1.5;
            ty = data[i].y * HEX_SCALED_HEIGHT + (data[i].x % 2) * HEX_SCALED_HEIGHT / 2;

            console.log(tx + ", " + ty);
            console.log(rc.unproject([tx + margin_x, ty + margin_y]));

            var city = window["city" + map.getZoom()];

            cityMarker = L.marker(rc.unproject([tx + margin_x, ty + margin_y]), {icon: city}).addTo(map)
        }
    }).complete(function () {
        if (firstLoad == true) {
            map.fitBounds(map.getBounds());
            firstLoad = false;
        }
    });

    map.on('zoomend', function () {
        cityMarker.setIcon(window["city" + map.getZoom()]);

        if (typeof highlightMarker != 'undefined') {
            highlightMarker.setIcon(window["highlight" + map.getZoom()]);
        }

    });

    map.on('click', onMapClick);
}

function onMapClick(e) {
    var x = (rc.project(e.latlng).x - margin_x - (HEX_HEIGHT / 2)) / (HEX_HEIGHT * 0.75);
    var y = (rc.project(e.latlng).y - margin_y - (HEX_HEIGHT / 2)) / HEX_HEIGHT;
    var z = -0.5 * x - y;
    var y = -0.5 * x + y;

    ix = Math.floor(x + 0.5);
    iy = Math.floor(y + 0.5);
    iz = Math.floor(z + 0.5);
    s = ix + iy + iz;
    if (s) {
        abs_dx = Math.abs(ix - x);
        abs_dy = Math.abs(iy - y);
        abs_dz = Math.abs(iz - z);
        if (abs_dx >= abs_dy && abs_dx >= abs_dz) {
            ix -= s;
        } else if (abs_dy >= abs_dx && abs_dy >= abs_dz) {
            iy -= s;
        } else {
            iz -= s;
        }
    }

    // map_x and map_y are the map coordinates of the click
    map_x = ix;
    map_y = (iy - iz + (1 - ix % 2 ) ) / 2 - 0.5;

    if (map_x < 0 || map_y < 0 || map_x > 39 || map_y > 39) {
        return false;
    }

    console.log(rc.project(e.latlng));

    console.log(map_x + ", " + map_y);

    // --- Calculate coordinates of this hex.  We will use this
    // --- to place the highlight image.

    tx = map_x * HEX_SIDE * 1.5;
    ty = map_y * HEX_SCALED_HEIGHT + (map_x % 2) * HEX_SCALED_HEIGHT / 2;


    if (typeof highlightMarker != 'undefined') {
        map.removeLayer(highlightMarker);
    }

    var highlight = window["highlight" + map.getZoom()];


    highlightMarker = L.marker(rc.unproject([tx + margin_x, ty + margin_y]), {icon: highlight}).addTo(map);
}

//$(document).ready(function(){
//
//});