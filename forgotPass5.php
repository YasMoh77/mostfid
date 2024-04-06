<?php
//ob_start();
session_start();       //important in every php page
$title='استعادة كلمة المرور ';       //title of the page
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




?> <div class="height"> <?php 

if($_SERVER['REQUEST_METHOD']=='POST') {	
     $code  =trim($_POST['code']);
     $pass  =trim($_POST['pass']);
     $rePass=trim($_POST['rePass']);
     $phone =isset($_POST['phone'])?$_POST['phone']:0;
     $email =isset($_POST['email'])?$_POST['email']:0;

     //$_SESSION['set']=array($email,$code);
     $filteredCode  =filter_var($code,FILTER_SANITIZE_STRING);
     $filteredPass  =filter_var($pass,FILTER_SANITIZE_STRING);
     $filteredRePass=filter_var($rePass,FILTER_SANITIZE_STRING);

     //strong password 
     $patternLower = "`[a-z]`";
     $patternUpper = "`[A-Z]`";
     $patternNumber = "`[0-9]`";

     $errors=array();
     //CODE
     if (empty($filteredCode)) {
     	$errors[]=$lang['enterCode'];
     }
     
     //PASSWORD
     elseif (empty($filteredPass) ) {
     	$errors[]=$lang['enterNewPass'];
     } 
     elseif (empty($filteredRePass) ) {
     	$errors[]=$lang['reEnterNewPass'];
     }
     elseif (strlen($filteredPass)<8 || strlen($filteredRePass)<8  ) {
     	$errors[]=$lang['passLeast'];
     } 
     elseif (strlen($filteredPass)>20 || strlen($filteredRePass)>20  ) {
          $errors[]=$lang['passMost'];
     } 
     elseif ($filteredRePass!==$filteredPass) {
     	$errors[]=$lang['passwordsNotMatch'];
     }
     elseif (!(preg_match($patternLower, $filteredPass)) || !(preg_match($patternLower, $filteredRePass)) ) {
          $errors[]=$lang['passLower'];
     }
     elseif (!(preg_match($patternUpper, $filteredPass)) || !(preg_match($patternUpper, $filteredRePass)) ) {
          $errors[]=$lang['passUpper'];
     }
     elseif (!(preg_match($patternNumber, $filteredPass)) || !(preg_match($patternNumber, $filteredRePass)) ) {
          $errors[]=$lang['passNumber'];
     }
     
     $PassFinal=password_hash($filteredRePass, PASSWORD_DEFAULT);
     

     if (!empty($errors)) {
	     	foreach ($errors as  $value) {
	     		echo '<span class="span-red">'.$value.'</span>';
	     	}
     	
     }else{
          if (isset($_POST['trader'])) { // => for traders
            
             $stmt=$conn->prepare(" SELECT code from user where code=? and phone=? "); 
             $stmt->execute(array($filteredCode,$phone) );
             $row=$stmt->rowCount();
                  if($row==0){ //CODE IS NOT IN DATABASE
                    echo '<span class="span-red">'.$lang['wrongCode'].'</span>';
                  }else{ //CODE IS IN DATABASE
                 $stmt3=$conn->prepare(" UPDATE user set password=?,activate=1 where code=? ");   
                 $stmt3->execute(array($PassFinal,$filteredCode));
                       if($stmt3){ //PASSWORD UPDATED
                         echo '<span class="block-green above-lg">'.$lang['passChanged'].'..جاري تحويلكم لصفحة تسجيل الدخول ...'.'</span>';
                         ?><script>
                              setTimeout(function go(){$('.block-green').fadeOut();},4200);
                              setTimeout(function go2(){ location.href='signinP.php';},4300);
                         </script><?php
                         
                        // echo '<br><a href="signinp.php" class="centered">'.$lang['login'].'</a>'; 

                       }
                  }



          }else{ // => for users
     	   $stmt2=$conn->prepare(" SELECT * from user where code=? and email=? ");	
		   $stmt2->execute(array($filteredCode,$email) );
		   $fetch=$stmt2->fetch();
			   if($fetch['code']!==$filteredCode){ //CODE IS NOT IN DATABASE
			   	echo '<span class="span-red">'.$lang['wrongCode'].'</span>';
			   }else{ //CODE IS IN DATABASE
	            $stmt2=$conn->prepare(" UPDATE user set password=?, activate=1 where code=? and email=? ");   
	            $stmt2->execute(array($PassFinal,$filteredCode,$email));
		             if($stmt2){ //PASSWORD UPDATED ?>
		             <span class="span-green"><?php echo $lang['passChanged']?></span>
                &nbsp;..&nbsp; <span class="span-green">سيتم توجيهك الآن لصفحة تسجيل الدخول  ...</span>
                 <script>setTimeout(function go(){location.href='signinU.php';},4000);</script> 
		          <?php   }
	             }  

              }//END else => if (isset($_POST['trader'])
          }



} // END if($_SERVER['REQUEST_METHOD']=='POST')






?>  </div>   <?php

include $tmpl."footer.inc";
