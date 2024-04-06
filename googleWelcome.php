<?php
ob_start();
session_start();       //important in every php page
$title='دخول  ';       //title of the page
include 'init.php';   //included files


require_once 'googleConfig.php'; 

  // authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);

  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  
  $email  =  $google_account_info->email;
  $name   =  $google_account_info->name;
  $id     =  $google_account_info->id;
  $pic    =  $google_account_info->picture;
  $verify =  $google_account_info->verifiedEmail;
  $ver=1;

  $country=null;
  $state=null;
  $city=null;
  date_default_timezone_set('Africa/Cairo');
  $date=date('Y-m-d');

    

  // check database for this user //email=? $email
  $stmt=$conn->prepare(" SELECT  *  from user where  email=? ");
  $stmt->execute(array($email));
  $fetch=$stmt->fetch();
  $count=$stmt->rowCount();
	  if ($count>0) { 

          if ($fetch['activate']==2) {
               ?><script>location.href='banned.php';</script> <?php
          }else{
        	  	//user is in database
              $_SESSION['userG']=$fetch['name'];
              $_SESSION['userGid']=$fetch['user_id']; 
              $_SESSION['googlePic']=$pic;

              setcookie('cookGName',$_SESSION['userG'],time()+3600*24*365*15,'/','mostfid.com',true,true);
              setcookie('cookGId',$_SESSION['userGid'],time()+3600*24*365*15,'/','mostfid.com',true,true);
              
              if ($fetch['country_id']==null||$fetch['state_id']==null||$fetch['city_id']==null) {
                 ?><script>location.href='action-us.php?u=edit-us&id=<?php echo $_SESSION['userGid']; ?>';</script><?php
              }else{
                header('location:index.php');
                exit();
              }
          
          }

	  }else{  
	  	//user isn't in database
	  	$stmt=$conn->prepare(" INSERT INTO user (name,password,email,country_id,state_id,city_id,activate,came_from,reg_date)
	  		values(:zname,:zpass,:zemail,:zcont,:zst,:zcit,:zactiv,2,:zdate)");
	    $stmt->execute(array(
          'zname'  => $name,
          'zpass'  => $id,
          'zemail' => $email,
          'zcont'  => $country,
          'zst'    => $state,
          'zcit'   => $city,
          'zactiv' => $ver,
          'zdate'  => $date

	                   ));
		    if ($stmt) { 
		    	//added successfully 
          ///////////////// user_id,username
          $stmt=$conn->prepare(" SELECT  * from user where email=?");
          $stmt->execute(array($email));
          $fetch2=$stmt->fetch();

          ////////////////
          $_SESSION['userG']=$fetch2['name'];
          $_SESSION['userGid']=$fetch2['user_id'];
          $_SESSION['googlePic']=$pic;

          setcookie('cookGName',$_SESSION['userG'],time()+3600*24*365*15,'/','localhost',true,true);
          setcookie('cookGId',$_SESSION['userGid'],time()+3600*24*365*15,'/','localhost',true,true);
          
          ?>
          <script>location.href='action-us.php?u=edit-us&id=<?php echo $_SESSION['userGid']; ?>';</script>
          <?php
		    /*  header("location:action-us.php?u=edit-us&id= ");
		      exit();*/
		    }

   }

  

} 



include $tmpl."footer.inc"; 
include 'foot.php';       
ob_end_flush();
 