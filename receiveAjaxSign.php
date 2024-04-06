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



//receive country return states (from select in SingUp.php)
    if (isset($_GET['sentCountrySign']) && isset($_GET['l'])   ) {
     	    $sentCountrySign=$_GET['sentCountrySign'];
          $l=$_GET['l'];

          $stmt=$conn->prepare(" SELECT country.*,state.* from state
          join country on state.country_id=country.country_id
          where country.country_id=? order by state_id");
          $stmt->execute(array($sentCountrySign));
          $stateSign=$stmt->fetchAll();

          ?> <option value=" "><?php echo $lang['chooseSt'];?></option> <?php
          if(!empty($stateSign) ){
          foreach ($stateSign as $state) {
            if($l=='ar'){echo "<option value=".$state['state_id'].">".$state['state_nameAR']."</option>";}
            else{echo "<option value=".$state['state_id'].">".$state['state_name']."</option>";}
           }
           }else{echo "<option disabled>No states</option>";
            }


   }




	//receive state return cities (from select in SingUp.php) 
	if (isset($_GET['sentStateSign']) && isset($_GET['l'])     ) {
          $sentStateSign=$_GET['sentStateSign'];
          $l=$_GET['l'];

          $stmt2=$conn->prepare(" SELECT city.*,state.* from city
          join state on city.state_id=state.state_id
          where state.state_id=?  order by city_id");
          $stmt2->execute(array($sentStateSign));
          $citySign=$stmt2->fetchAll();

          ?> <option value=" "><?php echo $lang['chooseCity'];?></option> <?php
          if(!empty($citySign) ){
          foreach ($citySign as $city) {
            if($l=='ar'){echo "<option value=".$city['city_id'].">".$city['city_nameAR']."</option>";}
            else{echo "<option value=".$city['city_id'].">".$city['city_name']."</option>";}
           }
           }else{echo "<option disabled>No cities</option>";
           }


   }
         


 


include  $tmpl ."footer.inc";
ob_end_flush();

