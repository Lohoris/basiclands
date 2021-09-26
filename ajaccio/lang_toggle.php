<?php

require_once 'includes.php';

checkref() or diex("Referrer error");
start_session();
$db=connect() or diesql("Couldn't connect to database");
$logged=get_logged_user();
am_admin() or diex("Must be admin");

$set_id=(int)$_GET["set_id"];
$lang_id=(int)$_GET["lang_id"];
$new_value=(int)$_GET["new_value"];

$db->begin() or diesql("Couldn't start transaction");

if ($new_value) {
	$NV="language|$lang_id";
}
else {
	$NV="language&~$lang_id";
}

$query="UPDATE `set` SET language=$NV WHERE id=$set_id";
mysql_query($query) or diesql("Couldn't update set $set_id:$lang_id:$new_value");

$db->commit() or diesql("Couldn't commit transaction");

//ajaccio_post(aja(div_set($set_id))."\n".aja(div_checklist()));
ajaccio_post(aja(div_set($set_id)));
