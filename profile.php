<?php
ob_start();
session_start();
$title='حسابي  ';       //title of the page
include 'init.php';
date_default_timezone_set('Africa/cairo');



if (isset($_SESSION['traderid'])) { //trader
      $session=$_SESSION['traderid'];
      //if activated==0 => email updated but not verified & if user or trader is banned
      banned($session); 

    if (isset($_GET['i']) && is_numeric($_GET['i']) && $_GET['i']>0 && $_GET['i']==$session ) {
	 $id=intval($_GET['i']); 
	 ///////////////
	 //don't allow trader to insert ads if he hasn't enough credit for paying online
     $stmt=$conn->prepare("SELECT max(item_mostafed),user.online_pay,user.credit FROM  items
       join user on  items.user_id=user.user_id WHERE user.user_id=? and user.online_pay=1 ");
     $stmt->execute(array($session));
     $fetchMax=$stmt->fetch();
	 //////////////
    // HOMEPAGE ICON 
				?>
                <div class="profile-container">
				<div class="home-profile-link-div">
					<a href="index.php" style="text-decoration: none;vertical-align: super;">
						<!--<i class="fas fa-house-user home-img"></i>-->
						<img class="home-img" src="<?php echo $images ?>home.png">
			        </a><span class="span-heading"> >حسابي</span>
			     </div> 
			     <div class="profile-top">
			     	<a href="?i=<?php echo $id;?>&p=data"><?php if(isset($_GET['p'])&&$_GET['p']=='data'){ ?><span class="focus1">بياناتي</span> <?php }else{ echo 'بياناتي';} ?></a>
			     	<a href="?i=<?php echo $id;?>&p=items"><?php if(isset($_GET['p'])&&$_GET['p']=='items'){ ?><span class="focus2">اعلاناتي  </span> <?php }else{ echo 'اعلاناتي   ';} ?></a>
			     	<a class="ordersLink" href="?i=<?php echo $id;?>&p=orders"><?php if(isset($_GET['p'])&&$_GET['p']=='orders'){ ?><span class="focus3">طلبات الشراء</span> <?php }else{ echo 'طلبات الشراء';} ?></a>
                    <!-- to send ajax to process1.php & change orders num -->
			     	<input type="hidden" class="sess" value="<?php echo $session;?>">
			     	<a href="?i=<?php echo $id;?>&p=credit"><?php if(isset($_GET['p'])&&$_GET['p']=='credit'){ ?><span class="focus4">معاملاتي  </span> <?php }else{ echo 'معاملاتي  ';} ?></a>
			     	<a href="?i=<?php echo $id;?>&p=favourites"><?php if(isset($_GET['p'])&&$_GET['p']=='favourites'){ ?><span class="focus5">المفضلة</span> <?php }else{ echo 'المفضلة';} ?></a>
			     	<a href="?i=<?php echo $id;?>&p=bought"><?php if(isset($_GET['p'])&&$_GET['p']=='bought'){ ?><span class="focus6">مشترياتي  </span> <?php }else{ echo 'مشترياتي  ';} ?></a>
			     	<a href="?i=<?php echo $id;?>&p=msg"><?php if(isset($_GET['p'])&&$_GET['p']=='msg'){ ?><span class="focus7">رسائلي  </span> <?php }else{ echo 'رسائلي  ';} ?></a>
			     	<a href="?i=<?php echo $id;?>&p=program"><?php if(isset($_GET['p'])&&$_GET['p']=='program'){ ?><span class="focus8">برنامج الشراكة </span> <?php }else{ echo 'برنامج الشراكة  ';} ?></a>
			     	<?php 
			     	//
			     	$fetchOn=fetch('online_pay','user','user_id',$session);
			     	if($fetchOn['online_pay']==1){
				     	if($fetchMax['credit']>0&&$fetchMax['credit']>=$fetchMax['max(item_mostafed)']*3){ ?><a href="ad.php">أضف   اعلان </a> <?php }
				     	else{ ?><a class="adNote">أضف   اعلان </a> <div class="adNote2">لا يمكنك اضافة اعلان لأن رصيدك لا يكفي لتغطية مستحقات مستفيد  <i class="fas fa-times adNote3"></i></div><?php }
			     	}else{ ?><a href="ad.php">أضف   اعلان </a> <?php }
			     	?>
			     	
			     </div>

			     <hr> 
			     <?php
			     $p=isset($_GET['p'])?$_GET['p']:'none';
			     if ($p=='data') { //TRADER
			     	$stmt=$conn->prepare(" SELECT * from user 
			     		join categories on categories.cat_id=user.cat_id
			     		join country on country.country_id=user.country_id
			     		join state on state.state_id=user.state_id
			     		join city on city.city_id=user.city_id
			     		where user.user_id=$id  ");	
				    $stmt->execute();
				    $trader=$stmt->fetch(); 
			     	?> 
			     	<div class="data-div">
			     	  <div class="title"><a href="index.php">الرئيسية</a> > <span> حسابي </span> > <span>بياناتي </span></div>
			     	<p>الاسم: <?php echo $trader['name']?></p>
			     	<p>اسم النشاط : <?php echo $trader['commercial_name']?></p>
			     	<p>الدولة: <?php echo $trader['country_nameAR']?></p>
			     	<p>المحافظة: <?php echo $trader['state_nameAR']?></p>
			     	<p>المدينة: <?php echo $trader['city_nameAR']?></p>
			     	<p>مجال النشاط: <?php echo $trader['cat_nameAR']?></p>
			     	<p>التليفون: <?php echo '0'.$trader['phone']?></p>
			     	<p>تاريخ الانضمام:<?php echo $trader['reg_date']?></p>
			     	<a href="action.php?d=edit-tr&id=<?php echo $trader['user_id']?>"><?php echo $lang['updateProf']?></a>
			     	<?php 
			     	if (isset($_COOKIE['phoneMos']) && $_COOKIE['phoneMos']==$trader['phone'] ) {
			     		?><p><a class="confirmRemove" href="action.php?d=no-remember&ip=<?php echo $trader['user_id'] ?>">الغاء حفظ بيانات الدخول  </a><input type="hidden" class="language" value="<?php echo $l; ?>">
			     			<i title="لا تحتفظ ببيانات تسجيل دخولي على هذا الجهاز  (رقم التليفون وكلمة المرور)" class="fas fa-exclamation-triangle rightx" data-bs-toggle="offcanvas" data-bs-target="#remCanvas" aria-controls="offcanvasWithBothOptions"></i>
                              <!--////////////-->
                                  <div class="offcanvas offcanvas-start " id="remCanvas" data-bs-scroll="true" tabindex="-1"  aria-labelledby="offcanvasWithBothOptionsLabel">
						              <div class="offcanvas-header">
						                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
						              </div> 
						              <div class="offcanvas-body">
						                <span>لا تحتفظ ببيانات تسجيل دخولي على هذا الجهاز  (رقم التليفون وكلمة المرور)</span>
						              </div>
						        </div>
                                  <!--////////////-->
			     		  </p><?php
			     	} ?>
			     	<p><a class="alone confirmDeleteAcc" href="action.php?d=del-tr&id=<?php echo $trader['user_id']?>">حذف حسابي  </a><input type="hidden" class="language" value="<?php echo $l;?>"></p>
                    </div>
			     	
			 <?php }elseif ($p=='items') { //TRADER
			 	//pagination data 
				$adsPerPage=16;
				$itemsShown=countFromDb4('item_id','items','user_id','=',$_SESSION['traderid'],'approve','>',0,'hide','=',0);
				$itemsPending=countFromDb4('item_id','items','user_id','=',$_SESSION['traderid'],'approve','=',0,'hide','=',0);
				$itemsHidden=countFromDb4('item_id','items','user_id','=',$_SESSION['traderid'],'approve','>',0,'hide','=',1);
				$NumberOfPages=ceil($itemsShown/$adsPerPage);
				$pageNum= isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page']<=$NumberOfPages&& $_GET['page']>0 ? intval($_GET['page']) : 1; 
			    $startFrom=($pageNum-1)* $adsPerPage; //
                
			 	$stmt=$conn->prepare(" SELECT * from items 
		     		join categories on categories.cat_id=items.cat_id
		     		join sub on sub.subcat_id=items.subcat_id
		     		join country on country.country_id=items.country_id
		     		join state on state.state_id=items.state_id
		     		join city on city.city_id=items.city_id
		     		join user on user.user_id=items.user_id
		     		where user.user_id=$id  limit $startFrom,$adsPerPage ");	
			    $stmt->execute();
			    $traders=$stmt->fetchAll();
			    
			    //mostafed rates
                $sum_mostafed=sumFromDb3('order_mostafed','orders','trader_id',$_SESSION['traderid'],'approve',1);
			 	?><div class="title">
				 	<div><a href="index.php">الرئيسية</a> > <span> حسابي </span> > <span>اعلاناتي  </span></div>
				 	<div class="two"><span>الاعلانات المعروضة  <?php echo '('.$itemsShown.')';?> &emsp;اعلانات  في  انتظار الموافقة <?php echo '('.$itemsPending.')';?> &emsp;اعلانات  محجوبة <?php echo '('.$itemsHidden.')';?></span></div>
			 	</div><?php
			 	if (!empty($traders)) {
 
			 	?><form action="action.php" method="POST" id="form-item"> 
			 		 <button title="" class="del-btn confirmHide ">حجب   </button>
			 		 <input type="hidden" class="language" value="<?php echo $l;?>">
			        <div class="items-container items-container-profile"> <?php
			 			foreach ($traders as $value) { 
			 				$ratio=$value['price']*($value['discount']/100);
			 				$finalPrice1=round($value['price']-$ratio);
                            $finalPrice=number_format($finalPrice1);
			 				?>
			 				<!--////////////////////////-->
			 		<div class="repeated-cont repeated-cont-profile <?php if($value['hide']==1){ echo 'opacity'; } ?>">
				      <!-- bring ads on clicking on aside links-->
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
			                <input type="hidden" class="trader" value="<?php echo $_SESSION['traderid'];?>">
                            <?php

			          }elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
			        	 ?><a><i class="fas fa-heart grey2"></i></a>  <?php
			          }else{ ?><a href="login.php"><i class="fas fa-heart grey2"></i></a>  <?php }  ?> 
				        <?php if($value['hide']==0){ 
					        	
					        	//$countIt=countFromDb2('item_id','items','user_id',$_SESSION['traderid']);
					        	//if ($countIt==1) {
					        		?><input type="checkbox" class="del-checkbox" name="item[]" value="<?php echo $value['item_id'] ?>"><?php
					        	/*}else{ ?><input type="checkbox" class="del-checkbox" name="item[]" value="<?php echo $value['item_id'] ?>"><?php }*/
				        	 }  ?>
				        <img src="data\upload\<?php echo $value['photo']?>">
				      </div>
			        <section>
					   <span class="alone small cut2"><?php echo $value['cat_nameAR'].'>'.$value['subcat_nameAR'];?></span>
	 					<a href="details.php?id=<?php echo $value['item_id']?>&t=p&main=p" class="p-title cut2 alone font1"><?php echo $value['title'] ?></a>
	 					<p class="date"><i class="fas fa-calendar"></i><?php echo ' '.$value['item_date'].' '; if($value['sit']==1){ echo "المعلن هو المالك  ";}elseif($value['sit']==2){ echo "السعر شامل أجر الوسيط  ";} ?></p>
	 					
	 					<div class="finalPrice-div">
	 						<s><?php echo $value['price']?></s>
	 						<span>ج.م.</span>
	 						<span>
	 							<span class="bold"><?php echo $finalPrice ?></span> 
	 						    <span>ج.م.</span>
	 						</span>
	 					</div>
	 						<?php
		 					if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id'] ) { //appears as a link for users
		 					 	?> <a class="a-phone" title="تقديم طلب شراء " href="order.php?id=<?php echo $value['item_id']?>"><i class="fas fa-phone"></i></a> <?php
		 					}elseif (isset($_SESSION['userEid'])||isset($_SESSION['userGid'])||isset($_SESSION['userFid'])) {
		 						?> <a class="a-phone" title="تقديم طلب شراء " href="order.php?id=<?php echo $value['item_id']?>"><i class="fas fa-phone"></i></a> <?php
		 					}elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
		 						?> <a class="a-phone"><i class="fas fa-phone"></i></a> <?php
		 					}else{ //appears as empty link for traders
		 					 	?> <a class="a-phone" href="login.php"><i class="fas fa-phone"></i></a> <?php
		 					} ?>
	 					 <div class="bottom-div">
		 					<span class="alone small"><?php echo $value['country_nameAR'].'/'.$value['state_nameAR'].'/'.$value['city_nameAR'];?></span>
		 					<?php 
				              if ($value['delivery']==1) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مدفوع داخل  </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
				              if ($value['delivery']==2) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مجاني داخل </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
				              if ($value['delivery']==3) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مدفوع داخل </span><span><?php echo $value['city_nameAR'] ?></span></span> <?php }
				              if ($value['delivery']==4) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مجاني داخل </span><span><?php echo $value['city_nameAR'] ?></span></span> <?php }
				              if ($value['delivery']==5) { ?><span class="alone deliv"><span class="cut2"><i title="توصيل " class="fas fa-truck"></i>مجاني  </span><span><?php echo $value['city_nameAR'].' ' ?>مدفوع  <?php echo $value['state_nameAR'] ?></span></span> <?php }
				              if ($value['delivery']==6) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مجاني  </span><span><?php echo $value['city_nameAR'] ?>مدفوع كل  المحافظات   </span></span> <?php }
				              if ($value['delivery']==7) { ?><span class="alone deliv"><i title="توصيل " class="fas fa-truck"></i>مدفوع لكل  المحافظات</span> <?php }
				              if ($value['delivery']==8) { ?><span class="alone deliv"><i title="توصيل " class="fas fa-truck"></i>مجاني لكل  المحافظات</span> <?php }
				             
		 						/*** fa-trash **/
		 					if ($sum_mostafed>0) { echo "<a class='form-del' title='لا يمكن  الحذف لوجود مستحقات مالية لمستفيد '><i class='fas fa-trash'></i></a>"; }
		 						else{ ?><a title="حذف " class='form-del2 confirmDelete' href="action.php?d=del_item&i=<?php echo $value['item_id']?>"><i class='fas fa-trash'></i></a> <?php }
		 				    ?> <input type="hidden" class="language" value="<?php echo $l;?>">
	 				        <!-- fa-cog --> 
	 				        <a class="edit" href="action.php?d=edit_item&i=<?php echo $value['item_id']?>" title="تعديل  "><i class="fas fa-cog"></i> </a> 
	 				        <?php 
	 				        //fa- door & fa-eye 
	 				        if($value['approve']==0){ ?><i title="في انتظار الموافقة " class="fas fa-door-closed"></i><?php } 
	 				        if($value['hide']==1){ ?> <a class='confirmUnHide' title="الغاء حجب  " href="action.php?d=unhide&i=<?php echo $value['item_id']?>"><i class="fas fa-eye"></i></a><?php } 
                            // orders for each approved item 
		          			$orders_item_approved=countFromDb4('order_id','orders','trader_id','=',$_SESSION['traderid'],'item_id','=',$value['item_id'],'approve','=',1); 
		          			// orders for each unapproved item 
		          			$orders_each_pending=countFromDb4('order_id','orders','trader_id','=',$_SESSION['traderid'],'item_id','=',$value['item_id'],'approve','=',0); 
                            if($orders_item_approved>0){ echo '('.$orders_item_approved.')';?><i title="طلبات تم تحويلها " class="fas fa-share"></i> <?php }
                            if($orders_each_pending>0){ echo '('.$orders_each_pending.')';?><i title="طلبات في انتظار التحويل " class="fas fa-lock"></i> <?php }
                            ?>
	 				        <!--/////////////-->
	 				     </div>
					   </section>
					</div>
				 	<!--/////////////////////////-->
				 	<?php  } 
                  
			 	?>  </div><!-- END items-container --><?php
					 	   //===================start pagination=========================	
					    $jumpForward=1;
					 	$jumpBackward=1; 

					if($NumberOfPages>1 ){ 	?>
					 <nav aria-label="Page navigation example" class="pagination-container">
						  <ul class="pagination pagination-md">
						 <?php if(($pageNum-$jumpBackward)>=1 ){  //previous
						 ?> <li class="page-item"><a class="page-link prev" href="?i=<?php echo $id.'&page='. ($pageNum-$jumpBackward)?>"><?php echo $lang['prev'];?></a></li><?php
					      }else{
					      ?> <li class="page-item disabled"><a class="page-link"><?php echo $lang['prev'];?></a></li><?php
					      }
					      //$page=1; $page<= $NumberOfPages;  $page++
					  for ($page=max(1,$pageNum-2);$page<=min($pageNum+2,$NumberOfPages);$page++) {  //for loop
						if (isset($_GET['page'])&&$_GET['page']==$page ) {
							echo   '<li class="page-item"><a class="page-link active" href="profile.php?i='.$id.'&p=items&page='.$page.'">'.$page.'</a></li>';
						}elseif (!isset($_GET['page'])&&$page==1 ) {
						   echo   '<li class="page-item"><a class="page-link active" href="profile.php?i='.$id.'&p=items&page='.$page.'">'.$page.'</a></li>';
						}else{
							echo   '<li class="page-item"><a class="page-link" href="profile.php?i='.$id.'&p=items&page='.$page.'">'.$page.'</a></li>';
						} }
					    if(($pageNum+$jumpForward)<=$NumberOfPages){  //next
						?> <li class="page-item"> <a class="page-link next"  href="?i=<?php echo $id.'&page='. ($pageNum+$jumpForward)?>"><?php echo $lang['next'];?></a> </li><?php
					}else{
					   ?> <li class="page-item disabled"> <a class="page-link "><?php echo $lang['last'];?></a> </li><?php
					} ?>  
					    </ul > 
					</nav>
					<?php
					} ?>
			<!--////////////// END pagination //////////////-->
			 	</form>  
			 <?php	}else{ ?><span>لا توجد  اعلانات  معروضة  </span> <?php } 
			


			 }elseif ($p=='orders') { //TRADER
		 	//pagination data
			$adsPerPage=10;
			$ordersNum=countFromDb3('order_id','orders','trader_id',$id,'approve',1);
			$NumberOfPages=ceil($ordersNum/$adsPerPage);
			$pageNum= isset($_GET['Page']) && is_numeric($_GET['Page']) && $_GET['Page']<=$NumberOfPages&& $_GET['Page']>0 ? intval($_GET['Page']) : 1; 
		    $startFrom='';
		    $startFrom=($pageNum-1)* $adsPerPage; //
                
				//from orders table
			$stmt=$conn->prepare(" SELECT orders.*,items.*,user.*,state.*,city.* from orders 
			join items on items.item_id=orders.item_id
			join user  on user.user_id =orders.trader_id 
			join state on state.state_id=orders.state_id
			join city on city.city_id=orders.city_id
			where orders.trader_id=? and orders.approve=1  order by orders.order_id desc   limit $startFrom,$adsPerPage  " );
			$stmt->execute(array($_SESSION['traderid']));
			$orders=$stmt->fetchAll();
			$row=$stmt->rowCount(); 

			//mostafed rates
			$stmt2=$conn->prepare(' SELECT SUM(order_mostafed) from orders where trader_id=? and approve=1');
            $stmt2->execute(array($_SESSION["traderid"]));$sum_mostafed=$stmt2->fetchColumn();
            //all my orders
		    $stmt2=$conn->prepare(' SELECT count(order_id) from orders where trader_id=? and approve=1 ');
		    $stmt2->execute(array($_SESSION['traderid']));$count_MyOrders=$stmt2->fetchColumn();
		    //my orders during the last week
		    $stmt=$conn->prepare(' SELECT count(order_id) from orders where trader_id=? and approve=1 and order_date > UNIX_TIMESTAMP()-(3600*24*7) ');
		    $stmt->execute(array($_SESSION['traderid']));$count_MyOrders7=$stmt->fetchColumn();
			?>
		<div>
		  <div class="order-main"> 
			<div class="title">
				<div class="one"><a href="index.php">الرئيسية</a> > <span> حسابي </span> > <span>طلبات الشراء </span></div>
		        <div class="two"><span>كل طلبات الشراء: <?php echo '('.$count_MyOrders.')';?></span>&emsp;&emsp;&emsp;<span>طلبات الشراء في  آخر أسبوع: <?php echo '('.$count_MyOrders7.')';?></span></div>
		  </div>
		<?php if ($row>0) {  ?>
			<section>
				<table class="table-trader">
				<thead>
				  <tr>
					<td class="wide">مقدم الخدمة </td> 
					<td class=" more">اسم  الاعلان </td>
					<td>السعر قبل الخصم</td>
					<td>نسبة الخصم</td>
					<td>السعر بعد الخصم</td>
					<td>الكمية </td>
					<td class="last">مستفيد  <br><span class="white bold"><?php echo $sum_mostafed;?></span></td>
					<td class="buyer-head wide">اسم المشتري</td> 
					<td class="buyer-head">تليفون المشتري</td>
					<td class="buyer-head wide">المحافظة - المدينة  </td>
					<td class="buyer-head wide">تاريخ الطلب</td>
					<td class="buyer-head">كود  الخصم  </td>
					<td class="last">اجراء</td>
				  </tr>
			</thead>
			<tbody>
				<?php 
			foreach ($orders as $item) {
				$ratio=$item['price']*($item['discount']/100);
                $finalPrice=round($item['price']-$ratio);
                $fetchUser_id=fetch('user_id','orders','order_id',$item['order_id']);
		         ?>

				<tr class="tr">
					<td class="cut2"><?php echo $item['commercial_name'] ?></td>
					<td><a href="details.php?id=<?php echo $item['item_id'] ?>&t=p&main=p"><?php echo $item['title']?></a></td>
					<td><s><?php echo $item['price']?></s></td>
					<td><?php echo $item['discount'].'%'?></td>
					<td><?php echo $finalPrice ?></td>
					<td><?php if($item['num2']>0&&$item['modefy']==0){ ?><span class="red2"><?php echo $item['num']?></span> <?php }elseif($item['num2']>0&&$item['modefy']==1){ ?><span class="green"><?php echo $item['num']?></span> <?php }else{ echo $item['num']; } ?></td>
					<td class="last"><?php echo $item['order_mostafed'];?></td>
					<td class="buyer-body"><?php echo $item['buyer_name']?></td>
					<td class="buyer-body"><?php echo '0'.$item['buyer_phone']?></td>
					<td class="buyer-body cut2"><?php echo $item['state_nameAR'].'-'.$item['city_nameAR']?></td> 
					<td class="buyer-body"><?php echo date('d/m/Y h:i:s A',$item['order_date'])?></td> 
					<td class="buyer-body"><?php echo $item['order_code']?></td> 
					<td class="last">
					 <?php  
					 if($item['cat_id']==1){ $next=$item['approve_date']+3600; }else{ $next=$item['approve_date']+(3600*72); }
					  //report available after one hour for food category, 3days for other categories 
					 $today=time();
					if($item['report']==1||$item['num2']>0){ ?><span class="blue small">تم التبليغ  </span>&emsp;<a class="report" href="process1.php?d=unreport&r=<?php echo $item['order_id']?>&tr=<?php echo $item['user_id']?>" >تراجع  </a> <?php }
                    elseif($item['report']==0 &&$item['num2']==0&&($today<$next)){ ?><span title="التبليغ متاح بعد 3 أيام " class="lightgrey" >تبليغ  </span> <?php } 
					elseif($item['report']==0 &&$item['num2']==0&&($today>$next)){ ?><a class="report confirmReport" href="process1.php?d=report&r=<?php echo $item['order_id']?>&tr=<?php echo $item['user_id']?>">تبليغ  </a> <input type="hidden" class="language" value="<?php echo $l;?>"><?php } 
				    elseif($item['report']==2){ ?> <span class="lightgrey" >تم الشراء </span> <?php }
				    ?>
			      </td> 
				</tr>
				<?php  }  //END if(!empty($orders)&&foreach)?> 
			 </tbody>
		 </table>
	   </section>
	  <?php }else{echo "<span class='right font-size'>لا توجد طلبات شراء </span>";} 
	?> </div><?php
	
	   //===================start pagination=========================	
		    $jumpForward=1;
		 	$jumpBackward=1; 

		if($NumberOfPages>1 ){ 	?>
		 <nav aria-label="Page navigation example" class="pagination-container">
			  <ul class="pagination pagination-md">
			 <?php if(($pageNum-$jumpBackward)>=1 ){  //previous
			 ?> <li class="page-item"><a class="page-link prev" href="?i=<?php echo $id.'&Page='. ($pageNum-$jumpBackward)?>"><?php echo $lang['prev'];?></a></li><?php
		      }else{
		      ?> <li class="page-item disabled"><a class="page-link"><?php echo $lang['prev'];?></a></li><?php
		      }
		      //$page=1; $page<= $NumberOfPages;  $page++
		  for ($page=max(1,$pageNum-2);$page<=min($pageNum+2,$NumberOfPages);$page++) {  //for loop
			if (isset($_GET['Page'])&&$_GET['Page']==$page ) {
				echo   '<li class="page-item"><a class="page-link active" href="profile.php?i='.$id.'&p=orders&Page='.$page.'">'.$page.'</a></li>';
			}elseif (!isset($_GET['Page'])&&$page==1 ) {
			   echo   '<li class="page-item"><a class="page-link active" href="profile.php?i='.$id.'&p=orders&Page='.$page.'">'.$page.'</a></li>';
			}else{
				echo   '<li class="page-item"><a class="page-link" href="profile.php?i='.$id.'&p=orders&Page='.$page.'">'.$page.'</a></li>';
			} }
		    if(($pageNum+$jumpForward)<=$NumberOfPages){  //next
			?> <li class="page-item"> <a class="page-link next"  href="?i=<?php echo $id.'&Page='. ($pageNum+$jumpForward)?>"><?php echo $lang['next'];?></a> </li><?php
		}else{
		   ?> <li class="page-item disabled"> <a class="page-link "><?php echo $lang['last'];?></a> </li><?php
		} ?>  
		    </ul > 
		</nav>
		<?php
		} 
	////////////// END pagination //////////////
   ?></div>
   <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
       	//change orders to seen
	     $('.ordersLink').click(function(){ 
        var sess=$('.sess').val();
        $.ajax({
        url:'process1.php?d=changeSeen',
        data:{session:sess}
         });
	    });
	     


	      });
     </script>




	 <?php	
	 }elseif ($p=='credit') { //TRADER ?>
	 	<div class="title"><a href="index.php">الرئيسية</a> > <span> حسابي </span> > <span> معاملاتي  </span></div>
		
		     <?php
		  		//pagination data
				$adsPerPage=12;
				//approved orders 
				$all_Orders=countFromDb2('order_id','orders','trader_id',$id);
				$all_approvedOrders=countFromDb3('order_id','orders','trader_id',$id,'approve',1);
			    $NumberOfPages=ceil($all_approvedOrders/$adsPerPage);
				$pageNum= isset($_GET['Page']) && is_numeric($_GET['Page']) && $_GET['Page']<=$NumberOfPages&& $_GET['Page']>0 ? intval($_GET['Page']) : 1; 
			    $startFrom=($pageNum-1)* $adsPerPage; //group by items.title group by orders.item_id

		  		//from orders table
				$stmt=$conn->prepare("  SELECT orders.*,items.* from orders 
				join items on items.item_id=orders.item_id
				where orders.trader_id=? and orders.approve=1 order by orders.order_id desc  limit $startFrom,$adsPerPage " );
				$stmt->execute(array($_SESSION['traderid']));
				$orders=$stmt->fetchAll();
				$row=$stmt->rowCount(); 

                //Num of awaiting approval orders 
                $awaiting_orders_num=countFromDb3('order_id','orders','trader_id',$id,'approve',0);
                //mostafed rates
                $sum_mostafed=sumFromDb3('order_mostafed','orders','trader_id',$_SESSION['traderid'],'approve',1);
                //credit
                $credit=fetch2('credit','user','user_id',$_SESSION['traderid'],'online_pay',1);//
                //get min value in order_mostafed
                $Minimum=fetch('max(item_mostafed)','items','user_id',$_SESSION['traderid']);
	            //get online pay
	            $fetchOnline=fetch2('online_pay','user','user_id',$_SESSION['traderid'],'trader',1);

	      if ($row>0) { //with approved orders ?> 
		   <div>
		    <div class="order-main"> 
		  	  
		  	  	
		  	  	<table class="table-trader one-row">
	             	<thead>
	             		<tr>
	             			<td class="top" rowspan="2">الرصيد </td>
	             			<td class="num" rowspan="2"><?php  if($credit['credit']<$Minimum['max(item_mostafed)']*3){echo '<span class="red2">'.number_format($credit['credit'],2,'.',',').' '.'ج.م. </span>'.'&emsp;&emsp;<span class="small"> اشحن رصيدك  <i title="ارسل المبلغ الذي تريد شحن رصيدك به الى 01013632800 (فودافون كاش) " class="fas fa-exclamation red2"></i></span>'; }else{echo '<span class="green">'.number_format($credit['credit'],2,'.',',').' '.'ج.م. </span>';} ?></td>
	             		</tr>
	             	</thead>
	             </table> 
	             
	             <p>لشحن رصيدك ارسل المبلغ الذي تريده الى (01013632800) عبر فودافون كاش ثم تواصل معنا </p> 
	             <br><br>
	            <section>
	            <table class="table-trader credit">
	              <thead>
	          		<tr>
		          		<td>اعلانات  عليها طلبات  </td>
		          		<td class="top">عدد الطلبات  المحولة  <?php echo '('.$all_approvedOrders.')'; ?></td>
		          		<td class="top">مستحقات مستفيد  <i title="عن الطلبات المحولة فقط " class="fas fa-exclamation "></i><br> <?php echo 'الجملة: '.$sum_mostafed.' '.'ج.م.';?></td>
	          	    </tr>
	          	</thead>
	          	<tbody>
	          		<?php
	          		foreach ($orders as $value) {
                        //mostafed
	          			$mos=sumFromDb2('order_mostafed','orders','item_id',$value['item_id']);
	          			?>
	          		    <tr>
		          			<td class="cut2 more"><?php echo $value['title'] ?></td>
		          			<td class="bot"><?php echo date('Y-m-d',$value['order_date']); ?></td>
		          			<td class="bot"><?php if($value['order_mostafed']==0 && $fetchOnline['online_pay']==0){ echo '<span class="green">تم الدفع  </span>'; }else{ echo $value['order_mostafed']; }  //if($mos==0){echo "0".'ج.م.';}else{echo $mos.' '.'ج.م.';} ?></td>
	          		    </tr>
	          	     <?php } ?>
	           	   </tbody>
	             </table>
	            </section>
	           </div><?php
	     

	           }else{ //(without approved orders)having no orders or have only pending orders ?>

         <div class="order-main"> 
		   
		   	<table class="table-trader one-row">
	             	<thead>
	             		<tr>
	             			<td class="top" rowspan="2">الرصيد  </td>
	             			<td class="num" rowspan="2"><?php if($fetchOnline['online_pay']==1){ if($credit['credit']==0||$credit['credit']<$Minimum['max(item_mostafed)']*3){echo '<span class="red2">'.number_format($credit['credit'],2,'.',',').' '.'ج.م. </span>'.'&emsp;&emsp;<span class="small"> اشحن رصيدك  <i title="ارسل المبلغ الذي تريد شحن رصيدك به الى 01013632800 (فودافون كاش) " class="fas fa-exclamation red2"></i></span>'; }else{echo '<span class="green">'.number_format($credit['credit'],2,'.',',').' '.'ج.م. </span>';} }else{ echo '<span class="red2">'.number_format($credit['credit'],2,'.',',').' '.'ج.م. </span>'.'&emsp;&emsp;<span class="small"> اشحن رصيدك  <i title="ارسل المبلغ الذي تريد شحن رصيدك به الى 01013632800 (فودافون كاش) " class="fas fa-exclamation red2"></i></span>'; } ?></td>
	             		</tr>
	             	</thead>
	             </table>   
	             
	             <p>لشحن رصيدك ارسل المبلغ الذي تريده الى (01013632800) عبر فودافون كاش ثم تواصل معنا </p> 
	             <br><br>
	             <section>
	        <table class="table-trader credit">
	          	<thead>
	          		<tr>
		          		<td>كل الاعلانات  </td>
		          		<td>طلبات في الانتظار  </td>
		          		<td>مستحقات مستفيد  </td>
	          	    </tr>
	          	</thead>
	          	<tbody>
	          		<?php
	          		$count_MyItems=countFromDb2('item_id','items','user_id',$session);
	          		?>
	          		<tr> 
	          			<td><?php echo $count_MyItems; ?></td>
	          			<td><?php echo $awaiting_orders_num; ?> </td>
	          			<td><?php echo '0 '.'ج.م.';?></td>
	          		</tr>
	          	</tbody>
	          </table>
	        <?php  }
        ?> </section>
      </div>
  </div> <?php
       //===================start pagination=========================	
		    $jumpForward=1;
		 	$jumpBackward=1; 

		if($NumberOfPages>1 ){ 	?>
		 <nav aria-label="Page navigation example" class="pagination-container">
			  <ul class="pagination pagination-md">
			 <?php if(($pageNum-$jumpBackward)>=1 ){  //previous
			 ?> <li class="page-item"><a class="page-link prev" href="?i=<?php echo $id.'&p=credit&Page='. ($pageNum-$jumpBackward)?>"><?php echo $lang['prev'];?></a></li><?php
		      }else{
		      ?> <li class="page-item disabled"><a class="page-link"><?php echo $lang['prev'];?></a></li><?php
		      }
		      //$page=1; $page<= $NumberOfPages;  $page++
		  for ($page=max(1,$pageNum-2);$page<=min($pageNum+2,$NumberOfPages);$page++) {  //for loop
			if (isset($_GET['Page'])&&$_GET['Page']==$page ) {
				echo   '<li class="page-item"><a class="page-link active" href="profile.php?i='.$id.'&p=credit&Page='.$page.'">'.$page.'</a></li>';
			}elseif (!isset($_GET['Page'])&&$page==1 ) {
			   echo   '<li class="page-item"><a class="page-link active" href="profile.php?i='.$id.'&p=credit&Page='.$page.'">'.$page.'</a></li>';
			}else{
				echo   '<li class="page-item"><a class="page-link" href="profile.php?i='.$id.'&p=credit&Page='.$page.'">'.$page.'</a></li>';
			} }
		    if(($pageNum+$jumpForward)<=$NumberOfPages){  //next
			?> <li class="page-item"> <a class="page-link next"  href="?i=<?php echo $id.'&p=credit&Page='. ($pageNum+$jumpForward)?>"><?php echo $lang['next'];?></a> </li><?php
		}else{
		   ?> <li class="page-item disabled"> <a class="page-link "><?php echo $lang['last'];?></a> </li><?php
		} ?>  
		    </ul > 
		</nav>
		<?php
		} 
	////////////// END pagination //////////////

  
			 	   	 
	 
	 }elseif ($p=='favourites') { //TRADER
	 	//pagination data
		$adsPerPage=12;
		//approved orders  
		//$fechItmId=fetch('item_id','items','user_id',$_SESSION['traderid']);
		$stmt3=$conn->prepare("SELECT COUNT(favourite_id),items.* FROM favourite
		join items on items.item_id=favourite.item_id 
		join user on user.user_id=favourite.user_id 
		where favourite.user_id=? and favourite.favourite_status>0  ");
		$stmt3->execute(array($_SESSION['traderid']));
		$all_favourite_num=$stmt3->fetchColumn(); ////and items.hide=0 

		//$all_favourite_num=countFromDb2('favourite_id','favourite','user_id',$_SESSION['traderid']);
		$NumberOfPages=ceil($all_favourite_num/$adsPerPage);
		$pageNum= isset($_GET['Page']) && is_numeric($_GET['Page']) && $_GET['Page']<=$NumberOfPages&& $_GET['Page']>0 ? intval($_GET['Page']) : 1; 
	    $startFrom=($pageNum-1)* $adsPerPage; //

	  	 $stmt=$conn->prepare(" SELECT categories.*,sub.*,state.*,city.*,items.*,user.*,favourite.* from favourite 
     		join categories on categories.cat_id=favourite.cat_id
     		join sub on sub.subcat_id=favourite.subcat_id
     		join state on state.state_id=favourite.state_id
     		join city on city.city_id=favourite.city_id
     		join items on items.item_id=favourite.item_id
     		join user on user.user_id=favourite.user_id 
     		where favourite.user_id=?  and favourite.favourite_status>0 limit $startFrom,$adsPerPage");	
	     $stmt->execute(array($_SESSION['traderid']));  
	     $traders=$stmt->fetchAll();

        ?><div class="title">
        	<div><a href="index.php">الرئيسية</a> > <span> حسابي </span> > <span> المفضلة  </span></div>
        	<div class="two"><span>مضاف  الى المفضلة: <?php echo '('.$all_favourite_num.')'; ?></span></div>
        </div><?php
 	   	    
		 	   	if (!empty($traders)) { 
		 	?> <div class="items-container items-container-profile"> <?php
		 			foreach ($traders as $value) { 
	 				$ratio=$value['price']*($value['discount']/100);
                    $finalPrice=round($value['price']-$ratio);
                    $fetch2=fetch('user_id','items','item_id',$value['item_id']);
	 				?>
	 				<!--////////////////////////-->
		 		<div class="repeated-cont repFav  repeated-cont-profile">
			      <!-- bring ads on clicking on aside links-->
			      <div class="div-img-disc">
			    	<span title="خصم" class="disc"><?php echo $value['discount'].'%'.' -' ?></span>
			        <?php
		            if (isset($_SESSION['traderid']) && $_SESSION['traderid']!=$fetch2['user_id'] ) { 
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
		          }elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$fetch2['user_id']) {
		        	 ?><a><i class="fas fa-heart grey2"></i></a>  <?php
		          }else{ ?><a href="login.php"><i class="fas fa-heart grey2"></i></a>  <?php }  ?> 
			       
			        <img src="data\upload\<?php echo $value['photo']?>">
			      </div>
		        <section>
				   <span class="alone small cut2"><?php echo $value['cat_nameAR'].'>'.$value['subcat_nameAR'];?></span>
 					<a href="details.php?id=<?php echo $value['item_id']?>&t=p&main=p" class="p-title cut2 alone font1 titleLink"><?php echo $value['title'] ?></a>
 					<input type="hidden" class="idValue" value="<?php echo $value['item_id'];?>">
 					<p class="date"><i class="fas fa-calendar"></i><?php echo ' '.$value['item_date'].' '; if($value['sit']==1){ echo "المعلن هو المالك  ";}elseif($value['sit']==2){ echo "السعر شامل أجر الوسيط  ";} ?></p>
 					<div class="finalPrice-div">
 						<s><?php echo $value['price']?></s>
 						<span>ج.م.</span>
 						<span>
 							<span class="bold"><?php echo $finalPrice ?></span>
 						    <span>ج.م.</span>
 						</span>
 					</div>
 						<?php
	 					if (isset($_SESSION['traderid']) ) { //appears as a link for users
	 					 	?> <a class="a-phone" title="تقديم طلب شراء " href="order.php?id=<?php echo $value['item_id']?>&t=p&main=p"><i class="fas fa-phone"></i></a> <?php
	 					}else{ //
	 					 	?> <a class="a-phone" href="login.php"><i class="fas fa-phone"></i></a> <?php
	 					} ?>
 					
 					 <div class="bottom-div">
	 					<span class="alone small"><?php if($value['country_id']==1){ echo 'مصر';}  echo '/'.$value['state_nameAR'].'/'.$value['city_nameAR'];?></span>
	 					<?php 
			              if ($value['delivery']==1) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مدفوع داخل  </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
			              if ($value['delivery']==2) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مجاني داخل </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
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
		 	<!--/////////////////////////-->
		  
		 	<?php  } //END foreach
		 	?> </div> <?php
				//===================start pagination=========================	
				    $jumpForward=1;
				 	$jumpBackward=1; 

					if($NumberOfPages>1 ){ 	?>
					 <nav aria-label="Page navigation example" class="pagination-container">
						  <ul class="pagination pagination-md">
						 <?php if(($pageNum-$jumpBackward)>=1 ){  //previous
						 ?> <li class="page-item"><a class="page-link prev" href="?i=<?php echo $id.'&p=favourites&Page='. ($pageNum-$jumpBackward)?>"><?php echo $lang['prev'];?></a></li><?php
					      }else{
					      ?> <li class="page-item disabled"><a class="page-link"><?php echo $lang['prev'];?></a></li><?php
					      }
					      //$page=1; $page<= $NumberOfPages;  $page++
					  for ($page=max(1,$pageNum-2);$page<=min($pageNum+2,$NumberOfPages);$page++) {  //for loop
						if (isset($_GET['Page'])&&$_GET['Page']==$page ) {
							echo   '<li class="page-item"><a class="page-link active" href="profile.php?i='.$id.'&p=favourites&Page='.$page.'">'.$page.'</a></li>';
						}elseif (!isset($_GET['Page'])&&$page==1 ) {
						   echo   '<li class="page-item"><a class="page-link active" href="profile.php?i='.$id.'&p=favourites&Page='.$page.'">'.$page.'</a></li>';
						}else{
							echo   '<li class="page-item"><a class="page-link" href="profile.php?i='.$id.'&p=favourites&Page='.$page.'">'.$page.'</a></li>';
						} }
					    if(($pageNum+$jumpForward)<=$NumberOfPages){  //next
						?> <li class="page-item"> <a class="page-link next"  href="?i=<?php echo $id.'&p=favourites&Page='. ($pageNum+$jumpForward)?>"><?php echo $lang['next'];?></a> </li><?php
					}else{
					   ?> <li class="page-item disabled"> <a class="page-link "><?php echo $lang['last'];?></a> </li><?php
					} ?>  
					    </ul > 
					</nav>
					<?php
					} 
	          ////////////// END pagination //////////////
		 	 }else{ //END if not empty
		 	       echo "<span >لا توجد  اعلانات  مضافة الى المفضلة  </span>";
		 	      } 
			 	



	 }elseif ($p=='bought') { //TRADER
	 	    //pagination data
			$adsPerPage=10;
			//approved orders
			$all_bought_num=countFromDb2('order_id','orders','user_id',$id);
			$NumberOfPages=ceil($all_bought_num/$adsPerPage);
			$pageNum= isset($_GET['Page']) && is_numeric($_GET['Page']) && $_GET['Page']<=$NumberOfPages&& $_GET['Page']>0 ? intval($_GET['Page']) : 1; 
		    $startFrom=($pageNum-1)* $adsPerPage; //

	 		//from orders table
			$stmt=$conn->prepare(" SELECT orders.*,items.*,user.*,state.*,city.* from orders 
			join items on items.item_id=orders.item_id
			join user  on user.user_id =orders.user_id 
			join state on state.state_id=orders.state_id
			join city on city.city_id=orders.city_id
			where orders.user_id=?   order by orders.order_id desc limit $startFrom,$adsPerPage");
			$stmt->execute(array($_SESSION['traderid']));
			$orderst=$stmt->fetchAll();
			$row=$stmt->rowCount(); 
			//all my orders
		    $stmt2=$conn->prepare(' SELECT count(order_id) from orders where user_id=? ');
		    $stmt2->execute(array($_SESSION['traderid']));$count_MyOrders=$stmt2->fetchColumn();
		    //my orders during the last week
		    $stmt=$conn->prepare(' SELECT count(order_id) from orders where user_id=? and order_date > UNIX_TIMESTAMP()-(3600*24*7) ');
		    $stmt->execute(array($_SESSION['traderid']));$count_MyOrders7=$stmt->fetchColumn();
			?>
		<div>
		  <div class="order-main"> 
			<div class="title">
				<div><a href="index.php">الرئيسية</a> > <span> حسابي </span> > <span>مشترياتي  </span></div>
		        <div class="two"><span>كل مشترياتي : <?php echo '('.$count_MyOrders.')';?></span>&emsp;&emsp;&emsp;<span>مشترياتي في آخر أسبوع: <?php echo '('.$count_MyOrders7.')';?></span></div>
		   </div>
		<?php if ($row>0) {  ?>
			<section>
			  <table class="table-trader">
				<thead>
				  <tr>
					<td class="wide">اسم  الاعلان </td>
					<td>السعر قبل الخصم</td>
					<td>نسبة الخصم</td>
					<td>السعر بعد الخصم</td>
					<td class="buyer-head wide">اسم المشتري</td> 
					<td class="buyer-head">تليفون المشتري</td>
					<td class="buyer-head wide">المحافظة - المدينة  </td>
					<td class="buyer-head wide">تاريخ الطلب</td>
					<td class="buyer-head">كود  الخصم  </td>
					<td class="last wide">الحالة </td>
				 </tr>
			</thead>
			<tbody>
				<?php 
			foreach ($orderst as $item) {
				$ratio=$item['price']*($item['discount']/100);
                $finalPrice=round($item['price']-$ratio);
                ?><input type="hidden" class="lang" value="<?php echo $l;?>"> <?php
		         ?>
				<tr>
					<td><a class="cut2 titleLink" href="details.php?id=<?php echo $item['item_id']?>&t=p&main=p"><?php echo $item['title']?></a><input type="hidden" class="idValue" value="<?php echo $item['item_id'];?>"></td>
					<td><s><?php echo $item['price']?></s></td>
					<td><?php echo $item['discount'].'%'?></td>
					<td><?php echo $finalPrice ?></td>
					<td class="buyer-body cut2"><?php echo $item['buyer_name']?></td>
					<td class="buyer-body"><?php echo '0'.$item['buyer_phone']?></td>
					<td class="buyer-body cut2"><?php echo $item['state_nameAR'].'-'.$item['city_nameAR']?></td>
					<td class="buyer-body"><?php echo date('d/m/Y h:i:s A',$item['order_date'])?></td>
					<td class="buyer-body"><?php echo $item['order_code']?></td>
					<td class="last relative"> 
					 <?php 
					 $fectApr=fetch('approve','orders','user_id',$item['user_id']);
					  if($fectApr['approve']==1){ 
							?><span class="blue small">تم قبول الطلب  </span> <?php
							 if($item['report_trader']==0){ ?>
						    <span title="بلغ عن مقدم الخدمة  (يؤدي البلاغ الكاذب الى حظر حسابك)" class="report reportBought" data-bs-toggle="offcanvas" data-bs-target="#canvasReport" aria-controls="canvasReport">تبليغ </span> <input type="hidden" class="order_id" value="<?php echo $item['order_id']?>"> 
						     <!-- start offcanvas to report item -->
			                     <div class="offcanvas" data-bs-scroll="true" tabindex="-1" id="canvasReport" aria-labelledby="offcanvasWithBothOptionsLabel"> 
					                  <div class="offcanvas-header offcanvas-header-report">
					                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
					                  </div> 
					                  <div class="offcanvas-body-report"> 
				                        <span class="report-reason"><?php echo $lang['reportReason']?></span>
						   	    	  	<p>يؤدي البلاغ الكاذب الى حظر الحساب  </p>
						   	    	  	<form id="formReportTr" >
							   	    	  	<input type="hidden" name="user" value="<?php echo $session;?>"><!-- reporter -->
							   	    	  	<input type="hidden" class="order" name="order"> <!-- order_id -->
							   	    	  	<textarea  class="input-report" id="inputReport" name="ReportTr" placeholder="عشرون حرفاً على الأقل  " ></textarea>
							   	    	  	<button type="submit" class="btn-canvas-msg   btn-canvas-report"><?php echo $lang['send']?></button>
							   	    	  	<span class="show-return-report"></span>
						   	    	  	</form>
				                      </div>
				               </div>
			                   <!-- end offcanvas to report item--> 

						    <?php }else{ //cancel report trader
						    	?><a href="process2.php?Bought=<?php echo $item['order_id']?>" class="report">الغاء التبليغ  </a> 
						    <?php }  
					    }
                    else{ ?><span class="red2" >في انتظار الموافقة  </span>&emsp;<a class="report confirmDeleteOrder" href="process2.php?c=cancelOrder&i=<?php echo $item['user_id']?>&r=<?php echo $item['order_id']?>" >الغاء </a><input type="hidden" class="language" value="<?php echo $l;?>"> <?php } 
				    ?>
			      </td> 
				</tr>
				<?php  }  //END if(!empty($orders)&&foreach)?>   
			   </tbody>
			 </table>
		   </section>
		  <?php }else{echo "<span class='right font-size'>لا توجد مشتريات  </span>";} ?>
		 </div> <?php
		  //===================start pagination=========================	
		    $jumpForward=1;
		 	$jumpBackward=1; 

		if($NumberOfPages>1 ){ 	?>
		 <nav aria-label="Page navigation example" class="pagination-container">
			  <ul class="pagination pagination-md">
			 <?php if(($pageNum-$jumpBackward)>=1 ){  //previous
			 ?> <li class="page-item"><a class="page-link prev" href="?i=<?php echo $id.'&p=bought&Page='. ($pageNum-$jumpBackward)?>"><?php echo $lang['prev'];?></a></li><?php
		      }else{
		      ?> <li class="page-item disabled"><a class="page-link"><?php echo $lang['prev'];?></a></li><?php
		      }
		      //$page=1; $page<= $NumberOfPages;  $page++
		  for ($page=max(1,$pageNum-2);$page<=min($pageNum+2,$NumberOfPages);$page++) {  //for loop
			if (isset($_GET['Page'])&&$_GET['Page']==$page ) {
				echo   '<li class="page-item"><a class="page-link active" href="profile.php?i='.$id.'&p=bought&Page='.$page.'">'.$page.'</a></li>';
			}elseif (!isset($_GET['Page'])&&$page==1 ) {
			   echo   '<li class="page-item"><a class="page-link active" href="profile.php?i='.$id.'&p=bought&Page='.$page.'">'.$page.'</a></li>';
			}else{
				echo   '<li class="page-item"><a class="page-link" href="profile.php?i='.$id.'&p=bought&Page='.$page.'">'.$page.'</a></li>';
			} }
		    if(($pageNum+$jumpForward)<=$NumberOfPages){  //next
			?> <li class="page-item"> <a class="page-link next"  href="?i=<?php echo $id.'&p=bought&Page='. ($pageNum+$jumpForward)?>"><?php echo $lang['next'];?></a> </li><?php
		}else{
		   ?> <li class="page-item disabled"> <a class="page-link "><?php echo $lang['last'];?></a> </li><?php
		} ?>  
		    </ul > 
		</nav>
		
	<?php	} ?>
	<!--////////////// END pagination //////////////-->

	  </div><?php
	
  }elseif ($p=='msg') { //trader
  	//from message table
	$stmt=$conn->prepare("  SELECT * from message 
	join user on user.user_id=message.message_to
	where message.message_to=? order by message.message_id desc  " );
	$stmt->execute(array($session));
	$msgs=$stmt->fetchAll();
	$row=$stmt->rowCount(); 
    
    ?>
  	<div class="title"><a href="index.php">الرئيسية</a> > <span> حسابي </span> > <span> رسائلي  </span></div>
    <input type="hidden" class="lang" value="<?php echo $l;?>">
    <span class="right small">يتم حذف الرسائل التي مر عليها أكثر من 15 يوم  </span>
    <div class="order-main order-main-msg "> 
		<section>
         <?php if ($row>0) { ?> 
	  	  	<form action="action.php" method="POST">
	  	  		<button class="confirm button-all btnchk" type="submit">حذف </button>
	  	  	<table class="table-trader credit msg">
             	<thead>
             		<tr>
             			<td class="top-msg"><?php echo $lang['from']?></td>
             			<td class="top-msg"><?php echo $lang['to']?></td>
             			<td class="top-msg">الرسالة </td>
             			<td class="top-msg">التاريخ </td>
             			<td class="top-msg">اجراء  </td>
             		</tr>
             	</thead>
             	<tbody>
		        	<?php foreach ($msgs as $msg) { 
                    $sendee=fetch('commercial_name','user','user_id',$msg['message_to']);
		        	?> 
             		<tr> 
             			<td class=""><?php if($msg['message_from']==7){ echo "ادارة مستفيد ";} ?></td>
             			<td class="cut2"><?php echo $sendee['commercial_name'] ?></td>
             			<td class="long"><?php echo $msg['message_text'] ?></td>
             			<td class="date"><?php echo date('Y-m-d h:i:s A',$msg['message_date']) ?></td>
             			<td><a class="confirm" href="process2.php?msg=del&i=<?php echo $msg['message_id']?>">حذف </a>&emsp;<input class="del-msg"  type="checkbox" name="chkMsg[]" value="<?php echo $msg['message_id'] ?>"></td>
             		</tr>
                  <?php  } ?>

             	</tbody>
             </table> 
         </form>
          <?php  }else{ echo "<span class='alone'>لا توجد رسائل  </span>";} ?>
	    </section>
	</div> 
   
 


 <?php }elseif ($p=='program') { //trader
 	        $prog=fetch('program','user','user_id',$session); 
		  	$fetchPh=fetch('phone','user','user_id',$session);
		  	//$prog_credit=fetch('program_credit','user','user_id',$session);
		  	$PartnerCode=fetch('program','user','user_id',$session);
            //sum partner's values
            $stmt3=$conn->prepare("SELECT sum(program_credit) FROM orders where prog2 !=''  and prog2 = ? and paid=1 ");
			$stmt3->execute(array($PartnerCode['program']));$sum=$stmt3->fetchColumn();
		  	?>
		  	<div class="title program"> 
				<div><a href="index.php">الرئيسية</a> > <span> حسابي </span> > <span>برنامج الشراكة </span></div>
		       

		        <?php
		        if ($prog['program']!=''){ // is participating in program
                   ?><div class="two above"><span class="program">أرباحك : <?php
                    if($sum>19){ echo $sum.' '.'ج.م.'; ?>
                  <hr>
                  <p>سيتم ارسال أرباحك  الى رقم تليفونك المسجل بالموقع  <?php echo ' ('.'0'.$fetchPh['phone'].') '?>عبر فودافون كاش ؛ اذا أردت  أن نرسل أرباحك الى رقم بديل؛ ادخل الرقم البديل  :</p>
                  <p>تتحمل أنت المسؤولية في حالة ادخال رقم تليفون غير صحيح  </p>
                  <form action="reportItem.php" method="POST">
                  	<div>
                  		<span class="program">أدخل الرقم البديل  </span> <input class="inp" type="text" name="alternate" autocomplete="off">
                        <button type="submit" class="button-all">موافق </button>
                  	</div>
                    <input type="hidden" name="user_idProg" value="<?php echo $session;?>">
                  </form>

                
                <?php
                }elseif($sum>0){  ?> <span class="green">رصيدك آخذ في الزيادة </span><p>سيظهر رصيدك هنا عندما يصل للحد الأدنى . راجع تفاصيل البرنامج من  <a href="prizes.php">هنا </a></p><?php
                }else{ echo $sum; } ?> 
              

               </span>
             </div> 
		        <p class="above">رقم الكود الخاص بك في برنامج الشراكة مع مستفيد  <?php echo '('.$prog['program'].')'; ?></p>
              
              <?php  }else{ //END  if ($prog['program']!=''
                          ?><span class="above alone">لم يتم الاشتراك  في البرنامج بعد ؛ للاطلاع على التفاصيل والاشتراك اضغط   <a class="bold" href="prizes.php">هنا  </a></span> <?php
                     }  ?>

		   </div>
 

 <?php }else{ //END if $p=='none'
	    header('location:logout.php?s=no');  
		exit();
      }  


				
			
    ?></div><!--  END profile-container -->  
      <!--ajax coner -->
       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
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
	          data:{item_T:item,user_T:trader,cat:cat,sub:sub,st:state,ci:city},
	          success: function(data){                             
	            $(".sh").html(data); 
	             }
	           });
	          });
		    //get order_id
	          $(".reportBought").on("click", function(){
	          var Ord=$(this).nextAll('.order_id').val();
	          $('.order').val(Ord);
	          });
	         //ajax send canvas report
	          $("#formReportTr").on("submit", function(event){
	           event.preventDefault();
	           var Text=$('#inputReport').val().length;//$('#notPrice').is(':checked') 
	          if( Text>=20 ){
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
	          }else{ //End if
	            $('.btn-canvas-report').addClass('disabled',true);
	             $('.btn-canvas-report').css('cursor','not-allowed');
	          }
	         });
	     //ajax call send item views
		   $('.titleLink').click(function(){
		  var item=$(this).nextAll('.idValue').val();
		  $.ajax({
		  url:"process2.php", 
		  data:{itemView:item}
		     });
		   });//




         });
     </script> 

  <?php
  }else{ //END if (isset($_GET['i'])
    header('location:logout.php?s=no'); 
	exit();
   }   







   /////////////////////  GOOGLE OR EMAIL USER => buyer /////////////////////
  //////////////////////////////////////////////////////////////////
}elseif (isset($_SESSION['userEid']) || isset($_SESSION['userGid']) || isset($_SESSION['userFid'])) {
	if(isset($_SESSION['userEid'])){ $session=$_SESSION['userEid']; }
	elseif(isset($_SESSION['userGid'])){ $session=$_SESSION['userGid']; }
	elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

	if (isset($session)) {
    //if activated==0 => email updated but not verified & if user or trader is banned
    banned($session); 

	if (isset($_GET['i']) && is_numeric($_GET['i']) && $_GET['i']>0 && $_GET['i']==$session ) {
	            $id=intval($_GET['i']); 
	 	?>
                <div class="profile-container">
				<div class="home-profile-link-div">
					<a href="index.php" style="text-decoration: none;vertical-align: super;">
						<!--<i class="fas fa-house-user home-img"></i>-->
						<img class="home-img" src="<?php echo $images ?>home.png">
			        </a><span class="span-heading"> >حسابي</span>
			     </div> 
			     <div class="profile-top">
			     	<a href="?i=<?php echo $id;?>&p=data"><?php if(isset($_GET['p'])&&$_GET['p']=='data'){ ?><span class="focus1">بياناتي</span> <?php }else{ echo 'بياناتي';} ?></a>
			     	<a href="?i=<?php echo $id;?>&p=favourites"><?php if(isset($_GET['p'])&&$_GET['p']=='favourites'){ ?><span class="focus5">المفضلة</span> <?php }else{ echo 'المفضلة';} ?></a>
			     	<a href="?i=<?php echo $id;?>&p=bought"><?php if(isset($_GET['p'])&&$_GET['p']=='bought'){ ?><span class="focus6">مشترياتي  </span> <?php }else{ echo 'مشترياتي  ';} ?></a>
			        <a href="?i=<?php echo $id;?>&p=program"><?php if(isset($_GET['p'])&&$_GET['p']=='program'){ ?><span class="focus8">برنامج الشراكة </span> <?php }else{ echo 'برنامج الشراكة  ';} ?></a>
			     </div>
			     <hr>
			     <?php
			     $p=isset($_GET['p'])?$_GET['p']:'none';
			     if ($p=='data') { //user
                     if (isset($_SESSION['userEid'])) { //EMAIL USERS
				     	$stmt=$conn->prepare(" SELECT * from user 
				     		join country on country.country_id=user.country_id
				     		join state on state.state_id=user.state_id
				     		join city on city.city_id=user.city_id
				     		where user.user_id=$id  ");	
					    $stmt->execute();
					    $user=$stmt->fetch(); ////$user['country_nameAR']
				     	?>  
				     	<div> 
				     	<p>الاسم: <?php echo $user['name']?></p>
				     	<p>الدولة: <?php echo $user['country_nameAR']; ?></p>
				     	<p>المحافظة: <?php echo $user['state_nameAR']?></p>
				     	<p>المدينة: <?php echo $user['city_nameAR']?></p>
				     	<p>التليفون: <?php echo '0'.$user['phone']?></p>
				     	<p>البريد الالكتروني: <?php echo $user['email']?></p>
				     	<p>تاريخ الانضمام:<?php echo $user['reg_date']?></p>
				     	<a href="action-us.php?u=edit-us&id=<?php echo $user['user_id']?>"><?php echo $lang['updateProf']?></a>
				     	<?php  
				     	if (isset($_COOKIE['remember_email']) && $_COOKIE['remember_email']==$user['email'] ) {
				     		?><p><a class="confirmRemove" href="action-us.php?u=no-remember&id=<?php echo $user['user_id'] ?>">الغاء حفظ بيانات الدخول  </a><input type="hidden" class="language" value="<?php echo $l; ?>">
				     			<i title="لا تحتفظ ببيانات تسجيل دخولي على هذا الجهاز  (رقم التليفون وكلمة المرور)" class="fas fa-exclamation-triangle rightx" data-bs-toggle="offcanvas" data-bs-target="#remCanvas" aria-controls="offcanvasWithBothOptions"></i>
                                  
                                  <!--////////////-->
                                  <div class="offcanvas offcanvas-start " id="remCanvas" data-bs-scroll="true" tabindex="-1"  aria-labelledby="offcanvasWithBothOptionsLabel">
						              <div class="offcanvas-header">
						                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
						              </div> 
						              <div class="offcanvas-body">
						                <span>لا تحتفظ ببيانات تسجيل دخولي على هذا الجهاز  (رقم التليفون وكلمة المرور)</span>
						              </div>
						        </div>

                                  <!--////////////-->
				     		 </p><?php
				     	} ?>
				     	<p><a class="alone confirmDeleteAcc" href="action-us.php?u=del-us&id=<?php echo $user['user_id']?>">حذف حسابي  </a><input type="hidden" class="language" value="<?php echo $l;?>"></p>
	                   </div>
			     	
			     <?php	}elseif(isset($_SESSION['userGid'])||isset($_SESSION['userFid'])){ // GOOGLE & FACEBOOK USERS
				     	    $stmt=$conn->prepare(" SELECT * from user where user_id=$id  ");
						    $stmt->execute();
						    $user=$stmt->fetch(); 
					     	?> 
					     	<div> 
					     	<p>الاسم: <?php echo $user['name']?></p> 
					     	<p>الدولة: <?php if($user['country_id']==null){ echo 'غير معروف  '; }else{ echo getCountry($user['country_id'],$l); }  ?></p>
					     	<p>المحافظة: <?php if($user['state_id']==null){ echo 'غير معروف  '; }else{ echo getState($user['state_id'],$l); } ?></p>
					     	<p>المدينة: <?php if($user['city_id']==null){ echo 'غير معروف  '; }else{ echo getCity($user['city_id'],$l); } ?></p>
					     	<p>التليفون: <?php if($user['phone']==0){ echo "غير معروف  ";}else{ echo '0'.$user['phone']; } ?></p>
					     	<?php if(isset($_SESSION['userGid'])){ ?><p>البريد الالكتروني: <?php echo $user['email']?></p><?php } ?>
					     	<p>تاريخ الانضمام:<?php echo $user['reg_date']?></p>
					     	<a href="action-us.php?u=edit-us&id=<?php echo $user['user_id']?>"><?php echo $lang['updateProf']?></a>
					     	<a class="alone confirmDeleteAcc" href="action-us.php?u=del-us&id=<?php echo $user['user_id']?>">حذف حسابي  </a><input type="hidden" class="language" value="<?php echo $l;?>">
					     	
		                   </div>
			         <?php  }



			 }elseif ($p=='favourites') { //user
			 	   //pagination data
					$adsPerPage=16;
					//approved orders
					$all_favourite_num=countFromDb3('favourite_id','favourite','user_id',$session,'favourite_status',1);
					$NumberOfPages=ceil($all_favourite_num/$adsPerPage);
					$pageNum= isset($_GET['Page']) && is_numeric($_GET['Page']) && $_GET['Page']<=$NumberOfPages&& $_GET['Page']>0 ? intval($_GET['Page']) : 1; 
				    $startFrom=($pageNum-1)* $adsPerPage; //

			 	$stmt=$conn->prepare(" SELECT categories.*,sub.*,state.*,city.*,items.*,user.*,favourite.* from favourite 
		     		join categories on categories.cat_id=favourite.cat_id
		     		join sub on sub.subcat_id=favourite.subcat_id
		     		join state on state.state_id=favourite.state_id
		     		join city on city.city_id=favourite.city_id
		     		join items on items.item_id=favourite.item_id
		     		join user on user.user_id=favourite.user_id
		     		where favourite.user_id=? and favourite_status>0 limit $startFrom,$adsPerPage");	
			    $stmt->execute(array($session));  
			    $traders=$stmt->fetchAll();

                ?><div class="title">
                	<div><a href="index.php">الرئيسية</a> > <span> حسابي </span> > <span> المفضلة  </span></div>
                    <div class="two"><span>مضاف الى المفضلة  <?php echo '('.$all_favourite_num.')' ?></span></div>
                </div>
			 	 <div class="items-container  items-container-profile"> <?php
			 	   	    
			 	   	     if (!empty($traders)) { 
			 			foreach ($traders as $value) { 
		 				$ratio=$value['price']*($value['discount']/100);
                        $finalPrice=round($value['price']-$ratio);
                        $fetch2=fetch('user_id','items','item_id',$value['item_id']);
		 				?>
		 				<!--////////////////////////-->
			 		<div class="repeated-cont repFav  repeated-cont-profile">
				      <!-- bring ads on clicking on aside links-->
				      <div class="div-img-disc">
				    	<span title="خصم" class="disc"><?php echo $value['discount'].'%'.' -' ?></span>
				        <?php
			            if (isset($session) ) { 
			        	  $fetchFav=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$session);
				        	if($fetchFav['favourite_status']==1){ 
				        	   ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
				        	}else{ 
				        		?><i title="حفظ "  class="fas fa-heart fav fav_E grey"></i><?php
				        	 } ?>
				        	    <input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
					        	<input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
					        	<input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
					        	<input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
					        	<input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
				                <input type="hidden" class="user" value="<?php echo $session;?>">
                            <?php
			          }else{ ?><a href="login.php"><i class="fas fa-heart grey2"></i></a>  <?php }  ?> 
				       
				        <img src="data\upload\<?php echo $value['photo']?>">
				      </div>
			        <section>
					   <span class="alone small cut2"><?php echo $value['cat_nameAR'].'>'.$value['subcat_nameAR'];?></span>
	 					<a href="details.php?id=<?php echo $value['item_id']?>&t=p&main=p" class="p-title cut2 alone font1 titleLink"><?php echo $value['title'] ?></a>
	 					<input type="hidden" class="idValue" value="<?php echo $value['item_id'];?>">
	 					<p class="date"><i class="fas fa-calendar"></i><?php echo ' '.$value['item_date'].' '; if($value['sit']==1){ echo "المعلن هو المالك  ";}elseif($value['sit']==2){ echo "السعر شامل أجر الوسيط  ";} ?></p>
	 					<div class="finalPrice-div">
	 						<s><?php echo $value['price']?></s>
	 						<span>ج.م.</span>
	 						<span>
	 							<span class="bold"><?php echo $finalPrice ?></span>
	 						    <span>ج.م.</span>
	 						</span>
	 					</div>
	 						<?php
		 					if (isset($session) ) { //appears as a link for users
		 					 	?> <a class="a-phone" title="تقديم طلب شراء " href="order.php?id=<?php echo $value['item_id']?>&t=p&main=p"><i class="fas fa-phone"></i></a> <?php
		 					}else{ //
		 					 	?> <a class="a-phone" href="login.php"><i class="fas fa-phone"></i></a> <?php
		 					} ?>
	 					
	 					 <div class="bottom-div">
		 					<span class="alone small"><?php if($value['country_id']==1){ echo 'مصر';}  echo '/'.$value['state_nameAR'].'/'.$value['city_nameAR'];?></span>
		 					<?php 
				              if ($value['delivery']==1) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مدفوع داخل  </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
				              if ($value['delivery']==2) { ?><span class="alone deliv"><span><i title="توصيل " class="fas fa-truck"></i>مجاني داخل </span><span><?php echo $value['state_nameAR'] ?></span></span> <?php }
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
			 	<!--/////////////////////////-->
			  
			 	 
			 	<?php  } //END foreach
			 	 }else{ //END if not empty
			 	       echo "<div class='noAds height'>لا توجد اعلانات مضافة الى المفضلة</div>";
			 	      } 
			 	?> </div> <?php
			 	//===================start pagination=========================	
				    $jumpForward=1;
				 	$jumpBackward=1; 

					if($NumberOfPages>1 ){ 	?>
					 <nav aria-label="Page navigation example" class="pagination-container">
						  <ul class="pagination pagination-md">
						 <?php if(($pageNum-$jumpBackward)>=1 ){  //previous
						 ?> <li class="page-item"><a class="page-link prev" href="?i=<?php echo $id.'&p=favourites&Page='. ($pageNum-$jumpBackward)?>"><?php echo $lang['prev'];?></a></li><?php
					      }else{
					      ?> <li class="page-item disabled"><a class="page-link"><?php echo $lang['prev'];?></a></li><?php
					      }
					      //$page=1; $page<= $NumberOfPages;  $page++
					  for ($page=max(1,$pageNum-2);$page<=min($pageNum+2,$NumberOfPages);$page++) {  //for loop
						if (isset($_GET['Page'])&&$_GET['Page']==$page ) {
							echo   '<li class="page-item"><a class="page-link active" href="profile.php?i='.$id.'&p=favourites&Page='.$page.'">'.$page.'</a></li>';
						}elseif (!isset($_GET['Page'])&&$page==1 ) {
						   echo   '<li class="page-item"><a class="page-link active" href="profile.php?i='.$id.'&p=favourites&Page='.$page.'">'.$page.'</a></li>';
						}else{
							echo   '<li class="page-item"><a class="page-link" href="profile.php?i='.$id.'&p=favourites&Page='.$page.'">'.$page.'</a></li>';
						} }
					    if(($pageNum+$jumpForward)<=$NumberOfPages){  //next
						?> <li class="page-item"> <a class="page-link next"  href="?i=<?php echo $id.'&p=favourites&Page='. ($pageNum+$jumpForward)?>"><?php echo $lang['next'];?></a> </li><?php
					}else{
					   ?> <li class="page-item disabled"> <a class="page-link "><?php echo $lang['last'];?></a> </li><?php
					} ?>  
					    </ul > 
					</nav>
					<?php
					} 
	          ////////////// END pagination //////////////



			   }elseif ($p=='bought') { //user
			   	      //pagination data
						$adsPerPage=10;
						//approved orders
						$all_bought_num=countFromDb2('order_id','orders','user_id',$id);
						$NumberOfPages=ceil($all_bought_num/$adsPerPage);
						$pageNum= isset($_GET['Page']) && is_numeric($_GET['Page']) && $_GET['Page']<=$NumberOfPages&& $_GET['Page']>0 ? intval($_GET['Page']) : 1; 
					    $startFrom=($pageNum-1)* $adsPerPage; //

			         //from orders table
					$stmt=$conn->prepare(" SELECT orders.*,items.*,user.*,state.*,city.* from orders 
					join items on items.item_id=orders.item_id
					join user  on user.user_id =orders.user_id 
					join state on state.state_id=orders.state_id
					join city on city.city_id=orders.city_id
					where orders.user_id=?   order by orders.order_id desc limit $startFrom,$adsPerPage");
					$stmt->execute(array($session));
					$orderst=$stmt->fetchAll();
					$row=$stmt->rowCount(); 
					//all my orders
				    $stmt2=$conn->prepare(' SELECT count(order_id) from orders where user_id=? ');
				    $stmt2->execute(array($session));$count_MyOrders=$stmt2->fetchColumn();
				    //my orders during the last week
				    $stmt=$conn->prepare(' SELECT count(order_id) from orders where user_id=? and order_date > UNIX_TIMESTAMP()-(3600*24*7) ');
				    $stmt->execute(array($session));$count_MyOrders7=$stmt->fetchColumn();
					?>
				<div>
				  <div class="order-main"> 
					<div class="title">
						<div><a href="index.php">الرئيسية</a> > <span> حسابي </span> > <span>مشترياتي  </span></div>
				        <div class="two"><span>كل مشترياتي : <?php echo '('.$count_MyOrders.')';?></span>&emsp;&emsp;&emsp;<span>مشترياتي في آخر أسبوع: <?php echo '('.$count_MyOrders7.')';?></span></div>
				    </div>
				<?php if ($row>0) {  ?>
					<section>
						<table class="table-trader table-bought">
							<thead>
								<tr>
							<td class="wide3 cut2">اسم  الاعلان </td>
							<td>السعر قبل الخصم</td>
							<td>نسبة الخصم</td>
							<td>السعر بعد الخصم</td>
							<td class="buyer-head wide">اسم المشتري</td> 
							<td class="buyer-head">تليفون المشتري</td>
							<td class="buyer-head wide">المحافظة - المدينة  </td>
							<td class="buyer-head wide">تاريخ الطلب</td>
							<td class="buyer-head">كود  الخصم  </td>
							<td class="last wide">الحالة </td>
						</tr>
					</thead>
					<tbody>
						<?php 
					foreach ($orderst as $item) {
						$ratio=$item['price']*($item['discount']/100);
		                $finalPrice=round($item['price']-$ratio);
		                ?><input type="hidden" class="lang" value="<?php echo $l;?>"> <?php
				         ?>
						<tr>
							<td class="cut2"><a class="cut2 titleLink" href="details.php?id=<?php echo $item['item_id']?>&t=p&main=p"><?php echo $item['title']?></a><input type="hidden" class="idValue" value="<?php echo $item['item_id'];?>"></td>
							<td><s><?php echo $item['price']?></s></td>
							<td><?php echo $item['discount'].'%'?></td>
							<td><?php echo $finalPrice ?></td>
							<td class="buyer-body cut2"><?php echo $item['buyer_name']?></td>
							<td class="buyer-body"><?php echo '0'.$item['buyer_phone']?></td>
							<td class="buyer-body cut2"><?php echo $item['state_nameAR'].'-'.$item['city_nameAR']?></td>
							<td class="buyer-body"><?php echo date('d/m/Y h:i:s A',$item['order_date'])?></td>
							<td class="buyer-body"><?php echo $item['order_code']?></td>
							<td class="last">
							<?php 
							$fectApr=fetch('approve','orders','order_id',$item['order_id']);
							if($fectApr['approve']==1){ 
								?><span class="blue small">تم قبول الطلب  </span> <?php
								 if($item['report_trader']==0){ ?>
							    <span title="بلغ عن مقدم الخدمة  (يؤدي البلاغ الكاذب الى حظر حسابك)" class="report reportBought" data-bs-toggle="offcanvas" data-bs-target="#canvasReport" aria-controls="canvasReport">تبليغ </span> <input type="hidden" class="order_id" value="<?php echo $item['order_id']?>"> 
							     <!-- start offcanvas to report item -->
				                     <div class="offcanvas" data-bs-scroll="true" tabindex="-1" id="canvasReport" aria-labelledby="offcanvasWithBothOptionsLabel"> 
						                  <div class="offcanvas-header offcanvas-header-report">
						                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
						                  </div>
						                  <div class="offcanvas-body-report"> 
					                        <span class="report-reason"><?php echo $lang['reportReason']?></span>
							   	    	  	<form id="formReportTr" >
								   	    	  	<input type="hidden" name="user" value="<?php echo $session;?>"><!-- reporter -->
								   	    	  	<input type="hidden" class="order" name="order"> <!-- order_id -->
								   	    	  	<textarea  class="input-report" id="inputReport" name="ReportTr" placeholder="عشرون حرفاً على الأقل  " ></textarea>
								   	    	  	<button type="submit" class="btn-canvas-msg   btn-canvas-report"><?php echo $lang['send']?></button>
								   	    	  	<span class="show-return-report"></span>
							   	    	  	</form>
					                      </div>
					               </div>
				                   <!-- end offcanvas to report item--> 

							    <?php }else{ //cancel report trader
							    	?><a href="process2.php?Bought=<?php echo $item['order_id']?>" class="report">الغاء التبليغ  </a> 
							    <?php }  
						    }
		                    else{ ?><span class="red2" >في انتظار الموافقة  </span>&emsp;<a class="report confirmDeleteOrder" href="process2.php?c=cancelOrder&i=<?php echo $item['user_id']?>&r=<?php echo $item['order_id']?>" >الغاء </a><input type="hidden" class="language" value="<?php echo $l;?>"> <?php }  
						    ?>
					        </td> 
						  </tr>
						 <?php  }  //END if(!empty($orders)&&foreach)?>   
					    </tbody>
				  	   </table>
				      </section>
				     <?php }else{echo "<span class='right font-size'>لا توجد مشتريات  </span>";} ?>
						 </div><?php
						 //===================start pagination=========================	
							    $jumpForward=1;
							 	$jumpBackward=1; 

							if($NumberOfPages>1 ){ 	?>
							 <nav aria-label="Page navigation example" class="pagination-container">
								  <ul class="pagination pagination-md">
								 <?php if(($pageNum-$jumpBackward)>=1 ){  //previous
								 ?> <li class="page-item"><a class="page-link prev" href="?i=<?php echo $id.'&p=bought&Page='. ($pageNum-$jumpBackward)?>"><?php echo $lang['prev'];?></a></li><?php
							      }else{
							      ?> <li class="page-item disabled"><a class="page-link"><?php echo $lang['prev'];?></a></li><?php
							      }
							      //$page=1; $page<= $NumberOfPages;  $page++
							  for ($page=max(1,$pageNum-2);$page<=min($pageNum+2,$NumberOfPages);$page++) {  //for loop
								if (isset($_GET['Page'])&&$_GET['Page']==$page ) {
									echo   '<li class="page-item"><a class="page-link active" href="profile.php?i='.$id.'&p=bought&Page='.$page.'">'.$page.'</a></li>';
								}elseif (!isset($_GET['Page'])&&$page==1 ) {
								   echo   '<li class="page-item"><a class="page-link active" href="profile.php?i='.$id.'&p=bought&Page='.$page.'">'.$page.'</a></li>';
								}else{
									echo   '<li class="page-item"><a class="page-link" href="profile.php?i='.$id.'&p=bought&Page='.$page.'">'.$page.'</a></li>';
								} }
							    if(($pageNum+$jumpForward)<=$NumberOfPages){  //next
								?> <li class="page-item"> <a class="page-link next"  href="?i=<?php echo $id.'&p=bought&Page='. ($pageNum+$jumpForward)?>"><?php echo $lang['next'];?></a> </li><?php
							}else{
							   ?> <li class="page-item disabled"> <a class="page-link "><?php echo $lang['last'];?></a> </li><?php
							} ?>  
							    </ul > 
							</nav>
							
						<?php	} ?>
						<!--////////////// END pagination //////////////-->

					  </div><?php
					
				  }elseif ($p=='program') { //user
				  	$prog=fetch('program','user','user_id',$session); 
				  	$fetchPh=fetch('phone','user','user_id',$session);
				  	$PartnerCode=fetch('program','user','user_id',$session);
		            //sum partner's values
		            $stmt3=$conn->prepare("SELECT sum(program_credit) FROM orders where prog2 !=''  and prog2 = ? and paid=1 ");
					$stmt3->execute(array($PartnerCode['program']));$sum=$stmt3->fetchColumn();
				  	?>
				  	<div class="title program"> 
						<div><a href="index.php">الرئيسية</a> > <span> حسابي </span> > <span>برنامج الشراكة </span></div>
				       
				        <?php
				        if ($prog['program']!=''){ // is participating in program
		                   ?><div class="two above"><span class="program">أرباحك : <?php
		                    if($sum>19){ echo $sum.' '.'ج.م.'; ?>
		                  <hr>
		                  <p>سيتم ارسال أرباحك  الى رقم تليفونك المسجل بالموقع  <?php echo ' ('.'0'.$fetchPh['phone'].') '?>عبر فودافون كاش ؛ اذا أردت  أن نرسل أرباحك الى رقم بديل؛ ادخل الرقم البديل  :</p>
		                  <p>تتحمل أنت المسؤولية في حالة ادخال رقم تليفون غير صحيح  </p>
		                  <form action="reportItem.php" method="POST">
		                  	<div>
		                  		<span class="program">أدخل الرقم البديل  </span> <input class="inp" type="text" name="alternate" autocomplete="off">
		                        <button type="submit" class="button-all">موافق </button>
		                  	</div>
		                    <input type="hidden" name="user_idProg" value="<?php echo $session;?>">
		                  </form>
		                
		                <?php
		                }elseif($sum>0){  ?> <span class="green">رصيدك آخذ في الزيادة </span><p>سيظهر رصيدك هنا عندما يصل للحد الأدنى . راجع تفاصيل البرنامج من  <a href="prizes.php">هنا </a></p><?php
		                }else{ echo $sum; } ?> 
		              
		               </span>
		             </div> 
				        <p class="above">رقم الكود الخاص بك في برنامج الشراكة مع مستفيد  <?php echo '('.$prog['program'].')'; ?></p>
		              
		              <?php  }else{ //END  if ($prog['program']!=''
		                          ?><span class="above alone">لم يتم الاشتراك  في البرنامج بعد ؛ للاطلاع على التفاصيل والاشتراك اضغط   <a class="bold" href="prizes.php">هنا  </a></span> <?php
		                     }  ?>
				   </div>



			 <?php }else{ //END if $p=='none'
				  header('location:logout.php?s=no'); 
				  exit();
			  } 

     	      ////////////////////
      
            ?></div><!--  END profile-container -->
            <!--ajax coner -->
		       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
		       <script>
		       $(document).ready(function(){
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
		          data:{item_E:item,user_E:user,cat_E:cat,sub_E:sub,st_E:state,ci_E:city},
		          success: function(data){                             
		            $(".sh").html(data);
		             }
		           });
		         });
		         //get order_id
		          $(".reportBought").on("click", function(){
		          var Ord=$(this).nextAll('.order_id').val();
		          $('.order').val(Ord);
                   $('#inputReport').focus();
		          });
		         //ajax send canvas report
		          $("#formReportTr").on("submit", function(event){
		           event.preventDefault();
		           var Text=$('#inputReport').val().length;//$('#notPrice').is(':checked') 
                  if( Text>=20 ){
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
		          }else{ //End if
                    $('.btn-canvas-report').addClass('disabled',true);
		          }
		         });
		          //ajax call send item views
				   $('.titleLink').click(function(){
				  var item=$(this).nextAll('.idValue').val();
				  $.ajax({
				  url:"process2.php", 
				  data:{itemView:item}
				     });
				   });
				   //



		         });
		     </script>



   <?php  }else{ //END if (isset($_GET['i'])
		        header('location:logout.php?s=no'); 
				exit();
	       }
	    }else{ //END if (isset($session)) 
	    	header('location:logout.php?s=no'); 
			exit();
	    } 
}else{ //END elseif (isset($_SESSION['userEid')||(isset($_SESSION['userGid')
	header('location:logout.php?s=no'); 
	exit();
}  


 
 include  $tmpl ."footer.inc";
 include 'foot.php';
 ob_end_flush();
