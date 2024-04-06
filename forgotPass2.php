<?php
//ob_start();
session_start();       //important in every php page
$title='طلب كلمة مرور جديدة ';       //title of the page
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



//RECEIVE FORM DATA COMING FROM FORGETPASS, THEN SENDING TO FORGETPASS3

if($_SERVER['REQUEST_METHOD']=='POST') {	

    if (isset($_POST['trader'])) { 
      ?> <div class="center"> <?php
      //traders
        $phone=filter_var(trim($_POST['phone']),FILTER_SANITIZE_NUMBER_INT);
        $code1=md5(rand(9999,190000));
        $code=substr($code1,0,5);
       $stmt=$conn->prepare(" SELECT * from user where phone=? and trader=1 "); 
       $stmt->execute(array($phone));
       $fetch=$stmt->fetch();
       $row=$stmt->rowCount(); 

      
      if ($row>0) {
         if ($fetch['activate']!=2) {
           $stmt=$conn->prepare(" UPDATE user set code=? , activate=?  where phone=? ");   
           $stmt->execute(array($code,0,$phone));
             if ($stmt) {
               ?><script> location.href='forgotPass4Tr.php?t=<?php echo $phone ?>'; </script> <?php
             }
         }else{
           ?><span class="add-email-verify red2">تم حظرك لمخالفة شروط الموقع  </span><?php
         }
         
       }else{
        ?><span class="add-email-verify">هذا الرقم غير مسجل لدينا</span><?php
      }
   ?>  </div>   <?php


 



    }else{ //users
    ?>  <div>   <?php
    $email=trim($_POST['email']);
    $code1=md5(rand(10000,100000));
    $code=substr($code1,0,6);

   $emailSanitzed=  filter_var($email,FILTER_SANITIZE_EMAIL);
   $emailValidated=  filter_var($emailSanitzed,FILTER_VALIDATE_EMAIL);
     
     if($emailValidated != true){
        echo '<p class="red2">'.$lang['checkEmail'].'</p>';
     }else{
	     $stmt=$conn->prepare(" SELECT * from user where email=? and trader=0 ");	
		   $stmt->execute(array($emailSanitzed));
       $fetch=$stmt->fetch();
		   $row=$stmt->rowCount();
       $fetchedEmail=$fetch['email'];
		   if($fetchedEmail !== $emailSanitzed){
		        	echo '<span>'.$lang['emailNotInData'].'</span>'; 
		   }else{
             if ($fetch['activate']!=2) {
                $name=$fetch['name'];
                $_SESSION['set']=array($emailSanitzed,$code,$name);
                $stmt2=$conn->prepare(" UPDATE user set code=?,activate=0 where email=? ");   
                $stmt2->execute(array($code,$emailSanitzed));
                ?> 
                 <div class="center"><span class="spinner-border spinner-border-del"></span></div> 
                 <script>location.href='forgotPass3.php';</script>
               <?php
            }else{ ?><span class="red2">تم حظرك لمخالفة شروط الموقع  </span> <?php }
       }

    }
?>  </div>   <?php

  } //END else => isset($_POST['trader']

}



include $tmpl."footer.inc"; 
