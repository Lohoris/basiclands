<?php

require_once '../includes.php';

start_session();
$db=connect() or diesql("Couldn't connect to database");
$logged=get_logged_user();
am_admin() or diex("Must be admin");

$lands=gets_complex("{$OP}land","ORDER BY id") or diesql("AEflkaefii");
$iid=1;
foreach ($lands as $land) {
	$query="UPDATE {$OP}land SET id=$iid WHERE id={$land["id"]}";
	mysql_query($query) or diesql("aekfjaefj");
	$iid++;
}

echo "done:$iid";
