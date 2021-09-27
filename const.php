<?php

$GC=array(
	"land_default_repeat" => "pismf",
	"land_default_amount" => 4,
	"land_default_mode"   => "stretch",
	'pref_lang'           => 'en',
);

$Land=array(
	1=>"Forest",
	"Island",
	"Mountain",
	"Plains",
	"Swamp",
);
foreach ($Land as $ii => $val) {
	$Land_r[$val]=$ii;
	$lr=strtolower(substr($val,0,1));
	$Land_repeat[$ii]=$lr;
	$Land_repeat_r[$lr]=$ii;
}

$S=array(
	'processing' => '<img src="'.$IMG.'ajax_wait.gif" alt="Processing...">',
	'going down' => '&#x21e3;', // ⇣
	'down up to' => '&#x2913;', // ⤓
	'refresh'    => '&#x27f3;', // ⟳
	'check ok'   => '&#x2713;', // ✓
	'check no'   => '&#x2717;', // ✗
);
$S=$S+array(
	'chok' => '<span class="ok small">'.$S["check ok"].'</span>',
	'chno' => '<span class="no small">'.$S["check no"].'</span>',
);

$user_status=array(
	1=>"user",
	"admin",
);
foreach ($user_status as $ii => $val) {
	$user_status_r[$val]=$ii;
}
