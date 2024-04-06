<?php
include  'lang.php';
$images='layout/images/';

?>
<!-- THE FOOT PAGE INCLUDED IN OTHER PAGES -->
<div class="foot">
	<h1>لو انت مشتري؛ ستجد على منصة مستفيد منتجات وخدمات يقدم اصحابها خصومات عليها بهدف ترويجها وتحقيق مزيد من المبيعات. لو انت مقدم خدمة؛ يمكنك عرض منتجاتك او خدماتك مجانا على مستفيد. انضم الينا وكن من المُيسرين. </h1>             

		<div class="container-foot"> 
			    
			    <div class="ar1">
			         <span><?php echo $lang['infoAboutUs']?> </span> 
				        <a class="links2" href="index.php"><?php echo $lang['homePage'] ?> </a> 
				         <a class="links2" href="aboutUs.php"><?php echo $lang['aboutUs'] ?> </a>
				        <a class="links2" href="faq.php"><?php echo $lang['faq'] ?> </a>
				        <a class="links2" href="contactUs.php"><?php echo $lang['contactUs'] ?> </a>
			    </div>
			     <div class="ar1">
			         <span><?php echo $lang['logo']?></span> 
				        <a class="links2" href="policy.php"><?php echo $lang['policy']?> </a>
				        <a class="links2" href="terms.php"><?php echo $lang['terms']?> </a>     
			    </div> 
			    <div class="ar1">
			         <span><?php echo $lang['MoreFoot']?> </span>  
				         <a class="links2" href="prizes.php"><?php echo $lang['prizes']?> </a> 
				         <?php if (! isset($_SESSION['traderid']) && ! isset($_SESSION['userEid']) && ! isset($_SESSION['userGid']) && ! isset($_SESSION['userFid']) ) { ?>
				         	<a class="links2" href="login.php"><?php echo $lang['signIn']?> </a>
				            <a class="links2" href="signUpU.php"><?php echo $lang['signUp']?> </a>
				        <?php } ?>
				         
			    </div>
			    <div class=" ar1">
			    	<!--<span class="span-follow">تابعنا  </span>-->
			    	<div class="div-follow">
					       <!--<a  href="https://www.facebook.com/mostfiid"> <i class="fab fa-facebook "></i></a>
					       <a  href="https://t.me/mostfiid"><i class="fab fa-telegram "></i></a>-->
					       <a class="fix-whats"  href="https://wa.me/201013632800"><i class="fab fa-whatsapp-square whats "></i></a>
			        </div>
			    </div>
		 </div>

		        

		   <div class="container-foot2">
			   <!--<hr>-->
               <span> جميع الحقوق محفوظة  &ensp;<i>مستفيد </i>&nbsp;&copy;&emsp;<?php echo date('Y');?></span>
		   </div>
	</div>
		     