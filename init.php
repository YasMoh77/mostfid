<?php

ini_set('display_errors', 'on');
error_reporting(E_ALL);

 


//abbreviations
$tmpl='include/templates/';
$css='layout/css/';
$js='layout/js/';
$images='layout/images/';
$fonts='layout/fonts/';
$language='include/languages/';
$func='include/functions/';


//important files

include 'lang.php'; //(containing language files) must be before header or header words fail.
include $tmpl."header.inc";
include 'connect.php'; //this file connects to database
include $func.'functions.php';
if (!isset($removeNavBar)) {include $tmpl .'navbar.php';}  //include on term 
