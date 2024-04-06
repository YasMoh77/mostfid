<?php
ob_start();
session_start();
$title='action';       //title of the page
?>
<meta name="robots" content="noindex">
<?php
include 'init.php';


if (isset($_SESSION['traderid'])) {
   banned($_SESSION['traderid']); 
    //actions for traders
    $d=isset($_GET['d'])?$_GET['d']:'none'; 

    if ($d=='no-remember') {
      if (isset($_GET['ip'])&&is_numeric($_GET['ip'])&&$_GET['ip']>0 &&$_GET['ip']==$_SESSION['traderid'] ) {
        $trader=intval($_GET['ip']);
        $check=checkItem('user_id','user',$trader);
        if ($check>0) {
         unset( $_SESSION['phoneMos']);
         unset( $_SESSION['passMos']);
         unset($_COOKIE['phoneMos']);
         setcookie('phoneMos','',time()- 3600,'/','mostfid.com');
         unset($_COOKIE['passMos']);
         setcookie('passMos','',time()- 3600,'/','mostfid.com');
         ?>
         <div class="div-remove-action">
         <span class="block-green alone">تم الغاء حفظ بيانات الدخول  </span> 
         </div>
         <script>
             setTimeout(function go1(){ $('.block-green').fadeOut(); },2200);
             setTimeout(function go2(){ location.href='profile.php?i=<?php echo $_SESSION['traderid']?>&p=data'; },2210);
          </script> 
          <?php 
        }
      }else{
        header('location:logout.php?s=no');
        exit();
      }
    }elseif ($d=='edit-tr') { 
      //edit trader =>coming from profile 
      if (isset($_GET['id']) && is_numeric($_GET['id'])&&$_GET['id']>0  && $_GET['id']==$_SESSION['traderid'] ) {
         $user_id=intval($_GET['id']);
         $fetchTr=fetch('*','user','user_id',$user_id);
        ?>
        <!----login page---->
        <h1 class="h1-heading-tr"> <span id="signup">تحديث بيانات مقدم خدمة  </span></h1>
        <div class="relative2 relative-signUp container mod-Tr">
               <!-- SIGN UP FORM-->
          <form class="form-login trData" id="form2" action="formUpdate.php" method="POST" > 
             <input type="hidden" name="country" value="<?php echo $fetchTr['country_id']?>">
             <input type="hidden" name="traderData">
            <!--Password field-->
            <section>
              <div class="div-lable"><label>تغيير كلمة المرور </label>
              </div>
              <div class="div-input signUp" id="modify-tr"><!-- minlength='8' maxlength='20' -->
                <input type="password" id="pass" name="password1" class="form-control inputPassword" 
                        autocomplete="new-password" placeholder="<?php echo $lang['sixCharacters']?>"  >
                <img class="showPassAddClosed" src="<?php echo $images.'eye-off.png' ?>" >
                <img class="showPassAddOpen" src="<?php echo $images.'eye.png' ?>" >
                <input type="hidden" name="oldPassword" value="<?php echo $fetchTr['password']?>">
              </div>
              <span class="pass-span">يجب ان تشتمل كلمة المرور على حرف صغير وحرف كبير ورقم</span>
              </section>
              <input type="hidden" name="user_id" value="<?php echo $user_id ?>">


              <!--Retype Password field-->
            <section>
              <div class="div-lable"><label>أعد ادخال كلمة المرور </label>
              </div>
              <div class="div-input signUp" id="modify-tr2"><!-- minlength='8' maxlength='20' -->
                <input type="password" id="pass2" name="password2" class="form-control inputPassword2" 
                        autocomplete="new-password" placeholder="<?php echo $lang['sixCharacters']?>"  >
                <img class="showPassAddClosed2" src="<?php echo $images.'eye-off.png' ?>" >
                <img class="showPassAddOpen2" src="<?php echo $images.'eye.png' ?>" >
              </div>
              <span class="pass-span">يجب ان تشتمل كلمة المرور على حرف صغير وحرف كبير ورقم</span>
              </section>
              

              <!--phone field-->
              <section>
               <div class="div-lable"><label>تغيير رقم المحمول  </label>
               </div>
               <div class="div-input signUp" >
                  <input type="text" id="phone" name="phone" class="form-control" placeholder="<?php echo '0'.$fetchTr['phone']?>" autocomplete='off'>
                 <input type="hidden" name="oldPhone" value="<?php echo '0'.$fetchTr['phone']?>">
               </div>
              </section>

              
            <!--<span class="required"> * = <?php echo $lang['req']?> </span>--><!--  href="terms.php?d=1" //  href="policy.php" -->
             <div><input class="right termsUpdate" type="checkbox" name="terms" ><span class=" read small right">أوافق على  <a target="_blank">الشروط والأحكام  </a>و  <a target="_blank">سياسة الخصوصية  </a></span></div>  
            <button type="submit"  class="btn btn-primary" id="signUp-btn"  ><?php echo $lang['send']?></button>
          </form>
      </div>
      <!--<div class="showForm showForm-tr"></div>-->
      <input type="hidden" id="lng" value="<?php echo $lang['lang']; ?>">
        <!---------------- END signUp Trader -------------->
    <?php  }else{
            header('location:logout.php?s=no');
            exit();
           }


    }elseif ($d=='del-tr') {
      //delete trader =>coming from profile
      if (isset($_GET['id'])&&is_numeric($_GET['id'])&&$_GET['id']>0  && $_GET['id']==$_SESSION['traderid']  ) {
        $user_id=intval($_GET['id']);
        $check=checkItem('user_id','user',$user_id);
          
           ?> <div class="height bottom-lg"> <?php
          if ($check>0) {
            //mostafed profit on passed orders(approve=1)
            $stmt2=$conn->prepare(' SELECT sum(order_mostafed) from orders where  trader_id=?  and approve=1 ');
            $stmt2->execute(array($user_id));
            $userMostfid=$stmt2->fetchColumn();
           
            $online=fetch('online_pay','user','user_id',$user_id);
            if ($online['online_pay']==0 && $userMostfid>0) { //pay manual & owes no money to mostfid
              echo "<div class='block2'>يوجد مستحقات لمستفيد؛ يجب دفع المستحقات قبل الحذف  </div>";
           }else{ //END if ($online['online_pay']==0 && $userMostfid>0) 
              $stmt=$conn->prepare("DELETE from user WHERE user_id = :zus");
              $stmt->bindParam(":zus",$user_id);
              $stmt->execute();
            if ($stmt) { ?>
                   <?php 
                    echo "<div class='block-green'>".$lang['deleted']."</div>"; 
                    unset($_SESSION['traderid']); 
                   ?>
                <script>
                   setTimeout(function go1(){ $('.block-green').fadeOut(); },1500);
                   setTimeout(function go2(){ location.href='index.php'; },1550);
                </script> 
         <?php  }else{
                  echo "<span class='center'>الرجاء التأكد من الاتصال بالانترنت وإعادة المحاولة </span>";
               }
           } 
       }else{
              include 'notFound.php';
            }

        ?> </div><?php

      }else{ //END if (isset($_GET['i'])
        header('location:logout.php?s=no');
        exit();
      }
     

    }elseif ($d=='edit_item') {
        if (isset($_GET['i']) && is_numeric($_GET['i']) && $_GET['i']>0 ) {
         $item_id=intval($_GET['i']);//item id
         $fetch=fetch('user_id','items','item_id',$item_id);  
 
         if ( $fetch['user_id']==$_SESSION['traderid']) {  
              $fetchIt=fetch('*','items','item_id',$item_id);
              $catName=fetch('cat_nameAR','categories','cat_id',$fetchIt['cat_id']);
              $subcatName=fetch('subcat_nameAR','sub','subcat_id',$fetchIt['subcat_id']);
             ?> 
             <main class="main2">  
                  <form class=" form-add-listing form-add form-update" action="formUpdate.php" method="POST" enctype="multipart/form-data">
                         <input type="hidden" name="edit-item">
                         <h1 class="h1-style">تعديل  إعلان  </h1>
                         <span class="center update-center">اترك الحقول التي لا ترغب في تغييرها </span>
                          <?php 
                          if ($fetchIt['update_date']>0) { 
                            ?><p class="center update-center update-center2">آخر تعديل في: <?php echo $fetchIt['update_date']?></p><?php
                          } ?>
                          <input type="hidden" name="item_id" value="<?php echo $fetchIt['item_id']?>"> 
                          
                          <!--category-->  
                          <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top">ا<?php echo  $lang['cat']?></label>
                          <div class="div-input-container "> 
                              <input type="text" class="input-add-page"  value="<?php echo $catName['cat_nameAR'];?>" readonly>
                              <input type="hidden" id="subcat" name="cat" value="<?php echo $fetchIt['cat_id'];?>">
                          </div> 

                          <!--sub-category-->
                          <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo  $lang['subCat']?> </label>
                          <div class="div-input-container  "> 
                              <input type="text" class="input-add-page"  value="<?php echo $subcatName['subcat_nameAR'];?>" readonly>
                               <input type="hidden" id="subcat2" name="cat2" value="<?php echo $fetchIt['subcat_id'];?>">
                          </div>

                          <!--title--> 
                          <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['title']?> </label>
                          <span class="red small"> * </span>
                          <div class="div-input-container  "> 
                              <input type="text" class="input-add-page input-long" id="name" name="name" minlength="8" maxlength="60" value="<?php echo $fetchIt['title'];?>" placeholder="<?php echo $lang['wirte8InTitle'];?>" autocomplete='off'>
                              <input type="hidden" name="oldName" value="<?php echo $fetchIt['title']?>">
                          <span id="show-name"> </span>
                          </div>
                          
                          
                          <!--Description-->
                          <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['description']?></label>          
                          <span class="red small"> * </span>
                          <div class="div-input-container ">
                              <textarea  class="text-mobile input-add-page input-long" id="description" name='description' value="<?php echo $fetchIt['description'];?>"  minlength="20"  maxlength="2000" required > <?php  echo $fetchIt['description'] ?></textarea> 
                              <input type="hidden" name="oldDescription" value="<?php echo $fetchIt['description']?>">
                          <span id="show-desc"></span>
                          </div> 


                        <!-- price -->
                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-price"><?php echo $lang['price']?></label>                
                        <span class="red small"> * </span>
                        <div class="div-input-container  div-price ">
                           <input type="text" class="input-add-page select-country long" id="price" name='price' value="<?php echo $fetchIt['price']?>" placeholder="أدخل السعر" minlength="1" >
                           <input type="hidden" name="oldPrice" value="<?php echo $fetchIt['price']?>">
                           <span id="show-price"> </span>
                        </div>
                       

                        <!--discount -->
                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-price">نسبة الخصم</label>                
                        <span class="red small"> * </span>
                        <i title="مشاهدة نسب الخصم" class="fas fa-exclamation-triangle" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMsg" aria-controls="offcanvasMsg"></i>
                        <div class="div-input-container  div-price ">
                          <input type="text" class="input-ratio " id="discount" name='discount' value="<?php echo $fetchIt['discount'] ?>" placeholder="أدخل النسبة بالأرقام فقط؛ مثال: 10" minlength="1" >
                          <input type="hidden" name="oldDiscount" value="<?php echo $fetchIt['discount']?>">
                          <span class="percent">%</span>
                          <br> <span id="show-discount"> </span>
                        </div>

                        
                        <!-- canvas discount --> 
                        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasMsg" aria-labelledby="offcanvasWithBothOptionsLabel">
                            <div class="offcanvas-header offcanvas-header-msg">
                               <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                <span class=" msg-to cut2">نسبة الخصم بناء على السعر:</span>
                            </div> 
                              <div class="offcanvas-body-msg">
                                <ul>
                                  <li>السعر حتى  50 جنية مصري .. الخصم لا يقل عن 10% (فئة طعام فقط )</li>
                                  <li>السعر من 51 جنية مصري  فما فوق  .. الخصم لا يقل عن 5% (فئة طعام فقط )</li>
                                  <li>السعر حتى 300  جنية مصري .. الخصم لا يقل عن 10%</li>
                                  <li>السعر من 301 جنية مصري حتى  600 جنية مصري .. الخصم لا يقل عن 8%</li>
                                  <li>السعر من 601 جنية مصري حتى 1,000 (ألف ).. الخصم لا يقل عن 5%</li>
                                  <li>السعر من 1001 جنية مصري حتى 40,000 (أربعين ألف ).. الخصم لا يقل عن 2%</li>
                                  <li>السعر من 40001 جنية مصري فما فوق .. الخصم لا يقل عن 1%</li>
                                </ul>
                              </div>
                          </div>
                       

                        <!--price after discount -->
                         <label for="inputEmail3" class="col-sm-2 col-form-label lbl-price">السعر بعد الخصم</label>     
                         <div class="div-input-container  div-price ">
                           <input type="text" class="input-add-page select-country long" id="showPriceAfter" placeholder="هنا يظهر السعر النهائي بعد حساب الخصم" readonly="">
                           <button type="button" class="calc">اضغط لحساب السعر</button>
                         </div>
                       
                          
                        <input type="hidden" name="oldDelivery" value="<?php echo $fetchIt['delivery']?>">

                        <?php
                        if ($fetchIt['cat_id']<7||$fetchIt['cat_id']==10) { ?>
                         <!--delivery --> 
                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-price">خدمة التوصيل</label>                
                        <span class="red small"> * </span>
                        <div class="div-input-container  div-price ">
                            <div>
                              <input type="radio" name="delivery1" id="delivery1" class="delivery" value="1" <?php if($fetchIt['delivery']==1){echo "checked";} ?>>
                              <label for='delivery1'>التوصيل داخل المحافظة بمقابل</label>
                            </div>
                            <div>
                              <input type="radio" name="delivery2" id="delivery2" class="delivery" value="2" <?php if($fetchIt['delivery']==2){echo "checked";} ?>> 
                              <label for='delivery2'>التوصيل داخل المحافظة مجانا </label>
                            </div>
                            <div>
                              <input type="radio" name="delivery3" id="delivery3" class="delivery" value="3" <?php if($fetchIt['delivery']==3){echo "checked";} ?>>
                              <label for='delivery3'>التوصيل داخل المدينة بمقابل </label>
                            </div>
                            <div>
                              <input type="radio" name="delivery4" id="delivery4" class="delivery" value="4" <?php if($fetchIt['delivery']==4){echo "checked";} ?>>
                              <label for='delivery4'>التوصيل داخل المدينة مجانا </label>
                            </div>
                            <div>
                              <input type="radio" name="delivery5" id="delivery5" class="delivery" value="5" <?php if($fetchIt['delivery']==5){echo "checked";} ?>>
                              <label for='delivery5'>داخل المدينة مجانا  وداخل المحافظة بمقابل  </label>
                            </div>
                            <div>
                              <input type="radio" name="delivery6" id="delivery6" class="delivery" value="6" <?php if($fetchIt['delivery']==6){echo "checked";} ?>>
                              <label for='delivery6'>داخل المدينة مجانا  ولكل المحافظات بمقابل  </label>
                            </div>
                            <div>
                              <input type="radio" name="delivery7" id="delivery7" class="delivery" value="7" <?php if($fetchIt['delivery']==7){echo "checked";} ?>>
                              <label for='delivery7'>التوصيل لجميع المحافظات بمقابل  </label>
                            </div>
                            <div>
                              <input type="radio" name="delivery8" id="delivery8" class="delivery" value="8" <?php if($fetchIt['delivery']==8){echo "checked";} ?>>
                              <label for='delivery8'>التوصيل لجميع المحافظات  مجانا </label>
                            </div>
                            <div>
                              <input type="radio" name="delivery9" id="delivery9" class="delivery" value="9" <?php if($fetchIt['delivery']==9){echo "checked";} ?>> 
                              <label for='delivery9'>لا يوجد توصيل</label>
                            </div>
                        </div>
                        <span id="show-discount"> </span> 
                       <?php } ?>

                           
                            <!-- main photo-->
                          <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo $lang['uploadPhoto']?></label>                
                          <span class="red small"> * </span>
                          <span class="span-photo rightx alone"><?php echo $lang['allowedPicExten'].' ولا يزيد حجم الصورة عن 4 ميجا بايت  '?></span>
                           <?php 
                            if ($fetchIt['photo']>0) {
                             ?><div class="action-ph-cont">
                                  <div class="div-input-container2 cont-with-ph">
                                      <img src="data/upload/<?php echo $fetchIt['photo']?>">
                                      <input type="hidden" name="oldPhoto" value="<?php echo $fetchIt['photo']?>">
                                  </div> 
                                  <button class="showFile leftx" type="button">تغيير الصورة  الرئيسية </button>
                                  <input class="new-photo-tr" type="file" name="photo"> 
                               </div>
                         <?php }else{
                            ?> <div class="action-ph-cont">
                                <div class="div-input-container2 cont-with-no-ph">
                                  <input type="file" class="upload alone"  id="mainPhoto"  name='photo' >
                                </div>
                              </div> <?php
                           } ?>

                           <!--  photo2 --> 
                           <?php 
                            if ($fetchIt['photo2']>0) {
                             ?><div class="action-ph-cont">
                                  <div class="div-input-container2 cont-with-ph">
                                      <img src="data/upload/<?php echo $fetchIt['photo2']?>">
                                      <input type="hidden" name="oldPhoto2" value="<?php echo $fetchIt['photo2']?>">
                                  </div> 
                                  <button class="showFile leftx" type="button">تغيير الصورة  رقم  2</button>
                                  <input class="new-photo-tr" type="file" name="photo2"> 
                               </div> 
                       <?php  }else{
                            ?><div class="action-ph-cont"> 
                                <div class="div-input-container2 cont-with-no-ph">
                                  <span>أضف صورة  رقم 2 (اختياري )</span>
                                  <input type="file" class="upload alone"  id="photo2"  name='photo2' > 
                                </div>
                              </div> <?php
                           } ?>

                           <!--  photo3 -->
                           
                           <?php 
                            if ($fetchIt['photo3']>0) {
                             ?><div class="action-ph-cont">
                                 <div class="div-input-container2 cont-with-ph">
                                      <img src="data/upload/<?php echo $fetchIt['photo3']?>">
                                      <input type="hidden" name="oldPhoto3" value="<?php echo $fetchIt['photo3']?>">
                                  </div> 
                                  <button class="showFile leftx" type="button">تغيير الصورة  رقم 3 </button>
                                  <input class="new-photo-tr" type="file" name="photo3"> 
                               </div>
                        <?php  }else{ 
                            ?> <div class="action-ph-cont">
                                 <div class="div-input-container2 cont-with-no-ph">
                                    <span>أضف صورة  رقم 3 (اختياري )</span>
                                    <input type="file" class="upload alone"  id="photo3"  name='photo3' > 
                                 </div>
                              </div> <?php
                           } ?>



                           
                         
                          <div class="last-div">
                             <span class="red2">(*) = <?php echo $lang['req']?></span>
                          </div>
                          <input type="hidden" id="lng" value="<?php echo $l;?>">
                          <input type="submit" name="submit" id="add-listing-submit" value="موافق"> 
                          <p class="faults red2"></p>


                          <!--  for js -->
                          <input type="hidden" class="exceedAllowed" value="<?php echo $lang['exceedAllowed']?>">
                          <input type="hidden" class="sixCharacters" value="<?php echo $lang['sixCharacters']?>">
                          <input type="hidden" class="twentyChars" value="<?php echo $lang['twentyChars']?>">
                          <input type="hidden" class="charsLeft" value="<?php echo $lang['charsLeft']?>">
                          <input type="hidden" class="noMoreChars" value="<?php echo $lang['noMoreChars']?>">
                          <input type="hidden" class="good" value="<?php echo $lang['good'];?>">
                          <input type="hidden" class="req" value="<?php echo $lang['req'];?>">
                          <input type="hidden" class="insert" value="<?php echo $lang['insert'];?>">
                          <input type="hidden" class="digit" value="<?php echo $lang['digit'];?>">
                          <input type="hidden" class="enterPhone" value="<?php echo $lang['enterPhone'];?>">
                          <input type="hidden" class="onlyNums" value="<?php echo $lang['onlyNums'];?>">
                          <input type="hidden" class="country" value="<?php echo $fetchIt['country_id'];?>">
                          <input type="hidden" class="aboveZero" value="<?php echo $lang['aboveZero'];?>">
                      </form>                
                  </main>
        
          <?php }else{
                  header('location:logout.php?s=no');
                  exit();
               }//END if ( $fetch['user_id']==$_SESSION['traderid'])
       }//END if(isset($_GET['i']))
    


    }elseif ($d=='del_item') {
       if (isset($_GET['i']) && is_numeric($_GET['i']) && $_GET['i']>0) {
         $item_id=intval($_GET['i']);
         $fetch=fetch('user_id','items','item_id',$item_id);

        if ( $fetch['user_id']==$_SESSION['traderid']) { 
            $stmt=$conn->prepare("SELECT item_id from items WHERE item_id = ? ");
            $stmt->execute(array($item_id));
            $found=$stmt->rowCount();  
                if ($found>0) {
                   $stmt=$conn->prepare("DELETE from items WHERE item_id = ? ");
                   $stmt->execute(array($item_id));
                   ?> <div class="height bottom-lg"> <?php
                      echo "<div class='block-green'>".$lang['deleted']."</div>";
                   ?> </div> 
                   <script>
                     setTimeout(function go1(){ $('.block-green').fadeOut(); },2000);
                     setTimeout(function go2(){ location.href='profile.php?i=<?php echo $_SESSION['traderid']?>&p=items'; },2200);
                   </script> 
             <?php   }else{include 'notFound.php';}
          }else{
            header('location:logout.php?s=no'); 
            exit();
          }
      }else{
        header('location:logout.php?s=no'); 
        exit();
      }



    }elseif ($d=='unhide'){
      if (isset($_GET['i']) && is_numeric($_GET['i']) && $_GET['i']>0) {
         $item_id=intval($_GET['i']);
         $fetch=fetch('user_id','items','item_id',$item_id);

         if ( $fetch['user_id']==$_SESSION['traderid']) { 
            $stmt=$conn->prepare("SELECT item_id from items WHERE item_id = ? ");
            $stmt->execute(array($item_id));
            $found=$stmt->rowCount();  
                if ($found>0) {
                  $stmt2=$conn->prepare("UPDATE items set hide=0 WHERE item_id =? ");
                  $stmt2->execute(array($item_id));
                    if($stmt2){
                       ?> <div class="height above-lg bottom-lg"> <?php
                          echo "<div class='block-green'>تم الغاء الحجب  </div>";
                       ?> </div> 
                       <script>
                        setTimeout(function go(){ $('.block-green').fadeOut(); },2200);
                        setTimeout(function go(){ location.href='profile.php?i=<?php echo $_SESSION['traderid']?>&p=items'; },2220);
                       </script><?php
                    }else{  ?> <div class="height bottom-lg">لم يتم التنفيذ .. حاول مرة أخرى</div> <?php }
                }else{include 'notFound.php';}
          }else{
            header('location:logout.php?s=no'); 
            exit();
          }
      }else{
        header('location:logout.php?s=no'); 
        exit();
      }
    }//END elseif()






//Hide item (traders who want to hide their own items) from profile.php=>p='item'
if ($_SERVER['REQUEST_METHOD']=='POST') { 
  if (isset($_POST['item'])) {
   $item=$_POST['item'];
   $num=count($item);
      for ($i=0; $i <$num ; $i++) {
              $stmt=$conn->prepare(" UPDATE items SET hide=1 WHERE item_id = ? ");
              $stmt->execute(array($item[$i]));
      }//END for($i=0; $i <$num ; $i++){}
        if ($stmt) { ?>
             <div class="height above-lg bottom-lg">   
               <?php echo "<div class='block-green '>تم  الحجب  </div>"; ?>
             </div> 
             <script>
               setTimeout(function go(){ $('.block-green').fadeOut(); },2100);
               setTimeout(function go(){ location.href='profile.php?i=<?php echo $_SESSION['traderid']?>&p=items'; },2120);
             </script> 
      <?php }
   




    //delete messages from => profile.php p=msg  
   }elseif (isset($_POST['chkMsg'])) {
      $chkMsg=$_POST['chkMsg']; 
      $num=count($chkMsg);
     for ($i=0; $i <$num ; $i++) {
              $stmt=$conn->prepare(" DELETE from message WHERE message_id = ? ");
              $stmt->execute(array($chkMsg[$i]));
                  if ($stmt) { ?>
                       <div class="height bottom-lg">   
                         <?php echo "<div class='block-green '>تم  الحذف   </div>"; ?>
                       </div> 
                       <script>
                         setTimeout(function go(){ $('.block-green').fadeOut(); },2000);
                         setTimeout(function go(){ location.href='profile.php?i=<?php echo $_SESSION['traderid']?>&p=msg'; },2050);
                       </script> 
                <?php }
      }//END for($i=0; $i <$num ; $i++){}




   //report unserious buyer & cut mostafed rates or reduce them if qnty is reduced by buyer
   //coming from process1.php ($d=='report')
   }elseif (isset($_POST['reportBuyer'])||isset($_POST['noSell'])) { 
    ?><div class="height"> <?php
    $noSell  =isset($_POST['noSell'])?$_POST['noSell']:0;
    $qnChange=isset($_POST['qnChange'])?$_POST['qnChange']:0;
    $newQnty =isset($_POST['qnty'])?$_POST['qnty']:0;
    $order_id=$_POST['order_id'];//hidden input
      
          $fetchReport=fetch('*','orders','order_id',$order_id);
          if ($fetchReport['report']==1 || $fetchReport['num2']>0 ) {
              ?><div class="block2">تم التبليغ عن هذا الطلب من قبل  </div><?php
          }else{
              if ($noSell==0&&$qnChange==0) {
                ?><div class="block2">اختر سبب التبليغ </div><?php
              
              }elseif ($noSell==1) {
                  $stmt=$conn->prepare(" UPDATE orders set report=1 where  order_id=? ");
                  $stmt->execute(array($order_id));

                        if ($stmt) { ?>
                    <div class="block-green">تم التبليغ عن عدم جدية المشتري  </div>
                    <script>
                      setTimeout(function div(){ $('.height').fadeOut();},2200);
                      setTimeout(function go(){location.href='profile.php?i=<?php echo $_SESSION['traderid']?>&p=orders';},2250);
                    </script>
              <?php } 
              }elseif ($qnChange==1&&$newQnty==0) {
                    ?><div class="block2">أدخل الكمية التي تم شراؤها  منكم  </div><?php
              }elseif($qnChange==1&&$newQnty>0){
                       $reason=$newQnty;//1 or 2
                  $stmt=$conn->prepare(" UPDATE orders set num2=? where  order_id=? ");
                  $stmt->execute(array($reason,$order_id));
                    if ($stmt) { ?>
                    <div class="block-green">تم التبليغ لكي يتم تعديل الكمية من  <?php echo '('.$fetchReport['num'].')'?>الى  <?php echo '('.$reason.')';?> </div>
                    <script>
                      setTimeout(function div(){ $('.height').fadeOut();},2200);
                      setTimeout(function go(){location.href='profile.php?i=<?php echo $_SESSION['traderid']?>&p=orders';},2250);
                    </script>
              <?php }
                } //END elseif($qnChange==1&&$newQnty>0)
              } //END else              
           
          ?> </div><?php 





   //unreport => coming from process1.php ($d=='unreport')
   }elseif (isset($_POST['unreport'])) {
      ?><div class="height"> <?php
    $sold  =!empty($_POST['sold'])?1:0;
    $order_id=$_POST['order_id'];
      
          $fetchReport=fetch('*','orders','order_id',$order_id);
          if ($fetchReport['report']==1||$fetchReport['num2']>0  ) {
             if ($sold==1) { 
                 $stmt=$conn->prepare(' SELECT num,num2,modefy,item_id from orders  where order_id=?');
                 $stmt->execute(array($order_id));
                 $payCut=$stmt->fetch();

                 $item_id1=$payCut['item_id'];//item_id
                 $item_id =fetch('item_mostafed','items','item_id',$item_id1);
                 $mos=$item_id['item_mostafed'];
                 $modefy=$payCut['modefy'];//Quantity modefication resolved or not
                 $num   =$payCut['num'];//quantity before
                 $num2  =$payCut['num2'];//quantity after 

                 if ($modefy==1) { //report already dealt with
                  if ($num2>0) {  //less quantity was reported
                    if($num>1){ //Quantity is more than one in placed order
                        if ($num2==1&&$num==3) {
                          $newMos=$mos*3;
                          $returnThis=$mos*2;
                        }elseif ($num2==2&&$num==3) {
                          $newMos=$mos*3; 
                          $returnThis=$mos; 
                        }elseif ($num2==1&&$num==2) {
                          $newMos=$mos*2; 
                          $returnThis=$mos; 
                        }

                          $trader_id=fetch('trader_id','orders','order_id',$order_id);//trader_id
                          $credit=fetch('credit','user','user_id',$trader_id['trader_id']);//credit
                          $newCredit=$credit['credit'] - $returnThis;
                       
                         $stmt=$conn->prepare(" UPDATE orders set order_mostafed=?,report=2,num2=0 where  order_id=? ");
                         $stmt->execute(array($newMos,$order_id));
                        if ($stmt) { //change to increase credit 
                          $stmt1=$conn->prepare(' UPDATE user set credit=?  where user_id=? ');
                          $stmt1->execute(array($newCredit,$trader_id['trader_id']));
                          if ($stmt1) { ?>
                            <div class="block-green">تم التراجع عن التبليغ  </div>
                            <script>
                              setTimeout(function go(){location.href='profile.php?i=<?php echo $_SESSION['traderid']?>&p=orders';},2000);
                            </script>
                        <?php  }
                     } 
                   } //END if($num>1)
                 } //END if ($num2>0)   
               }else{ //END if ($modefy==1)
                  $stmt=$conn->prepare(" UPDATE orders set report=2 where  order_id=? ");
                  $stmt->execute(array($order_id)); 
                  if ($stmt) { ?>
                      <div class="block-green">تم التراجع عن التبليغ  </div>
                      <script>
                        setTimeout(function div(){ $('.height').fadeOut();},2000);
                        setTimeout(function go(){location.href='profile.php?i=<?php echo $_SESSION['traderid']?>&p=orders';},2050);
                      </script>
                <?php  }
               } 

             }else{ ?><div class="block2">يلزم تأكيد سبب التراجع  </div> <?php }
         } //END  if ($fetchReport['report']==1       
       ?> </div><?php 

   }//end elseif()





}//END if ($_SERVER['REQUEST_METHOD']=='POST')






}else{ //END $session 
  header('location:logout.php?s=no');
  exit();
}   








include  $tmpl ."footer.inc";
include 'foot.php';
ob_end_flush();
