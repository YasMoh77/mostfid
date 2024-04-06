<?php
ob_start();
if(!session_id()) {
    session_start();
}

$title='منصة مستفيد | تسجيل الدخول  ';       //title of the page
$keywords='<meta name="keywords" content="   عرض   , منصة  ,  شراء  ,  اشترى  ,  سعر ,  اسعار ,  دروس , عرض , اجهزة , خصم , تخفيضات , الجمعة  ,  نقل , ترجمة  , عروض   , مطلوب   , خصم  , كود خصم   , خصومات      ">';
$description='<meta name="description" content="سجل الدخول لمنصة مستفيد بجوجل أو بالبريد الالكتروني. قدم طلب شراء لكي تستفيد  من الخصومات على منتجات وخدمات عديدة. ">';


include 'init.php';   //included files



if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

 if (isset($session) ) { //IF THERE IS A SESSION
	header('location:index.php');
	exit(); 
  }

 
require_once 'googleConfig.php';
require_once 'facebookConfig.php'; 
$redirectTo='https://www.mostfid.com/facebookWelcome.php';
//$redirectTo='http://localhost:82/mostfid/facebookWelcome.php';
$data=['email']; 
$fullUrl=$handler->getLoginUrl($redirectTo,$data);
?>
<div class="relative-login container">

			<div class="div-input-login">
				<!--facebook login  href="<?php //echo $facebook_login_url; ?>"-->
				<div class="div-input-login1">
				  <a onclick="window.location='<?php echo $fullUrl; ?>'" ><button class="submit btnFB" type="submit"  class="btn btn-primary " ><?php echo $lang['fbLogin']?></button></a>
				</div>
				
				<!--google login -->
				<div class="div-input-login1">
				 <a href="<?php echo $client->createAuthUrl();?>"> <button class="submit btnG" type="submit" id="google-login"  class="btn btn-primary " ><?php echo $lang['googleLogin'];?></button></a>
				</div>
				<!--email login -->
				<div class="div-input-login1">
				  <a href="signinU.php"><button class="submit btnE" type="submit"  class="btn btn-primary " ><?php echo $lang['emailLogin']?></button></a>
				</div>
		   </div>
</div>


<?php 
include $tmpl."footer.inc"; 
include 'foot.php';       
ob_end_flush();
 