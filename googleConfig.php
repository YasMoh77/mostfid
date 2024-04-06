<?php
ob_start();

  

  require_once 'google/vendor/autoload.php';    

  // init configuration
$clientID = '785197984914-dukur8uir789d81f43a1att12h484n7e.apps.googleusercontent.com';
$clientSecret = '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';
//$redirectUri = 'https://www.mostfid.com/googleWelcome.php';
$redirectUri = 'http://localhost:82/mostfid/googleWelcome.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");



     
ob_end_flush();
 