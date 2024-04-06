<?php
ob_start();
session_start();
$title='مستفيد | اتصل بنا ';       //title of the page
$keywords='<meta name="keywords" content=  " مستفيد  ,  اوكازيون   , منتجات , عروض النت   ,  سعر ,  اسعار , تخفيض , تخفيضات , الجمعه ,  عروض اوكازيون   , خصم  , كود خصم   , خصومات  ,  منصة مستفيد  , mostfid  ,عرض   , منصة  ,  شراء  ,  اشترى    " >';
$description='<meta name="description" content="تواصل معنا عبر الهاتف؛ البريد الالكتروني؛ أو ارسل لنا رسالة عبر الموقع  ">';

include 'init.php';
 

?>
<div class="container  container2"> 
	<h4 class=" h2-heading"><?php echo $lang['contactUs']?></h4>
	<div class="sub-container2 flex subCon">
		     
		
         <!-- contactUs FORM-->
		<form class="form-login" id="formContact" >
			<!--name field-->
			<section>
				<div class="div-lable"><label><?php echo $lang['name']?></label><span class="req-contact-us"> * </span>
				</div>
				<div class="div-input">
				    <input type="text" id="Name" name="Name" class="form-control  inputUser"  required="">
				</div>
			</section>

             	
			<!-- phone field-->
			<section>
				<div class="div-lable"><label><?php echo $lang['phone']?></label><span class="req-contact-us"> * </span>
				</div>
				<div class="div-input">
				    <input type="text" id="Phone" name="Phone" class="form-control  inputUser" required="">
				</div>
			</section>
			
 
			<!-- reason field-->
			<section>
				<div class="div-lable"><label><?php echo $lang['whyContact']?></label><span class="req-contact-us"> * </span>
				</div>
				<div class="div-input">
				    <select class=" inputPassword  select-country " id="reason"  name='reason' required="" >
                        <option value=""><?php echo $lang['choose']?></option>
                        <option value="1"><?php echo $lang['inquire']?></option>
                        <option value="2"><?php echo $lang['suggest']?></option>
                        <option value="3"><?php echo $lang['complain']?></option>
                        <option value="4">رأي  </option>
                        <option value="5"><?php echo $lang['otherReason']?></option>
                    </select>  
				</div>
			</section>
			<!-- message field--> 
			<section>
				<div class="div-lable"><label><?php echo $lang['msgContactUs']?></label><span class="req-contact-us"> * </span>
				</div>
				<div class="div-input">
				    <textarea class="textarea-comment textarea-contact" id="message" name='message' required=""></textarea>
				</div>
			</section>

			<!-- verify code -->
			<?php
		    	$getRandom=md5(rand(1000,79000));
		    	$CodeCon=substr($getRandom, 0,6);
		    	$_SESSION['codeContact']=$CodeCon;
		    ?> 
			<section>
				<div class="div-lable"><label>كود التحقق </label><span class="req-contact-us"> * </span><span class="btn btn-primary pointerInitial spanCode" id='<?php echo $_SESSION['codeContact'];?>'><?php echo $_SESSION['codeContact']?></span>
				</div>
				<div class="div-input">
				   <input type="text" class="form-control2" name="code" placeholder="أدخل كود التحقق " autocomplete="off" required="">&emsp;<!--<span class="btn btn-secondary pointerInitial spanCode" id='<?php echo $_SESSION['codeContact'];?>'></span>-->
				   <span class="rightx goodCode white"></span><span class="rightx badCode red2"></span> 
				</div>
			</section> 

			<span class="req-contact-us"> * </span> = <span class="required required2 required-contact "> <?php echo $lang['req']?> </span>
			<button type="submit"  class="btn btn-primary" id="signUp-btn" name="signUp" ><span><?php echo $lang['send']?></span></button>
		    <div class=" showFormCon"></div>
		</form>
		

		

		<div class="div-hr">
			<hr>
		</div>
		


		<div class="contacts">
			<div class="inner">
				<div><span>01013632800</span></div>
				<div><span>01013632800</span></div>
				<div><span>contact@mostfid.com</span></div>
			</div>
			<div class="inner">
				<div><span class="blue bold">PHONE :</span></div>
				<div><span class="blue bold">WHATSAPP :</span></div>
				<div><span class="blue bold">EMAIL :</span></div>
			</div>
		</div>

  </div>
</div>


<?php
 //counter eye to count page visits
 include 'counter.php';
 echo '<span class="eye-counter" id="'.$_SESSION['counterContactUs'].'"></span>'; 
 ?>

<!--ajax coner -->
       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
       	//send form to formSignUp.php 
        $("#formContact").on("submit", function(e){
          e.preventDefault();
          var form2=$(this);
          $.ajax({
          url:"formContactUs.php",
          method:"POST",
          beforeSend:function(){
            $('#signUp-btn').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#signUp-btn').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success:function(data){
            $('.showFormCon').html(data);
          },
          complete:function(){
         	$('#signUp-btn').removeClass('disabled',true);
            $('.spinner-border').remove();
            /*$('#Name').val('');*/$('#Phone').val('');
            /*$('#reason').val('');$('#message').val('');*/
           }
           });
        });
        //ajax call send page views
		  var eye=$('.eye-counter').attr('id');
		  $.ajax({
		  url:"counterInsert.php",
		  data:{contactUs:eye}
		     });
		   //
        
        




      });
     </script>
      



<?php

include  $tmpl ."footer.inc";
include 'foot.php';
ob_end_flush();


