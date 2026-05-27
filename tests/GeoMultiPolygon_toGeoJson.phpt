--TEST--
H3\GeoMultiPolygon::toGeoJson() Test
--EXTENSIONS--
h3
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
string(%d) "-122.42708872508,37.784046222599"
string(%d) "-122.43458610785,37.772267349852"
string(%d) "-122.42576908738,37.761735733922"
string(%d) "-122.40945463242,37.762981847664"
string(%d) "-122.40063951171,37.752446474756"
string(%d) "-122.38432356238,37.753688825354"
string(%d) "-122.37681938644,37.765467684343"
string(%d) "-122.38563455404,37.776004200674"
string(%d) "-122.40195385158,37.77476071449"
string(%d) "-122.41077092288,37.785293473597"
string(%d) "-122.42708872508,37.784046222599"
int(1)
int(0)
string(%d) "36.274882348529,49.996922529545"
string(%d) "36.260164286791,50.004527816947"
string(%d) "36.24357546745,49.999471290108"
string(%d) "36.24170840428,49.986812751444"
string(%d) "36.256421230471,49.979209355065"
string(%d) "36.273006354997,49.98426260695"
string(%d) "36.274882348529,49.996922529545"
bool(true)
