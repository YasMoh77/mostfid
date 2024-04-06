<?php
session_start();  //important in every php page
//important pocedures in every php page
$removeNavBar='';     //put this to stop nav bar in this page
$title='Login';       //title of the page
include 'init.php';   //included files
  

if (isset($_SESSION['idMos'])) {
	header('location:dashboard.php');
	exit();
}


//checking if request method is 'post'
if($_SERVER['REQUEST_METHOD']=='POST') {
		$email=$_POST['email'];
		$pass=$_POST['password'];
		//$hashedPass=sha1($pass); 
        //
		$stmt=$conn->prepare('SELECT  *
		FROM user WHERE email=? /*AND password=?*/  ');
		$stmt->execute(array($email));
		$fetched=$stmt->fetch();
		$row=$stmt->rowCount();

		if ($row==0) { ?> <div class="div-active-login"><span>wrong email </span></div> <?php }
        if ($row>0){ 
        	   //verify hashed pass
    	if(password_verify($pass, $fetched['password'])){ 
    			//checking if user is activated
	    $stmt2=$conn->prepare('SELECT user_id, email, password
		FROM user WHERE email=?  AND  password=? And activate>0 and group_id >0	');
		$stmt2->execute(array($email,$fetched['password']));
		$row2=$stmt2->rowCount();

			//If an admin, register a session
			if ($row2>0) {
			//setcookie('email',$email, time()+150000);
			//setcookie('pass',$fetched['password'], time()+150000);
			$_SESSION['nameMos']=$fetched['name'];  //register a session using username
			$_SESSION['idMos']=$fetched['user_id']; //register a session using id
			//echo "okkk";
			header('location:dashboard.php');  //then direct him to dashboard.php
			exit();                            //then exit
			  } 

		   } //end if(password_verify(
		} //end if ($row>0)
     } //END if($_SERVER['REQUEST_METHOD']== 'POST'


?>
<!--HTML TAGS-->
<form class="admin-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
	<label>Admin Login</label>
<input type="email" name="email" placeholder="Enter email"  class="log" autocomplete="on">
<input type="password" name="password" placeholder="Enter password" class="  log" autocomplete="new-password">
<input type="submit" name="submit" value="Login">
</form>










<?php include  $tmpl ."footer.inc";?>