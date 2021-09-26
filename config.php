<?php

$PROGNAME="basiclist";

$DB_HOST = '127.0.0.1';
$DB_PORT = 3306;
$DB_NAME = '';
$DB_CHAR = 'utf8mb4';
$DB_USER = '';
$DB_PASS = '';

$OP='';

$COOKIE_NAME = "$PROGNAME";
$COOKIE_LIFE = 3600*24*30; // 30 giorni
$COOKIE_PATH = "/";

$DOMAIN = "$PROGNAME.looris.net";

$LIBNAME = "varlibs";
$LIBDIR  = "";
$LIBURL  = "";

$OPENID_URL      = "https://www.google.com/accounts/o8/id";
$OPENID_REQUIRED = array("contact/email","namePerson/first","namePerson/last");

require_once 'config_local.php';

$URL    = "http://$DOMAIN/";
$AJURL  = $URL."ajaccio/";
$JSURL  = $URL."script/";
$IMG    = $URL."img/";
$CSS    = $URL."css/";
