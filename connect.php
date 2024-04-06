<?php
	  
     
	$dsn='mysql:host=localhost; dbname=mostfid'; 
    $user='root';
    $password='';
    $options=array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8');


		/*$dsn='mysql:host=premium152.web-hosting.com; dbname=mostjxtw_mstfdb'; 
		$user='mostjxtw_mstfus';
		$password='YasserMoh@0965320614';
		$options=array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8');*/


		try {
			$conn = new PDO($dsn, $user, $password, $options); 
			$conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
			
		   }

		catch (PDOException  $e){
		echo('failed'). $e->getMessage();  // a message shown in time of failure
		 }
