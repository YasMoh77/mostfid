<?php
ob_start();
session_start();       //important in every php page
$title='Action';       //title of the page
include 'init.php';




if (isset($_SESSION['idMos']) && $_SESSION['idMos']==7 ) {
  if($_SERVER['REQUEST_METHOD']=='POST'){

  //block, unblock, activate members => coming from members.php
  if(isset($_POST['change']) && isset($_POST['userTrader']) ){
	if (isset($_POST['change']) && $_POST['change']!=0  && isset($_POST['userTrader']) && is_numeric($_POST['userTrader']) && $_POST['userTrader']>0 ) {
					
						$do=$_POST['change'];
						$userTrader=filter_var(trim($_POST['userTrader']),FILTER_SANITIZE_NUMBER_INT);
	                        $stmt=$conn->prepare('SELECT user_id,phone from user WHERE user_id=? OR phone=? ');
	                        $stmt->execute(array($userTrader,$userTrader));
	                        $found=$stmt->rowCount();
                        if ($userTrader>0) {
	                        if($found>0){ 
								if ($do=='1') { //block user or trader
									$stmt=$conn->prepare(' UPDATE user set block=1 where  phone=? OR user_id=? ');
								    $stmt->execute(array($userTrader,$userTrader));
									if ($stmt) {
										echo "<div class='block-green'>User blocked Successfully</div>";
									}else{
										echo "<span class='center'>action wasnot executed, Try again</span>";
									}
								}elseif ($do=='2') { //unblock user or trader
									$stmt=$conn->prepare(' UPDATE user set block=0 where  phone=? OR user_id=? ');
								    $stmt->execute(array($userTrader,$userTrader));
									if ($stmt) {
										echo "<div class='block-green'>User unblocked Successfully</div>";
									}else{
										echo "<span class='center'>action wasnot executed, Try again</span>";
									}
								}elseif ($do=='3') { //activate
										$stmt=$conn->prepare(' UPDATE user set activate=1 where  phone=? OR user_id=?  ');
									    $stmt->execute(array($userTrader,$userTrader));
										if ($stmt) {
											echo "<div class='block-green'>User activated Successfully</div>";
										}else{
											echo "<span class='center'>action wasnot executed, Try again</span>";
										}
								  
								}elseif ($do=='4') { //deactivate=ban
										$stmt=$conn->prepare(' UPDATE user set activate=2 where  phone=? OR user_id=?  ');
									    $stmt->execute(array($userTrader,$userTrader));
										if ($stmt) {
											echo "<div class='block-green'>User Deactivated Successfully</div>";
										}else{
											echo "<span class='center'>action wasnot executed, Try again</span>";
										}
								  
								}elseif ($do=='5') { //hide products for not paying back mostafed money
                                        $fetchUid=fetch('user_id','user','phone',$userTrader);//get user_id if phone is inserted
									   // echo 'id='.$fetchUid['user_id'];
									    $stmt=$conn->prepare(' UPDATE items set hide=1 where  user_id=? OR user_id=?  ');
									    $stmt->execute(array($userTrader,$fetchUid['user_id']) );
										if ($stmt) {
											echo "<div class='block-green'>Products for this user are now hidden</div>";
										}else{
											echo "<span class='center'>action wasnot executed, Try again</span>";
										}
								
								}elseif ($do=='6') { //Unhide products for not paying back mostafed money
									    $fetchUid=fetch('user_id','user','phone',$userTrader);//get user_id if phone is inserted
									    $stmt=$conn->prepare(' UPDATE items set hide=0 where  user_id=? OR user_id=?  ');
									    $stmt->execute(array($userTrader,$fetchUid['user_id']));
										if ($stmt) {
											echo "<div class='block-green'>Products for this user are now shown</div>";
										}else{
											echo "<span class='center'>action wasnot executed, Try again</span>";
										}
								
								}elseif ($do=='7') { //change trader to online pay
									    $fetchTrId=fetch('trader','user','user_id',$userTrader);
										$fetchTrId2=fetch('trader','user','phone',$userTrader);
									    
										if($fetchTrId['trader']==1||$fetchTrId2['trader']==1){ //this is a trader
												$stmt=$conn->prepare(' UPDATE user set online_pay=1 where  user_id=? OR phone=? and trader=1  ');
									            $stmt->execute(array($userTrader,$userTrader));
										
												if ($stmt) {
													echo "<div class='block-green'>Success..Trader changed to online pay</div>";
												}else{
													echo "<span class='center'>action wasnot executed, Try again</span>";
												}
										}else{
											echo "<span class='center'>Online pay for traders only. </span>";
										}
								
								}elseif ($do=='8') { //Cancel online pay
									    $stmt=$conn->prepare(' UPDATE user set online_pay=0 where  user_id=? OR phone=?  ');
									    $stmt->execute(array($userTrader,$userTrader));
										if ($stmt) {
											echo "<div class='block2'> Online pay was invalidated</div>";
										}else{
											echo "<span class='center'>action wasnot executed, Try again</span>";
										}
								
								}elseif ($do=='9') { //Make Admin
									    $stmt=$conn->prepare(' UPDATE user set group_id=1 where  user_id=? OR phone=?  ');
									    $stmt->execute(array($userTrader,$userTrader));
										if ($stmt) {
											echo "<div class='block-green'> Member promoted to Admin</div>";
										}else{
											echo "<span class='center'>action wasnot executed, Try again</span>";
										}

								}elseif ($do=='10') { //Return to user
										$stmt2=$conn->prepare(' SELECT group_id from user where  user_id=? OR phone=?  ');
									    $stmt2->execute(array($userTrader,$userTrader));
									    $groupID=$stmt2->fetch();
									    if ($groupID['group_id']==0) {
									    	echo "<div class='block2'> Member is already a user </div>";
									    }else{
	                                        $stmt=$conn->prepare(' UPDATE user set group_id=0 where  user_id=? OR phone=?  ');
										    $stmt->execute(array($userTrader,$userTrader));
											if ($stmt) {
												echo "<div class='block-green'> Member returned to user</div>";
											}else{
												echo "<span class='center'>action wasnot executed, Try again</span>";
											}
								       }

								}elseif ($do=='11') { //Delete member (user or trader)
									    $stmt2=$conn->prepare(' SELECT user_id from user where  user_id=? OR phone=?  ');
									    $stmt2->execute(array($userTrader,$userTrader));
									    $userID=$stmt2->fetch();
									    if ($userID['user_id']==0) {
									    	echo "<div class='block2'> Member is already deleted </div>";
									    }else{
										    //mostafed profit on passed orders(approve=1)
										    $stmt2=$conn->prepare(' SELECT sum(order_mostafed) from orders where  (trader_id=? OR trader_phone=?) and approve=1 ');
										    $stmt2->execute(array($userTrader,$userTrader));
										    $userMostfid=$stmt2->fetchColumn();
										   
										    $online=fetch('online_pay','user','user_id',$userID['user_id']);
										    if ($online['online_pay']==0 && $userMostfid>0) { //pay manual & owes no money to mostfid
										    	echo "<div class='block2'>SORRY! This member owes money to mostfid. You can't delete him </div>";
										   }else{ //END if ($online['online_pay']==0 && $userMostfid>0)	
											    $stmt=$conn->prepare(' DELETE from user where  user_id=? OR phone=?  ');
											    $stmt->execute(array($userTrader,$userTrader));
												if ($stmt) {
													echo "<div class='block-green'> Member deleted</div>";
												}else{
													echo "<span class='center'>action wasnot executed, Try again</span>";
												}
										   } 
                                      } 

								}else{
										echo "<span class='center'>Wrong ... Choose action</span>";
									}
							}else{
								echo "<span class='center'>Wrong ... insertion is not in our database</span>";
							}
					    }

					}else{
							echo "<span class='center'>Wrong ... Empty Values</span>";
						}


    
    //change user/trader data => coming from members.php
	}elseif (isset($_POST['update']) && isset($_POST['newData'])&& isset($_POST['idPhone']) ) {
		$updateValue1 =isset($_POST['update'])&& is_numeric($_POST['update'])&&$_POST['update']>0?intval($_POST['update']):0;
		$newData1     =isset($_POST['newData'])?trim($_POST['newData']):' ';
		$idPhone1     =isset($_POST['idPhone'])&&is_numeric($_POST['idPhone'])?intval($_POST['idPhone']):0;
        //sanitize
        $updateValue=filter_var($updateValue1,FILTER_SANITIZE_NUMBER_INT);
		$newData    =filter_var($newData1,FILTER_SANITIZE_STRING);
		$idPhone    =filter_var($idPhone1,FILTER_SANITIZE_NUMBER_INT);
		//if fields are empty
		if ($updateValue<1) {
			echo "<span class='center'>Wrong ... Choose value</span>";
		}elseif (strlen($newData)==0) {
			echo "<span class='center'>Wrong ... Insert data</span>";
		}elseif (empty($idPhone)) {
			echo "<span class='center'>Wrong ... Insert Id OR phone</span>";
		}else{
        //chck if member is found
		$stmt=$conn->prepare('SELECT user_id,phone from user WHERE user_id=? OR phone=? ');
        $stmt->execute(array($idPhone,$idPhone));
        $found=$stmt->rowCount();

        if ($found>0) { 
        	 $fetchTr=fetch('trader','user','phone',$idPhone);
        	 $fetchTr2=fetch('trader','user','user_id',$idPhone);
        	if ($updateValue1==1) {
			   if (!is_numeric($newData)) { 
					$stmt2=$conn->prepare(' UPDATE user set name=?  where  user_id=? OR phone=?  ');
					$stmt2->execute(array($newData,$idPhone,$idPhone));
			       if ($stmt2) { echo "<div class='block-green'>Selected data updated successfully</div>"; }
              }else{echo "Wrong! You inserted number";}
           }elseif ($updateValue1==2) {
           	  if (!is_numeric($newData)) { 
                    if($fetchTr['trader']>0||$fetchTr2['trader']>0){
			           	$stmt2=$conn->prepare(' UPDATE user set commercial_name=?  where  user_id=? OR phone=?  ');
						$stmt2->execute(array($newData,$idPhone,$idPhone));
						if ($stmt2) { echo "<div class='block-green'>Selected data updated successfully</div>"; }
                   }else{ echo "SORRY! This is not a trader";}
              }else{echo "Wrong! You inserted number";}
           }elseif ($updateValue1==3) {
           	  if (!is_numeric($newData)) { 
           	  	   if($fetchTr['trader']>0||$fetchTr2['trader']>0){
			           	$stmt2=$conn->prepare(' UPDATE user set address=?  where  user_id=? OR phone=?  ');
						$stmt2->execute(array($newData,$idPhone,$idPhone));
						if ($stmt2) { echo "<div class='block-green'>Selected data updated successfully</div>"; }
                   }else{ echo "SORRY! This is not a trader";}
             }else{echo "Wrong! You inserted number";}
           }elseif ($updateValue1==4) {
             if (is_numeric($newData)) {
        		 if(strlen($newData)==11){
	        		$fetchPh=fetch('phone','user','phone',$newData);
	        		if($fetchPh['phone']>0){
	                   echo "SORRY! phone is used";
	        		}else{
			           $stmt2=$conn->prepare(' UPDATE user set phone=?  where  user_id=? OR phone=?  ');
					   $stmt2->execute(array($newData,$idPhone,$idPhone));
					   if ($stmt2) { echo "<div class='block-green'>Selected data updated successfully</div>"; }
		            }
	            }else{ echo "pls insert 11 digits"; }
	          }else{echo "pls insert phone number";}
           }
           
           
           
        }else{
        	echo "<span class='center'>Member not found </span>";
        }
	}

    




    // trader paid or not  => coming from dashboard & dash=='mostafed'   
	}elseif (isset($_POST['payStatus']) && isset($_POST['tr-phone'])  ) {
			if (isset($_POST['payStatus'])&&is_numeric($_POST['payStatus'])&&$_POST['payStatus']>0 && isset($_POST['tr-phone']) && is_numeric($_POST['tr-phone'])&&$_POST['tr-phone']>0 ) {
				$pay=intval($_POST['payStatus']);//1=Yes, paid//2=Not paid
				$phone1=intval($_POST['tr-phone']);
				$phone=filter_var(trim($phone1),FILTER_SANITIZE_NUMBER_INT);
	            $fetchTrID=fetch2('user_id','user','phone',$phone,'trader',1);
	            $fetchOnline=fetch2('online_pay','user','phone',$phone,'trader',1);

              if ($fetchTrID['user_id']>0) { //this must be  a trader
                 if($fetchOnline['online_pay']==0){ //only deal with traders who pay manual
                $checkTr=checkItem('trader_id','orders',$fetchTrID['user_id']);
                if ($checkTr>0) { //trader has orders in orders table
                	if ($pay==1) { //set paid =1 for this trader =Yes paid
	              	    $stmt=$conn->prepare(' UPDATE orders set paid=1 where  trader_id=?  ');
						$stmt->execute(array($fetchTrID['user_id']));
							if ($stmt) {
							echo "<div class='alert alert-success'>Trader updated to paid</div>";
						   }
                      }elseif ($pay==2) { //set paid =0 for this trader =No, didn't pay
                      	$stmt=$conn->prepare(' UPDATE orders set paid=0 where  trader_id=?  ');
						$stmt->execute(array($fetchTrID['user_id']));
							if ($stmt) {
							echo "<div class='alert alert-success'>Trader updated to Unpaid</div>";
						   }
                      }
                }else{
              	  echo "<div class='alert alert-danger'>This trader has no orders here</div>";
                }
               }else{
               	echo "<div class='alert alert-danger'>Ooops; This trader pays online. We deal with manual traders here </div>";
               }
             }else{
            	echo "<div class='alert alert-danger'>We didn't find a trader with this number</div>";
             }
		}else{
		echo "<div class='alert alert-danger'>Choose action & insert phone number</div>";
	    }

	 




    // if trader paid change order_mostafed to 0  => coming from dashboard & dash=='mostafed'  
	}elseif (isset($_POST['setMosZero'])) {
		    $trader_info=filter_var(trim($_POST['paidTr']),FILTER_SANITIZE_NUMBER_INT);
		    $trOrdersPh= fetch('trader_phone','orders','trader_phone',$trader_info);
			$trOnline= fetch('online_pay','user','phone',$trader_info);
			$trPaid= fetch('paid','orders','trader_phone',$trader_info);

             if(strlen($trader_info)>0){ //if not empty
				if('0'.$trOrdersPh['trader_phone']===$trader_info){ //if phone is orrect
	                if($trOnline['online_pay']==0){ //if trader pays manual only
						if($trPaid['paid']==1){ //only if trader has paid
							$stmt=$conn->prepare(' UPDATE orders set order_mostafed=0,paid=0 where   trader_phone=? and paid=1  ');
							$stmt->execute(array($trader_info) );
								if ($stmt) {
								echo "<div class='alert alert-success'>Mostafed value & paid both updated to 0</div>"; 
							   }
						}else{
							echo "<div class='alert alert-danger'>STOP; This trader hasn't paid yet. </div>";
						}
					 }else{
					 	echo "<div class='alert alert-danger'>Ooops; This trader pays online. We deal with manual traders here.</div>";
					 }
		        }else{
		        	echo "<div class='alert alert-danger'>NO such a trader in orders table </div>";
		        }
		      }else{
		        	echo "<div class='alert alert-danger'>Insert trader's phone </div>";
		        }





    // update orders set order_mostafed=? for trader=? =>  coming from dashboard & $dash=='orders'
    //used for corrections if some values from order_mostafed were deleted unintentionally and wrongly
	}elseif (isset($_POST['TrPhone'])) {
		$trader_phone=filter_var(trim($_POST['TrPhone']),FILTER_SANITIZE_NUMBER_INT);
	     //mostafed rates
          $fetchIT=fetchAll('item_id','orders','trader_phone',$trader_phone);
          if (!empty($fetchIT)) {
          	foreach ($fetchIT as $value) {
	          
	          $fetch=fetch('*','items','item_id',$value['item_id']);
	          $price=$fetch['price'];
	          $discount=$fetch['discount'];
	          $AfterCutPrice=$price-($price*($discount/100));
	          if ($fetch['subcat_id']==22||$fetch['subcat_id']==28||$fetch['subcat_id']==59||$fetch['subcat_id']==60||$fetch['subcat_id']==61) { //22=cloth,28=ceramic,59=electric works,60 painting,61 ceramic works
	             if ($fetch['subcat_id']==22) {$mostafed=2;}else{$mostafed=4;}
	          }else{
	          	//.5% of the after discount price is mostafed rate 
	          	$mostafed=$AfterCutPrice*(.5/100);
	          } //END  if ($sub==22||
	        
	          //UPDATE orders
	          $stmt=$conn->prepare(' UPDATE orders set order_mostafed=?  where  item_id=?   ');
	          $stmt->execute(array($mostafed,$value['item_id']) );
	           if ($stmt) {
	           	echo "<div class='alert alert-success'>order_mostafed in orders table updated for this trader </div>"; 
	           }
         } } //END if (!empty($fetchIT)) & foreach




    //add review to appear on index.php =>  coming from dashboard & $dash=='add'
	}elseif (isset($_POST['reviewText'])&&isset($_POST['name']) ) {
		$reviewText=trim($_POST['reviewText']);
		$name      =trim($_POST['name']);

		 $stmt=$conn->prepare("INSERT INTO  
			 	  review(review_text,name ) 
			    VALUES (:ztext,:zname )");
	    $stmt->execute(array(
				   "ztext"    =>   $reviewText,
				   "zname"    =>   $name
	               ));
	    if ($stmt) {
	    	echo "<div class='block-green'>Review added successfully</div>";
	    }



    //update review to appear on index.php =>  coming from dashboard & $dash=='add'
	}elseif (isset($_POST['reviewUpdate'])) { 
		 $review_id  =$_POST['reviewUpdate'];
		 $review_text=$_POST['newReview'];
		 $name       =$_POST['newName'];
		 $stmt=$conn->prepare(' UPDATE review set review_text=?,name=? where  review_id=?  ');
		 $stmt->execute(array($review_text,$name,$review_id));
				if ($stmt) {
				echo "<div class='block-green grr'>Review updated successfully</div>";
				?>
				<script>
					setTimeout(function div(){ $('.grr').fadeOut();},1800);
					setTimeout(function go(){location.href='dashboard.php?dash=reviews';},1900);
				</script>
				<?php
			   }




    //send group messages , coming from => dashboard & dash= messages
	}elseif (isset($_POST['sendAll'])&&isset($_POST['selectAll'])) { //
		$msg=filter_var(trim($_POST['sendAll']),FILTER_SANITIZE_STRING);
		$to=$_POST['selectAll'];
		$traders=$_POST['id'];
		$all=$_POST['all'];
		$date=time();
		if(strlen($msg)>0){
			if($to==1) { //to all traders
				 $count=count($traders);
				 for ($i=0;  $i<$count;  $i++) { 
				 	 $stmt=$conn->prepare(" INSERT into message 
		              (message_text,message_date,message_from,message_to) 
		              values(:ztxt,:zdate,7,:zto) ");
		               $stmt->execute(array(
		               'ztxt'    => $msg,
		               'zdate'   => $date,
		               'zto'     => $traders[$i] 
		               ));
				  }
				if ($stmt) {
					 ?><span class="block-green">Group message sent to all traders</span> <?php
				}
			}elseif ($to==2) { //to all (traders & users)
				$count=count($all);
				 for ($i=0;  $i<$count;  $i++) { 
				 	 $stmt=$conn->prepare(" INSERT into message 
		              (message_text,message_date,message_from,message_to) 
		              values(:ztxt,:zdate,7,:zto) ");
		               $stmt->execute(array(
		               'ztxt'    => $msg,
		               'zdate'   => $date,
		               'zto'     => $all[$i] 
		               ));
				  }
				if ($stmt) {
					 ?><span class="block-green">Group message sent to traders & users (activated only)</span> <?php
				}
			}else{ //end $to==1
	          ?><span class="block2">Choose from select box</span> <?php
			}
      }else{
      	?><span class="block2">Type your message</span> <?php
      }





	//delete messages older than => from dashboard & d='msg'
	}elseif (isset($_POST['selectDelMsg'])) {
		 $delete=$_POST['selectDelMsg'];
		 if ($delete==1) {
		 	$stmt=$conn->prepare(' DELETE from message  where  message_date<(UNIX_TIMESTAMP()-3600*24*7)  ');
		    $stmt->execute();
		    $row=$stmt->rowCount();
		 }elseif ($delete==2) {
		 	$stmt=$conn->prepare(' DELETE from message  where  message_date<(UNIX_TIMESTAMP()-3600*24*14)  ');
		    $stmt->execute();
		    $row=$stmt->rowCount();
		 }elseif ($delete==3) {
		 	$stmt=$conn->prepare(' DELETE from message  where  message_date<(UNIX_TIMESTAMP()-3600*24*21)  ');
		    $stmt->execute();
		    $row=$stmt->rowCount();
		 }

		 if ($stmt) {
			echo "<div class='block-green'>".$row.' Messages deleted successfully'."</div>";
		   }else{
		   	echo "<div class='block2'>Not</div>";
		   }
	




    //send automatic message to traders with short credit whose items have been hidden asking them to charge credit
	}elseif (isset($_POST['lowCredit'])) {
		$stmt=$conn->prepare("SELECT *  FROM  user
          WHERE trader=1 and online_pay=1 and password is not null  ");
        $stmt->execute();
        $fetched=$stmt->fetchAll(); 
        if (!empty($fetched)) {
          foreach ($fetched as $value) {
            //get max value for item mostafed to check if trader has enough credit for paying online
            $stmt=$conn->prepare("SELECT max(item_mostafed),user.online_pay,items.user_id FROM  items
              join user on  items.user_id=user.user_id WHERE user.user_id=? and user.online_pay=1 ");
            $stmt->execute(array($value['user_id']));
            $fetchMax=$stmt->fetch();
            //hide items if credit is less than max(item_mostafed)
            if($value['credit']<$fetchMax['max(item_mostafed)']*3){
              //send msg to say that items are shown
			  $msg2='عفواً؛ لقد تم حجب اعلاناتكم لعدم وجود رصيد يفي بمستحقات مستفيد عن الطلبات القادمة.. الرجاء شحن رصيدكم حتى تتمكنوا من استقبال طلبات جديدة ..للاستفسار اتصل على 01013632800 .. مع تحيات ادارة موقع مستفيد ';
              $date2=time();
              $stmt4=$conn->prepare(" INSERT into message 
              (message_text,message_date,message_from,message_to) 
              values(:ztxt,:zdate,7,:zto) ");
               $stmt4->execute(array(
               'ztxt'    => $msg2,
               'zdate'   => $date2,
               'zto'     => $value['user_id']
               ));
               
               if ($stmt4) {	echo "<div class='block-green'>Success; Group messages sent to these Traders </div>"; }
            }
          }//end foreach
         
        }//end if (!empty($fetched))
	}elseif (isset($_POST['getMem'])) {
		$phone=$_POST['getMem'];
		if (strlen($phone)==11) { 		
	    ?>
	    <h1 class="h1Manage mem"> Get Member</h1>
				<div class="container unconfirmedTr">
					<div class="table-container">
					<table class="table-manage-members">
						<thead>
							<tr>
								<td><a href=""> ID </a> </td>
								<td><a href=""> Username </a> </td>
								<td><a href=""> Email </a> </td>
								<td><a href=""> Phone </a> </td>
								<td><a href=""> Country </a> </td>
								<td><a href=""> State </a> </td>
								<td><a href=""> City </a> </td>
								<td><a href=""> Register date </a> </td>
								<td><a href=""> No. Orders </a> </td>
								<td><a href=""> Approved Orders </a> </td>
								<td><a href=""> Pending Orders </a> </td>
								<td><a href=""> Were reported? </a> </td>
								<td><a href=""> They reported? </a> </td>
								<td><a href=""> Block </a> </td>
								<td><a href=""> Need SMS/Ok,Banned </a><br>(Activate=0,1,2) </td>
								<td><a href=""> Program </a> </td>
								<td><a href=""> Program Credit </a> </td>
								<td><a href=""> Group Id </a> </td>
								<td><a href=""> Code </a> </td>
								<td><a class='actionTd-mem' href=""> action </a> </td>
						    </tr>
						</thead>
						<tbody>
						<?php
						$stmt=$conn->prepare("SELECT user.*,country.*,state.*,city.*  FROM  user 
		                  inner join country on country.country_id=user.country_id
		                  inner join state on state.state_id=user.state_id
		                  inner join city on city.city_id=user.city_id
						  WHERE  phone=? order by user_id desc ");
						$stmt->execute(array($phone));
						$fetched=$stmt->fetchAll();

						foreach ($fetched as  $value) {//foreach start
							//all orders
				            $all_orders=countFromDb2('order_id','orders','user_id=',$value['user_id']);
				            //approved orders
				            $appr_orders=countFromDb3('order_id','orders','user_id=',$value['user_id'],'approve',1);
				            //pending orders
				            $pend_orders=countFromDb3('order_id','orders','user_id=',$value['user_id'],'approve',0);
				            //pending orders
				            $were_reported=countFromDb3('report','orders','user_id=',$value['user_id'],'report',1);
				            //pending orders
				            $they_reported=countFromDb3('report_trader','orders','user_id=',$value['user_id'],'report_trader',1);
 
							echo "<tr class='tr-members'>";
							echo "<td>".$value['user_id']  ."</td>";
							echo "<td class='td2'>".$value['name'] ."</td>";
							echo "<td class='td3'>".$value['email']    ."</td>";
							echo "<td>".'0'.$value['phone']."</td>";
							echo "<td>".$value['country_name'] ."</td>";
							echo "<td>".$value['state_name'] ."</td>";
							echo "<td class='td4'>".$value['city_name'] ."</td>";
							echo "<td class='td4'>".$value['reg_date']. "</td>";
							echo "<td class='td4'>".$all_orders. "</td>";
							echo "<td class='td4'>".$appr_orders. "</td>";
							echo "<td class='td4'>".$pend_orders. "</td>";
							echo "<td class='td4'>".$were_reported. "</td>";
							echo "<td class='td4'>".$they_reported. "</td>";
							echo "<td class='td4'>";if($value['block']==1){ echo "<span class='red'>Yes</span>";} echo "</td>";
							echo "<td class='td4'>"; if($value['activate']==1){ ?><i class="fas fa-check green"></i> <?php }elseif($value['activate']==2){ ?><span class="red">Banned</span> <?php }else{ ?><span class="red">Need SMS</span> <?php } echo "</td>";
							echo "<td class='td4'>".$value['program']. "</td>";/////
							echo "<td class='td4'>";if($value['program_credit']>0){ echo $value['program_credit']; } echo "</td>";////
							echo "<td class='td4'>"; if($value['group_id']==1){ echo "Admin";}elseif($value['group_id']==2){ echo "SuperAdmin";} "</td>";
							if($_SESSION['idMos']==7){echo "<td class='td4'>".$value['code']. "</td>";}
							echo "<td >"; 
								if($_SESSION['idMos']==7){  //exclusive for the super admin
							         echo '&emsp;<input type="checkbox" name="check" value="'.$value["user_id"].'">&emsp;';
								     echo "<a href='members.php?do=edit&id=" . $value['user_id']."' class='btn btn-success'> Edit </a> 
								      <a href='members.php?do=delete&id=" . $value['user_id']."' class='btn btn-danger  confirm'>Delete </a>";//edit &delete
								      if($value['group_id'] ==0 /*&& $value['regstatus'] ==1*/){ ?>
								      	<form action="promote.php" method="POST" class ="promoteForm">
								      		<select class="promoteSelect1"  id="promote" name="promote">
								      			<option value="0" disabled>Promote </option>
								       		<option value="1" <?php if($value['group_id']==0){echo "selected";}?>>User </option>
							      			<option value="2" <?php if($value['group_id']==1){echo "selected";}?>> Admin</option>
							      			<option value="3" <?php if($value['group_id']==2){echo "selected";}?>> SuperAdmin</option>
								      		</select>
								      		<input type="hidden" name="user_id" value="<?php echo $value['user_id'] ?>">
								      		<button type="submit" class="promoteOk"><span class="promoteOkspan">OK</span></button>
								      	</form><!--<span class="promoteShow" > g</span>--> <?php 
								      }elseif($value['group_id'] ==1 /*&& $value['regstatus'] ==1*/){ ?>
								       <form action="promote.php" method="POST" class ="promoteForm">
								       	<select class="promoteSelect2"  id="promote2" name="promote">
								       		<option value="0" disabled>Promote </option>
								       		<option value="1" <?php if($value['group_id']==0){echo "selected";}?>>User </option>
							      			<option value="2" <?php if($value['group_id']==1){echo "selected";}?>> Admin</option>
							      			<option value="3" <?php if($value['group_id']==2){echo "selected";}?>> SuperAdmin</option>
								       	</select>
								       	<input type="hidden" name="user_id" value="<?php echo $value['user_id'] ?>">
								       	<button type="submit" class="promoteOk"><span class="promoteOkspan">OK</span></button>
								      </form><!--<span class="promoteShow"> </span>--> <?php 
								      }elseif($value['group_id'] ==2 /*&& $value['regstatus'] ==1*/){ ?>
								       <form action="promote.php" method="POST" class ="promoteForm">
								       	<select class="promoteSelect2"  id="promote2" name="promote">
								       		<option value="0" disabled>Promote </option>
								       		<option value="1" <?php if($value['group_id']==0){echo "selected";}?>>User </option>
							      			<option value="2" <?php if($value['group_id']==1){echo "selected";}?>> Admin</option>
							      			<option value="3" <?php if($value['group_id']==2){echo "selected";}?>> SuperAdmin</option>
								       	</select>
								       	<input type="hidden" name="user_id" value="<?php echo $value['user_id'] ?>">
								       	<button type="submit" class="promoteOk"><span class="promoteOkspan">OK</span></button>
								      </form><!--<span class="promoteShow"> </span>--> <?php 
								      } 
								    }								
							     "</td>";  
							echo "</tr>";						
						}//foreach end

					?> </tbody>						  										 				
					</table>
					</div>						
                </div>

	    <?php
	   }
    }//End elseif()







} //END if($_SERVER['REQUEST_METHOD']=='POST')


//Edit, approve & delete reviews
$do=isset($_GET['do'])?$_GET['do']:'nothing';

//Edit reviews
if ($do=='editReview') {
	$review_id=$_GET['id'];
	$check=checkItem('review_id','review',$review_id);
	
	if ($check>0) {
	$text=fetch('*','review','review_id',$review_id); 
	?>
	<form dir="rtl" class="center height " action="processAdmin2.php" method="POST">
		<input class=" above-lg" type="text" name="newReview" value="<?php echo $text['review_text'] ?>" autocomplete='off'>
		<input class=" above-lg" type="text" name="newName" value="<?php echo $text['name'] ?>" autocomplete='off'>
		<input type="hidden" name="reviewUpdate" value="<?php echo $text['review_id'] ?>">
		<button type="submit">ok</button>
		<p class=" above"><?php echo $text['review_text'] ?></p>
		<p class=" above"><?php echo $text['name'] ?></p>
	</form>
	<?php

	}else{ echo "<p class='center above-lg'>Review isn't found</p>";}




//approve reviews of users inserted by admin from  dashboard => add 
}elseif ($do=='approveReview') { 
	$review_id=$_GET['id'];
	$check=checkItem('review_id','review',$review_id);
	if ($check>0) {
		$stmt=$conn->prepare(' UPDATE review set approve=1 where  review_id=?  ');
		$stmt->execute(array($review_id));
			if ($stmt) {
			echo "<div class='block-green grr'>Review approved successfully</div>";
            ?>
			<script>
				setTimeout(function div(){ $('.grr').fadeOut();},1800);
				setTimeout(function go(){location.href='dashboard.php?dash=reviews';},1900);
			</script>
			<?php
		   }
	  } 



 //delete reviews  
 }elseif ($do=='deleteReview') {
	$review_id=$_GET['id'];
	$check=checkItem('review_id','review',$review_id);
	if ($check>0) {
		$stmt=$conn->prepare(' DELETE from review  where  review_id=?  ');
		$stmt->execute(array($review_id));
			if ($stmt) {
			echo "<div class='block-green grr'>Review deleted successfully</div>";
			?>
			<script>
				setTimeout(function div(){ $('.grr').fadeOut();},1800);
				setTimeout(function go(){location.href='dashboard.php?dash=reviews';},1900);
			</script>
			<?php
		   }
	  } 
 }//END elseif() 





}//END session



include $tmpl."footer.inc";
ob_end_flush();
