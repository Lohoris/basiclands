<?php

require_once 'includes.php';

checkref() or diex("Referrer error");
start_session();
$db=connect() or diesql("Couldn't connect to database");
$logged=get_logged_user();
am_admin() or diex("Must be admin");

$name=$_GET["name"];
$code=$_GET["code"];

$name or diex("No name");
$code or diex("No code");

$db->begin() or diesql("Couldn't start transaction");

// controlla che non ci sia già
($lang=get_language_by_name($name))===NULL and diesql("Couldn't check language name");
$lang and diex('Language "'.$name.'" already exists');
($lang=get_language_by_code($code))===NULL and diesql("Couldn't check language code");
$lang and diex('Language coded "'.$code.'" already exists');

// sceglie l'ID
$query="SELECT id FROM language ORDER BY id DESC LIMIT 1";
$result=mysql_query($query) or diesql("Couldn't get current lang.maxid");
if (mysql_numrows($result)<1) {
	$newid=1;
}
else {
	$maxid=mysql_result($result,0,"id");
	$newid=$maxid<<1;
}

// lo aggiunge
$esname=mysql_real_escape_string($name);
$escode=mysql_real_escape_string($code);
$query="INSERT INTO language (id, name, code) VALUES ($newid, '$esname', '$escode')";
mysql_query($query) or diesql("Couldn't insert $newid:$name:$code");

$db->commit() or diesql("Couldn't commit transaction");

ajaccio_post(aja(div_language($newid)));
