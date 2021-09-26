<?php

function get_logged_user () {
	global $PAGE_TYPE;
	$DEBUG=FALSE;
	//$DEBUG=!$PAGE_TYPE;
	
	if ($DEBUG) {
		print_rr($_SESSION);
		print_rr(session_id());
		print_rr(session_get_cookie_params());
		echo "1";
	}
	if (!$uid=$_SESSION["uid"]) return array();
	
	if ($DEBUG) echo "2";
	if (!$user=get_user($uid)) return $user;
	
	if ($DEBUG) echo "3";
	$sid=session_id();
	if ($sid!=$user["session"]) {
		// la sessione non è buona, login invalido
		return array();
	}
	
	if ($DEBUG) echo "4";
	return $user;
}

// NOTA: assumono che la sessione sia già iniziata
function logout ($id) {
	global $OP,$query;
	
	$id=(int)$id;
	
	unset($_SESSION["uid"]);
	
	$query="UPDATE `user` SET session=NULL WHERE id=$id";
	if (!mysql_query($query)) return NULL;
	
	return TRUE;
}
function login ($id) {
	global $OP,$query;
	
	$id=(int)$id;
	$sid=mysql_real_escape_string(session_id());
	
	$query="UPDATE `user` SET session='$sid', last_access=NOW() WHERE id=$id";
	if (!mysql_query($query)) return NULL;
	
	$_SESSION["uid"]=$id;
	return get_logged_user();
}
