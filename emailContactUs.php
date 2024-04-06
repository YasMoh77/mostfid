<?php
//ob_start();
session_start();       //important in every php page
$title='Send Message ';       //title of the page
include 'init.php';   //included files




//$_SESSION['contactUs'][0][1][2][3]==NAME,PHONE,REASON,MESSAGE from contactUs.php



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once "phpmailer/vendor/autoload.php";


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
$mail->Password="jchikyvzwpmhzcoq";        //GMAIL PASSWORD
$mail->SMTPSecure="tls";
$mail->Port="587";
//////
  if(isset($_SESSION['contactUs']) ){ //contactUs.php
   $name=$_SESSION['contactUs'][0];
   $phone=$_SESSION['contactUs'][1];
   $reason=$_SESSION['contactUs'][2];
   $message=$_SESSION['contactUs'][3];
 }
  

/////////

//FROM, SUBJECT, BODY, ATTACHMENT
$mail->From='yassermoh396@gmail.com'; //SENT FROM
$mail->FromName="contact Us - Mostafed";
//$mail->addReplyTo('hgq1100@yahoo.com');//NOT IMPORTANT
$mail->addAddress('hgq1100@yahoo.com'); //SENT TO
$mail->Subject=$reason;
$mail->isHTML(true);
$mail->Body='
<h1> Hello Yasser </h1>
<h3> From: &nbsp; '.$name.' &nbsp; </h3>
<h3> Phone: &nbsp; '.$phone.'</h3>
<h3> Contact Reason: &nbsp; '.$reason.'</h3>
<h3> Message: </h3>

 <br>
  <h3 style="color:red">'.$message.'</h3>

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


//SUCCESS
if($mail->Send() ) { 
	
  if(isset($_SESSION['contactUs']) ){//text-center
    ?> <br><br><br>
    <?php
    echo "<div class='block-green font-size go'>".$lang['msgSent']."</div>";
    ?> <br><br><br> 
    <script>
     setTimeout(function div(){ $('.go').fadeOut();},2550);
     setTimeout(function go(){location.href='index.php';},2650);
    </script>
  <?php }

}else{
  include 'oops.php';
  $mail->ErrorInfo; 
}
 //FAILURE
//$mail->ErrorInfo;
   

include $tmpl."footer.inc"; 
include "foot.php"; 