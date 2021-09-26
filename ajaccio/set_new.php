<?php

require_once 'includes.php';

checkref() or diex("Referrer error");
start_session();
$db=connect() or diesql("Couldn't connect to database");
$logged=get_logged_user();
am_admin() or diex("Must be admin");

$name=$_GET["name"];
$code=$_GET["code"];
$mcic=$_GET["mci_code"];

$name or diex("No name");
$mcic or diex("No mcic");

if (isset($_GET["land"])) {
	$DO=$GC["land_default_mode"];
	$repeat_lands=$GC["land_default_repeat"];
	$repeat_amount=(int)$_GET["land"];
	if ($repeat_amount<1) $repeat_amount=$GC["land_default_amount"];
}
else if (isset($_GET["repeat"])) {
	$DO=$_GET["repeat"];
	$repeat_lands=strtolower($_GET["repeat_lands"]);
	$repeat_amount=(int)$_GET["repeat_amount"];
	if ($repeat_amount<1) $repeat_amount=1;
}
else {
	diex("Call error");
}
if (array_search($DO,array("stretch","copy"))===FALSE) diex("Unknown mode: $DO");

$db->begin() or diesql("Couldn't start transaction");

// controlla che non ci sia già
($set=get_set_by_name($name))===NULL and diesql("Couldn't check set name");
$set and diex('Set named "'.$name.'" already exists');
($set=get_set_by_mcic($mcic))===NULL and diesql("Couldn't check set mcic");
$set and diex('Set mcicd "'.$mcic.'" already exists');

// sceglie l'order
$query="SELECT `order` FROM `set` ORDER BY `order` DESC LIMIT 1";
$result=mysql_query($query) or diesql("Couldn't get current set.maxid");
if (mysql_numrows($result)<1) {
	$order=1;
}
else {
	$maxord=mysql_result($result,0,"order");
	$order=$maxord+1;
}

// lo aggiunge
$ename="'".mysql_real_escape_string($name)."'";
if ($code) {
	$ecode="'".mysql_real_escape_string($code)."'";
}
else {
	$ecode="NULL";
}
$mcico="'".mysql_real_escape_string($mcic)."'";
$query="INSERT INTO `set` (name, code, mci_code, `order`) VALUES ($ename, $ecode, $mcico, $order)";
mysql_query($query) or diesql("Couldn't insert $ename:$ecode");
$setid=mysql_insert_id();

// aggiunge le terre
$iic=1;
$iism=1;
if ($DO=="copy") $iic=$repeat_amount;
else if ($DO=="stretch") $iism=$repeat_amount;
$srl=str_split($repeat_lands);
do {
	reset($srl);
	foreach ($srl as $rl) {
		if (!isset($Land_repeat_r[$rl])) continue;
		$type=$Land_repeat_r[$rl];
		
		$iis=$iism;
		do {
			$query="INSERT INTO land (set_id, type) VALUES ($setid, $type)";
			mysql_query($query) or diesql("Couldn't insert in $ename:$ecode:$mcico $setid:$type ($iic,$iism,$iis)");
		} while (--$iis>0);
	}
} while(--$iic>0);

$db->commit() or diesql("Couldn't commit transaction");

ajaccio_post(aja(div_set($setid))."\n".aja(div_checklist()));
