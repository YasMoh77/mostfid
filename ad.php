<?php
ob_start();
session_start();
$title='أضف اعلان ';       //title of the page 
include 'init.php';



if (isset($_SESSION['traderid'])) { //trader 
  $session=$_SESSION['traderid']; 
//if activated==0 => email updated but not verified & if user or trader is banned 
  banned($session);
  } 
    if (isset($_SESSION['traderid']) ) {  ?>        
         	     
                <main class="main2">
         	      	<form class=" form-add-listing form-add" action="form.php" method="POST" enctype="multipart/form-data">
                         <h1 class="h1-style">أضف  اعلان  </h1>
                           <!--category-->
                          <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['cat']?> </label>
                          <span class="red small"> * </span>
                          <div class="div-input-container  ">
                          <select class="select-subcats" name="categories1" id="subcat">
                            <?php
                              $stmt=$conn->prepare(" SELECT * from categories ");
                              $stmt->execute();$cats=$stmt->fetchAll();
                              $count=$stmt->rowCount();
                           ?> <option value="0" ><?php echo $lang['choose']?></option> <?php
                           if($count>0){ 
                             foreach ($cats as $cat) {
                              if($l=='ar'){echo "<option value='".$cat['cat_id']."'>".$cat['cat_nameAR']."</option>";}
                             } } ?>
                          </select>
                          </div> 


                          <!--SubCategory-->
                          <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['subCat']?> </label>
                          <span class="red small"> * </span>
                          <div class="div-input-container  ">
                            <select class="select-subcats" name="categories2" id="subcat2">
                               <option value="0">اختر</option>
                            </select> 
                          </div>


                          <!--title-->
                          <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['title']?> </label>
                          <span class="red small"> * </span> 
                          <div class="div-input-container  "> 
                              <input type="text" class="input-add-page input-long" id="name" name="name" minlength="8" maxlength="60" placeholder="<?php echo $lang['wirte8InTitle'];?>">
                          <span id="show-name"> </span>
                          </div>
                          
                          
                                    <!--Description-->
                          <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['description']?></label>          
                          <span class="red small"> * </span>
                          <div class="div-input-container  ">
                              <textarea  class="text-mobile input-add-page input-long" id="description" name='description' placeholder="<?php echo $lang['wirte8InDesc']?>"  minlength="20"  maxlength="2000"></textarea> 
                          <span id="show-desc"></span>
                          </div> 



                        <!--country-->
                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['chooseCont']?></label>                
                        <span class="red small"> * </span>
                        <div class="div-input-container  ">
                          
                            <select class=" inputPassword  select-country input-add-page" id="country"  name='country' readonly >
                                    <!--<option value=" "><?php echo $lang['choose']?></option>-->
                                    <?php
                                     $fetch=fetch('country_id','user','user_id',$_SESSION['traderid']);
                                     $stmt=$conn->prepare(" SELECT * from country
                                     join user on user.country_id=country.country_id where user.country_id=? ");
                                     $stmt->execute(array($fetch['country_id']));
                                     $country2=$stmt->fetch();

                                     if($l=='ar'){echo "<option value=".$country2['country_id'].">".$country2['country_nameAR']."</option>";}
                                     else{echo "<option value=".$country2['country_id'].">".$country2['country_name']."</option>";}
                                     ?>
                            </select>
                           </div>

                           

                           <!--state-->
                        <?php 
                         $stmt2=$conn->prepare(" SELECT state.*,country.* from state 
                         join country on state.country_id=country.country_id where country.country_id=? ");
                         $stmt2->execute(array($fetch['country_id']));
                         $states=$stmt2->fetchAll();
                        ?>
                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['chooseSt']?></label>                
                        <span class="red small"> * </span>
                        <div class="div-input-container  ">
                            <select class=" inputPassword  select-country" id="state"  name='state' required >
                                <option value="0"><?php echo $lang['choose']?></option>
                                <?php
                                if(!empty($states)){
                                 foreach ($states as  $value) {
                                 if($l=='ar'){echo "<option value=".$value['state_id'].">".$value['state_nameAR']."</option>";}
                                 else{echo "<option value=".$value['state_id'].">".$value['state_name']."</option>";}
                                } } ?>
                            </select>
                        </div>

                        

                         <!--city-->
                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-top"><?php echo $lang['chooseCity']?></label>                
                        <span class="red small"> * </span>
                        <div class="div-input-container  ">
                            <select class=" inputPassword  select-country" id="city"  name='city' required >
                              <option value="0"><?php echo $lang['choose']?></option>
                            </select>
                        </div>


                        
                       <!-- price -->
                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-price"><?php echo $lang['price']?></label>                
                        <span class="red small"> * </span>
                        <div class="div-input-container  div-price ">
                           <input type="text" class="input-add-page select-country long" id="price" name='price' placeholder="أدخل السعر" minlength="1" required autocomplete="off">
                           <span id="show-price"> </span> 
                        </div>
                       


                        <!--discount -->
                        <label for="inputEmail3" class="col-sm-2 col-form-label lbl-price">نسبة الخصم</label>                
                        <span class="red small"> * </span>
                        <i title="مشاهدة نسب الخصم" class="fas fa-exclamation-triangle" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMsg" aria-controls="offcanvasMsg"></i>
                        <div class="div-input-container  div-price ">
                          <input type="text" class="input-ratio select-country long" id="discount" name='discount' placeholder="أدخل النسبة بالأرقام فقط؛ مثال: 10" minlength="1" required autocomplete="off">
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
                                <ul class="canvas-ul"> 
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


                         <!--delivery -->
                        <label id="lblDeliv" class="col-sm-2 col-form-label lbl-price">خدمة التوصيل</label>                
                        <span id="spanDeliv" class="red small"> * </span>
                        <div id="divDeliv" class="div-input-container  div-price ">
                            <div>
                              <input type="radio" name="delivery1" id="delivery1" class="delivery" value="1">
                              <label for='delivery1'>التوصيل داخل المحافظة بمقابل</label>
                            </div> 
                            <div>
                              <input type="radio" name="delivery2" id="delivery2" class="delivery" value="2"> 
                              <label for='delivery2'>التوصيل داخل المحافظة مجانا </label> 
                            </div>
                            <div> 
                              <input type="radio" name="delivery3" id="delivery3" class="delivery" value="3">
                              <label for='delivery3'>التوصيل داخل المدينة بمقابل </label>
                            </div>
                            <div>
                              <input type="radio" name="delivery4" id="delivery4" class="delivery" value="4">
                              <label for='delivery4'>التوصيل داخل المدينة مجانا </label>
                            </div>
                            <div>
                              <input type="radio" name="delivery5" id="delivery5" class="delivery" value="5">
                              <label for='delivery5'>داخل المدينة مجانا  وداخل المحافظة بمقابل  </label>
                            </div> 
                            <div>
                              <input type="radio" name="delivery6" id="delivery6" class="delivery" value="6">
                              <label for='delivery6'>داخل المدينة مجانا  ولكل المحافظات بمقابل  </label>
                            </div>
                            <div>
                              <input type="radio" name="delivery7" id="delivery7" class="delivery" value="7">
                              <label for='delivery7'>التوصيل لكل المحافظات بمقابل  </label>
                            </div>
                            <div>
                              <input type="radio" name="delivery8" id="delivery8" class="delivery" value="8">
                              <label for='delivery8'>التوصيل لكل المحافظات  مجانا </label>
                            </div>
                            <div>
                              <input type="radio" name="delivery9" id="delivery9" class="delivery" value="9"> 
                              <label for='delivery9'>لا يوجد توصيل</label>
                            </div>
                        </div>


                        <label id="lblProp" class="col-sm-2 col-form-label lbl-price">حدد موقفك  </label>                
                        <span id="spanProp" class="red small"> * </span>
                        <div id="divProp" class="div-input-container  div-price ">
                          <div><input type="radio" class="delivery" id="sit1" name="sit1" value="1"><span class="right">انا المالك  </span></div>
                          <div><input type="radio" class="delivery" id="sit2" name="sit2" value="2"><span class="right">أنا وسيط  </span></div>
                        </div>

                        


                           
                            <!-- main photo-->
                          <label for="inputEmail3" class="col-sm-2 col-form-label"><?php echo $lang['uploadPhoto']?></label>                
                          
                          <span class="span-photo rightx alone"><?php echo $lang['allowedPicExten'].' ولا يزيد حجم الصورة عن 4 ميجا بايت  '?></span>
                          <div class="div-input-container2 ">
                              <input type="file" class="upload alone"  id="mainPhoto"  name='photo' >
                              <span class="span-photo"><?php echo $lang['mainPhoto']?></span>
                              <span class="red small"> * </span>
                          </div>
                          <div class="div-input-container2 ">
                              <input type="file" class="upload alone"  id="photo2"  name='photo2' >
                              <span class="span-photo">صورة رقم 2 </span>
                          </div>
                          <div class="div-input-container2 ">
                              <input type="file" class="upload alone"  id="photo3"  name='photo3' >
                              <span class="span-photo">صورة رقم 3</span>
                          </div>
                          
                         

                              
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
                          <input type="hidden" class="country" value="<?php echo $fetch['country_id'];?>">
                          <input type="hidden" class="aboveZero" value="<?php echo $lang['aboveZero'];?>">
                
                      </form>                
                  </main>
        

                      <!--ajax coner -->
                      <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
                      <script>
                      $(document).ready(function(){
                        //ajax call country to return states
                        $("#country").on("change", function(){
                          var country=$(this).val();
                          var l=$('#lng').val();
                          $.ajax({
                          url:"catSelect.php",
                          data:{sentCountry:country,l:l},
                          success: function(data){                             
                            $("#state").html(data);
                             }
                           });
                        });
                        //ajax call state
                        $("#state,#country").on("change", function(){
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
                        //ajax call subcats for search box
                          $("#subcat").on("change", function(){
                          var cats=$(this).val();
                          var L=$('#lng').val();
                          $.ajax({
                          url:"showSubCats.php",
                          data:{sentCats:cats,l:L},
                          success: function(data){                             
                            $('#subcat2').html(data);
                             }
                           });
                         });
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
                         var sit1= $('#sit1').val();var sit2= $('#sit2').val();

                        if(Sub==0||Sub2==0||name<1||desc<1||price==0||discount==0||Cont==0||state==0||city==0||phone==0||mainPhoto==0||(delivery1==0&&delivery2==0&&delivery3==0&&delivery4==0&&delivery5==0) || (sit1==0&&sit2==0) ){
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
        /* }else{ // END isset($_GET['id'])
           header('location:login.php');
           exit();
         }*/


}else {// END isset($_SESSION['traderid'])
   header('location:login.php');
   exit();
}
 
 
 include  $tmpl ."footer.inc";
 include 'foot.php';
 ob_end_flush();
 ?>