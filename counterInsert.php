<?php
ob_start();
session_start();
//abbreviations
$tmpl='include/templates/';
$css='layout/css/';
$js='layout/js/';
$images='layout/images/';
$fonts='layout/fonts/';
$language='include/languages/';
$func='include/functions/';
//important files
include 'lang.php'; //must be before header or header words fail.
include $tmpl."header.inc";
include 'connect.php'; //this file connects to database
include $func.'functions.php';


//prizes
if (isset($_GET['prizes'])) {
	$value=$_GET['prizes'];
	$prizes='prizes';
	$stmt=$conn->prepare('UPDATE  page_views  SET  value=? WHERE page_name=?  ');
	$stmt->execute(array($value,$prizes));
}
//order
if (isset($_GET['order'])) {
	$value=$_GET['order'];
	$order='order';
	$stmt=$conn->prepare('UPDATE  page_views  SET  value=? WHERE page_name=?  ');
	$stmt->execute(array($value,$order));
}
//map
if (isset($_GET['map'])) {
	$value=$_GET['map'];
	$map='map';
	$stmt=$conn->prepare('UPDATE  page_views  SET  value=? WHERE page_name=?  ');
	$stmt->execute(array($value,$map));
}
//policy
if (isset($_GET['policy'])) {
	$value=$_GET['policy'];
	$policy='policy';
	$stmt=$conn->prepare('UPDATE  page_views  SET  value=? WHERE page_name=?  ');
	$stmt->execute(array($value,$policy));
}
//terms
if (isset($_GET['terms'])) {
	$value=$_GET['terms'];
	$terms='terms';
	$stmt=$conn->prepare('UPDATE  page_views  SET  value=? WHERE page_name=?  ');
	$stmt->execute(array($value,$terms));
}
//searchK
if (isset($_GET['searchK'])) {
	$value=$_GET['searchK'];
	$searchK='searchK';
	$stmt=$conn->prepare('UPDATE  page_views  SET  value=? WHERE page_name=?  ');
	$stmt->execute(array($value,$searchK));
}
//searchAside
if (isset($_GET['searchAside'])) {
	$value=$_GET['searchAside'];
	$searchAside='searchAside';
	$stmt=$conn->prepare('UPDATE  page_views  SET  value=? WHERE page_name=?  ');
	$stmt->execute(array($value,$searchAside));
}
//contactUs
if (isset($_GET['contactUs'])) {
	$value=$_GET['contactUs'];
	$contactUs='contactUs';
	$stmt=$conn->prepare('UPDATE  page_views  SET  value=? WHERE page_name=?  ');
	$stmt->execute(array($value,$contactUs));
}
//aboutUs
if (isset($_GET['aboutUs'])) {
	$value=$_GET['aboutUs'];
	$aboutUs='aboutUs';
	$stmt=$conn->prepare('UPDATE  page_views  SET  value=? WHERE page_name=?  ');
	$stmt->execute(array($value,$aboutUs));
}
//faq
if (isset($_GET['faq'])) {
	$value=$_GET['faq'];
	$faq='faq';
	$stmt=$conn->prepare('UPDATE  page_views  SET  value=? WHERE page_name=?  ');
	$stmt->execute(array($value,$faq));
}
//countries
if (isset($_GET['countries'])) {
	$value=$_GET['countries'];
	$countries='countries';
	$stmt=$conn->prepare('UPDATE  page_views  SET  value=? WHERE page_name=?  ');
	$stmt->execute(array($value,$countries));
}
//details
if (isset($_GET['details'])) {
	$value=$_GET['details'];
	$details='details';
	$stmt=$conn->prepare('UPDATE  page_views  SET  value=? WHERE page_name=?  ');
	$stmt->execute(array($value,$details));
}
//index
if (isset($_GET['index'])) {
	$value=$_GET['index'];
	$index='index';
	$stmt=$conn->prepare('UPDATE  page_views  SET  value=? WHERE page_name=?  ');
	$stmt->execute(array($value,$index));
}
//general
if (isset($_GET['general'])) {
	$value=$_GET['general'];
	$general='general';
	$stmt=$conn->prepare('UPDATE  page_views  SET  value=? WHERE page_name=?  ');
	$stmt->execute(array($value,$general));
}
//service
if (isset($_GET['service'])) {
	$value=$_GET['service'];
	$service='service';
	$stmt=$conn->prepare('UPDATE  page_views  SET  value=? WHERE page_name=?  ');
	$stmt->execute(array($value,$service));
}


include $tmpl."footer.inc";   
ob_end_flush();