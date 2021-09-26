<?php

function connect () {
	global $DB_HOST, $DB_PORT, $DB_NAME, $DB_CHAR, $DB_USER, $DB_PASS;
	
	$db = new simplePdoWrapper();
	$db->ConnectMySQL( $DB_HOST, $DB_PORT, $DB_NAME, $DB_CHAR, $DB_USER, $DB_PASS );
	
	return $db;
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
	global $query, $db;
	
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
	
	$query="SELECT $SELECT FROM $FROM $WHEREO";
	print_r(['qu',$query]);
	$amt = $db->queryAmount($query);
	
	$ret=array();
	if ( $amt==0 )
		return $ret;
	
	while ($fet=$db->fetchRow()) {
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
	
	return $ret;
}
function count_complex ($FROM, $WHEREO="") {
	global $OP,$query;
	if (!$result=mysql_query($query="SELECT COUNT(*) AS count FROM $FROM $WHEREO")) return NULL;
	if (!mysql_numrows($result)) return 0;
	return mysql_result($result,0,"count");
}
