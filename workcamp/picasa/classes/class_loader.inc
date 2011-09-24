<?php

function __autoload($class_name) {
	$path = dirname(__FILE__) . "/" . strtolower(substr($class_name, 0, strpos($class_name, "_"))) . "/";
	require_once($path . strtolower($class_name) . ".inc");
}