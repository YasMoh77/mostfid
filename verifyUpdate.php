<?PHP
ob_start();
session_start();       //important in every php page
$title='صفحة التحقق  من البريد الالكتروني ';       //title of the page
include 'init.php';   //included files


 
if (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email

	if (isset($session)) { ?>
				
    <p class="center bold"><?php echo $lang['insertemailCode']?></p>
    <form id="form-verify">
			<input type="text" id="codeVerify" name="emailLogin" placeholder=" أدخل بريدك الالكتروني">
			<button type="submit" id="submit-verify" value=""><?php echo $lang['sendNewCode']?></button>
		</form>
		<div id="showVerifyLogin"></div> 

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
          url:'verifyResultUpdate.php', 
          beforeSend:function(){
            $('#submit-verify').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#submit-verify').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $("#showVerifyLogin").html(data);
             },
           complete:function(){
           	$('#submit-verify').removeClass('disabled',true);
            $('.spinner-border').remove();
           }
           });
          }// END if
        });
        //





        });
    </script>
		<?php



 }else{ // End if (isset($session))
  header('location:logout.php?s=no');
  exit();
 }





include 'foot.php';
include $tmpl."footer.inc";        
ob_end_flush();