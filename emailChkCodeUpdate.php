<?php
ob_start();
session_start();       //important in every php page
$title='التحقق من البريد الالكتروني ';       //title of the page
include 'init.php';   //included files




  if (isset($_SESSION['userEid'])) {  
     $chk=checkItem('user_id','user',$_SESSION['userEid']);
     if ($chk>0) {
          ?>
          <div class='text-center bottom'><span class='span-green'></span></div>
          <div class="centered"><?php 
              echo $lang['sentCode'];?> <?php 
              if(isset($_SESSION['codeUpdate'])) { echo '( '.$_SESSION['codeUpdate'][0].' )'; }
              else{ echo $lang['emailProvided']; }  echo $lang['plsEnterCode'];  ?> 
          </div>
          <span class="above centered">اذا لم  يصلك الكود؛ اضغط <a href="verifyUpdate.php"> هنا  </a> لنرسل لك كود جديد </span> 


          <form id="form-verify">
          	<input type="text" id="codeVerify" name="code" autocomplete="off">
              <input type="hidden" name="email" value="<?php if(isset($_SESSION['codeUpdate'])){echo $_SESSION['codeUpdate'][0];} ?>">
          	<input type="hidden" name="update">
          	<button type="submit" id="submit-verify" value=""><?php echo $lang['verifyEmail']?></button>
          </form>
          <div class="showEmailVerify" id="showVerify"></div>

     
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
                $("#showVerify").html(data);
                 },
                 complete:function(){
                 	$('#submit-verify').removeClass('disabled',true);
                    $('.spinner-border').remove();
                    $('codeVerify').val('');
                 }
               });
             } //END IF
            });
            //



             });
          </script>

    <?php
    }else{ header('location:logout.php?s=no');exit(); }

  }else{ 
   header('location:logout.php?s=no');
   exit();	
  }



include $tmpl."footer.inc"; 
include "foot.php";
ob_end_flush(); 