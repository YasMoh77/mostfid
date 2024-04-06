<?php
//ob_start();
session_start();       //important in every php page
$title='Password Reset';       //title of the page
?><link rel="canonical" href="https://mostfid.com/update-tr-dt.php" > <?php
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




// ACTIVATING TRADER'S PHONE NUMBER => COMING FROM PROFILE- p='data'
if(isset($_SESSION['traderid'])){
  ?> <div class="height"> <?php
   if($_SERVER['REQUEST_METHOD']=='POST') {	
    
     $code  =trim($_POST['code']);
     $phone =$_POST['phone'];
     $filteredCode  =filter_var($code,FILTER_SANITIZE_NUMBER_INT);
     //check user_id
     $stmt=$conn->prepare("SELECT user_id FROM user WHERE phone=? AND trader=1 and activate=0 ");
     $stmt->execute(array($phone)); $row=$stmt->rowCount();
       
    if ($row>0) { //trader was found & number is correct 
         $errors=array();
         //CODE
         if (empty($filteredCode)) {
         	$errors[]=$lang['enterCode']; 
         }
         if (!empty($errors)) {
     	      foreach ($errors as  $value) {
     		    echo '<span class="span-red">'.$value.'</span>';
     	   }
         	
         }else{ 
         	   $stmt4=$conn->prepare(" SELECT code from user where code=? and phone=? "); 
             $stmt4->execute(array($filteredCode,$phone) );
             $row2=$stmt4->rowCount();
                  if($row2==0){ //CODE IS NOT IN DATABASE
                    echo '<span class="span-red">'.$lang['wrongCode'].'</span>';
                  }else{ //CODE IS IN DATABASE
                 $stmt3=$conn->prepare(" UPDATE user set phone=?,activate=1 where code=? ");   
                 $stmt3->execute(array($phone,$filteredCode));
                       if($stmt3){ //PASSWORD UPDATED
                         echo '<span class="block-green above-lg">تم تغيير رقم التليفون ؛ سيتم توجيهك لصفحة الحساب  </span>';
                         ?><script>
                         	setTimeout(function go(){$('.block-green').fadeOut();},4100); 
                            setTimeout(function go2(){location.href='profile.php?i=<?php echo $_SESSION['traderid']?>&p=data';},4200);
                           </script><?php 

                        } 
                     }
                  } 
                }
          }
  ?> </div> <?php 




// ACTIVATING TRADER'S PHONE NUMBER => COMING FROM signinP.php
}else{
  //no session 
  ?> <div class="div-height"> <?php
   if($_SERVER['REQUEST_METHOD']=='POST') {   
     $code  =trim($_POST['code']);
     $phone =$_POST['phone'];
     $filteredCode  =filter_var($code,FILTER_SANITIZE_STRING);
     //check user_id
     $stmt=$conn->prepare("SELECT user_id,phone FROM user WHERE phone=? AND trader=1 and activate=0 ");
     $stmt->execute(array($phone)); $fetch=$stmt->fetch();
         $errors=array();
         //CODE
         if (empty($filteredCode)) {
          $errors[]=$lang['enterCode']; 
         }
         if (!empty($errors)) {
            foreach ($errors as  $value) {
            echo '<span class="span-red">'.$value.'</span>';
         }
          
         }else{ 
             $stmt=$conn->prepare(" SELECT code from user where code=? and phone=? and user_id=? AND trader=1 and activate=0"); 
             $stmt->execute(array($filteredCode,$fetch['phone'],$fetch['user_id']) );
             $row=$stmt->rowCount();
                  if($row==0){ //CODE IS NOT IN DATABASE
                    echo '<span class="span-red">'.$lang['wrongCode'].'</span>';
                  }else{ //CODE IS IN DATABASE
                 $stmt3=$conn->prepare(" UPDATE user set activate=1 where phone=? and code=? ");   
                 $stmt3->execute(array($phone,$filteredCode));
                       if($stmt3){ //PASSWORD UPDATED
                         echo '<span class="above alone green">تم تغيير رقم التليفون ؛ سيتم توجيهك لصفحة تسجيل الدخول  ...</span>';
                         ?><script>
                          setTimeout(function go(){$('.block-green').fadeOut();},3700);
                            setTimeout(function go(){location.href='signinP.php';},3750);
                           </script><?php

                        }
                     }
                  }
             
          }
  ?> </div> <?php

}






?>  </div>   <?php
include $tmpl."footer.inc";
