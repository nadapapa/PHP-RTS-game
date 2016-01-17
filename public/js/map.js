// defining icons
// the number next to the icon name (e.g. city2) means the zoom level in which that particular
// icon should be shown.
var highlight1 = L.icon({
    iconUrl: '/img/map/tiles/highlight.png',

    iconSize: [9, 9], // size of the icon

    iconAnchor: [4.5, 4.5], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -4.5] // point from which the popup should open relative to the iconAnchor
});

var highlight2 = L.icon({
    iconUrl: '/img/map/tiles/highlight.png',

    iconSize: [18, 18], // size of the icon

    iconAnchor: [9, 9], // point of the icon which will correspond to marker's location
    popupAnchor: [9, -9] // point from which the popup should open relative to the iconAnchor
});

var highlight3 = L.icon({
    iconUrl: '/img/map/tiles/highlight.png',

    iconSize: [36, 36], // size of the icon

    iconAnchor: [18, 18], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -18] // point from which the popup should open relative to the iconAnchor
});

var highlight4 = L.icon({
    iconUrl: '/img/map/tiles/highlight.png',

    iconSize: [72, 72], // size of the icon

    iconAnchor: [36, 36], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -36] // point from which the popup should open relative to the iconAnchor
});


var city1 = L.icon({
    iconUrl: '/img/map/tiles/city.png',

    iconSize: [9, 9], // size of the icon

    iconAnchor: [4.5, 4.5], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -4.5] // point from which the popup should open relative to the iconAnchor
});

var city2 = L.icon({
    iconUrl: '/img/map/tiles/city.png',

    iconSize: [18, 18], // size of the icon

    iconAnchor: [9, 9], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -9] // point from which the popup should open relative to the iconAnchor
});

var city3 = L.icon({
    iconUrl: '/img/map/tiles/city.png',

    iconSize: [36, 36], // size of the icon

    iconAnchor: [18, 18], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -18] // point from which the popup should open relative to the iconAnchor
});

var city4 = L.icon({
    iconUrl: '/img/map/tiles/city.png',

    iconSize: [72, 72], // size of the icon

    iconAnchor: [36, 36], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -36] // point from which the popup should open relative to the iconAnchor
});


var army1 = L.icon({
    iconUrl: '/img/map/tiles/army.png',
    iconSize: [9, 9],
    iconAnchor: [4.5, 4.5],
    popupAnchor: [0, -4.5]
});

var army2 = L.icon({
    iconUrl: '/img/map/tiles/army.png',
    iconSize: [18, 18],
    iconAnchor: [9, 9],
    popupAnchor: [0, -9]
});

var army3 = L.icon({
    iconUrl: '/img/map/tiles/army.png',
    iconSize: [36, 36],
    iconAnchor: [18, 18],
    popupAnchor: [0, -18]
});

var army4 = L.icon({
    iconUrl: '/img/map/tiles/army.png',
    iconSize: [72, 72],
    iconAnchor: [36, 36],
    popupAnchor: [0, -36]
});


var green1 = L.icon({
    iconUrl: '/img/map/tiles/green.png',

    iconSize: [9, 9], // size of the icon

    iconAnchor: [4.5, 4.5], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -4] // point from which the popup should open relative to the iconAnchor
});

var green2 = L.icon({
    iconUrl: '/img/map/tiles/green.png',

    iconSize: [18, 18], // size of the icon

    iconAnchor: [9, 9], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -9] // point from which the popup should open relative to the iconAnchor
});

var green3 = L.icon({
    iconUrl: '/img/map/tiles/green.png',

    iconSize: [36, 36], // size of the icon

    iconAnchor: [18, 18], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -18] // point from which the popup should open relative to the iconAnchor
});

var green4 = L.icon({
    iconUrl: '/img/map/tiles/green.png',

    iconSize: [72, 72], // size of the icon

    iconAnchor: [36, 36], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -36] // point from which the popup should open relative to the iconAnchor
});


var brush1 = L.icon({
    iconUrl: '/img/map/tiles/brush.png',

    iconSize: [9, 9], // size of the icon

    iconAnchor: [4.5, 4.5], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -4] // point from which the popup should open relative to the iconAnchor
});

var brush2 = L.icon({
    iconUrl: '/img/map/tiles/brush.png',

    iconSize: [18, 18], // size of the icon

    iconAnchor: [9, 9], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -9] // point from which the popup should open relative to the iconAnchor
});

var brush3 = L.icon({
    iconUrl: '/img/map/tiles/brush.png',

    iconSize: [36, 36], // size of the icon

    iconAnchor: [18, 18], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -18] // point from which the popup should open relative to the iconAnchor
});

var brush4 = L.icon({
    iconUrl: '/img/map/tiles/brush.png',

    iconSize: [72, 72], // size of the icon

    iconAnchor: [36, 36], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -36] // point from which the popup should open relative to the iconAnchor
});


var red1 = L.icon({
    iconUrl: '/img/map/tiles/red.png',

    iconSize: [9, 9], // size of the icon

    iconAnchor: [4.5, 4.5], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -4] // point from which the popup should open relative to the iconAnchor
});

var red2 = L.icon({
    iconUrl: '/img/map/tiles/red.png',

    iconSize: [18, 18], // size of the icon

    iconAnchor: [9, 9], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -9] // point from which the popup should open relative to the iconAnchor
});

var red3 = L.icon({
    iconUrl: '/img/map/tiles/red.png',

    iconSize: [36, 36], // size of the icon

    iconAnchor: [18, 18], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -18] // point from which the popup should open relative to the iconAnchor
});

var red4 = L.icon({
    iconUrl: '/img/map/tiles/red.png',

    iconSize: [72, 72], // size of the icon

    iconAnchor: [36, 36], // point of the icon which will correspond to marker's location
    popupAnchor: [0, -36] // point from which the popup should open relative to the iconAnchor
});

// some constants
var margin_x = 27;
var margin_y = 36;
var HEX_HEIGHT = 72;
var HEX_SCALED_HEIGHT = HEX_HEIGHT;
var HEX_SIDE = HEX_SCALED_HEIGHT / 2;

var first_drag = 1;

var army_selected = 0;
var army_attacked = 0;
var city_attacked = 0;

var enemy_army_in_the_way = 0;
var friendly_army_in_the_way = 0;

var friendly_city_in_the_way = 0;
var enemy_city_in_the_way = 0;

var ajax_throttle = 500; //ms
var map_width = 40; //hex
var map_height = 40; //hex

var highlight_zindex = 1000;
var cities_zindex = 2000;
var path_zindex = 3000;
var path_point_zindex = 6000;
var attack_marker_zindex = 6000;
var armies_zindex = 5000;

var armies_hash = [];
var armies_coordinates = [];
var cities_hash = [];


function init() {
    same_view = {x: 1000, y: 1000};
    var mapMinZoom = 1;
    var mapMaxZoom = 4;
    var view = [-93, 69];
    var zoom = mapMinZoom;

    var img = [
        2231,  // original width of image
        2988   // original height of image
    ];

    map = L.map('map', {
        maxZoom: mapMaxZoom,
        minZoom: mapMinZoom,
        crs: L.CRS.Simple,
        attributionControl: false,
    }).setView(view, zoom, {reset: true});

    // refresh button
    L.easyButton('<i class="fa fa-refresh"></i>', function () {
        refreshMap();
    }, 'frissítés').addTo(map);

    map.on('zoomend', function () {
        city_markers.eachLayer(function (layer) {
            layer.setIcon(window["city" + map.getZoom()]);
        });

        army_markers.eachLayer(function (layer) {
            layer.setIcon(window["army" + map.getZoom()]);
        });

        path_markers.eachLayer(function (layer) {
            if (layer.options.icon.options.iconUrl.indexOf('red.png') > -1) {
                layer.setIcon(window["red" + map.getZoom()]);
            } else {
                layer.setIcon(window["brush" + map.getZoom()]);
            }
        });

        started_path_group.eachLayer(function (layer) {
            layer.setIcon(window["brush" + map.getZoom()]);
        });

        point_markers.eachLayer(function (layer) {
            if (layer.options.icon.options.iconUrl.indexOf('red.png') > -1) {
                layer.setIcon(window["red" + map.getZoom()]);
            } else {
                layer.setIcon(window["green" + map.getZoom()]);
            }
        });

        if (typeof highlightMarker != 'undefined') {
            highlightMarker.setIcon(window["highlight" + map.getZoom()]);
        }

        if (typeof highlightMarkerFrom != 'undefined') {
            highlightMarkerFrom.setIcon(window["highlight" + map.getZoom()]);
        }

        if (typeof attackMarker != 'undefined') {
            attackMarker.setIcon(window["red" + map.getZoom()]);
        }
    });

    rc = new L.RasterCoords(map, img);

    if (start_coord != 0) {
        placeHighlightHex(start_coord[0], start_coord[1]);
        //getHexData(start_coord[0], start_coord[1]);
        map.setView(highlightMarker.getLatLng(), 4);
    }

    // marker layers
    city_markers = L.featureGroup().addTo(map);
    army_markers = L.featureGroup().addTo(map);

    path_markers = L.featureGroup().addTo(map);
    point_markers = L.featureGroup().addTo(map);
    started_path_group = L.featureGroup().addTo(map);

    var mapBounds = new L.LatLngBounds(
        map.unproject([0, img[1]], mapMaxZoom),
        map.unproject([img[0], 0], mapMaxZoom)
    );

    map.setMaxBounds(mapBounds);

    L.tileLayer('http://localhost/img/map/{z}/{x}/{y}.png', {
        minZoom: mapMinZoom,
        maxZoom: mapMaxZoom,
        continuousWorld: true,
        bounds: mapBounds,
        noWrap: true,
        reuseTiles: true
    }).addTo(map);

    // minimap =======================================================================
    var minimap = new L.TileLayer('/img/map/{z}/{x}/{y}.png', {
        minZoom: 0,
        maxZoom: mapMaxZoom,
        bounds: mapBounds,
        reuseTiles: true,
        continuousWorld: true,
        //bounds: mapBounds
    });
    new L.Control.MiniMap(minimap, {
        toggleDisplay: true,
        height: 200,
        position: 'bottomleft'
    }).addTo(map);

    // ===================================================================================
    //map.panBy([1, 0]);
    $.ajaxSetup({cache: true});

    // info box ===========================================================================
    infobox = L.control();

    infobox.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'infobox');
        updateInfobox();
        return this._div;
    };

    infobox.addTo(map);

    // ====================================================================================
    map.on('click', clickOnMap);

    map.tap.enable();

    map.on('moveend', loadItems);

    popup = L.popup().setLatLng([0, 0]).addTo(map);
    map.closePopup(popup);

}

function clickOnMap(e) {
    var coord = calculateHexCoord(e.latlng);
    placeHighlightHex(coord.x, coord.y);
    getHexData(coord.x, coord.y);
    started_path_group.clearLayers();
}

function clickOnCity(e) {
    var coord = calculateHexCoord(e.latlng);
    placeHighlightHex(coord.x, coord.y);
    var data = e.target.city_data;
    updateInfobox(1, data);
    started_path_group.clearLayers();

    map.closePopup(popup);
    e.target.closePopup();

    // if it is not the user's city
    if(army_selected != 0 && army_attacked == 0 && city_attacked == 0){
        e.target.openPopup();
    }
    if (enemy_army_in_the_way !== 0) {
        e.target.closePopup();
    }
}

function clickOnArmy(e) {
    var coord = calculateHexCoord(e.latlng);
    placeHighlightHex(coord.x, coord.y);
    var data = e.target.army_data;
    started_path_group.clearLayers();

    map.closePopup(popup);

    // if there's a path
    if (typeof data.army.path != 'undefined' && data.army.path.length > 0) {
        //console.log(data.army.path);
        drawPath(data.army.path, started_path_group);

        var time = data.army.path[data.army.path.length - 1].finished_at;
        time = time.replace(/-/g, '/');

        e.target.setPopupContent("hátralévő idő: <span id='countdown'></span>");

        $('#countdown').countdown(time, function (event) {
            $(this).html(event.strftime('%H:%M:%S'));
        });
    }

    // if it's the user's army
    if (typeof data.army.unit1 != 'undefined') {
        // then check if the user has selected an army before
        if (army_selected != 0 && army_selected != data.army_id) {
            e.target.closePopup();
        }
    } else { // if it's NOT the user's army
        e.target.closePopup();
        // then check if the user has selected an army before
        if (army_selected != 0 && army_selected != data.army_id && army_attacked == 0) {
            e.target.openPopup();
        }
        if (enemy_army_in_the_way !== 0) {
            e.target.closePopup();
        }

        if (army_attacked == data.army_id) {
            e.target.openPopup();
        }
    }

    if (data.city > 0) { // if the army is in a city
        var city_leaflet_id = cities_hash[data.city];
        var city = city_markers.getLayer(city_leaflet_id);
        data.city_name = city.city_data.city_name;
        data.user_name = city.city_data.user_name;
        data.nation = city.city_data.nation;
        updateInfobox(3, data);
    }

    updateInfobox(2, data);

}

function clickOnPathPoint(e) {
    clickOnMap(e);
    calculatePathTime();
}

function selectArmy(army_id) {
    army_selected = army_id;

    var e = army_markers.getLayer(armies_hash[army_id]);

    e.setPopupContent('<button type="button" class="btn btn-xs btn-danger" onclick="cancelPath(' + army_id + ')">kijelölés visszavonása</button>').update();
    e.closePopup();

    map.on('click', addPathPointPopup);


    path_markers.clearLayers();
    point_markers.clearLayers();

    if (typeof highlightMarker != 'undefined') {
        map.removeLayer(highlightMarker);
        highlightMarker = undefined;
    }
    armycoord = calculateHexCoord(e._latlng);

    points = [];
    path = [];

    points.push(armycoord);

    tx = (armycoord.x * HEX_SIDE * 1.5) + 36;
    ty = (armycoord.y * HEX_SCALED_HEIGHT + (armycoord.x % 2) * HEX_SCALED_HEIGHT / 2) + 36;

    if (typeof highlightMarkerFrom != 'undefined') {
        highlightMarkerFrom.setLatLng(rc.unproject([tx + margin_x, ty + margin_y]));
        //map.removeLayer(highlightMarker);
    } else {
        highlightMarkerFrom = L.marker(rc.unproject([tx + margin_x, ty + margin_y]), {
            icon: window["highlight" + map.getZoom()],
            zIndexOffset: highlight_zindex,
            clickable: false
        }).addTo(map);
    }
}

function addPathPointPopup(e) {
    if (army_attacked == 0) {
        var coord = calculateHexCoord(e.latlng);
        popup.setLatLng(highlightMarker.getLatLng());
        popup.setContent('<button type="button" class="btn btn-xs btn-info" ' +
            'onclick="addPathPoint(' + coord.x + ',' + coord.y + ')">pont hozzáadása az útvonalhoz</button>');
        popup.update();
        map.openPopup(popup);
    }
}

function addPathPoint(x, y) {
    //var coord = calculateHexCoord(e.latlng);
    var coord = {x: x, y: y};
    points.push(coord);

    map.closePopup();
    path_markers.clearLayers();
    point_markers.clearLayers();

    path = [];

    if (typeof highlightMarker != 'undefined') {
        map.removeLayer(highlightMarker);
        highlightMarker = undefined;
    }
    createPath();
    path.push(coord);
    drawPathPoints();
    drawPath(path, path_markers);
}

function createPath() {
    var l = points.length;
    for (var i = 0; i < l - 1; i++) {
        var a = offsetToCube(points[i]);
        var b = offsetToCube(points[i + 1]);
        path = path.concat(calculateLine(a, b));
    }
}

function drawPathPoints() {
    l = points.length;
    for (var i = 1; i < l; i++) {
        tx = (points[i].x * HEX_SIDE * 1.5) + 36;
        ty = (points[i].y * HEX_SCALED_HEIGHT + (points[i].x % 2) * HEX_SCALED_HEIGHT / 2) + 36;

        pointMarker = L.marker(rc.unproject([tx + margin_x, ty + margin_y]), {
            number: i,
            icon: window["green" + map.getZoom()],
            zIndexOffset: path_point_zindex,
            clickable: true,
            draggable: true,
        })
            .addTo(map)
            .on('drag', dragPathPoint)
            .on('click', clickOnPathPoint);

        pointMarker
            .bindPopup(
            '<i class="fa fa-cog fa-spin fa-2x fa-fw margin-bottom"></i>' +
            '<br><button type="button" class="btn btn-xs btn-danger" ' +
            'onclick="deletePathPoint(' + i + ')">pont törlése</button>').closePopup();

        army_markers.eachLayer(function (army_layer) {
            if (army_layer._latlng.lat === pointMarker._latlng.lat
                && army_layer._latlng.lng === pointMarker._latlng.lng) {
                if (typeof army_layer.army_data.army.unit1 === 'undefined') {
                    pointMarker.setIcon(window["red" + map.getZoom()]);
                }
            }
        });

        city_markers.eachLayer(function (city_layer) {
            if (city_layer._latlng.lat === pointMarker._latlng.lat
                && city_layer._latlng.lng === pointMarker._latlng.lng) {
                if (city_layer.city_data.owned == false) {
                    pointMarker.setIcon(window["red" + map.getZoom()]);
                }
            }
        });

        pointMarker.on('dragend', function (e) {

            path.push(calculateHexCoord(e.target._latlng));

            e.target.closePopup();
            //calculatePathTime();

            e.target.setIcon(window["green" + map.getZoom()]);

            army_markers.eachLayer(function (army_layer) {
                if (army_layer._latlng.lat === e.target._latlng.lat
                    && army_layer._latlng.lng === e.target._latlng.lng) {

                    if (typeof army_layer.army_data.army.unit1 !== 'undefined') {
                        friendly_army_in_the_way = army_layer.army_data.army_id;
                    }

                    if (typeof army_layer.army_data.army.unit1 === 'undefined') {
                        enemy_army_in_the_way = army_layer.army_data.army_id;
                        e.target.setIcon(window["red" + map.getZoom()]);
                    }
                }
            });

            city_markers.eachLayer(function (city_layer) {
                if (city_layer._latlng.lat === e.target._latlng.lat
                    && city_layer._latlng.lng === e.target._latlng.lng) {

                    if (city_layer.city_data.owned == true) {
                        friendly_city_in_the_way = city_layer.city_data.id;
                    }

                    if (city_layer.city_data.owned == false) {
                        console.log("vmi");

                        enemy_city_in_the_way = city_layer.city_data.id;
                        e.target.setIcon(window["red" + map.getZoom()]);
                    }
                }
            });
        });

        point_markers.addLayer(pointMarker);
    }

    //if(army_attacked != 0){
    //    pointMarker.setIcon(window["red" + map.getZoom()]);
    //    pointMarker.update();
    //}
    pointMarker.closePopup();
    //calculatePathTime();
}

function drawPath(path, layerGroup) {
    enemy_army_in_the_way = 0;
    friendly_army_in_the_way = 0;

    l = path.length;
    for (var i = 0; i < l; i++) {
        tx = (path[i].x * HEX_SIDE * 1.5) + 36;
        ty = (path[i].y * HEX_SCALED_HEIGHT + (path[i].x % 2) * HEX_SCALED_HEIGHT / 2) + 36;
        var coord = rc.unproject([tx + margin_x, ty + margin_y]);

        var pathMarker = L.marker(coord, {
            number: i,
            icon: window["brush" + map.getZoom()],
            zIndexOffset: path_zindex,
            clickable: false,
        }).addTo(map);

        if (i > 0) {
            army_markers.eachLayer(function (army_layer) {
                if (army_layer._latlng.lat === coord.lat
                    && army_layer._latlng.lng === coord.lng) {

                    if (typeof army_layer.army_data.army.unit1 !== 'undefined') {
                        friendly_army_in_the_way = army_layer.army_data.army_id;
                    }

                    if (typeof army_layer.army_data.army.unit1 === 'undefined') {
                        pathMarker.setIcon(window["red" + map.getZoom()]);
                        enemy_army_in_the_way = army_layer.army_data.army_id;
                    }

                }
            });

            city_markers.eachLayer(function (city_layer) {
                if (city_layer._latlng.lat === coord.lat
                    && city_layer._latlng.lng === coord.lng) {
                    if (city_layer.city_data.owned == true) {
                        friendly_city_in_the_way = city_layer.city_data.id;
                    }

                    if (city_layer.city_data.owned == false) {
                        pathMarker.setIcon(window["red" + map.getZoom()]);
                        enemy_city_in_the_way = city_layer.city_data.id;
                    }

                }
            });
        }
        layerGroup.addLayer(pathMarker);

    }

}

function dragPathPoint(e) {
    if (typeof highlightMarker != 'undefined') {
        map.removeLayer(highlightMarker);
        highlightMarker = undefined;
    }

    var coord = calculateHexCoord(e.target._latlng);

    tx = (coord.x * HEX_SIDE * 1.5) + 36;
    ty = (coord.y * HEX_SCALED_HEIGHT + (coord.x % 2) * HEX_SCALED_HEIGHT / 2) + 36;

    e.target.setLatLng(rc.unproject([tx + margin_x, ty + margin_y]));

    points[e.target.options.number] = coord;
    path = [];

    path_markers.clearLayers();

    createPath();
    drawPath(path, path_markers);
}

function deletePathPoint(n) {
    if (army_attacked != 0 && n == points.length - 1) {
        army_attacked = 0;
    }
    if (city_attacked != 0 && n == points.length - 1) {
        city_attacked = 0;
    }

    points.splice(n, 1);
    path = [];

    path_markers.clearLayers();
    point_markers.clearLayers();

    if (typeof highlightMarker != 'undefined') {
        map.removeLayer(highlightMarker);
        highlightMarker = undefined;
    }


    createPath();
    path.push(points[points.length - 1]);
    drawPath(path, path_markers);
    drawPathPoints();
}

function moveToHex(path) {
    $.post("/map/move_army", {_token: $('meta[name=_token]').attr('content'), path: path, army:army_selected}, function (data) {
        //map.contextmenu.setDisabled(0, true);
        cancelPath(data);
        refreshMap();
    });

    map.closePopup();

}

function cancelPath(army_id) {
    army_selected = 0;
    army_attacked = 0;
    city_attacked = 0;
    friendly_army_in_the_way = 0;
    enemy_army_in_the_way = 0;

    map.off('click', addPathPointPopup);
    var e = army_markers.getLayer(armies_hash[army_id]);
    e.setPopupContent(
        '<button type="button" class="btn btn-xs btn-success army-select" ' +
        'onclick="selectArmy(' + army_id + ')">' +
        'sereg áthelyezése</button>').update();
    e.closePopup();

    points = [];
    path = [];

    path_markers.clearLayers();
    point_markers.clearLayers();

    if (typeof highlightMarkerFrom != 'undefined') {
        map.removeLayer(highlightMarkerFrom);
        highlightMarkerFrom = undefined;
    }

    if (typeof highlightMarker != 'undefined') {
        map.removeLayer(highlightMarker);
        highlightMarker = undefined;
    }

    if (typeof attackMarker != 'undefined') {
        map.removeLayer(attackMarker);
        attackMarker = undefined;
    }
}

function attackArmy(id) {
    army_attacked = id;

    var attacked_army = army_markers.getLayer(armies_hash[id]);

    attacked_army.closePopup();

    //attacked_army.setPopupContent('támadás');

    addPathPoint(attacked_army.army_data.x, attacked_army.army_data.y);

    //placeAttackMarker(attacked_army.army_data.x, attacked_army.army_data.y);
}

function attackCity(id){
    city_attacked = id;

    var attacked_city = city_markers.getLayer(cities_hash[id]);
    map.closePopup();

    //attacked_army.setPopupContent('támadás');

    addPathPoint(attacked_city.city_data.x, attacked_city.city_data.y);

    //placeAttackMarker(attacked_army.army_data.x, attacked_army.army_data.y);
}

function calculatePathTime() {
    $.post("/map/path_price", {'_token': $('meta[name=_token]').attr('content'), path: path}, function (data) {
        var sec_num = parseInt(data, 10);
        var hours = Math.floor(sec_num / 3600);
        var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
        var seconds = sec_num - (hours * 3600) - (minutes * 60);

        if (hours < 10) {
            hours = "0" + hours;
        }
        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        if (seconds < 10) {
            seconds = "0" + seconds;
        }
        var time = hours + ':' + minutes + ':' + seconds;

        var warning = "";

        if (friendly_army_in_the_way !== 0 || enemy_army_in_the_way !== 0
            || friendly_city_in_the_way !== 0 || enemy_city_in_the_way !== 0
        ) {
            warning =
                "<b>Egy hadsereg/város blokkolja az utat! </b> <br>" +
                "Ha ez egy ellenséges sereg/város, akkor <br>" +
                "a találkozáskor csata/ostrom lesz. <br>" +
                "Ha ez a sereg/város a tiéd, akkor  <br>" +
                "a mozgó sereg csak megáll<br>"
        }

        point_markers.eachLayer(function (layer) {

            layer.setPopupContent(
                "út hossza: " + (parseInt(path.length, 10) - 1) + " hex<br>" +
                "út ideje: " + time + "<br>" + warning +
                '<button type="button" class="btn btn-xs btn-success" onclick="moveToHex(path)">' +
                'mehet</button> ' +
                '<button type="button" class="btn btn-xs btn-danger" ' +
                'onclick="deletePathPoint(' + layer.options.number + ')">pont törlése</button>'
            );
        });
    });
}

function clearMarkers() {
    city_markers.clearLayers();
    army_markers.clearLayers();

    path_markers.clearLayers();
    point_markers.clearLayers();
    started_path_group.clearLayers();

    if (typeof highlightMarker != 'undefined') {
        map.removeLayer(highlightMarker);
        highlightMarker = undefined;
    }
    if (typeof highlightMarkerFrom != 'undefined') {
        map.removeLayer(highlightMarkerFrom);
        highlightMarkerFrom = undefined;
    }
    if (typeof attackMarker != 'undefined') {
        map.removeLayer(attackMarker);
        attackMarker = undefined;
    }
}

function refreshMap() {
    city_markers.clearLayers();
    army_markers.clearLayers();

    path_markers.clearLayers();
    point_markers.clearLayers();
    started_path_group.clearLayers();

    cities_hash = [];
    armies_hash = [];

    if (typeof highlightMarker != 'undefined') {
        map.removeLayer(highlightMarker);
        highlightMarker = undefined;
    }
    if (typeof highlightMarkerFrom != 'undefined') {
        map.removeLayer(highlightMarkerFrom);
        highlightMarkerFrom = undefined;
    }
    if (typeof attackMarker != 'undefined') {
        map.removeLayer(attackMarker);
        attackMarker = undefined;
    }


    updateInfobox(-1, false);

    loadItems();
}

function throttle(callback, limit) {

    var wait = false;                 // Initially, we're not waiting
    return function () {              // We return a throttled function
        if (!wait) {                  // If we're not waiting
            callback.call();          // Execute users function
            wait = true;              // Prevent future invocations
            setTimeout(function () {  // After a period of time
                wait = false;         // And allow future invocations
            }, limit);
        }
    }
}

function loadItems() {

    var bound = map.getBounds();

    var nw = calculateHexCoord(bound.getNorthWest());
    //console.log(nw);
    //if(same_view.x == nw.x && same_view.y == nw.y){
    //    return false;
    //}
    same_view = nw;
    //var ne = calculateHexCoord(bound.getNorthEast());
    var se = calculateHexCoord(bound.getSouthEast());
    //var sw = calculateHexCoord(bound.getSouthWest());

    //console.log('ne: x: ' + ne.x + ', y: ' + ne.y + ', nw: x: ' + nw.x + ', y: ' + nw.y + ', se: x: ' + se.x + ', y: ' + se.y + ', sw: x: ' + sw.x + ', y: ' + sw.y);

    var x1 = nw.x;
    var y1 = nw.y;

    var x2 = se.x;
    var y2 = se.y;

    if (x1 < 0 && y1 < 0 && x2 > 40 && y2 > 40) {
        return false;
    }

    //console.log(x1 + ", " + x2 + ", " + y1 + ", " + y2);

    $.getJSON("/map/get_data", {x1: x1, y1: y1, x2: x2, y2: y2}, function (data) {
        if (data.cities.length > 0) {
            placeCities(data.cities);
        }

        if (data.armies.length > 0) {
            placeArmies(data.armies);
        }
    });
    //}
}

function placeCities(cities) {
    for (var i in cities) {
        if (typeof cities_hash[cities[i].id] != 'undefined') {
            continue;
        }
        tx = (cities[i].x * HEX_SIDE * 1.5) + 36;
        ty = (cities[i].y * HEX_SCALED_HEIGHT + (cities[i].x % 2) * HEX_SCALED_HEIGHT / 2) + 36;

        var city_marker = L.marker(rc.unproject([tx + margin_x, ty + margin_y]), {
            icon: window["city" + map.getZoom()],
            zIndexOffset: cities_zindex,
        }).addTo(map);

        if(cities[i].owned == false){
            city_marker.bindPopup(
                '<button type="button" class="btn btn-xs btn-danger"' +
                ' onclick="attackCity(' + cities[i].id + ')">' +
                'ostrom</button>');
        } else {
            city_marker.bindPopup(
                '<button type="button" class="btn btn-xs btn-success"' +
                ' onclick="addPathPoint(' + cities[i].x + ',' + cities[i].y + ')">' +
                'A városba</button>');
        }

        cities_hash[cities[i].id] = city_marker._leaflet_id;
        city_marker.city_data = cities[i];

        city_markers.addLayer(city_marker);

        city_marker.on('click', function (e) {
            clickOnCity(e);
        });
    }
}

function placeArmies(armies) {
    for (var i in armies) {
        if (typeof armies_hash[armies[i].army_id] != 'undefined') {
            continue;
        }
        tx = (armies[i].x * HEX_SIDE * 1.5) + 36;
        ty = (armies[i].y * HEX_SCALED_HEIGHT + (armies[i].x % 2) * HEX_SCALED_HEIGHT / 2) + 36;

        var army_marker = L.marker(rc.unproject([tx + margin_x, ty + margin_y]), {
            icon: window["army" + map.getZoom()],
            zIndexOffset: armies_zindex,
        }).addTo(map);

        if (typeof armies[i].army.unit1 != 'undefined' && armies[i].army.general == 1) {
            army_marker.bindPopup(
                '<button type="button" class="btn btn-xs btn-success army-select"' +
                ' onclick="selectArmy(' + armies[i].army.id + ')">' +
                'sereg áthelyezése</button>');
        } else if (typeof armies[i].army.unit1 != 'undefined' && armies[i].army.general == 0){
            army_marker.bindPopup(
                'A sereg nem mozgatható, <br>mert nincs tábornoka');
        } else if (armies[i].city > 0) {
            army_marker.bindPopup(
                '<button type="button" class="btn btn-xs btn-danger"' +
                ' onclick="attackCity(' + armies[i].city + ')">' +
                'ostrom</button>');
        } else {
            army_marker.bindPopup(
                '<button type="button" class="btn btn-xs btn-danger"' +
                ' onclick="attackArmy(' + armies[i].army_id + ')">' +
                'sereg megtámadása</button>');
        }

        armies_hash[armies[i].army_id] = army_marker._leaflet_id;

        armies_coordinates.push(army_marker._latlng);

        army_marker.army_data = armies[i];

        army_markers.addLayer(army_marker);

        army_marker.on('click', function (e) {
            clickOnArmy(e);
        });
    }

}


function updateInfobox(type, data) {
    if (data) {
        var info = '<b>Koordináták</b><br>' +
            '<b>x: </b>' + data.x + '<br>' +
            '<b>y: </b>' + data.y;

        if (type == 0) {
            info += updateInfoboxHex(data);
        }

        if (type == 1) {
            info += updateInfoboxCity(data);
        }

        if (type == 2) {
            info += updateInfoboxArmy(data);
        }

        if (type == 3) {
            info += updateInfoboxCity(data);
            info += updateInfoboxArmy(data);
        }
    }
    infobox._div.innerHTML = '<h4>Információk</h4>' + (data ? info : 'Jelölj ki egy hexet');
}

function switchNation(nation) {
    switch (parseInt(nation)) {
        case 0:
            return '';
            break;
        case 1:
            return 'római';
            break;
        case 2:
            return 'görög';
            break;
        case 3:
            return 'germán';
            break;
        case 4:
            return 'szarmata';
            break;
    }
}

function switchType(type) {
    switch (type) {
        case 1:
            return 'mély víz';
            break;
        case 2:
            return 'homokos part';
            break;
        case 3:
            return 'füves rét';
            break;
        case 4:
            return 'fenyőerdő';
            break;
        case 5:
            return 'hómező';
            break;
        case 6:
            return 'dombvidék';
            break;
        case 7:
            return 'havas dombok';
            break;
        case 8:
            return 'hegy';
            break;
        case 9:
            return 'sekély víz';
            break;
        case 10:
            return 'jég';
            break;
        case 11:
            return 'mocsár';
            break;
    }
}

function updateInfoboxArmy(data) {
    var info = updateInfoboxHex(data) +
        '<br><br><b>Hadsereg</b><br>' +
        '<b>Tulajdonos:</b> ' + data.army.user_name +
        '<br><b>Nép:</b> ' + switchNation(data.army.nation);

    if (typeof data.army.unit1 != 'undefined') {
        info += '<br><b>Tábornok:</b> ' + (data.army.general ? 'van' : 'nincs') +
            '<br><b>Élelmiszer:</b> ' + data.army.food +
            '<br><b>Egységek</b><br>' +
            'könnyűgyalogos: ' + data.army.unit1 + '<br>' +
            'nehézgyalogos: ' + data.army.unit2 + '<br>' +
            'pikás: ' + data.army.unit3 + '<br>' +
            'könnyűlovas: ' + data.army.unit4 + '<br>' +
            'nehézlovas: ' + data.army.unit5 + '<br>' +
            'íjász: ' + data.army.unit6 + '<br>' +
            'katapult: ' + data.army.unit7;
    }

    return info;
}

function updateInfoboxCity(data) {
    return '<br><br> <b>Város</b><br> ' +
        '<b>Név:</b> ' + data.city_name + '<br>' +
        '<b>Tulajdonos:</b> ' + data.user_name + '<br>' +
        '<b>Nép: </b>' + switchNation(data.nation);
}

function updateInfoboxHex(data) {
    return (data.city ? '' : '<br><b>Típus: </b>' + switchType(parseInt(data.layer1)) +
    (data.hex_owner ? '<br>' +
    '<b>Tulajdonos: </b>' + data.user_name : ''));

}

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
    } else {
        highlightMarker = L.marker(rc.unproject([tx + margin_x, ty + margin_y]), {
            icon: window["highlight" + map.getZoom()],
            zIndexOffset: highlight_zindex,
            clickable: false,
        }).addTo(map);
    }
}

function getHexData(x, y) {
    if (x < 0 || y < 0 || x > 39 || y > 39) {
        return false;
    }
    $.getJSON("/map/get_hex_data", {x: x, y: y}, function (data) {

        data['x'] = x;
        data['y'] = y;

        updateInfobox(0, data
        );

        //if (typeof data.path != 'undefined') {
        //    var started_path = [{x: x, y: y}];
        //    started_path = started_path.concat(data.path);
        //    drawPath(started_path, started_path_group);
        //
        //    army_markers.eachLayer(function (marker) {
        //        if (marker.army.id == data.army_id) {
        //
        //
        //            marker.army = data;
        //            marker.unbindPopup();
        //
        //            if (typeof data.path_time != 'undefined') {
        //                marker.options.contextmenuItems[0].disabled = true;
        //
        //                marker.bindPopup(
        //                    "hátralévő idő: <span id='countdown'></span>",
        //                    {offset: new L.Point(0, -30)}).openPopup();
        //
        //            } else {
        //                marker.options.contextmenuItems[0].disabled = false;
        //
        //            }
        //        }
        //    });
        //
        //    $('#countdown').countdown(data.path_time, function (event) {
        //        $(this).html(event.strftime('%H:%M:%S'));
        //    });
        //}

    });
}

// TODO garrison army in city
// TODO moving units between armies and cities
function checkNeighbourArmy(army_id){

}






function offsetToCube(hex) {
    var x = hex.x;
    var z = hex.y - (hex.x - (hex.x & 1)) / 2;
    var y = -x - z;

    return {x: x, y: y, z: z};
}

function cubeToOffset(hex) {
    var x = hex.x;
    var y = hex.z + (hex.x - (hex.x & 1)) / 2;
    return {x: x, y: y};
}

function cubeDistance(a, b) {
    return (Math.abs(a.x - b.x) + Math.abs(a.y - b.y) + Math.abs(a.z - b.z)) / 2;
}

function cubeLerp(a, b, t) {
    return {
        x: (a.x + (b.x - a.x) * t),
        y: (a.y + (b.y - a.y) * t),
        z: (a.z + (b.z - a.z) * t)
    }
}


function calculateLine(a, b) {
    var N = cubeDistance(a, b);
    var results = [];
    for (var i = 0; i < N; i++) {
        results.push(cubeToOffset(cubeRound(cubeLerp(a, b, 1.0 / N * i))));
    }
    return results;
}

/**
 * rounds a hex in cube coordinates
 * http://www.redblobgames.com/grids/hexagons/#rounding
 */
function cubeRound(h) {
    var rx = Math.round(h.x);
    var ry = Math.round(h.y);
    var rz = Math.round(h.z);

    var x_diff = Math.abs(rx - h.x);
    var y_diff = Math.abs(ry - h.y);
    var z_diff = Math.abs(rz - h.z);

    if (x_diff > y_diff && x_diff > z_diff) {
        rx = -ry - rz
    } else if (y_diff > z_diff) {
        ry = -rx - rz
    } else {
        rz = -rx - ry
    }

    return {x: rx, y: ry, z: rz}
}


//############################################################################################
//#################                    EASY BUTTON                     #######################
//#################  https://github.com/CliffCloud/Leaflet.EasyButton  #######################
//############################################################################################
(function () {

// This is for grouping buttons into a bar
// takes an array of `L.easyButton`s and
// then the usual `.addTo(map)`
    L.Control.EasyBar = L.Control.extend({

        options: {
            position: 'topleft',  // part of leaflet's defaults
            id: null,       // an id to tag the Bar with
            leafletClasses: true        // use leaflet classes?
        },


        initialize: function (buttons, options) {

            if (options) {
                L.Util.setOptions(this, options);
            }

            this._buildContainer();
            this._buttons = [];

            for (var i = 0; i < buttons.length; i++) {
                buttons[i]._bar = this;
                buttons[i]._container = buttons[i].button;
                this._buttons.push(buttons[i]);
                this.container.appendChild(buttons[i].button);
            }

        },


        _buildContainer: function () {
            this._container = this.container = L.DomUtil.create('div', '');
            this.options.leafletClasses && L.DomUtil.addClass(this.container, 'leaflet-bar easy-button-container leaflet-control');
            this.options.id && (this.container.id = this.options.id);
        },


        enable: function () {
            L.DomUtil.addClass(this.container, 'enabled');
            L.DomUtil.removeClass(this.container, 'disabled');
            this.container.setAttribute('aria-hidden', 'false');
            return this;
        },


        disable: function () {
            L.DomUtil.addClass(this.container, 'disabled');
            L.DomUtil.removeClass(this.container, 'enabled');
            this.container.setAttribute('aria-hidden', 'true');
            return this;
        },


        onAdd: function () {
            return this.container;
        },

        addTo: function (map) {
            this._map = map;

            for (var i = 0; i < this._buttons.length; i++) {
                this._buttons[i]._map = map;
            }

            var container = this._container = this.onAdd(map),
                pos = this.getPosition(),
                corner = map._controlCorners[pos];

            L.DomUtil.addClass(container, 'leaflet-control');

            if (pos.indexOf('bottom') !== -1) {
                corner.insertBefore(container, corner.firstChild);
            } else {
                corner.appendChild(container);
            }

            return this;
        }

    });

    L.easyBar = function () {
        var args = [L.Control.EasyBar];
        for (var i = 0; i < arguments.length; i++) {
            args.push(arguments[i]);
        }
        return new (Function.prototype.bind.apply(L.Control.EasyBar, args));
    };

// L.EasyButton is the actual buttons
// can be called without being grouped into a bar
    L.Control.EasyButton = L.Control.extend({

        options: {
            position: 'topleft',       // part of leaflet's defaults

            id: null,            // an id to tag the button with

            type: 'replace',       // [(replace|animate)]
                                   // replace swaps out elements
                                   // animate changes classes with all elements inserted

            states: [],              // state names look like this
                                     // {
                                     //   stateName: 'untracked',
                                     //   onClick: function(){ handle_nav_manually(); };
                                     //   title: 'click to make inactive',
                                     //   icon: 'fa-circle',    // wrapped with <a>
                                     // }

            leafletClasses: true      // use leaflet styles for the button
        },


        initialize: function (icon, onClick, title, id) {

            // clear the states manually
            this.options.states = [];

            // add id to options
            if (id != null) {
                this.options.id = id;
            }

            // storage between state functions
            this.storage = {};

            // is the last item an object?
            if (typeof arguments[arguments.length - 1] === 'object') {

                // if so, it should be the options
                L.Util.setOptions(this, arguments[arguments.length - 1]);
            }

            // if there aren't any states in options
            // use the early params
            if (this.options.states.length === 0 &&
                typeof icon === 'string' &&
                typeof onClick === 'function') {

                // turn the options object into a state
                this.options.states.push({
                    icon: icon,
                    onClick: onClick,
                    title: typeof title === 'string' ? title : ''
                });
            }

            // curate and move user's states into
            // the _states for internal use
            this._states = [];

            for (var i = 0; i < this.options.states.length; i++) {
                this._states.push(new State(this.options.states[i], this));
            }

            this._buildButton();

            this._activateState(this._states[0]);

        },

        _buildButton: function () {

            this.button = L.DomUtil.create('button', '');

            if (this.options.id) {
                this.button.id = this.options.id;
            }

            if (this.options.leafletClasses) {
                L.DomUtil.addClass(this.button, 'easy-button-button leaflet-bar-part');
            }

            // don't let double clicks get to the map
            L.DomEvent.addListener(this.button, 'dblclick', L.DomEvent.stop);

            // take care of normal clicks
            L.DomEvent.addListener(this.button, 'click', function (e) {
                L.DomEvent.stop(e);
                this._currentState.onClick(this, this._map ? this._map : null);
                this._map.getContainer().focus();
            }, this);

            // prep the contents of the control
            if (this.options.type == 'replace') {
                this.button.appendChild(this._currentState.icon);
            } else {
                for (var i = 0; i < this._states.length; i++) {
                    this.button.appendChild(this._states[i].icon);
                }
            }
        },


        _currentState: {
            // placeholder content
            stateName: 'unnamed',
            icon: (function () {
                return document.createElement('span');
            })()
        },


        _states: null, // populated on init


        state: function (newState) {

            // activate by name
            if (typeof newState == 'string') {

                this._activateStateNamed(newState);

                // activate by index
            } else if (typeof newState == 'number') {

                this._activateState(this._states[newState]);
            }

            return this;
        },


        _activateStateNamed: function (stateName) {
            for (var i = 0; i < this._states.length; i++) {
                if (this._states[i].stateName == stateName) {
                    this._activateState(this._states[i]);
                }
            }
        },

        _activateState: function (newState) {

            if (newState === this._currentState) {

                // don't touch the dom if it'll just be the same after
                return;

            } else {

                // swap out elements... if you're into that kind of thing
                if (this.options.type == 'replace') {
                    this.button.appendChild(newState.icon);
                    this.button.removeChild(this._currentState.icon);
                }

                if (newState.title) {
                    this.button.title = newState.title;
                } else {
                    this.button.removeAttribute('title');
                }

                // update classes for animations
                for (var i = 0; i < this._states.length; i++) {
                    L.DomUtil.removeClass(this._states[i].icon, this._currentState.stateName + '-active');
                    L.DomUtil.addClass(this._states[i].icon, newState.stateName + '-active');
                }

                // update classes for animations
                L.DomUtil.removeClass(this.button, this._currentState.stateName + '-active');
                L.DomUtil.addClass(this.button, newState.stateName + '-active');

                // update the record
                this._currentState = newState;

            }
        },


        enable: function () {
            L.DomUtil.addClass(this.button, 'enabled');
            L.DomUtil.removeClass(this.button, 'disabled');
            this.button.setAttribute('aria-hidden', 'false');
            return this;
        },


        disable: function () {
            L.DomUtil.addClass(this.button, 'disabled');
            L.DomUtil.removeClass(this.button, 'enabled');
            this.button.setAttribute('aria-hidden', 'true');
            return this;
        },


        removeFrom: function (map) {

            this._container.parentNode.removeChild(this._container);
            this._map = null;

            return this;
        },

        onAdd: function () {
            var containerObj = L.easyBar([this], {
                position: this.options.position,
                leafletClasses: this.options.leafletClasses
            });
            this._container = containerObj.container;
            return this._container;
        }


    });


    L.easyButton = function (/* args will pass automatically */) {
        var args = Array.prototype.concat.apply([L.Control.EasyButton], arguments);
        return new (Function.prototype.bind.apply(L.Control.EasyButton, args));
    };

    /*************************
     *
     * util functions
     *
     *************************/

// constructor for states so only curated
// states end up getting called
    function State(template, easyButton) {

        this.title = template.title;
        this.stateName = template.stateName ? template.stateName : 'unnamed-state';

        // build the wrapper
        this.icon = L.DomUtil.create('span', '');

        L.DomUtil.addClass(this.icon, 'button-state state-' + this.stateName.replace(/(^\s*|\s*$)/g, ''));
        this.icon.innerHTML = buildIcon(template.icon);
        this.onClick = L.Util.bind(template.onClick ? template.onClick : function () {
        }, easyButton);
    }

    function buildIcon(ambiguousIconString) {

        var tmpIcon;

        // does this look like html? (i.e. not a class)
        if (ambiguousIconString.match(/[&;=<>"']/)) {

            // if so, the user should have put in html
            // so move forward as such
            tmpIcon = ambiguousIconString;

            // then it wasn't html, so
            // it's a class list, figure out what kind
        } else {
            ambiguousIconString = ambiguousIconString.replace(/(^\s*|\s*$)/g, '');
            tmpIcon = L.DomUtil.create('span', '');

            if (ambiguousIconString.indexOf('fa-') === 0) {
                L.DomUtil.addClass(tmpIcon, 'fa ' + ambiguousIconString)
            } else if (ambiguousIconString.indexOf('glyphicon-') === 0) {
                L.DomUtil.addClass(tmpIcon, 'glyphicon ' + ambiguousIconString)
            } else {
                L.DomUtil.addClass(tmpIcon, /*rollwithit*/ ambiguousIconString)
            }

            // make this a string so that it's easy to set innerHTML below
            tmpIcon = tmpIcon.outerHTML;
        }

        return tmpIcon;
    }

})();