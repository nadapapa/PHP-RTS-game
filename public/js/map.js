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


var city1 = L.icon({
    iconUrl: '/img/map/tiles/city.png',

    iconSize: [9, 9], // size of the icon

    iconAnchor: [4.5, 4.5] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var city2 = L.icon({
    iconUrl: '/img/map/tiles/city.png',

    iconSize: [18, 18], // size of the icon

    iconAnchor: [9, 9] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var city3 = L.icon({
    iconUrl: '/img/map/tiles/city.png',

    iconSize: [36, 36], // size of the icon

    iconAnchor: [18, 18] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var city4 = L.icon({
    iconUrl: '/img/map/tiles/city.png',

    iconSize: [72, 72], // size of the icon

    iconAnchor: [36, 36] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});


var army1 = L.icon({
    iconUrl: '/img/map/tiles/army.png',

    iconSize: [9, 9], // size of the icon

    iconAnchor: [4.5, 4.5] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var army2 = L.icon({
    iconUrl: '/img/map/tiles/army.png',

    iconSize: [18, 18], // size of the icon

    iconAnchor: [9, 9] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var army3 = L.icon({
    iconUrl: '/img/map/tiles/army.png',

    iconSize: [36, 36], // size of the icon

    iconAnchor: [18, 18] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

var army4 = L.icon({
    iconUrl: '/img/map/tiles/army.png',

    iconSize: [72, 72], // size of the icon

    iconAnchor: [36, 36] // point of the icon which will correspond to marker's location
    //popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
});

// some constants
var margin_x = 27;
var margin_y = 36;
var HEX_HEIGHT = 72;
var HEX_SCALED_HEIGHT = HEX_HEIGHT * 1.0;
var HEX_SIDE = HEX_SCALED_HEIGHT / 2;
var firstLoad = true;

$.ajaxPrefilter(function (options, originalOptions, xhr) {
    var token = $('meta[name="csrf_token"]').attr('content');

    if (token) {
        return xhr.setRequestHeader('X-XSRF-TOKEN', token);
    }
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
        crs: L.CRS.Simple,
        contextmenu: true,
        contextmenuItems: [{
            text: 'ide',
            callback: moveToHex
        }]
    }).setView([0, 0], mapMinZoom);

    var city_markers = L.layerGroup().addTo(map);
    var army_markers = L.layerGroup().addTo(map);
    path_markers = L.layerGroup().addTo(map);


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

    // minimap =======================================================================
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

    //  ajax cities ===================================================================
    $.ajaxSetup({cache: false});
    $.getJSON("/map/get_cities", function (data) {
        for (var i in data) {
            tx = (data[i].x * HEX_SIDE * 1.5) + 36;
            ty = (data[i].y * HEX_SCALED_HEIGHT + (data[i].x % 2) * HEX_SCALED_HEIGHT / 2) + 36;

            var city_marker = L.marker(rc.unproject([tx + margin_x, ty + margin_y]), {
                icon: window["city" + map.getZoom()],
                zIndexOffset: 1000,
                clickable: false
            }).addTo(map);
            city_markers.addLayer(city_marker);
        }
    }).complete(function () {
        if (start_coord != 0) {
            placeHighlightHex(start_coord[0], start_coord[1]);
            getHexData(start_coord[0], start_coord[1]);
            map.setView(highlightMarker.getLatLng(), 4);
        }
        if (firstLoad == true) {
            map.fitBounds(map.getBounds());
            firstLoad = false;
        }
    });

    //  ajax armies ===================================================================
    $.getJSON("/map/get_armies", function (data) {
        for (var i in data) {

            tx = (data[i].x * HEX_SIDE * 1.5) + 36;
            ty = (data[i].y * HEX_SCALED_HEIGHT + (data[i].x % 2) * HEX_SCALED_HEIGHT / 2) + 36;

            var army_marker = L.marker(rc.unproject([tx + margin_x, ty + margin_y]), {
                icon: window["army" + map.getZoom()],
                zIndexOffset: 2000,
                contextmenu: true,
                contextmenuInheritItems: false,
                contextmenuItems: [{
                    text: 'hadsereg mozgatása',
                    disabled: true,
                    callback: selectArmy
                }]
            }).addTo(map)
                .on('click', function (e) {
                    var coord = calculateHexCoord(e.latlng);
                    placeHighlightHex(coord.x, coord.y);
                    getHexData(coord.x, coord.y);
                });
            if (typeof data[i].army != 'undefined') {
                army_marker.options.contextmenuItems[0].disabled = false;

                army_marker.army = data[i].army;
            }

            army_markers.addLayer(army_marker);
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
            var info = '<b>Koordináták</b><br>' +
                '<b>x: </b>' + data.x + '<br>' +
                '<b>y: </b>' + data.y +
                (data.city_name ? '' : '<br>' +
                '<b>Típus: </b>' + data.type +
                (data.hex_owner ? '<br>' +
                '<b>Tulajdonos: </b>' + data.hex_owner : ''));

            if (data.city_name) {
                info += '<br><br> <b>Város</b><br> ' +
                    '<b>Név:</b> ' + data.city_name + '<br>' +
                    '<b>Tulajdonos:</b> ' + data.city_owner + '<br>' +
                    '<b>Nép: </b>' + data.city_nation;
            }
            if (data.army_id) {
                info += '<br><br> <b>Hadsereg</b><br>' +
                    (data.army_owner ? ' <b>Tulajdonos:</b> ' + data.army_owner : "") +
                    (data.army_nation ? '<br><b>Nép:</b> ' + data.army_nation : '');
            }
            if (typeof data.army != 'undefined') {
                    info += '<br><b>Egységek</b><br>' +
                        'könnyűgyalogos: ' + data.army.unit1 + '<br>' +
                        'nehézgyalogos: ' + data.army.unit2 + '<br>' +
                        'pikás: ' + data.army.unit3 + '<br>' +
                        'könnyűlovas: ' + data.army.unit4 + '<br>' +
                        'nehézlovas: ' + data.army.unit5 + '<br>' +
                        'íjász: ' + data.army.unit6 + '<br>' +
                        'katapult: ' + data.army.unit7;
                }

        }
        this._div.innerHTML = '<h4>Információk</h4>' + (data ? info : 'Jelölj ki egy hexet');
    };
    info.addTo(map);

    map.on('click', onMapClick);

    map.on('contextmenu.show', function (e) {
        var coord = calculateHexCoord(e.contextmenu._showLocation.latlng);
        placeHighlightHex(coord.x, coord.y);
        getHexData(coord.x, coord.y)
    });

    // zoom adjusting ===================================================================
    map.on('zoomend', function () {

        city_markers.eachLayer(function (layer) {
            layer.setIcon(window["city" + map.getZoom()]);
        });

        army_markers.eachLayer(function (layer) {
            layer.setIcon(window["army" + map.getZoom()]);
        });

        path_markers.eachLayer(function (layer) {
            layer.setIcon(window["highlight" + map.getZoom()]);
        });

        if (typeof highlightMarker != 'undefined') {
            highlightMarker.setIcon(window["highlight" + map.getZoom()]);
        }

        if (typeof highlightMarkerFrom != 'undefined') {
            highlightMarkerFrom.setIcon(window["highlight" + map.getZoom()]);
        }


    });
}

function onMapClick(e) {
    map.contextmenu.hide();
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
    tx = (x * HEX_SIDE * 1.5) + 36;
    ty = (y * HEX_SCALED_HEIGHT + (x % 2) * HEX_SCALED_HEIGHT / 2) + 36;

    if (typeof highlightMarker != 'undefined') {
        highlightMarker.setLatLng(rc.unproject([tx + margin_x, ty + margin_y]));
        //map.removeLayer(highlightMarker);
    } else {
        highlightMarker = L.marker(rc.unproject([tx + margin_x, ty + margin_y]), {
            icon: window["highlight" + map.getZoom()],
            zIndexOffset: 1500,
            clickable: false,
        }).addTo(map);
    }
}

function getHexData(x, y) {
    // ajax hex info ================================================================
    if (x < 0 || y < 0 || x > 39 || y > 39) {
        return false;
    }
    $.getJSON("/map/get_hex_data", {x: x, y: y}, function (data) {

        switch (data.city_nation) {
            case 0:
                var city_nation = '';
                break;
            case 1:
                var city_nation = 'római';
                break;
            case 2:
                var city_nation = 'görög';
                break;
            case 3:
                var city_nation = 'germán';
                break;
            case 4:
                var city_nation = 'szarmata';
                break;
        }

        switch (data.army_nation) {
            case 0:
                var army_nation = '';
                break;
            case 1:
                var army_nation = 'római';
                break;
            case 2:
                var army_nation = 'görög';
                break;
            case 3:
                var army_nation = 'germán';
                break;
            case 4:
                var army_nation = 'szarmata';
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
            hex_owner: data.owner,

            city_owner: data.city_owner,
            city_name: data.city_name,
            city_nation: city_nation,

            army_id: data.army_id,
            army_owner: data.army_owner,
            army_nation: army_nation,
            army: data.army
        });
    });
}

function selectArmy(a) {
    armycoord = calculateHexCoord(a.latlng);
    console.log(armycoord);

    // --- Calculate coordinates of this hex.  We will use this
    // --- to place the highlight image.
    tx = (armycoord.x * HEX_SIDE * 1.5) + 36;
    ty = (armycoord.y * HEX_SCALED_HEIGHT + (armycoord.x % 2) * HEX_SCALED_HEIGHT / 2) + 36;

    if (typeof pathMarker != 'undefined') {
        console.log("van");
    }

    if (typeof highlightMarkerFrom != 'undefined') {
        highlightMarkerFrom.setLatLng(rc.unproject([tx + margin_x, ty + margin_y]));
        //map.removeLayer(highlightMarker);
    } else {
        highlightMarkerFrom = L.marker(rc.unproject([tx + margin_x, ty + margin_y]), {
            icon: window["highlight" + map.getZoom()],
            zIndexOffset: 1400,
            clickable: false,
        }).addTo(map);
    }

}

function moveToHex(b) {
    //console.log(armycoord);
    var finishcoord = calculateHexCoord(b.latlng);

    $.getJSON("/map/get_path", {
        x1: armycoord.x,
        y1: armycoord.y,
        x2: finishcoord.x,
        y2: finishcoord.y
    }, function (data) {
        console.log(data);

        for (var i in data) {
            tx = (data[i].x * HEX_SIDE * 1.5) + 36;
            ty = (data[i].y * HEX_SCALED_HEIGHT + (data[i].x % 2) * HEX_SCALED_HEIGHT / 2) + 36;

            var pathMarker = L.marker(rc.unproject([tx + margin_x, ty + margin_y]), {
                icon: window["highlight" + map.getZoom()],
                zIndexOffset: 1500,
                clickable: false
            }).addTo(map);
            path_markers.addLayer(pathMarker)
        }
    });


    //map.removeLayer(highlightMarkerFrom);
    //highlightMarkerFrom = undefined;
    //
    //console.log(finishcoord);
}


////////////////////////////////////////////////////////////////////////////////
//                              TODO
////////////////////////////////////////////////////////////////////////////////
// hadsereg kijelölése: jobbklikk -> menü -> klikk a kijelölésre
// utána ha másik hexre kattint akkor egy új highlight jön létre
// a másik hexen jobb klikk -> hadsereg ide -> hadsereg áthelyezése az új hexre
//
//
//
//
//
//
//
//