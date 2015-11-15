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
        contextmenuItems: [{text: 'ide'}]
    }).setView([0, 0], mapMinZoom);

    var city_markers = L.layerGroup().addTo(map);
    var army_markers = L.layerGroup().addTo(map);

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

    //  ajax armies ===================================================================
    $.getJSON("/map/get_armies", function (data) {
        for (var i in data) {
            tx = (data[i].x * HEX_SIDE * 1.5) + 36;
            ty = (data[i].y * HEX_SCALED_HEIGHT + (data[i].x % 2) * HEX_SCALED_HEIGHT / 2) + 36;

            console.log(data[i].army_id);

            var army_marker = L.marker(rc.unproject([tx + margin_x, ty + margin_y]), {
                icon: window["army" + map.getZoom()],
                zIndexOffset: 2000,
                contextmenu: true,
                contextmenuInheritItems: false,
                contextmenuItems: [{
                    text: 'hadsereg',
                    disabled: true
                }]
            }).addTo(map)
                .on('click', function (e) {
                    var coord = calculateHexCoord(e.latlng);
                    placeHighlightHex(coord.x, coord.y);
                    onArmyClick(this, coord.x, coord.y);
                });
            army_marker.army_id = data[i].army_id;
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
                (data.city ? '' : '<br>' +
                '<b>Típus: </b>' + data.type +
                (data.owner ? '<br>' +
                '<b>Tulajdonos: </b>' + data.owner : ''));

            if (data.city) {
                info += '<br><br> <b>Város</b><br> ' +
                    '<b>Név:</b> ' + data.city + '<br>' +
                    '<b>Tulajdonos:</b> ' + data.owner + '<br>' +
                    '<b>Nép: </b>' + data.nation;
            }
            if (data.army_id) {
                info += '<br><br> <b>Hadsereg</b><br>' +
                    (data.army_owner ? ' <b>Tulajdonos:</b> ' + data.army_owner : "") +
                    (data.nation ? '<br><b>Nép:</b> ' + data.nation : '');
                if (typeof data.unit1 != 'undefined') {
                    info += '<br><b>Egységek</b><br>' +
                        'könnyűgyalogos: ' + data.unit1 + '<br>' +
                        'nehézgyalogos: ' + data.unit2 + '<br>' +
                        'pikás: ' + data.unit3 + '<br>' +
                        'könnyűlovas: ' + data.unit4 + '<br>' +
                        'nehézlovas: ' + data.unit5 + '<br>' +
                        'íjász: ' + data.unit6 + '<br>' +
                        'katapult: ' + data.unit7;
                }
            }
        }
        this._div.innerHTML = '<h4>Információk</h4>' + (data ? info : 'Jelölj ki egy hexet');
    };
    info.addTo(map);

    map.on('click', onMapClick);

    //map.on('contextmenu.show', function () {
    //    map.fireEvent('click');
    //});

    map.on('contextmenu.show', function (e) {
        //map.fireEvent('click', e);
        console.log(e);
        var coord = calculateHexCoord(e.contextmenu._showLocation.latlng);
        placeHighlightHex(coord.x, coord.y);
        onArmyClick(e.relatedTarget, coord.x, coord.y)
    });

    // zoom adjusting ===================================================================
    map.on('zoomend', function () {

        city_markers.eachLayer(function (layer) {
            layer.setIcon(window["city" + map.getZoom()]);
        });

        army_markers.eachLayer(function (layer) {
            layer.setIcon(window["army" + map.getZoom()]);
        });


        if (typeof highlightMarker != 'undefined') {
            highlightMarker.setIcon(window["highlight" + map.getZoom()]);
        }

    });
}

function onMapClick(e) {
    map.contextmenu.hide();
    var coord = calculateHexCoord(e.latlng);
    placeHighlightHex(coord.x, coord.y);
    getHexData(coord.x, coord.y);
}

function onArmyClick(army_marker, x, y) {
    $.getJSON("/map/get_army_data", {army_id: army_marker.army_id}, function (data) {
        switch (data.city_nation) {
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
        switch (data.hex_layer1) {
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
            owner: data.hex_owner,
            city: data.city_name,
            nation: nation,
            army_id: data.id,
            army_owner: data.army_owner,
            unit1: data.unit1,
            unit2: data.unit2,
            unit3: data.unit3,
            unit4: data.unit4,
            unit5: data.unit5,
            unit6: data.unit6,
            unit7: data.unit7
        });
        if (auth_user_id == parseInt(data.user_id)) {
            army_marker.options.contextmenuItems[0].disabled = false;
            //.setDisabled(1, false);
        }
    });
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
            nation: nation,
            army_id: data.army_id,
            army_owner: data.army_owner,
            unit1: data.unit1,
            unit2: data.unit2,
            unit3: data.unit3,
            unit4: data.unit4,
            unit5: data.unit5,
            unit6: data.unit6,
            unit7: data.unit7
        });

        //setContextMenu(data);
    });
}

