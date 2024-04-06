<?php
ob_start();
session_start();
$title='تحديث ';
//abbreviations
$tmpl='include/templates/';
$css='layout/css/';
$js='layout/js/';
$images='layout/images/';
$fonts='layout/fonts/';
$language='include/languages/'; 
$func='include/functions/';
//important files
include 'lang.php';//must be before header or header words fail.
include $tmpl."header.inc";
include 'connect.php'; //this file connects to database
include $func.'functions.php';
date_default_timezone_set('Africa/Cairo');



if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif(isset($_SESSION['userEid'])){ $session=$_SESSION['userEid']; }
elseif(isset($_SESSION['userGid'])){ $session=$_SESSION['userGid']; }
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

  if (isset($session) ) { 
      if ($_SERVER['REQUEST_METHOD'] =='POST') { //UPDATE TRADER DATA&ITEMS
        
         if (isset($_POST['traderData'])) {
            include  "include/templates/navbar.php";
            //updating trader data => coming from profile,p=data
             $user_id    =$_POST['user_id'];
             $country=$_POST['country'];
             $date=date('Y-m-d');
             $code=rand(10000,100000);
             /////passwords
            $password   ='';
            $oldpassword=$_POST['oldPassword'];
            $password1  =isset($_POST['password1'])&&!empty($_POST['password1'])?trim($_POST['password1']):'';
            $password2  =isset($_POST['password2'])&&!empty($_POST['password2'])?trim($_POST['password2']):'';       
            if (!empty($password2) && $password2===$password1 ):$newPassword= $password2;else:$newPassword= '';endif;
            //filteration
             $filteredNewPassword=filter_var(trim($newPassword),FILTER_SANITIZE_STRING);
            
             
             //strong password
             $patternLower = "`[a-z]`";
             $patternUpper = "`[A-Z]`";
             $patternNumber = "`[0-9]`";

             $errors=[];
             //PASSWORD
             if(!empty($password1) || !empty($password2)){
                 if (strlen(trim($filteredNewPassword)) > 0 && strlen(trim($filteredNewPassword)) < 8 ) {
                   $errors[]=$lang['passLeast'];
                 }elseif(($password2 !== $password1 )){
                   $errors[]=$lang['passwordsNotMatch'];
                 }elseif(strlen(trim($filteredNewPassword)) > 20) {
                    $errors[]=$lang['passMost'];
                 }elseif(!(preg_match($patternLower, $filteredNewPassword)) ){
                    $errors[]=$lang['passLower'];
                  }elseif(!(preg_match($patternUpper, $filteredNewPassword)) ){
                    $errors[]=$lang['passUpper'];
                  }elseif(!(preg_match($patternNumber, $filteredNewPassword)) ){
                    $errors[]=$lang['passNumber'];
                  }
              }

              //hash new password or use old one
              $filteredPassword=!empty($filteredNewPassword)?password_hash($filteredNewPassword, PASSWORD_DEFAULT):$oldpassword;
              //PHONE 
              $oldphone=$_POST['oldPhone'];
              $phone=isset($_POST['phone'])&&!empty($_POST['phone'])?trim($_POST['phone']):$oldphone;
              $filteredPhone   =filter_var(trim($phone),FILTER_SANITIZE_NUMBER_INT);
              //PHONE  
              $result1=phone($country,$filteredPhone);//checks if phone suits country
              $stmt=$conn->prepare('SELECT phone from user where phone=? and user_id != ?');
              $stmt->execute(array($filteredPhone,$session));
              $found=$stmt->rowcount();
             
              if ($result1[0]==2) { 
                $errors[]=$lang['checkPhoneNum'].' .. '.$lang['insert'].' '.$result1[1].' '.$lang['digit'];
              }elseif ($found>0) {
                $errors[]='رقم المحمول مستخدم  بواسطة شخص آخر ';
              }
              //terms
              if (!isset($_POST['terms'])) {
              $errors[]=$lang['agreeTerms'];
              }


              if (!empty($errors)) {
                ?><div class='height-update'> <?php
                  foreach ($errors as $value) {
                    echo "<div class='block2 font-med'>".$value.'</div>';
                  }
                ?></div> <?php
              }else{
                ?><div class="height"><?php
                //if phone is new
                if($filteredPassword!==$oldpassword){
                 //update password 
                 $stmt=$conn->prepare("UPDATE user set  password=?,update_date=? where user_id=?  ");
                 $stmt->execute(array($filteredPassword,$date,$session )); 
                   if ($stmt) {
                     ?>
                     <div class="block-green above-lg">تم التحديث بنجاح ؛ سيتم تحويلكم لصفحة الحساب ...</div>
                     <script>
                      setTimeout(function go(){$('.block-green').fadeOut();},4300);
                      setTimeout(function go(){location.href='profile.php?i=<?php echo $session?>&p=data';},4350);
                    </script> 
                     <?php
                   }
                }elseif ($filteredPassword===$oldpassword&&$filteredPhone!==$oldphone) {
                  //update phone 
                 $stmt=$conn->prepare("UPDATE user set  phone=?,update_date=?,code=?,activate=0 where user_id=?  ");
                 $stmt->execute(array($filteredPhone,$date,$code,$session )); 
                      if ($stmt) {
                        ?>
                        <script>location.href='update-tr-dt.php?t=<?php echo $filteredPhone?>';</script> <?php
                      }
 

                }elseif ($filteredPassword!==$oldpassword&&$filteredPhone!==$oldphone) {
                  //update password & phone 
                 $stmt=$conn->prepare("UPDATE user set  password=?,phone=?,update_date=?,code=?,activate=0 where user_id=?  ");
                 $stmt->execute(array($filteredPassword,$filteredPhone,$date,$code,$session ));
                      if ($stmt) {
                        ?><script>location.href='update-tr-dt.php?t=<?php echo $filteredPhone?>';</script> <?php
                      }

                }elseif ($filteredPassword===$oldpassword&&$filteredPhone===$oldphone) {
                  ?><div class="block-green above-lg">تم التحديث بنجاح ؛ سيتم تحويلكم لصفحة الحساب ...</div> 
                    <script>
                      setTimeout(function go(){$('.block-green').fadeOut();},4100);
                      setTimeout(function go(){location.href='profile.php?i=<?php echo $session?>&p=data';},4200);
                    </script> 

                  <?php
                }
              ?></div><?php
             }
        include  "foot.php";

    

  }elseif(isset($_POST['edit-item'])){ //update items
      include  "include/templates/navbar.php";
      // coming from profile,p=items 
      $item_id       =$_POST['item_id'];
      $name          =!empty($_POST['name'])?$_POST['name']:$_POST['oldName'];
      $desc          =!empty($_POST['description'])?$_POST['description']:$_POST['oldDescription'];
      $price         =!empty($_POST['price'])?$_POST['price']:$_POST['oldPrice'];
      $discount      =!empty($_POST['discount'])?$_POST['discount']:$_POST['oldDiscount'];
      $time          =date('Y-m-d');
      $cat           =$_POST['cat'];//category 
      $cat2          =$_POST['cat2'];//category 
       

       //===========DELIVERY CHECKBOXES ============
       $delivery1='';
      if (!empty($_POST['delivery1'])) {
        $delivery1=$_POST['delivery1'];
      }elseif (!empty($_POST['delivery2'])) {
        $delivery1=$_POST['delivery2'];
      }elseif (!empty($_POST['delivery3'])) {
        $delivery1=$_POST['delivery3'];
      }elseif (!empty($_POST['delivery4'])) {
        $delivery1=$_POST['delivery4'];
      }elseif (!empty($_POST['delivery5'])) {
        $delivery1=$_POST['delivery5'];
      }elseif (!empty($_POST['delivery6'])) {
        $delivery1=$_POST['delivery6'];
      }elseif (!empty($_POST['delivery7'])) {
        $delivery1=$_POST['delivery7'];
      }elseif (!empty($_POST['delivery8'])) {
        $delivery1=$_POST['delivery8'];
      }elseif (!empty($_POST['delivery9'])) {
        $delivery1=$_POST['delivery9'];
      }
     

     $delivery=$delivery1>0?$delivery1:$_POST['oldDelivery'];
     
      //sanitize variables
      $filteredName     =filter_var(trim($name) , FILTER_SANITIZE_STRING);
      $filteredDesc     =filter_var(trim($desc) , FILTER_SANITIZE_STRING);
      $filteredPrice    =filter_var(trim($price) , FILTER_SANITIZE_NUMBER_INT);
      $filteredDiscount =filter_var(trim($discount) , FILTER_SANITIZE_NUMBER_INT);
      
      
      $allowedExtensions=array('jpg','jpeg','png');
      // photo
      if (isset($_FILES['photo']) && $_FILES['photo']['name']!=null ) {
      $photoName=$_FILES['photo']['name'];
      $photoSize=$_FILES['photo']['size'];
      $photoTmp =$_FILES['photo']['tmp_name']; 
      $photoType=$_FILES['photo']['type'];
      //refine photo upload
      $expl=explode(".", $photoName);
      $refinedPhotoName=strtolower(end($expl));
      }else{
        $oldPhoto=$_POST['oldPhoto']; 
      }

      // photo2
      if (isset($_FILES['photo2']) && $_FILES['photo2']['name']!=null ) {
      $photoName2=$_FILES['photo2']['name'];
      $photoSize2=$_FILES['photo2']['size'];
      $photoTmp2 =$_FILES['photo2']['tmp_name']; 
      $photoType2=$_FILES['photo2']['type'];
      //refine photo upload
      $expl2=explode(".", $photoName2);
      $refinedPhotoName2=strtolower(end($expl2));
      }else{
        $oldPhoto2=$_POST['oldPhoto2'];
      }

      // photo3
      if (isset($_FILES['photo3']) && $_FILES['photo3']['name']!=null ) {
      $photoName3=$_FILES['photo3']['name'];
      $photoSize3=$_FILES['photo3']['size'];
      $photoTmp3 =$_FILES['photo3']['tmp_name']; 
      $photoType3=$_FILES['photo3']['type'];
      //refine photo upload
      $expl3=explode(".", $photoName3);
      $refinedPhotoName3=strtolower(end($expl3));
      }else{
        $oldPhoto3=$_POST['oldPhoto3'];
      }
      
      //array to show errors
      $errors=array();  
        //NAME
      if (mb_strlen($filteredName)<6) {// short name
        $errors[]='<div class="block2">'.$lang['wirte8InTitle'].' في حقل العنوان '.'</div>';
      }
      if (mb_strlen($filteredName)>60) {
        $errors[]='<div class="block2">'.$lang['wirte60OnlyInTitle'].' في حقل العنوان '.'</div>';
      }
       //DESCRIPTION
      if (strlen($filteredDesc)<20) {
        $errors[]='<div class="block2">'.$lang['wirte8InDesc'].' في حقل الوصف '.'</div>';
      }
      if (strlen($filteredDesc)>2000) {
        $errors[]='<div class="block2">'.$lang['DescTooLong'].' في حقل الوصف  '.'</div>';
      }
       //PRICE
      if ( $filteredPrice==0) {
        $errors[]='<div class="block2">'.$lang['plsAddPrice'].'</div>';
      }


      //DISCOUNT 
      if ( $filteredDiscount==0) { 
              $errors[]='<div class="block2">'.$lang['plsAddDisc'].'</div>';
            }else{
                  if($cat==1){
                     if ($filteredPrice<=50&&$filteredDiscount<10) {
                       $errors[]='<div class="block2">لا تقل نسبة الخصم عن 10% للأسعار حتى 50 جنيه مصري  (فئة طعام فقط )</div>';
                     }elseif ($filteredPrice>=51&&$filteredDiscount<5) {
                       $errors[]='<div class="block2">لا تقل نسبة الخصم عن 5% للأسعار  فوق 50 جنيه مصري  (فئة طعام فقط )</div>';
                     }
                 }elseif ($cat==12) { //transport
                       if ($filteredPrice<=4000&&$filteredDiscount<7) {
                        $errors[]='<div class="block2">لا تقل نسبة الخصم  لسعر   "'.$filteredPrice.'" في فئة  "'.getCat($cat).'" عن 7% </div>';
                       }elseif ($filteredPrice>4000&&$filteredDiscount<6) {
                        $errors[]='<div class="block2">لا تقل نسبة الخصم  لسعر   "'.$filteredPrice.'" في فئة  "'.getCat($cat).'" عن 6% </div>';
                       }
                 }elseif ($cat==17) { //entertainment 
                     if ($cat2==70) { //party hall
                       if ($filteredPrice<5000&&$filteredDiscount<5) {
                        $errors[]='<div class="block2">لا تقل نسبة الخصم  لسعر   "'.$filteredPrice.'" في فئة  "'.getSub($cat2).'" عن 5% </div>';
                       }elseif ($filteredPrice>=5000&&$filteredDiscount<4) {
                        $errors[]='<div class="block2">لا تقل نسبة الخصم  لسعر   "'.$filteredPrice.'" في فئة  "'.getSub($cat2).'" عن 4% </div>';
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
      
      
       
       //PHOTO
      if (!isset($oldPhoto) && empty($refinedPhotoName) ) {
        $errors[]="<div class='block2'>".$lang['plsAddMainPic']."</div>";      
      }elseif( isset($refinedPhotoName) && !in_array($refinedPhotoName,$allowedExtensions) ) {
        $errors[]="<div class='block2'>".$lang['allowedPicExten']."</div>";
      }
       //PHOTO2
      if( isset($refinedPhotoName2) && !in_array($refinedPhotoName2,$allowedExtensions) ) {
        $errors[]="<div class='block2'>".$lang['allowedPicExten']."</div>";
      }
       //PHOTO3
      if( isset($refinedPhotoName3) && !in_array($refinedPhotoName3,$allowedExtensions) ) {
        $errors[]="<div class='block2'>".$lang['allowedPicExten']."</div>";
      }
       //PHOTO SIZE 1,2,3     
      if ( isset($photoSize)&&$photoSize>4096000 || isset($photoSize2)&&$photoSize2>4096000 || isset($photoSize3)&&$photoSize3>4096000  ) {
        $errors[]="<div class='block2'>".$lang['allowedPicSize']."</div>";       
      }elseif (isset($photoSize)&&$photoSize<1000 || isset($photoSize2)&&$photoSize2<1000 || isset($photoSize3)&&$photoSize3<1000) {
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

          }else{
              
                if (isset($_FILES['photo'])&& $_FILES['photo']['name']!=null  ) {
                 //photo
                 $finalName=rand(0,100000000).'_'.$refinedPhotoName;
                 move_uploaded_file($photoTmp, "data/upload/".$finalName);
                }else{
                  $finalName=$oldPhoto;
                }

                if (isset($_FILES['photo2'])&& $_FILES['photo2']['name']!=null  ) {
                 //photo2
                 $finalName2=rand(0,100000000).'_'.$refinedPhotoName2;
                 move_uploaded_file($photoTmp2, "data/upload/".$finalName2);
                }else{
                  $finalName2=$oldPhoto2;
                }

                if (isset($_FILES['photo3'])&& $_FILES['photo3']['name']!=null  ) {
                 //photo3
                 $finalName3=rand(0,100000000).'_'.$refinedPhotoName3;
                 move_uploaded_file($photoTmp3, "data/upload/".$finalName3);
                }else{
                  $finalName3=$oldPhoto3;
                }
                
        //connecting with database to send new data
             $stmt=$conn->prepare("UPDATE items set  title=?,description=?,price=?,discount=?,photo=?,photo2=?,photo3=?,update_date=?,delivery=? where user_id=? and item_id=? ");
             $stmt->execute(array($filteredName,$filteredDesc,$filteredPrice,$filteredDiscount,$finalName,$finalName2,$finalName3,$time, $delivery, $session,$item_id ));
               if($stmt){ 
                    //success
                    echo   $Msg="<div class='div'><div class='block-green'>".$lang['successUpdate'].'<br>سيتم تحويلك لصفحة حسابي - منتجاتي '."</div></div>";
                    ?><script>
                      setTimeout( function go(){ $('.block-green').fadeOut();},3330);
                      setTimeout( function go2(){ location.href='profile.php?i=<?php echo $session?>&p=items';},3350);
                      </script> <?php
                    echo "<br><br><br>";
                   
                    }else{
                      echo $lang['notAddedPlsCheck'];
                    }
           } //END IF (!EMPTY $ERRORS)
      include  "foot.php";


     }elseif (isset($_POST['update-EmailUser'])) { //UPDATE EMAIL USER
         include  "include/templates/navbar.php";
         ///////////////////////
            $user_id    =$_POST['user_id'];
             /////passwords
            $password   ='';
            $oldpassword=$_POST['oldpassword'];
            $password1  =isset($_POST['password1'])&&!empty($_POST['password1'])?trim($_POST['password1']):'';
            $password2  =isset($_POST['password2'])&&!empty($_POST['password2'])?trim($_POST['password2']):'';       
            if (!empty($password2) && $password2===$password1 ):$newPassword= $password2;else:$newPassword= '';endif;
             

             //email 
             $oldemail=$_POST['oldemail'];
             $newEmail=$_POST['email'];
             $email=$newEmail===$oldemail?$oldemail:$newEmail;
             
             //phone
             $oldphone=$_POST['oldphone'];
             $phone=isset($_POST['phone'])&&!empty($_POST['phone'])?trim($_POST['phone']):$oldphone;

             //country
             $country      =$_POST['oldcountry'];
             //state
             $oldstate     =$_POST['oldstate'];
             $newstate     =isset($_POST['state'])&&!empty($_POST['state'])?$_POST['state']:0;
             $state        =$newstate>0?$newstate:$oldstate;
             //city
             $oldcity      =$_POST['oldcity'];
             $newcity      =isset($_POST['city'])&&!empty($_POST['city'])?$_POST['city']:0;
             $city         =$newcity>0?$newcity:$oldcity;
             $date         =date('Y-m-d');
             //code
             $code1 = md5(rand(10000,100000));
             $code  =substr($code1,0,6);
             $_SESSION['codeUpdate']=[$email,$code];
             

             //filteration
             $filteredNewPassword=filter_var(trim($newPassword),FILTER_SANITIZE_STRING);
             $sanitizededEmail=filter_var(trim($email),FILTER_SANITIZE_EMAIL);
             $filteredEmail   =filter_var($sanitizededEmail,FILTER_VALIDATE_EMAIL);
             $filteredPhone   =filter_var(trim($phone),FILTER_SANITIZE_NUMBER_INT);
             
             //strong password
             $patternLower = "`[a-z]`";
             $patternUpper = "`[A-Z]`";
             $patternNumber = "`[0-9]`";

             //activate
             $activate1=$_POST['activate'];
             if($sanitizededEmail!=$oldemail){
              $activate=0;
             }elseif ($sanitizededEmail==$oldemail&&$activate1==1) {
               $activate=1;
             }elseif ($sanitizededEmail==$oldemail&&$activate1==0) {
               $activate=0;
             }

           
             
             //mistakes
             $error=array();
             //
             if($newEmail!=$oldemail){
                 $stmt=$conn->prepare(" SELECT email from user where BINARY email=? "); 
                 $stmt->execute(array($newEmail));
                 $row=$stmt->rowCount();
                     if ($row>0 ) {
                       $error[]="".$lang['emailUsed']."";
                     }
              }
             //PASSWORD

              if (!empty($filteredNewPassword) && $filteredNewPassword!==$oldpassword) {
                 if (strlen(trim($filteredNewPassword)) > 0 && strlen(trim($filteredNewPassword)) < 8 ) {
                   $error[]=$lang['passLeast'];
                 }elseif(($password2 !== $password1 )){
                   $error[]=$lang['passwordsNotMatch'];
                 }elseif(strlen(trim($filteredNewPassword)) > 20) {
                    $error[]=$lang['passMost'];
                 }elseif(!(preg_match($patternLower, $filteredNewPassword)) ){
                    $error[]=$lang['passLower'];
                  }elseif(!(preg_match($patternUpper, $filteredNewPassword)) ){
                    $error[]=$lang['passUpper'];
                  }elseif(!(preg_match($patternNumber, $filteredNewPassword)) ){
                    $error[]=$lang['passNumber'];
                  }
              }

               //hash new password or use old one
            $filteredPassword=!empty($filteredNewPassword)?password_hash($filteredNewPassword, PASSWORD_DEFAULT):$oldpassword;

            //EMAIL
            if (empty($sanitizededEmail) ) {
              $error[]="".$lang['addEmail']."";
            }elseif ($filteredEmail !=true ) {
              $error[]="".$lang['checkEmail'].""; 
            }
            //PHONE 
            $start=strpos($filteredPhone,'01');
            $start2=strpos($filteredPhone,'3');

            $result1=phone($country,$filteredPhone);//checks if phone suits country
            $stmt=$conn->prepare('SELECT phone from user where phone=? and user_id != ?');
            $stmt->execute(array($filteredPhone,$session));
            $found=$stmt->rowcount();
           
            if ($result1[0]==2) { 
              $error[]=$lang['checkPhoneNum'].' .. '.$lang['insert'].' '.$result1[1].' '.$lang['digit'];
            }elseif ($found>0) {
              $error[]='رقم المحمول مستخدم  بواسطة شخص آخر ';
            }elseif ($start!=0) {
              $error[]=$lang['checkPhoneNum'];
            }elseif ($start2==2) {
              $error[]=$lang['checkPhoneNum'];
            }
            //STATE & CITY
            if ($newstate!=$oldstate&&$newstate>0&&$city==$oldcity ) {
              $error[]="".$lang['plsChooseCity']."";
            }

             
             if(!empty($error) ){

             foreach ($error as  $value) {
               echo "<div class='height'><span class='btn btn-danger block2'>".$value."</span></div>";
             }
 
           }else{
              $stmt=$conn->prepare(" UPDATE user SET password=?,email=?,phone=?,state_id=?,city_id=?,activate=?,code=?,update_date=?  WHERE user_id=$session "); 
              $stmt->execute(array($filteredPassword,$sanitizededEmail,$filteredPhone,$state,$city,$activate,$code,$date ));
              
              if ($stmt&&$sanitizededEmail!=$oldemail||$stmt&&($sanitizededEmail==$oldemail&&$activate1==0) ) {
                  $sanitizededEmail=' ';
              ?><div style="margin: 26vh auto;width: fit-content;">
                <span class="spinner-border spinner-border-bg" role="status" aria-hidden="true"></span>
              </div><?php
               ?><script>window.location.href='emailUpdate.php';</script><?php
              
              }elseif($stmt&&$sanitizededEmail===$oldemail&&$activate1==1){
                 echo "<div class='height'><span class=' block-green'>".$lang['profileUpdated'].' ... سيتم توجيهك لصفحة الحساب '."</span></div>";
                 ?><script>
                      setTimeout( function go(){ $('.block-green').fadeOut();},3700);
                      setTimeout( function go2(){ location.href='profile.php?i=<?php echo $session?>&p=data';},3750);
                 </script> <?php
              
              }else{
                echo "<div class='height'><span class='btn btn-danger block'>".$lang['updateFail']."</span></div>";
              } 
           }
         include  "foot.php";



      /////////// Google User => from action-us.php //////////////// 
     }elseif (isset($_POST['update-GoogleUserNull'])) {
                ///////////////////////
             $phone     =$_POST['phone'];
             $country   =isset($_POST['country'])?$_POST['country']:0;
             $state     =isset($_POST['state'])?$_POST['state']:0;
             $city      =isset($_POST['city'])?$_POST['city']:0;
             $terms     =isset($_POST['terms'])?$_POST['terms']:0;
             $date      =date('Y-m-d');
             
             //filteration
             $filteredPhone   =filter_var(trim($phone),FILTER_SANITIZE_NUMBER_INT);
             
             //mistakes
             $error=array();
            //PHONE 
            $start=strpos($filteredPhone,'01');
            $start2=strpos($filteredPhone,'3');

            $result1=phone($country,$filteredPhone);//checks if phone suits country
            $stmt=$conn->prepare('SELECT phone from user where phone=? and user_id != ?');
            $stmt->execute(array($filteredPhone,$session));
            $found=$stmt->rowcount();

            if (empty($filteredPhone)) { 
              $error[]=$lang['enterPhone'];
            }elseif ($result1[0]==2) { 
              $error[]=$lang['checkPhoneNum'].' .. '.$lang['insert'].' '.$result1[1].' '.$lang['digit'];
            }elseif ($found>0) {
              $error[]='رقم المحمول مستخدم  بواسطة شخص آخر ';
            }elseif ($start !==0) {
              $error[]=$lang['checkPhoneNum'];
            }elseif ($start2 ===2) {
              $error[]=$lang['checkPhoneNum'];
            }
            //country
            if ($country==0) {
             $error[]=$lang['chooseCont']; 
            }
            //state
            if ($state==0) {
             $error[]=$lang['chooseSt'];

            }
            //city
            if ($city==0) {
             $error[]=$lang['chooseCity'];
            }
            //terms
            if ($terms==0) {
             $error[]=$lang['agreeTerms'];
            }
            
             
           if(!empty($error) ){
               foreach ($error as  $value) {
                 echo "<span class='btn btn-danger block2'>".$value."</span>";
               }

           }else{
              $stmt=$conn->prepare(" UPDATE user SET phone=?,country_id=?,state_id=?,city_id=?,update_date=?  WHERE user_id=? "); 
              $stmt->execute(array($filteredPhone,$country,$state,$city,$date,$session ));
              if($stmt){
                 echo "<div class='height'><span class=' block-green'>".$lang['profileUpdated'].' ... سيتم توجيهك  للصفحة السابقة '."</span></div>";
                 ?><script>
                      setTimeout( function go(){ $('.block-green').fadeOut();},3700);
                      <?php
                      if(isset($_SESSION['comingFromOrderPage'])){ ?> setTimeout( function go2(){ location.href='order.php?id=<?php echo $_SESSION['comingFromOrderPage']?>';},3750); <?php }
                      else{ ?>setTimeout( function go2(){ location.href='profile.php?i=<?php echo $session?>&p=data';},3750); <?php }
                      ?>
                 </script> <?php
              }else{
                echo "<div class='height'><span class='btn btn-danger block'>".$lang['updateFail']."</span></div>";
              } 
           }
        



     }elseif (isset($_POST['update-GoogleUser'])){
        //////////////////////
             //phone
             $oldphone=$_POST['oldphone'];
             $phone=isset($_POST['phone'])&&!empty($_POST['phone'])?trim($_POST['phone']):$oldphone;
             //country
             $country      =$_POST['oldcountry'];
             //state
             $oldstate     =$_POST['oldstate'];
             $newstate     =isset($_POST['state'])&&!empty($_POST['state'])?$_POST['state']:0;
             $state        =$newstate>0?$newstate:$oldstate;
             //city
             $oldcity      =$_POST['oldcity'];
             $newcity      =isset($_POST['city'])&&!empty($_POST['city'])?$_POST['city']:0;
             $city         =$newcity>0?$newcity:$oldcity;
             $terms        =isset($_POST['terms'])?$_POST['terms']:0;
             $date         =date('Y-m-d');

             //filteration
             $filteredPhone   =filter_var(trim($phone),FILTER_SANITIZE_NUMBER_INT);
             
             //mistakes
             $error=array();
            //PHONE 
            $start=strpos($filteredPhone,'01');
            $start2=strpos($filteredPhone,'3');

            $result1=phone($country,$filteredPhone);//checks if phone suits country
            $stmt=$conn->prepare('SELECT phone from user where phone=? and user_id != ?');
            $stmt->execute(array($filteredPhone,$session));
            $found=$stmt->rowcount();
           
            if ($result1[0]==2) { 
              $error[]=$lang['checkPhoneNum'].' .. '.$lang['insert'].' '.$result1[1].' '.$lang['digit'];
            }elseif ($found>0) {
              $error[]='رقم المحمول مستخدم  بواسطة شخص آخر ';
            }elseif ($start !==0) {
              $error[]=$lang['checkPhoneNum'];
            }elseif ($start2 ===2) {
              $error[]=$lang['checkPhoneNum'];
            }
            //state
            if ($state==0) {
             $error[]=$lang['chooseSt'];
            }
            //city
            if ($city==0) {
             $error[]=$lang['chooseCity'];
            }
            //STATE & CITY
            if ($newstate!=$oldstate&&$newstate>0&&$city==$oldcity ) {
              $error[]="".$lang['plsChooseCity']."";
            }
            //terms
            if ($terms==0) {
             $error[]=$lang['agreeTerms'];
            }

             
             if(!empty($error) ){
             foreach ($error as  $value) {
               echo "<span class='btn btn-danger block2'>".$value."</span>";
             }

           }else{
              $stmt=$conn->prepare(" UPDATE user SET phone=?,state_id=?,city_id=?,update_date=?  WHERE user_id=? "); 
              $stmt->execute(array($filteredPhone,$state,$city,$date,$session) );
              
              if($stmt){
                 echo "<span class='block-green'>".$lang['profileUpdated'].' ... سيتم توجيهك لصفحة الحساب '."</span>";
                 ?><script>
                      setTimeout( function go(){ $('.block-green').fadeOut();},3550);
                      setTimeout( function go2(){ location.href='profile.php?i=<?php echo $session?>&p=data';},3600);
                 </script> <?php
              }else{
                echo "<div class='height'><span class='btn btn-danger block'>".$lang['updateFail']."</span></div>";
              } 
           }
      //////////////////////
     }elseif (isset($_POST['update-faceNull'])) {  //End elseif(isset($_POST['update-GoogleUser']))  
            ///////////////////////
             $phone     =$_POST['phone'];
             $country   =isset($_POST['country'])?$_POST['country']:0;
             $state     =isset($_POST['state'])?$_POST['state']:0;
             $city      =isset($_POST['city'])?$_POST['city']:0;
             $terms     =isset($_POST['terms'])?$_POST['terms']:0;
             $date      =date('Y-m-d');
             
             //filteration
             $filteredPhone   =filter_var(trim($phone),FILTER_SANITIZE_NUMBER_INT);
             
             //mistakes
             $error=array();
            //PHONE 
            $start=strpos($filteredPhone,'01');
            $start2=strpos($filteredPhone,'3');

            $result1=phone($country,$filteredPhone);//checks if phone suits country
            $stmt=$conn->prepare('SELECT phone from user where phone=? and user_id != ?');
            $stmt->execute(array($filteredPhone,$session));
            $found=$stmt->rowcount();

            if (empty($filteredPhone)) { 
              $error[]=$lang['enterPhone'];
            }elseif ($result1[0]==2) { 
              $error[]=$lang['checkPhoneNum'].' .. '.$lang['insert'].' '.$result1[1].' '.$lang['digit'];
            }elseif ($found>0) {
              $error[]='رقم المحمول مستخدم  بواسطة شخص آخر ';
            }elseif ($start !==0) {
              $error[]=$lang['checkPhoneNum'];
            }elseif ($start2 ===2) {
              $error[]=$lang['checkPhoneNum'];
            }
            //country
            if ($country==0) {
             $error[]=$lang['chooseCont']; 
            }
            //state
            if ($state==0) {
             $error[]=$lang['chooseSt'];

            }
            //city
            if ($city==0) {
             $error[]=$lang['chooseCity'];
            }
            //terms
            if ($terms==0) {
             $error[]=$lang['agreeTerms'];
            }
            
             
           if(!empty($error) ){
               foreach ($error as  $value) {
                 echo "<span class='btn btn-danger block2'>".$value."</span>";
               }

           }else{
              $stmt=$conn->prepare(" UPDATE user SET phone=?,country_id=?,state_id=?,city_id=?,update_date=?  WHERE user_id=? "); 
              $stmt->execute(array($filteredPhone,$country,$state,$city,$date,$session ));
              if($stmt){
                 echo "<div class='height'><span class=' block-green'>".$lang['profileUpdated'].' ... سيتم توجيهك  للصفحة السابقة '."</span></div>";
                 ?><script>
                      setTimeout( function go(){ $('.block-green').fadeOut();},3700);
                      <?php
                      if(isset($_SESSION['comingFromOrderPage'])){ ?> setTimeout( function go2(){ location.href='order.php?id=<?php echo $_SESSION['comingFromOrderPage']?>';},3750); <?php }
                      else{ ?>setTimeout( function go2(){ location.href='profile.php?i=<?php echo $session?>&p=data';},3750); <?php }
                      ?>
                 </script> <?php
              }else{
                echo "<div class='height'><span class='btn btn-danger block'>".$lang['updateFail']."</span></div>";
              } 
           }
     }elseif (isset($_POST['update-faceUser'])) { //END update faceNull
          //////////////////////
             //phone
             $oldphone=$_POST['oldphone'];
             $phone=isset($_POST['phone'])&&!empty($_POST['phone'])?trim($_POST['phone']):$oldphone;
             //country
             $country      =$_POST['oldcountry'];
             //state
             $oldstate     =$_POST['oldstate'];
             $newstate     =isset($_POST['state'])&&!empty($_POST['state'])?$_POST['state']:0;
             $state        =$newstate>0?$newstate:$oldstate;
             //city
             $oldcity      =$_POST['oldcity'];
             $newcity      =isset($_POST['city'])&&!empty($_POST['city'])?$_POST['city']:0;
             $city         =$newcity>0?$newcity:$oldcity;
             $terms        =isset($_POST['terms'])?$_POST['terms']:0;
             $date         =date('Y-m-d');

             //filteration
             $filteredPhone   =filter_var(trim($phone),FILTER_SANITIZE_NUMBER_INT);
             
             //mistakes
             $error=array();
            //PHONE 
            $start=strpos($filteredPhone,'01');
            $start2=strpos($filteredPhone,'3');

            $result1=phone($country,$filteredPhone);//checks if phone suits country
            $stmt=$conn->prepare('SELECT phone from user where phone=? and user_id != ?');
            $stmt->execute(array($filteredPhone,$session));
            $found=$stmt->rowcount();
           
            if ($result1[0]==2) { 
              $error[]=$lang['checkPhoneNum'].' .. '.$lang['insert'].' '.$result1[1].' '.$lang['digit'];
            }elseif ($found>0) {
              $error[]='رقم المحمول مستخدم  بواسطة شخص آخر ';
            }elseif ($start !==0) {
              $error[]=$lang['checkPhoneNum'];
            }elseif ($start2 ===2) {
              $error[]=$lang['checkPhoneNum'];
            }
            //state
            if ($state==0) {
             $error[]=$lang['chooseSt'];
            }
            //city
            if ($city==0) {
             $error[]=$lang['chooseCity'];
            }
            //STATE & CITY
            if ($newstate!=$oldstate&&$newstate>0&&$city==$oldcity ) {
              $error[]="".$lang['plsChooseCity']."";
            }
            //terms
            if ($terms==0) {
             $error[]=$lang['agreeTerms'];
            }

             
             if(!empty($error) ){
             foreach ($error as  $value) {
               echo "<span class='btn btn-danger block2'>".$value."</span>";
             }

           }else{
              $stmt=$conn->prepare(" UPDATE user SET phone=?,state_id=?,city_id=?,update_date=?  WHERE user_id=? "); 
              $stmt->execute(array($filteredPhone,$state,$city,$date,$session) );
              
              if($stmt){
                 echo "<span class='block-green'>".$lang['profileUpdated'].' ... سيتم توجيهك لصفحة الحساب '."</span>";
                 ?><script>
                      setTimeout( function go(){ $('.block-green').fadeOut();},3550);
                      setTimeout( function go2(){ location.href='profile.php?i=<?php echo $session?>&p=data';},3600);
                 </script> <?php
              }else{
                echo "<div class='height'><span class='btn btn-danger block'>".$lang['updateFail']."</span></div>";
              } 
           }
     }//END update faceUser


}else{ // END  if ($_SERVER['REQUEST_METHOD'] =='POST')
  include 'notFound.php';
}






}else{ //END SESSION
  header("location:logout.php?s=no");
	exit();
}

 include  $tmpl ."footer.inc";
ob_end_flush();
