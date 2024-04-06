<?php
ob_start();
session_start();       //important in every php page
$title='مستفيد | تسجيل عضو جديد ';       //title of the page
$keywords='<meta name="keywords" content="   عرض   , منصة  ,  شراء  ,  اشترى  ,  سعر ,  اسعار ,  دروس , عرض , اجهزة , خصم , تخفيضات , الجمعة  ,  نقل , ترجمة  , عروض   , مطلوب   , خصم  , كود خصم   , خصومات      ">';
$description='<meta name="description" content="سجل الدخول لمنصة مستفيد بجوجل أو بالبريد الالكتروني. قدم طلب شراء لكي تستفيد  من الخصومات على منتجات وخدمات عديدة. ">';

include 'init.php';   //included files 
	

  //sign up page for users
	if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb
 
		if (isset($session)) {
		    header('location:index.php');
		    exit();
	      }
	
?>
<!----login page---->
        <h1 class="h1-heading-signUpU">
		   <span id="signup">تسجيل  عضو جديد</span> 
		</h1>
<div class="relative2 relative-signUp container signUpUser"> 

         <!-- SIGN UP FORM-->
		<form class="form-login" id="form2" >
      <input type="hidden" name="user" value="user">
			<!--Username field-->
			<section>
				<div class="div-lable"><label><?php echo $lang['username']?></label><span class="red-signup"> * </span>
				</div>
				<div class="div-input">
				    <input type="text" id="user" name="username" class="form-control  inputUser" autocomplete="off" required>
				</div>
			</section>
			

			<!--Password field-->
			<section>
				<div class="div-lable"><label><?php echo $lang['password']?></label><span class="red-signup"> * </span>
				</div>
				<div class="div-input"> 
					<input type="password" id="pass" name="password" class="form-control inputPassword" 
					        autocomplete="new-password" placeholder="<?php echo $lang['sixCharacters']?>" minlength='8' maxlength='20' required >
					<img class="showPassAddClosed" src="<?php echo $images.'eye-off.png' ?>" > 
					<img class="showPassAddOpen" src="<?php echo $images.'eye.png' ?>" >
				</div>
		    </section>


		    <!--Retype Password field-->
			<section>
				<div class="div-lable"><label><?php echo $lang['rePassword']?></label><span class="red-signup"> * </span>
				</div>
				<div class="div-input">
					<input type="password" id="pass2" name="password2" class="form-control inputPassword2" 
					        autocomplete="new-password" placeholder="<?php echo $lang['sixCharacters']?>" minlength='8' maxlength='20' required>
					<img class="showPassAddClosed2" src="<?php echo $images.'eye-off.png' ?>" >
					<img class="showPassAddOpen2" src="<?php echo $images.'eye.png' ?>" >
				</div>
		    </section>
		    

             <!--Email field-->
			<section>
				<div class="div-lable"><label><?php echo $lang['email']?></label>
					<span class="red-signup"> * </span>
				</div>
				<div class="div-input">
				    <input type="email" id="email" name="email" class="form-control" required>
				</div>
		    </section>
		   
              
             <!--phone field-->
		    <section>
				<div class="div-lable"><label><?php echo $lang['phone']?></label>
					<span class="red-signup"> * </span>
				</div>
				<div class="div-input">
				    <input type="text" id="phone" name="phone" class="form-control" required>
				</div>
		    </section>
		    
             
             <!--country field-->
		    <section>
				<div class="div-lable"><label><?php echo $lang['country']?></label>
					<span class="red-signup"> * </span>
				</div>
				<div class="div-input">
				   <select class=" inputPassword  select-country " id="country"  name='country'  required>
                <option value="0"><?php echo $lang['choose']?></option>
                <?php
                $stmt=$conn->prepare(" SELECT * from country where country_id=1 ");
                $stmt->execute();
                $country=$stmt->fetchAll();
                foreach ($country as $cont) {
                  if($l=='ar'){echo "<option value=".$cont['country_id'].">".$cont['country_nameAR']."</option>";}
                  else{echo "<option value=".$cont['country_id'].">".$cont['country_name']."</option>";}
                 }  ?>
            </select>
				</div>
		    </section>

		    <!--state field-->
		    <section>
				<div class="div-lable"><label><?php echo $lang['state']?></label>
					<span class="red-signup"> * </span>
				</div>
				<div class="div-input">
					  <select class=" inputPassword  select-country" id="state"  name='state'  required>
	                       <option value="0"><?php echo $lang['choose']?></option>
	                  </select>
				</div>
		    </section>

             <!--city field-->
		    <section>
				<div class="div-lable"><label><?php echo $lang['city']?></label>
					<span class="red-signup"> * </span>
				</div>
				<div class="div-input">
				   <select class=" inputPassword  select-country" id="city"  name='city'  required>
              <option value="0"><?php echo $lang['choose']?></option>
           </select>
				</div>
		    </section>

         <!--verify code field--> 
         <?php
          $getRandom=md5(rand(1000,10000)); 
          $code=substr($getRandom, 0,6);
          $_SESSION['code']=$code;
          ?> 
        <section>
        <div class="div-lable"><label>كود التحقق  <span class="small">(أنا انسان)</span></label>
          <span class="red-signup"> * </span>&emsp;<span class="btn btn-secondary pointerInitial spanCode" id='<?php echo $_SESSION['code'];?>'><?php echo $_SESSION['code'];?></span>
        </div>
        <div class="div-input">
          <input type="text" name="code" class="form-control form-control2" placeholder="أدخل كود التحقق  " autocomplete="off"> 
        <span class="rightx goodCode green"></span><span class="rightx badCode red2"></span>
        </div>
        </section> 


			<span class="alone rightx red2"> * = <?php echo $lang['req']?> </span>	<!-- required -->	
      <input class="right" type="checkbox" name="terms" ><span class="small right">قرأت   <a href="terms.php">الشروط والأحكام  </a>و  <a href="policy.php">سياسة الخصوصية  </a>وأوافق عليهما </span>
			<button type="submit"  class="btn btn-primary" id="signUp-btn" name="signUp" ><?php echo $lang['sign-up']?></button>
    </form>
    <div class="showForm"></div>
</div>


<input type="hidden" id="lng" value="<?php echo $lang['lang']; ?>">
      <!--ajax coner -->
       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
        //ajax call country
        $("#country").on("change", function(){
          var countrySign=$(this).val();
          var L=$('#lng').val();
          $.ajax({
          url:"receiveAjaxSign.php",
          data:{sentCountrySign:countrySign,l:L},
          success: function(data){                             
            $("#state").html(data);
             }
           });
        });
        //ajax call state
        $("#country,#state").on("change", function(){
          var stateSign=$('#state').val();
          var L=$('#lng').val();
          $.ajax({
          url:"receiveAjaxSign.php",
          data:{sentStateSign:stateSign,l:L},
          success: function(data){                             
            $("#city").html(data);
             }
           });
        });
        //send form to formSignUp.php 
        $("#form2").on("submit", function(e){
          e.preventDefault();
          var form2=$(this); 
          $.ajax({
          url:"formSignUpUs.php", 
          method:"POST",
          beforeSend:function(){
            $('#signUp-btn').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#signUp-btn').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $(".showForm").html(data);
             },
          complete:function(){
         	$('#signUp-btn').removeClass('disabled',true);
            $('.spinner-border').remove();
           /* $('#user').val('');$('#pass').val('');$('#pass2').val('');
            $('#phone').val('');$('#email').val('');*/$('#country').val('');
            $('#state').val('');$('#city').val('');
           }
           });
        });
        //send form to formSignUp.php
        $("#form-check-trader").on("submit", function(e){
          e.preventDefault();
          $.ajax({
          url:"process1.php",
          method:"POST",
          beforeSend:function(){
            $('.btn-check-trader').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('.btn-check-trader').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $(".show-check-trader").html(data);
             },
          complete:function(){
         	$('.btn-check-trader').removeClass('disabled',true);
            $('.spinner-border').remove();
            $('.phone-check-trader').val('');
           }
           });
        });
        
        
        




      });
     </script>
      


<?php
include $tmpl."footer.inc";   
include "foot.php";        
ob_end_flush();

