<?PHP

ob_start();
session_start();
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



			 			
			 		
   // THIS POST COMING FROM  (emailverifyLog.php)
	if($_SERVER['REQUEST_METHOD']=='POST') { 						
	      //store data in variables
	      $code1=$_POST['code'];
          $code=  filter_var(trim($code1),FILTER_SANITIZE_STRING);
          $email=$_POST['email'];
          $update=isset($_POST['update'])?1:0; 
          //welcome msg
           $dateMsg=time();
		   $msgtxt='أهلا بكم في موقع مستفيد؛ نرجو منكم الجدية عند تقديم طلبات شراء؛ في حالة عدم الجدية أو استخدام الموقع للتجريب ينعتبر هذا مخالفة لشروط الخدمة وسنضطر آسفين لحظر حسابكم . نشكر لكم تعاونكم معنا ..ادارة موقع مستفيد ';
		
		 $stmt=$conn->prepare(" SELECT activate from user where  code=?  and email=? and activate>0 ");	
		 $stmt->execute(array($code,$email));
	 	 $row=$stmt->rowCount();

	 if ($row>0) { // IF activate >0
	 	        ?>
			 	<div>
			 		<p> <span class="span-red"><?php echo $lang['alreadyVerify']?></span></p>
			 	</div>
			    <?php 
	 
     }else{ // not activated
     	$stmt2=$conn->prepare(" SELECT  code,user_id from user  where code=? and email=? ");	
		$stmt2->execute(array($code,$email));
		$USER=$stmt2->fetch();
		$row2=$stmt2->rowCount();
		if ($row2>0) { //code is true
			    $stmt3=$conn->prepare(" UPDATE  user set activate=1 where code=?");	
		  	    $stmt3->execute(array($code));
			 	?> <div> <p> <span class="span-green centered"><?php
			 		 
			 		if($update==1){ 

			 			echo $lang['successUpdate']; ?>
			 			<p class="centered"><span>سيتم توجيهك لصفحة  الحساب  ...</span></p>
				 		 <script>
				 		 setTimeout(function go(){ window.location.href='profile.php?i=<?php echo $USER['user_id']?>&p=data'; },4000); 
				 		</script>

			 	   <?php }else{

			 	    	echo $lang['successVerify']; ?> 
			 	    	<p class="centered"><span>سيتم توجيهك لصفحة تسجيل الدخول  ...</span></p>
				 		 <script>
				 		 setTimeout(function go(){ window.location.href='signinU.php'; },4000); 
				 		</script> 

			 	  <?php  } 
			 		
			 	?></span></p></div> <?php 
			 	//send
			 	//insert welcome message
			 	$userID=fetch2('user_id','user','email',$email,'code',$code);
           		$stmt=$conn->prepare("INSERT INTO   message(message_text,message_date,message_from,message_to ) 
			                                        VALUES (:ztext,:zdate,7,:zto )");
	            $stmt->execute(array(
				   "ztext"    =>   $msgtxt,
				   "zdate"    =>   $dateMsg,
				   "zto"      =>   $userID['user_id']
	               ));


			     
		}else{ //code isn't true ?>
	 	<div class="wrong-code">
	 		<p> <span class="span-red"><?php echo $lang['wrongCode']?></span></p>
	 	</div>
       <?php 
		}
     }
}else{ //end if($_SERVER['REQUEST_METHOD']=='POST')
	header('location:login.php');
	exit();
}




include $tmpl."footer.inc";  
ob_end_flush();