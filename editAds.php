<?php
ob_start();
session_start();
$title='Edit Ads';       //title of the page
include 'init.php';



    if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

    if (isset($session) ) {  
           if (isset($_GET['i']) && is_numeric($_GET['i']) ) {
                $item_id=$_GET['i'];
                $fetch=itemFetch('items.item_id',$item_id);
         	      ?>
         	      <main class="main2">
         	      	<form class=" form-add-listing form-add" action="formUpdate.php" method="POST" enctype="multipart/form-data">
                         <h1 class="h1-style">تعديل  اعلان</h1>
                           <!--category-->
                          <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['cat']?> </label>
                          <span class="red small"> * </span>
                          <div class="div-input-container  ">
                            <input type="text" class="select-subcats" value="<?php echo $fetch['cat_nameAR']?>" disabled>
                          </div>



                          <!--SubCategory-->
                          <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['subCat']?> </label>
                          <span class="red small"> * </span>
                          <div class="div-input-container  ">
                            <input type="text" class="select-subcats" value="<?php echo $fetch['subcat_nameAR']?>" disabled>
                          </div>


                          <!--title-->
                          <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['title']?> </label>
                          <span class="red small"> * </span>
                          <div class="div-input-container  "> 
                            <input type="text" class="input-add-page" id="name" name="name" minlength="8" maxlength="90" placeholder="<?php echo $lang['wirte8InTitle'];?>" value="<?php echo $fetch['title']?>">
                            <input type="hidden" name="oldName" value="<?php echo $fetch['title']?>">
                          <span id="show-name"> </span>
                          </div>
                          
                          
                                    <!--Description-->
                          <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['description']?></label>          
                          <span class="red small"> * </span>
                          <div class="div-input-container  ">
                              <textarea  class="text-mobile input-add-page" id="description" name='description' placeholder="<?php echo $lang['wirte8InDesc']?>"  minlength="20"  maxlength="2000" value="<?php echo $fetch['description']?>"><?php echo $fetch['description']?></textarea> 
                             <input type="hidden" name="oldDescription" value="<?php echo $fetch['description']?>">
                          <span id="show-desc"></span>
                          </div> 
                          



                        <!--country-->
                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['chooseCont']?></label>                
                        <span class="red small"> * </span>
                        <div class="div-input-container  ">
                            <input type="text" class="select-subcats" value="<?php echo $fetch['country_nameAR']?>" disabled>
                           <input type="hidden"  name="country" value="<?php echo $fetch['country_id'];?>">
                           </div>



                        <!--state-->
                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['chooseSt']?></label>                
                        <span class="red small"> * </span>
                        <div class="div-input-container  ">
                            <input type="text" class="select-subcats" value="<?php echo $fetch['state_nameAR']?>" disabled>
                        </div>




                         <!--city-->
                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['chooseCity']?></label>                
                        <span class="red small"> * </span>
                        <div class="div-input-container  ">
                            <input type="text" class="select-subcats" value="<?php echo $fetch['city_nameAR']?>" disabled>
                        </div>



                        <!--phone -->
                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-price"><?php echo $lang['phone']?></label>                
                        <span class="red small"> * </span>
                        <div class="div-input-container  div-price ">
                        <input type="text" class="phoneListing2 input-add-page select-country" id="phone" name='phone' placeholder="أدخل رقم المحمول" value='<?php echo '0'.$fetch['phone']?>' minlength="1" maxlength="11" required>
                        <input type="hidden" name="oldPhone" value="<?php echo $fetch['phone']?>">
                        <span id="" class="show-phone"> </span>
                        </div>
                        


                        
                        <!--price -->
                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-price"><?php echo $lang['price']?></label>                
                        <span class="red small"> * </span>
                        <div class="div-input-container  div-price ">
                        <input type="text" class="input-add-page select-country long" id="price" name='price' placeholder="أدخل السعر" value="<?php echo $fetch['price']?>" minlength="1" required>
                        <input type="hidden" name="oldPrice" value="<?php echo $fetch['price']?>">
                        <span id="show-price"> </span>
                        </div>
                       


                        <!--discount -->
                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-price">نسبة الخصم</label>                
                        <span class="red small"> * </span>
                        <div class="div-input-container  div-price ">
                        <input type="text" class="input-add-page select-country long" id="discount" name='discount' placeholder="أدخل الخصم" value="<?php echo $fetch['discount']?>" minlength="1" required>
                        <input type="hidden" name="oldDiscount" value="<?php echo $fetch['discount']?>">
                        <span class="percent">%</span>
                        <br> <span id="show-discount"> </span>
                        </div>
                       
                       

                        <!--price after discount -->
                         <label for="inputEmail3" class="col-sm-2 col-form-label lbl-price">السعر بعد الخصم</label>     
                         <div class="div-input-container  div-price ">
                         <input type="text" class="input-add-page select-country long" id="showPriceAfter" placeholder="هنا يظهر السعر النهائي بعد حساب الخصم" readonly="">
                         <button type="button" class="calc">اضغط لحساب السعر</button>
                         </div>


                         <!--delivery -->
                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-price">هل  الشحن  متوفر؟</label>                
                        <span class="red small"> * </span>
                        <div class="div-input-container  div-price ">
                            <div>
                              <?php
                              if ($fetch['delivery']==1) { ?>
                                <input type="radio" name="delivery1" id="delivery1" class="delivery" value="1" checked="">
                            <?php  }else{ ?>
                                 <input type="radio" name="delivery1" id="delivery1" class="delivery" value="1">
                           <?php } ?>
                              <label for='delivery1'>متوفر شحن داخلي بمقابل    </label>
                            </div>
                            <div>
                              <?php
                              if ($fetch['delivery']==2) { ?>
                                 <input type="radio" name="delivery2" id="delivery2" class="delivery" value="2" checked="">
                            <?php  }else{ ?>
                                 <input type="radio" name="delivery2" id="delivery2" class="delivery" value="2">
                           <?php } ?>
                              <label for='delivery2'>متوفر شحن  داخلي مجاني     </label>
                            </div>
                            <div>
                              <?php
                              if ($fetch['delivery']==3) { ?>
                                 <input type="radio" name="delivery3" id="delivery3" class="delivery" value="3" checked="">
                            <?php  }else{ ?>
                                 <input type="radio" name="delivery3" id="delivery3" class="delivery" value="3">
                           <?php } ?>
                              <label for='delivery3'>متوفر شحن  داخلي ومحافظات  بمقابل    </label>
                            </div>
                            <div>
                              <?php
                              if ($fetch['delivery']==4) { ?>
                                 <input type="radio" name="delivery4" id="delivery4" class="delivery" value="4" checked="">
                            <?php  }else{ ?>
                                 <input type="radio" name="delivery4" id="delivery4" class="delivery" value="4">
                           <?php } ?>
                              <label for='delivery4'>متوفر شحن داخلي ومحافظات مجاني    </label>
                            </div>
                            <div>
                              <?php
                              if ($fetch['delivery']==5) { ?>
                                 <input type="radio" name="delivery5" id="delivery5" class="delivery" value="5" checked="">
                            <?php  }else{ ?>
                                 <input type="radio" name="delivery5" id="delivery5" class="delivery" value="5">
                           <?php } ?>
                              <label for='delivery5'>لا يتوفر شحن   </label>
                            </div>
                        </div>
                        <span id="show-discount"> </span>



                           
                            <!--main photo-->
                          <label for="inputEmail3" class="col-sm-2 col-form-label-file"><?php echo $lang['uploadPhoto']?></label>                
                          <span class="span-photo rightx alone"><?php echo $lang['allowedPicExten']?></span>
                          <div class="div-input-container2 ">
                            <?php
                            if (isset($fetch['photo'])&&$fetch['photo']>0) {
                             ?>
                             <img src="data\upload\<?php echo $fetch['photo'] ?>"> 
                             <input type="hidden" name="oldPhoto" value="<?php echo $fetch['photo'] ?>">
                             <div>
                               <span>change</span>
                               <input type="file" class="upload alone"  id="mainPhoto"  name='photo' >
                             </div>
                             <?php
                            }else{ ?>
                              <input type="file" class="upload alone"  id="mainPhoto"  name='photo' >
                              <span class="span-photo"><?php echo $lang['mainPhoto']?></span>
                              <span class="red small"> * </span>
                           <?php } ?>
                          </div>
                          
                          <!--photos-->
                          <div class="div-input-container2  ">
                                <?php
                                if (isset($fetch['photo2']) && $fetch['photo2']>0) {
                                 ?>
                                 <img src="data\upload\<?php echo $fetch['photo2'] ?>">
                                 <div>
                                   <span>change</span>
                                   <input type="file" class="upload alone "  id=""  name='photo2'  >
                                 </div>
                                 <input type="hidden" name="oldPhoto2" value="<?php echo $fetch['photo2'] ?>">
                                 <?php
                                }else{ ?>
                                <input type="file" class="upload alone "  id=""  name='photo2'  >
                                <span class="span-photo"><?php echo $lang['photo2']?> &nbsp;(<?php echo $lang['opt']?>)</span><br>
                              <?php  }  ?>
                                <!--<input type="file" class="upload alone above"  id=""  name='photo3'  >
                                <span class="span-photo"><?php echo $lang['photo3']?> &nbsp;(<?php echo $lang['opt']?>)</span><br>-->
                              <!--<div>
                                <input type="file" class="upload alone above"  id=""  name='photo4'  >
                                <span class="span-photo"><?php echo $lang['photo4']?> &nbsp;(<?php echo $lang['opt']?>)</span><br>
                                <input type="file" class="upload alone above"  id=""  name='photo5'  >
                                <span class="span-photo"><?php echo $lang['photo5']?> &nbsp; (<?php echo $lang['opt']?>)</span>
                             </div>-->
                          </div>

                          
                              
                          <div class="last-div">
                             <span class="span-required2">(*) = <?php echo $lang['req']?></span>
                          </div>
                         
                          <input type="hidden" id="lng" value="<?php echo $l;?>">
                          <!--<input type="checkbox" class="terms"  id="terms"  name='terms' required >
                          <span class="span-terms"><?php echo $lang['iRead']?> <a href="terms.php"><?php echo $lang['terms']?></a> & <a href="policy.php"><?php echo $lang['priv']?></a></span>-->
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
                          <input type="hidden" class="country" name="country" value="<?php echo $fetch['country_id'];?>">
                          <input type="hidden" class="aboveZero" value="<?php echo $lang['aboveZero'];?>">
                  </form>                
             </main>
        


                      <!--ajax coner -->
                      <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
                      <script>
                      $(document).ready(function(){
                         //ajax 
                         $('#add-listing-submit').on('click',function(e){
                         var Sub= $('#subcat').val();
                         var Sub2= $('#subcat2').val();
                         var name= $('#name').val().length;
                         var desc= $('#description').val().length;
                         var price= $('#price').val();
                         var discount= $('#discount').val();
                         var Cont= $('#country').val();
                         var state=$('#state').val();
                         var city=$('#city').val();
                         var phone= $('#phone').val();
                         var mainPhoto= $('#mainPhoto').val();
                         var delivery1= $('#delivery1').val();var delivery2= $('#delivery2').val();var delivery3= $('#delivery3').val();var delivery4= $('#delivery4').val();var delivery5= $('#delivery5').val();

                        if(Sub==0||Sub2==0||name<1||desc<1||price==0||discount==0||Cont==0||state==0||city==0||phone==0||mainPhoto==0||(delivery1==0&&delivery2==0&&delivery3==0&&delivery4==0&&delivery5==0) ){
                       e.preventDefault();
                       $(this).addClass('disabled',true);
                       $('.faults').text('<?php echo $lang['faults'] ?>');
                       }else{
                       $.ajax({
                        success:function(data){
                        //  $("#country").val(' ');
                          $("#state").val(' ');
                          $("#city").val(' ');
                          $("#subcat").val(' ');
                          $("#subcat2").val(' ');
                        }
                       });
                        } //end if
                      });
                     
                         
                        });
                    </script>
                    
                


         <?php
         }else{ // END isset($_GET['i'])
           header('location:login.php');
           exit();
         }


}else  {// END isset($_SESSION['user'])
   header('location:login.php');
   exit();
}
 
 
 include  $tmpl ."footer.inc";
 include 'foot.php';
 ob_end_flush();
 ?>