<?php
ob_start();
session_start();       //important in every php page
$title='Action';       //title of the page
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




//adding to favourites
if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google 
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb
if (isset($session) ) { //IF THERE IS A SESSION
	
//add ads to favourite table => from users
if (isset($_GET['item_E'])&&isset($_GET['user_E'])&&isset($_GET['cat_E'])&&isset($_GET['sub_E'])&&isset($_GET['st_E'])&&isset($_GET['ci_E'])) {
	$item =$_GET['item_E'];
	$user =$_GET['user_E'];
	$cat  =$_GET['cat_E'];
	$sub  =$_GET['sub_E'];
	$state=$_GET['st_E'];
	$city =$_GET['ci_E'];

	 	$stmt=$conn->prepare(" SELECT *  from favourite 
	  	where item_id=? and user_id=? ");
	    $stmt->execute(array($item,$user));
	    $count=$stmt->rowCount();
	     if ($count>0) {  
			      $stmt2=$conn->prepare(" SELECT *  from favourite 
			  	  where item_id=? and user_id=? and favourite_status=1 ");
		          $stmt2->execute(array($item,$user));
		          $count2=$stmt2->rowCount();
		          if ($count2>0) {
		          	//change to not favourite
		          	$stmt=$conn->prepare(" UPDATE favourite set favourite_status=0
			  	    where item_id=? and user_id=? ");
		            $stmt->execute(array($item,$user));
		          }else{
		          	//change to favourite
		          	$stmt=$conn->prepare(" UPDATE favourite set favourite_status=1
			  	    where item_id=? and user_id=? ");
		            $stmt->execute(array($item,$user));
		          }
	      }else{
			         //INSERT favourite
			     $stmt=$conn->prepare(" INSERT into favourite 
	      	 	(favourite_status,item_id,user_id,cat_id,subcat_id,state_id,city_id) 
	      	 	values(1,:zitem,:zuser,:zcat,:zsub,:zst,:zci) ");
		         $stmt->execute(array(
	             'zitem'     => $item,
	             'zuser'     => $user,
	             'zcat'     => $cat,
	             'zsub'     => $sub,
	             'zst'     => $state,
	             'zci'     => $city
	              ));
	             }
}






//add ads to favourite_tr => from traders
if (isset($_GET['item_T'])&&isset($_GET['user_T'])&&isset($_GET['cat'])&&isset($_GET['sub'])&&isset($_GET['st'])&&isset($_GET['ci'])) {
	$item=$_GET['item_T'];
	$user=$_GET['user_T'];
	$cat=$_GET['cat'];
	$sub=$_GET['sub'];
	$st=$_GET['st'];
	$ci=$_GET['ci'];

	 	$stmt=$conn->prepare(" SELECT *  from favourite 
	  	where item_id=? and user_id=? ");
	    $stmt->execute(array($item,$user));
	    $count=$stmt->rowCount();
	     if ($count>0) {
	      	      //if theres favourite
			      $stmt=$conn->prepare(" SELECT *  from favourite
			  	  where item_id=? and user_id=? and favourite_status=1 ");
		          $stmt->execute(array($item,$user));
		          $count2=$stmt->rowCount();

		          if ($count2>0) {
		          	//change to not favourite
		          	$stmt=$conn->prepare(" UPDATE favourite set favourite_status=0
			  	    where item_id=? and user_id=? ");
		            $stmt->execute(array($item,$user));
		          }else{
		          	//change to favourite
		          	$stmt=$conn->prepare(" UPDATE favourite set favourite_status=1
			  	    where item_id=? and user_id=? ");
		            $stmt->execute(array($item,$user));
		          }

	      }else{
			         //INSERT favourite
			     $stmt=$conn->prepare(" INSERT into favourite 
	      	 	(favourite_status,item_id,user_id,cat_id,subcat_id,state_id,city_id) 
	      	 	values(1,:zitem,:zuser,:zcat,:zsub,:zst,:zci) ");
		         $stmt->execute(array(
	             'zitem'     => $item,
	             'zuser'     => $user,
	             'zcat'     => $cat,
	             'zsub'     => $sub,
	             'zst'     => $st,
	             'zci'     => $ci
	              ));
	             }
  }


  

}//END if session




include $tmpl."footer.inc";
ob_end_flush();
