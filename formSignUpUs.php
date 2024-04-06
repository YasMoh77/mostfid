<?php
ob_start();
session_start();
$title='تسجيل عو جديد';       //title of the page
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



// registering new user => coming from signUpU.php
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
					//store data in variables
				    $user   =$_POST['username'];
				  	$pass1  =$_POST['password'];
				  	$pass2  =$_POST['password2'];
				  	$email  =$_POST['email'];
				  	$phone  =$_POST['phone'];
				  	$country=$_POST['country'];
				  	$state  =$_POST['state'];
				  	$city   =$_POST['city'];
				  	$codeSess   =$_POST['code'];
				  	$terms  =isset($_POST['terms'])?1:0;
				  	date_default_timezone_set('Africa/Cairo');
				    $date   =date('Y-m-d');
				  	$getRandom=md5(rand(1000,10000));
                    $code=substr($getRandom, 0,6);
	                $pass=trim($pass2)===trim($pass1)?trim($pass2):'no';
	                
	                 
	                 //start sanitize & validate
				  	$filteredUser   =filter_var(trim($user),FILTER_SANITIZE_STRING);
				  	$filteredPass1  =filter_var(trim($pass),FILTER_SANITIZE_STRING);
				  	$filteredPhone  =filter_var(trim($phone),FILTER_SANITIZE_NUMBER_INT);
                	$filteredEmail  =filter_var(trim($email),FILTER_SANITIZE_EMAIL);
				  	$validatedEmail =filter_var($filteredEmail,FILTER_VALIDATE_EMAIL);
				  	//array with email & code 
				    $_SESSION['codeSignUpMos']=array($email,$code);
                   

				    //strong password
                    $patternLower = "`[a-z]`";
					$patternUpper = "`[A-Z]`";
					$patternNumber = "`[0-9]`";
				  
	                 //start errors
				 	$errors=array();
				 	//USER
				  	if(strlen(trim($filteredUser))<4) {
				  		$errors[]=$lang['usernameLeast'];
				  	}elseif(strlen(trim($filteredUser))>60) {
				  		$errors[]=$lang['usernameLong'];
				  	}
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
				  	
				  	$filteredPass=password_hash($filteredPass1, PASSWORD_DEFAULT);

                     //EMAIL
				  	$check2=checkItem('email','user', $filteredEmail);
					if (empty($email)) {
						$errors[]=$lang['addYourEmail'];
					}elseif($validatedEmail != true) {
				  		$errors[]=$lang['checkEmail'];
				  	}elseif ($check2>0) {
					 $errors[]= '( '.$filteredEmail.' )'.' '.$lang['emailTaken'];
                    }
					  	
				  	//PHONE 
					$start=strpos($filteredPhone,'01');
					$start2=strpos($filteredPhone,'3');

		        	$result1=phone($country,$filteredPhone);//checks if phone suits country
		        	$fetch2=fetch('phone','user','phone',$filteredPhone);
			        if ($result1[0]==2) {
			        $errors[]=$lang['checkPhoneNum'].' .. '.$lang['insert'].' '.$result1[1].' '.$lang['digit'];
			        }elseif ($start!==0) {
			        $errors[]=$lang['checkPhoneNum'];
			        }elseif ($start2===2) {
			        $errors[]=$lang['checkPhoneNum'];
			        }elseif ($fetch2['phone']>0) {
			        $errors[]=$lang['phoneTaken'];
			        }
			        
			        //COUNTRY
				  	if($country==0 ) {
				  		$errors[]=$lang['chooseCont'];
				  	}
				  	//STATE
				  	if($state==0 ) {
				  		$errors[]=$lang['chooseSt'];
				  	}
				  	//CITY
				  	if($city==0 ) {
				  		$errors[]=$lang['chooseCity'];
				  	}
				  	//code
				  	if($codeSess!==$_SESSION['code']) {
				  		$errors[]=$lang['wrongCode']; 
				  	}
				  	//TERMS
				  	if($terms==0 ) {
				  		$errors[]=$lang['agreeTerms']; 
				  	}
				  	
                     

                     //end errors
				  if (!empty($errors)) {
				   foreach ($errors as  $value) {
					echo  '<div class="block2 ">'.$value.'</div>';
				   }
			      
				 }else{ //trader or user ?
                       	   //check if this new user is a trader
                       	  $check=checkItem('phone','user',$filteredPhone);
                       	  if ($check>0) { ?>
                       	  	<div class="block2 ">أنت مضاف في الموقع بالفعل  <a href="signinP.php"><?php echo $lang['doLogin'] ?></a></div>
                       	 <?php }else{
                  
                        	// insert into users
                        $stmt=$conn->prepare('INSERT INTO  
					    	user(name,password,email,phone,country_id,state_id,city_id,reg_date,came_from,activate,code)
					     VALUES(:zname,:zpass,:zemail,:zphone,:zcountry,:zstate,:zcity,:zdate,1,0,:zcode)');
			             $stmt->execute(array(
			               "zname"    =>    $filteredUser,
			               "zpass"    =>    $filteredPass,
						   "zemail"   =>    $filteredEmail,
						   "zphone"   =>	$filteredPhone,
						   "zcountry" =>	$country,
						   "zstate"   =>	$state,
						   "zcity"    =>	$city,
						   "zdate"    =>	$date,
						   "zcode"    =>    $code
								   
					                    ));
						   if($stmt){  //redirect to send a verification email
	                       	?>
	                       	<span class="spinner-border spinner-border-del" role="status" aria-hidden="true"></span>
	                       	<script>window.location.href='emailVerifySignUp.php';</script><?php
						   }else{ //stms not executed
						 	echo "<div class='text-center bottom'><span class='span-green'>".$lang['connectFail']."</span></div>";
						  } 
					  }  // END if ($check>0)
			     } //END  if (empty($errors))
	        
	        }else{ //END $_SERVER['REQUEST_METHOD'] condition
              header('location:login.php');
              exit();
	        }




include $tmpl."footer.inc";   
ob_end_flush();