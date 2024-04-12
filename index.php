<?php
 

ob_start();
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365 * 15);
session_start();
$title='مستفيد | شراء منتجات  وخدمات بخصومات  ';       //title of the page
$keywords='<meta name="keywords" content=  " مستفيد  , منتجات    ,    سعر   ,   اسعار   ,   خدمات   ,   تخفيضات  ,   خصم    ,  خصومات   , mostfid  ,عرض   , منصة  ,  شراء   " >';
$description='<meta name="description" content=" ستجد على مستفيد منتجات وخدمات عليها خصومات وعروض حقيقية على شعرها الأصلي تجعل سعرها على مستفيد أقل من سعرها في السوق.. مستفيد يدعمك كمشتري ويساعدك على التغلب على ارتفاع الأسعار.. شعارنا انت أولى بالخصم">';
$canonical='<link rel="canonical" href="https://mostfid.com" >';
 
 
include 'init.php';
 //echo phpinfo(); 
 
 
    //store session 
if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb
//if activated==0 => email updated but not verified & if user or trader is banned
if (isset($session)) { banned($session); }
deleteOrders(); //delete orders older than 3 months => functions 805
?> 
<noscript>pls enable js</noscript>
<!--  advertisement -->
 <div class="wrapper">
 	<span class="centered small">اعلان  مدفوع </span>
 	<div class="cont">
	 <div class="advert">
	 	<a href="https://www.lafetaa.com"><img src="layout/images/add3.jpg" alt="اعلان مدفوع "></a>
	 </div>
	</div>
</div>
<!--  advertisement -->

  <section class="para-section para-index">
  	<img src="layout/images/shop2.jpg" alt="منتجات وخدمات بأسعار مخفضة  ">  
   <div class="son son-gs" >
	 <div class="div-ul-main first">
		<div class="div-first centered"> <span>منتجات  </span></div>
		<a href="#head-pp" class="centered white">دخول </a>
	</div>

	<div class="div-ul-main second">
		<div class="div-first centered"><span>خدمات   </span></div>
		<a href="#head-ps" class="centered white">دخول </a>
	</div>
</div>
</section>



<div class="about">
	<h1 class="about-heading centered ">منصة مستفيد لشراء المنتجات والخدمات بخصومات  </h1>
     <h2><b class="about-detail about-detail2">مستفيد من أفضل منصات شراء المنتجات والخدمات   </b></h2>
	   <h3 class="about-detail about-detail3">يعتبر  <a href="index.php">مستفيد </a>من أفضل منصات شراء  <a href="general.php">المنتجات   </a>و  <a href="service.php">الخدمات  </a>بخصومات؛ فنحن لا نعرض في مستفيد الا المنتجات والخدمات التي عليها خصومات أو عروض حقيقية؛ مما يجعل سعرها على مستفيد أقل من سعرها في السوق الأصلي. </h3>
	        
	   <h2><b class="about-detail about-detail2">أهمية مستفيد للمستخدم كمنصة شراء بخصومات   </b></h2>
     <h3 class="about-detail about-detail3">ستجد في مستفيد منتجات وخدمات عديدة في مكان واحد وعليها خصومات حقيقية وبالتالي نوفر عليك في مستفيد عناء البحث في اماكن مختلفة ونخفف عنك عبء ارتفاع الاسعار؛ وشعارنا دائما انت اولى بالخصم  </h3>
	   
	   <h2><b class="about-detail about-detail2">أهمية مستفيد لمقدم الخدمة كمنصة بيع  </b></h2>    
	   <h3 class="about-detail about-detail3">هدفنا في مستفيد جذب المشتري للاستفادة من الخصومات الحقيقية التي تقدمها على منتجاتك أو خدماتك مما يؤدي الى تنشيط السوق وتحقيق الرواج وبالتالي زيادة مبيعاتك. </h3>
     <h4 class="about-detail about-detail4">نريد أن نشجع مقدمي الخدمة  لتبني ثقافة البيع بخصم لجذب المشتري وفي نفس الوقت الاحتفاظ بهامش ربح مناسب.  <a href="partnerCheck.php">انضم الى مستفيد  </a>وكن من الميسرين  </h4>
     
	<!--<h2 class="about-detail centered">
		مستفيد  بيوفرلك كمشتري منتجات وخدمات بسعر مناسب؛ وبيساعد مقدم الخدمة انه يروج لخدماته ومنتجاته  .. جمعنالك في مستفيد  المنتجات والخدمات اللي عليها خصومات؛  والتزمنا بضوابط تضمنلك خصم حقيقي على سعر السوق الأصلي  .. مع مستفيد انت أولى بالخصم.
	</h2>

	<h1 class="about-heading about-heading2 centered ">رؤية مستفيد  </h1>
	<h2 class="about-detail about-detail2 centered">
		هدفنا في مستفيد أن نجعل من "البيع بخصم" ثقافة لدى البائعين  ومقدمي الخدمات للتخفيف عن كاهل المشتري من جهة ولتحريك السوق بالنسبة للبائع من جهة أخرى. 
	</h2> 
	<h2 class="about-detail about-detail3 centered">
		لو انت مشتري تذكّر ان مستفيد يرفع شعار "انت اولى بالخصم" ويساعدك على التغلب على ارتفاع الاسعار ولو بقدر ما؛ ولو انت مقدم خدمة مستفيد يدعوك لأن تكون من المُيسرين  وتتبع طريقة الأذكياء في البيع بأن تقدم نسبة خصم لا تضر بمكاسبك ولكن في المقابل ستكون عنصر جذب للمشتري وبإذن الله ستحقق الرواج ومزيد من المبيعات.
	</h2>-->
</div>


<div class="index-faq-div">
<!--<div class="container">-->
	<div class="sub-container">
			<h1 class=" h2-heading"><?php echo $lang['faq'];?></h1>
			<div class="bottom">
				<div class="div-relative bold">
					<h2 class="span-div-relative"><?php echo $lang['ques1'];?></h2>
				    <i class="fas fa-plus"></i> <i class="fas fa-minus"></i>
				</div>
				<div class="div-absolute">
					<p class="p-faq-answer"><?php echo $lang['answer1'];?></p>
				</div>
	        </div>

	        <div class="bottom">
				<div class="div-relative bold">
					<h3 class="span-div-relative"><?php echo $lang['ques3'];?></h3>
				    <i class="fas fa-plus"></i> <i class="fas fa-minus"></i>
				</div>
				<div class="div-absolute">
					<p class="p-faq-answer"><?php echo $lang['answer3'];?></p>
				</div>
			</div>

			<div class="bottom">
				<div class="div-relative bold">
					<h4 class="span-div-relative"><?php echo $lang['ques4'];?></h4>
				    <i class="fas fa-plus"></i> <i class="fas fa-minus"></i>
				</div>
				<div class="div-absolute div-faq-answer">
					<p class="p-faq-answer"><?php echo $lang['answer4'];?></p>
				</div>
			</div>

			<div class="bottom">
				<div class="div-relative bold">
					<h5 class="span-div-relative"><?php echo $lang['ques5'];?></h5>
				    <i class="fas fa-plus"></i> <i class="fas fa-minus"></i>
				</div>
				<div class="div-absolute div-faq-answer">
					<p class="p-faq-answer"><?php echo $lang['answer5'];?></p>
				</div>
			</div>

			<div class="last"><a href="faq.php"><h1>اقرأ المزيد من الاسئلة الشائعة  </h1></a></div>

    </div>
</div>

 
<div class="how2work">
		<h1 class="how2work-heading centered ">كيف يعمل مستفيد</h1>
			<div class="son">
				<div>
					<i class="fas fa-search centered"></i>
					<h1 class="centered">ابحث عن الخدمات والمنتجات  </h1>
				</div>
				<div>
					<i class="fas fa-eye centered"></i>
					<h1 class="centered">اعرف التفاصيل والسعر بعد الخصم  </h1>
				</div>
				<div>
					<i class="fas fa-check centered"></i>
					<h1 class="centered">قدم طلب شراء </h1>
				</div>
			</div>
</div>








<!--?????????????????????????-->
<p id="head-pp" class="head-p no-margin right">أقسام المنتجات </p>
<div class="icons">

	<!--<img src="layout/images/perfume2.png">-->
	<div class="con"><a href="search.php?cat=1&state=0&ordering=1 "><i class="fas fa-hamburger"></i></a> <p>طعام </p></div>
	<div class="con"><a href="search.php?cat=2&state=0&ordering=1 "><i class="fas fa-tv"></i></a> <p>أجهزة </p></div>
	<div class="con"><a href="search.php?cat=3&state=0&ordering=1 "><i class="fas fa-couch"></i></a> <p>لوازم المنزل </p></div>
	<div class="con"><a href="search.php?cat=4&state=0&ordering=1 "><i class="fas fa-spray-can"></i></a> <p>الجمال والزينة </p></div>
	<div class="con"><a href="search.php?cat=5&state=0&ordering=1 "><i class="fas fa-tshirt"></i></a> <p>ملابس وأحذية </p></div>
	<div class="con"><a href="search.php?cat=6&state=0&ordering=1 "><i class="fas fa-paint-roller"></i></a> <p>بناء وتشطيبات </p></div>
	<div class="con"><a href="search.php?cat=7&state=0&ordering=1 "><i class="fas fa-building"></i></a> <p>عقارات وأراضي </p></div>
	<div class="con"><a href="search.php?cat=8&state=0&ordering=1 "><i class="fas fa-car"></i></a> <p>مركبات </p></div>
	<div class="con"><a href="search.php?cat=9&state=0&ordering=1 "><i class="fas fa-tractor"></i></a> <p>معدات  ومستلزمات  </p></div>
	<div class="con"><a href="search.php?cat=10&state=0&ordering=1 "><i class="fas fa-cogs"></i></a> <p>قطع غيار </p></div>
</div>




<div class="index-below">
		<?php
		$stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
         FROM items
	     JOIN categories  ON items.cat_id=categories.cat_id
	     JOIN sub         ON items.subcat_id=sub.subcat_id
	     JOIN user        ON items.user_id=user.user_id
	     JOIN country     ON items.country_id=country.country_id
	     JOIN state       ON items.state_id=state.state_id
	     JOIN city        ON items.city_id=city.city_id
		WHERE  items.approve>0 and items.hide=0	and items.cat_id<11						
		ORDER BY   items.discount desc   limit 4");
		$stmt->execute();
		$itemsGET=$stmt->fetchAll();

		if (!empty($itemsGET)) { ?>
		<div class="inner"> 
		<span class="head">المنتجات الأكبر  خصما </span>
		  <div class="items-container items-container-profile general"> <?php
			foreach ($itemsGET as $value) { 
				$ratio=$value['price']*($value['discount']/100);
                $finalPrice=number_format(round($value['price']-$ratio) ) ;
				?>
				<div class="repeated-cont repeated-cont-profile ">
				<!-- bring ads on clicking on  aside links-->
				      <div class="div-img-disc">
				    	<span title="خصم" class="disc"><?php echo $value['discount'].'%'.' -' ?></span>
				        <?php
			        if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id']) { 
			        	  $fetchFav=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$_SESSION['traderid']);
				        	
				        	if($fetchFav['favourite_status']==1){ 
				        	   ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_T purple"></i><?php 
				        	}else{ 
				        		?><i title="حفظ "  class="fas fa-heart fav fav_T grey"></i><?php
				        	} ?>
				        	    <input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
					        	<input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
					        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
					        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
					        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
				                <input type="hidden" class="trader" value="<?php echo $_SESSION['traderid'];?>">
                         <?php
			        }elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
			        	 ?><a><i class="fas fa-heart grey2"></i></a><?php
			        
			        }elseif (isset($_SESSION['userEid'])) {
			        	$fetchEid=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$_SESSION['userEid']);
			            if($fetchEid==1){ ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
				        	}else{ 
				        	 ?><i title="حفظ" class="fas fa-heart fav fav_E grey"></i><?php
				        	 } ?>
				        	<input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
			                <input type="hidden" class="user" value="<?php echo $_SESSION['userEid'];?>">
			                <input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
				        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
				        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
				        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
			        <?php }elseif (isset($_SESSION['userGid'])||isset($_SESSION['userFid']) ) {
			        	    $social=isset($_SESSION['userGid'])?$_SESSION['userGid']:$_SESSION['userFid'];
			        	    $fetchGid=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$social);
			            if($fetchGid['favourite_status']==1){ ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
				        	}else{ 
				        	 ?><i title="حفظ" class="fas fa-heart fav fav_E grey"></i><?php
				        	 } ?>
				        	<input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
			                <input type="hidden" class="user" value="<?php echo $social;?>">
			                <input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
				        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
				        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
				        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
			        <?php  }else{ ?><a href="login.php"><i class="fas fa-heart grey2"></i></a>  <?php }   ?> 
				       
				        <img src="data\upload\<?php echo $value['photo']?>" alt="<?php echo $value['title'] ?>">
				      </div>
			        <section>
					   <span class="alone small cut2"><?php echo $value['cat_nameAR'].' > '.$value['subcat_nameAR'];?></span>
	 					<a  class="p-title  alone font1 titleLink" href="details.php?id=<?php echo $value['item_id']?>&t=i "><?php echo $value['title'] ?></a>
	 					<input type="hidden" class="idValue" value="<?php echo $value['item_id'];?>">
	 					<p class="date"><i class="fas fa-calendar"></i><?php echo ' '.$value['item_date'].' '; if($value['sit']==1){ echo "المعلن هو المالك  ";}elseif($value['sit']==2){ echo "السعر شامل أجر الوسيط  ";} ?></p>
	 						
	 						<div class="finalPrice-div">
		 						<s><?php echo number_format($value['price']); ?></s>
		 						<span>ج.م.</span>
		 						<span>
		 							<span class="bold"><?php echo $finalPrice ?></span>
		 						    <span class="currency">ج.م.</span>
		 						</span>
		 					</div>
	 						<?php 
		 					if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id'] ) { //appears as a link for users
		 					 	?><hr><?php
		 					}elseif (isset($_SESSION['userEid'])||isset($_SESSION['userGid'])||isset($_SESSION['userFid'])) { 
		 						?><hr><?php
		 					}elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
		 						?> <a class="a-phone"><i class="fas fa-phone"></i></a> <?php
		 					}else{ //appears as empty link for traders
		 					 	?> <a class="a-phone" href="login.php"><i class="fas fa-phone"></i></a> <?php
		 					} ?>
	 					 <!--</p>-->
	 					 <div class="bottom-div">
		 					<span class="alone small"><?php echo $value['country_nameAR'].'/'.$value['state_nameAR'].'/'.$value['city_nameAR'];?></span>
		 					<?php 
		 					if ($value['delivery']==1) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مدفوع داخل محافظة  </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==2) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مجاني داخل محافظة  </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==3) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مدفوع داخل  </span><span><?php echo $value['city_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==4) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مجاني داخل </span><span><?php echo $value['city_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==5) { ?><span class="alone deliv"><span class="cut2"><i title="توصيل " class="fas fa-truck"></i>مجاني  </span><span><?php echo $value['city_nameAR'].' ' ?>مدفوع  <?php echo $value['state_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==6) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مجاني  </span><span><?php echo $value['city_nameAR'] ?>مدفوع كل  المحافظات   </span></span> <?php }
		 					if ($value['delivery']==7) { ?><span class="alone deliv"><i title="توصيل " class="fas fa-truck"></i>مدفوع لكل  المحافظات</span> <?php }
		 					if ($value['delivery']==8) { ?><span class="alone deliv"><i title="توصيل " class="fas fa-truck"></i>مجاني لكل  المحافظات</span> <?php }
		 					?>
	 				     </div>
					 </section>
				</div>
		<?php	}
		 ?></div>
		<a class="see-more" href="search.php?cat=0&state=0&ordering=1 ">شاهد المزيد </a>
	</div> 
   <?php } ?>




	
		<?php
		$stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
         FROM items
	     JOIN categories  ON items.cat_id=categories.cat_id
	     JOIN sub         ON items.subcat_id=sub.subcat_id
	     JOIN user        ON items.user_id=user.user_id
	     JOIN country     ON items.country_id=country.country_id
	     JOIN state       ON items.state_id=state.state_id
	     JOIN city        ON items.city_id=city.city_id
		WHERE  items.approve>0 and items.hide=0	and items.cat_id<11					
		ORDER BY   items.item_id desc   limit 4");
		$stmt->execute();
		$itemsGET=$stmt->fetchAll();

		if (!empty($itemsGET)) { ?>
		<div class="inner">
		<span class="head">المنتجات  الأحدث اضافة </span>
		  <div class="items-container items-container-profile general"> <?php
			foreach ($itemsGET as $value) { 
				$ratio=$value['price']*($value['discount']/100);
                $finalPrice=number_format(round($value['price']-$ratio) ) ;
				?>
				<div class="repeated-cont repeated-cont-profile ">
				<!-- bring ads on clicking on  aside links-->
				      <div class="div-img-disc">
				    	<span title="خصم" class="disc"><?php echo $value['discount'].'%'.' -' ?></span>
				        <?php
			        if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id']) { 
			        	  $fetchFav=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$_SESSION['traderid']);
				        	
				        	if($fetchFav['favourite_status']==1){ 
				        	   ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_T purple"></i><?php 
				        	}else{ 
				        		?><i title="حفظ "  class="fas fa-heart fav fav_T grey"></i><?php
				        	} ?>
				        	    <input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
					        	<input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
					        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
					        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
					        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
				                <input type="hidden" class="trader" value="<?php echo $_SESSION['traderid'];?>">
                         <?php
			        }elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
			        	 ?><a><i class="fas fa-heart grey2"></i></a>  <?php
			        
			        }elseif (isset($_SESSION['userEid'])) {
			        	$fetchEid=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$_SESSION['userEid']);
			            if($fetchEid==1){ ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
				        	}else{ 
				        	 ?><i title="حفظ" class="fas fa-heart fav fav_E grey"></i><?php
				        	 } ?>
				        	<input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
			                <input type="hidden" class="user" value="<?php echo $_SESSION['userEid'];?>">
			                <input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
				        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
				        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
				        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
			        <?php }elseif (isset($_SESSION['userGid']) ||isset($_SESSION['userFid']) ) {
			        	    $social=isset($_SESSION['userGid'])?$_SESSION['userGid']:$_SESSION['userFid'];
			        	  $fetchGid=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$social);
			            if($fetchGid['favourite_status']==1){ ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
				        	}else{ 
				        	 ?><i title="حفظ" class="fas fa-heart fav fav_E grey"></i><?php
				        	 } ?>
				        	<input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
			                <input type="hidden" class="user" value="<?php echo $social;?>">
			                <input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
				        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
				        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
				        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">

			        <?php }else{ ?><a href="login.php"><i class="fas fa-heart grey2"></i></a>  <?php }  ?> 
				       
				        <img src="data\upload\<?php echo $value['photo']?>" alt="<?php echo $value['title'] ?>">
				      </div>
			        <section>
					   <span class="alone small cut2"><?php echo $value['cat_nameAR'].' > '.$value['subcat_nameAR'];?></span>
	 					<a href="details.php?id=<?php echo $value['item_id']?>&t=i " class="p-title  alone font1 titleLink"><?php echo $value['title'] ?></a>
	 					<input type="hidden" class="idValue" value="<?php echo $value['item_id'];?>">
	 					<p class="date"><i class="fas fa-calendar"></i><?php echo ' '.$value['item_date'].' '; if($value['sit']==1){ echo "المعلن هو المالك  ";}elseif($value['sit']==2){ echo "السعر شامل أجر الوسيط  ";} ?></p>
	 						
	 						<div class="finalPrice-div">
		 						<s><?php echo number_format($value['price']);?></s>
		 						<span>ج.م.</span>
		 						<span>
		 							<span class="bold"><?php echo $finalPrice ?></span>
		 						    <span>ج.م.</span>
		 						</span>
		 					</div>
	 						<?php 
		 					if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id'] ) { //appears as a link for users
		 					   ?><hr><?php
		 					}elseif (isset($_SESSION['userEid'])||isset($_SESSION['userGid'])||isset($_SESSION['userFid'])) { 
		 					  ?><hr><?php
		 					}elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
		 						?> <a class="a-phone"><i class="fas fa-phone"></i></a> <?php
		 					}else{ //appears as empty link for traders
		 					 	?> <a class="a-phone" href="login.php"><i class="fas fa-phone"></i></a> <?php
		 					} ?>
	 					 <div class="bottom-div">
		 					<span class="alone small"><?php echo $value['country_nameAR'].'/'.$value['state_nameAR'].'/'.$value['city_nameAR'];?></span>
		 					<?php
		 					if ($value['delivery']==1) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مدفوع داخل محافظة  </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==2) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مجاني داخل محافظة  </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==3) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مدفوع داخل </span><span><?php echo $value['city_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==4) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مجاني داخل </span><span><?php echo $value['city_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==5) { ?><span class="alone deliv"><span class="cut2"><i title="توصيل " class="fas fa-truck"></i>مجاني  </span><span><?php echo $value['city_nameAR'].' ' ?>مدفوع  <?php echo $value['state_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==6) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مجاني  </span><span><?php echo $value['city_nameAR'] ?>مدفوع كل  المحافظات   </span></span> <?php }
		 					if ($value['delivery']==7) { ?><span class="alone deliv"><i title="توصيل " class="fas fa-truck"></i>مدفوع لكل  المحافظات</span> <?php }
		 					if ($value['delivery']==8) { ?><span class="alone deliv"><i title="توصيل " class="fas fa-truck"></i>مجاني لكل  المحافظات</span> <?php } 
		 					?>
	 				     </div>
					 </section>
				</div>
		<?php	}
		 ?></div>
		
		<a class="see-more"  href="search.php?cat=0&state=0&ordering=2 ">شاهد المزيد </a> 
	</div>
 <?php } ?>



	
		
		<?php
		$stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
         FROM items
	     JOIN categories  ON items.cat_id=categories.cat_id
	     JOIN sub         ON items.subcat_id=sub.subcat_id
	     JOIN user        ON items.user_id=user.user_id
	     JOIN country     ON items.country_id=country.country_id
	     JOIN state       ON items.state_id=state.state_id
	     JOIN city        ON items.city_id=city.city_id
		WHERE  items.approve>0 and items.hide=0	and items.cat_id<11						
		ORDER BY   items.seen desc   limit 4");
		$stmt->execute();
		$itemsGET=$stmt->fetchAll();

		if (!empty($itemsGET)) { ?>
		<div class="inner inner-last">
			<span class="head">المنتجات   الأكثر  مشاهدة </span>
		  <div class="items-container items-container-profile general"> <?php
			foreach ($itemsGET as $value) { 
				$ratio=$value['price']*($value['discount']/100);
                $finalPrice=number_format(round($value['price']-$ratio) ) ;

                $fetchCat=fetch('cat_id','items','item_id',$value['item_id']);
                $fetchSub=fetch('subcat_id','items','item_id',$value['item_id']);
                $fetchCont=fetch('country_id','items','item_id',$value['item_id']);

				?>
				<div class="repeated-cont repeated-cont-profile ">
				<!-- bring ads -->
				      <div class="div-img-disc">
				    	<span title="خصم" class="disc"><?php echo $value['discount'].'%'.' -' ?></span>
				        <?php
			        if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id']) { 
			        	  $fetchFav=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$_SESSION['traderid']);
				        	
				        	if($fetchFav['favourite_status']==1){ 
				        	   ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_T purple"></i><?php 
				        	}else{ 
				        		?><i title="حفظ "  class="fas fa-heart fav fav_T grey"></i><?php
				        	} ?>
				        	    <input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
					        	<input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
					        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
					        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
					        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
				                <input type="hidden" class="trader" value="<?php echo $_SESSION['traderid'];?>">
                         <?php
			        }elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
			        	 ?><a><i class="fas fa-heart grey2"></i></a>  <?php
			        
			        }elseif (isset($_SESSION['userEid'])) {
			        	$fetchEid=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$_SESSION['userEid']);
			            if($fetchEid==1){ ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
				        	}else{ 
				        	 ?><i title="حفظ" class="fas fa-heart fav fav_E grey"></i><?php
				        	 } ?> 
				        	<input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
			                <input type="hidden" class="user" value="<?php echo $_SESSION['userEid'];?>">
			                <input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
				        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
				        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
				        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
			        <?php }elseif (isset($_SESSION['userGid']) ||isset($_SESSION['userFid']) ) {
			        	    $social=isset($_SESSION['userGid'])?$_SESSION['userGid']:$_SESSION['userFid'];
			        	   $fetchGid=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$social);
			            if($fetchGid['favourite_status']==1){ ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
				        	}else{ 
				        	 ?><i title="حفظ" class="fas fa-heart fav fav_E grey"></i><?php
				        	 } ?>
				        	<input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
			                <input type="hidden" class="user" value="<?php echo $social;?>">
			                <input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
				        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
				        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
				        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
			        
			        <?php }else{ ?><a href="login.php"><i class="fas fa-heart grey2"></i></a>  <?php }  ?> 
				       
				        <img src="data\upload\<?php echo $value['photo']?>" alt="<?php echo $value['title'] ?>">
				      </div>
			        <section> 
					   <span class="alone small cut2"><?php echo getCat($fetchCat['cat_id']).' > '.getSub($fetchSub['subcat_id']);?></span>
	 					<a href="details.php?id=<?php echo $value['item_id']?>&t=i " class="p-title  alone font1 titleLink"><?php echo $value['title'] ?></a>
	 					<input type="hidden" class="idValue" value="<?php echo $value['item_id'];?>">
	 					<p class="date"><i class="fas fa-calendar"></i><?php echo ' '.$value['item_date'].' '; if($value['sit']==1){ echo "المعلن هو المالك  ";}elseif($value['sit']==2){ echo "السعر شامل أجر الوسيط  ";} ?></p>
	 						
	 						<div class="finalPrice-div">
		 						<s><?php echo number_format($value['price']);?></s>
		 						<span>ج.م.</span>
		 						<span>
		 							<span class="bold"><?php echo $finalPrice ?></span>
		 						    <span>ج.م.</span>
		 						</span>
	 					    </div>
	 						<?php 
		 					if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id'] ) { //appears as a link for users
		 					 	?><hr><?php
		 					}elseif (isset($_SESSION['userEid'])||isset($_SESSION['userGid'])||isset($_SESSION['userFid'])) { 
		 						?><hr><?php
		 					}elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
		 						?> <a class="a-phone"><i class="fas fa-phone"></i></a> <?php
		 					}else{ //appears as empty link for traders
		 					 	?> <a class="a-phone" href="login.php"><i class="fas fa-phone"></i></a> <?php
		 					} ?>
	 					 <div class="bottom-div">
		 					<span class="alone small"><?php echo getCountry($fetchCont['country_id']).'/'.$value['state_nameAR'].'/'.$value['city_nameAR'];?></span>
		 					<?php
		 					if ($value['delivery']==1) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مدفوع داخل محافظة  </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==2) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مجاني داخل محافظة  </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==3) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مدفوع داخل </span><span><?php echo $value['city_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==4) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مجاني داخل </span><span><?php echo $value['city_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==5) { ?><span class="alone deliv"><span class="cut2"><i title="توصيل " class="fas fa-truck"></i>مجاني  </span><span><?php echo $value['city_nameAR'].' ' ?>مدفوع  <?php echo $value['state_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==6) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مجاني  </span><span><?php echo $value['city_nameAR'] ?>مدفوع كل  المحافظات   </span></span> <?php }
		 					if ($value['delivery']==7) { ?><span class="alone deliv"><i title="توصيل " class="fas fa-truck"></i>مدفوع لكل  المحافظات</span> <?php }
		 					if ($value['delivery']==8) { ?><span class="alone deliv"><i title="توصيل " class="fas fa-truck"></i>مجاني لكل  المحافظات</span> <?php }
		 					?>
	 				     </div>
					 </section>
				</div>
		<?php	}
		 ?></div> 
		
		<a class="see-more" href="search.php?cat=0&state=0&ordering=3 ">شاهد المزيد </a>
	</div>
  <?php	} ?>
</div>

<!--------------------  CAROUSEL --------------------->
<!--<p class="cats-container-p">اقسام الموقع</p>
<div class="cats-container">
	<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
	  <div class="carousel-indicators">
	    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
	    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
	    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
	    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
	    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
	    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="5" aria-label="Slide 6"></button>
	  </div>
	  <div class="carousel-inner">
	    <div class="carousel-item active">
	      <img src="layout/images/build.jpg" class="d-block w-100" alt="...">
	      <div class="carousel-caption d-none d-md-block">
	        <h3>First slide label</h3>
	        <p class="p-carousel">Some representative placeholder content for the first slide.</p>
	      </div>
	    </div>
	    <div class="carousel-item">
	      <img src="layout/images/devices.jpg" class="d-block w-100" alt="...">
	      <div class="carousel-caption d-none d-md-block">
	        <h3>Second slide label</h3>
	        <p class="p-carousel">Some representative placeholder content for the second slide.</p>
	      </div>
	    </div>
	    <div class="carousel-item">
	      <img src="layout/images/food.jpg" class="d-block w-100" alt="...">
	      <div class="carousel-caption d-none d-md-block">
	        <h3>Third slide label</h3>
	        <p class="p-carousel">Some representative placeholder content for the third slide.</p>
	      </div>
	    </div>
	    <div class="carousel-item">
	      <img src="layout/images/beauty.jpg" class="d-block w-100" alt="...">
	      <div class="carousel-caption d-none d-md-block">
	        <h3>fourth slide label</h3>
	        <p class="p-carousel">Some representative placeholder content for the third slide.</p>
	      </div>
	    </div>
	    <div class="carousel-item">
	      <img src="layout/images/sofa.png" class="d-block w-100" alt="...">
	      <div class="carousel-caption d-none d-md-block">
	        <h3>fifth slide label</h3>
	        <p class="p-carousel">Some representative placeholder content for the third slide.</p>
	      </div>
	    </div>
	    <div class="carousel-item">
	      <img src="layout/images/clothes.png" class="d-block w-100" alt="...">
	      <div class="carousel-caption d-none d-md-block">
	        <h3>sixth slide label</h3>
	        <p class="p-carousel">Some representative placeholder content for the third slide.</p>
	      </div>
	    </div>
	  </div>
	  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
	    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	    <span class="visually-hidden">Previous</span>
	  </button>
	  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
	    <span class="carousel-control-next-icon" aria-hidden="true"></span>
	    <span class="visually-hidden">Next</span>
	  </button>
	</div>
</div>-->




<!--     FROM DATABASE -->
<div>
	     
</div>

<?php
	//counter eye to count page visits
	include 'counter.php';
	echo '<span class="eye-counter" id="'.$_SESSION['counterGeneral'].'"></span>'; 
	?>
  <!--ajax coner -->
   <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
   <script>
   $(document).ready(function(){
	   //ajax call send page views
	  var eye=$('.eye-counter').attr('id');
	  $.ajax({
	  url:"counterInsert.php",
	  data:{general:eye}
	     });
	   //ajax call send item views
	   $('.titleLink').click(function(){
	  var item=$(this).nextAll('.idValue').val();
	  $.ajax({
	  url:"process2.php", 
	  data:{itemView:item} 
	     });
	   });
	   //ajax add to favourite  => from users
     $(".fav_E").on("click", function(){
      var item=$(this).nextAll('.item').val();
      var user=$(this).nextAll('.user').val();
      var cat=$(this).nextAll('.cat').val();
      var sub=$(this).nextAll('.sub').val();
      var state=$(this).nextAll('.state').val();
      var city=$(this).nextAll('.city').val();
      $.ajax({
      url:"process3.php",
      data:{item_E:item,user_E:user,cat_E:cat,sub_E:sub,st_E:state,ci_E:city}
       });
     });
     //ajax add to favourite_tr => from traders
     $(".fav_T").on("click", function(){
      var item=$(this).nextAll('.item').val();
      var trader=$(this).nextAll('.trader').val();
      var cat=$(this).nextAll('.cat').val();
      var sub=$(this).nextAll('.sub').val();
      var state=$(this).nextAll('.state').val();
      var city=$(this).nextAll('.city').val();
      $.ajax({
      url:"process3.php",
      data:{item_T:item,user_T:trader,cat:cat,sub:sub,st:state,ci:city}
       });
     });
    //



     });
   </script>
   
 


<!--&&&&&&&&&&&&&&&&&&&&&&&&   khadamat  services &&&&&&&&&&&&&&&&&&&&&&&&&& -->
<p id="head-ps" class="head-p no-margin right">أقسام الخدمات  </p>
 
<div class="icons"> 
	<div class="con"><a href="search.php?cat=11&s=s&state=0&ordering=1"><i class="far fa-object-group"></i></a> <p>خدمات تصميم </p></div>
	<div class="con"><a href="search.php?cat=12&s=s&state=0&ordering=1"><i class="fas fa-truck"></i></a> <p>خدمات نقل </p></div>
	<div class="con"><a href="search.php?cat=13&s=s&state=0&ordering=1"><i class="fas fa-screwdriver"></i></a> <p>خدمات صيانة </p></div>
	<div class="con"><a href="search.php?cat=14&s=s&state=0&ordering=1"><i class="fas fa-building building-service"></i></a> <p>خدمات المنزل والمعمار </p></div>
	<div class="con"><a href="search.php?cat=15&s=s&state=0&ordering=1"><i class="fas fa-user-graduate"></i></a> <p>تعليم وتدريب  </p></div>
	<div class="con"><a href="search.php?cat=16&s=s&state=0&ordering=1"><i class="fas fa-dove"></i></a> <p>مظهر وتجميل  </p></div>
	<div class="con"><a href="search.php?cat=17&s=s&state=0&ordering=1"><i class="fas fa-video"></i></a> <p>خدمات ترفيهية  </p></div>
</div>




<div class="index-below">
	
		<?php
		$stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
         FROM items
	     JOIN categories  ON items.cat_id=categories.cat_id
	     JOIN sub         ON items.subcat_id=sub.subcat_id
	     JOIN user        ON items.user_id=user.user_id
	     JOIN country     ON items.country_id=country.country_id
	     JOIN state       ON items.state_id=state.state_id
	     JOIN city        ON items.city_id=city.city_id
		WHERE  items.approve>0 and items.hide=0	and categories.cat_id>10					
		ORDER BY   items.discount desc   limit 4");
		$stmt->execute();
		$itemsGET=$stmt->fetchAll(); 

		if (!empty($itemsGET)) { ?>
		 <div class="inner">  
		  <span class="head">الخدمات  الأكبر  خصما </span>
		  <div class="items-container items-container-profile"> <?php
			foreach ($itemsGET as $value) { 
				$ratio=$value['price']*($value['discount']/100);
                $finalPrice=number_format(round($value['price']-$ratio) ) ;
				?>
				<div class="repeated-cont repeated-cont-profile ">
				<!-- bring ads on clicking on  aside links-->
				      <div class="div-img-disc">
				    	<span title="خصم" class="disc"><?php echo $value['discount'].'%'.' -' ?></span>
				        <?php
			        if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id']) { 
			        	  $fetchFav=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$_SESSION['traderid']);
				        	
				        	if($fetchFav['favourite_status']==1){ 
				        	   ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_T purple"></i><?php 
				        	}else{ 
				        		?><i title="حفظ "  class="fas fa-heart fav fav_T grey"></i><?php
				        	} ?>
				        	    <input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
					        	<input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
					        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
					        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
					        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
				                <input type="hidden" class="trader" value="<?php echo $_SESSION['traderid'];?>">
                         <?php
			        }elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
			        	 ?><a><i class="fas fa-heart grey2"></i></a>  <?php
			        
			        }elseif (isset($_SESSION['userEid'])) {
			        	$fetchEid=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$_SESSION['userEid']);
			            if($fetchEid==1){ ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
				        	}else{ 
				        	 ?><i title="حفظ" class="fas fa-heart fav fav_E grey"></i><?php
				        	 } ?>
				        	<input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
			                <input type="hidden" class="user" value="<?php echo $_SESSION['userEid'];?>">
			                <input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
				        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
				        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
				        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
			        <?php }elseif (isset($_SESSION['userGid']) ||isset($_SESSION['userFid']) ) {
			        	    $social=isset($_SESSION['userGid'])?$_SESSION['userGid']:$_SESSION['userFid'];
			        	   $fetchEid=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$social);
			            if($fetchEid['favourite_status']==1){ ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
				        	}else{ 
				        	 ?><i title="حفظ" class="fas fa-heart fav fav_E grey"></i><?php
				        	 } ?>
				        	<input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
			                <input type="hidden" class="user" value="<?php echo $social;?>">
			                <input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
				        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
				        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
				        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">

			       <?php }else{ ?><a href="login.php"><i class="fas fa-heart grey2"></i></a>  <?php }  ?> 
				       
				        <img src="data\upload\<?php echo $value['photo']?>" alt="<?php echo $value['title'] ?>">
				      </div>
			        <section>
					   <span class="alone cut2"><span class="small" title="<?php echo $value['cat_nameAR']?>"><?php echo $value['cat_nameAR'].'</span> > <span class="small" title="'.$value['subcat_nameAR'].'">'.$value['subcat_nameAR'];?></span></span>
	 					<a href="details.php?id=<?php echo $value['item_id']?>" class="p-title  alone font1 titleLink"><?php echo $value['title'] ?></a>
	 					<input type="hidden" class="idValue" value="<?php echo $value['item_id'];?>">
	 					<p class="date"><?php echo 'أضيف في: '.$value['item_date'] ?></p>
	 					<div class="finalPrice-div ">
	 						<s><?php echo number_format($value['price']);?></s>
	 						<span>ج.م.</span>
	 						<span> 
	 							<span class="bold"><?php echo $finalPrice ?></span>
	 						    <span>ج.م.</span>
	 						</span>
	 					</div> 
	 						<?php
		 					if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id'] ) { //appears as a link for users
		 					  ?><hr><?php
		 					}elseif (isset($_SESSION['userEid'])||isset($_SESSION['userGid'])||isset($_SESSION['userFid'])) {
                 ?><hr><?php
		 					}elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
		 						?> <a class="a-phone"><i class="fas fa-phone"></i></a> <?php
		 					}else{ //appears as empty link for traders
		 					 	?> <a class="a-phone" href="login.php"><i class="fas fa-phone"></i></a> <?php
		 					} ?>
	 					 </p>
	 					 <div class="bottom-div">
		 					<span class="alone small"><?php echo $value['country_nameAR'].'/'.$value['state_nameAR'].'/'.$value['city_nameAR'];?></span>
		 					<?php
		 					if ($value['delivery']==1) { ?><span class="alone"><span> توصيل مدفوع داخل  </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==2) { ?><span class="alone"><span>توصيل مجاني داخل </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==3) { ?><span class="alone"><span>توصيل مدفوع داخل </span><span><?php echo $value['city_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==4) { ?><span class="alone"><span>توصيل مجاني داخل </span><span><?php echo $value['city_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==5) { ?><span class="alone">توصيل مدفوع لجميع المحافظات</span> <?php }
		 					if ($value['delivery']==6) { ?><span class="alone">توصيل مجاني لجميع المحافظات</span> <?php }
		 					?>
	 				     </div>
					 </section>
				</div>
		<?php	}
		 ?></div> 
		<a class="see-more" href="search.php?cat=0&s=s&state=0&ordering=1">شاهد المزيد </a>
	</div>
  <?php } ?>





	
		<?php
		$stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
         FROM items
	     JOIN categories  ON items.cat_id=categories.cat_id
	     JOIN sub         ON items.subcat_id=sub.subcat_id
	     JOIN user        ON items.user_id=user.user_id
	     JOIN country     ON items.country_id=country.country_id
	     JOIN state       ON items.state_id=state.state_id
	     JOIN city        ON items.city_id=city.city_id
		WHERE  items.approve>0 and items.hide=0	and categories.cat_id>10					
		ORDER BY   items.item_id desc   limit 4");
		$stmt->execute();
		$itemsGET=$stmt->fetchAll();

		if (!empty($itemsGET)) { ?>
		<div class="inner">
		  <span class="head">الخدمات الأحدث اضافة </span>
		  <div class="items-container items-container-profile"> <?php
			foreach ($itemsGET as $value) { 
				$ratio=$value['price']*($value['discount']/100);
                $finalPrice=number_format(round($value['price']-$ratio) ) ;
				?>
				<div class="repeated-cont repeated-cont-profile ">
				<!-- bring ads on clicking on  aside links-->
				      <div class="div-img-disc">
				    	<span title="خصم" class="disc"><?php echo $value['discount'].'%'.' -' ?></span>
				        <?php
			        if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id']) { 
			        	  $fetchFav=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$_SESSION['traderid']);
				        	
				        	if($fetchFav['favourite_status']==1){ 
				        	   ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_T purple"></i><?php 
				        	}else{ 
				        		?><i title="حفظ "  class="fas fa-heart fav fav_T grey"></i><?php
				        	} ?>
				        	    <input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
					        	<input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
					        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
					        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
					        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
				                <input type="hidden" class="trader" value="<?php echo $_SESSION['traderid'];?>">
                         <?php
			        }elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
			        	 ?><a><i class="fas fa-heart grey2"></i></a>  <?php
			        
			        }elseif (isset($_SESSION['userEid'])) {
			        	$fetchEid=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$_SESSION['userEid']);
			            if($fetchEid==1){ ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
				        	}else{ 
				        	 ?><i title="حفظ" class="fas fa-heart fav fav_E grey"></i><?php
				        	 } ?>
				        	<input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
			                <input type="hidden" class="user" value="<?php echo $_SESSION['userEid'];?>">
			                <input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
				        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
				        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
				        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
			        <?php }elseif (isset($_SESSION['userGid']) ||isset($_SESSION['userFid']) ) {
			        	    $social=isset($_SESSION['userGid'])?$_SESSION['userGid']:$_SESSION['userFid'];
			        	   $fetchEid=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$social);
			            if($fetchEid['favourite_status']==1){ ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
				        	}else{ 
				        	 ?><i title="حفظ" class="fas fa-heart fav fav_E grey"></i><?php
				        	 } ?>
				        	<input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
			                <input type="hidden" class="user" value="<?php echo $social;?>">
			                <input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
				        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
				        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
				        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
			        <?php }else{ ?><a href="login.php"><i class="fas fa-heart grey2"></i></a>  <?php }  ?> 
				       
				        <img src="data\upload\<?php echo $value['photo']?>" alt="<?php echo $value['title'] ?>">
				      </div>
			        <section>
					    <span class="alone cut2"><span class="small" title="<?php echo $value['cat_nameAR']?>"><?php echo $value['cat_nameAR'].'</span> > <span class="small" title="'.$value['subcat_nameAR'].'">'.$value['subcat_nameAR'];?></span></span>
	 					<a href="details.php?id=<?php echo $value['item_id']?>" class="p-title  alone font1 titleLink"><?php echo $value['title'] ?></a>
	 					<input type="hidden" class="idValue" value="<?php echo $value['item_id'];?>">
	 					<p class="date"><?php echo 'أضيف في: '.$value['item_date'] ?></p>
	 					<div class="finalPrice-div">
	 						<s><?php echo number_format($value['price']);?></s>
	 						<span>ج.م.</span>
	 						<span>
	 							<span class="bold"><?php echo $finalPrice ?></span>
	 						    <span>ج.م.</span>
	 						</span>
	 					</div>
	 						<?php
		 					if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id'] ) { //appears as a link for users
                ?><hr><?php
		 					}elseif (isset($_SESSION['userEid'])||isset($_SESSION['userGid'])||isset($_SESSION['userFid'])) {
		 						?><hr><?php
		 					}elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
		 						?> <a class="a-phone"><i class="fas fa-phone"></i></a> <?php
		 					}else{ //appears as empty link for traders
		 					 	?> <a class="a-phone" href="login.php"><i class="fas fa-phone"></i></a> <?php
		 					} ?>
	 					 </p>
	 					 <div class="bottom-div">
		 					<span class="alone small"><?php echo $value['country_nameAR'].'/'.$value['state_nameAR'].'/'.$value['city_nameAR'];?></span>
		 					<?php
		 					if ($value['delivery']==1) { ?><span class="alone"><span> توصيل مدفوع داخل  </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==2) { ?><span class="alone"><span>توصيل مجاني داخل </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==3) { ?><span class="alone"><span>توصيل مدفوع داخل </span><span><?php echo $value['city_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==4) { ?><span class="alone"><span>توصيل مجاني داخل </span><span><?php echo $value['city_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==5) { ?><span class="alone">توصيل مدفوع لجميع المحافظات</span> <?php }
		 					if ($value['delivery']==6) { ?><span class="alone">توصيل مجاني لجميع المحافظات</span> <?php }
		 					?>
	 				     </div>
					 </section>
				</div>
		<?php	}
		 ?></div> 
		<a class="see-more"  href="search.php?cat=0&s=s&state=0&ordering=2">شاهد المزيد </a> 
	</div>
<?php } ?>



	


		<?php
		$stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
         FROM items
	     JOIN categories  ON items.cat_id=categories.cat_id
	     JOIN sub         ON items.subcat_id=sub.subcat_id
	     JOIN user        ON items.user_id=user.user_id
	     JOIN country     ON items.country_id=country.country_id
	     JOIN state       ON items.state_id=state.state_id
	     JOIN city        ON items.city_id=city.city_id
		WHERE  items.approve>0 and items.hide=0	 and categories.cat_id>10				
		ORDER BY   items.seen desc   limit 4");
		$stmt->execute();
		$itemsGET3=$stmt->fetchAll();

		if (!empty($itemsGET3)) { ?> 
		<div class="inner inner3">
		  <span class="head">الخدمات  الأكثر  مشاهدة </span> 
		  <div class="items-container items-container-profile"> <?php
			foreach ($itemsGET3 as $value) { 
				$ratio=$value['price']*($value['discount']/100);
                $finalPrice=number_format(round($value['price']-$ratio) ) ;
				?>
				<div class="repeated-cont repeated-cont-profile ">
				<!-- bring ads -->
				      <div class="div-img-disc">
				    	<span title="خصم" class="disc"><?php echo $value['discount'].'%'.' -' ?></span>
				        <?php
			        if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id']) { 
			        	  $fetchFav=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$_SESSION['traderid']);
				        	
				        	if($fetchFav['favourite_status']==1){ 
				        	   ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_T purple"></i><?php 
				        	}else{ 
				        		?><i title="حفظ "  class="fas fa-heart fav fav_T grey"></i><?php
				        	} ?>
				        	    <input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
					        	<input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
					        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
					        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
					        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
				                <input type="hidden" class="trader" value="<?php echo $_SESSION['traderid'];?>">
                         <?php
			        }elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
			        	 ?><a><i class="fas fa-heart grey2"></i></a>  <?php
			        
			        }elseif (isset($_SESSION['userEid'])) {
			        	$fetchEid=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$_SESSION['userEid']);
			            if($fetchEid==1){ ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
				        	}else{ 
				        	 ?><i title="حفظ" class="fas fa-heart fav fav_E grey"></i><?php
				        	 } ?>
				        	<input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
			                <input type="hidden" class="user" value="<?php echo $_SESSION['userEid'];?>">
			                <input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
				        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
				        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
				        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
			       
			        <?php }elseif (isset($_SESSION['userGid']) ||isset($_SESSION['userFid']) ) {
			        	    $social=isset($_SESSION['userGid'])?$_SESSION['userGid']:$_SESSION['userFid'];
			        	   $fetchEid=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$social);
			            if($fetchEid['favourite_status']==1){ ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
				        	}else{ 
				        	 ?><i title="حفظ" class="fas fa-heart fav fav_E grey"></i><?php
				        	 } ?>
				        	<input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
			                <input type="hidden" class="user" value="<?php echo $social;?>">
			                <input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
				        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
				        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
				        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
			        <?php }
			        else{ ?><a href="login.php"><i class="fas fa-heart grey2"></i></a>  <?php }  ?> 
				        <img src="data\upload\<?php echo $value['photo']?>" alt="<?php echo $value['title'] ?>">
				      </div>
			        <section>
			        	<span class="alone cut2"><span class="small" title="<?php echo $value['cat_nameAR']?>"><?php echo $value['cat_nameAR'].'</span> > <span class="small" title="'.$value['subcat_nameAR'].'">'.$value['subcat_nameAR'];?></span></span>
	 					<a href="details.php?id=<?php echo $value['item_id']?>" class="p-title  alone font1 titleLink"><?php echo $value['title'] ?></a>
	 					<input type="hidden" class="idValue" value="<?php echo $value['item_id'];?>">
	 					<p class="date"><?php echo 'أضيف في: '.$value['item_date'] ?></p>
	 					<div class="finalPrice-div ">
	 						<s><?php echo number_format($value['price']);?></s>
	 						<span>ج.م.</span>
	 						<span>
	 							<span class="bold"><?php echo $finalPrice ?></span>
	 						    <span>ج.م.</span>
	 						</span>
	 					</div>
	 						<?php
		 					if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id'] ) { //appears as a link for users
		 					 	?><hr><?php
		 					}elseif (isset($_SESSION['userEid'])||isset($_SESSION['userGid'])||isset($_SESSION['userFid'])) {
		 						?><hr><?php
		 					}elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
		 						?> <a class="a-phone"><i class="fas fa-phone"></i></a> <?php
		 					}else{ //appears as empty link for traders
		 					 	?> <a class="a-phone" href="login.php"><i class="fas fa-phone"></i></a> <?php 
		 					} ?>
	 					 </p>
	 					 <div class="bottom-div">
		 					<span class="alone small"><?php echo $value['country_nameAR'].'/'.$value['state_nameAR'].'/'.$value['city_nameAR'];?></span>
		 					<?php
		 					if ($value['delivery']==1) { ?><span class="alone"><span> توصيل مدفوع داخل  </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==2) { ?><span class="alone"><span>توصيل مجاني داخل </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==3) { ?><span class="alone"><span>توصيل مدفوع داخل </span><span><?php echo $value['city_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==4) { ?><span class="alone"><span>توصيل مجاني داخل </span><span><?php echo $value['city_nameAR'] ?></span></span> <?php }
		 					if ($value['delivery']==5) { ?><span class="alone">توصيل مدفوع لجميع المحافظات</span> <?php }
		 					if ($value['delivery']==6) { ?><span class="alone">توصيل مجاني لجميع المحافظات</span> <?php }
		 					?>
	 				     </div>
					 </section>
				</div>
		<?php	}
		 ?></div> 
		<a class="see-more" href="search.php?cat=0&s=s&state=0&ordering=3">شاهد المزيد </a>
	</div>
	<?php } ?>
</div>

<!--------------------  CAROUSEL --------------------->
<!--<p class="cats-container-p">اقسام الموقع</p>
<div class="cats-container">
	<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
	  <div class="carousel-indicators">
	    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
	    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
	    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
	    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
	    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
	    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="5" aria-label="Slide 6"></button>
	  </div>
	  <div class="carousel-inner">
	    <div class="carousel-item active">
	      <img src="layout/images/build.jpg" class="d-block w-100" alt="...">
	      <div class="carousel-caption d-none d-md-block">
	        <h3>First slide label</h3>
	        <p class="p-carousel">Some representative placeholder content for the first slide.</p>
	      </div>
	    </div>
	    <div class="carousel-item">
	      <img src="layout/images/devices.jpg" class="d-block w-100" alt="...">
	      <div class="carousel-caption d-none d-md-block">
	        <h3>Second slide label</h3>
	        <p class="p-carousel">Some representative placeholder content for the second slide.</p>
	      </div>
	    </div>
	    <div class="carousel-item">
	      <img src="layout/images/food.jpg" class="d-block w-100" alt="...">
	      <div class="carousel-caption d-none d-md-block">
	        <h3>Third slide label</h3>
	        <p class="p-carousel">Some representative placeholder content for the third slide.</p>
	      </div>
	    </div>
	    <div class="carousel-item">
	      <img src="layout/images/beauty.jpg" class="d-block w-100" alt="...">
	      <div class="carousel-caption d-none d-md-block">
	        <h3>fourth slide label</h3>
	        <p class="p-carousel">Some representative placeholder content for the third slide.</p>
	      </div>
	    </div>
	    <div class="carousel-item">
	      <img src="layout/images/sofa.png" class="d-block w-100" alt="...">
	      <div class="carousel-caption d-none d-md-block">
	        <h3>fifth slide label</h3>
	        <p class="p-carousel">Some representative placeholder content for the third slide.</p>
	      </div>
	    </div>
	    <div class="carousel-item">
	      <img src="layout/images/clothes.png" class="d-block w-100" alt="...">
	      <div class="carousel-caption d-none d-md-block">
	        <h3>sixth slide label</h3>
	        <p class="p-carousel">Some representative placeholder content for the third slide.</p>
	      </div>
	    </div>
	  </div>
	  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
	    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	    <span class="visually-hidden">Previous</span>
	  </button>
	  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
	    <span class="carousel-control-next-icon" aria-hidden="true"></span>
	    <span class="visually-hidden">Next</span>
	  </button>
	</div>
</div>-->




<!--     FROM DATABASE -->
<div>
	

</div><?php
	//counter eye to count page visits
	include 'counter.php';
	echo '<span class="eye-counter" id="'.$_SESSION['counterService'].'"></span>'; 
	?>
  <!--ajax coner -->
   <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
   <script>
   $(document).ready(function(){
	   //ajax call send page views
	  var eye=$('.eye-counter').attr('id');
	  $.ajax({
	  url:"counterInsert.php",
	  data:{service:eye}
	     });
	    //ajax call send item views
	   $('.titleLink').click(function(){
	  var item=$(this).nextAll('.idValue').val();
	  $.ajax({
	  url:"process2.php",
	  data:{itemView:item}
	     });
	   });
	    //ajax add to favourite  => from users
     $(".fav_E").on("click", function(){
      var item=$(this).nextAll('.item').val();
      var user=$(this).nextAll('.user').val();
      var cat=$(this).nextAll('.cat').val();
      var sub=$(this).nextAll('.sub').val();
      var state=$(this).nextAll('.state').val();
      var city=$(this).nextAll('.city').val();
      $.ajax({
      url:"process3.php",
      data:{item_E:item,user_E:user,cat_E:cat,sub_E:sub,st_E:state,ci_E:city}
       });
     });
     //ajax add to favourite_tr => from traders
     $(".fav_T").on("click", function(){
      var item=$(this).nextAll('.item').val();
      var trader=$(this).nextAll('.trader').val();
      var cat=$(this).nextAll('.cat').val();
      var sub=$(this).nextAll('.sub').val();
      var state=$(this).nextAll('.state').val();
      var city=$(this).nextAll('.city').val();
      $.ajax({
      url:"process3.php",
      data:{item_T:item,user_T:trader,cat:cat,sub:sub,st:state,ci:city}
       });
     });
    //



     });
   </script>
<!--&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&-->











<!--<div class="index-below carousel-con">
	<div class="inner"> -->
		<!--------------------  CAROUSEL --------------------->
		<!--<h1 class="cats-container-p centered">قالوا عن مستفيد </h1>
		<?php


		?>
		
		<div class="cats-container">
			<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
			  <div class="carousel-indicators">
			    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
			    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
			    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
			    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
			    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
			    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="5" aria-label="Slide 6"></button>
			  </div>
			  <div class="carousel-inner">
			  	<?php 
			  	$stmt=$conn->prepare("SELECT max(review_id) FROM review WHERE approve = 1 ");
			    $stmt->execute();$maxRev=$stmt->fetch(); 
			    
			  	 
			  	 /* $rev=fetch('*','review','review_id',$maxRev[0]);
			  	 $counter=$rev['review_id']-1;
			  	  $rev2=fetch('*','review','review_id',$counter);
			  	 $counter2=$rev2['review_id']-1;
			  	  $rev3=fetch('*','review','review_id',$counter2);
			  	 $counter3=$rev3['review_id']-1;
			  	  $rev4=fetch('*','review','review_id',$counter3);
			   	$counter4=$rev4['review_id']-1;
			  	  $rev5=fetch('*','review','review_id',$counter4);
			  	 $counter5=$rev5['review_id']-1;
			  	  $rev6=fetch('*','review','review_id',$counter5);*/
			  	 ?>
			  
			    <div class="carousel-item active">
			       <p class="d-block  centered"> <?php echo $rev['review_text']; ?></p>  
			      <div class="carousel-caption d-none d-md-block">
			        <h4><?php echo $rev['name']; ?> </h4>
			      </div>
			    </div>
			    <div class="carousel-item">
			       <p class="d-block centered "> <?php  echo $rev2['review_text']; ?></p>  
			      <div class="carousel-caption d-none d-md-block">
			        <h4><?php echo $rev2['name']; ?> </h4>
			      </div>
			    </div>
			    <div class="carousel-item">
			       <p class="d-block centered "> <?php echo $rev3['review_text'];  ?></p>  
			      <div class="carousel-caption d-none d-md-block">
			        <h4><?php echo $rev3['name'];?> </h4>
			      </div>
			    </div>
			    <div class="carousel-item">
			       <p class="d-block centered"> <?php echo $rev4['review_text']; ?></p>  
			      <div class="carousel-caption d-none d-md-block">
			        <h4><?php  echo $rev4['name'];?> </h4>
			      </div>
			    </div>
			    <div class="carousel-item">
			       <p class="d-block centered "> <?php echo $rev5['review_text']; ?></p>  
			      <div class="carousel-caption d-none d-md-block">
			        <h4><?php echo $rev5['name']; ?> </h4>
			      </div>
			    </div>
			    <div class="carousel-item">
			       <p class="d-block centered"> <?php echo $rev6['review_text']; ?></p>  
			      <div class="carousel-caption d-none d-md-block">
			        <h4><?php echo $rev6['name']; ?> </h4>
			      </div>
			    </div>
			  </div>
			  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
			    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
			    <span class="visually-hidden">Previous</span>
			  </button>
			  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
			    <span class="carousel-control-next-icon" aria-hidden="true"></span>
			    <span class="visually-hidden">Next</span>
			  </button>
			</div>
		</div>


	</div>
</div>-->





<!--     FROM DATABASE -->
<?php
	//counter eye to count page visits
	include 'counter.php';
	echo '<span class="eye-counter" id="'.$_SESSION['counterIndex'].'"></span>'; 
	?>
  <!--ajax coner -->
   <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
   <script>
   $(document).ready(function(){
	   //ajax call send page views
	  var eye=$('.eye-counter').attr('id');
	  $.ajax({
	  url:"counterInsert.php",
	  data:{index:eye}
	     });
	   //



     });
   </script>
   <?php



 
 include  $tmpl ."footer.inc";
 include 'foot.php';
 ob_end_flush();
 