<?php
ob_start();
session_start();
$title='form';
include 'init.php';



 if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader

if (isset($session) ) { 
      if ($_SERVER['REQUEST_METHOD'] =='POST') {
      //sending categories
      $cat1          =isset($_POST['categories1'])?$_POST['categories1']:0;
      $cat2          =isset($_POST['categories2'])?$_POST['categories2']:0;
      $name          =$_POST['name'];
      $desc          =$_POST['description'];
      $price         =isset($_POST['price'])&&is_numeric($_POST['price'])?intval($_POST['price']):0;
      $country       =isset($_POST['country'])?$_POST['country']:0;
      $state         =isset($_POST['state'])?$_POST['state']:0;
      $city          =isset($_POST['city'])?$_POST['city']:0; 
      $discount      =isset($_POST['discount'])&&is_numeric($_POST['discount'])?intval($_POST['discount']):0;
      $time          =date('Y-m-d');
       
      // sum of final price 
      /* $ratio=$price*($discount/100);
       $finalPrice=$price-$ratio;*/

     
       //===========DELIVERY CHECKBOXES ============
       $deliveryA=0;
      if (!empty($_POST['delivery1'])) {
        $deliveryA=$_POST['delivery1'];
      }elseif (!empty($_POST['delivery2'])) {
        $deliveryA=$_POST['delivery2'];
      }elseif (!empty($_POST['delivery3'])) {
        $deliveryA=$_POST['delivery3'];
      }elseif (!empty($_POST['delivery4'])) {
        $deliveryA=$_POST['delivery4'];
      }elseif (!empty($_POST['delivery5'])) {
        $deliveryA=$_POST['delivery5'];
      }elseif (!empty($_POST['delivery6'])) {
        $deliveryA=$_POST['delivery6'];
      }elseif (!empty($_POST['delivery7'])) {
        $deliveryA=$_POST['delivery7'];
      }elseif (!empty($_POST['delivery8'])) {
        $deliveryA=$_POST['delivery8'];
      }elseif (!empty($_POST['delivery9'])) {
        $deliveryA=$_POST['delivery9'];
      }

   
     
      //sanitize variables
      $filteredCat1     =filter_var($cat1, FILTER_SANITIZE_NUMBER_INT);
      $filteredCat2     =filter_var($cat2, FILTER_SANITIZE_NUMBER_INT);
      $filteredName     =filter_var(trim($name) , FILTER_SANITIZE_STRING);
      $filteredDesc     =filter_var(trim($desc) , FILTER_SANITIZE_STRING);
      $filteredPrice    =filter_var(trim($price) , FILTER_SANITIZE_NUMBER_INT);
      $filteredCountry  =filter_var($country, FILTER_SANITIZE_NUMBER_INT);
      $filteredState    =filter_var($state, FILTER_SANITIZE_NUMBER_INT);
      $filteredCity     =filter_var($city, FILTER_SANITIZE_NUMBER_INT);
      $filteredDiscount =filter_var(trim($discount), FILTER_SANITIZE_NUMBER_INT);
      

      //delivery 
       $delivery=$filteredCat1<7||$filteredCat1==10?$deliveryA:9;//9=no delivery

      //situation (broker or owner) 
      $sitA=0; 
      if ( isset($_POST['sit1'])&&$_POST['sit1']==1) { $sitA=1;}
      elseif ( isset($_POST['sit2'])&&$_POST['sit2']==2) { $sitA=2;}
       $sit=($filteredCat1==7||$filteredCat1==8)&&$sitA>0?$sitA:0;


      //mostafed rates
      $AfterCutPrice=$filteredPrice-($filteredPrice*($filteredDiscount/100));
      if($filteredCat1==7||$filteredCat2==39){ //property & cars
         //.25% of the after discount price is mostafed rate 
         $mostafed=$AfterCutPrice*(.25/100);

       }elseif ($filteredCat2==22||$filteredCat2==28||$filteredCat2==59||$filteredCat2==60||$filteredCat2==61) { //22=cloth,28=ceramic,59=electric works,60 painting,61 ceramic works
         if ($filteredCat2==22) {$mostafed=2;}else{$mostafed=4;} //22=cloth
      }else{
        //.5% of the after discount price is mostafed rate 
        $mostafed=$AfterCutPrice*(.5/100);
      } //END  if ($filteredCat2==22||
       

      

      //main photo
      $photoName=$_FILES['photo']['name'];
      $photoSize=$_FILES['photo']['size'];
      $photoTmp =$_FILES['photo']['tmp_name']; 
      $photoType=$_FILES['photo']['type'];
      //refine photo upload
      $expl=explode(".", $photoName);
      $refinedPhotoName=strtolower(end($expl));
      $allowedExtensions=array('jpg','jpeg','png');

      // photo 2
      $photoName2=$_FILES['photo2']['name'];
      $photoSize2=$_FILES['photo2']['size'];
      $photoTmp2 =$_FILES['photo2']['tmp_name']; 
      $photoType2=$_FILES['photo2']['type'];
      //refine photo2 upload
      $expl2=explode(".", $photoName2);
      $refinedPhotoName2=strtolower(end($expl2));
       
       // photo 3
      $photoName3=$_FILES['photo3']['name'];
      $photoSize3=$_FILES['photo3']['size'];
      $photoTmp3 =$_FILES['photo3']['tmp_name']; 
      $photoType3=$_FILES['photo3']['type'];
      //refine photo3 upload
      $expl3=explode(".", $photoName3);
      $refinedPhotoName3=strtolower(end($expl3));
       
      
      //array to show errors
      $errors=array();
        //CAT
      if ($filteredCat1==0 ) {
        $errors[]='<div class="block2">'.$lang['chooseCat'].'</div>';
      }
        //SUBCAT
      if ($filteredCat2==0 ) {
        $errors[]='<div class="block2">'.$lang['chooseSub'].'</div>';
      }
       
        //NAME
      if (mb_strlen (trim($filteredName))<8) {// short name
        $errors[]='<div class="block2">'.$lang['wirte8InTitle'].' في حقل العنوان '.'</div>';
      }
      if (mb_strlen (trim($filteredName))>60) {
        $errors[]='<div class="block2">'.$lang['wirte60OnlyInTitle'].' في حقل العنوان '.'</div>';
      }
       //DESCRIPTION

      if (mb_strlen (trim($filteredDesc))<20) {
        $errors[]='<div class="block2">'.$lang['wirte8InDesc'].' في حقل الوصف '.'</div>';
      }
      if (mb_strlen (trim($filteredDesc))>2000) {
        $errors[]='<div class="block2">'.$lang['DescTooLong'].' في حقل الوصف '.'</div>';
      } 

       //COUNTRY
       if ($filteredCountry==0) {
        $errors[]='<div class="block2">'.$lang['plsChooseCont'].'</div>';
      }
       //STATE
      if ($filteredState==0) {
        $errors[]='<div class="block2">'.$lang['plsChooseSt'].'</div>';
      }
        //CITY
      if ($filteredCity==0) {
        $errors[]='<div class="block2">'.$lang['plsChooseCity'].'</div>';
      }
       //PRICE
      if ( $filteredPrice==0) {
        $errors[]='<div class="block2">'.$lang['plsAddPrice'].'</div>';
      }

      //DISCOUNT 
      if ( $filteredDiscount==0) { 
              $errors[]='<div class="block2">'.$lang['plsAddDisc'].'</div>';
            }else{
                  if($filteredCat1==1){
                     if ($filteredPrice<=50&&$filteredDiscount<10) {
                       $errors[]='<div class="block2">لا تقل نسبة الخصم عن 10% للأسعار حتى 50 جنيه مصري  (فئة طعام فقط )</div>';
                     }elseif ($filteredPrice>=51&&$filteredDiscount<5) {
                       $errors[]='<div class="block2">لا تقل نسبة الخصم عن 5% للأسعار  فوق 50 جنيه مصري  (فئة طعام فقط )</div>';
                     }
                 }elseif ($filteredCat1==12) { //transport
                       if ($filteredPrice<=4000&&$filteredDiscount<7) {
                        $errors[]='<div class="block2">لا تقل نسبة الخصم  لسعر   "'.$filteredPrice.'" في فئة  "'.getCat($filteredCat1).'" عن 7% </div>';
                       }elseif ($filteredPrice>4000&&$filteredDiscount<6) {
                        $errors[]='<div class="block2">لا تقل نسبة الخصم  لسعر   "'.$filteredPrice.'" في فئة  "'.getCat($filteredCat1).'" عن 6% </div>';
                       }
                 }elseif ($filteredCat1==17) { //entertainment 
                     if ($filteredCat2==70) { //party hall
                       if ($filteredPrice<5000&&$filteredDiscount<5) {
                        $errors[]='<div class="block2">لا تقل نسبة الخصم  لسعر   "'.$filteredPrice.'" في فئة  "'.getSub($filteredCat2).'" عن 5% </div>';
                       }elseif ($filteredPrice>=5000&&$filteredDiscount<4) {
                        $errors[]='<div class="block2">لا تقل نسبة الخصم  لسعر   "'.$filteredPrice.'" في فئة  "'.getSub($filteredCat2).'" عن 4% </div>';
                       }
                     }
                 }else{
                      if ($filteredPrice>=1&&$filteredPrice<=300&&$filteredDiscount<10) {
                        $errors[]='<div class="block2">لا تقل نسبة الخصم عن 10% للأسعار  حتى 300 جنيه مصري</div>';
                      }elseif ($filteredPrice>=301&&$filteredPrice<=600&&$filteredDiscount<8) {
                        $errors[]='<div class="block2">لا تقل نسبة الخصم عن 8% للأسعار  من 301 حتى 600 جنيه مصري</div>';
                      }elseif ($filteredPrice>=601&&$filteredPrice<=1000&&$filteredDiscount<5) {
                        $errors[]='<div class="block2">لا تقل نسبة الخصم عن 5% للأسعار  من 601 حتى 1000 جنيه مصري</div>';
                      }elseif ($filteredPrice>=1001&&$filteredPrice<=40000&&$filteredDiscount<2) {
                        $errors[]='<div class="block2">لا تقل نسبة الخصم عن 2% للأسعار  من 1001 حتى 40000 جنيه مصري</div>';
                      }elseif ($filteredPrice>40000&&$filteredDiscount<1) {
                        $errors[]='<div class="block2">لا تقل نسبة الخصم عن 1% للأسعار  فوق 40000 جنيه مصري</div>';
                      }
                     }
      }

       //DISCOUNT
      if ( $filteredDiscount>=100) {
        $errors[]='<div class="block2">خطأ .. نسبة الخصم غير منطقية  </div>';
      }
      
      
       
      //delivery if category is 10 or less 
      if ($delivery==0&&$filteredCat1<=10) {
        if ($filteredCat1!=7&&$filteredCat1!=8&&$filteredCat1!=9) {
          $errors[]='<div class="block2">اختر موقف الشحن</div>';
        }
      }

      //situation (owner or middle man)
      if (($filteredCat1==7||$filteredCat1==8)&&$sit==0) {
          $errors[]='<div class="block2">حدد موقفك   .. المالك أم الوسيط ؟ </div>';
      }

       
       //PHOTO
      if (empty($refinedPhotoName) ) {
        $errors[]="<div class='block2'>".$lang['plsAddMainPic']."</div>";      
      }elseif( !empty($refinedPhotoName) && !in_array($refinedPhotoName,$allowedExtensions) ) {
        $errors[]="<div class='block2'>".$lang['allowedPicExten']."</div>";
      }elseif( !empty($refinedPhotoName2) && !in_array($refinedPhotoName2,$allowedExtensions) || !empty($refinedPhotoName3) && !in_array($refinedPhotoName3,$allowedExtensions ) ){
        $errors[]="<div class='block2'>".$lang['allowedPicExten']."</div>";
      }
       //PHOTO SIZE     
      if ( ($photoSize || $photoSize2 || $photoSize3 /*|| $photoSize4 || $photoSize5*/ )>4096000 ) {
        $errors[]="<div class='block2'>".$lang['allowedPicSize']."</div>";       
      }
       //PHOTO SIZE
      if ( isset($photoSize) && $photoSize>0 && $photoSize<1000 ||isset($photoSize2) && $photoSize2>0 && $photoSize2<1000 || isset($photoSize3) && $photoSize3>0 && $photoSize3<1000 ) {
        $errors[]="<div class='block2'>".$lang['mainPicSmall']."</div>";       
      }
      


          if (!empty($errors)) {  //print errors  ?>
                <!--<a id='back2'  href='<?php //echo $_SERVER['HTTP_REFERER'] ?>'><?php echo $lang['back']?></a>--> 
                <div class="above-lg bottom-lg ">
                <p class="correctFaults"><?php echo $lang['correctFaults']?></p> <?php  
                   foreach ($errors as  $value) { //alert alert-danger
                     echo $value;
                  }
              ?> </div> <?php

          }else{  // check repeated 
           //check repeated items
          $stmt=$conn->prepare(" SELECT * from items where title=? and description=? and price=? and discount=?  and cat_id=? and subcat_id=? and country_id=? and state_id=? and city_id=? and delivery=? and approve=? and user_id=?  ");
          $stmt->execute(array($filteredName,$filteredDesc,$filteredPrice,$filteredDiscount,$filteredCat1,$filteredCat2,$filteredCountry,$filteredState,$filteredCity,$delivery,0,$session));
          $count=$stmt->rowCount();
          if ($count>0) {
           echo "<div class=' above-lg block2 bottom2'>".$lang['alreadyAdded']."</div>";
           echo "<br><br><br>";
          }else{

                //photo
                 $finalName=rand(0,100000000).'_'.$refinedPhotoName;
                 move_uploaded_file($photoTmp, "data/upload/".$finalName);
                
              if (isset($_FILES['photo2'])&& $_FILES['photo2']['name']!=null  ) {
                 $finalName2=rand(0,100000000).'_'.$refinedPhotoName2;
                 move_uploaded_file($photoTmp2, "data/upload/".$finalName2);
               }else{
                $finalName2=0;
               }
                if (isset($_FILES['photo3'])&& $_FILES['photo3']['name']!=null  ) {
                 $finalName3=rand(0,100000000).'_'.$refinedPhotoName3;
                 move_uploaded_file($photoTmp3, "data/upload/".$finalName3);
               }else{
                $finalName3=0;
               }
          
        //connecting with database to add new item 
          $stmt=$conn->prepare("INSERT INTO  
            items(title,description,price,item_mostafed,cat_id,subcat_id,country_id,state_id,city_id,discount,photo,photo2,photo3,item_date,user_id,delivery,sit  )
            VALUES (:ztitle,:zdesc,:zprice,:zmostafed,:zcat,:zsubcat,:zcountry,:zstate,:zcity,:zdiscount,:zphoto,:zphoto2,:zphoto3,:ztime,:zmem,:zdelivery,:zsit )");
            
             $stmt->execute(array(
               "ztitle"          =>   $filteredName,
               "zdesc"           =>   $filteredDesc,
               "zprice"          =>   $filteredPrice,
               "zmostafed"       =>   $mostafed,
               "zcat"            =>   $filteredCat1,
               "zsubcat"         =>   $filteredCat2,
               "zcountry"        =>   $filteredCountry,
               "zstate"          =>   $filteredState,
               "zcity"           =>   $filteredCity,
               "zdiscount"       =>   $filteredDiscount,
               "zphoto"          =>   $finalName,
               "zphoto2"         =>   $finalName2,
               "zphoto3"         =>   $finalName3,
               "ztime"           =>   $time,
               "zmem"            =>   $session,
              'zdelivery'        =>   $delivery,
               'zsit'            =>   $sit

                 ));
             
                
               if($stmt){ 
                    //success
                    echo   $Msg="<div class='div'><div class='block-green'>".$lang['itemAdded'].' .. سيتم توجيهك للصفحة الرئيسية '."</div></div>";
                    echo "<br><br><br>";
                      if($filteredCat1>10){ ?> <script>setTimeout(function go(){ location.href='service.php';},3000);</script><?php }
                      else{ ?> <script>setTimeout(function go(){ location.href='general.php';},3000);</script> <?php }
                    
                    }else{
                      echo $lang['notAddedPlsCheck'];
                    }
                } // end else (repeated item)  
          } //END IF (!EMPTY $ERRORS) 
                
                    
}else{ // END  if ($_SERVER['REQUEST_METHOD'] =='POST') 
  include 'notFound.php';
}






}else{ //END SESSION
  header("location:signin.php");
	exit();
}

 include  $tmpl ."footer.inc";
 include  "foot.php";
ob_end_flush();
