<?php

require_once 'includes.php';

checkref() or diex("Referrer error");
start_session();
$db=connect() or diesql("Couldn't connect to database");
$logged=get_logged_user();
am_admin() or diex("Must be admin");

$what=$_GET["what"];
if ($what=="lang") {
	$id=(int)$_GET["lang_id"];
	$table="language";
}
else if ($what=="set") {
	$id=(int)$_GET["set_id"];
	$table="set";
}
else {
	diex("What's $what");
}

$db->begin() or diesql("Couldn't start transaction");

$query="UPDATE $table SET active=1-active WHERE id=$id";
mysql_query($query) or diesql("Couldn't toggle active on $what:$id");

$db->commit() or diesql("Couldn't commit transaction");

if ($what=="lang") {
	ajaccio_post(aja(div_language($id)));
}
else if ($what=="set") {
	ajaccio_post(aja(div_set($id))."\n".aja(div_checklist()));
}
