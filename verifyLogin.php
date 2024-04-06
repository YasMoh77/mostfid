<?PHP
ob_start();
session_start();       //important in every php page
$title='التحقق  من البريد الالكتروني ';       //title of the page
include 'init.php';   //included files


  if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb
 
	if (isset($session)) {
		header('location:index.php');   
    exit();
	  } ?>
    
 
		 <div class="height">
    <p class="center bold"><?php echo $lang['insertemailCode']?></p>
    <form  id="form-verify" >
			<input type="text" id="codeVerify" name="emailLogin" placeholder=" أدخل بريدك الالكتروني">
			<button type="submit" name="myButton" id="submit-verify" value=""><?php echo $lang['sendNewCode']?></button>
		</form>
		<div id="showVerifyLogin"></div> 
    </div>
	   <!--ajax coner -->
       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
        //send form to formSignUp.php 
        $("#form-verify").on("submit", function(e){
          e.preventDefault();
          var email=$('#codeVerify').val();
          if(email==0){
            $('#submit-verify').addClass('disabled',true); 
          }else{
          $.ajax({
          method:"POST",
          url:'verifyResultLogin.php',
          beforeSend:function(){
            $('#submit-verify').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#submit-verify').prop('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $("#showVerifyLogin").html(data);
             },
           complete:function(){
           	$('#submit-verify').prop('disabled',false);
            $('#codeVerify').val('');
            $('.spinner-border').remove();
           }
           });
          }// END if
        });
        //




        });
    </script>
		<?php




include 'foot.php';
include $tmpl."footer.inc";        
ob_end_flush();