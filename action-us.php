<?php
ob_start();
session_start();
$title='مستفيد ';       //title of the page
?>
<meta name="robots" content="noindex">
<?php
include 'init.php';



if (isset($_SESSION['userEid']) || isset($_SESSION['userGid']) || isset($_SESSION['userFid']) ) {
	if(isset($_SESSION['userEid'])){ $session=$_SESSION['userEid']; }
	elseif(isset($_SESSION['userGid'])){ $session=$_SESSION['userGid']; }
	elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb
	  if (isset($session)) {

		//actions for user
      $u=isset($_GET['u'])?$_GET['u']:'none';
       if ($u=='no-remember') {
	       if (isset($_GET['id'])&&is_numeric($_GET['id'])&&$_GET['id']>0 &&$_GET['id']==$session ) {
	        $user=intval($_GET['id']);
	        $check=checkItem('user_id','user',$user);
	        if ($check>0) {
	         unset( $_SESSION['REmail']);
	         unset( $_SESSION['RPass']);
	         unset($_COOKIE['remember_email']);
	         setcookie('remember_email',' ',time()- 3600,'/');
	         unset($_COOKIE['remember_password']);
	         setcookie('remember_password',' ',time()- 3600,'/');
	         ?>
	         <div class="div-remove-action">
	         <span class="block-green alone">تم الغاء حفظ بيانات الدخول  </span> 
	         </div>
	         <script>
                 setTimeout(function go1(){ $('.block-green').fadeOut(); },2200);
                 setTimeout(function go2(){ location.href='profile.php?i=<?php echo $session?>&p=data'; },2250);
             </script> 
	         <?php 
	        } 
	      }else{
        	header('location:logout.php?s=no');
        	exit();
            }



       }elseif ($u=='edit-us') {
         if (isset($_SESSION['userEid'])) {  
         	//if email isn't activated
            $fetch=fetch('activate','user','user_id',$session); 
            if($fetch['activate']==0){ ?><script>location.href='emailChkCodeUpdate.php';</script> <?php }         
       	     //EMAIL USER
       	   if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id']>0 && $_GET['id']==$session ){
		     $user_id=intval($_GET['id']); 
		     //Bring user data from database
		     $stmt=$conn->prepare(" SELECT user.*,country.*,state.*,city.* from user
		      join country on country.country_id= user.country_id
		      join state on state.state_id= user.state_id
		      join city on city.city_id= user.city_id
		      WHERE user.user_id=? order by user_id");
		      $stmt->execute(array($user_id));
		      $admins=$stmt->fetch();
        	   ?>
		       	<!----edit page---->
			   <h1 class="h1-heading"><span id="signup"><?php echo $lang['updateProf']?></span></h1>
			   <?php $fetch=fetch('update_date','user','user_id',$session);?>
			   <span class="center"><?php echo $lang['leaveUpdates']?></span>
			   <?php 
			    if($fetch['update_date']>0){ ?><span class="last-update"><?php echo '('.$lang['lastUpdate'].': '.$fetch['update_date'].')'?></span> <?php }
			   ?>
		    

		<div class="relative container relative-action">
		         <!-- update FORM  action="action.php?do=updateinfo" method="POST"-->
		    <form action="formUpdate.php" method="POST" class="form-login edit-us" id="form2" >
		      <!--Username field-->
		      <section>
		        <div class="div-lable"><label><?php echo $lang['username']?></label>
		        </div>
		        <div class="div-input">
		            <input type="text" name="username" class="form-control  inputUser" value="<?php echo $admins['name'];?>" readonly >
		        </div>
		      </section>

		      
		      <!--New Password field-->
		      <section>
		        <div class="div-lable"><label><?php echo $lang['newPass']?></label>
		        </div>
		        <div class="div-input eye-container1">
		          <input type="password" name="password1" class="form-control inputPassword" autocomplete="new-password" placeholder="<?php echo $lang['fillPass']?>" > 
		          <img class="showPassAddClosed" src="<?php echo $images.'eye-off.png' ?>" >
		          <img class="showPassAddOpen" src="<?php echo $images.'eye.png' ?>" >
		        </div>
		        </section>


		        <!--Retype New Password field-->
		      <section>
		        <div class="div-lable"><label><?php echo $lang['reNewPass']?></label>
		        </div>
		        <div class="div-input eye-container2">
		          <input type="password" name="password2" class="form-control inputPassword2" autocomplete="new-password" placeholder="" > 
		          <img class="showPassAddClosed2" src="<?php echo $images.'eye-off.png' ?>" >
		          <img class="showPassAddOpen2" src="<?php echo $images.'eye.png' ?>" >
		        </div>
		        </section>
		       
		      
		          <!--Email field-->
		       <section>
		          <div class="div-lable"><label><?php echo $lang['email']?></label>
		          </div>
		          <div class="div-input">
		              <input type="email" name="email" class="form-control" value="<?php echo $admins['email'];?>" required>
		          </div>
		       </section>
		      
		        
		             <!--phone field-->
		        <section>
		        <div class="div-lable"><label><?php echo $lang['phone']?></label>
		        </div>
		        <div class="div-input">
		            <input type="text" name="phone" class="form-control" value="<?php   echo '0'.$admins['phone'];?>" required>
		        </div>
		        </section>
		        
		        
		        <!--country, state, city //-->
		         <section>               
		          <div class="div-lable-special"><label><?php echo $lang['cont-st-city']?></label>
		          </div>
		          <div class="div-input  ">
		                <ul class="ul-cat-action ul-cat">
		                   <li ><?php if($l=='ar'){echo $admins["country_nameAR"];}else{echo $admins["country_name"];}  ?> &emsp;> </li>
		                   <li ><?php if($l=='ar'){echo $admins["state_nameAR"];}else{echo $admins["state_name"];}  ?>&emsp; > </li>
		                   <li ><?php if($l=='ar'){echo $admins["city_nameAR"];}else{echo $admins["city_name"];}  ?></li> 
		               </ul>  
		          </div>
		        </section> 

		        
		         <!--country field-->
		        <section>
		        <div class="div-lable"><label><?php echo $lang['country']?></label>
		        </div>
		        <div class="div-input">
		           <input type="text" name="country" class="form-control  inputUser" value="<?php echo $admins['country_nameAR'];?>" readonly >  
		        </div>
		        </section>


		        <!--state field-->
		        <section>
		        <div class="div-lable"><label><?php echo $lang['state']?></label>
		        </div>
		        <div class="div-input edit-us">
		            <select class=" inputPassword  select-country" id="state"  name='state' >
		                 <option class="small" value="0"><?php echo $lang['chngSt']?></option>
		                  <?php
		                  $stmt=$conn->prepare(" SELECT * from state
		                  join country on country.country_id= state.country_id
		                  WHERE country.country_id=? order by state.country_id");
		                  $stmt->execute(array($admins['country_id']));
		                  $states=$stmt->fetchAll();
		                  if (!empty($states)) {
		                        foreach ($states as $state) {
		                          if($l=='ar'){echo   '<option value="'.$state['state_id'].'">'.$state['state_nameAR'].'</option>';}
		                          else{echo   '<option value="'.$state['state_id'].'">'.$state['state_name'].'</option>';}
		                        }
		                   }else{
		                       echo   '<option>'.$lang['noStates'].'</option>';
		                   } 
		                   ?>  
		            </select>
		        </div>
		        </section>


		        <!--city field-->
		        <section>
		        <div class="div-lable"><label><?php echo $lang['city']?></label>
		        </div>
		        <div class="div-input edit-us">
		           <select class=" inputPassword  select-country" id="city"  name='city' >
		                <option class="small" value="0"><?php echo $lang['chngCity']?></option>
		           </select> 
		           <span class="note"></span>
		        </div>
		        </section>

		       
		        <!-- old values --> 
		        <input type="hidden" name="update-EmailUser" value="1">
		        <input type="hidden" name="user_id" value="<?php echo $admins['user_id'];?>">
		        <input type="hidden" name="oldpassword" value="<?php echo $admins['password'];?>">
		        <input type="hidden" name="oldphone" value="<?php echo $admins['phone']; ?>">
		        <input type="hidden" name="oldemail" value="<?php echo $admins['email']; ?>">
		        <input type="hidden" name="oldcountry" value="<?php echo $admins['country_id']; ?>">
		        <input type="hidden" name="oldstate" value="<?php echo $admins['state_id'];?>">
		        <input type="hidden" name="oldcity" value="<?php echo $admins['city_id'];?>">
		        <input type="hidden" name="activate" value="<?php echo $admins['activate'];?>">
		        <input type="hidden" id="lng" value="<?php echo $l;?>">
		      <button type="submit"  class="btn btn-primary BtnUpdate" id="signUp-btn" name="signUp" ><?php echo $lang['update']?></button>    
		    </form>   
		</div>
		<!--ajax coner -->
       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
        //ajax call city
        $("#state").on("change", function(){
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
         //


        });
       </script>

	        <?php }else{ //END if(isset($_GET['id']) 
		        	header('location:logout.php?s=no');
		        	exit();
	            } 



          }elseif(isset($_SESSION['userGid']) ){ //END if(isset($_SESSION['userEid']))
            //GOOGLE USER
             if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id']>0 && $_GET['id']==$session ){
		     $user_id=intval($_GET['id']); 
		     $userG=fetch('*','user','user_id',$_SESSION['userGid']);  
		     ?>
		     
		       	<!----edit page---->
			   <h1 class="h1-heading"><span id="signup"><?php echo $lang['updateProf']?></span></h1>
			   <?php  
			   $fetch=fetch('update_date','user','user_id',$session);
			   if(isset($_SESSION['comingFromOrderPage'])) { ?><span class="centered"> لتقديم  طلب شراء؛ يجب استكمال بياناتك الناقصة أولاً  </span><?php }
			   if($userG['country_id']==null&&$userG['state_id']==null&&$userG['city_id']==null){ ?><span class="center">املأ  الحقول ذات العلامة (*)</span> <?php }
			   	else{ ?><span class="center"><?php echo $lang['leaveUpdates']?></span><?php  }
			   if($fetch['update_date']>0){ ?><span class="last-update"><?php echo '('.$lang['lastUpdate'].': '.$fetch['update_date'].')'?></span> <?php }
			   ?>
		   
		<div class="relative container relative-action edit-google-us">
		   <?php if($userG['country_id']==null&&$userG['state_id']==null&&$userG['city_id']==null){ ?>
		      <!-- GOOGLE USER WITH NULL VALUES  -->
		    <form class="form-login edit-us GoogleNull" id="form2" >
			        <!--Username field-->
			      <section>
			        <div class="div-lable"><label><?php echo $lang['username']?></label>
			        </div>
			        <div class="div-input">
			            <input type="text" name="username" class="form-control  inputUser" value="<?php echo $userG['name'];?>" readonly >
			        </div>
			      </section>

			         <!--phone field--> 
			        <section>
			        <div class="div-lable"><label><?php echo $lang['phone']?></label><span class="red2">*</span>
			        </div>
			        <div class="div-input">
			            <input type="text" name="phone" class="form-control" value="<?php if($userG['phone']==0){ echo '0';}else{ echo '0'.$userG['phone']; } ?>" required>
			        </div>
			        </section>
			        
			         <!--country field-->
			        <section>
			        <div class="div-lable"><label><?php echo $lang['country']?></label><span class="red2">*</span>
			        </div>
			        <div class="div-input"> 
			        	<select class=" inputPassword  select-country contGoogle" id="country"  name='country' >
	                      <option value="0"><?php echo $lang['plsChooseCont']?></option>
	                      <?php
	                      $stmt=$conn->prepare(" SELECT * from country WHERE country_id=1 ");
		                  $stmt->execute(); $count=$stmt->fetchAll();
			                  if (!empty($count)) {
			                  	foreach ($count as  $value) {
			                  	  if($l=='ar'){echo   '<option value="'.$value['country_id'].'">'.$value['country_nameAR'].'</option>';}
		                          else{echo   '<option value="'.$value['country_id'].'">'.$value['country_name'].'</option>';}
			                  	}
			                  } ?>
			        	</select>	
			        </div>
			        </section>

			        <!--state field--> 
			        <section>
			        <div class="div-lable"><label><?php echo $lang['state']?></label><span class="red2">*</span>
			        </div>
			        <div class="div-input edit-us">
			            <select class=" inputPassword  select-country" id="stateUp"  name='state' >
			                 <option class="small" value="0"><?php echo $lang['chooseSt']?></option>
			            </select>
			        </div>
			        </section>
			             <!--city field-->
			        <section>
			        <div class="div-lable"><label><?php echo $lang['city']?></label><span class="red2">*</span>
			        </div>
			        <div class="div-input edit-us"> 
			           <select class=" inputPassword  select-country" id="cityUp"  name='city' >
			                <option class="small" value="0"><?php echo $lang['chooseCity']?></option>
			           </select> 
			            <span class="note"></span>
			        </div>
			        </section>
			        <input type="checkbox" name="terms" value="1"><span>قرأت   <a href="terms.php" target="_blank">الشروط والأحكام </a> و  <a href="policy.php" target="_blank">سياسة الخصوصية </a> وأوافق عليهما </span>

			        <!-- old values --> 
			       <input type="hidden" name="update-GoogleUserNull" value="1">
			        <input type="hidden" name="user_id" value="<?php echo $userG['user_id'];?>">
			        <input type="hidden" name="oldpassword" value="<?php echo $userG['password'];?>">
			        <input type="hidden" name="oldphone" value="<?php echo $userG['phone']; ?>">
			        <input type="hidden" name="oldemail" value="<?php echo $userG['email']; ?>">
			        <input type="hidden" name="oldcountry" value="<?php echo $userG['country_id']; ?>">
			        <input type="hidden" name="oldstate" value="<?php echo $userG['state_id'];?>">
			        <input type="hidden" name="oldcity" value="<?php echo $userG['city_id'];?>">
			        <input type="hidden" name="activate" value="<?php echo $userG['activate'];?>">
			        <input type="hidden" id="lng" value="<?php echo $l;?>">
			      <button type="submit"  class="btn btn-primary BtnUpdate" id="signUp-btn" name="signUp" ><?php echo $lang['update']?></button>    
		    </form> 
		    <div class="showFormGNull"></div>
		  <?php  }else{ ?>
		  	    <!-- GOOGLE USER WITHOUT NULL VALUES  -->
		  	<form class="form-login edit-us GoogleOk" id="form2" >
			        <!--Username field-->
			      <section>
			        <div class="div-lable"><label><?php echo $lang['username']?></label>
			        </div>
			        <div class="div-input">
			            <input type="text" name="username" class="form-control  inputUser" value="<?php echo $userG['name'];?>" readonly >
			        </div>
			      </section>

			         <!--phone field--> 
			        <section>
			        <div class="div-lable"><label><?php echo $lang['phone']?></label><span class="red2">*</span>
			        </div>
			        <div class="div-input">
			            <input type="text" name="phone" class="form-control" value="<?php echo '0'.$userG['phone'];?>" required>
			        </div>
			        </section>

			        <!--country, state, city //-->
			         <section>               
			          <div class="div-lable-special"><label><?php echo $lang['cont-st-city']?></label>
			          </div>
			          <div class="div-input  ">
			                <ul class="ul-cat-action ul-cat">
			                   <li ><?php if($l=='ar'){echo getCountry($userG["country_id"],$l);}else{echo getCountry($userG["country_id"],$l);}  ?> &emsp;> </li>
			                   <li ><?php if($l=='ar'){echo getState($userG["state_id"],$l);}else{echo getState($userG["state_id"],$l);}  ?>&emsp; > </li>
			                   <li ><?php if($l=='ar'){echo getCity($userG["city_id"],$l);}else{echo getCity($userG["city_id"],$l);}  ?></li> 
			               </ul>  
			          </div>
			        </section> 
			        
			         <!--country field-->
			        <section>
			        <div class="div-lable"><label><?php echo $lang['country']?></label>
			        </div>
			        <div class="div-input">
			           <input type="text" name="country" class="form-control  inputUser" value="<?php echo getCountry($userG["country_id"],$l);?>" readonly >  
			        </div>
			        </section>


			        <!--state field-->
			        <section>
			        <div class="div-lable"><label><?php echo $lang['state']?></label><span class="red2">*</span>
			        </div>
			        <div class="div-input edit-us">
			            <select class=" inputPassword  select-country" id="stateUp"  name='state' >
			                 <option class="small" value="0"><?php echo $lang['chooseSt']?></option>
			                 <?php
			                 $stmt=$conn->prepare(" SELECT * from state WHERE country_id=?");
			                 $stmt->execute(array($userG["country_id"]));
			                 $states=$stmt->fetchAll();
			                 if (!empty($states)) {
			                 	foreach ($states as $value) {
			                 	  if($l=='ar'){echo   '<option value="'.$value['state_id'].'">'.$value['state_nameAR'].'</option>';}
		                          else{echo   '<option value="'.$value['state_id'].'">'.$value['state_name'].'</option>';}
			                 	}
			                 }
			                 ?>
			            </select>
			        </div>
			        </section>

			        <!--city field-->
			        <section>
			        <div class="div-lable"><label><?php echo $lang['city']?></label><span class="red2">*</span>
			        </div>
			        <div class="div-input edit-us">
			           <select class=" inputPassword  select-country" id="cityUp"  name='city' >
			                <option class="small" value="0"><?php echo $lang['chooseCity']?></option>
			           </select> 
			           <span class="note"></span>
			        </div>
			        </section>
			        <input type="checkbox" name="terms" value="1"><span>قرأت   <a href="terms.php" target="_blank">الشروط والأحكام </a> و  <a href="policy.php" target="_blank">سياسة الخصوصية </a> وأوافق عليهما </span>

			        <!-- old values --> 
			       <input type="hidden" name="update-GoogleUser" value="1">
			        <input type="hidden" name="oldphone" value="<?php echo $userG['phone']; ?>">
			        <input type="hidden" name="oldcountry" value="<?php echo $userG['country_id']; ?>">
			        <input type="hidden" name="oldstate" value="<?php echo $userG['state_id'];?>">
			        <input type="hidden" name="oldcity" value="<?php echo $userG['city_id'];?>">
			        <input type="hidden" id="lng" value="<?php echo $l;?>">
			      <button type="submit"  class="btn btn-primary BtnUpdate" id="signUp-btn" name="signUp" ><?php echo $lang['update']?></button>    
		    </form> 
          <div class="showFormGNull"></div>
		      <?php   } //END else ?>  
 	 </div><!-- END container -->
		<!--ajax coner -->
       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
       	//ajax call state
        $("#country").on("change", function(){
          var country=$('#country').val();
          var L=$('#lng').val();
          $.ajax({
          url:"receiveAjaxSign.php",
          data:{sentCountrySign:country,l:L},
          success: function(data){                             
            $("#stateUp").html(data); 
             }
           });
         });
        //ajax call city
        $("#stateUp").on("change", function(){ 
          var stateSign=$(this).val();
          var L=$('#lng').val();
          $.ajax({
          url:"receiveAjaxSign.php",
          data:{sentStateSign:stateSign,l:L},
          success: function(data){                             
            $("#cityUp").html(data); 
             }
           });
         });
         //send form to formUpdate.php
        $(".GoogleNull").on("submit", function(e){
          e.preventDefault();
          $.ajax({
          url:"formUpdate.php",
          method:"POST",
          beforeSend:function(){
            $('.GoogleNull> #signUp-btn').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('.GoogleNull> #signUp-btn').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $(".showFormGNull").html(data);
             },
          complete:function(){
         	$('.GoogleNull> #signUp-btn').removeClass('disabled',true);
            $('.spinner-border').remove();
            }
           });
        });
        // Google user without Null values => sent to formUpdate.php
        $(".GoogleOk").on("submit", function(e){
          e.preventDefault();
          $.ajax({
          url:"formUpdate.php",
          method:"POST",
          beforeSend:function(){
            $('.GoogleOk> #signUp-btn').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('.GoogleOk> #signUp-btn').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $(".showFormGNull").html(data);
             },
          complete:function(){
         	$('.GoogleOk> #signUp-btn').removeClass('disabled',true);
            $('.spinner-border').remove();
            }
           });
        });


        });
       </script>

	        <?php }else{
		        	header('location:logout.php?s=no');
		        	exit();
	            } //END if(isset($_GET['id'])

          }elseif (isset($_SESSION['userFid'])) {  ////END elseif(isset($_SESSION['userGid'])) 
          	 //GOOGLE USER
             if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id']>0 && $_GET['id']==$session ){
		     $user_id=intval($_GET['id']); 
		     $userG=fetch('*','user','user_id',$_SESSION['userFid']);  
		     ?>
		     
		       	<!----edit page---->
			   <h1 class="h1-heading"><span id="signup"><?php echo $lang['updateProf']?></span></h1>
			   <?php  
			   $fetch=fetch('update_date','user','user_id',$session);
			   if(isset($_SESSION['comingFromOrderPage'])) { ?><span class="centered"> لتقديم  طلب شراء؛ يجب استكمال بياناتك الناقصة أولاً  </span><?php }
			   if($userG['country_id']==null&&$userG['state_id']==null&&$userG['city_id']==null){ ?><span class="center">املأ  الحقول ذات العلامة (*)</span> <?php }
			   	else{ ?><span class="center"><?php echo $lang['leaveUpdates']?></span><?php  }
			   if($fetch['update_date']>0){ ?><span class="last-update"><?php echo '('.$lang['lastUpdate'].': '.$fetch['update_date'].')'?></span> <?php }
			   ?>
		   
		<div class="relative container relative-action edit-google-us">
		   <?php if($userG['country_id']==null&&$userG['state_id']==null&&$userG['city_id']==null){ ?>
		      <!-- GOOGLE USER WITH NULL VALUES  -->
		    <form class="form-login edit-us faceNull" id="form2" >
			        <!--Username field-->
			      <section>
			        <div class="div-lable"><label><?php echo $lang['username']?></label>
			        </div>
			        <div class="div-input">
			            <input type="text" name="username" class="form-control  inputUser" value="<?php echo $userG['name'];?>" readonly >
			        </div>
			      </section>

			         <!--phone field--> 
			        <section>
			        <div class="div-lable"><label><?php echo $lang['phone']?></label><span class="red2">*</span>
			        </div>
			        <div class="div-input">
			            <input type="text" name="phone" class="form-control" value="<?php if($userG['phone']==0){ echo '0';}else{ echo '0'.$userG['phone']; } ?>" required>
			        </div>
			        </section>
			        
			         <!--country field-->
			        <section>
			        <div class="div-lable"><label><?php echo $lang['country']?></label><span class="red2">*</span>
			        </div>
			        <div class="div-input"> 
			        	<select class=" inputPassword  select-country contGoogle" id="country"  name='country' >
	                      <option value="0"><?php echo $lang['plsChooseCont']?></option>
	                      <?php
	                      $stmt=$conn->prepare(" SELECT * from country WHERE country_id=1 ");
		                  $stmt->execute(); $count=$stmt->fetchAll();
			                  if (!empty($count)) {
			                  	foreach ($count as  $value) {
			                  	  if($l=='ar'){echo   '<option value="'.$value['country_id'].'">'.$value['country_nameAR'].'</option>';}
		                          else{echo   '<option value="'.$value['country_id'].'">'.$value['country_name'].'</option>';}
			                  	}
			                  } ?>
			        	</select>	
			        </div>
			        </section>

			        <!--state field-->
			        <section>
			        <div class="div-lable"><label><?php echo $lang['state']?></label><span class="red2">*</span>
			        </div>
			        <div class="div-input edit-us">
			            <select class=" inputPassword  select-country" id="stateUp"  name='state' >
			                 <option class="small" value="0"><?php echo $lang['chooseSt']?></option>
			            </select>
			        </div>
			        </section>
			             <!--city field-->
			        <section>
			        <div class="div-lable"><label><?php echo $lang['city']?></label><span class="red2">*</span>
			        </div>
			        <div class="div-input edit-us"> 
			           <select class=" inputPassword  select-country" id="cityUp"  name='city' >
			                <option class="small" value="0"><?php echo $lang['chooseCity']?></option>
			           </select> 
			            <span class="note"></span>
			        </div>
			        </section>
			        <input type="checkbox" name="terms" value="1"><span>قرأت   <a href="terms.php" target="_blank">الشروط والأحكام </a> و  <a href="policy.php" target="_blank">سياسة الخصوصية </a> وأوافق عليهما </span>

			        <!-- old values --> 
			       <input type="hidden" name="update-faceNull" value="1">
			        <input type="hidden" name="user_id" value="<?php echo $userG['user_id'];?>">
			        <input type="hidden" name="oldpassword" value="<?php echo $userG['password'];?>">
			        <input type="hidden" name="oldphone" value="<?php echo $userG['phone']; ?>">
			        <input type="hidden" name="oldemail" value="<?php echo $userG['email']; ?>">
			        <input type="hidden" name="oldcountry" value="<?php echo $userG['country_id']; ?>">
			        <input type="hidden" name="oldstate" value="<?php echo $userG['state_id'];?>">
			        <input type="hidden" name="oldcity" value="<?php echo $userG['city_id'];?>">
			        <input type="hidden" name="activate" value="<?php echo $userG['activate'];?>">
			        <input type="hidden" id="lng" value="<?php echo $l;?>">
			      <button type="submit"  class="btn btn-primary BtnUpdate" id="signUp-btn" name="signUp" ><?php echo $lang['update']?></button>    
		    </form> 
		    <div class="showFormFNull"></div>
		  <?php  }else{ ?>
		  	    <!-- GOOGLE USER WITHOUT NULL VALUES  -->
		  	<form class="form-login edit-us faceOk" id="form2" >
			        <!--Username field-->
			      <section>
			        <div class="div-lable"><label><?php echo $lang['username']?></label>
			        </div>
			        <div class="div-input">
			            <input type="text" name="username" class="form-control  inputUser" value="<?php echo $userG['name'];?>" readonly >
			        </div>
			      </section>

			         <!--phone field--> 
			        <section>
			        <div class="div-lable"><label><?php echo $lang['phone']?></label><span class="red2">*</span>
			        </div>
			        <div class="div-input">
			            <input type="text" name="phone" class="form-control" value="<?php echo '0'.$userG['phone'];?>" required>
			        </div>
			        </section>

			        <!--country, state, city //-->
			         <section>               
			          <div class="div-lable-special"><label><?php echo $lang['cont-st-city']?></label>
			          </div>
			          <div class="div-input  ">
			                <ul class="ul-cat-action ul-cat">
			                   <li ><?php if($l=='ar'){echo getCountry($userG["country_id"],$l);}else{echo getCountry($userG["country_id"],$l);}  ?> &emsp;> </li>
			                   <li ><?php if($l=='ar'){echo getState($userG["state_id"],$l);}else{echo getState($userG["state_id"],$l);}  ?>&emsp; > </li>
			                   <li ><?php if($l=='ar'){echo getCity($userG["city_id"],$l);}else{echo getCity($userG["city_id"],$l);}  ?></li> 
			               </ul>  
			          </div>
			        </section> 
			        
			         <!--country field-->
			        <section>
			        <div class="div-lable"><label><?php echo $lang['country']?></label>
			        </div>
			        <div class="div-input">
			           <input type="text" name="country" class="form-control  inputUser" value="<?php echo getCountry($userG["country_id"],$l);?>" readonly >  
			        </div>
			        </section>


			        <!--state field-->
			        <section>
			        <div class="div-lable"><label><?php echo $lang['state']?></label><span class="red2">*</span>
			        </div>
			        <div class="div-input edit-us">
			            <select class=" inputPassword  select-country" id="stateUp"  name='state' >
			                 <option class="small" value="0"><?php echo $lang['chooseSt']?></option>
			                 <?php
			                 $stmt=$conn->prepare(" SELECT * from state WHERE country_id=?");
			                 $stmt->execute(array($userG["country_id"]));
			                 $states=$stmt->fetchAll();
			                 if (!empty($states)) {
			                 	foreach ($states as $value) {
			                 	  if($l=='ar'){echo   '<option value="'.$value['state_id'].'">'.$value['state_nameAR'].'</option>';}
		                          else{echo   '<option value="'.$value['state_id'].'">'.$value['state_name'].'</option>';}
			                 	}
			                 }
			                 ?>
			            </select>
			        </div>
			        </section>

			        <!--city field-->
			        <section>
			        <div class="div-lable"><label><?php echo $lang['city']?></label><span class="red2">*</span>
			        </div>
			        <div class="div-input edit-us">
			           <select class=" inputPassword  select-country" id="cityUp"  name='city' >
			                <option class="small" value="0"><?php echo $lang['chooseCity']?></option>
			           </select> 
			           <span class="note"></span>
			        </div>
			        </section>
			        <input type="checkbox" name="terms" value="1"><span>قرأت   <a href="terms.php" target="_blank">الشروط والأحكام </a> و  <a href="policy.php" target="_blank">سياسة الخصوصية </a> وأوافق عليهما </span>

			        <!-- old values --> 
			       <input type="hidden" name="update-faceUser" value="1">
			        <input type="hidden" name="oldphone" value="<?php echo $userG['phone']; ?>">
			        <input type="hidden" name="oldcountry" value="<?php echo $userG['country_id']; ?>">
			        <input type="hidden" name="oldstate" value="<?php echo $userG['state_id'];?>">
			        <input type="hidden" name="oldcity" value="<?php echo $userG['city_id'];?>">
			        <input type="hidden" id="lng" value="<?php echo $l;?>">
			      <button type="submit"  class="btn btn-primary BtnUpdate" id="signUp-btn" name="signUp" ><?php echo $lang['update']?></button>    
		    </form> 
          <div class="showFormFNull"></div>
		      <?php   } //END else ?>   
 	 </div><!-- END container -->
		<!--ajax coner -->
       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
       	//ajax call state
        $("#country").on("change", function(){
          var country=$('#country').val();
          var L=$('#lng').val();
          $.ajax({
          url:"receiveAjaxSign.php",
          data:{sentCountrySign:country,l:L},
          success: function(data){                             
            $("#stateUp").html(data); 
             }
           });
         });
        //ajax call city
        $("#stateUp").on("change", function(){ 
          var stateSign=$(this).val();
          var L=$('#lng').val();
          $.ajax({
          url:"receiveAjaxSign.php",
          data:{sentStateSign:stateSign,l:L},
          success: function(data){                             
            $("#cityUp").html(data); 
             }
           });
         });
         //send form to formUpdate.php
        $(".faceNull").on("submit", function(e){
          e.preventDefault();
          $.ajax({
          url:"formUpdate.php",
          method:"POST",
          beforeSend:function(){
            $('.faceNull> #signUp-btn').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('.faceNull> #signUp-btn').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $(".showFormFNull").html(data);
             },
          complete:function(){
         	$('.faceNull> #signUp-btn').removeClass('disabled',true);
            $('.spinner-border').remove();
            }
           });
        });
        // Google user without Null values => sent to formUpdate.php
        $(".faceOk").on("submit", function(e){
          e.preventDefault();
          $.ajax({
          url:"formUpdate.php",
          method:"POST",
          beforeSend:function(){
            $('.faceOk> #signUp-btn').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('.faceOk> #signUp-btn').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $(".showFormFNull").html(data);
             },
          complete:function(){
         	$('.faceOk> #signUp-btn').removeClass('disabled',true);
            $('.spinner-border').remove();
            }
           });
        });


        });
       </script>

	        <?php }else{
		        	header('location:logout.php?s=no');
		        	exit();
	            } //END if(isset($_GET['id'])

          } //END elseif(isset($_SESSION['userFid']))
       	

  

    }elseif ($u=='del-us') { 
     	//delete user =>coming from profile
	      if (isset($_GET['id'])&&is_numeric($_GET['id'])&&$_GET['id']>0  && $_GET['id']==$session  ) {
	        $user_id=intval($_GET['id']);
	        $check=checkItem('user_id','user',$user_id);
	         
	          if ($check>0) {
	          	?> <div class="height above-lg"> <?php 
		          $stmt=$conn->prepare("DELETE from user WHERE user_id = :zus");
		          $stmt->bindParam(":zus",$user_id);
		          $stmt->execute();
		          $count=$stmt->rowCount();
		          if ($stmt) {
		            echo "<div class='block-green'>".$lang['deleted']."</div>";
		            if(isset($_SESSION['userEid']) ) { unset($_SESSION['userEid']); }
		            if(isset($_SESSION['userGid']) ) { unset($_SESSION['userGid']); }
		            if(isset($_SESSION['userFid']) ) { unset($_SESSION['userFid']); }
		           ?> 
		           <script>
		               setTimeout(function go1(){ $('.block-green').fadeOut(); },2100);
		               setTimeout(function go2(){ location.href='index.php'; },2150);
	               </script>  

		           <?php
		           }else{  echo "<div class='block2'>تحقق من الاتصال بالانترنت ثم أعد المحاولة </div>"; }
		        ?></div> <?php
	         }else{
	            include 'notFound.php';
	         }
       }else{ //END if (isset($_GET['i'])
        header('location:logout.php?s=no');
        exit();
       }
     	



    }elseif ($u=='anything') {
     	# code...
    }




  }else{ //End session
		header('location:logout.php?s=no');
		exit();
  }
  
}//END if(isset($session['userEid'])||isset($session['userGid']))





include  $tmpl ."footer.inc";
include 'foot.php';
ob_end_flush();

