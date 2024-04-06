<?php
ob_start();
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365 * 5);
session_start();       //important in every php page
$title='دخول  الأعضاء ';       //title of the page
include 'init.php';   //included files


 if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

 if (isset($session) ) { //IF THERE IS A SESSION 
	header('location:index.php'); 
	exit();
  }

	?>
<!----login page  action="<?php //echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST"---->
<div class="container-signin signinu container">
		<form class="form-login" id="form1" >
			<span class="font1" id="login">دخول الأعضاء  </span>   
			<input type="hidden" name="user">
			<!--email -->
			<div class="div-inputL"> 
			     <input type="email" name="email" class="form-control" id="signinuEmail" autocomplete="on" placeholder="أدخل البريد الالكتروني" value="<?php if(isset($_COOKIE['remember_email'])){echo $_COOKIE['remember_email'];} ?>" required>
			</div>

			<!--Password -->
			<div class="div-inputL" >
			      <input type="password" name="password" class="form-control inputPassword inputPassword1" id="signinuPass" autocomplete="new-password" placeholder="أدخل كلمة المرور" value="<?php if(isset($_COOKIE['remember_password'])){echo $_COOKIE['remember_password'];} ?>"  required>
			      <img class="showPassAddClosed1" id="eyeClosedSignIn" src="<?php echo $images.'eye-off.png' ?>" >
				  <img class="showPassAddOpen1" id="eyeOpenSignIn" src="<?php echo $images.'eye.png' ?>" >
			<!--remember me  --> 
			 <?php 
			 if (!isset($_COOKIE['remember_email']) && !isset($_COOKIE['remember_password'])) {
			 	?>	<input id="check-remember" type="checkbox" name="remember"><span class="remember-span"><?php echo $lang['rememberMe']?></span><?php
			 } ?>
			</div> 


			<?php
		    	$getRandom=md5(rand(1000,10000));
		    	$code=substr($getRandom, 0,6);
		    	$_SESSION['code']=$code;
		    ?> 
		    	<!-- code -->
			<!--<div class="div-inputL">  
			     <input type="text" name="code" class="form-control form-control2" placeholder="أدخل الكود " autocomplete="off" required=""> &emsp;<span class="btn btn-secondary pointerInitial spanCode" id='<?php echo $_SESSION['code'];?>'><?php echo $_SESSION['code'];?></span>  
			      <span class="rightx goodCode white"></span><span class="rightx badCode red2"></span>
			</div>-->

 
			<!--submit -->
			<div class="div-inputL signIn-submit">
			     <button class="submit font1" type="submit"  class="btn btn-primary" name="login" id="LOGIN">دخــول  </button>
			</div>

			<!--forgot password -->
			<div class="div-inputL forget-div">
				<span class="forgot"><a href="forgotPass.php?forgot=2"><?php echo $lang['forgotPass']?></a></span>
				<span class="login-span"> <a href="signUpU.php"><?php echo $lang['sign-up']?></a></span>
	       </div>
	    </form>
	    <div class="showForm"></div>
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
 
