<?php
ob_start();
session_start();       //important in every php page
$title='التحقق من البريد الالكتروني ';       //title of the page
include 'init.php';   //included files


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once "phpmailer/vendor/autoload.php";


//$_SESSION['codeUpdate'][0][1]==EMAIL,CODE from formUpdate.php (update profile) 
if(isset($_SESSION['codeUpdate']) ) {
  //verification comes from action.php(profile update)
  $email=$_SESSION['codeUpdate'][0];
  $code=$_SESSION['codeUpdate'][1];



if($l=='ar'){

$mail=new PHPMailer();

$mail->CharSet = 'UTF-8';
$mail->Encoding = 'base64';

$mail->isSMTP();
$mail->SMTPAuth=true;
$mail->SMTPDebug=0;


//HOST, USERNAME, PASSWORD, SECURE
$mail->Host="smtp.gmail.com";
$mail->Username="yassermoh396@gmail.com"; //GMAIL USERNAME
$mail->Password="jchikyvzwpmhzcoq";        //GMAIL PASSWORD
$mail->SMTPSecure="tls";
$mail->Port="587";

//FROM, SUBJECT, BODY, ATTACHMENT
$mail->From="contact@mostfid.com"; //SENT FROM
$mail->FromName="mostfid";
$mail->addReplyTo('hgq1100@yahoo.com');//NOT IMPORTANT
$mail->addAddress($email); //SENT TO
$mail->Subject=$lang['emailUpdate'];
$mail->isHTML(true);
$mail->Body='
<h1 style="text-align:right;">'.$lang['welcome2Mostafed'].'</h1> 
      <br>

     <center><div>
     <h2 style="background-color:#18b6ae;color:white;padding:1vh 0vw">www.mostfid.com</h2>
     <br><br><br>

     <h4>'.$lang['rquestUpdate'].' '.$lang['code2Verify'].'</h4>
     <center><h1 style="background-color:orange;color:white;font-weight:bold;padding:3vh 2vw;width:fit-content;"> '.$code.'</h1></center>
     <br><br><br>
 </div></center>

  <strong><h2 style="text-align:right;text-decoration:underline">'.$lang['plsFollow'].'</h2></strong>
  <div style="text-align:right;list-style-type:circle">
    <h3 style="margin-bottom:-1vh">'.$lang['copyCode'].'</h3> 
    <h3 style="margin-bottom:-1vh">'.$lang['goTo'].' '.'<a href="https://www.mostfid.com/emailUpdate">'.' '.$lang['verifyPage'].'</a></h3> 
    <h3 style="margin-bottom:-1vh">'.$lang['pasteClick2'].'</h3>   
    <br>
    <h5 style="margin-bottom:-1vh">'.$lang['ignore'].'</h5>
  </div>

     <br><br><br>
     <center>
       <h2>'.$lang['regards'].'</h2>
       <h2>'.$lang['MostafedTeam'].'</h2>
       <h4><a href="https://www.mostfid.com/index">www.mostfid.com</a></h4>
     </center>

';
//$mail->addAttachment('img.png','our pic');//KK


//ARRAYS
$mail->SMTPOptions=array(
  "ssl" => array(
       "verify_peer"       =>false,
       "verify_peer_name"  =>false,
       "allow_self_signed" =>true
     ),
);

}else{  //English

$mail=new PHPMailer();

$mail->CharSet = 'UTF-8';
$mail->Encoding = 'base64';

$mail->isSMTP();
$mail->SMTPAuth=true;
$mail->SMTPDebug=0;


//HOST, USERNAME, PASSWORD, SECURE
$mail->Host="smtp.gmail.com";
$mail->Username="yassermoh396@gmail.com"; //GMAIL USERNAME
$mail->Password="jchikyvzwpmhzcoq";        //GMAIL PASSWORD
$mail->SMTPSecure="tls";
$mail->Port="587";


//FROM, SUBJECT, BODY, ATTACHMENT
$mail->From="contact@mostfid.com"; //SENT FROM
$mail->FromName="mostfid";
$mail->addReplyTo('hgq1100@yahoo.com');//NOT IMPORTANT
$mail->addAddress($email); //SENT TO
$mail->Subject=$lang['emailUpdate'];
$mail->isHTML(true);
$mail->Body= '
 <div>
     <h1>'.$lang['welcome2Mostafed'].'</h1>
     <br>
    
     <center>
     <h2 style="background-color:#18b6ae;color:white;padding:1vh 0vw">www.mostfid.com</h2>
     </center>
     <br><br>

     <h4">'.$lang['rquestUpdate'].' '.$lang['code2Verify'].'</h4>
     <center><h1 style="background-color:orange;color:white;font-weight:bold;padding:3vh 2vw;width:fit-content;"> '.$code.'</h1></center>
     <br><br>
 </div>

  <strong><h3 style="text-decoration:underline">'.$lang['plsFollow'].'</h3></strong>
  <div style="">
    <h4 style="margin-bottom:-1vh">'.$lang['copyCode'].'</h4> 
    <h4 style="margin-bottom:-1vh">'.$lang['goTo'].' '.'<a href="https://www.mostfid.com/emailUpdate">'.' '.$lang['verifyPage'].'</a></h4> 
    <h4 style="margin-bottom:-1vh">'.$lang['pasteClick2'].'</h4>   
    <br>
    <h6 style="margin-bottom:-1vh">'.$lang['ignore'].'</h6>
  </div>

     <br><br><br>
     <center>
       <h2>'.$lang['regards'].'</h2>
       <h2>'.$lang['MostafedTeam'].'</h2>
       <h4><a href="https://www.mostfid.com/index">www.mostfid.com</a></h4>
     </center>
' ; 
//$mail->addAttachment('img.png','our pic');//KK
//ARRAYS
$mail->SMTPOptions=array(
  "ssl" => array(
       "verify_peer"       =>false,
       "verify_peer_name"  =>false,
       "allow_self_signed" =>true
     ),
); 
 }  //End else


//SUCCESS
if( $mail->Send() ) { 
     ?><script>window.location.href='emailChkCodeUpdate.php';</script><?php
  
	}else{
    ?><div class="center"> <?php
    echo $lang['refresh'];
    ?></div> <?php
  }



}else{  //END if isset $_SESSION
	header('location:login.php');
	exit();
} 


include $tmpl."footer.inc"; 
include "foot.php";
ob_end_flush(); 

//FAILURE
//$mail->ErrorInfo;
 //REDIRECT
