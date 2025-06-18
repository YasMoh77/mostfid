<?php
ob_start();
session_start();
date_default_timezone_set('Africa/Cairo');
$title='مستفيد | تفاصيل الاعلان';  //title of the
$keywords='<meta name="keywords" content=  "  منصة مستفيد   ,  تعليقات المشترين , تقييم المنتج  ,  الوصف   ,   تفاصيل الاعلان,  mostfid  ,  big sale  " >';
$description='<meta name="description" content="يوفر مستفيد منتجات وخدمات يعرضها اصحابها بأسعار مخفضة.جميع المنتجات والخدمات المعروضة عليها خصم حقيقي. استمتع مع مستفيد بخصم على منتجات وخدمات انت في حاجة اليها   ">';
$canonical='<link rel="canonical" href="https://www.mostfid.com/search.php?cat=0&s=p&state=0&ordering=1" >'; 

include 'init.php';
  

if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google 
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

   //check $_GET request and store it 
   if(isset($_GET['id']) && is_numeric($_GET['id'])&&$_GET['id']>0 /*&&isset($_GET['main']) && ($_GET['main']=='g' || $_GET['main']=='v' || $_GET['main']=='p' || $_GET['main']=='admin' || $_GET['main']=='self') && isset($_GET['t'])&&($_GET['t']=='s' || $_GET['t']=='i' || $_GET['t']=='p' || $_GET['t']=='admin' */ ) {
   	 $ITEMID=intval($_GET['id']);
   	 if(isset($session)){ banned($session); }//if banned or not verified email
     //Bring data from database
	 $ITEMS=items('items.item_id',$ITEMID);  //$ITEMS[0]=fetchAll, $ITEMS[1]=rowcount
		     
		   if ($ITEMS[1]>0){ 
		   	foreach ($ITEMS[0] as $item) {	
	   		 $ratio=$item['price']*($item['discount']/100); 
             $finalPrice1=round($item['price']-$ratio);
             $finalPrice=number_format($finalPrice1);
		   	 
		  /*if (isset($_GET['t'])&&$_GET['t']=='s' ) { // coming from search.php or search-v.php ?>
          <div class="above-details-main">
            <?php if(isset($_GET['main'])&&$_GET['main']=='g' ){ 
            	?><a class="main-link" href="general.php">الرئيسية </a> > 
            	<a class="main-link" href="search.php?cat=<?php echo $item['cat_id'] ?>&state=0&ordering=0">بحث </a> >
            	<?php 
            }elseif(isset($_GET['main'])&&$_GET['main']=='v'){ 
            	?><a class="main-link" href="service.php">الرئيسية </a> > 
            	<a class="main-link" href="search-v.php?k=<?php echo $item['cat_id'] ?>">بحث </a> >
            <?php 
            }else{ header('location:logout.php?s=no'); exit(); } ?>
            
            <span>تفاصيل الاعلان  </span>

          </div> 

        <?php }elseif(isset($_GET['t'])&&$_GET['t']=='i'){  // coming from general.php or service.php ?>
          <div class="above-details-main">
            <?php if(isset($_GET['main'])&&$_GET['main']=='g' ){ ?><a class="main-link" href="general.php">الرئيسية </a> > <?php }
            elseif(isset($_GET['main'])&&$_GET['main']=='v'){ ?><a class="main-link" href="service.php">الرئيسية </a> > <?php } 
             else{ header('location:logout.php?s=no'); exit(); } ?>
            <span>تفاصيل الاعلان  </span>
          </div> 
        <?php }elseif (isset($_GET['t'])&&$_GET['t']=='p'){  // coming from profile.php  ?>
        	 <div class="above-details-main">
            <?php if(isset($_GET['main'])&&$_GET['main']=='p' ){ ?><a class="main-link" href="profile.php?i=<?php echo $session;?>&p=data">حسابي  </a> > <?php }
             else{ header('location:logout.php?s=no'); exit(); } ?>
            <span>تفاصيل الاعلان  </span>
          </div> 

       <?php }elseif (isset($_GET['t'])&&$_GET['t']=='admin'){  // coming from c-panel  ?>
       	  <div class="above-details-main">
            <?php if(isset($_GET['main'])&&$_GET['main']=='admin' ){ ?><a class="main-link" href="admin/items.php">لوحة التحكم  </a> > <?php }
             else{ header('location:logout.php?s=no'); exit(); } ?>
            <span>تفاصيل الاعلان  </span>
          </div> 

      <?php }elseif (isset($_GET['t'])&&$_GET['t']=='f'){

             }else{ 
                 header('location:logout.php?s=no');
                 exit();
                } */?> 
            <div class="above-details-main">
            	<span>تفاصيل الاعلان  </span>
            </div>
		   	 <!-- get url to decide ts or ti -->
		   	 <?php  
		   	 $url= $_SERVER['REQUEST_URI']; /*get url*/
	   		 $pr=preg_match('/t=s&main=g/', $url);$pr2=preg_match('/t=s&main=v/', $url); //use for details pathinfo
	   		 $pr3=preg_match('/t=i&main=g/', $url);$pr4=preg_match('/t=i&main=v/', $url);
	   		 $pr5=preg_match('/t=p&main=p/', $url);$pr6=preg_match('/t=admin&main=admin/', $url);
	   		 ?>
		   	 <div class="details-main">
		   	 	<div class="details-main-son dt-right">
		   	 		<div class="pic-discount-div">خصم <?php echo $item['discount'].'%' ?></div>
		   	 		<?php
		   	 		if (!isset($_GET['source'])) {
		   	 		
			        if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$item['user_id']) { 
			        	  $fetchFav=fetch2('favourite_status','favourite','item_id',$item['item_id'],'user_id',$_SESSION['traderid']);
				        	
				        	if($fetchFav['favourite_status']==1){ 
				        	   ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_T purple"></i><?php 
				        	}else{ 
				        		?><i title="حفظ "  class="fas fa-heart fav fav_T grey"></i><?php
				        	 } ?>
				        	<input type="hidden" class="item" value="<?php echo $item['item_id'];?>">
			                <input type="hidden" class="trader" value="<?php echo $_SESSION['traderid'];?>">
			                <input type="hidden" class="cat" value="<?php echo $item['cat_id'];?>">
				        	<input type="hidden" class="sub" value="<?php echo $item['subcat_id'];?>">
				        	<input type="hidden" class="state" value="<?php echo $item['state_id'];?>">
				        	<input type="hidden" class="city" value="<?php echo $item['city_id'];?>">
                         <?php
			        }elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$item['user_id']) {
			        	 ?><a><i class="fas fa-heart grey2"></i></a>  <?php
			        
			        }elseif (isset($_SESSION['userEid']) || isset($_SESSION['userGid']) ||isset($_SESSION['userFid'])) {
			        	$session1=isset($_SESSION['userEid'])?$_SESSION['userEid']:$_SESSION['userGid']; 
			        	$session=isset($_SESSION['userFid'])?$_SESSION['userFid']:$session1; 
			        	$fetchEid=fetch2('favourite_status','favourite','item_id',$item['item_id'],'user_id',$session);
			            if($fetchEid==1){ ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
				        	}else{ 
				        	 ?><i title="حفظ" class="fas fa-heart fav fav_E grey"></i><?php
				        	 } ?> 
				        	<input type="hidden" class="item" value="<?php echo $item['item_id'];?>">
			                <input type="hidden" class="user" value="<?php echo $session;?>">
			                <input type="hidden" class="cat" value="<?php echo $item['cat_id'];?>">
				        	<input type="hidden" class="sub" value="<?php echo $item['subcat_id'];?>">
				        	<input type="hidden" class="state" value="<?php echo $item['state_id'];?>">
				        	<input type="hidden" class="city" value="<?php echo $item['city_id'];?>">
			        
			        <?php }else{ ?><a href="login.php"><i class="fas fa-heart grey2"></i></a>  <?php } }else{ echo "cpPreview";} ?> 
		   	 	    <!--////////////////////////-->
		   	 	    <div id="carousel-dt" class="carousel slide">
						  <div class="carousel-indicators carousel-indicators-dt ">
						    <span type="button" data-bs-target="#carousel-dt" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"><img src="data\upload\<?php echo $item['photo'] ?>" alt=''></span>
						    <?php if ($item['photo2']>0) { ?> <span type="button" data-bs-target="#carousel-dt" data-bs-slide-to="1" aria-label="Slide 2"><img src="data\upload\<?php echo $item['photo2'] ?>" class="d-block w-100" alt="..."></span> <?php  } ?>
						    <?php if ($item['photo3']>0) { ?> <span type="button" data-bs-target="#carousel-dt" data-bs-slide-to="2" aria-label="Slide 3"><img src="data\upload\<?php echo $item['photo3'] ?>" class="d-block w-100" alt="..."></span> <?php  } ?>
						  </div>
						  <div class="carousel-inner carousel-inner-dt">
						    <div class="carousel-item active">
						      <img src="data\upload\<?php echo $item['photo'] ?>" class="d-block w-100" alt="...">
						    </div>
						    <div class="carousel-item">
						      <?php if (isset($item['photo2'] )) { ?> <img src="data\upload\<?php echo $item['photo2'] ?>" class="d-block w-100" alt="..."><?php  } ?>
						    </div>
						    <div class="carousel-item">
						      <?php if (isset($item['photo3'] )) { ?> <img src="data\upload\<?php echo $item['photo3'] ?>" class="d-block w-100" alt="..."><?php  } ?>
						    </div>
						  </div>
						  <button class="carousel-control-prev" type="button" data-bs-target="#carousel-dt" data-bs-slide="prev">
						    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
						    <span class="visually-hidden">Previous</span>
						  </button>
						  <button class="carousel-control-next" type="button" data-bs-target="#carousel-dt" data-bs-slide="next">
						    <span class="carousel-control-next-icon" aria-hidden="true"></span>
						    <span class="visually-hidden">Next</span>
						  </button>
					</div>



		   	 	   <!--//////////////////////////////-->
		   	 		<!--<img src="data\upload\<?php //echo $item['photo'] ?>" alt="<?php //echo $item['title'] ?>">-->
		   	 	</div>
		   	 	<div class="details-main-son dt-left">
		   	 		<p><?php echo $item['cat_nameAR'].' > '.$item['subcat_nameAR'] ?></p>
		   	 		<span class="p-title font1 cut2 alone"><?php echo $item['title'] ?></span>
		   	 		<p class="date"><i class="fas fa-calendar"></i><?php echo ' '.$item['item_date'].' '; if($item['sit']==1){ echo "المعلن هو المالك  ";}elseif($item['sit']==2){ echo "السعر شامل أجر الوسيط  ";} ?></p>
		   	 		
		   	 		<p class="alone small"><?php echo $item['country_nameAR'].' - '.$item['state_nameAR'].' - '.$item['city_nameAR'];?></p>
		   	 		<p class="finalPrice finalPriceD">
 						<s><?php echo number_format($item['price']);?></s>
 						<span>ج.م.</span>
 						<span class=" span2">
 							<span class="bold"><?php echo $finalPrice ?></span>
 						    <span>ج.م.</span>
 						</span>
	 				</p>

	 					<?php
	 					if ($item['delivery']<9) { ?><div class="cont-delivery"> <?php
		 					if ($item['delivery']==1) { ?><span class="delivery-details"><span><i title="توصيل " class="fas fa-truck"></i>مدفوع داخل محافظة  <?php echo $item['state_nameAR'] ?></span> <?php }
		 					if ($item['delivery']==2) { ?><span class="delivery-details"><span><i title="توصيل " class="fas fa-truck"></i>مجاني داخل محافظة  <?php echo $item['state_nameAR'] ?> <?php }
		 					if ($item['delivery']==3) { ?><span class="delivery-details"><span><i title="توصيل " class="fas fa-truck"></i>مدفوع داخل  <?php echo $item['city_nameAR'] ?></span> <?php }
		 					if ($item['delivery']==4) { ?><span class="delivery-details"><span><i title="توصيل " class="fas fa-truck"></i> مجاني داخل  <?php echo $item['city_nameAR'] ?></span> <?php }
		 					if ($item['delivery']==5) { ?><span class="delivery-details"><span><i title="توصيل " class="fas fa-truck"></i> مجاني  <?php echo $item['city_nameAR']?> مدفوع  <?php echo $item['state_nameAR'] ?> </span> <?php }
		 					if ($item['delivery']==6) { ?><span class="delivery-details"><span><i title="توصيل " class="fas fa-truck"></i> مجاني  <?php echo $item['city_nameAR']?> مدفوع لكل  المحافظات  </span> <?php }
		 					if ($item['delivery']==7) { ?><span class="delivery-details"><span><i title="توصيل " class="fas fa-truck"></i>مدفوع لكل المحافظات  </span> <?php }
		 					if ($item['delivery']==8) { ?><span class="delivery-details"><span><i title="توصيل " class="fas fa-truck"></i>مجاني لكل  المحافظات  </span> <?php }
		 				   ?></div> <?php
		 				}
		 					?>
		 				
		 					<?php   //check if item owner & if blocked
		 					if (isset($session)) { $fetchB=fetch2('block','user','user_id',$session,'block',1); }
		 					if (!isset($_GET['source'])) { //if there's preview from cpanel
		 					if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$item['user_id'] ) { //appears as a link for users
                                ?><div class="flex j-c-s-b above-sm" > <input class="b-none radius-sm" id="q" class="radius-sm" type="number" name="q" min="1" max="10"><a id="link" data-bs-toggle="offcanvas" data-bs-target="#cart" aria-controls="staticBackdrop" class="widest" title="تقديم طلب شراء " ><i class="fas fa-phone"></i></a></div> <?php
		 					}elseif (isset($_SESSION['userEid']) ||isset($_SESSION['userGid']) ||isset($_SESSION['userFid']) ) {
		 						?><div class="flex j-c-s-b above-sm" > <input class="b-none radius-sm" id="q" class="radius-sm" type="number" name="q" min="1" max="10"><a id="link" data-bs-toggle="offcanvas" data-bs-target="#cart" aria-controls="staticBackdrop" class="widest" title="تقديم طلب شراء " ><i class="fas fa-phone"></i></a></div> <?php
		 					}elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$item['user_id']) {
		 						?> <a class="widest widest-login"><i class="fas fa-phone"></i></a> <?php
		 					}else{  
		 					 	?> <a class="widest widest-login" href="login.php"><i class="fas fa-phone"></i></a> <?php
		 					} }else{ echo $lang['cpPreview'];} //END if cpanel preview ?>
		   	 	</div>
		   	 	     <!-- start offcanvas cart -->
                     <div class="offcanvas radius-sm" data-bs-backdrop="static" tabindex="-1" id="cart" aria-labelledby="staticBackdropLabel"> 
		                  <div class="offcanvas-header offcanvas-header-report">
		                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button> 
		                        <span class=" msg-to cut2"><?php echo $item['title'];?></span>
		                  </div>
		                  <div class=""> 
	                        <span class="report-reason showQnty right"></span>

			   	    	  	<form  action="cart.php" method="POST">
			   	    	  		<input  type="hidden" id="qForm" name="q">
			   	    	  		<input  type="hidden" id="qSess" value="<?php if(isset($_SESSION['cart'][$item['item_id']])){ echo $_SESSION['cart'][$item['item_id']]['q'];}?>" name="qSess">
			   	    	  		<input type="hidden" name="id" value="<?php echo $item['item_id']?>">
				   	    	  	<button type="submit" class="btn-canvas-msg btnCart radius-sm"><?php echo 'الذهاب الى السلة ';?></button>
			   	    	  	</form> 
	                      </div>
	                 </div>
                   <!-- end offcanvas cart -->
		   	 </div>
		   	 <?php
		   	 if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
		  	 elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
			 elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
             elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

             if (isset($session) && $session!=$item['user_id'] ) { 
             	$fetchReportVal=fetch2('value','report','item_id',$item['item_id'],'user_id',$session);
                 ?>
                     <!-- start offcanvas to report item -->
                     <div class="offcanvas" data-bs-scroll="true" tabindex="-1" id="canvasReport" aria-labelledby="offcanvasWithBothOptionsLabel"> 
		                  <div class="offcanvas-header offcanvas-header-report">
		                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		                        <span class=" msg-to cut2"><?php echo $lang['Report'].' : '.$item['title'];?></span>
		                  </div>
		                  <div class="offcanvas-body-report">
	                        <span class="report-reason"><?php echo $lang['reportReason']?></span>
			   	    	  	<form id="form-canvas-report" >
				   	    	  	<div><input type="radio" class="immoral" id="immoral" name="immoral" value="1"><label for='immoral'><?php echo $lang['immoral']?></label></div>
				   	    	  	<div><input type="radio" class="repeated" id="repeated" name="repeated" value="2"><label for='repeated'><?php echo $lang['repeated']?></label></div>
				   	    	  	<div><input type="radio" class="fraud" id="fraud" name="fraud" value="3"><label for='fraud'><?php echo $lang['fraud']?></label></div>
				   	    	  	<div><input type="radio" class="other" id="other" name="other" value="4"><label for='other'><?php echo $lang['other']?></label></div>
				   	    	  	<input type="hidden" name="user" value="<?php echo $session;?>"><!-- reporter -->
				   	    	  	<input type="hidden" name="item" value="<?php echo $item['item_id'];?>"><!-- item_id -->
				   	    	  	<input type="text" class="input-report report-dt" name="txtReport" placeholder="<?php echo $lang['reportReason']?>" autocomplete="off">
                                 <?php // t=s or t=i
                                 if($fetchReportVal==null){  ?><input type="hidden" name="reportVal" value="0"><!-- report value --> <?php }
                                  else{ ?><input type="hidden" name="reportVal" value="1"> <?php }
                                 ?>
				   	    	  	<button type="submit" class="btn-canvas-msg   btn-canvas-report"><?php echo $lang['send']?></button>
				   	    	  	<span class="show-return-report"></span>
			   	    	  	</form>
	                      </div>
	                 </div><?php
                  // <!-- end offcanvas to report item--> 

                 if (!isset($_GET['source'])) { if($fetchReportVal==null){ ?><a  class="report-detail" data-bs-toggle="offcanvas" data-bs-target="#canvasReport" aria-controls="canvasReport">بلغ عن هذا الاعلان  </a> <?php } }else{ echo "cpPreview";}
                 	
                 
              
			?>

            <!--ajax coner --> 
	         <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
	         <script>
		       $(document).ready(function(){
		       	//ajax send canvas report
		          $("#form-canvas-report").on("submit", function(event){
		           event.preventDefault();
		          $.ajax({
		          type:'POST',
		          url:"reportItem.php",
		          beforeSend:function(){
		           $('<span class="spinner-border spinner-canvas-report" role="status" aria-hidden="true"></span>').insertAfter($('.btn-canvas-report'));
		           $('.btn-canvas-report').addClass('disabled',true);
		          },
		          data: new FormData(this),
		          processData:false,
		          contentType:false,
		          success: function(data){                            
		             $('.show-return-report').html(data);
		             },
		         complete: function(){
		             $('.btn-canvas-report').removeClass('disabled',true);
		             $('.spinner-border').remove();
		             $('.input-report').val(' ');
		             }
		           });
		         });
		          //send quantity to cart
		          $('#link').click(function(){
		          	var sessQnty=$('#qSess').val();
		          	var q=$('#q').val();
		          	var formQnty=$('#qForm').val($('#q').val());
		          	var tot=Number(sessQnty)+ Number(q);
		          	console.log(tot);
		          	if (sessQnty>=10||tot >10) {
		          		$('.btnCart').hide();
		          		$('.showQnty').html('لا يمكن اضافة اكثر من 10 طلبات ');
		          	}else{
		          		$('.btnCart').show();
		          		$('.showQnty').html('تمت الاضافة الى سلة المشتريات  ');
		          	}
		          	
		          });


		          });
		      </script>

            <?php  }//END  if (isset($session) -> for canvas report ?>
             
              <?php
              /* copy page link */             
               $url='https://www.mostfid.com'.$_SERVER['REQUEST_URI'];
               ?>
                <div class="div-copy">
                	 <button class="btn-copy">انسخ رابط الصفحة  </button><span class="spanCopy"></span>
                	<input type="text" class="inputCopy cut2" value="<?php echo $url; ?>">
                   
				</div>
              
		   	 <hr class="middle-hr"> 

		   	 <div class="details-main2">
		   	 	<section class="one">
			   	    <div> 
			   	 		<div class="desc color">الوصف</div>
			   	 	</div>
			   	 <!--/////////// desc //////////////-->
			   	 <div class="description"><?php echo $item['description'] ?></div>
                <hr class="middle-hr">


		   	 	<!--////////// rating ///////////////-->
               <?php
               // (RATE US) IF THERE IS A SESSION
                if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
				elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
				elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
                elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

                 if(!isset($_GET['source'])){
                if (isset($session) ) { //IF THERE IS A SESSION
                ?><div class="rate color">تقييمات  المشترين</div>
                <div class='gallery-small-rateUs you-rate rating'>
		               	<!-- GENERAL RATING -->
		               	<div class='gallery-small'> 
	                          <?php
	                          $stmt=$conn->prepare(" SELECT sum(VOTE)  from vote where item_id=?");
	                          $stmt->execute(array($item['item_id']));
	                          $sum=$stmt->fetchColumn();
	                     
	                          $stmt=$conn->prepare(" SELECT count(VOTE)  from vote where item_id=?");
	                          $stmt->execute(array($item['item_id']));
	                          $count=$stmt->fetchColumn();
	                          

	                          $rate=$count>0?round($sum/$count):0; 
	                          ?><div id="star-basedOn-container">
		                           <div class='div-star-rating1'>
		                           	     <!--<span class=' dt-label' ><?php echo $lang['signRating']?></span>-->
			                           <div class="fa-stars-container">
			                              <?php
				                          if($rate==1){ ?> <i class='fa fa-star orange'></i> <i class='fa fa-star'></i> <i class='fa fa-star'></i> <i class='fa fa-star'></i> <i class='fa fa-star'></i>  <?php  }
				                          elseif($rate==2){ ?> </i><i class='fa fa-star orange'></i> <i class='fa fa-star orange'></i> <i class='fa fa-star'></i> <i class='fa fa-star'></i> <i class='fa fa-star'></i> <?php }
				                          elseif($rate==3){ ?> <i class='fa fa-star orange'></i> <i class='fa fa-star orange'></i> <i class='fa fa-star orange'></i> <i class='fa fa-star'></i> <i class='fa fa-star'></i> <?php }
				                          elseif($rate==4){ ?> <i class='fa fa-star orange'></i> <i class='fa fa-star orange'></i> <i class='fa fa-star orange'></i> <i class='fa fa-star orange'></i> <i class='fa fa-star'></i> <?php }
				                          elseif($rate==5){ ?> <i class='fa fa-star orange'></i> <i class='fa fa-star orange'></i> <i class='fa fa-star orange'></i> <i class='fa fa-star orange'></i> <i class='fa fa-star orange'></i> <?php }
				                          else{ ?> <i class='fa fa-star'></i> <i class='fa fa-star'></i> <i class='fa fa-star'></i> <i class='fa fa-star'></i> <i class='fa fa-star'></i> <?php }
		                                 ?>
		                              </div>
		                           </div> <?php //END div-star-rating
			                         if($count>0){ ?> <div id="con" class="container-div-star-rating2"> <p class='div-star-rating2'><?php echo '('.$rate.' '.$lang['stars'].')'.'&ensp;&ensp;'.'('.$count.' '.$lang['votes'].')'; ?></p> </div> <?php }
			                         else{ ?><div id="con" class="container-div-star-rating3"> <p class='div-star-rating2'><?php echo  "(".$count.' '.$lang['votes'].")"; ?></p> </div> <?php } ?>
	                          </div><!--END star-basedOn-container-->
	                          <div class="star-block">
	                          	<?php
	                            $five=countFromDb3('VOTE','vote','VOTE',5,'item_id',$item['item_id']);$four=countFromDb3('VOTE','vote','VOTE',4,'item_id',$item['item_id']);
	                            $three=countFromDb3('VOTE','vote','VOTE',3,'item_id',$item['item_id']);$two=countFromDb3('VOTE','vote','VOTE',2,'item_id',$item['item_id']);$one=countFromDb3('VOTE','vote','VOTE',1,'item_id',$item['item_id']);

	                          	?>
                             	<div><i class="fa fa-star orange"></i><i class="fa fa-star orange"></i><i class="fa fa-star orange"></i><i class="fa fa-star orange"></i><i class="fa fa-star orange"></i>&nbsp;<?php echo '('.$five.')'?></div>
                             	<div><i class="fa fa-star orange"></i><i class="fa fa-star orange"></i><i class="fa fa-star orange"></i><i class="fa fa-star orange"></i><i class="fa fa-star"></i>&nbsp;<?php echo '('.$four.')'?></div>
                             	<div><i class="fa fa-star orange"></i><i class="fa fa-star orange"></i><i class="fa fa-star orange"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>&nbsp;<?php echo '('.$three.')'?></div>
                             	<div><i class="fa fa-star orange"></i><i class="fa fa-star orange"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>&nbsp;<?php echo '('.$two.')'?></div>
                             	<div><i class="fa fa-star orange"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>&nbsp;<?php echo '('.$one.')'?></div>
                             </div>
			            </div><!--END gallery-small-->
			            



                        <!-- USER RATING --> 
                        <?php
		                $fetchOrder=fetch2('*','orders','user_id',$session,'item_id',$item['item_id']);
		                $checkBuyer=checkItem4('user_id','orders',$session,'item_id',$item['item_id'],'approve',1);
                        if (isset($session)&&$checkBuyer>0 ) { //IF THERE IS A SESSION
                        ?>
                        <div class='div-star-rating'> 
                         <span class='dt-label' ><?php echo $lang['rateThis']?></span>
                                 <?PHP
                                 $stmt=$conn->prepare(" SELECT VOTE from vote 
                                 	WHERE user_id=? and item_id=?");
                                 $stmt->execute(array($session, $item['item_id']) );
                                 $countVote=$stmt->fetch();
                                 $star=$countVote['VOTE']; 
                                  if($star>=0){ ?>
                                  <input type="hidden" id="hint" value="<?php echo $star; ?>">
                                  <!--FONTAWESOME STARS-->
                                  <div class="star-reslt-container">
	                                  <div class="fa-stars-container">
	                                 	 <span class='fa fa-star rate1'><input type="hidden" name="one" value="1" id="one"></span>
	                                     <span class='fa fa-star rate2'><input type="hidden" name="two" value="2" id="two"> </span>
	                                     <span class='fa fa-star rate3'><input type="hidden" name="three" value="3" id="three"> </span>
	                                     <span class='fa fa-star rate4'><input type="hidden" name="four" value="4" id="four"> </span>
	                                     <span class='fa fa-star rate5'><input type="hidden" name="five" value="5" id="five"> </span>
	                                     <!-- HIDDEN DATA FOR AJAX -->
	                                     <input type="hidden"  id="sessionUser" value="<?php echo $session;?>">
	                                     <input type="hidden"  id="sessionUserID" value="<?php echo $session;?>">
	                                     <input type="hidden"  id="ITEMID" value="<?php echo $ITEMID;?>">
	                                  </div>
	                              
	                                  <?php if($star>0){ ?>
	                                  	  <div class="all-votes-container">
	                                            <span id="Your-vote" class="Your-vote">( <?php echo $lang['yourVote'].' '.$star; ?>  )</span> 
	                                     </div> 
                                   </div>
                                   <?php

                                  }else{  ?>
	                                 	<div class="all-votes-container"> 
	                                     	<span id="Your-vote" class="Your-vote2"> <?php echo '('.$lang['notVoted'].')';?> </span> 
	                                     </div>
                                  
                                <?php }  //END if($star>0)  
                                  } //END if($star>=0) 
                              }//END if (isset($session)&&$checkBuyer>0  ?>
                                  
                    </div><!--END gallery-small-rateUs--> 
                
               <!--================================================================-->
		       <!--ajax coner -->
		       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
		       <script>
			       $(document).ready(function(){
		           //ajax call sending votes  
		           //one
		           $(".rate1").on("click", function(){
		          var One=$('#one').val();
		          var User=$('#sessionUser').val();
		          var UserID=$('#sessionUserID').val();
		          var ITEMID=$('#ITEMID').val();
		          $.ajax({
		          url:"vote.php",
		          data:{one:One,user:User,userid:UserID,item:ITEMID},
		          success: function(data){                             
		            $('#Your-vote').html(data);
		             }
		           });
		         });
		           //two
		           $(".rate2").on("click", function(){
		          var Two=$('#two').val();
		          var User=$('#sessionUser').val();
		          var UserID=$('#sessionUserID').val();
		          var ITEMID=$('#ITEMID').val();
		          $.ajax({
		          url:"vote.php",
		          data:{two:Two,user:User,userid:UserID,item:ITEMID},
		          success: function(data){                             
		            $('#Your-vote').html(data);
		             }
		           });
		         });
		           //three
		           $(".rate3").on("click", function(){
		          var Three=$('#three').val();
		          var User=$('#sessionUser').val();
		          var UserID=$('#sessionUserID').val();
		          var ITEMID=$('#ITEMID').val();
		          $.ajax({
		          url:"vote.php",
		          data:{three:Three,user:User,userid:UserID,item:ITEMID},
		          success: function(data){                             
		            $('#Your-vote').html(data);
		             }
		           });
		         });
		           //four
		           $(".rate4").on("click", function(){
		          var Four=$('#four').val();
		          var User=$('#sessionUser').val();
		          var UserID=$('#sessionUserID').val();
		          var ITEMID=$('#ITEMID').val();
		          $.ajax({
		          url:"vote.php",
		          data:{four:Four,user:User,userid:UserID,item:ITEMID},
		          success: function(data){                             
		            $('#Your-vote').html(data);
		             }
		           });
		         });//five
		           $(".rate5").on("click", function(){
		          var Five=$('#five').val();
		          var User=$('#sessionUser').val();
		          var UserID=$('#sessionUserID').val();
		          var ITEMID=$('#ITEMID').val();
		          $.ajax({
		          url:"vote.php",
		          data:{five:Five,user:User,userid:UserID,item:ITEMID},
		          success: function(data){                             
		            $('#Your-vote').html(data);
		             }
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
    <!--================================================================-->						   	   
               <?php
             }else{ // (RATE US) IF THERE IS NO SESSION
               ?><div class='gallery-small rating'>
                    <div class='div-star-rating'> 
                       <div class="fa-stars-container container-no-session">
                             <div class="container-no-session-inner">
                                 <span class='fa fa-star orange rate1'><input type="hidden" name="one" value="1" id="one"></span>
                                 <span class='fa fa-star '><input type="hidden" name="two" value="0" id="two"> </span>
                                 <span class='fa fa-star '><input type="hidden" name="three" value="0" id="three"> </span>
                                 <span class='fa fa-star '><input type="hidden" name="four" value="0" id="four"> </span>
                                 <span class='fa fa-star '><input type="hidden" name="five" value="0" id="five"> </span>
                             </div>
                             <div id="login-to-vote"><span  class='span-add-comments'><?php echo $lang['toVote']?>&ensp;<a href='login.php'><?php echo $lang['doLogin']?></a> &ensp;<?php echo $lang['or']?>&ensp; <a href='signUpU.php'><?php echo $lang['signUp']?></a></span>
                             </div>
                       </div>
                    </div><!-- END div-star-rating-->
               </div> <?php } //END gallery-small?>
           <?php }else{echo 'cpPreview';}  //END $_GET['source'] ?>
              <!-- /////////////////////////////// -->




              <hr class="middle-hr"> 
              <!--/////////// comms //////////////-->
              <div class="comms color">تعليقات المشترين</div>
              <?php if(isset($fetchOrder['order_date'])&& $fetchOrder['order_date']>0 && $fetchOrder['approve']==1){ ?><span class="small">شراء موثق بتاريخ  <?php echo '&nbsp;'.date('Y-m-d',$fetchOrder['order_date']); ?></span> <?php } ?>
              <div class="comments"> <?php 
               
              	if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
				elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
				elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
                elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb
                
                if(!isset($_GET['source'])){ // if no preview from control panel 
                if (isset($session) ) { //IF THERE IS A SESSION
                	if ( $checkBuyer>0 ) { ?>
   			        
		   			<form  id="formComment" ><!--SHOW TEXTAREA & START FORM COMMENT-->
			   			 <div class='textarea-comment-container'><!--container of textarea-comments-->
				   			 <span class="dt-label"><?php echo $lang['AddComments']?></span> 
				   			 <input type="text" class='textarea-comment'   name='comment' placeholder="أكتب تعليقك" >
				   			 <input type='hidden' id="itemid"  name='itemid' value='<?php echo $item['item_id'] ?>'>
				   			 <input type='hidden' id="userid"  name='userid' value='<?php echo $session; ?>'>
				   			 <input type='hidden' id="lng" name="lng"  value='<?php echo $l; ?>'>
				   			 <?php
                              /*if($pr==1){ ?><input type="hidden" name="token" value="1"> <?php }elseif($pr2==1){ ?><input type="hidden" name="token" value="2"> <?php }
                              elseif($pr3==1){ ?><input type="hidden" name="token" value="3"> <?php }elseif($pr4==1){ ?><input type="hidden" name="token" value="4"> <?php }
                              elseif($pr5==1){ ?><input type="hidden" name="token" value="5"> <?php }elseif($pr6==1){ ?><input type="hidden" name="token" value="6"> <?php }*/
	                         ?>
				   			 <button type='submit' id='submitComment'><?php echo $lang['submit']?></button>
			   			     <span id="show-comm"></span>
			   			 </div><!--end of container of textarea-comments-->
		            </form><!--END FORM COMMENT-->
		            
                    <!--ajax coner -->
			       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
			       <script>
				       $(document).ready(function(){ 
			           //ajax call sending formComment to database  
			           $("#formComment").on("submit", function(e){
			          e.preventDefault();
			          var Text  =$('.textarea-comment').val();
			           if(Text.length>0){
			          $.ajax({
			          method:'POST',
			          url:"formComment.php",
			          beforeSend:function(){
			           $('#submitComment').prop('disabled',true); 
                       $('#submitComment').append('<span class="spinner-border spinner-border-comment" role="status" aria-hidden="true"> </span>');
			          },
			          processData:false,
			          contentType:false,
			          data:new FormData(this),
			          success:function(data){
			           	$('.show-comment').html(data);
			           },
			           complete:function(){
			           	$('#submitComment').prop('disabled',false);
                        $('.spinner-border').remove();
                        $('.textarea-comment').val(' ');
			           }
			           });
			           }//end if
			         });
			           //
			           


			           

			           });
			        </script>

                       <?php
                           }else{
                           	?><span class="small alone">اضافة تعليق متاحة فقط لمن  لهم تجربة شراء  </span> <?php
                           }
                          
		                 }else{
		   			echo "<div><span class='span-add-comments'>".$lang['toAddComment']."<a href='login.php'>&ensp;".$lang['doLogin']."</a>".'&ensp;'.$lang['or'].'&ensp;'."<a href='signUpU.php'>".$lang['signUp']."</a></span></div>";
		                 } //END if isset($session)
		             }else{
		                 	echo "cpPreview";
		                 } // END if !isset($GET['source']) 

                      //edit comments
			         //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&         
			          if (isset($session)) {
			          	if ($_SERVER['REQUEST_METHOD']=='POST') {
			          		  $text3=trim($_POST['newText']);
							  $text2=stripcslashes($text3);
							  $text1=htmlspecialchars($text2);
							  $text=htmlspecialchars($text1);// filter_var($text1,FILTER_SANITIZE_STRING);
							  $com     =$_POST['comEdit'];
							  $item_id =$_POST['item'];
							  $token   =isset($_POST['token']);
							  $stmt=$conn->prepare(" UPDATE  comments set c_text=? where c_id=? ");
							  $stmt->execute(array($text,$com));
							  if ($stmt) {
							  	 ?><script>location.href='details.php?id=<?php echo $item_id.'#show';?>& <?php //if($token==1){ echo 't=s&main=g#show';}elseif($token==2){ echo 't=s&main=v#show'; }elseif($token==3){ echo 't=i&main=g#show';}elseif($token==4){ echo 't=i&main=v#show';}elseif($token==5){ echo 't=p&main=p#show';}elseif($token==6){ echo 't=admin&main=admin#show';} ?></script> <?php 
							  	
							  }
			              }
			          }
			          //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
	                  /////// show comments /////////////// 
			          // users comments 
			         $userComments=countFromDb2('c_id','comments','item_id',$item['item_id']); 
				     //pagination data
				     $adsPerPage=10;
					 $NumberOfPages=ceil($userComments/$adsPerPage);
				     $pageNum= isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page']<=$NumberOfPages&& $_GET['page']>0 ? intval($_GET['page']) : 1;
				     $startFrom=($pageNum-1)* $adsPerPage; //

	               $stmt=$conn->prepare("SELECT items.*,user.*,comments.* FROM comments
			         JOIN user ON user.user_id=comments.user_id
			         JOIN items ON items.item_id=comments.item_id
			        WHERE items.item_id=? 
					ORDER BY comments.c_id DESC limit $startFrom, $adsPerPage ");
					$stmt->execute(array($item['item_id']));
					$fetched2=$stmt->fetchAll();
					$count2=$stmt->rowCount();

					if ($count2>0) { ?>
	              <div class="show-comment" id="show"> 
			   		<span class="span-no-comments "><?php echo $lang['byUsers']?></span>
			   		<?php 
			   		 ?> <span class="num-comments "> <?php
			   		echo '( '.$userComments.' '.$lang['comment'].' )'; 
			   		 ?> </span> <?php

			   		foreach ($fetched2 as  $com) { 
			   		
			   			?>
				   	<!--------///////////------------------->
				   	 <div class="container-comm" id="comment">
			   			 <div class="div-comm-1">
				   		     <div class="name-date-dots"> 
				   		    	<section>
				   		    		<span class='span-black-homepage-comment cut2'><?php echo $com['name']; ?></span>
					   			    <span class="comment-date"><?php echo $com['c_date'].'&emsp;&emsp; شراء موثق  '; ?></span>
				   		    	</section>
				   		    	<?php 
				   		    	if(!isset($_GET['source'])){
	                               if(isset($session)){ //comment owner can edit, others can report
					   		    	 if($com['user_id']==$session&&$com['item_id']==$item['item_id']){ ?> <i class="fas fa-ellipsis-h dot dotEdit"></i> <?php }else{ ?> <i class="fas fa-ellipsis-h dot dotReport"></i> <?php } }
				   		    	  }else{ echo "<span class='dot'>cpPrev</span>";} ?>
				   		    	 
			   			        <div class="dot-container edit-delete-container"> 
			   			        	<i class="fas fa-pen" title="<?php echo $lang['Edit'] ?>"></i>
			   			        	<a href="actcom.php?c=<?php echo $com['c_id']?>&i=<?php echo $com['item_id']?>&<?php if($pr==1){ echo 't=sg';}elseif($pr2==1){ echo 't=sv'; }elseif($pr3==1){ echo 't=ig';}elseif($pr4==1){ echo 't=iv';}elseif($pr5==1){ echo 't=p';}elseif($pr6==1){ echo 't=admin';} ?>"><i class="fas fa-trash confirmDelete" title="<?php echo $lang['del'] ?>"></i><input type="hidden" class="language" value="<?php echo $l;?>"></a>
			   			        </div>
			   			        <div class="dot-container report-container">
			   			        	<?php
			   			        	$fetchComVal=fetch2('value','reportcomm','value',1,'user_id',$session);
			   			        	if($fetchComVal['value']==1){ ?> <i class="fas fa-flag Rflag" title="<?php echo $lang['report'] ?>"></i><?php }
			   			        	else{ ?> <i class="far fa-flag Rflag" title="<?php echo $lang['report'] ?>"></i><?php }
			   			        	?>
			   			            <input type="hidden" class="comid" value="<?php echo $com['c_id']?>">
			   			            <input type="hidden" class="reporter" value="<?php echo $session?>">
			   			            <input type="hidden" class="comOwner" value="<?php echo $$com['user_id']?>">
			   			        </div>
			   			    </div>
			   			</div>
                        <div class="div-comm-2"><!--  -->
                        	
                        	<form id="inputEditText" class="formEditText" action="details.php?id=<?php echo $com['item_id'].'#show';?><?php //if($pr==1){ echo 't=s&main=g#show';}elseif($pr2==1){ echo 't=s&main=v#show'; }elseif($pr3==1){ echo 't=i&main=g#show';}elseif($pr4==1){ echo 't=i&main=v#show';}elseif($pr5==1){ echo 't=p&main=p#show';}elseif($pr6==1){ echo 't=admin&main=admin#show';} ?>" method='POST' >
	                            <input type="text" class="newText" name="newText" value="<?php echo $com['c_text']?>" autocomplete='off' >
                                <input type="hidden" class="comEdit" name="comEdit" value="<?php echo $com['c_id']?>">
                                <input type="hidden" class="comEdit" name="item" value="<?php echo $com['item_id']?>">
	                            <?php
                               /*   if($pr==1){ ?><input type="hidden" name="token" value="1"> <?php }elseif($pr2==1){ ?><input type="hidden" name="token" value="2"> <?php }
                                  elseif($pr3==1){ ?><input type="hidden" name="token" value="3"> <?php }elseif($pr4==1){ ?><input type="hidden" name="token" value="4"> <?php }
                                  elseif($pr5==1){ ?><input type="hidden" name="token" value="5"> <?php }elseif($pr6==1){ ?><input type="hidden" name="token" value="6"> <?php }*/
	                            ?>
	                            <button class="sendEdit"><?php echo $lang['update'] ?></button>
                            </form>
                            <button class="cancel">cancel</button>
                            <p class="p-comment-homepage" id="p-comment-homepage"><span dir="auto"><?php echo $com['c_text']?></span></p>
                            <input type="hidden" id="commNum" value="<?php echo $com['c_id']?>">
                        </div><!--comments on homepage-->
                  </div>
                  <!--ajax coner -->
			       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
			       <script>
			       $(document).ready(function(){
			         //ajax add to favourite_tr => from traders
			         $(".Rflag").on("click", function(){
			          var comId=$(this).nextAll('.comid').val();
			          var Reporter=$(this).nextAll('.reporter').val();
			          $.ajax({
			          url:"process2.php",
			          data:{comid:comId,reporter:Reporter}
			           });
			          }); 
			          


		             });
		          </script>

                <?php } //END foreach($fetched2 as $com)  
	         

	         //===================start pagination=========================	
			    $jumpForward=1;
			 	$jumpBackward=1; 

			if($NumberOfPages>1 ){ 	?>
			 <nav aria-label="Page navigation example" class="pagination-container">
				  <ul class="pagination pagination-md">
				 <?php if(($pageNum-$jumpBackward)>=1 ){  //previous
				 ?> <li class="page-item"><a class="page-link prev" href="?id=<?php echo $item['item_id']; ?>&page=<?php echo ($pageNum-$jumpBackward)?>"><?php echo $lang['prev'];?></a></li><?php
			      }else{
			      ?> <li class="page-item disabled"><a class="page-link"><?php echo $lang['prev'];?></a></li><?php
			      }
			      //$page=1; $page<= $NumberOfPages;  $page++
			  for ($page=max(1,$pageNum-2);$page<=min($pageNum+2,$NumberOfPages);$page++) {  //for loop
				if (isset($_GET['page'])&&$_GET['page']==$page ) {
					echo   '<li class="page-item"><a class="page-link active" href="details.php?id='.$item['item_id'].'&page='.$page.'">'.$page.'</a></li>';
				}elseif (!isset($_GET['page'])&&$page==1 ) {
				   echo   '<li class="page-item"><a class="page-link active" href="details.php?id='.$item['item_id'].'&page='.$page.'">'.$page.'</a></li>';
				}else{
					echo   '<li class="page-item"><a class="page-link" href="details.php?id='.$item['item_id'].'&page='.$page.'">'.$page.'</a></li>';
				} }
			    if(($pageNum+$jumpForward)<=$NumberOfPages){  //next
				?> <li class="page-item"> <a class="page-link next"  href="?id=<?php echo $item['item_id']; ?>&page=<?php echo ($pageNum+$jumpForward)?>"><?php echo $lang['next'];?></a> </li><?php
			}else{
			   ?> <li class="page-item disabled"> <a class="page-link "><?php echo $lang['last'];?></a> </li><?php
			} ?>  
			    </ul > 
			</nav>
			<?php
			}
			////////////// END pagination //////////////
			?></div> <?php
	        }else{ //END if ($count2>0)
	        ?>
	        <div class="show-comment" id="show">
	           <span class="alone">لاتوجد تعليقات</span> 
	        </div>
	        <?php 
	        } 
     


              ?>           
              </div>

              <!--/////////////////////////-->
              </section>
              

		   	  <section class="two">
		   	 	<div class="ad"><p class="centered">أضف اعلانك</p></div>

		   	  </section>
		   	 </div>
		   	 
			 <?php } //END foreach ($ITEMS[0] as $item)


			}else{ //END  if ($ITEMS[1]>0)
				echo "<div class='height'><div class='block2-search'>عفوا؛ لم نعثر على هذا المنتج  </div></div>";
			}

            //counter eye to count page visits
			include 'counter.php';
			echo '<span class="eye-counter" id="'.$_SESSION['counterDetails'].'"></span>'; 

            $url= $_SERVER['REQUEST_URI']; //get url 
            $_SESSION['url']=$url; //add url to session
                 ?> <!--ajax coner -->
			       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
			       <script>
			       $(document).ready(function(){
			          //ajax call send page views
					  var eye=$('.eye-counter').attr('id');
					  $.ajax({
					  url:"counterInsert.php", 
					  data:{details:eye}
					     });
					     //

			             });
			        </script><?php


               //END if(isset($_GET['id']))
		   }else/*if (isset($_GET['id'])&& !is_numeric($_GET['id']) || isset($_GET['id'])&&$_GET['id']<1 )*/ {
			  header('location:logout.php?s=no');
			  exit();
				 
		   }

		

include  $tmpl ."footer.inc";
include 'foot.php';
 ob_end_flush();
 