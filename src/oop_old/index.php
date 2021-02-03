<?php
use src\oop\Request;

$request = new Request();
$test = $request->query();

var_dump($test);