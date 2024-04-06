<?php
session_start();  
$title='التحقق من  رقم التليفون';       //title of the page
include 'init.php';   //included files 

if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

if (!isset($session)) {
	if (isset($_GET['t'])&&is_numeric($_GET['t']) &&strlen($_GET['t'])==11) {
		$phone=intval($_GET['t']); 
		?>
		<h5 class="center above font-med">أرسلنا كود التحقق  في رسالة نصية الى رقم  </h5>
    <h5 class="center above font-med"><?php echo '( '.'0'.$phone.' )'; ?></h5>
    <h5 class="center above font-med"> املأ الحقول  أدناه</h5>
		<h6 class="center above font-med">ملحوظة: قد يتأخر وصول الرسالة قليلا</h6>
    <form  id="form-verify2" > 
        <div class="form-verify-child "> 
            <section>
              <input type="text" class="codeVerify" id="code"   name="code" placeholder="<?php echo $lang['enterCode'] ?>" autocomplete='off'>
              <input type="hidden" name="trader" value="trader">
              <input type="hidden" name="phone" value="<?php echo $phone;?>">
              </section>
           <!-- new Password //--> 
            <section class="div-input passTr">
                <input type="password" class="inputPassword codeVerify" id="pass"   name="pass" placeholder="<?php echo $lang['newPass']?>" minlength='8' maxlength='15' autocomplete='off' >
                <img class="eyeClosedF"  src="<?php echo $images.'eye-off.png' ?>" >
                <img class="eyeOpenF"  src="<?php echo $images.'eye.png' ?>" >
            </section>
              <!--Retype  new Password -->
            <section class="passTr">
                <input type="password" class="inputPassword2 codeVerify" id="rePass" name="rePass" placeholder="<?php echo $lang['reNewPass']?>" minlength='8' maxlength='15' autocomplete='off'>
                <img class="eyeClosedF2"  src="<?php echo $images.'eye-off.png' ?>" >
                <img class="eyeOpenF2" src="<?php echo $images.'eye.png' ?>" >
            </section>
            <button type="submit" id="submit-verify-pass" class="submit-verify-pass" ><?php echo $lang['ok']?></button>
        </div>
    </form>


 
<div id="showVerify2"></div> 
<!--ajax coner -->
       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
        $("#form-verify2").on("submit", function(e){
          e.preventDefault();
          var code=$('#code').val().length;
          var pass=$('#pass').val().length;
          var rePass=$('#rePass').val().length;
          if(code<1||pass<1||rePass<1)  {
            $('#submit-verify-pass').addClass('disabled',true);
          }else{
          $.ajax({ 
          method:"POST",
          url:'forgotPass5.php',
          beforeSend:function(){
            $('#submit-verify-pass').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#submit-verify-pass').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $("#showVerify2").html(data);
             },
             complete:function(){
              $('#submit-verify-pass').removeClass('disabled',true);
              $('.spinner-border').remove();
             }
           });
           } // END else
        });
        //
        




        });
    </script>
<!---///////////////////////////////////////////-->
   	<?php

	}else{ //END if (isset($_GET['t'])
      include 'notFound.php';
	}
} //END if(!isset($session))





include $tmpl."footer.inc";
include 'foot.php';    
