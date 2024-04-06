<?php
//ob_start();
session_start();       //important in every php page
$title='report';       //title of the page
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




if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google 
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

if (isset($session)) {
  		if ($_SERVER['REQUEST_METHOD']=='POST') {
	  			if(isset($_POST['immoral'])||isset($_POST['repeated'])||isset($_POST['fraud'])||isset($_POST['txtReport']) ){
	  		   $immoral =isset($_POST['immoral'])&&$_POST['immoral']==1?$_POST['immoral']:0;
		       $repeated=isset($_POST['repeated'])&&$_POST['repeated']==2?$_POST['repeated']:0;
		       $fraud   =isset($_POST['fraud'])&&$_POST['fraud']==3?$_POST['fraud']:0;
		       $text    =$_POST['txtReport'];//text
		       $item_id =$_POST['item'];//<!-- item reported -->
		       $user_id =$_POST['user'];//<!-- reporter -->
		       $date=date('Y-m-d');
		       $value=' ';
		       
		       $filteredMsg=filter_var(trim($text),FILTER_SANITIZE_STRING);

		       if ($immoral==1) {
		       	$value=1;  
		       }elseif ($repeated==2) {
		        $value=2; 
		       }elseif ($fraud==3) {
		        $value=3; 
		       }else{
		      	$value=$filteredMsg; 
		       }
	 
	  		
	  	
	  	   
		  	if ((strlen($filteredMsg)>0)||$immoral==1||$repeated==2||$fraud==3 ) {
		  		$checkUser=checkItem3('item_id','user_id','report',$item_id,$user_id);
			  		if ($checkUser==1) {
			  			$stmt=$conn->prepare(" UPDATE report set value=?  where  item_id=? and user_id=? ");
			            $stmt->execute(array($value,$item_id,$user_id));
			            if ($stmt) {
			            	?>
			            	<span class='sent green'>تم التبليغ عن الاعلان  </span> 
			            	<?php 
			            }else{
			            	?><span class="sent red2">حدث خطأ؛ تأكد من الاتصال وأعد المحاولة  </span> <?php
			            }

			  		}else{
			  			//insert new report
			  		$stmt=$conn->prepare(" INSERT into report 
		      	 	(value,report_date,item_id,user_id) 
		      	 	values(:zvalue,:zdate,:zitem,:zuser) ");
			         $stmt->execute(array(
			         'zvalue'    => $value,
			         'zdate'     => $date,
		             'zitem'     => $item_id,
		             'zuser'     => $user_id
		              ));
			         if ($stmt) {
			            	?>
			            	<span class='sent green'>تم التبليغ عن الاعلان  </span> <?php
			            }else{
			            	?><span class="sent red2">حدث خطأ؛ تأكد من الاتصال وأعد المحاولة  </span> <?php
			            }

			  		}

		  }else{ //END if ((strlen($filteredMsg)>0)
		  	echo "<span class='sent red2'>".$lang['chooseReason']."</span>";
		  }


 

		  //report trader => coming from profile-bought
      }elseif(isset($_POST['ReportTr'])&&isset($_POST['order']) ){
	       $text    =isset($_POST['ReportTr'])?$_POST['ReportTr']:'';//text
	       $order_id=$_POST['order'];//<!-- order reported -->
	       $date    =time();
	       
	       $filteredMsg=filter_var(trim($text),FILTER_SANITIZE_STRING);
	       
	       	if (strlen($filteredMsg)>=20) {
		       	$checkOrd=checkItem('order_id','orders',$order_id);
		       	if ($checkOrd>0) {
		       		//  update orders
		         	$stmt2=$conn->prepare(" UPDATE orders set report_trader=1,report_value=?  where  order_id=? ");
				    $stmt2->execute(array($filteredMsg,$order_id));
				    if ($stmt2) { 
				    	?><span class='sent green'>تم التبليغ عن  مقدم الخدمة ...</span> 
				    	<script>setTimeout(function direct(){location.reload();},2200);</script><?php
				    }else{
		            	?><span class="sent red2">حدث خطأ؛ تأكد من الاتصال وأعد المحاولة  </span> <?php
		            }
		       	}else{
		       		?><span class="sent red2">لم يتم العثور على هذا الطلب  </span> <?php
		       	}
	      
	    }else{ 
	    	echo "<span class='sent red2 font-size'>".$lang['enoughReason']."</span>";
	    }





      //taking part in mostfid partner program => coming from prizes.php
      }elseif (isset($_POST['phoneProg']) ) {
      	$phone=filter_var(trim($_POST['phoneProg']),FILTER_SANITIZE_STRING);
        $num=substr(md5(uniqid(mt_rand(), true)) , 0, 5);
		
		if(strlen($phone) ==11){
			$checkPh=checkItem('phone','user',$phone);
		if ($checkPh>0) {
			$fetch=fetch('*','user','phone',$phone);
			if($fetch['user_id']==$session){
			$check=checkItem('program','user',$num);
			if($fetch['program']!=''){
				?><span class="red2">أنت مشترك بالفعل  </span> <?php
			  }else{ 
					if ($check>0) { //code is taken
							?> <span class="red2">أدخل رقم تليفونك مرة ثانية ثم اضغط موافق  </span><?php
					}else{ 
							$stmt=$conn->prepare(" UPDATE user set program=? where phone=? ");
							$stmt->execute(array($num,$phone));
								if ($stmt) {
									?> <div class="green">تم  الاشتراك ينجاح </div>
					                    <span>الاسم: <?php if($fetch['trader']==1){ echo $fetch['commercial_name']; }else{echo $fetch['name']; } ?></span>
					                    <span>&emsp;.. رقم الكود الخاص بك  <?php echo '('.$num.')'; ?></span>
									 <?php
								}else{
									?> <span class="red2">تحقق من الاتصال ثم حاول مرة أخرى </span><?php
								}
			        	   }//END if ($check>0)
		               }//END if($fetch['program']>0
		          }else{ //END if($fetch['user_id']==$session)
		            ?> <span class="red2">أدخل رقمك المسجل لدينا في الموقع  </span><?php
		          }
		      }else{
		      	?> <span class="red2">هذا الرقم غير مسجل لدينا </span><?php
		      }

		   }else{ //END if(strlen($phone)
		      ?> <div class="block2">رقم التليفون غير صحيح  </div><?php
		   }




      //receiving data from profile to receive program credit => p='program'
      }elseif (isset($_POST['user_idProg']) ) {
      	include $tmpl.'navbar.php';
      	$user_id=$_POST['user_idProg'];
       	$alternate1=isset($_POST['alternate'])?$_POST['alternate']:0;
       	$alternate=filter_var(trim($alternate1),FILTER_SANITIZE_NUMBER_INT);
      	$fetchPh=fetch('phone','user','user_id',$user_id);
      	$phone=$alternate==0?$fetchPh['phone']:$alternate;
      	 ?><div class="height"><?php
	      	 if ($alternate>0&&strlen($alternate)!=11) {
	      	 	?><div class="block2">الرقم الذي أدخلته غير صحيح  </div> <?php
	      	 }else{
		      	$stmt=$conn->prepare(" UPDATE user set send_to=? where user_id=? ");
				$stmt->execute(array($phone,$user_id));
					if ($stmt) {
						?>
						<div class="block-green">تم  بنجاح </div>
						<script>setTimeout(function go(){ location.href='profile.php?i=<?php echo $user_id;?>&p=program';},1100);</script> 
						<?php
					}
	         }
          ?></div><?php
         include 'foot.php';
      }






	}else{ //END if $s_server[REQUEST_METHOD]=='POST'
	   include 'notFound.php';
    }

}else{ //END session
	include 'notFound.php';
}


include  $tmpl ."footer.inc";
 ob_end_flush();
 