<?php
ob_start();
session_start();
$title='Sign up';       //title of the page
//abbreviations
$tmpl='include/templates/';
$css='layout/css/';
$js='layout/js/';
$images='layout/images/';
$fonts='layout/fonts/';
$language='include/languages/';
$func='include/functions/';
//important files
include '../lang.php';//must be before header or header words fail.
include $tmpl."header.inc";
include 'connect.php'; //this file connects to database
include $func.'functions.php';





//add trader from dashboard&dash=add
if (isset($_SESSION['idMos'])) {
	if($_SERVER['REQUEST_METHOD']=='POST') {	
	     if(isset($_POST['addTrader']) ){		        	
				  	$user   =$_POST['username'];
				  	$user2  =$_POST['commercial_name'];
				  	$phone  =$_POST['phone'];
				  	$address=$_POST['address'];
				  	$field  =$_POST['field'];
				  	$country=$_POST['country']; 
				  	$state  =$_POST['state'];
				  	$city   =$_POST['city'];
				  	$pay    =$_POST['onlinePay'];
				  	$online=$pay==1?1:0;
				  	date_default_timezone_set('Africa/Cairo');
				    $date   =date('Y-m-d');
				    $code1=rand(10000,100000);
		            $code2=md5($code1);
		            $code=substr($code2,0,6);
 

				  	//filter
				  	$filteredUser   =filter_var(trim($user),FILTER_SANITIZE_STRING);
			  		$filteredUser2  =filter_var(trim($user2),FILTER_SANITIZE_STRING);
			  	    $filteredPhone  =filter_var(trim($phone),FILTER_SANITIZE_NUMBER_INT);
			  		$filteredAddress=filter_var(trim($address),FILTER_SANITIZE_STRING);
				   
				   	$errors=array();
				   	//USER
					  	if(strlen(trim($filteredUser))<4) {
					  		$errors[]=$lang['usernameLeast'];
					  	}elseif(strlen(trim($filteredUser))>60) {
					  		$errors[]=$lang['usernameLong'];
					  	}
					  	//USER2
					  	if(strlen(trim($filteredUser2))<4) {
					  		$errors[]='أدخل أربعة أحرف على الأقل في اسم النشاط';
					  	}
					  	if(strlen(trim($filteredUser2))>60) {
					  		$errors[]='لا يجب أن يزيد اسم النشاط عن ستين حرفا';
					  	} 
					  	//ADDRESS
					  	if(strlen(trim($filteredAddress))<8) {
					  		$errors[]='أدخل على  الأقل ثمانية أحرف في حقل العنوان ';
					  	}
					  	if(strlen(trim($filteredAddress))>200) {
					  		$errors[]='لا يجب أن يزيد حقل العنوان عن مائتي حرف  ';
					  	}  
					     //TRADER FIELD OF WORK
					  	if($field==0 ) {
					  		$errors[]='اختر مجال نشاطك';
					  	}
				        //COUNTRY
					  	if($country==0 ) {
					  		$errors[]=$lang['chooseCont'];
					  	}
					  	//STATE
					  	if($state==0 ) {
					  		$errors[]=$lang['chooseSt'];
					  	}
					  	//CITY
					  	if($city==0 ) {
					  		$errors[]=$lang['chooseCity'];
					  	}
					  	//online pay
					  	if($pay==0 ) {
					  		$errors[]='اختر طريقة الدفع ';
					  	}
					  	//PHONE 
						$start=strpos($filteredPhone,'01');
						$start2=strpos($filteredPhone,'3');
				        $result1=phone($country,$filteredPhone);//checks if phone suits country
				        $fetch=fetch('phone','user','phone',$filteredPhone);
				        $phoneUsed=$fetch['phone']; 
				        
				        if (empty($filteredPhone)) {
				        $errors[]= $lang['enterPhone'];
				        }elseif ($result1[0]==2) {
				        $errors[]=$lang['checkPhoneNum'].' .. '.$lang['insert'].' '.$result1[1].' '.$lang['digit'];
				        }elseif ($phoneUsed==$filteredPhone) {
				        $errors[]= $lang['phoneUsed'];
				        }elseif ($start!==0) {
				        $errors[]='يجب أن يبدأ رقم المحمول بـ  &nbsp; 01';
				        }elseif ($start2===2) {
				        $errors[]='انتبه؛ رقم المحمول يبدأ بـ   &nbsp; 013 ';
				        }

				        if (!empty($errors)) {
				   foreach ($errors as  $value) { 
					echo  '<span class="block2 ">'.$value.'</span>';
				   }
			      
				 }else{
				 	$stmt=$conn->prepare('INSERT INTO  
					    	user(name,commercial_name,online_pay,address,phone,cat_id,country_id,state_id,city_id,reg_date,trader,activate,accepted_terms,code)
					     VALUES(:zname,:zcomm,:zonline,:zaddress,:zphone,:zcat,:zcountry,:zstate,:zcity,:zdate,1,1,1,:zcode)');
			             $stmt->execute(array(
			               "zname"    =>    $filteredUser,
			               "zcomm"    =>	$filteredUser2,
			               "zonline"  =>	$online,
			               "zaddress" =>	$filteredAddress,
						   "zphone"   =>	$filteredPhone,
						   "zcat"     =>	$field,
						   "zcountry" =>	$country,
						   "zstate"   =>	$state,
						   "zcity"    =>	$city,
						   "zdate"    =>	$date,
						   "zcode"    =>    $code 
								   
					                    ));
						   if($stmt){  //redirect to send a verification email
						 	echo "<div class='block-green'>Trader inserted successfully </div>";
						  }else{
						  	echo "<div class='block2'>Ooops... Try again </div>";
						  } 

				 }
             

 

             //add credit to traders
            }elseif (isset($_POST['addCredit'])) {
            	$TrPhone =$_POST['creditTrPhone'];
				$amount  =$_POST['creditTrAmount']; 
				$filteredPhone   =filter_var(trim($TrPhone),FILTER_SANITIZE_NUMBER_INT);
				$filteredAmount  =filter_var(trim($amount),FILTER_SANITIZE_NUMBER_INT);
				if ($filteredPhone>0) {
					$fetchTr=fetch2('*','user','phone',$filteredPhone,'online_pay',1);
					 $fetchMax=fetch('max(item_mostafed)','items','user_id',$fetchTr['user_id']);
					if ($fetchTr['phone']>0) {
						if ($filteredAmount>0) {
                            if($fetchTr['online_pay']==1){ //trader must be online_pay=1
							  if(($fetchTr['cat_id']>=7&&$fetchTr['cat_id']<=9)&&$fetchTr['credit']<$fetchMax['max(item_mostafed)']) { //less credit
								//get current credit 
								$newCredit=$fetchTr['credit']+=$amount;
								//update user to insert credit
								$stmt=$conn->prepare(' UPDATE user set credit=?  where phone=? ');
								$stmt->execute(array($newCredit,$fetchTr['phone']));
								if ($stmt) {
									?><div class='block-green'>Amount inserted successfully for  <?php echo $fetchTr['commercial_name']?> </div><?php
									//send msg to inform trader
									$msg='تم زيادة رصيدكم بمقدار '.$amount.'ج.م. '.'رصيدكم الآن '.' '.$newCredit.'ج.م. ';
						              $date=time();
						              $stmt3=$conn->prepare(" INSERT into message 
						              (message_text,message_date,message_from,message_to) 
						              values(:ztxt,:zdate,7,:zto) ");
						               $stmt3->execute(array(
						               'ztxt'    => $msg,
						               'zdate'   => $date,
						               'zto'     => $fetchTr['user_id']
					                   ));
					                   if ($stmt3) {
							            	echo "<div class='block-green'>And Trader was sent a message</div>";
							            } 
								    //unhide trader items after increasing credit
							           $fetchTr2=fetch2('*','user','phone',$filteredPhone,'online_pay',1);
                                       $fetchMax2=fetch('max(item_mostafed)','items','user_id',$fetchTr2['user_id']);
	                                    if($fetchTr2['credit']>$fetchMax2['max(item_mostafed)']*3){
							              $stmt2=$conn->prepare(' UPDATE items set hide=0 where  user_id=?  ');
							              $stmt2->execute(array($fetchTr['user_id']));
							            }
							            
							            if ($stmt2) {
							            	echo "<div class='block-green'>And Items shown</div>";
							            	//send msg to say that items are shown
										  $msg2='تم ازالة الحجب عن اعلاناتكم ';
							              $date2=time();
							              $stmt4=$conn->prepare(" INSERT into message 
							              (message_text,message_date,message_from,message_to) 
							              values(:ztxt,:zdate,7,:zto) ");
							               $stmt4->execute(array(
							               'ztxt'    => $msg2,
							               'zdate'   => $date2,
							               'zto'     => $fetchTr['user_id']
						                   ));
							            }
								}else{ 
									echo "<div class='block2'>No amount added.. check connection then try again</div>";
								}
							  }elseif (($fetchTr['cat_id']<7||$fetchTr['cat_id']>9)&&$fetchTr['credit']<$fetchMax['max(item_mostafed)']*3) {
							  	 //get current credit
								$newCredit=$fetchTr['credit']+=$amount;
								//update user to insert credit
								$stmt=$conn->prepare(' UPDATE user set credit=?  where phone=? ');
								$stmt->execute(array($newCredit,$fetchTr['phone']));
								if ($stmt) {
									?><div class='block-green'>Amount inserted successfully for  <?php echo $fetchTr['commercial_name']?> </div><?php
									//send msg to inform trader
									$msg='تم زيادة رصيدكم بمقدار '.$amount.'ج.م. '.'رصيدكم الآن '.' '.$newCredit.'ج.م. ';
						              $date=time();
						              $stmt3=$conn->prepare(" INSERT into message 
						              (message_text,message_date,message_from,message_to) 
						              values(:ztxt,:zdate,7,:zto) ");
						               $stmt3->execute(array(
						               'ztxt'    => $msg,
						               'zdate'   => $date,
						               'zto'     => $fetchTr['user_id']
					                   ));
					                   if ($stmt3) {
							            	echo "<div class='block-green'>And Trader was sent a message</div>";
							            } 
								    //unhide trader items after increasing credit
							           $fetchTr2=fetch2('*','user','phone',$filteredPhone,'online_pay',1);
                                       $fetchMax2=fetch('max(item_mostafed)','items','user_id',$fetchTr2['user_id']);
	                                    if($fetchTr2['credit']>$fetchMax2['max(item_mostafed)']*3){
							              $stmt2=$conn->prepare(' UPDATE items set hide=0 where  user_id=?  ');
							              $stmt2->execute(array($fetchTr['user_id']));
							            }
							            
							            if ($stmt2) {
							            	echo "<div class='block-green'>And Items shown</div>";
							            	//send msg to say that items are shown
										  $msg2='تم ازالة الحجب عن اعلاناتكم ';
							              $date2=time();
							              $stmt4=$conn->prepare(" INSERT into message 
							              (message_text,message_date,message_from,message_to) 
							              values(:ztxt,:zdate,7,:zto) ");
							               $stmt4->execute(array(
							               'ztxt'    => $msg2,
							               'zdate'   => $date2,
							               'zto'     => $fetchTr['user_id']
						                   ));
							            }
								}else{
									echo "<div class='block2'>No amount added.. check connection then try again</div>";
								}
							 


							}else{ //trader has more credit than item_mostafed
                                //get current credit
							$newCredit=$fetchTr['credit']+=$amount;
							//update user to insert credit
							$stmt=$conn->prepare(' UPDATE user set credit=?  where phone=? ');
							$stmt->execute(array($newCredit,$fetchTr['phone']));
								if ($stmt) {
									?><div class='block-green'>Amount inserted successfully for  <?php echo $fetchTr['commercial_name']?> </div><?php
									//send msg to inform trader
									  $msg=' تم زيادة رصيدكم بمقدار '.$amount.'ج.م. '.'رصيدكم الآن '.' '.$newCredit.'ج.م. ';
						              $date=time();
						              $stmt3=$conn->prepare(" INSERT into message 
						              (message_text,message_date,message_from,message_to) 
						              values(:ztxt,:zdate,7,:zto) ");
						               $stmt3->execute(array(
						               'ztxt'    => $msg,
						               'zdate'   => $date,
						               'zto'     => $fetchTr['user_id']
					                   ));
					                   if ($stmt3) {
							            	echo "<div class='block-green'>And Trader was sent a message</div>";
							            } 
                                }
							  }	//end trader has more credit
							}else{ echo "<div class='block2'>You must change this trader to online_pay=1 before adding money </div>"; }
						
						}else{//no amount inserted
						  echo "<div class='block2'>Please Insert amount</div>";
						}
					}else{ //theres no trader= inserted phone is wrong
                      echo "<div class='block2'>Ooops.. We couldn't find trader </div>";
					}
				}else{ //no inserted phone
					 echo "<div class='block2'>Please Insert phone</div>";
					}




            /*Repairing quantity.. Dealing with reports , paying back after reducing quantity
             coming from => dash=reported*/
            }elseif (isset($_POST['order_id_Repair'])) {
            	$order_id=filter_var(trim($_POST['order_id_Repair']),FILTER_SANITIZE_NUMBER_INT);//order_id
            	$stmt=$conn->prepare(' SELECT num,num2,modefy,item_id from orders  where order_id=?');
				$stmt->execute(array($order_id));
				$payCut=$stmt->fetch();

				 $item_id1=$payCut['item_id'];//item_id
                 $item_id =fetch('item_mostafed','items','item_id',$item_id1);
                 $mostafed=$item_id['item_mostafed'];
				 $modefy=$payCut['modefy'];//Quantity modefication resolved or not
				 $num   =$payCut['num'];//quantity before
				 $num2  =$payCut['num2'];//quantity after

				if ($modefy==0) { //problem not resolved yet
				if ($num2>0) { //less quantity was reported
					if($num>1){ //Quantity is more than one in placed order
					if ($num2==1&&$num==3) { 
						$newMos=$mostafed;
						$returnThis=$mostafed*2;
					}elseif ($num2==2&&$num==3) {
						$newMos=$mostafed*2; 
						$returnThis=$mostafed; 
					}elseif ($num2==1&&$num==2) {
						$newMos=$mostafed; 
						$returnThis=$mostafed; 
					}
					  

					  $trader_id=fetch('trader_id','orders','order_id',$order_id);//trader_id
					  $credit=fetch('credit','user','user_id',$trader_id['trader_id']);//credit
                      $newCredit=($credit['credit']) + $returnThis;

					$stmt=$conn->prepare('UPDATE  orders  SET  order_mostafed=?,modefy=1  WHERE  order_id=? ');
		            $stmt->execute(array($newMos,$order_id));
		            if ($stmt) {
		            	?><div class="block-green">Quantity modefied for This order</div> <?php
		                $stmt1=$conn->prepare(' UPDATE user set credit=?  where user_id=? ');
                        $stmt1->execute(array($newCredit,$trader_id['trader_id']));
                        if ($stmt1) {
                        	?><div class="block-green">And credit increased for This order</div> <?php
                        }
		            }

                }else{ //(wrong)he didn't report at all
                	?><div class="block2"> This trader shouldn't report selling less quantity.. Only one order passed to him</div> <?php }
				}else{ //(wrong)he shouldn't report
					?><div class="block2"> This trader didn't report selling less Quantity</div> <?php
				}
             }else{ //END if resolved
                ?><div class="block2">STOP! Quantity for this order has already been modefied </div> <?php
             }

			    



       }//end elseif()




	}else{ //END $_SERVER['REQUEST_METHOD'] condition
          header('location:login.php');
          exit();
	      }



}else{ //END if isset(session)
      header('location:login.php');
      exit();
	 }




include $tmpl."footer.inc";   
ob_end_flush();