<?php

function connect () {
	global $DB_SITE,$DB_NAME,$DB_USER,$DB_PASS;
	if (!$res=mysql_connect($DB_SITE,$DB_USER,$DB_PASS)) return NULL;
	if (!mysql_select_db($DB_NAME)) return NULL;
	return $res;
}
function begin () {
	global $query;
	$query="BEGIN";
	if (!mysql_query($query)) return NULL;
	return TRUE;
}
function commit () {
	global $query;
	$query="COMMIT";
	if (!mysql_query($query)) return NULL;
	return TRUE;
}
function rollback () {
	global $query;
	$query="ROLLBACK";
	if (!mysql_query($query)) return NULL;
	return TRUE;
}

function get_complex ($FROM, $WHEREO, $SELECT="*") {
	global $query;
	
	if (!$result=mysql_query($query="SELECT $SELECT FROM $FROM $WHEREO LIMIT 1"))
		return NULL;
	
	if (mysql_numrows($result)==0)
		return array();
	
	$ret=mysql_fetch_assoc($result);
	mysql_free_result($result);
	return $ret;
}
function gets_complex ($FROM, $WHEREO="", $SELECT="*", $mode=NULL, $element=NULL, $elid="id") {
	global $query;
	
	if ($SELECT=="LIST") {
		$REAL_LIST=TRUE;
		$SELECT="id,name";
	}
	else if ($mode=="REAL_LIST") {
		$REAL_LIST=TRUE;
	}
	else if ($mode=="LIST") {
		$LIST=TRUE;
	}
	else if ($mode=="PUSH") {
		$PUSH=TRUE;
	}
	else if ($mode=="ELEM" && $element) {
		$ELEM=TRUE;
	}
	
	if (!$result=mysql_query($query="SELECT $SELECT FROM $FROM $WHEREO")) return NULL;
	
	$ret=array();
	if (mysql_numrows($result)==0) return $ret;
		
	while ($fet=mysql_fetch_assoc($result)) {
		if ($REAL_LIST)
			$ret[$fet["id"]]=$fet["name"];
		else if ($LIST)
			array_push($ret, $fet["id"]);
		else if ($ELEM)
			$ret[$fet[$elid]]=$fet[$element];
		else if (isset($fet["id"]) && !$PUSH)
			$ret[$fet["id"]]=$fet;
		else
			array_push($ret, $fet);
	}
	
	mysql_free_result($result);
	return $ret;
}
function count_complex ($FROM, $WHEREO="") {
	global $OP,$query;
	if (!$result=mysql_query($query="SELECT COUNT(*) AS count FROM $FROM $WHEREO")) return NULL;
	if (!mysql_numrows($result)) return 0;
	return mysql_result($result,0,"count");
}
