<?php
ob_start();
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365 * 15);
session_start();       //important in every php page
$title='مستفيد | دخول مقدم خدمة ';       //title of the page
$keywords='<meta name="keywords" content="   عرض   , منصة  ,  شراء  ,  اشترى  ,  سعر ,  اسعار ,  دروس , عرض , اجهزة , خصم , تخفيضات , الجمعة  ,  نقل , ترجمة  , عروض   , مطلوب   , خصم  , كود خصم   , خصومات      ">';
$description='<meta name="description" content="انضم الينا كمقدم خدمة.. سجل برقم هاتفك     ">';
 
include 'init.php';   //included files

//SIGNIN FOR PARTNERS=TRADERS
 if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google 
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

 if (isset($session) ) { //IF THERE IS A SESSION
	header('location:index.php');
	exit();
  }

	?>
<!----login page----> 
<div class="container-signin signinp container"> 
		<form class="form-login formSigninPartner" id="form1" >
			<span class="font1" id="login">دخول  مقدم خدمة </span>   
			
			<!--phone -->
			<div class="div-inputL">
			     <input type="text" name="phone" class="form-control" autocomplete="on" placeholder="أدخل رقم تليفونك المحمول " value="<?php if(isset($_COOKIE['phoneMos'])){echo '0'.$_COOKIE['phoneMos'];} ?>" required>
			</div>

			<!--Password -->
			<div class="div-inputL eye-container1">
			      <input type="password" name="password" class="form-control inputPassword inputPassword1" autocomplete="off" placeholder="أدخل كلمة المرور" value="<?php if(isset($_COOKIE['passMos'])){echo $_COOKIE['passMos'];} ?>" required>
			      <img class="showPassAddClosed" id="eyeClosedSignIn" src="<?php echo $images.'eye-off.png' ?>" >
				  <img class="showPassAddOpen" id="eyeOpenSignIn" src="<?php echo $images.'eye.png' ?>" > 
			      <!--remember me  -->
			 <?php 
			if (!isset($_COOKIE['phoneMos']) && !isset($_COOKIE['passMos'])) {
			 	?>	<div class="check-remember-div"><input id="check-remember" type="checkbox" name="remember"><span class="remember-span"><?php echo $lang['rememberMe']?></span></div> <?php
			 }else{
			 	?>	<div class="check-remember-div2"></div> <?php
			 } ?>
			</div>  
 

			<?php
		    	$getRandom=md5(rand(1000,10000));
		    	$code=substr($getRandom, 0,6);
		    	$_SESSION['code']=$code;
		    ?> 
		    	<!-- code --> 
			<!--<div class="div-inputL"> 
			     <input type="text" name="code" class="form-control form-control2" placeholder="أدخل كود التحقق  " autocomplete="off" required=""> &emsp;<span class="btn btn-secondary pointerInitial spanCode" id='<?php echo $_SESSION['code'];?>'><?php echo $_SESSION['code'];?></span> 
			      <span class="rightx goodCode white"></span><span class="rightx badCode red2"></span>
			</div>-->

			

			<!--submit -->
			<div class="div-inputL signIn-submit">
			     <button class="submit font1" type="submit"  name="login" id="LOGIN"><?php echo $lang['login']?></button>
			</div>

			<!--forgot password -->
			<div class="div-inputL forget-div">
				<span class="forgot"><a href="forgotPass.php?forgot=1"><?php echo $lang['forgotPass']?></a></span>
				<span class="login-span"> <a href="partnerCheck.php"><?php echo $lang['sign-up']?></a></span>
	       </div>
	        <div class="showForm"></div>
	    </form>
	   
</div>

<!--ajax coner -->
       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
         $("#form1").on("submit", function(e){
          e.preventDefault();
          $.ajax({
          url:"formSignin.php",    
          method:"POST",
          beforeSend:function(){
            $('#form1> #LOGIN').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#form1> #LOGIN').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $(".showForm").html(data);
             },
          complete:function(){
         	$('#form1> #LOGIN').removeClass('disabled',true);
            $('.spinner-border').remove();
           }
           });
        });
        //



         });
     </script> 


<?php
include $tmpl."footer.inc"; 
include 'foot.php';       
ob_end_flush();
 
