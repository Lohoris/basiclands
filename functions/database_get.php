<?php

function get_user ($id) {
	$id=(int)$id;
	if ($ret=get_cache_ar($id,"user")) return $ret;
	$ret=get_complex("`user`","WHERE id=$id","*,UNIX_TIMESTAMP(last_access) AS last_access_unix,UNIX_TIMESTAMP(created_date) AS created_date_unix");
	if ($ret) register_cache($ret,"user");
	return $ret;	
}
function arget_user ($t) {
	if (is_array($t)) return $t;
	if ($ar=get_cache_ar($t,"user")) return $ar;
	$ar=get_user($t);
	if ($ar) register_cache($ar,"user");
	return $ar;
}
function get_user_by_email ($email) {
	$email=mysql_real_escape_string($email);
	return get_complex("`user`","WHERE email='$email'");
}

function get_language_by_name ($name) {
	$name=mysql_real_escape_string($name);
	return get_complex("language","WHERE name='$name'");
}
function get_language_by_code ($code) {
	$code=mysql_real_escape_string($code);
	return get_complex("language","WHERE code='$code'");
}
function get_languages () {
	return gets_complex("language","ORDER BY id ASC");
}

function get_set_by_name ($name) {
	$name=mysql_real_escape_string($name);
	return get_complex("`set`","WHERE name='$name'");
}
function get_set_by_code ($code) {
	$code=mysql_real_escape_string($code);
	return get_complex("`set`","WHERE code='$code'");
}
function get_set_by_mcic ($mcic) {
	$mcic=mysql_real_escape_string($mcic);
	return get_complex("`set`","WHERE mci_code='$mcic'");
}
function get_sets ($ACTIVE=NULL, $REVERSE=TRUE) {
	if ($REVERSE) $ORR="DESC";
	else $ORR="ASC";
	if ($ACTIVE===NULL) $WAC="";
	else {
		$WAC="WHERE active=";
		if ($ACTIVE) $WAC.="1";
		else $WAC.="0";
	}
	return gets_complex("`set`","$WAC ORDER BY `order` $ORR");
}
function count_set_lands ($set) {
	$sid=argi($set);
	return count_complex("land","WHERE set_id=$sid");
}
function get_set ($id) {
	$id=(int)$id;
	return get_complex("`set`","WHERE id=$id");
}
function arget_set ($t) {
	if (is_array($t)) return $t;
	if ($ar=get_cache_ar($t,"set")) return $ar;
	$ar=get_set($t);
	if ($ar) register_cache($ar,"set");
	return $ar;
}

function get_lands () {
	$lldb=gets_complex("land","ORDER BY id");
	$lset=array();
	$lsor=array();
	$lret=array();
	
	// controlla quali set hanno dei numeri non assegnati
	$sets=array();
	foreach ($lldb as $land) {
		if (!isset($sets[$land["set_id"]])) {
			$sets[$land["set_id"]]=TRUE;
		}
		if ($land["number"]==NULL) $sets[$land["set_id"]]=FALSE;
		$lset[$land["set_id"]][$land["id"]]=$land;
	}
	ksort($sets);
	
	// riordina
	foreach ($sets as $set_id => $complete) {
		$lsor=$lset[$set_id];
		if ($complete) {
			aasort($lsor,"number");
		}
		else {
			aasort($lsor,"id");
		}
		foreach ($lsor as $land) {
			$lret[$land["id"]]=$land;
		}
	}
	
	return $lret;
}
function get_land ($id) {
	$id=(int)$id;
	return get_complex("land","WHERE id=$id");
}
