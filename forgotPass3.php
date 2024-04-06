<?php
session_start();  
$title='Forgot Password';       //title of the page
include 'init.php';   //included files

//RECEIVING DATA FROM FORGOTPASS2.PHP
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once "phpmailer/vendor/autoload.php";

//$_SESSION['set'][0]=EMAIL, $_SESSION['set'][1]=CODE, $_SESSION['set'][2]=NAME
if($l=='ar'){ 
  ?><span class="spinner-border spinner-border-del"></span> <?php
$mail=new PHPMailer();
ini_set('max_execution_time', 300); //in order not to throw wrong msg when network is slow

$mail->CharSet = 'UTF-8'; // stop wrong encoding
$mail->Encoding = 'base64'; // stop wrong encoding

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
$mail->addAddress($_SESSION['set'][0]); //SENT TO
$mail->Subject=$lang['newPASS'];
$mail->isHTML(true);
$mail->Body= '
     <h1 style="text-align:right;">'.$lang['hello'].' '.$_SESSION['set'][2].'</h1>
      <br>

     <center><div>
     <h1>'.$lang['requestedNewPass'].'</h1>

     <h2 style="background-color:#18b6ae;color:white;padding:1vh 0vw">www.mostfid.com</h2>
     <br><br><br>

     <h3> '.$lang['useCode4Pass'].'</h3>
     <center><h2 style="background-color:orange;color:white;font-weight:bold;padding:3vh 2vw;width:fit-content;"> '.$_SESSION['set'][1].'</h2></center>
     <br><br><br>
 </div></center>

  <strong><h2 style="text-align:right;text-decoration:underline">'.$lang['plsFollow'].'</h2></strong>
  <div style="text-align:right;list-style-type:circle">
    <h3 style="margin-bottom:-1vh">'.$lang['copyCode'].'</h3> 
    <h3 style="margin-bottom:-1vh">'.$lang['goTo'].' '.'<a href="https://www.mostfid.com/forgotPass4.php">'.' '.$lang['verifyPage'].'</a></h3> 
    <h3 style="margin-bottom:-1vh">'.$lang['pasteClick'].'</h3>   
  <br>
  <h5 style="margin-bottom:-1vh">'.$lang['ignoreF'].'</h5>
</div>


     <br><br><br>
     <center>
       <h2>'.$lang['regards'].'</h2>
       <h2>'.$lang['MostafedTeam'].'</h2> 
       <h4><a href="https://www.mostfid.com">www.mostfid.com</a></h4>
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
}else{  //English
    ?><span class="spinner-border spinner-border-del"></span> <?php
$mail=new PHPMailer();
ini_set('max_execution_time', 300); //in order not to throw wrong msg when network is slow


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
$mail->addAddress($_SESSION['set'][0]); //SENT TO
$mail->Subject=$lang['newPASS'];
$mail->isHTML(true);
$mail->Body= '
 <div>
     <h1>'.$lang['hello'].' '.$_SESSION['set'][2].'</h1>
     <br>
     <h3>'.$lang['requestedNewPass'].'</h3>
    
     <center>
     <h2 style="background-color:#18b6ae;color:white;padding:1vh 0vw">www.mostfid.com</h2>
     </center>
     <br><br>

     <h3> '.$lang['useCode4Pass'].'</h3>
     <center><h1 style="background-color:orange;color:white;font-weight:bold;padding:3vh 2vw;width:fit-content;"> '.$_SESSION['set'][1].'</h1></center>
     <br><br>
 </div>

  <strong><h3 style="text-decoration:underline">'.$lang['plsFollow'].'</h3></strong>
  <div style="">
    <h4 style="margin-bottom:-1vh">'.$lang['copyCode'].'</h4> 
    <h4 style="margin-bottom:-1vh">'.$lang['goTo'].' '.'<a href="https://www.mostfid.com/forgotPass4.php">'.' '.$lang['verifyPage'].'</a></h4> 
    <h4 style="margin-bottom:-1vh">'.$lang['pasteClick'].'</h4>   
  <br>
  <h5 style="margin-bottom:-1vh">'.$lang['ignoreF'].'</h5>
</div>

     <br><br><br>
     <center>
       <h2>'.$lang['regards'].'</h2>
       <h2>'.$lang['MostafedTeam'].'</h2>
       <h4><a href="https://www.mostfid.com">www.mostfid.com</a></h4>
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
}

//SUCCESS
if($mail->Send() ){ 
   ?><script>window.location.href='forgotPass4.php';</script> <?php
   
}else{ ?>
  <div class=" height center above-lg">
    <span class="font-med"> <?php echo $lang['refresh'];?> </span>
  </div> 
<?php }

 //FAILURE
//$mail->ErrorInfo;
 //REDIRECT
?> <!--<script> window.location.href='forgotPass4.php'; </script>--><?php



include $tmpl."footer.inc";
include 'foot.php';    
