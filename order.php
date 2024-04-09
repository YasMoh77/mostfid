<?php
ob_start();
session_start();
$title=' معاينة الطلب   ';       //title of the page
include 'init.php';



if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

if ($session) {
  //if activated==0 => email updated but not verified & if user or trader is banned end session & kick out
  banned($session); 

if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id']>0 ) {
	$id=intval($_GET['id']);
  $q=isset($_GET['q'])&&$_GET['q']>0?$_GET['q']:1;
	$ITEMS=items('items.item_id',$id);   
  
  
 ///////////////
  //google comers who have no data are refused to place orders
  $fetchbuyer=fetch('*','user','user_id',$session); 
  if ($fetchbuyer['country_id']==null || $fetchbuyer['state_id']==null || $fetchbuyer['city_id']==null) {
     $_SESSION['comingFromOrderPage']=$id;
     ?><script>location.href='action-us.php?u=edit-us&id=<?php echo $session?>';</script> <?php
   } 

  $stmt=$conn->prepare("SELECT * FROM user 
    join country on user.country_id=country.country_id
    join state on user.state_id=state.state_id
    join city on user.city_id=city.city_id
    WHERE user.user_id = ?");
  $stmt->execute(array($session)); 
  $buyer=$stmt->fetch();

	    
     
     /////session cart
  if (isset($_SESSION['cart'][$id])) {
       $prev=$_SESSION['cart'][$id]['q'];
       $_SESSION['cart'][$id]=array('id'=>$id,'q'=>$prev+$q);
       echo 'q='.$_SESSION['cart'][$id]['q'];
    }else{
      $_SESSION['cart'][$id]=array('id'=>$id,'q'=>$q);
       echo 'qnew='.$_SESSION['cart'][$id]['q'];
    }
  
  
  if (isset($_GET['empty'])) { unset($_SESSION['cart']); } //empty all cart 
  if (isset($_GET['remove'])) { $rem=$_GET['remove'];unset($_SESSION['cart'][$rem]);} //empty only one item from cart    
?>
<div class="order-main"> <?php  
  ////////////////////// 
        /* if (isset($_GET['t'])&&$_GET['t']=='s' ) { ?>
          <div class="above-details-main">
            <?php if(isset($_GET['main'])&&$_GET['main']=='g' ){ 
              $link='&t=s&main=g';
              ?><a class="main-link" href="general.php">الرئيسية </a> > 
              <a class="main-link" href="search.php?cat=0&state=0&ordering=1&main=g">بحث </a> >
              <input type="hidden" id="linkEmpty" value="<?php echo $link;?>">
              <?php 
            }elseif(isset($_GET['main'])&&$_GET['main']=='v'){ 
              $link='&t=s&main=v';
              ?><a class="main-link" href="service.php">الرئيسية </a> > 
              <a class="main-link" href="search-v.php?cat=0&state=0&ordering=1&main=v">بحث </a> >
              <input type="hidden" id="linkEmpty" value="<?php echo $link;?>">
            <?php 
            }else{ header('location:logout.php?s=no'); exit(); } ?>
            <span>معاينة الطلب  </span>
          </div> 

        <?php }elseif(isset($_GET['t'])&&$_GET['t']=='i'){ ?> 
          <div class="above-details-main">
            <?php if(isset($_GET['main'])&&$_GET['main']=='g' ){ ?><a class="main-link" href="general.php">الرئيسية </a> > <?php  $link='&t=i&main=g';?><input type="hidden" id="linkEmpty" value="<?php echo $link;?>"> <?php 
             }elseif(isset($_GET['main'])&&$_GET['main']=='v'){ ?><a class="main-link" href="service.php">الرئيسية </a> > <?php  $link='&t=i&main=v';?><input type="hidden" id="linkEmpty" value="<?php echo $link;?>"> <?php  
             }else{ header('location:logout.php?s=no'); exit(); } ?>
            <span>معاينة الطلب  </span>
            <input type="hidden" id="linkEmpty" value="<?php echo $link;?>">
          </div> 
        <?php  }elseif (isset($_GET['t'])&&$_GET['t']=='p') {  ?>
             <div class="above-details-main">
              <a class="main-link" href="index.php">الرئيسية </a> > <a class="main-link" href="profile.php?i=<?php echo $session;?>&p=favourites">حسابي  </a> >
              <span>معاينة الطلب  </span>
             </div>
      <?php }else{
                     header('location:logout.php?s=no');
                     exit();
                } */




   if(isset($_SESSION['cart'])&&count($_SESSION['cart'])>0){ ?>
<form id="order">
	<section>
		<table class="table-buyer table-buyer-dt order-pg"> 
			<thead>
				<tr>
          <td>م </td>
					<td class="wide">صورة الاعلان  </td>
					<td class="wide2 cut2">اسم الاعلان  </td>
					<td class="cut2">الفئة</td>
					<td class="cut2">الفئة الفرعية</td>
					<td class="wide2 cut2">المحافظة - المدينة</td>
					<td>السعر قبل الخصم</td>
					<td>السعر بعد الخصم</td>
					<td>نسبة الخصم</td>
          <td class="wide2">التوصيل </td> 
					<td>الغاء</td> 
				</tr>
			</thead>
			<tbody>
         <?php
           $n=1; 
         foreach ($_SESSION['cart'] as $key => $val) {  
      $ITEMS=items('items.item_id',$key); 
      foreach ($ITEMS[0] as  $item) {  
      //price after discount
      $ratio=$item['price']*($item['discount']/100);
      $finalPrice1=round($item['price']-$ratio);
      $finalPrice=number_format($finalPrice1);

         ?> 
				<tr>
          <td><?php echo $n; ?></td>
					<td><img src="data\upload\<?php echo $item['photo']?>"></td>
					<td class="cut2 long"><?php echo $item['title']?></td>
					<td class="cut2"><?php echo $item['cat_nameAR']?></td>
					<td class="cut2 long"><?php echo $item['subcat_nameAR']?></td>
					<td class="cut2 long"><?php echo $item['state_nameAR'].'-'.$item['city_nameAR']?></td>
					<td><s><?php echo number_format($item['price']);?></s></td>
					<td><?php echo $finalPrice ?></td>
					<td><?php echo $item['discount'].'%'?></td> 
          <?php $del=fetch('delivery','items','item_id',$key); if($del['delivery']<9){ 
            if($item['delivery']==1){ ?><td>داخل  محافظة <?php echo $item['state_nameAR'] ?>بمقابل  </td> <?php }
            if($item['delivery']==2){ ?><td>داخل   محافظة <?php echo $item['state_nameAR'] ?>  مجانا  </td> <?php }
            if($item['delivery']==3){ ?><td>داخل  مدينة <?php echo $item['city_nameAR'] ?> بمقابل  </td> <?php }
            if($item['delivery']==4){ ?><td>داخل  مدينة <?php echo $item['city_nameAR'] ?> مجانا </td> <?php }
            if($item['delivery']==5){ ?><td><?php echo $item['city_nameAR'] ?> مجانا  و محافظة <?php echo ' '.$item['state_nameAR'].' ' ?>بمقابل  </td> <?php }
            if($item['delivery']==6){ ?><td><?php echo $item['city_nameAR'] ?>  مجانا  وكل المحافظات بمقابل  </td> <?php }
            if($item['delivery']==7){ ?><td>لجميع المحافظات بمقابل  </td> <?php }
            if($item['delivery']==8){ ?><td>لجميع المحافظات  مجانا</td> <?php }
            }else{ ?><td> ــــ </td> <?php }
           ?>
           <!--<td><input class="number" type="number" name="num[]" value="1" min="1" max="3"></td>-->
          <td class="remove"><a href="order.php?id=<?php echo $key; ?>&remove=<?php echo $key/*.$link*/; ?>" ><i class="fas fa-trash"></i></a></td>
				</tr>
        <?php $n++; 
            //<!-- hidden values -->
            /* fetch trader phone */
           $trPhone=fetch('phone','user','user_id',$item['user_id']); 
           ?>
        <input type="hidden" name="trader[]" value="<?php echo $item['user_id']?>">
        <input type="hidden" name="traderPhone[]" value="<?php echo $trPhone['phone']?>">
        <input type="hidden" name="item[]" value="<?php echo $item['item_id']?>">
        <input type="hidden" name="cat[]" value="<?php echo $item['cat_id']?>">
        <input type="hidden" name="sub[]" value="<?php echo $item['subcat_id']?>">
      <?php } } // END foreach & foreach ?>
			</tbody>
		</table>
	</section>
 


      <div class="order-flex">
        <div><?php //the 3 links below table
        if (isset($_GET['t'])&&$_GET['t']=='s' ) { //coming from search page 
           if (isset($_GET['main'])&&$_GET['main']=='g' ) {
            // $link='&t=s&main=g';
             ?><i class="fas fa-plus"></i><a href="search.php?cat=0&state=0&ordering=1&main=g"> اضافة المزيد من الطلبات  </a> <?php
           }elseif (isset($_GET['main']) && $_GET['main']=='v') {
              //$link='&t=s&main=v';
             ?><i class="fas fa-plus"></i><a href="search-v.php?cat=0&state=0&ordering=1&main=v"> اضافة المزيد من الطلبات  </a><?php
           }

        }elseif (isset($_GET['t'])&&$_GET['t']=='i' ) { //coming from homepage 
          if (isset($_GET['main'])&&$_GET['main']=='g' ) {
             // $link='&t=i&main=g';
             ?><i class="fas fa-plus"><a href="general.php"></i> اضافة المزيد من الطلبات  </a> <?php
           }elseif (isset($_GET['main']) && $_GET['main']=='v') {
              //$link='&t=i&main=v';
             ?><i class="fas fa-plus"><a href="service.php"></i> اضافة المزيد من الطلبات  </a><?php 
           }
        } ?> 
         <i class="fas fa-plus"><a href="index.php"></i> اضافة المزيد من الطلبات  </a> 
       </div>
      	<div class="empty" ><i class="fas fa-times"><a href="order.php?id=<?php echo $key.'&empty=e'/*.$link*/; ?>"></i> الغاء جميع الطلبات  </a></div>
        <div><i class="fas fa-check"></i><a href="cart.php?d=fulfil<?php //echo $link; ?>"> التقدم لاتمام الطلب  </a></div>
    </div><!-- end flex -->
	</div>
</div>
</form>
	 <?php
     //counter eye to count page visits 
      include 'counter.php';
      echo '<span class="eye-counter" id="'.$_SESSION['counterOrder'].'"></span>'; 
      ?>


  <?php }else{ ?> <div class="height centered font-med above-lg no">لا توجد طلبات  شراء </div><?php } //END if(count($_session['cart'])) ?>  
      <!--ajax coner -->
      <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
      <script>
      $(document).ready(function(){
        //ajax call send page views  
        var eye=$('.eye-counter').attr('id');
        $.ajax({
        url:"counterInsert.php",
        data:{order:eye}
         });
      
      

            });
        </script>

        
  <?php   }else{ //END if isset($_GET[''])
    	     echo "<div class='block2-search'>عفوا؛ لم نعثر على هذا الاعلان  </div>";
         }

 }else{ header('location:index.php');exit();} //END session


 include  $tmpl ."footer.inc";
 include 'foot.php';
 ob_end_flush();
  