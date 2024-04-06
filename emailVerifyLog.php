<?php
ob_start();
session_start();       //important in every php page
$title='التحقق من البريد الالكتروني ';       //title of the page
include 'init.php';   //included files


if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

if (!isset($session) ) { 

    if(isset($_SESSION['codeLoginMos']) ){
        echo "<div class='text-center bottom'><span class='span-green'></span></div>";
      }  ?>
      
      
    <div class="top-emailVerify">
      <div class="centered"><?php echo $lang['sentCode']?> 
          <?php 
          if(isset($_SESSION['codeLoginMos'])){echo '( '.$_SESSION['codeLoginMos'][0].' )';}
          else{echo $lang['emailProvided'];}?> <?php echo $lang['plsEnterCode']?> 
      </div>
      <span class="centered">اذا لم  يصلك الكود؛ اضغط <a href="verifyLogin.php">هنا </a> لإرسال كود جديد </span>

      <form  id="form-verify">
      	<input type="text" id="codeVerify" name="code" autocomplete="off" placeholder="أدخل الكود">
        <input type="hidden" name="email" value="<?php if(isset($_SESSION['codeUpdate'])){echo $_SESSION['codeUpdate'][0];}elseif(isset($_SESSION['codeLoginMos'])){echo $_SESSION['codeLoginMos'][0];} ?>">
      	<button type="submit" id="submit-verify" value=""><?php echo $lang['verifyEmail']?></button>
      </form>
      <div class="showEmailVerify" id="showVerifyEmail"></div> 
    </div>



          <!--ajax coner -->
           <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
           <script>
           $(document).ready(function(){
            //send form to formSignUp.php
            $("#form-verify").on("submit", function(e){
              e.preventDefault();
              var form2=$(this);
              var code=$('#codeVerify').val();
              if(code==0){
                $('#submit-verify').addClass('disabled',true);
              }else{
              $.ajax({
              method:"POST",
              url:'verifyFinal.php', 
              beforeSend:function(){
                $('#submit-verify').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                $('#submit-verify').addClass('disabled',true);
              },
              processData:false,
              contentType:false,
              data:new FormData(this),
              success: function(data){                             
                $("#showVerifyEmail").html(data);
                 },
                 complete:function(){
                 	$('#submit-verify').removeClass('disabled',true);
                    $('.spinner-border').remove();
                    $('codeVerify').val('');
                 }
               });
             }//END IF 
            });
            //
            /*$('#form-verify> button').click(function(){
              
            });*/ 



            });
        </script>

    <?php

} //END if (!isset($session) )




include $tmpl."footer.inc"; 
include "foot.php";
ob_end_flush(); 