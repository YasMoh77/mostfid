<?php
ob_start();
session_start();  
$title='التحقق من التليفون';       //title of the page
include 'init.php';   //included files   



	if (isset($_GET['t'])&&is_numeric($_GET['t']) &&strlen($_GET['t'])==11) {
				$phone=intval($_GET['t']);
			?>
			<h5 class="center above font-med">أرسلنا كود التحقق  في رسالة نصية الى رقم  </h5>
			<h5 class="center above font-med"> <?php echo '( '.'0'.$phone.' )'; ?></h5>
      <h5 class="center above font-med">لتفعيل رقمك الجديد؛ أدخل الكود </h5>
			<h6 class="center above font-med">ملحوظة: قد يتأخر وصول الرسالة قليلا</h6>
		    <form class="update-tr-dt" id="form-verify3"  ><!--action="update-tr-dt2" method="POST"-->
		        <div class="form-verify-child">
		            <section>
		              <input type="text" class="codeVerify" id="code"   name="code" placeholder="<?php echo $lang['enterCode'] ?>" autocomplete='off'>
		              <input type="hidden" name="trader" value="trader">
		              <input type="hidden" name="phone" value="<?php echo $phone;?>">
		            </section>
		        </div>
              <button id="submit-verify-pass button-all">ok</button>
		    </form>
		    <div id="showVerify2"></div> 
		    <!--ajax coner -->
       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
        $("#form-verify3").on("submit", function(e){
          e.preventDefault();
          var code=$('#code').val().length;
          if(code<1)  {
            $('#submit-verify-pass').addClass('disabled',true);
          }else{ 
          $.ajax({ 
          method:"POST",
          url:'update-tr-dt2.php',
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

			
		
		<?php 
		
	}else{ //END if(isset)
		include 'notFound.php';
	}








include $tmpl."footer.inc";
include 'foot.php';    
ob_end_flush();