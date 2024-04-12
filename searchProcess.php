<?php
//ob_start();
session_start();       //important in every php page
ob_start();
$title='بحـث ';       //title of the page
?><link rel="canonical" href="https://mostfid.com/search.php?cat=0&state=0&ordering=1" > <?php
$tmpl='include/templates/';
$css='layout/css/';
$js='layout/js/';
$images='layout/images/';
$fonts='layout/fonts/';
$language='include/languages/';
$func='include/functions/';
//important files
include 'lang.php'; //must be before header or header words fail. 
include $tmpl."header.inc";
include 'connect.php'; //this file connects to database
include $func.'functions.php';



//coming from search.php 
if (isset($_POST['cat'])&&isset($_POST['state'])&&isset($_POST['ordering'])||isset($_GET['Page']) ){ 
    
           $CAT=isset($_POST['cat'])&&is_numeric($_POST['cat'])/*&&$_POST['cat']<11/*&&$_POST['cat']>0*/?intval($_POST['cat']):0;
           $s=isset($_GET['s'])&&$_GET['s']=='s'?'s':'p';
           $STATE=isset($_POST['state'])&&is_numeric($_POST['state'])&&$_POST['state']<28&&$_POST['state']>0?intval($_POST['state']):0;
           $ORDERING=isset($_POST['ordering'])&&is_numeric($_POST['ordering'])&&$_POST['ordering']<4&&$_POST['ordering']>0?intval($_POST['ordering']):1;
          if ($ORDERING==1) {
            $ordering='ORDER BY  discount desc';
          }elseif ($ORDERING==2) {
            $ordering='ORDER BY  item_id desc';
          }elseif ($ORDERING==3) {
            $ordering='ORDER BY  seen desc';
          }elseif ($ORDERING<1||$ORDERING>3) {
            $ordering='ORDER BY discount desc';
          }
           
           ////////////////
           if ($CAT==0&&$STATE==0) {
            //count items
            $stmt=$conn->prepare(" SELECT count(item_id) FROM items
             JOIN categories  ON items.cat_id=categories.cat_id
             JOIN sub         ON items.subcat_id=sub.subcat_id
             JOIN user        ON items.user_id=user.user_id
             JOIN country     ON items.country_id=country.country_id
             JOIN state       ON items.state_id=state.state_id
             JOIN city        ON items.city_id=city.city_id
          WHERE items.cat_id>0 and items.state_id>0 and items.approve>0 and items.hide=0 /*and categories.cat_id<11*/ ");         
             
          $stmt->execute();
          $itemsNum=$stmt->fetchColumn();
          //pagination data
          $adsPerPage=15;
          $NumberOfPages=ceil($itemsNum/$adsPerPage);
          $pageNum= isset($_GET['Page']) && is_numeric($_GET['Page']) && $_GET['Page']<=$NumberOfPages&& $_GET['Page']>0 ? intval($_GET['Page']) : 1; 
          $startFrom=($pageNum-1)* $adsPerPage; 
                    
                    //get items
          $stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
               FROM items
             JOIN categories  ON items.cat_id=categories.cat_id
             JOIN sub         ON items.subcat_id=sub.subcat_id
             JOIN user        ON items.user_id=user.user_id
             JOIN country     ON items.country_id=country.country_id
             JOIN state       ON items.state_id=state.state_id
             JOIN city        ON items.city_id=city.city_id
          WHERE items.cat_id>0 and items.state_id>0  and items.approve>0 and items.hide=0  /*and categories.cat_id<11*/       
             $ordering     limit $startFrom, $adsPerPage ");
          $stmt->execute();
          $itemsGET=$stmt->fetchAll();




          }elseif ($CAT>0&&$STATE>0) {
            //count items
            $stmt=$conn->prepare(" SELECT count(item_id) FROM items
             JOIN categories  ON items.cat_id=categories.cat_id
             JOIN sub         ON items.subcat_id=sub.subcat_id
             JOIN user        ON items.user_id=user.user_id
             JOIN country     ON items.country_id=country.country_id
             JOIN state       ON items.state_id=state.state_id
             JOIN city        ON items.city_id=city.city_id
          WHERE items.cat_id=? and items.state_id=? and items.approve>0 and items.hide=0 /*and categories.cat_id<11*/ ");         
             
          $stmt->execute(array($CAT,$STATE)); 
          $itemsNum=$stmt->fetchColumn();
          //pagination data
          $adsPerPage=15; 
          $NumberOfPages=ceil($itemsNum/$adsPerPage);
          $pageNum= isset($_GET['Page']) && is_numeric($_GET['Page']) && $_GET['Page']<=$NumberOfPages&& $_GET['Page']>0 ? intval($_GET['Page']) : 1; 
          $startFrom=($pageNum-1)* $adsPerPage; //
          

          //get items
          $stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
               FROM items
             JOIN categories  ON items.cat_id=categories.cat_id
             JOIN sub         ON items.subcat_id=sub.subcat_id
             JOIN user        ON items.user_id=user.user_id
             JOIN country     ON items.country_id=country.country_id
             JOIN state       ON items.state_id=state.state_id
             JOIN city        ON items.city_id=city.city_id
          WHERE items.cat_id=? and items.state_id=? and items.approve>0 and items.hide=0  /*and categories.cat_id<11*/          
             $ordering    limit $startFrom, $adsPerPage");
          $stmt->execute(array($CAT,$STATE));
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
          WHERE items.cat_id=? and items.state_id>0 and items.approve>0 and items.hide=0 /*and categories.cat_id<11*/ ");         
             
          $stmt->execute(array($CAT));
          $itemsNum=$stmt->fetchColumn();
          //pagination data
          $adsPerPage=15;
          $NumberOfPages=ceil($itemsNum/$adsPerPage);
          $pageNum= isset($_GET['Page']) && is_numeric($_GET['Page']) && $_GET['Page']<=$NumberOfPages&& $_GET['Page']>0 ? intval($_GET['Page']) : 1; 
          $startFrom=($pageNum-1)* $adsPerPage; //
                    
                    //get items
          $stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
               FROM items
             JOIN categories  ON items.cat_id=categories.cat_id
             JOIN sub         ON items.subcat_id=sub.subcat_id
             JOIN user        ON items.user_id=user.user_id
             JOIN country     ON items.country_id=country.country_id
             JOIN state       ON items.state_id=state.state_id
             JOIN city        ON items.city_id=city.city_id
          WHERE items.cat_id=? and items.state_id>0 and items.approve>0 and items.hide=0  /*and categories.cat_id<11*/        
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
          WHERE items.cat_id>0 and items.state_id=? and items.approve>0 and items.hide=0 /*and categories.cat_id<11*/ ");         
             
          $stmt->execute(array($STATE));
          $itemsNum=$stmt->fetchColumn(); 
          //pagination data
          $adsPerPage=15;
          $NumberOfPages=ceil($itemsNum/$adsPerPage);
           $pageNum= isset($_GET['Page']) && is_numeric($_GET['Page']) && $_GET['Page']<=$NumberOfPages&& $_GET['Page']>0 ? intval($_GET['Page']) : 1; 
          $startFrom=($pageNum-1)* $adsPerPage; //
                    
                    //get items
          $stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
               FROM items
             JOIN categories  ON items.cat_id=categories.cat_id
             JOIN sub         ON items.subcat_id=sub.subcat_id
             JOIN user        ON items.user_id=user.user_id
             JOIN country     ON items.country_id=country.country_id
             JOIN state       ON items.state_id=state.state_id
             JOIN city        ON items.city_id=city.city_id
          WHERE items.cat_id>0 and items.state_id=? and items.approve>0 and items.hide=0  /*and categories.cat_id<11*/        
             $ordering  limit $startFrom, $adsPerPage ");
          $stmt->execute(array($STATE));
          $itemsGET=$stmt->fetchAll();
          }
          /////////////////////

         if(!empty($itemsGET)){
         ?>
         <span class="itemsNum-search"><?php if($s=='s'){echo 'خدمات   &ensp;';}elseif($s=='p'){echo 'منتجات   &ensp;'; } echo getCat($CAT).' - '.getState($STATE).' - '; if($ORDERING==1){ echo 'الأكبر خصماً';}elseif($ORDERING==2){ echo 'الأحدث اضافة ';}elseif($ORDERING==3){ echo 'الأكثر مشاهدة ';}elseif($ORDERING>3||$ORDERING<1){$ORDERING=1; echo 'الأكبر خصماً';} ?>&emsp;&emsp;&emsp;نتائج البحث:  &nbsp;<?php echo $itemsNum;?> اعلان &ensp; <?php echo $NumberOfPages;?> صفحة   </span> 
         <div class=" items-container aside-son"><?php
          ////////////////////
        foreach ($itemsGET as $value) { 
                 $ratio=$value['price']*($value['discount']/100);
                  $finalPrice1=round($value['price']-$ratio);
                  $finalPrice=number_format($finalPrice1);
          ?>
        <div class="repeated-cont repeated-contSP">
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
              
              }elseif (isset($_SESSION['userEid'])||isset($_SESSION['userGid'])||isset($_SESSION['userFid'])) {
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
               
                <img src="data\upload\<?php echo $value['photo']?>" alt="<?php echo $value['title'] ?>">
              </div>
              <section>
             <span class="alone small cut2"><?php echo $value['cat_nameAR'].' > '.$value['subcat_nameAR'];?></span> 
            <a href="details.php?id=<?php echo $value['item_id']?>&t=s&main=g" class="p-title alone font1 titleLink"><?php echo $value['title'] ?></a>
            <input type="hidden" class="idValue" value="<?php echo $value['item_id'];?>">
            <p class="date"><i class="fas fa-calendar"></i><?php echo ' '.$value['item_date'].' '; if($value['sit']==1){ echo "المعلن هو المالك  ";}elseif($value['sit']==2){ echo "السعر شامل أجر الوسيط  ";} ?></p> 
           
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
                ?><hr><?php
              }elseif (isset($_SESSION['userEid'])||isset($_SESSION['userGid'])||isset($_SESSION['userFid'])) {
                 ?><hr><?php
              }elseif (isset($_SESSION['traderid'])&&$_SESSION['traderid']==$value['user_id']) {
                ?> <div class="search-v-div-a"><a class="a-phone"><i class="fas fa-phone"></i></a></div> <?php
              }else{ //appears as empty link for traders
                ?> <div class="search-v-div-a"><a class="a-phone" href="login.php"><i class="fas fa-phone"></i></a></div> <?php
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
              ?>
               </div>
           </section>
        </div>
        
      <?php } //END foreach
        /////////////////////
      ?></div><!-- END items-container aside-son --><?php
        }else{ //END if(!empty(itemsGET)) 
             ?> <span class="itemsNum-search"><?php echo getCat($CAT).' - '.getState($STATE).' - '; if($ORDERING==1){ echo 'الأكبر خصماً';}elseif($ORDERING==2){ echo 'الأحدث اضافة ';}elseif($ORDERING==3){ echo 'الأكثر مشاهدة ';}elseif($ORDERING>3||$ORDERING<1){$ORDERING=1; echo 'الأكبر خصماً';} ?>&emsp;&emsp;&emsp;نتائج البحث:  &nbsp;<?php echo $itemsNum;?> اعلان &ensp; <?php echo $NumberOfPages;?> صفحة   </span> <?php
             echo "<div class='block2-search'>عفوا؛  لا توجد نتائج؛  ابحث في جميع  الأقسام والمحافظات  </div>";
        } 
         
          //===================start pagination=========================  
          $jumpForward=1;
        $jumpBackward=1; 

      if($NumberOfPages>1 ){  ?>
       <nav aria-label="Page navigation example" class="pagination-container">
          <ul class="pagination pagination-md">
         <?php if(($pageNum-$jumpBackward)>=1 ){  //previous
         ?> <li class="page-item"><a class="page-link prev" href="?cat=<?php echo $CAT.'&s='.$s.'&state='.$STATE.'&ordering='.$ORDERING.'&page='. ($pageNum-$jumpBackward)?>"><?php echo $lang['prev'];?></a></li><?php
            }else{
            ?> <li class="page-item disabled"><a class="page-link"><?php echo $lang['prev'];?></a></li><?php
            }
            //$page=1; $page<= $NumberOfPages;  $page++
        for($page=max(1,$pageNum-2);$page<=min($pageNum+2,$NumberOfPages);$page++) {  //for loop //href="searchProcess
        if (isset($_GET['page'])&&$_GET['page']==$page ) {
          echo   '<li class="page-item"><a class="page-link active" href="search.php?cat='.$CAT.'&s='.$s.'&state='.$STATE.'&ordering='.$ORDERING.'&page='.$page.'">'.$page.'</a></li>';
        }elseif (!isset($_GET['page'])&&$page==1 ) {
           echo   '<li class="page-item"><a class="page-link active" href="search.php?cat='.$CAT.'&s='.$s.'&state='.$STATE.'&ordering='.$ORDERING.'&page='.$page.'">'.$page.'</a></li>';
        }else{
          echo   '<li class="page-item"><a class="page-link" href="search.php?cat='.$CAT.'&s='.$s.'&state='.$STATE.'&ordering='.$ORDERING.'&page='.$page.'">'.$page.'</a></li>';
        } }
          if(($pageNum+$jumpForward)<=$NumberOfPages){  //next
        ?> <li class="page-item"> <a class="page-link next"  href="?cat=<?php echo $CAT.'&s='.$s.'&state='.$STATE.'&ordering='.$ORDERING.'&page='. ($pageNum+$jumpForward)?>"><?php echo $lang['next'];?></a> </li><?php
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
      ?>
      <!--ajax coner -->
         <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
         <script>
         $(document).ready(function(){
         //ajax call send page views
          var eye1=$('.searchAside').attr('id');
          $.ajax({
          url:"counterInsert.php",
          data:{searchAside:eye1}
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
          data:{item_T:item,user_T:trader,cat:cat,sub:sub,st:state,ci:city}
           });
          });
          






            });
        </script>

<?php
}else{ //END if(isset($_POST['']))
 header('location:logout.php?s=no');
 exit();
}




include $tmpl."footer.inc"; 
ob_end_flush();