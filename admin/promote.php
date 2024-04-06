<?php //CANCELLED
/*ob_start();
session_start();//important in every php page
$title='Promote';     //title
include 'init.php';   //include
if (isset($_SESSION['idMos']) && $_SESSION['idMos']==7) { //check presence of session
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			$promote1=isset($_POST['promote'])?$_POST['promote']:null;
			$user_id=$_POST['user_id'];
			//$promoteSuperAdmin=isset($_POST['promoteSuperAdmin'])?$_POST['promoteSuperAdmin']:null;
              $promote=$promote1>0?$promote1:1;
             if ($promote == 1) { //user
             	//connecting with database to send new data
				 $stmt=$conn->prepare('UPDATE  user  SET  group_id=0  WHERE  user_id=? ');
		         $stmt->execute(array($user_id));

             }elseif ($promote == 2){ //admin
             	//connecting with database to send new data
				 $stmt=$conn->prepare('UPDATE  user  SET  group_id=1  WHERE  user_id=? ');
		         $stmt->execute(array($user_id));
				 
             }elseif ($promote == 3){ //super admin
             	//connecting with database to send new data
				 $stmt=$conn->prepare('UPDATE  user  SET  group_id=2  WHERE  user_id=? ');
		         $stmt->execute(array($user_id));
				 
             }
             //
             if($stmt){
                   echo "<div class='block-green'>" ."Selected user promoted to";if($promote==1){echo " User";}elseif($promote==2){echo " Admin";}elseif($promote==3){echo " SuperAdmin";}  "</div>";
				 }
			
		}







}else{
	header('location:index.php');
	exit();
}
//End 
include $tmpl ."footer.inc";
ob_end_flush();*/
?>			