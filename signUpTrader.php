<?php
ob_start();
session_start();       //important in every php page
$title='تسجيل حساب جديد ';       //title of the page
include 'init.php';   //included files

	
  $l=$lang['lang'];

	if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

		if (isset($session)) {
		    header('location:index.php'); 
		    exit();
	      }
	


if ($_SERVER['REQUEST_METHOD']=='POST') { 
    	$phone=filter_var(trim($_POST['phoneCheck']),FILTER_SANITIZE_NUMBER_INT) ; //phone in traders table
	    $pass=filter_var(trim($_POST['passCheck']),FILTER_SANITIZE_STRING); //check_code in traders table
	
   $fetch=fetch3('*','user','phone',$phone,'code',$pass,'trader',1); 
	if (empty($phone)) {
		?><div class="height2 center above-lg"><span class="red2 font-size">أدخل رقم تليفونك</span></div> <?php
	}elseif (strlen($phone)!=11) {
		?><div class="height2 center above-lg"><span class="red2 font-size">رقم التليفون غير صحيح</span></div> <?php
	}elseif (empty($pass)) {
		?><div class="heigh2 center above-lg"><span class="red2 font-size">أدخل  كلمة السر المؤقتة</span></div> <?php 
 

	}else{
	if ($fetch['accepted_terms']==0) { 
		//contact site manager
	  ?><div class="height2 center above-lg"><span class="red2 font-size">هذه البيانات غير صحيحة؛  الرجاء الاتصال بادارة الموقع لاعتمادك  لدينا </span>&ensp;<span class="bold font-size">01013632800</span> </div><?php 
	  
	  }elseif ($fetch['accepted_terms']>0 && $fetch['password']!=null ) {
	  	?><div class="height2 center above-lg"><span class="red2 font-size">تم الانضمام بالفعل؛ الرجاء <a class="font-size" href="signinP.php">تسجيل الدخول  </a></span></div> <?php
	  }elseif($fetch['accepted_terms']>0 && $fetch['password']==null){  
	  //<!--------------- signUp Trader ----------------->

	    $stmt=$conn->prepare(" SELECT categories.*,country.*,state.*,city.*
	         FROM user
		     JOIN categories  ON user.cat_id=categories.cat_id
		     JOIN country     ON user.country_id=country.country_id
		     JOIN state       ON user.state_id=state.state_id
		     JOIN city        ON user.city_id=city.city_id
		WHERE user.phone=? 	and user.trader=1	");	
		$stmt->execute(array($fetch['phone']));
		$user=$stmt->fetch();
		?>

	<!----login page---->
	<h1 class="h1-heading-tr"> <span id="signup">استكمال تسجيل  مقدم خدمة  </span></h1>
	<div class="relative2 relative-signUp container signUpTr">
         <!-- SIGN UP FORM-->
		<form class="form-login tr" id="form2" > 
			<!--Username field -->
			<input type="hidden" name="country" value="<?php echo $fetch['country_id'] ?>">
			<input type="hidden" name="phone" value="<?php echo $phone; ?>">
			<section>
				<div class="div-lable"><label>اسم صاحب النشاط</label>
				</div>
				<div class="div-input signUp">
				    <input type="text" id="user" name="username" class="form-control  inputUser" placeholder="<?php echo $fetch['name']?>"  disabled>
				</div>
			</section>


			<!--commercial name field -->
			<section>
				<div class="div-lable"><label>اسم النشاط</label>
				</div>
				<div class="div-input signUp">
				    <input type="text" id="user" name="commercial_name" class="form-control  inputUser" placeholder="<?php echo $fetch['commercial_name']?>" disabled>
				</div>
			</section>


			<!--address-->
			<section>
				<div class="div-lable"><label>العنوان  </label>
				</div>
				<div class="div-input signUp">
				    <input type="text" id="address" name="address" class="form-control  inputUser" placeholder="<?php echo $fetch['address']?>" disabled>
				</div>
			</section>

			
			<!--Password field-->
			<section>
				<div class="div-lable"><label><?php echo $lang['enterNewPass']?></label><span class="red-signup"> * </span>
				</div>
				<div class="div-input signUp">
					<input type="password" id="pass" name="password" class="form-control inputPassword" 
					        autocomplete="off" placeholder="<?php echo $lang['sixCharacters']?>" minlength='8' maxlength='20' required>
					<img class="showPassAddClosed" src="<?php echo $images.'eye-off.png' ?>" >
					<img class="showPassAddOpen" src="<?php echo $images.'eye.png' ?>" >
				</div>
				<span class="pass-span">يجب ان تشتمل كلمة المرور على حرف صغير وحرف كبير ورقم</span>
		    </section>


		    <!--Retype Password field-->
			<section>
				<div class="div-lable"><label><?php echo $lang['reEnterNewPass']?></label><span class="red-signup"> * </span>
				</div>
				<div class="div-input signUp">
					<input type="password" id="pass2" name="password2" class="form-control inputPassword2" 
					        autocomplete="off" placeholder="<?php echo $lang['sixCharacters']?>" minlength='8' maxlength='20' required>
					<img class="showPassAddClosed2" src="<?php echo $images.'eye-off.png' ?>" >
					<img class="showPassAddOpen2" src="<?php echo $images.'eye.png' ?>" >
				</div>
				<span class="pass-span">يجب ان تشتمل كلمة المرور على حرف صغير وحرف كبير ورقم</span>
		    </section>
        

             <!--phone field-->
		    <section>
				<div class="div-lable"><label><?php echo $lang['phone']?></label> 
				</div>
				<div class="div-input signUp">
				    <input type="text" id="phone"  class="form-control" placeholder="<?php echo '0'.$fetch['phone']?>" disabled="">
                </div>
		    </section>


		    <!--trade field field -->
			<section>
				<div class="div-lable"><label>مجال النشاط</label>
				</div>
				<div class="div-input">
					 <input type="text"  class="form-control" placeholder="<?php echo $user['cat_nameAR']?>" disabled>
				</div>
			</section>


        <!--country field-->
		    <section>
				<div class="div-lable"><label><?php echo $lang['country']?></label>
				</div>
				<div class="div-input">
				  <input type="text"  class="form-control" placeholder="<?php echo $user['country_nameAR']?>" disabled> 
				</div>
		    </section>


		    <!--state field-->
		    <section>
				<div class="div-lable"><label><?php echo $lang['state']?></label>
				</div>
				<div class="div-input">
					<input type="text"  class="form-control" placeholder="<?php echo $user['state_nameAR']?>" disabled>   
				</div>
		    </section>


             <!--city field--> 
		    <section>
				<div class="div-lable"><label><?php echo $lang['city']?></label>
				</div>
				<div class="div-input">
				  <input type="text"  class="form-control" placeholder="<?php echo $user['city_nameAR']?>" disabled> 
				</div>
		    </section>


		   <!--verify code field--> 
		    <section>
		    	<?php
		    	$getRandom=md5(rand(1000,10000));
		    	$code=substr($getRandom, 0,6);
		    	$_SESSION['code']=$code;
		    	?> 
				<div class="div-lable"><label>كود التحقق  <span class="small">(أنا انسان)</span></label><span class="red-signup"> * </span>&emsp;<span class="btn btn-secondary pointerInitial spanCode" id='<?php echo $_SESSION['code'];?>'><?php echo $_SESSION['code'];?></span> 
				</div>
				<div class="div-input">
				  <input type="text" name="code" class="form-control form-control2" placeholder="أدخل كود التحقق " autocomplete="off" required> 
				  <span class="rightx goodCode green"></span><span class="rightx badCode red2"></span>
				</div>
		    </section> 
		    
		    
			<span class="rightx red2 font-size"> * = <?php echo $lang['req']?> </span> <!--  href="terms.php?d=1" // href="policy.php"-->
			 <div><input class="right" type="checkbox" name="terms" ><span class="small right">أوافق على  <a>الشروط والأحكام  </a>و  <a>سياسة الخصوصية  </a></span></div>
			<button type="submit"  class="btn btn-primary" id="signUp-btn"  ><?php echo $lang['send']?></button>
		</form>
</div>
<div class="showForm showForm-tr"></div>
<input type="hidden" id="lng" value="<?php echo $lang['lang']; ?>">
  
      	<!---------------- END signUp Trader -------------->
	   <?php } //END elseif($fetch['accepted_terms']>0 && $fetch['password']==null)
     }//END else => for if after fetch2

 }else{ // END if $_SERVER['REQUEST_METHOD']=='POST'
  include 'notFound.php';
}  ?>

 
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
        $(".tr").on("submit", function(e){
          e.preventDefault();
          $.ajax({
          url:"formSignUpTr.php",
          method:"POST",
          beforeSend:function(){
            $('.tr> #signUp-btn').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('.tr> #signUp-btn').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $(".showForm").html(data);
             },
          complete:function(){
         	$('.tr> #signUp-btn').removeClass('disabled',true);
            $('.spinner-border').remove();
            $('#country').val('');
            $('#state').val('');$('#city').val('');
           }
           });
        });
        //
        
        




      });
     </script>
      


<?php
include $tmpl."footer.inc";   
include "foot.php";        
ob_end_flush();

