<?php

function vertical_align ($text) {
	return vertical_align_start().$text.vertical_align_end();
}
function vertical_align_start () {
	return '
	<div style="display:table;width:100%;height:100%;">
		<div style="display:table-cell;vertical-align:middle;">
	';
}
function vertical_align_end () {
	return '
		</div>
	</div>
	';
}

function aasort (&$array, $key) {
	$sorter=array();
	$ret=array();
	reset($array);
	foreach ($array as $ii => $va) {
		$sorter[$ii]=$va[$key];
	}
	asort($sorter);
	foreach ($sorter as $ii => $va) {
		$ret[$ii]=$array[$ii];
	}
	$array=$ret;
}

function argi ($arg) {
	if (is_array($arg)) {
		if (!isset($arg["id"])) {
			return NULL;
		}
		return $arg["id"];
	}
	if (is_object($arg)) {
		return $arg->id;
	}
	return (int)$arg;
}
