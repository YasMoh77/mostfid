<?php
ob_start();
session_start();
$title='دخول ';       //title of the page
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


//coming from signinU.php
			if($_SERVER['REQUEST_METHOD']=='POST') {
				   if (isset($_POST['user'])) {
						$email1    =trim($_POST['email']);
						$password1 =trim($_POST['password']);
						//$codeSess1 =trim($_POST['code']); 
						
						//filter
						$emailS  =filter_var($email1,FILTER_SANITIZE_STRING);
						$email   =filter_var($emailS,FILTER_VALIDATE_EMAIL);
						$password=filter_var($password1,FILTER_SANITIZE_STRING);
						//$codeSess=filter_var($codeSess1,FILTER_SANITIZE_STRING);
						//check //div-active-login
						if (empty($email)) { 
						  ?> <div class="center "><span class="red2"><?php echo $lang['addYourEmail']?> </span></div> <?php
						}elseif($email!= true){
                          ?> <div class="center red"><span class="red2"><?php echo $lang['checkEmail'].' .. '.$lang['insert'].' '.'11'.' '.$lang['digit']?> </span></div> <?php
						}elseif (empty($password)) {
						  ?> <div class="center red"><span class="red2"><?php echo $lang['enterPass']?> </span></div> <?php
						}/*elseif (empty($codeSess)) {
						  ?> <div class="center red"><span class="red2"><?php echo $lang['enterCode']?> </span></div> <?php
						}elseif ($codeSess !== $_SESSION['code']) {
						  ?> <div class="center red"><span class="red2"><?php echo $lang['wrongCode']?> </span></div> <?php
						}*/else{
							
						$stmt=$conn->prepare('SELECT  * FROM user WHERE email=? and trader=0 ');
						$stmt->execute(array($email));
						$fetched=$stmt->fetch();
						$row=$stmt->rowCount();
						
                       
						if ($row==0) { ?> <div class="center"><span  class="red2"><?php echo $lang['emailNotInData']?> </span></div> <?php }
                        if ($row>0){
                        	   //verify hashed pass
                        	if(password_verify($password, $fetched['password'])){
                        		if ($fetched['activate']==0) {
                        			//IF NOT ACTIVATED EMAIL   
                                    $code1=md5(rand(17000,100000));
                                    $code=substr($code1,0,6); 
                                    //update user set code=? 
                                   echo update('user','code',$code,'email',$fetched['email']);
                                    $arr=[$fetched['email'],$code]; 
                        			$_SESSION['codeLoginMos']=$arr;
                        		?><script>location.href='emailVerifyLogin.php';</script> <?php
                        		
                        		}elseif ($fetched['activate']==2) {
                        			echo '<div class="center"><span  class="red2">تم حظرك من دخول الموقع لمخالفتك شروط الاستخدام  </span></div>';
                        		}else{

							 //set cookies to continue sessions
							 $_SESSION['userE']=$fetched['name'];
                             $_SESSION['userEid']=$fetched['user_id'];

                             setcookie('cookEName',$_SESSION['userE'],time()+ 60*60*24*365*15,'/','localhost',true,true);
                             setcookie('cookEId',$_SESSION['userEid'],time()+ 60*60*24*365*15,'/','localhost',true,true); 
                             
                             //to help remember email & password
                             if (isset($_POST['remember'])) {
                             //save sign in info inside cookies
                             $_SESSION['REmail']=$fetched['email']; 
                             $_SESSION['RPass']=$password;
                             setcookie('remember_email',$_SESSION['REmail'],time()+ 60*60*24*365*15,'/','localhost',true,true);
                             setcookie('remember_password',$_SESSION['RPass'],time()+ 60*60*24*365*15,'/','localhost',true,true);
                              }
							 
							 ?><script>location.href='index.php';</script> <?php
							   
                             }  //END if ($fetched['activate']==0

                        	}else{ //wrong password
                        		echo '<div class="center"><span  class="red2">'.$lang['checkPass'].'</span></div>';
                        	}

                 }  //END if ($row>0)
              }  //END else


          }else{ //END if(isset($_POST['user']))
			             //trader data
			            $phone1    =trim($_POST['phone']);
						$password1 =trim($_POST['password']);
						//$codeSess1 =trim($_POST['code']);
						 
						//filter
						$phone  =filter_var($phone1,FILTER_SANITIZE_NUMBER_INT);
						$password=filter_var($password1,FILTER_SANITIZE_STRING);
						//$codeSess=filter_var($codeSess1,FILTER_SANITIZE_STRING);
						//check
						if (empty($phone)) { 
						  ?> <div class="div-active-login"><span><?php echo $lang['enterPhone']?> </span></div> <?php
						}elseif(strlen($phone)!=11){
                          ?> <div class="div-active-login"><span><?php echo $lang['checkPhoneNum'].' .. '.$lang['insert'].' '.'11'.' '.$lang['digit']?> </span></div> <?php
						}elseif (empty($password)) {
						  ?> <div class="div-active-login"><span><?php echo $lang['enterPass']?> </span></div> <?php
						}/*elseif (empty($codeSess)) {
						  ?> <div class="center red"><span class="red2"><?php echo $lang['enterCode']?> </span></div> <?php
						}elseif ($codeSess !== $_SESSION['code']) {
						  ?> <div class="center red"><span class="red2"><?php echo $lang['wrongCode']?> </span></div> <?php
						}*/else{
						$checkPhone=checkItem('phone','user',$phone);
                       
						if ($checkPhone==0) { ?> <div class="div-active-login"><span><?php echo $lang['phoneNotInDt']?> </span></div> <?php } 
                        if ($checkPhone>0){
                        	$fetched=fetch2('*','user','phone',$phone,'trader',1);
                        	
							 if ($fetched['trader']==0) { //this is a user not a trader
							 	?> <div class="div-active-login">
							 		<span>غير مسموح لك تسجيل الدخول من هنا</span>
							 		<span class="alone">اضغط  <a class="white bold" href='login.php'>هنا </a>لتسجيل الدخول</span>
							 		</div> <?php
							 }else{
							 	 if ($fetched['activate']==0) { //not activated
                                    ?><script>location.href='update-tr-dt.php?t=<?php echo $phone?>'; </script> <?php
							 	 }elseif ($fetched['activate']==2) { //deactivated=banned
                                    ?><div class="div-active-login"><span>تم حظرك لمخالفة شروط الموقع  </span></div> <?php
							 	 }elseif($fetched['password']==null){
                                       ?><div class="div-active-login"><span>ليس لك صلاحية  تسجيل الدخول من هنا  <br>سيتم تحويك للموضع المناسب  الآن ....</span></div>
                                       <script>
                                       setTimeout(function go(){location.href='partnerCheck.php'; },5500);
                                       	
                                       </script> <?php
							 	 }else{
                        	   //verify hashed pass
                        	if(password_verify($password, $fetched['password'])){ 
							//set cookies to continue sessions
							 $_SESSION['trader']=$fetched['commercial_name'];
                             $_SESSION['traderid']=$fetched['user_id'];

                             setcookie('cook_trader',$_SESSION['trader'],time()+ 60*60*24*365*15,'/','mostfid.com',true,true);
                             setcookie('cook_traderid',$_SESSION['traderid'],time()+ 60*60*24*365*15,'/','mostfid.com',true,true); 
                             
                             //to help remember email & password
                             if (isset($_POST['remember'])) { 
                             //save sign in info inside cookies
                             $_SESSION['phoneMos']=$fetched['phone'];
                             $_SESSION['passMos']=$password;
                             setcookie('phoneMos',$_SESSION['phoneMos'],time()+(60*60*24*365*15),'/','localhost',true,true);
                             setcookie('passMos',$_SESSION['passMos'],time()+(60*60*24*365*15),'/','localhost',true,true);
                              }
							 ?><script>location.href='index.php';</script><?php

                        	}else{ //wrong password
                        		echo '<div class="div-active-login"><span>'.$lang['checkPass'].'</span></div>';
                        	}
                        }//End if activate==0 &&  if password==null
                    }//////// //END else => if ($fetched['trader']==0)
                 }  //END if ($row>0)
              }  //END else

          }



		} //END if($_SERVER['REQUEST_METH




include $tmpl."footer.inc";   
ob_end_flush();
