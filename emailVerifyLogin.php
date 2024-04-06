<?php
ob_start();
session_start();       //important in every php page
$title='التحقق من البريد الالكتروني ';       //title of the page
include 'init.php';   //included files




//$_SESSION['codeLoginMos'][0][1]==EMAIL,CODE from login.php to remind to verify email


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once "phpmailer/vendor/autoload.php"; 

//////
  if(isset($_SESSION['codeLoginMos'])){ //verification comes from login.php to remind to verify email
   $email=$_SESSION['codeLoginMos'][0]; 
   $code=$_SESSION['codeLoginMos'][1];
 }else{
  header('location:login.php');
  exit();
 }
  


if($l=='ar'){

$mail=new PHPMailer();
ini_set('max_execution_time', 300);//if loading stayed for long

$mail->CharSet = 'UTF-8';//important for coding
$mail->Encoding = 'base64';

$mail->isSMTP();
$mail->SMTPAuth=true;
$mail->SMTPDebug=0; 


//HOST, USERNAME, PASSWORD, SECURE
$mail->Host="smtp.gmail.com";
$mail->Username="yassermoh396@gmail.com"; //GMAIL USERNAME
$mail->Password="ggozzjdaohvcjyxr";        //GMAIL PASSWORD
$mail->SMTPSecure="tls"; 
$mail->Port="587";

//FROM, SUBJECT, BODY, ATTACHMENT
$mail->From="contact@mostfid.com"; //SENT FROM
$mail->FromName="Mostfid";
$mail->addReplyTo('hgq1100@yahoo.com');//NOT IMPORTANT
$mail->addAddress($email); //SENT TO
$mail->Subject=$lang['verifyEmail2'];
$mail->isHTML(true);
$mail->Body='
<h1 style="text-align:right;">'.$lang['welcome2Mostafed'].'</h1>
      <br>

     <center><div>
     <h2 style="background-color:#18b6ae;color:white;padding:1vh 0vw">www.mostfid.com</h2>
     <br><br><br>

     <h2>'.$lang['code2Verify'].'</h2>
     <center><h1 style="background-color:orange;color:white;font-weight:bold;padding:3vh 2vw;width:fit-content;"> '.$code.'</h1></center>
     <br><br><br>
 </div></center>

  <strong><h2 style="text-align:right;text-decoration:underline">'.$lang['plsFollow'].'</h2></strong>
  <div style="text-align:right;list-style-type:circle">
    <h3 style="margin-bottom:-1vh">'.$lang['copyCode'].'</h3> 
    <h3 style="margin-bottom:-1vh">'.$lang['goTo'].' '.'<a href="https://www.mostfid.com/emailVerifyLog.php">'.' '.$lang['verifyPage'].'</a></h3> 
    <h3 style="margin-bottom:-1vh">'.$lang['pasteClick2'].'</h3>   
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
ini_set('max_execution_time', 300);

$mail->CharSet = 'UTF-8';
$mail->Encoding = 'base64';

$mail->isSMTP();
$mail->SMTPAuth=true;
$mail->SMTPDebug=0;


//HOST, USERNAME, PASSWORD, SECURE
$mail->Host="smtp.gmail.com";
$mail->Username="yassermoh396@gmail.com"; //GMAIL USERNAME
$mail->Password="ggozzjdaohvcjyxr";        //GMAIL PASSWORD
$mail->SMTPSecure="tls";
$mail->Port="587";


//FROM, SUBJECT, BODY, ATTACHMENT
$mail->From="contact@mostfid.com"; //SENT FROM 
$mail->FromName="Mostfid";
$mail->addReplyTo('hgq1100@yahoo.com');//NOT IMPORTANT
$mail->addAddress($email); //SENT TO
$mail->Subject=$lang['verifyEmail2'];
$mail->isHTML(true);
$mail->Body= '
 <div>
     <h1>'.$lang['welcome2Mostafed'].'</h1>
     <br>
    
     <center>
     <h2 style="background-color:#18b6ae;color:white;padding:1vh 0vw">www.mostfid.com</h2>
     </center>
     <br><br>

     <h2> '.$lang['code2Verify'].'</h2>
     <center><h1 style="background-color:orange;color:white;font-weight:bold;padding:3vh 2vw;width:fit-content;"> '.$code.'</h1></center>
     <br><br>
 </div>

  <strong><h3 style="text-decoration:underline">'.$lang['plsFollow'].'</h3></strong>
  <div style="">
    <h4 style="margin-bottom:-1vh">'.$lang['copyCode'].'</h4> 
    <h4 style="margin-bottom:-1vh">'.$lang['goTo'].' '.'<a href="https://www.mostfid.com/emailVerifyLog.php">'.' '.$lang['verifyPage'].'</a></h4> 
    <h4 style="margin-bottom:-1vh">'.$lang['pasteClick2'].'</h4>   
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
 } //End else 

 
//SUCCESS
if($mail->send() ) { 
 ?> <script> window.location.href='emailVerifyLog.php';  </script> <?php 

	//echo ' sent ';
}else{ ?>
  <div class=" height center above-lg">
    <span class="font-med"> <?php echo $lang['refresh'];?> </span>
  </div> 
<?php }
 //FAILURE
//$mail->ErrorInfo; 
 //REDIRECT
?> <!--<script> window.location.href='verify.php'; </script>--><?php
  
  
include $tmpl."footer.inc"; 
include "foot.php";
ob_end_flush(); 