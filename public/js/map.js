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

    var city_markers = L.layerGroup().addTo(map);

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
        height: 200,
        position: 'bottomleft'
    }).addTo(map);

    map.panBy([1, 0]);
    //L.Util.requestAnimFrame(map.invalidateSize, map, !1, map._container);

    //  ajax cities ===================================================================
    //$.ajaxSetup({cache: false});
    $.getJSON("/map/get_cities", function (data) {
        console.log(data);
        //var cities = JSON.parse(data);

        for (var i in data) {
            tx = data[i].x * HEX_SIDE * 1.5;
            ty = data[i].y * HEX_SCALED_HEIGHT + (data[i].x % 2) * HEX_SCALED_HEIGHT / 2;

            var city_marker = L.marker(rc.unproject([tx + margin_x, ty + margin_y]), {icon: window["city" + map.getZoom()]}).addTo(map);
            city_markers.addLayer(city_marker);
        }
    }).complete(function () {
        if (typeof coord != 'undefined') {
            placeHighlightHex(coord[0], coord[1]);
            getHexData(coord[0], coord[1]);
            map.setView(highlightMarker.getLatLng(), 4);
        }
        if (firstLoad == true) {
            map.fitBounds(map.getBounds());
            firstLoad = false;
        }
    });

    // info box ===========================================================================
    info = L.control();
    info.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
        this.update();
        return this._div;
    };

    // method that we will use to update the control based on feature properties passed
    info.update = function (data) {
        if (data) {
            var info = '<b>Koordináták</b><br><b>x: </b>' + data.x + '<br><b>y: </b>' + data.y + (data.city ? '' : '<br><b>Típus: </b>' + data.type + (data.owner ? '<br><b>Tulajdonos: </b>' + data.owner : ''));

            if (data.city) {
                info += '<br><br> <b>Város</b><br> <b>Név:</b> ' + data.city + '<br><b>Tulajdonos:</b> ' + data.owner + '<br><b>Nép: </b>' + data.nation;
            }
        }
        this._div.innerHTML = '<h4>Információk a hexről</h4>' + (data ? info : 'Jelölj ki egy hexet');
    };
    info.addTo(map);


    map.on('click', onMapClick);

    // zoom adjusting ===================================================================
    map.on('zoomend', function () {

        city_markers.eachLayer(function (layer) {
            layer.setIcon(window["city" + map.getZoom()]);
        });

        if (typeof highlightMarker != 'undefined') {
            highlightMarker.setIcon(window["highlight" + map.getZoom()]);
        }

    });

}

function onMapClick(e) {
    var coord = calculateHexCoord(e.latlng);
    placeHighlightHex(coord.x, coord.y);
    getHexData(coord.x, coord.y);

}

// calculating hex coordinates from latlng
function calculateHexCoord(latlng) {
    // calculate clicked hex coordinates ==================================================
    var x = (rc.project(latlng).x - margin_x - (HEX_HEIGHT / 2)) / (HEX_HEIGHT * 0.75);
    var y = (rc.project(latlng).y - margin_y - (HEX_HEIGHT / 2)) / HEX_HEIGHT;
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

    return {x: map_x, y: map_y};
}

function placeHighlightHex(x, y) {
    if (x < 0 || y < 0 || x > 39 || y > 39) {
        return false;
    }

    // --- Calculate coordinates of this hex.  We will use this
    // --- to place the highlight image.
    tx = x * HEX_SIDE * 1.5;
    ty = y * HEX_SCALED_HEIGHT + (x % 2) * HEX_SCALED_HEIGHT / 2;


    if (typeof highlightMarker != 'undefined') {
        map.removeLayer(highlightMarker);
    }

    highlightMarker = L.marker(rc.unproject([tx + margin_x, ty + margin_y]), {icon: window["highlight" + map.getZoom()]}).addTo(map);
}

function getHexData(x, y) {
    // ajax hex info ================================================================
    if (x < 0 || y < 0 || x > 39 || y > 39) {
        return false;
    }
    $.getJSON("/map/get_hex_data", {x: x, y: y}, function (data) {
        console.log(data);

        switch (data.nation) {
            case 0:
                var nation = '';
                break;
            case 1:
                var nation = 'római';
                break;
            case 2:
                var nation = 'görög';
                break;
            case 3:
                var nation = 'germán';
                break;
            case 4:
                var nation = 'szarmata';
                break;
        }

        switch (data.layer1) {
            case 1:
                var type = 'mély víz';
                break;
            case 2:
                var type = 'homokos part';
                break;
            case 3:
                var type = 'füves rét';
                break;
            case 4:
                var type = 'fenyőerdő';
                break;
            case 5:
                var type = 'hómező';
                break;
            case 6:
                var type = 'dombvidék';
                break;
            case 7:
                var type = 'havas dombok';
                break;
            case 8:
                var type = 'hegy';
                break;
            case 9:
                var type = 'sekély víz';
                break;
            case 10:
                var type = 'jég';
                break;
            case 11:
                var type = 'mocsár';
                break;
        }


        info.update({
            x: x,
            y: y,
            type: type,
            owner: data.owner,
            city: data.city,
            nation: nation
        });
    });

}

