<?php
ob_start();
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365 * 15);
$title='دخول ';       //title of the page
include 'init.php';   //included files

if(!session_id()) { session_start(); }

require_once('facebookConfig.php');


try {
  $accessToken = $handler->getAccessToken();
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit();
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit();
}
 
if (!isset($accessToken)) {
  header('location:login.php');
  exit();
}
 
$oAuth2Client=$FBObject->getOAuth2Client(); 

if($accessToken->isLongLived()){
  // Exchanges a short-lived access token for a long-lived one
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    $response=$FBObject->get("/me?fields=id,name,email,picture",$accessToken);

  $userData=$response->getGraphNode()->asArray();
  $_SESSION['userData']=$userData;
  $_SESSION['access_token']= (string) $accessToken;



  $name = $_SESSION['userData']['name'];
  $id = $_SESSION['userData']['id'];
  //$email= $_SESSION['userData']['email'];
  $pic= $_SESSION['userData']['picture']['url'];
 
  $country=null; 
  $state=null;
  $city=null;
  date_default_timezone_set('Africa/Cairo');
  $date=date('Y-m-d');

    

  // check database for this user 
  $stmt=$conn->prepare(" SELECT  *  from user where password=? and came_from=3 ");
  $stmt->execute(array($id));
  $fetch=$stmt->fetch();
  $count=$stmt->rowCount();
    if ($count>0) {
          if ($fetch['activate']==2) {
              ?><script>location.href='banned.php';</script> <?php
          }else{
          //user is in database 
          $_SESSION['userF']=$fetch['name'];
          $_SESSION['userFid']=$fetch['user_id']; 
          $_SESSION['fbPic']=$pic; 

          //setcookie('cookFName',$_SESSION['userF'],time()+3600*24*365*15,'/','mostfid.com',true,true);
          //setcookie('cookFId',$_SESSION['userFid'],time()+3600*24*365*15,'/','mostfid.com',true,true);

              if ($fetch['country_id']==null||$fetch['state_id']==null||$fetch['city_id']==null) {
                 ?><script>location.href='action-us.php?u=edit-us&id=<?php echo $_SESSION['userFid']; ?>';</script><?php
              }else{
                header('location:index.php');
                exit();
              }
          

          }
    }else{ 
      //user isn't in database
      $stmt=$conn->prepare(" INSERT INTO user (name,password,country_id,state_id,city_id,activate,came_from,reg_date)
        values(:zname,:zpass,:zcont,:zst,:zcit,1,3,:zdate)");
      $stmt->execute(array(
          'zname'  => $name,
          'zpass'  => $id,
          'zcont'  => $country,
          'zst'    => $state,
          'zcit'   => $city,
          'zdate'  => $date

                     ));
        if ($stmt) { 
          //added successfully  
          ///////////////// user_id,username
          $stmt=$conn->prepare(" SELECT  * from user where password=? and came_from=3 ");
          $stmt->execute(array($id));
          $fetch2=$stmt->fetch();

          ////////////////
          $_SESSION['userF']=$fetch2['name'];
          $_SESSION['userFid']=$fetch2['user_id'];
          $_SESSION['fbPic']=$pic;

          //setcookie('cookFName',$_SESSION['userF'],time()+3600*24*365*15,'/','mostfid.com',true,true);
         // setcookie('cookFId',$_SESSION['userFid'],time()+3600*24*365*15,'/','mostfid.com',true,true);

         ?><script>location.href='action-us.php?u=edit-us&id=<?php echo $_SESSION['userFid']; ?>';</script><?php
         /* header('location:index.php');
          exit();*/
        }

   }

 
}// END if($accessToken->isLongLived())  





include $tmpl."footer.inc"; 
include 'foot.php';       
ob_end_flush();
 
 
 
