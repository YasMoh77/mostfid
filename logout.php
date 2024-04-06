<?php
session_start();

   //DESTROY ONLY IF HIT LOGOUT
	if(isset($_GET['s']) && $_GET['s']=='no' ){ // Traders => phone sign up
		     
		     if (isset( $_SESSION['traderid'])) {
		     	unset( $_SESSION['traderid']);
	            unset( $_SESSION['trader']);
		     }elseif (isset($_SESSION['userGid'])) {
		     	unset( $_SESSION['userGid']);
	            unset( $_SESSION['userG']);
		     }elseif (isset($_SESSION['userFid'])) {
		     	unset( $_SESSION['userFid']);
	            unset( $_SESSION['userF']);
		     }elseif (isset($_SESSION['userEid'])) {
		     	unset( $_SESSION['userEid']);
	            unset( $_SESSION['userE']);
		     }

		if (isset($_COOKIE['cook_traderid'])  ) {
			//delete cookies 
			 unset( $_SESSION['traderid']);
	         unset( $_SESSION['trader']);
			 unset($_COOKIE['cook_traderid']);
			 unset($_COOKIE['cook_trader']);
	         setcookie('cook_trader','',time()-3600,'/');
	         setcookie('cook_traderid','',time()-3600,'/'); 
	        
		
		 //Google sign up
        }elseif (isset($_COOKIE['cookGId'])) {
	        	unset($_COOKIE['cookGName']);
	        	unset($_COOKIE['cookGId']);
		        setcookie('cookGName','',time()- 3600,'/');
		        setcookie('cookGId','',time()- 3600,'/'); 
	            unset( $_SESSION['userGid']);
	            unset( $_SESSION['userG']);
        
         //Email sign up
        }elseif (isset($_COOKIE['cookFId'])) {
	        	unset($_COOKIE['cookFName']);
	        	unset($_COOKIE['cookFId']);
		        setcookie('cookFName','',time()- 3600,'/');
		        setcookie('cookFId','',time()- 3600,'/'); 
	            unset( $_SESSION['userFid']);
	            unset( $_SESSION['userF']);
        
         //Email sign up
        }elseif (isset($_COOKIE['cookEId'])) {
	        	unset($_COOKIE['cookEName']);
		        setcookie('cookEName','',time()- 3600,'/');
		        unset($_COOKIE['cookEId']);
		        setcookie('cookEId','',time()- 3600,'/'); 
	            unset( $_SESSION['userEid']);
	            unset( $_SESSION['userE']);
        }

        

		//after logging out, go to index.php
		header('location:index.php');
		exit();


    //OR GO ON SESSION AND JUST HEAD TO INDEX.PHP
	}else{
		header('location:index.php');
		exit();
	}


