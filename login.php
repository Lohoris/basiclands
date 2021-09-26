<?php

/*	TODOs
	°°	fare un login separato è necessario per evitare che la url openid permanga;
		l'alternativa migliore sarebbe di far funzionare openid in un popup, come spiegato a questo link:
		http://openid-demo.appspot.com/
*/

require_once 'includes.php';

$germ=base_germe();
$db=connect() or diesql("Couldn't connect to database");

if (isset($_GET["logout"])) {
	checkref() or diex("Referrer error");
	$logged=get_logged_user();
	$logged or diex("Already unlogged");
	logout($logged["id"]) or diesql("Error logging out");
}
else if (isset($_GET["openid_mode"]) && ($_GET["openid_mode"]!="cancel")) {
	$openid=new LightOpenID;
	
	if (!$openid->validate()) {
		// TODO°° fare meglio di così
		echo "<p>INVALID OPENID</p>";
		print_rrd($openid);
	}
	
	$attr=$openid->getAttributes();
	$email=$attr["contact/email"];
	$fname=$attr["namePerson/first"]." ".$attr["namePerson/last"];
	
	($usr=get_user_by_email($email))===NULL and diesql("Couldn't get user");
	if ($usr) {
		$uid=$usr["id"];
	}
	else {
		// l'utente non esiste, lo crea
		$iname=mysql_real_escape_string($fname);
		$imail=mysql_real_escape_string($email);
		$istat=$user_status_r["user"];
		$query="INSERT INTO {$OP}user (name, email, status, last_access, created_date) VALUES ('$iname', '$imail', $istat, NOW(), NOW())";
		mysql_query($query) or diesql("Couldn't create user");
		$uid=mysql_insert_id();
	}
	$logged=login($uid) or diesql("Couldn't login");
}

$germ->add_head('<meta http-equiv="refresh" content="0;url='.$URL.'">');
