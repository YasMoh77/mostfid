<?php
ob_start();
session_start();
$title= 'مستفيد | ابحث عن خدمات بخصومات  ';       
$keywords='<meta name="keywords" content="   بحث , خدمات ,  منصة,  طلب ,  سعر ,  50% , البحث ,  تخفيضات   , عروض    , حقيقية , خصم     , خصومات      ">';
$description='<meta name="description" content=" ابحث على منصة مستفيد عن خدمات يقدم اصحابها عروض و خصومات عليها  ؛نقل بضائع دورات تعليمية ترجمة وغيرها ؛ ابدأ البحث الآن وقدم طلب شراء     ">';
$canonical='<link rel="canonical" href="https://mostfid.com/search-v.php?cat=0&state=0&ordering=1" >';
include 'init.php';

if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google 
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb
//if activated==0 => email updated but not verified
if (isset($session)) {
//if activated==0 => email updated but not verified & if user or trader is banned
  banned($session);
}

 
  ?><div class="main-div"> 
    <div>
      <p class=" right">
        <a class="main-link" href="service.php">الرئيسية  </a>
        >  <span>بحث  </span>
      </p>
    </div>
    <div class="outer-container">
      <!-------- ASIDE ?k=<?php// echo $cat['cat_id']?>&a=search------->
      <aside>
        <form action="search-v.php" method='GET'>
        <select class="rightx" name="cat">
      <?php
        $stmt=$conn->prepare(" SELECT * from categories WHERE cat_id>10  ");  
        $stmt->execute();$cats=$stmt->fetchAll();
        if (!empty($cats)) {
          ?> <option value="0">جميع الأقسام</option> <?php
             foreach ($cats as $cat) { ?>
          <option value="<?php echo $cat['cat_id']?>"><?php echo $cat['cat_nameAR'];?></option>
        <?php } } ?>
         </select> 
         <select class="rightx" name="state">
          <?php
          $stmt=$conn->prepare(" SELECT * from state where country_id=1  ");  
          $stmt->execute();$states=$stmt->fetchAll();
          if (!empty($states)) {
            ?> <option value="0">جميع المحافظات  </option> <?php
              foreach ($states as $state) { ?>
            <option value="<?php echo $state['state_id']?>"><?php echo $state['state_nameAR'];?></option>
          <?php } } ?>
           </select>
           <select name="ordering">
            <option value="1">الأكبر خصما</option>
            <option value="2">الأحدث اضافة</option>
            <option value="3">الأكثر مشاهدة</option>
           </select>
          <?php //echo $_GET['main']; ?>
           <!--<input type="hidden" name="GetMain" value="<?php echo $_GET['main']; ?>">-->
           <button type="submit"><?php echo $lang['search'] ?></button>
         </form>
       </aside>
       <!--------- END ASIDE ------->
        <?php
    if (isset($_GET['cat'])/*&&is_numeric($_GET['cat'])*/&&isset($_GET['state'])/*&&is_numeric($_GET['state'])*/&&isset($_GET['ordering'])/*&&is_numeric($_GET['ordering'])*/||isset($_GET['page']) ){ //END if(POST)
        //if request comes from aside in search page
      ?><div class="aside-son-container">
        <?php
           $CAT=isset($_GET['cat'])&&is_numeric($_GET['cat'])&&$_GET['cat']<18&&$_GET['cat']>0?intval($_GET['cat']):0;
           $STATE=isset($_GET['state'])&&is_numeric($_GET['state'])&&$_GET['state']<28&&$_GET['state']>0?intval($_GET['state']):0;
           $ORDERING=isset($_GET['ordering'])&&is_numeric($_GET['ordering'])&&$_GET['ordering']<4&&$_GET['ordering']>0?intval($_GET['ordering']):1;
          if ($ORDERING==1) {
            $ordering='ORDER BY  discount desc';
          }elseif ($ORDERING==2) {
            $ordering='ORDER BY  item_id desc';
          }elseif ($ORDERING==3) {
            $ordering='ORDER BY  seen desc';
          }elseif ($ORDERING<1||$ORDERING>3) {
            $ordering='ORDER BY discount desc';
          }

          $mostafeed='مستفيد خدمات  '; 
          ////////////////////
           if ($CAT>0&&$STATE>0) {
            //count items
            $stmt=$conn->prepare(" SELECT count(item_id) FROM items
             JOIN categories  ON items.cat_id=categories.cat_id
             JOIN sub         ON items.subcat_id=sub.subcat_id
             JOIN user        ON items.user_id=user.user_id
             JOIN country     ON items.country_id=country.country_id
             JOIN state       ON items.state_id=state.state_id
             JOIN city        ON items.city_id=city.city_id
          WHERE items.cat_id=? and items.state_id=? and items.approve>0 and items.hide=0 and categories.cat_id>10 ");         
             
          $stmt->execute(array($CAT,$STATE)); 
          $itemsNum=$stmt->fetchColumn();
          //pagination data
         $adsPerPage=15; 
          $NumberOfPages=ceil($itemsNum/$adsPerPage);
          $pageNum= isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page']<=$NumberOfPages&& $_GET['page']>0 ? intval($_GET['page']) : 1; 
          $startFrom=($pageNum-1)* $adsPerPage; //
          ?><span class="itemsNum-search"><?php echo $mostafeed.' - '.getCat($CAT).' - '.getState($STATE).' - '; if($ORDERING==1){ echo 'الأكبر خصماً';}elseif($ORDERING==2){ echo 'الأحدث اضافة ';}elseif($ORDERING==3){ echo 'الأكثر مشاهدة ';}elseif($ORDERING>3||$ORDERING<1){$ORDERING=1; echo 'الأكبر خصماً';} ?>&emsp;&emsp;&emsp;نتائج البحث:  &nbsp;<?php echo $itemsNum;?> اعلان &ensp; <?php echo $NumberOfPages;?> صفحة   </span> <?php

          //get items
          $stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
               FROM items
             JOIN categories  ON items.cat_id=categories.cat_id
             JOIN sub         ON items.subcat_id=sub.subcat_id
             JOIN user        ON items.user_id=user.user_id
             JOIN country     ON items.country_id=country.country_id
             JOIN state       ON items.state_id=state.state_id
             JOIN city        ON items.city_id=city.city_id
          WHERE items.cat_id=? and items.state_id=? and items.approve>0 and items.hide=0 and categories.cat_id>10           
             $ordering    limit $startFrom, $adsPerPage");
          $stmt->execute(array($CAT,$STATE));
          $itemsGET=$stmt->fetchAll();
          



          }elseif ($CAT==0&&$STATE==0) {
            //count items
            $stmt=$conn->prepare(" SELECT count(item_id) FROM items
             JOIN categories  ON items.cat_id=categories.cat_id
             JOIN sub         ON items.subcat_id=sub.subcat_id
             JOIN user        ON items.user_id=user.user_id
             JOIN country     ON items.country_id=country.country_id
             JOIN state       ON items.state_id=state.state_id
             JOIN city        ON items.city_id=city.city_id
          WHERE items.cat_id>0 and items.state_id>0 and items.approve>0 and items.hide=0 and categories.cat_id>10 ");         
             
          $stmt->execute();
          $itemsNum=$stmt->fetchColumn();
          //pagination data
         $adsPerPage=15;
          $NumberOfPages=ceil($itemsNum/$adsPerPage);
          $pageNum= isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page']<=$NumberOfPages&& $_GET['page']>0 ? intval($_GET['page']) : 1; 
          $startFrom=($pageNum-1)* $adsPerPage; 
             ?><span class="itemsNum-search"><?php echo $mostafeed.' - '.getCat($CAT).' - '.getState($STATE).' - '; if($ORDERING==1){ echo 'الأكبر خصماً';}elseif($ORDERING==2){ echo 'الأحدث اضافة ';}elseif($ORDERING==3){ echo 'الأكثر مشاهدة ';}elseif($ORDERING>3||$ORDERING<1){$ORDERING=1; echo 'الأكبر خصماً';} ?>&emsp;&emsp;&emsp;نتائج البحث:  &nbsp;<?php echo $itemsNum;?> اعلان &ensp; <?php echo $NumberOfPages;?> صفحة   </span> <?php
                    
                    //get items
          $stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
               FROM items
             JOIN categories  ON items.cat_id=categories.cat_id
             JOIN sub         ON items.subcat_id=sub.subcat_id
             JOIN user        ON items.user_id=user.user_id
             JOIN country     ON items.country_id=country.country_id
             JOIN state       ON items.state_id=state.state_id
             JOIN city        ON items.city_id=city.city_id
          WHERE items.cat_id>0 and items.state_id>0  and items.approve>0 and items.hide=0 and categories.cat_id>10        
             $ordering     limit $startFrom, $adsPerPage ");
          $stmt->execute();
          $itemsGET=$stmt->fetchAll();




          }elseif ($CAT>0&&$STATE==0) {
              //count items
            $stmt=$conn->prepare(" SELECT count(item_id) FROM items
             JOIN categories  ON items.cat_id=categories.cat_id
             JOIN sub         ON items.subcat_id=sub.subcat_id
             JOIN user        ON items.user_id=user.user_id
             JOIN country     ON items.country_id=country.country_id
             JOIN state       ON items.state_id=state.state_id
             JOIN city        ON items.city_id=city.city_id
          WHERE items.cat_id=? and items.state_id>0 and items.approve>0 and items.hide=0 and categories.cat_id>10 ");         
             
          $stmt->execute(array($CAT));
          $itemsNum=$stmt->fetchColumn();
          //pagination data
         $adsPerPage=15;
          $NumberOfPages=ceil($itemsNum/$adsPerPage);
          $pageNum= isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page']<=$NumberOfPages&& $_GET['page']>0 ? intval($_GET['page']) : 1; 
          $startFrom=($pageNum-1)* $adsPerPage; //
            ?><span class="itemsNum-search"><?php echo $mostafeed.' - '.getCat($CAT).' - '.getState($STATE).' - '; if($ORDERING==1){ echo 'الأكبر خصماً';}elseif($ORDERING==2){ echo 'الأحدث اضافة ';}elseif($ORDERING==3){ echo 'الأكثر مشاهدة ';}elseif($ORDERING>3||$ORDERING<1){$ORDERING=1; echo 'الأكبر خصماً';} ?>&emsp;&emsp;&emsp;نتائج البحث:  &nbsp;<?php echo $itemsNum;?> اعلان &ensp; <?php echo $NumberOfPages;?> صفحة   </span> <?php
                    
                    //get items
          $stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
               FROM items
             JOIN categories  ON items.cat_id=categories.cat_id
             JOIN sub         ON items.subcat_id=sub.subcat_id
             JOIN user        ON items.user_id=user.user_id
             JOIN country     ON items.country_id=country.country_id
             JOIN state       ON items.state_id=state.state_id
             JOIN city        ON items.city_id=city.city_id
          WHERE items.cat_id=? and items.state_id>0 and items.approve>0 and items.hide=0 and categories.cat_id>10           
             $ordering     limit $startFrom, $adsPerPage ");
          $stmt->execute(array($CAT));
          $itemsGET=$stmt->fetchAll();



          }elseif ($CAT==0&&$STATE>0) {
              //count items
            $stmt=$conn->prepare(" SELECT count(item_id) FROM items
             JOIN categories  ON items.cat_id=categories.cat_id
             JOIN sub         ON items.subcat_id=sub.subcat_id
             JOIN user        ON items.user_id=user.user_id
             JOIN country     ON items.country_id=country.country_id
             JOIN state       ON items.state_id=state.state_id
             JOIN city        ON items.city_id=city.city_id
          WHERE items.cat_id>0 and items.state_id=? and items.approve>0 and items.hide=0 and categories.cat_id>10 ");         
             
          $stmt->execute(array($STATE));
          $itemsNum=$stmt->fetchColumn();
          //pagination data
         $adsPerPage=15;
          $NumberOfPages=ceil($itemsNum/$adsPerPage);
          $pageNum= isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page']<=$NumberOfPages&& $_GET['page']>0 ? intval($_GET['page']) : 1; 
          $startFrom=($pageNum-1)* $adsPerPage; //
            ?><span class="itemsNum-search"><?php echo $mostafeed.' - '.getCat($CAT).' - '.getState($STATE).' - '; if($ORDERING==1){ echo 'الأكبر خصماً';}elseif($ORDERING==2){ echo 'الأحدث اضافة ';}elseif($ORDERING==3){ echo 'الأكثر مشاهدة ';}elseif($ORDERING>3||$ORDERING<1){$ORDERING=1; echo 'الأكبر خصماً';} ?>&emsp;&emsp;&emsp;نتائج البحث:  &nbsp;<?php echo $itemsNum;?> اعلان &ensp; <?php echo $NumberOfPages;?> صفحة   </span> <?php
                    
                    //get items
          $stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
               FROM items
             JOIN categories  ON items.cat_id=categories.cat_id
             JOIN sub         ON items.subcat_id=sub.subcat_id
             JOIN user        ON items.user_id=user.user_id
             JOIN country     ON items.country_id=country.country_id
             JOIN state       ON items.state_id=state.state_id
             JOIN city        ON items.city_id=city.city_id
          WHERE items.cat_id>0 and items.state_id=? and items.approve>0 and items.hide=0 and categories.cat_id>10         
             $ordering  limit $startFrom, $adsPerPage ");
          $stmt->execute(array($STATE));
          $itemsGET=$stmt->fetchAll();
          }
          ///////////////////
         ?><div class=" items-container aside-son"><?php
        if(!empty($itemsGET)){
        foreach ($itemsGET as $value) { 
                 $ratio=$value['price']*($value['discount']/100);
                 $finalPrice1=round($value['price']-$ratio);
                 $finalPrice=number_format($finalPrice1);
          ?>
        <div class="repeated-cont repeated-contSV">
        <!-- bring ads on clicking on  aside links--> 
              <div class="div-img-disc">
              <span title="خصم" class="disc"><?php echo $value['discount'].'%'.' -' ?></span>
                <?php
              if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id']) { 
                  $fetchFav=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$_SESSION['traderid']);
                  
                  if($fetchFav==1){ 
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
                  if($fetchEid==1){ ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
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
             <span class="alone small cut2"><?php echo $value['cat_nameAR'].' > '.$value['subcat_nameAR'];?></span>
            <a href="details.php?id=<?php echo $value['item_id']?>&t=s&main=v" class="p-title  alone font1 titleLink"><?php echo $value['title'] ?></a>
            <input type="hidden" class="idValue" value="<?php echo $value['item_id'];?>">
            <p class="date"><?php echo 'أضيف في: '.$value['item_date'] ?></p>
            <div class="finalPrice-div finalPrice-divS <?php if(($value['price']-$ratio)<10000){ echo 'shortPriceS';} ?>">
               <s><?php echo number_format($value['price']);?></s>
                <span>ج.م.</span>
                <span>
                  <span class="bold"><?php echo $finalPrice ?></span>
                  <span>ج.م.</span>
                </span>
            </div>
              <?php
              if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id'] ) { //appears as a link for users
                ?> <div class="search-v-div-a"><a title="تقديم طلب شراء " href="order.php?id=<?php echo $value['item_id']?>&t=s&main=v"><i class="fas fa-phone"></i></a></div> <?php
              }elseif (isset($_SESSION['userEid'])||isset($_SESSION['userGid'])||isset($_SESSION['userFid'])) {
                ?> <div class="search-v-div-a"><a title="اطلب شراء المنتج " href="order.php?id=<?php echo $value['item_id']?>&t=s&main=v"><i class="fas fa-phone"></i></a></div> <?php
              }elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
                ?> <div class="search-v-div-a"><a><i class="fas fa-phone"></i></a></div> <?php
              }else{ //appears as empty link for traders
                ?> <div class="search-v-div-a"><a  href="login.php"><i class="fas fa-phone"></i></a></div> <?php
              } ?>
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
        
      <?php } //END foreach
        /////////////////////
        }else{ //END if(!empty(itemsGET)) 
                  echo "<div class='block2-search'>عفوا؛  لا توجد نتائج؛  ابحث في جميع  الأقسام والمحافظات  </div>";
        } 
         ?></div><!-- END items-container aside-son --><?php
          //===================start pagination=========================  
          $jumpForward=1;
        $jumpBackward=1; 

      if($NumberOfPages>1 ){  ?>
       <nav aria-label="Page navigation example" class="pagination-container">
          <ul class="pagination pagination-md">
         <?php if(($pageNum-$jumpBackward)>=1 ){  //previous
         ?> <li class="page-item"><a class="page-link prev" href="?cat=<?php echo $CAT.'&state='.$STATE.'&ordering='.$ORDERING.'&page='. ($pageNum-$jumpBackward)?>"><?php echo $lang['prev'];?></a></li><?php
            }else{
            ?> <li class="page-item disabled"><a class="page-link"><?php echo $lang['prev'];?></a></li><?php
            }
            //$page=1; $page<= $NumberOfPages;  $page++
        for ($page=max(1,$pageNum-2);$page<=min($pageNum+2,$NumberOfPages);$page++) {  //for loop
        if (isset($_GET['page'])&&$_GET['page']==$page ) {
          echo   '<li class="page-item"><a class="page-link active" href="search-v.php?cat='.$CAT.'&state='.$STATE.'&ordering='.$ORDERING.'&page='.$page.'">'.$page.'</a></li>';
        }elseif (!isset($_GET['page'])&&$page==1 ) {
           echo   '<li class="page-item"><a class="page-link active" href="search-v.php?cat='.$CAT.'&state='.$STATE.'&ordering='.$ORDERING.'&page='.$page.'">'.$page.'</a></li>';
        }else{
          echo   '<li class="page-item"><a class="page-link" href="search-v.php?cat='.$CAT.'&state='.$STATE.'&ordering='.$ORDERING.'&page='.$page.'">'.$page.'</a></li>';
        } }
          if(($pageNum+$jumpForward)<=$NumberOfPages){  //next
        ?> <li class="page-item"> <a class="page-link next"  href="?cat=<?php echo $CAT.'&state='.$STATE.'&ordering='.$ORDERING.'&page='. ($pageNum+$jumpForward)?>"><?php echo $lang['next'];?></a> </li><?php
      }else{
         ?> <li class="page-item disabled"> <a class="page-link "><?php echo $lang['last'];?></a> </li><?php
      } ?>  
          </ul > 
      </nav>
      <?php
      }
      ////////////// END pagination ////////////// 
           //counter eye to count page visits
      include 'counter.php';
      echo '<span class="eye-counter searchAside" id="'.$_SESSION['counterSearchAside'].'"></span>'; 
       ?></div> <!--END items-container container -->
       <!--ajax coner -->
         <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
         <script>
         $(document).ready(function(){
         //ajax call send page views
        var eye2=$('.searchAside').attr('id');
        $.ajax({
        url:"counterInsert.php",
        data:{searchAside:eye2}
           });
          //ajax call send item views
        $('.titleLink').click(function(){
        var item=$(this).nextAll('.idValue').val();
        $.ajax({
        url:"process2.php",
        data:{itemView:item}
           });
         });



            });
        </script>
        <?php



    }elseif(isset($_GET['k'])&&is_numeric($_GET['k'])&&$_GET['k']>0&&$_GET['k']<18  || isset($_GET['Page'])){ //END if(S_server==GET) 
              //if request comes from index.php
             $kat=intval($_GET['k']);
             $mostafeed='مستفيد خدمات  '; 
        ?><div class="aside-son-container">
             <?php
              /////////////////
            //count items
          $stmt=$conn->prepare(" SELECT count(item_id) FROM items
           JOIN categories  ON items.cat_id=categories.cat_id
           JOIN sub         ON items.subcat_id=sub.subcat_id
           JOIN user        ON items.user_id=user.user_id
           JOIN country     ON items.country_id=country.country_id
           JOIN state       ON items.state_id=state.state_id
           JOIN city        ON items.city_id=city.city_id
        WHERE items.cat_id=?  and items.approve>0 and items.hide=0 and categories.cat_id>10 ");         
        $stmt->execute(array($kat));
        $itemsNum=$stmt->fetchColumn();
        //pagination data
       $adsPerPage=15;
        $NumberOfPages=ceil($itemsNum/$adsPerPage);
        $pageNum= isset($_GET['Page']) && is_numeric($_GET['Page']) && $_GET['Page']<=$NumberOfPages&& $_GET['Page']>0 ? intval($_GET['Page']) : 1; 
        $startFrom=($pageNum-1)* $adsPerPage; //
        ?><span class="itemsNum-search"><?php echo $mostafeed.' - '.getCat($kat).' - '.'جميع المحافظات  '.' - '.'الأكبر  خصماً '?>  &emsp;&emsp;&emsp;نتائج البحث:  &nbsp;<?php echo $itemsNum;?> اعلان &ensp; <?php echo $NumberOfPages;?> صفحة   </span> <?php
                
                 //get items
         $stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
           FROM items
         JOIN categories  ON items.cat_id=categories.cat_id
         JOIN sub         ON items.subcat_id=sub.subcat_id
         JOIN user        ON items.user_id=user.user_id
         JOIN country     ON items.country_id=country.country_id
         JOIN state       ON items.state_id=state.state_id
         JOIN city        ON items.city_id=city.city_id
        WHERE items.cat_id=?    and items.approve>0 and items.hide=0  and categories.cat_id>10
        ORDER BY   items.item_id   DESC  limit $startFrom, $adsPerPage");
        $stmt->execute(array($kat));
        $itemsKat=$stmt->fetchAll();
       ?> <div class=" items-container aside-son "> <?php
               ////////////////
              //$itemsKat=getItems('items.cat_id',$kat);
        if(!empty($itemsKat)){
              foreach ($itemsKat as $value) { 
               $ratio=$value['price']*($value['discount']/100);
               $finalPrice1=round($value['price']-$ratio);
               $finalPrice=number_format($finalPrice1);
          ?>
        <div class="repeated-cont repeated-contSV">
              <div class="div-img-disc"> 
              <span title="خصم"  class="disc"><?php echo $value['discount'].'%'.' -' ?></span>
                <?php
              if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id']) { 
                  $fetchFav=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$_SESSION['traderid']);
                  
                  if($fetchFav==1){ 
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
                               <!--<span class="sh">sh</span>-->
                     <?php
              }elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
                 ?><a><i class="fas fa-heart grey2"></i></a>  <?php
                 
              }elseif (isset($_SESSION['userEid'])|| isset($_SESSION['userGid']) ||isset($_SESSION['userFid'])) {
                $session1=isset($_SESSION['userEid'])?$_SESSION['userEid']:$_SESSION['userGid']; 
                $session=isset($_SESSION['userFid'])?$_SESSION['userFid']:$session1; 
                $fetchEid=fetch2('favourite_status','favourite','item_id',$value['item_id'],'user_id',$session);
                  if($fetchEid==1){ ?><i title="مضاف للمفضلة" class="fas fa-heart fav fav_E purple"></i><?php 
                  }else{ 
                   ?><i title="حفظ" class="fas fa-heart fav fav_E grey"></i><?php 
                   } ?>
                  <input type="hidden" class="item" value="<?php echo $value['item_id'];?>">
                      <input type="hidden" class="user" value="<?php echo $session;?>">
                      <input type="hidden" class="cat" value="<?php echo $value['cat_id'];?>">
                  <input type="hidden" class="sub" value="<?php echo $value['subcat_id'];?>">
                  <input type="hidden" class="state" value="<?php echo $value['state_id'];?>">
                  <input type="hidden" class="city" value="<?php echo $value['city_id'];?>">
              
              <?php }else{ ?><a href="login.php"><i class="fas fa-heart grey2"></i></a>  <?php }  ?> 
          
                <img src="data\upload\<?php echo $value['photo'] ?>" alt="<?php echo $value['title'] ?>">
              </div>
              <section>
             <span class="alone small"><?php echo $value['cat_nameAR'].'>'.$value['subcat_nameAR'];?></span>
            <a href="details.php?id=<?php echo $value['item_id']?>&t=s&main=v" class="p-title  alone font1 titleLink"><?php echo $value['title'] ?></a>
            <input type="hidden" class="idValue" value="<?php echo $value['item_id'];?>">
            <p class="date"><?php echo 'أضيف في: '.$value['item_date'] ?></p>
            <div class="finalPrice-div finalPrice-divS <?php if(($value['price']-$ratio)<10000){ echo 'shortPriceS';} ?>">
              <s><?php echo number_format($value['price']);?></s>
              <span>ج.م.</span>
              <span>
                <span class="bold"><?php echo $finalPrice ?></span>
                <span>ج.م.</span> 
              </span>
            </div>
              <?php
              if (isset($_SESSION['traderid'])&&$_SESSION['traderid']!=$value['user_id'] ) { //appears as a link for users
                ?> <a class="widest" title="تقديم طلب شراء " href="order.php?id=<?php echo $value['item_id']?>&t=s&main=v"><i class="fas fa-phone"></i></a> <?php
              }elseif (isset($_SESSION['userEid'])||isset($_SESSION['userGid'])||isset($_SESSION['userFid'])) {
                ?> <a class="widest" title="تقديم طلب شراء " href="order.php?id=<?php echo $value['item_id']?>&t=s&main=v"><i class="fas fa-phone"></i></a> <?php
              }elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
                ?> <a class="widest"><i class="fas fa-phone"></i></a> <?php
              }else{ //appears as empty link for traders
                ?><a class="widest" href="login.php"><i class="fas fa-phone"></i></a> <?php 
              } ?>
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
      <?php } //END foreach

      }else{ //END if(!empty)
         echo "<div class='block2-search'>عفوا؛ لا توجد نتائج؛ يفضل البحث في جميع الأقسام </div>";
      } 
   ?></div> <!-- END items-container --><?php 
             //===================start pagination========================= 
              $jumpForward=1;
            $jumpBackward=1; 

          if($NumberOfPages>1 ){  ?>
           <nav aria-label="Page navigation example" class="pagination-container">
              <ul class="pagination pagination-md">
             <?php if(($pageNum-$jumpBackward)>=1 ){  //previous
             ?> <li class="page-item"><a class="page-link prev"  href="?k=<?php echo $kat.'&Page='. ($pageNum-$jumpBackward)?>"><?php echo $lang['prev'];?></a></li><?php
                }else{
                ?> <li class="page-item disabled"><a class="page-link"><?php echo $lang['prev'];?></a></li><?php
                }
                //$page=1; $page<= $NumberOfPages;  $page++
            for ($page=max(1,$pageNum-2);$page<=min($pageNum+2,$NumberOfPages);$page++) {  //for loop
            if (isset($_GET['Page'])&&$_GET['Page']==$page ) {
              echo   '<li class="page-item"><a class="page-link active" href="search-v.php?k='.$kat.'&Page='.$page.'">'.$page.'</a></li>';
            }elseif (!isset($_GET['Page'])&&$page==1 ) {
               echo   '<li class="page-item"><a class="page-link active" href="search-v.php?k='.$kat.'&Page='.$page.'">'.$page.'</a></li>';
            }else{
              echo   '<li class="page-item"><a class="page-link" href="search-v.php?k='.$kat.'&Page='.$page.'">'.$page.'</a></li>';
            } }
              if(($pageNum+$jumpForward)<=$NumberOfPages){  //next
            ?> <li class="page-item"> <a class="page-link next"  href="?k=<?php echo $kat.'&Page='. ($pageNum+$jumpForward)?>"><?php echo $lang['next'];?></a> </li><?php
          }else{
             ?> <li class="page-item disabled"> <a class="page-link "><?php echo $lang['last'];?></a> </li><?php
          } ?>  
              </ul > 
          </nav>
          <?php
          } 
      ////////////// END pagination /////////////
      //counter eye to count page visits 
      include 'counter.php';
      echo '<span class="eye-counter searchK" id="'.$_SESSION['counterSearchK'].'"></span>'; 
      ?> </div><?php //END aside-son-container
        
        /////////////////////
            }else{ //End if(isset($_GET['k']))
              include 'notFound.php';
            } ?>

    </div>  <!-- END outer-container --> 
   </div> <!-- END main-div -->
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
         //ajax add to favourite_tr  => from traders
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
          //ajax call send page views
          var eye1=$('.searchK').attr('id');
          $.ajax({
          url:"counterInsert.php",
          data:{searchK:eye1}
             });
           //ajax call send item views
           $('.titleLink').click(function(){
          var item=$(this).nextAll('.idValue').val();
          $.ajax({
          url:"process2.php",
          data:{itemView:item}
             });
           });
       



         });
      </script>

    <?php




 
 include  $tmpl ."footer.inc";
 include 'foot.php';
 ob_end_flush();