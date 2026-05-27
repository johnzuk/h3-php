--TEST--
H3\H3DirectedEdge::getBoundary() Test
--EXTENSIONS--
h3
--INI--
serialize_precision=12
--FILE--
<?php
$edge = \H3\H3DirectedEdge::fromString('115283473fffffff');
$boundary = $edge->getBoundary();

var_dump(count($boundary->getVertices()));
var_dump($boundary->getVertices()[0]->getLat());
var_dump($boundary->getVertices()[0]->getLon());
var_dump($boundary->getVertices()[1]->getLat());
var_dump($boundary->getVertices()[1]->getLon());
?>
--EXPECT--
int(2)
float(37.4201286777)
float(-122.037734964)
float(37.3375560844)
float(-122.090428929)
