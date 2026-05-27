--TEST--
H3\H3Index::toGeoBoundary() Test
--EXTENSIONS--
h3
--FILE--
<?php
$geo = new \H3\LatLng(49.99185845731755, 36.24805297746707);
$h3 = \H3\H3Index::fromGeo($geo, 8);
$boundary = $h3->toGeoBoundary();

var_dump(count($boundary->getVertices()));
var_dump($boundary->getVertices()[0]->getLat());
var_dump($boundary->getVertices()[0]->getLon());
?>
--EXPECTF--
int(6)
float(%f)
float(%f)
