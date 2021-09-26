<?php

$PROGNAME="basiclist";

$DB_SITE = NULL;
$DB_NAME = NULL;
$DB_USER = NULL;
$DB_PASS = NULL;
$OP=$PROGNAME."_";

$COOKIE_NAME = "$PROGNAME";
$COOKIE_LIFE = 3600*24*30; // 30 giorni
$COOKIE_PATH = "/";

$DOMAIN = "$PROGNAME.looris.net";
$URL    = "http://$DOMAIN/";
$AJURL  = $URL."ajaccio/";
$JSURL  = $URL."script/";
$IMG    = $URL."img/";
$CSS    = $URL."css/";

$LIBNAME = "varlibs";
$LIBDIR  = "";
$LIBURL  = "";

$OPENID_URL      = "https://www.google.com/accounts/o8/id";
$OPENID_REQUIRED = array("contact/email","namePerson/first","namePerson/last");

require_once 'config_local.php';
