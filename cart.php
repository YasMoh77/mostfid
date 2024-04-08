<?php
ob_start();
session_start();
$title='اتمام  الطلب  ';       //title of the page
include 'init.php';
 


if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

if ($session) {
  //if activated==0 => email updated but not verified & if user or trader is banned
  banned($session);
  
if ((isset($_GET['d']) && $_GET['d']=='fulfil' || isset($_GET['remove'])) || isset($_GET['d']) && $_GET['d']=='fulfil'&& isset($_GET['t'])&&($_GET['t']=='s'||$_GET['t']=='i') || isset($_GET['main'])&&($_GET['main']=='i'||$_GET['main']=='v') ) {
  if (isset($_GET['empty'])) { unset($_SESSION['cart']);}  //empty all cart
  if (isset($_GET['remove'])) { $rem=$_GET['remove'];unset($_SESSION['cart'][$rem]); }//empty only one item from cart 
 

  $stmt=$conn->prepare("SELECT * FROM user 
    join country on user.country_id=country.country_id
    join state on user.state_id=state.state_id
    join city on user.city_id=city.city_id
    WHERE user.user_id = ?");
  $stmt->execute(array($session)); 
  $buyer=$stmt->fetch();

  
    ?> 
    <div class="order-main cart"><?php 
      //
      if (isset($_GET['t'])&&$_GET['t']=='s' ) { //coming from search page 
       if (isset($_GET['main'])&&$_GET['main']=='g' ) {
         $link='&t=s&main=g';
         ?><p class="right"><a class="main-link" href="general.php">الرئيسية  </a> > <a class="main-link" href="search.php?cat=0&state=0&ordering=1&main=g">بحث  </a> > <span>إتمام الطلب  </span></p> <?php
       }elseif (isset($_GET['main']) && $_GET['main']=='v') {
          $link='&t=s&main=v';
         ?><p class="right"><a class="main-link" href="general.php">الرئيسية  </a> > <a class="main-link" href="search-v.php?cat=0&state=0&ordering=1&main=v">بحث  </a> > <span>إتمام الطلب  </span></p><?php
       }

    }elseif (isset($_GET['t'])&&$_GET['t']=='i' ) { //coming from homepage 
      if (isset($_GET['main'])&&$_GET['main']=='g' ) {
          $link='&t=i&main=g';
         ?><p class="right"><a class="main-link" href="general.php">الرئيسية  </a> > <span>إتمام الطلب  </span></p><?php
       }elseif (isset($_GET['main']) && $_GET['main']=='v') {
          $link='&t=i&main=v';
         ?><p class="right"><a class="main-link" href="service.php">الرئيسية  </a> > <span>إتمام الطلب  </span></p><?php
       }
    } 
} //END if ((isset($_GET['d']) && $_GET['d']=='fulfil'  ?> 
  
  
<form id="order" action="orderForm.php" method="POST">
  <?php  if(isset($_SESSION['cart'])&& count($_SESSION['cart'])>0){  ?>
<section>
		<table class="cart-table">
			<thead>
				<tr>
					<td class="cut2">اسم الاعلان   </td>
					<td>السعر بعد الخصم  </td>
          <td>الكمية  </td> 
          <td>الاجمالي  </td> 
					<td>الغاء </td> 
				</tr>
			</thead>
			<tbody>
         <?php
        $total=0;
         foreach ($_SESSION['cart'] as $key => $val ) {  
                    //google comers who have no data are refused to place orders
                    $fetchbuyer=fetch('*','user','user_id',$session); 
                    if ($fetchbuyer['country_id']==null || $fetchbuyer['state_id']==null || $fetchbuyer['city_id']==null) {
                     $_SESSION['comingFromOrderPage']=$key;
                     ?><script>location.href='action-us.php?u=edit-us&id=<?php echo $session?>';</script> <?php
                     } 

                    // 
                $ITEMS=items('items.item_id',$key); 
                foreach ($ITEMS[0] as  $item) {  
                          //price after discount
                          $ratio=$item['price']*($item['discount']/100);
                          $finalPrice1=round($item['price']-$ratio);
                          $finalPrice=$finalPrice1;
                          
                             ?>
                    				<tr>
                    					<td class="cut2 title"><?php echo $item['title']?></td>
                    					<td><input type="text" class="final" value="<?php echo $finalPrice ?>" disabled><?php// echo $finalPrice ?></td>
                              <td>
                              <?php if( ($item['cat_id']!=7&&$item['cat_id']!=8&&$item['cat_id']<12)||$item['subcat_id']==52||$item['subcat_id']==57||$item['subcat_id']==62||$item['subcat_id']==64||$item['subcat_id']==65){ 
                                   
                                 ?><input type="text" class="pickNum width10" name="num[]" value="<?php echo $val['q']; ?>" readonly> <?php
                                   
                               }else{ ?><input type="hidden" name="num[]" value="1"><span>-</span> <?php }
                               
                               ?> 
                               </td>
                              <td class="total"><?php echo $finalPrice*$val['q'] ?></td>
                    					<td><a href="?id=<?php echo $key; ?>&remove=<?php echo $key.$link;?>"><i onclick="return confirm('هل ترغب في الحذف؟')" class="fas fa-trash red2"></i></a></td>
                    				 
                            </tr>
                            <?php 
                                //<!-- hidden values -->
                                /* fetch trader phone */
                               $trPhone=fetch('phone','user','user_id',$item['user_id']); 
                               ?>
                            <input type="hidden" name="trader[]" value="<?php echo $item['user_id']?>">
                            <input type="hidden" name="traderPhone[]" value="<?php echo $trPhone['phone']?>">
                            <input type="hidden" name="item[]" value="<?php echo $item['item_id']?>">
                            <input type="hidden" name="cat[]" value="<?php echo $item['cat_id']?>">
                            <input type="hidden" name="sub[]" value="<?php echo $item['subcat_id']?>">
                  <?php  }  
                            $total+=$finalPrice*$val['q'];
      }  /*}else{ ?> <div class="height centered font-med above-lg">لا توجد طلبات  شراء </div><?php }*/ // END foreach & foreach ?>
      </tbody>
		</table>
    <div class="solid orange"><span>الاجمالي =  <span class="red"><?php echo $total; ?></span> ج.م. </span></div>
	</section> 
	 <div class="prog">
    <span>أدخل كود الاحالة  (اختياري ) </span><input type="text"  name="prog" autocomplete="off" >
  </div>


  <div class="under-table">
    <p class="notice">لاتمام طلب الشراء ؛ سيتم ارسال  بياناتك الاتية الى ادارة الموقع:</p>
      <div class="above bottom2">
                  <!-- name --> 
                  <div class="div-pl2">
                     <div class="first"> <label class="input-lbl"><?php echo $lang['name']?></label><!--<span class="red2">*</span>--></div>
                     <div class="second">
                      <input class="input-plan"  type="text" name="name" value="<?php if($fetchbuyer['trader']==1){ echo $fetchbuyer['commercial_name'];}else{ echo $fetchbuyer['name'];} ?>" readonly>
                    </div>
                  </div><br>

                  <!-- phone -->  
                  <div class="div-pl2">
                     <div class="first"> <label class="input-lbl"><?php echo $lang['phone']?></label><!--<span class="red2">*</span>--></div>
                       <div class="second">
                      <input class="input-plan"  type="text" name="phone" value="<?php echo '0'.$fetchbuyer['phone']?>" readonly>
                      </div>
                  </div><br>

                  <!-- state --> 
                  <div class="div-pl2">
                      <div class="first"><label class="input-lbl"><?php echo $lang['state']?></label><!--<span class="red2">*</span>--></div>
                       <div class="second">
                        <select class="input-plan" id="state" name="state">
                          <option value="<?php echo $fetchbuyer['state_id']?>"><?php echo $buyer['state_nameAR']?></option>
                        </select>
                       </div>
                  </div><br>

                  <!-- city -->  
                  <div class="div-pl2">
                      <div class="first"><label class="input-lbl"><?php echo $lang['city']?></label><!--<span class="red2">*</span>--></div>
                      <div class="second">
                        <select class="input-plan" id="city" name="city">
                          <option value="<?php echo $fetchbuyer['city_id']?>"><?php echo $buyer['city_nameAR']?></option>
                        </select>
                      </div>
                  </div>

            </div><!--end div-> class=bottom2 -->
            <div class="flex">
              <input type="hidden" class="lang" value="<?php echo $l;?>">
              <span class="retreat" ><a href="<?php if($link=='&t=s&main=g'){ echo 'search.php?cat=0&state=0&ordering=1&main=g'; }elseif($link=='&t=s&main=v'){ echo 'search-v.php?cat=0&state=0&ordering=1&main=v'; }elseif($link=='&t=i&main=g'){ echo 'general.php'; }elseif($link=='&t=i&main=v'){ echo 'service.php'; } ?>">تراجع  </a></span> 
              <button type="submit" class="button-all confirmAhead" id="btnpl2"><?php echo $lang['submit']?></button>
            </div>
      
    <p class="resultPl"></p> 
  </div><!--end div-> class=under table -->
<?php }else{ ?> <div class="height centered font-med above-lg no">لا توجد طلبات  شراء </div><?php } // END foreach & foreach ?>
   <?php
     //counter eye to count page visits 
      include 'counter.php';
      echo '<span class="eye-counter" id="'.$_SESSION['counterOrder'].'"></span>'; 
      ?>
</form>
</div>
    
      <!--ajax coner -->
      <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
      <script>
      $(document).ready(function(){
        //ajax call state
        $("#state").on("change", function(){
          var state=$(this).val();
          var l=$('#lng').val();
          $.ajax({
          url:"catSelect.php",
          data:{sentState:state,l:l},
          success: function(data){                             
            $("#city").html(data);
             }
           });
        });
        //ajax call send page views 
        var eye=$('.eye-counter').attr('id');
        $.ajax({
        url:"counterInsert.php",
        data:{order:eye}
         });
        
        //ajax 
        $(".pickNum").on("change", function(){
          /* var num=$(this).val();
           var final=$(this).closest('td').prev('td').find('.final').val();
           $(this).closest('td').next().html(final);
           var total=final*num;
           $(this).closest('td').next().html(total);*/
          
        });

                 
                  

            });
        </script>

        <?php 	

 }else{ //END session
      include 'notFound.php';
    }



 include  $tmpl ."footer.inc";
 include 'foot.php';
 ob_end_flush();
 