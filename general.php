<?php
ob_start();
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365 * 5);
session_start();
$title='مستفيد منتجات  ';       //title of the page

$keywords='<meta name="keywords" content="    منتجات ,  شراء  ,  اشترى  ,  سعر ,  السوق ,  اجهزة كهربائية  , الجمال, الزينة , خصم , ملابس , احذية ,  شنط ,  جلد , عروض   , اجهزة  , كروشيه , مفروشات , خصومات      ">';
$description='<meta name="description" content=" جمعنالك في مستفيد منتجات عليها خصومات حقيقية؛ اجهزة كهربائية الجمال و الزينة ملابس و احذية شنط جلد و كروشيه منتجات عناية مفروشات و غيرها.. مع مستفيد اشتري بسعر أقل من سعر السوق الأصلى  ">';

include 'init.php';



    //store session
if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb
//if activated==0 => email updated but not verified
if (isset($session)) {
//if activated==0 => email updated but not verified & if user or trader is banned
  banned($session);
}

?> 
  <section class="para-section para-g ">
   <div class="son" >
	 <div class="div-ul">
		<div class="div-first">أقسام المنتجات  </div>
		<ul>
			<?php
			$stmt=$conn->prepare(" SELECT * from categories WHERE cat_id<=10  ");	 
		    $stmt->execute();
		    $cats=$stmt->fetchAll();
		    if (!empty($cats)) {
		    	foreach ($cats as $cat) { ?>
		    		<li><i class="fas fa-star"></i><a href="search.php?cat=<?php echo $cat['cat_id']?>&state=0&ordering=1&main=g"><?php echo $cat['cat_nameAR'];?></a></li>
		    <?php }
		    } ?>
		</ul> 
	</div>
	<div class="div-img">
		<img src="layout/images/cover.png" alt="موقع مستفيد ">  
	</div>
</div>
</section>


<!--?????????????????????????-->
<div class="icons">tyttt<!--<img src="layout/images/perfume2.png">-->
	<div class="con"><a href="search.php?cat=1&state=0&ordering=1&main=g"><i class="fas fa-hamburger"></i></a> <p>طعام </p></div>
	<div class="con"><a href="search.php?cat=2&state=0&ordering=1&main=g"><i class="fas fa-tv"></i></a> <p>أجهزة </p></div>
	<div class="con"><a href="search.php?cat=3&state=0&ordering=1&main=g"><i class="fas fa-couch"></i></a> <p>لوازم المنزل </p></div>
	<div class="con"><a href="search.php?cat=4&state=0&ordering=1&main=g"><i class="fas fa-spray-can"></i></a> <p>الجمال والزينة </p></div>
	<div class="con"><a href="search.php?cat=5&state=0&ordering=1&main=g"><i class="fas fa-tshirt"></i></a> <p>ملابس وأحذية </p></div>
	<div class="con"><a href="search.php?cat=6&state=0&ordering=1&main=g"><i class="fas fa-paint-roller"></i></a> <p>بناء وتشطيبات </p></div>
	<div class="con"><a href="search.php?cat=7&state=0&ordering=1&main=g"><i class="fas fa-building"></i></a> <p>عقارات وأراضي </p></div>
	<div class="con"><a href="search.php?cat=8&state=0&ordering=1&main=g"><i class="fas fa-car"></i></a> <p>مركبات </p></div>
	<div class="con"><a href="search.php?cat=9&state=0&ordering=1&main=g"><i class="fas fa-tractor"></i></a> <p>معدات  ومستلزمات  </p></div>
	<div class="con"><a href="search.php?cat=10&state=0&ordering=1&main=g"><i class="fas fa-cogs"></i></a> <p>قطع غيار </p></div>
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
	 					<a  class="p-title  alone font1 titleLink" href="details.php?id=<?php echo $value['item_id']?>&t=i&main=g"><?php echo $value['title'] ?></a>
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
		<a class="see-more" href="search.php?cat=0&state=0&ordering=1&main=g">شاهد المزيد </a>
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
	 					<a href="details.php?id=<?php echo $value['item_id']?>&t=i&main=g" class="p-title  alone font1 titleLink"><?php echo $value['title'] ?></a>
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
		
		<a class="see-more"  href="search.php?cat=0&state=0&ordering=2&main=g">شاهد المزيد </a> 
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
	 					<a href="details.php?id=<?php echo $value['item_id']?>&t=i&main=g" class="p-title  alone font1 titleLink"><?php echo $value['title'] ?></a>
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
		
		<a class="see-more" href="search.php?cat=0&state=0&ordering=3&main=g">شاهد المزيد </a>
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
   <?php



 
 include  $tmpl ."footer.inc";
 include 'foot.php';
 ob_end_flush();
 