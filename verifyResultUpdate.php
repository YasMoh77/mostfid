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


// THIS POST COMING FROM  (verifyLogin.php) TO VERIFY LOGIN INFO
	if($_SERVER['REQUEST_METHOD']=='POST') {	
     $emailLogin=$_POST['emailLogin'];
     $emailSanitzed=  filter_var($emailLogin,FILTER_SANITIZE_EMAIL);
     $emailValidated=  filter_var($emailSanitzed,FILTER_VALIDATE_EMAIL);
     
     $code1=md5(rand(10000,100000));
     $code=substr($code1,0,6); 
     $arr=array($emailSanitzed,$code);
     
     
     if($emailValidated != true){
        echo '<span class="red2">'.$lang['checkEmail'].'</span>'; 
     }else{
	       $stmt=$conn->prepare(" SELECT * from user where email=? ");	
		   $stmt->execute(array($emailSanitzed));
		   $row=$stmt->rowCount();
	   if ($row==0) { //EMAIL IS not IN DATABASE
                echo '<span class="red2 alone">'.$lang['emailNotKnown'].'</span>'.'<span class="above centered"><a href="signUpU.php">'.$lang['signUp'].'</a></span>';
	   	       }else{
		   	   $stmt2=$conn->prepare(" SELECT * from user where email=? and activate=1 ");	
			   $stmt2->execute(array($emailSanitzed));
			   $row2=$stmt2->rowCount();
		   if($row2>0){ //EMAIL IS VERIFIED 
               echo $lang['alreadyVerify'].' .. '.'<a href="login.php">'.$lang['doLogin'].'</a>';
			   }else{ //direct to emailVerifySignUp.php to send a verify code
			   	 //update code
			   	$stmt=$conn->prepare(" UPDATE user set code=? where email=? ");	
			    $stmt->execute(array($code,$emailSanitzed));
	                 if($stmt){
	                 	$_SESSION['codeLoginMos']=$arr;
	                   ?><script>window.location.href='emailUpdate.php';</script><?php
	                 }else{
	                 	echo "something went wrong, please re-enter your email address.";
	                 }  
			   	 
			   }

	   }//END if ($row>0)
     }

 }else{ // END if($_SERVER['REQUEST_METHOD']=='POST')
    header('location:logout.php');
    exit();
 }







include $tmpl."footer.inc";  