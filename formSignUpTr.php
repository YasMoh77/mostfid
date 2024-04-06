<?php
ob_start();
session_start();
$title='تسجيل مقدم خدمة ';       //title of the page
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




// completing trader register => coming from signUpTrader.php
    if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

			if (isset($session) ) {
				header('location:index.php');
				exit();
			  }

			//checking if request method is 'POST'
			if($_SERVER['REQUEST_METHOD']=='POST') {
			        // complete trader data by trader itself 
			        $phone  =$_POST['phone'];
			        $country=$_POST['country'];	
				  	$pass1  =$_POST['password'];
				  	$pass2  =$_POST['password2'];
				  	$pass=trim($pass2)===trim($pass1)?trim($pass2):'no';
				  	$filteredPass1  =filter_var(trim($pass),FILTER_SANITIZE_STRING);
				  	$codeSess1=$_POST['code'];
				  	$codeSess  =filter_var(trim($codeSess1),FILTER_SANITIZE_STRING);
				  	$terms  =isset($_POST['terms'])?1:0;
				  	$date=time();
				  	$msgtxt='أهلا بكم في موقع مستفيد؛ هذا الموقع أنشأناه بفضل الله بعد  طول دراسة وتفكير ليحقق بإذن الله الفائدة للجميع؛ الرجاء الالتزام بشروط استخدام الموقع مع الأمانة والصدق في التعامل. نشكر لكم تعاونكم معنا ..ادارة موقع مستفيد ';
				    //strong password
                    $patternLower = "`[a-z]`";
					$patternUpper = "`[A-Z]`";
					$patternNumber = "`[0-9]`"; 
				    

	                 //start errors
				 	$errors=array();
                        //post coming from signUpTrader... by user itself
				  		//PASSWORD
					  	if($filteredPass1=='no') {
					  		$errors[]=$lang['passwordsNotMatch'];
					    }
					    elseif(strlen(trim($filteredPass1))<8) {
					  		$errors[]=$lang['passLeast'];
					    }
					  	elseif(strlen(trim($filteredPass1))>20) {
					  		$errors[]=$lang['passMost'];
					  	}
						elseif(!(preg_match($patternLower, $filteredPass1)) ){
						    $errors[]=$lang['passLower'];

						}elseif(!(preg_match($patternUpper, $filteredPass1)) ){
						    $errors[]=$lang['passUpper'];

						}elseif(!(preg_match($patternNumber, $filteredPass1)) ){
						    $errors[]=$lang['passNumber'];
						}
						//code
					  	if($codeSess!==$_SESSION['code']) {
					  		$errors[]=$lang['wrongCode']; 
					  	}
						//TERMS
					  	if($terms==0 ) {
					  		$errors[]=$lang['agreeTerms']; 
					  	}

					   $filteredPass=password_hash($filteredPass1, PASSWORD_DEFAULT);
					  //PHONE 
					    $filteredPhone=filter_var(trim($phone),FILTER_SANITIZE_NUMBER_INT);
				        $result2=phone($country,$filteredPhone);//checks if phone suits country
				        $fetch=fetch('phone','user','phone',$filteredPhone);
				        $phoneUsed=$fetch['phone'];
				        
				        if ($result2[0]==2) {
				        $errors[]=$lang['checkPhoneNum'].' .. '.$lang['insert'].' '.$result2[1].' '.$lang['digit'];
				        }elseif ($phoneUsed!=$filteredPhone) {
				        $errors[]=$lang['phoneNotInDt']; 
				        }
				  	


                     //end errors
				  if (!empty($errors)) {
				   foreach ($errors as  $value) { 
					echo  '<span class="block2 ">'.$value.'</span>';
				   }
			      
				 }else{ 
				           // complete trader data 
				 	    	$check=checkItem2('phone','user',$filteredPhone,'trader',1);
				 	    	$fetch=fetch('password','user','phone',$filteredPhone);
				 	    	if ($check>0 && $fetch['password']==null ) { 
                        	// update traders
                       	 $stmt=$conn->prepare(' UPDATE user set password=?   where phone=? and trader=1 ');  
			             $stmt->execute(array($filteredPass,$filteredPhone));
						   if($stmt){  
	                       		?><div class='block-green'>
	                       			<?php echo 'تم استكمال البيانات    ';?>
	                       			<span class="white right">سيتم تحويلك لصفحة تسجيل الدخول</span>
	                       			<script>setTimeout(function go(){location.href='signinP.php';},3500);</script>	
	                       		</div><?php  
	                       		//insert welcome message
	                       		$fetchUid=fetch('user_id','user','phone',$filteredPhone);
	                       		$stmt=$conn->prepare("INSERT INTO   message(message_text,message_date,message_from,message_to ) 
							                                        VALUES (:ztext,:zdate,7,:zto )");
					            $stmt->execute(array(
								   "ztext"    =>   $msgtxt,
								   "zdate"    =>   $date,
								   "zto"      =>   $fetchUid['user_id']
					               ));

						   }else{ //stms not executed  
						 	echo "<div class='block2 above-lg'>".$lang['connectFail']."</div>";
						   }
						}else{echo "<div class='block2 above-lg'>عفوا ..لم يتم العثور على هذه البيانات  </div>";}
               
			  } //END  if (empty($errors))
	        
	        }else{ //END $_SERVER['REQUEST_METHOD'] condition
              header('location:login.php');
              exit();
	        }




include $tmpl."footer.inc";   
ob_end_flush();