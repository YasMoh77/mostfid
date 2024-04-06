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
		<a href="general.php" class="centered white">دخول </a>
	</div>

	<div class="div-ul-main second">
		<div class="div-first centered"><span>خدمات   </span></div>
		<a href="service.php" class="centered white">دخول </a>
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





<div class="index-below carousel-con">
	<div class="inner"> 
		<!--------------------  CAROUSEL --------------------->
		<h1 class="cats-container-p centered">قالوا عن مستفيد </h1>
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
			    
			  	 
			  	  $rev=fetch('*','review','review_id',$maxRev[0]);
			  	 $counter=$rev['review_id']-1;
			  	  $rev2=fetch('*','review','review_id',$counter);
			  	 $counter2=$rev2['review_id']-1;
			  	  $rev3=fetch('*','review','review_id',$counter2);
			  	 $counter3=$rev3['review_id']-1;
			  	  $rev4=fetch('*','review','review_id',$counter3);
			   	$counter4=$rev4['review_id']-1;
			  	  $rev5=fetch('*','review','review_id',$counter4);
			  	 $counter5=$rev5['review_id']-1;
			  	  $rev6=fetch('*','review','review_id',$counter5);
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
</div>





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
 