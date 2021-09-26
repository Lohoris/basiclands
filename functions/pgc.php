<?php

function am_admin () {
	global $logged;
	return is_admin($logged);
}
function is_admin ($user) {
	global $user_status_r;
	if (!$user=arget_user($user)) return NULL;
	return $user["status"]==$user_status_r["admin"];
}

function diex ($message="") {
	global $PAGE_TYPE;
	if ($PAGE_TYPE=="ajaccio") {
		die("NO\n".aja(hnl2br($message)));
	}
	else {
		die($message);
	}
}
function diesql ($message) {
	global $query;
	diex("$message\n\nSQL error: ".mysql_error()."\n\nQuery: $query\n\n");
}
function ajaccio_post ($message="") {
	echo "OK\n$message";
}

function stretch ($image, $id, $scale, $germe) {
	//$AP='';
	$command="adjust_image('$id','reco1_bg',$scale);";
	if ($germe!==NULL) {
		$germe->onresize($command);
		$SD='style="display:none;"';
	}
	else {
		$SD='';
		//$AP='<script type="text/javascript">'.$command.'</script>';
	}
	return '<img id="'.$id.'" src="'.$image.'" alt="" '.$SD.'>';
}
function lang_image ($lang, $mode="normal") {
	global $IMG;
	return '<div class="lang_image_'.$mode.'"><img src="'.$IMG.$lang["code"].'16.png"></div>';
}

function sets_lands ($sets, $lands) {
	foreach ($lands as $land) {
		if (!isset($sets[$land["set_id"]])) continue;
		$sets[$land["set_id"]]["lands"][$land["id"]]=$land;
	}
	return $sets;
}
function active_languages ($langs) {
	foreach ($langs as $lid => $lang) {
		if (!$lang["active"]) unset($langs[$lid]);
	}
	return $langs;
}
function set_langs ($set, $langs) {
	$ret=array();
	foreach ($langs as $lang) {
		if ((int)$set["language"]&(int)$lang["id"]) {
			array_push($ret,$lang);
		}
	}
	return $ret;
}
function language_filter ($langs) {
	$ret=0;
	foreach ($langs as $lla) {
		$ret=$ret|$lla["id"];
	}
	return $ret;
}
