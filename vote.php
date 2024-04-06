<?php
ob_start();
session_start();
$title='vote';       //title of the page
//abbreviations
$tmpl='include/templates/';
$css='layout/css/';
$js='layout/js/';
$images='layout/images/';
$fonts='layout/fonts/';
$language='include/languages/';
$func='include/functions/';
//important files
include "lang.php"; //must be before header or header words fail.
include $tmpl."header.inc";
include 'connect.php'; //this file connects to database
include $func.'functions.php';



    	 // RECEIVING AJAX WHEN CLICKING ON STARS  (RATE US)
    	if ( (isset($_GET['one'])||isset($_GET['two'])||isset($_GET['three'])||isset($_GET['four'])||isset($_GET['five']) ) &&isset($_GET['user'])&&isset($_GET['userid'])&&isset($_GET['item']) ) {
            $one=isset($_GET['one'])?$_GET['one']:0;
            $two=isset($_GET['two'])?$_GET['two']:0;
            $three=isset($_GET['three'])?$_GET['three']:0;
            $four=isset($_GET['four'])?$_GET['four']:0;
            $five=isset($_GET['five'])?$_GET['five']:0; 
           
            if($one>0){
            $vote=$one;
            }elseif($two>0) {
            $vote=$two;
            }elseif($three>0) {
            $vote=$three;
            }elseif($four>0) {
            $vote=$four;
            }elseif($five>0) {
            $vote=$five;
            }

            $userid=$_GET['userid'];
            $item  =$_GET['item'];
            
            

    		$stmtall=$conn->prepare(" SELECT * from vote where user_id=? and item_id=?");
    		$stmtall->execute(array($userid,$item));
    		$count=$stmtall->rowCount();
    		if($count>0){ 
	    		  	if ($vote>0) {
        	    			$stmtUp=$conn->prepare(" UPDATE vote set VOTE=? where user_id=? and item_id=?");
        	    			$stmtUp->execute(array($vote,$userid,$item));
	    		       	}
	    			if($stmtUp){
	                 echo "<span class='thanks-voting'>".$lang['thanksVoting']."</span>";
                   $stmt=$conn->prepare(" SELECT * from vote where user_id=? and item_id=?");
                   $stmt->execute(array($userid,$item));
                   $VOTE= $stmt->fetch();
                   $count=$stmt->rowCount();
                      if ($count>0) { 
                          echo "<span class='thanks-voting2'>( ".$lang['yourVote'].' '.$VOTE['VOTE'].' )</span>';
                      }
                    }

    		}else{ //SEND VOTES
	    	//Bring data from database
    		 $stmt=$conn->prepare(" INSERT INTO vote (VOTE,user_id,item_id) values (:zvote,:zuserid,:zitem) ");
			   $stmt->execute(array( 'zvote'  => $vote,'zuserid'=>$userid,'zitem'=>$item  )); 
              if ($stmt) {
		      	 echo "<span class='thanks-voting'>".$lang['thanksVoting']."</span>";
		               $stmt=$conn->prepare(" SELECT * from vote where user_id=? and item_id=?");
                   $stmt->execute(array($userid,$item));
                   $VOTE= $stmt->fetch();
                   $count=$stmt->rowCount();
            if ($count>0) { 
                echo "<span class='thanks-voting2'>( ".$lang['yourVote'].' '.$VOTE['VOTE'].' )</span>';
                }
             }	

	    } //END IF($COUNT)  
	} //if (isset($_POST['one']))




          
 include  $tmpl ."footer.inc";
 ob_end_flush();
 ?>