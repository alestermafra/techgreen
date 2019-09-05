<?php

function _isset(&$var, $default = null) {
	if(isset($var)) {
		return $var;
	}
	return $default;
}


function pluralize(array &$var, $sing, $plu) {
	if(count($var) > 1) {
		return $plu;
	}
	return $sing;
}