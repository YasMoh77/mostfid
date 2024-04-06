<?php

//abbreviations
$tmpl='include/templates/';
$css='layout/css/';
$js='layout/js/';
$images='layout/images/';
$fonts='layout/fonts/';
$language='include/languages/';
$func='include/functions/';



//impotant files
include $language."english.php"; //must be before header or header words fail.
include '../lang.php';
$l=$lang['lang'];  
include $tmpl."header.inc";
include 'connect.php'; //this file connects to database
include $func.'functions.php';
if (!isset($removeNavBar)) {include $tmpl .'navbar.php';}  //include on term 
