<?php
ob_start();
session_start();
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




//from listing2.php
if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

if (isset($session) ) {	


     //returning states based on country
if  (isset($_GET['sentCountry']) && isset($_GET['l']) ) {
          $sentCountry=$_GET['sentCountry'];
            $l=$_GET['l'];

          $stmt=$conn->prepare(" SELECT country.*,state.* from state
          join country on state.country_id=country.country_id
          where country.country_id=? ");
          $stmt->execute(array($sentCountry));
          $state=$stmt->fetchAll();

          ?> <option value="0"><?php echo $lang['choose']?></option> <?php
          if(!empty($state) ){
              foreach ($state as $st) {
                if($l=='ar'){echo "<option value=".$st['state_id'].">".$st['state_nameAR']."</option>";}
                else{echo "<option value=".$st['state_id'].">".$st['state_name']."</option>";}
               }
           }else{
            echo "<option value='0' disabled>".$lang['noStates']."</option>";
           }

         }






         //returning cities  
if (isset($_GET['sentState']) && isset($_GET['l']) ){
          $sentState=$_GET['sentState'];
          $l=$_GET['l'];

          $stmt=$conn->prepare(" SELECT city.*,state.* from city
          join state on city.state_id=state.state_id
          where state.state_id=?   ");
          $stmt->execute(array($sentState));
          $cities=$stmt->fetchAll();

          ?> <option value="0"><?php echo $lang['choose']?></option> <?php
          if(!empty($cities) ){
          foreach ($cities as $city) {
                  if($l=='ar'){echo "<option value=".$city['city_id'].">".$city['city_nameAR']."</option>";}
                  else{echo "<option value=".$city['city_id'].">".$city['city_name']."</option>";}
              }
           }else{
            echo "<option value='0' disabled>".$lang['noCities']."</option>";
           }

     }


                         

}else{ //if no session
  header("location:signin.php");
	exit();
}


 include  $tmpl ."footer.inc";
ob_end_flush();
?>
