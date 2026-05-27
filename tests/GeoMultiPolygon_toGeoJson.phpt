--TEST--
H3\GeoMultiPolygon::toGeoJson() Test
--EXTENSIONS--
h3
--INI--
precision=12
--FILE--
<?php
$multiPolygon = \H3\h3_set_to_multi_polygon([
    new \H3\H3Index(0x872830828ffffff),
    new \H3\H3Index(0x87283082effffff),
    new \H3\H3Index(0x871196400ffffff),
]);

foreach ($multiPolygon->toGeoJson() as $i => $polygon) {
    var_dump($i);
    foreach ($polygon as $i => $boundary) {
        var_dump($i);
        foreach ($boundary as [$lon, $lat]) {
            var_dump("$lon,$lat");
        }
    }
}

$multiPolygon = \H3\h3_set_to_multi_polygon(\H3\H3Index::fromLong(0x85119643fffffff)->hexRing(3));

$geojson = [];

foreach ($multiPolygon->getPolygons() as $polygon) {
    $geojson_polygon = [];

    $geofence = [];

    $vertices = $polygon->getGeofence()->getVertices();

    foreach ($vertices as $coord) {
        $geofence[] = [$coord->getLon(), $coord->getLat()];
    }
    $geofence[] = [$vertices[0]->getLon(), $vertices[0]->getLat()];

    $geojson_polygon[] = $geofence;

    foreach ($polygon->getHoles() as $hole) {
        $geofence = [];
        foreach ($hole->getVertices() as $coord) {
            $geofence[] = [$coord->getLon(), $coord->getLat()];
        }
        $geofence[] = [$hole->getVertices()[0]->getLon(), $hole->getVertices()[0]->getLat()];
        $geojson_polygon[] = $geofence;
    }

    $geojson[] = $geojson_polygon;
}

var_dump(json_encode($multiPolygon->toGeoJson()) === json_encode($geojson));
?>
--EXPECTF--
int(0)
int(0)
string(%d) "-122.427088725,37.7840462226"
string(%d) "-122.434586108,37.7722673499"
string(%d) "-122.425769087,37.7617357339"
string(%d) "-122.409454632,37.7629818477"
string(%d) "-122.400639512,37.7524464748"
string(%d) "-122.384323562,37.7536888254"
string(%d) "-122.376819386,37.7654676843"
string(%d) "-122.385634554,37.7760042007"
string(%d) "-122.401953852,37.7747607145"
string(%d) "-122.410770923,37.7852934736"
string(%d) "-122.427088725,37.7840462226"
int(1)
int(0)
string(%d) "36.2748823485,49.9969225295"
string(%d) "36.2601642868,50.0045278169"
string(%d) "36.2435754674,49.9994712901"
string(%d) "36.2417084043,49.9868127514"
string(%d) "36.2564212305,49.9792093551"
string(%d) "36.273006355,49.9842626069"
string(%d) "36.2748823485,49.9969225295"
bool(true)
