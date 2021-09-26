<?php

require_once 'includes.php';

checkref() or diex("Referrer error");
start_session();
$db=connect() or diesql("Couldn't connect to database");
$logged=get_logged_user();

if (isset($_GET["refresh"])) {
	$DO="refresh";
}
else if (isset($_GET["toggle_id"])) {
	am_admin() or diex("Must be admin");
	$DO="toggle";
	
	$land_id=(int)$_GET["toggle_id"];
	$lang_id=(int)$_GET["lang_id"];
	$new_value=(int)$_GET["new_value"];
}
else if (isset($_GET["spread_id"])) {
	am_admin() or diex("Must be admin");
	$spread_id=(int)$_GET["spread_id"];
	$set_id=(int)$_GET["set_id"];
	$number=(int)$_GET["number"];
	$from=(int)$_GET["from"];
	$to=(int)$_GET["to"];
	$DO="spread";
}
else {
	am_admin() or diex("Must be admin");
	$land_id=(int)$_GET["land_id"];
	$number=(int)$_GET["number"];
	$next_id=(int)$_GET["next_id"];
	$DO="land";
}

$db->begin() or diesql("Couldn't start transaction");

if ($DO=="land") {
	$query="UPDATE land SET number=$number WHERE id=$land_id";
	mysql_query($query) or diesql("Couldn't update $land_id:$number");
}
else if ($DO=="spread") {
	for ($land_id=$from; $land_id<=$to; $land_id++) {
		$number++;
		$query="UPDATE land SET number=$number WHERE id=$land_id AND set_id=$set_id";
		mysql_query($query) or diesql("Couldn't update $land_id:$number in $set_id");
	}
}
else if ($DO=="refresh") {
	; // NOTA: sì, non fa nulla, è intenzionale
}
else if ($DO=="toggle") {
	if ($new_value) {
		$NV="got|$lang_id";
	}
	else {
		$NV="got&~$lang_id";
	}
	
	$query="UPDATE land SET got=$NV WHERE id=$land_id";
	mysql_query($query) or diesql("Couldn't update $land_id:$lang_id:$new_value");
}

$db->commit() or diesql("Couldn't commit transaction");

ajaccio_post("$land_id\n$number\n$next_id\n".aja(div_checklist($land_id)));
