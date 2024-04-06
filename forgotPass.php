<?php
ob_start();
session_start();
$title='طلب كلمة مرور جديدة ';       //title of the page
?><link rel="canonical" href="https://mostfid.com/index.php" > <?php
include 'init.php';   //included files



  //store session
if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

if (!isset($session)) {
 if (isset($_GET['forgot'])&&is_numeric($_GET['forgot'])&&$_GET['forgot']==1 ) { 
 //traders
?>
<h6 class="toGetPass">للحصول على كلمة مرور جديدة؛ أدخل رقم تليفونك المحمول </h6>
<form  id="form-verify">
	<div class="flex">
    <div>
      <input type="text" id="codeVerify" name="phone" placeholder="أدخل رقم تليفونك المحمول">
      <input type="hidden"  name="trader" value="trader">
      <input type="hidden" id="fromTrader" value="1">
      <div id="showVerifyPass"></div>
   </div>
	 <div><button type="submit" id="submit-verify" value=""><?php echo $lang['send']?></button></div>
 </div>
</form>
<?php

 

}elseif(isset($_GET['forgot'])&&is_numeric($_GET['forgot'])&&$_GET['forgot']==2){
 //users
 ?>
<h6 class="toGetPass"><?php echo $lang['toGetPass']?></h6>
<form  id="form-verify">
  <input type="email" id="codeVerify" name="email" placeholder="أدخل بريدك الالكتروني">
  <input type="hidden" id="fromTrader" value="0">
  <button type="submit" id="submit-verify" value=""><?php echo $lang['send']?></button>
</form>
<div id="showVerifyPass2"></div> 
<?php



}else{
  header('location:index.php');
  exit();
} ?>


<!--ajax coner -->
       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
        $("#form-verify").on("submit", function(e){
          e.preventDefault();
          var email=$('#codeVerify').val().length;
          var fromTrader=$('#fromTrader').val();
          if(fromTrader==1)  { //coming from trader
           if(email>0)  {
          $.ajax({
          method:"POST",
          url:'forgotPass2.php',
          beforeSend:function(){
            $('#submit-verify').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#submit-verify').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $("#showVerifyPass").html(data); 
            
             },
             complete:function(){
             	$('#submit-verify').removeClass('disabled',true);
              $('.spinner-border').remove();
             }
           });
           }else{
           	$("#showVerifyPass").html('<span class="add-email-verify">أدخل البيانات المطلوبة أعلاه </span>');
           } //END  if(email>0)
         }else{ //END if(fromTrader==1)
          if(email>0)  { //coming from user
          $.ajax({
          method:"POST",
          url:'forgotPass2.php',
          beforeSend:function(){
            $('#submit-verify').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#submit-verify').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $("#showVerifyPass2").html(data); 
            
             },
             complete:function(){
              $('#submit-verify').removeClass('disabled',true);
              $('.spinner-border').remove();
             }
           });
           }else{
            $("#showVerifyPass2").html('<span class="add-email-verify">أدخل البيانات المطلوبة أعلاه </span>');
           } //END  if(email>0)

         }
        });
        
        //



        });
    </script>


<?php
}else{
  header('location:index.php');
  exit();
}

include 'foot.php';
include $tmpl."footer.inc";        
ob_end_flush();
 