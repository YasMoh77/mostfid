<?php
ob_start();
session_start();//important in every php page
$title='Members';     //title
include 'init.php';   

if (isset($_SESSION['idMos'])) { //check presence of session

					 //store the data brought by $_GET 
			$do=isset($_GET['do'])?$_GET['do']:'manage';  
			    //email users
			    $countEUsers=countFromDb2('user_id','user','came_from=',1);
			    //social users
			    $stmt=$conn->prepare(' SELECT count(user_id) from user where came_from>1 ');
			    $stmt->execute();$countSUsers=$stmt->fetchColumn();
			    //count no-password traders who need sms(null)
			    $stmt=$conn->prepare(' SELECT count(user_id) from user where trader =1 and password is null');
			    $stmt->execute();$count_Null_traders=$stmt->fetchColumn();
			    //count traders
			    $stmt=$conn->prepare(' SELECT count(user_id) from user where trader =1 and password is not null');
			    $stmt->execute();$count_traders=$stmt->fetchColumn();
             ?>
             <p>In this page=>Items get hidden if credit is less than max(item_mostafed) & online pay=1 (is validated)</p>
             <div class="center members-top">
				<a href="members.php?do=manage">Email Users<?php echo '('.$countEUsers.')'; ?></a>
				<a href="members.php?do=social">Social Media Users<?php echo '('.$countSUsers.')'; ?></a>
				<a href="members.php?do=null">NULL Traders,Need SMS<?php echo '('.$count_Null_traders.')'; ?></a>
				<a href="members.php?do=trader">Traders,Need SMS if activate=x<?php echo '('.$count_traders.')'; ?></a>
		    </div>

		    <!--***** block / unblock users ******-->
		   <div class="members-top2 center">
			    <form  id="changeMStatus"> 
					<label>Change Users/Traders</label>
					<select name="change">
						<option value="0">Choose</option>
						<option value="1">Block</option>
						<option value="2">Unblock</option>
						<option value="3">Activate</option>
						<option value="4">Deactivate</option>
						<option value="5">Hide products</option>
						<option value="6">Unhide products</option>
						<option value="7">Validate Online Pay ✓</option>
						<option value="8">Cancel Online Pay ⨯</option>
						<option value="9">Make Admin</option>
						<option value="10">Return to user</option>
						<option value="11">DELETE Member</option>
					</select> 
					<input type="text" name="userTrader" placeholder="UserID/Phone number" autocomplete="off">
				   <button class="button-all" id="signUp-btn" type="submit">ok</button>
				</form> 
				<!--***** update users ******-->
			    <form   id="updateMData"> 
					<label class="green">UPDATE Users/Traders SET</label>
					<select name="update">
						<option value="0">Choose</option>
						<option value="1">name</option>
						<option value="2">commercial_name</option>
						<option value="3">address</option>
						<option value="4">phone</option>
					</select>
					=
					<input type="text" name="newData" placeholder="Insert new data">
					WHERE 
					<input type="text" name="idPhone" placeholder="UserID/Phone number" autocomplete="off">
				   <button class="button-all" id="signUp-btn" type="submit">ok</button>
				</form>



				<form   id="lowCreditF">
					<span>Send group message to traders with short credit (Their items are hidden, to remind them to charge credit)</span>
					<input type="hidden" name="lowCredit">
					<button class="button-all" id="signUp-btn" type="submit">Send</button>
				</form>
				<button id="refresh">REFRESH PAGE</button>
				<div class="showForm center"></div>   
          </div>
			<br>
			<form class="center getMem" >
				<span>Find this member</span>
				<input type="text" name="getMem" placeholder="show a member / insert phone"> 
				<button>ok</button> <button id="refresh">REFRESH</button>
			</form>
			<span class="showMem"></span>
			<!--***** END block / unblock users action="processAdmin2.php" method="POST"******-->
			<!--ajax coner -->
		       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
		       <script>
		       $(document).ready(function(){
		         $("#changeMStatus").on("submit", function(e){
		          e.preventDefault();  
		          $.ajax({
		          url:"processAdmin2.php", 
		          method:"POST",
		          beforeSend:function(){
		            $('#changeMStatus> #signUp-btn').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
		            $('#changeMStatus> #signUp-btn').addClass('disabled',true);
		          },
		          processData:false,
		          contentType:false,
		          data:new FormData(this),
		          success: function(data){                             
		            $(".showForm").html(data);
		             },
		          complete:function(){
		         	$('#changeMStatus> #signUp-btn').removeClass('disabled',true);
		            $('.spinner-border').remove();
		           }
		           });
		        });
		        //updata members data
		        $("#updateMData").on("submit", function(e){
		          e.preventDefault();
		          $.ajax({
		          url:"processAdmin2.php", 
		          method:"POST",
		          beforeSend:function(){
		            $('#updateMData> #signUp-btn').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
		            $('#updateMData> #signUp-btn').addClass('disabled',true);
		          },
		          processData:false,
		          contentType:false,
		          data:new FormData(this),
		          success: function(data){                             
		            $(".showForm").html(data);
		             },
		          complete:function(){
		         	$('#updateMData> #signUp-btn').removeClass('disabled',true);
		            $('.spinner-border').remove();
		           }
		           });
		        });
		        //updata members data 
		        $("#lowCreditF").on("submit", function(e){ 
		          e.preventDefault();
		          $.ajax({
		          url:"processAdmin2.php", 
		          method:"POST",
		          beforeSend:function(){
		            $('#lowCreditF> #signUp-btn').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
		            $('#lowCreditF> #signUp-btn').addClass('disabled',true);
		          },
		          processData:false,
		          contentType:false,
		          data:new FormData(this),
		          success: function(data){                             
		            $(".showForm").html(data);
		             },
		          complete:function(){
		         	$('#lowCreditF> #signUp-btn').removeClass('disabled',true);
		            $('.spinner-border').remove();
		           }
		           });
		        });
		        //get member
		        $(".getMem").on("submit", function(e){ 
		          e.preventDefault();
		          $.ajax({
		          url:"processAdmin2.php", 
		          method:"POST",
		          beforeSend:function(){
		            $('.getMem> button').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
		            $('.getMem> button').addClass('disabled',true);
		          },
		          processData:false,
		          contentType:false,
		          data:new FormData(this),
		          success: function(data){                             
		            $(".showMem").html(data);
		             },
		          complete:function(){
		         	$('.getMem> button').removeClass('disabled',true);
		            $('.spinner-border').remove();
		           }
		           });
		        });




		         });
		     </script> 
			<?php




									         
			if ($do=='manage') {
				
				?>
				<h1 class="h1Manage"> Email Users</h1>
				<div class="container unconfirmedTr">
					<div class="table-container">
					<table class="table-manage-members">
						<span class="alone small">Automatically activated through emails sent by PHP MAILER</span>
						<p><span class="blue">Block</span>=>Can't place orders/<span class="blue">Activate</span>=>Email verified & can sign in/<span>Were reported</span>=>Traders reported them/<span>They reported</span>=>They reported traders</p> 
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
								<td><a href=""> Activate </a> </td>
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
						  WHERE came_from =1  order by user_id desc ");
						$stmt->execute();
						$fetched=$stmt->fetchAll();

						foreach ($fetched as  $value) { //foreach start
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
                            //program_credit
                            $fetchCredit=fetch('program_credit','orders','user_id',$value['user_id']);
							
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
							echo "<td class='td4'>"; if($value['activate']==1){ ?><i class="fas fa-check green"></i> <?php }else{ ?><i class="fas fa-times red"></i> <?php } echo "</td>";
							echo "<td class='td4'>".$value['program']. "</td>";/////
							echo "<td class='td4'>";if($fetchCredit['program_credit']>0){ echo $fetchCredit['program_credit']; } echo "</td>";////
							echo "<td class='td4'>"; if($value['group_id']==1){ echo "Admin";}elseif($value['group_id']==2){ echo "SuperAdmin";} "</td>";
							if($_SESSION['idMos']==7){echo "<td class='td4'>".$value['code']. "</td>";}
							echo "<td >"; 
								if($_SESSION['idMos']==7){   //exclusive for the super admin
								     echo "<a href='members.php?do=edit&id=" . $value['user_id']."' class='btn btn-success'> Edit </a> ";//edit 
								    }								
							     "</td>";  
							echo "</tr>";						
						}//foreach end

					?> </tbody>						  										 				
					</table>
					</div>					
                </div>

                <!--ajax coner -->
       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
	               //ajax call 
	               $("").on("change", function(){
	              var Promote=$(this).val();
	                  if ($(this).val()>0){
		              $.ajax({
		              url:"promote.php",
		              data:{promote:Promote},
		              success: function(data){                             
		                $('.').html(data);
		                 }
		               });
	               }
	             });
	              





		     });
		    </script>			
			<?php

			}elseif($do=='social'){
				/////////
				/* $mor='';
				 if (isset($_GET['more']) && $_GET['more']=='pending' ) { 
				 	$mor=' and  regstatus = 0 ';
				 }*/

				$stmt=$conn->prepare("SELECT *  FROM  user 
				  WHERE came_from >1  order by user_id desc ");
				$stmt->execute();
				$fetched=$stmt->fetchAll();

				?>
				<h1 class="h1Manage"> Social Media Users</h1>
				<div class="container unconfirmedTr">
					<div class="table-container">
					<table class="table-manage-members">
						<span class="alone small">Already activated through Google</span>
						<p><span class="blue">Block</span>=>Can't place orders/<span class="blue">Activate</span>=>Allowed to sign in(well-behaved)/<span>Were reported</span>=>Traders reported them/<span>They reported</span>=>They reported traders</p> 
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
								<td><a href=""> Activate </a> </td>
								<td><a href=""> Program </a> </td>
								<td><a href=""> Program Credit </a> </td>
								<td><a href=""> Group Id </a> </td>
								<td><a href=""> Came From </a> </td>
								<td><a class='actionTd-mem' href=""> action </a> </td>
						    </tr>
						</thead>
						<tbody>
						<?php
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
                            //program_credit
                            $fetchCredit=fetch('program_credit','orders','user_id',$value['user_id']);
						    echo "<tr class='tr-members'>";
							echo "<td>".$value['user_id']  ."</td>";
							echo "<td class='td2'>".$value['name'] ."</td>";
							echo "<td class='td3'>".$value['email']    ."</td>";
							echo "<td>"; if($value['phone']>0){ echo '0'.$value['phone'];}else{ echo $value['phone'];} echo "</td>";
							echo "<td>"; if(isset($value['country_id'])&& $value['country_id']>0){echo getCountry($value['country_id']);}else{echo 'Social Media User';} echo "</td>";
							echo "<td>"; if(isset($value['state_id'])&& $value['state_id']>0){echo getState($value['state_id']);}else{echo 'Social Media User';} echo "</td>";
							echo "<td>"; if(isset($value['city_id'])&& $value['city_id']>0){echo getCity($value['city_id']) ;}else{echo 'Social Media User';} echo "</td>";
							echo "<td class='td4'>".$value['reg_date']. "</td>";
							echo "<td class='td4'>".$all_orders. "</td>";
							echo "<td class='td4'>".$appr_orders. "</td>";
							echo "<td class='td4'>".$pend_orders. "</td>";
							echo "<td class='td4'>".$were_reported. "</td>";
							echo "<td class='td4'>".$they_reported. "</td>";
							echo "<td class='td4'>";if($value['block']==1){ echo "<span class='red'>Yes</span>";} echo "</td>";
							echo "<td class='td4'>"; if($value['activate']==1){ ?><i class="fas fa-check green"></i> <?php }else{ ?><i class="fas fa-times red"></i> <?php } echo "</td>";
							echo "<td class='td4'>".$value['program']. "</td>";/////
							echo "<td class='td4'>";if($fetchCredit['program_credit']>0){ echo $fetchCredit['program_credit']; } echo "</td>";////
							echo "<td class='td4'>"; if($value['group_id']==1){ echo "Admin";}elseif($value['group_id']==2){ echo "SuperAdmin";} "</td>";
							echo "<td class='td4'>";
							     if($value['came_from']==2){echo "Google";}elseif($value['came_from']==3){echo "FB";}  
							echo "</td>";
							echo "<td >";
								if($_SESSION['idMos']==7){  //exclusive for the super admin
							         echo '&emsp;<input type="checkbox" name="check" value="'.$value["user_id"].'">&emsp;';
								     echo "<a href='members.php?do=edit&id=" . $value['user_id']."' class='btn btn-success'> Edit </a> ";//edit 
								    }								
							     "</td>";  
							echo "</tr>";		
							} ?>
						</tbody>						  										 				
					</table>
					</div>						
                </div>
                <?php


				/////////
			}elseif ($do=='null') {
				
				$stmt=$conn->prepare("SELECT *  FROM  user 
				  WHERE trader=1 and password is null  order by user_id desc ");
				$stmt->execute();
				$fetched=$stmt->fetchAll();
				?>
				<h1 class="h1Manage"> NULL Traders</h1>
				<div class="container unconfirmedTr">  
					<!-- traders with (short data, activate=0) -->
					<div class="table-container">
						<span>Number of NULL-Password Traders:<?php echo '('.$count_Null_traders.')'; ?></span>
						<p>Traders with (NULL password) => <span>Send them Temporary Password(Code) so that they can add permanent one</span></p>
					<table class="table-manage-members">
						<thead>
							<tr>
								<td><a href=""> ID </a> </td>
								<td><a href=""> name </a> </td>
								<td><a href=""> Commercial Name </a> </td>
								<td><a href=""> Address </a> </td>
								<td><a href=""> Phone </a> </td>
								<td><a href=""> Online Pay </a> </td>
								<td><a href=""> Country </a> </td>
								<td><a href=""> State </a> </td>
								<td><a href=""> City </a> </td>
								<td><a href=""> Register date </a> </td>
								<td><a href=""> Block </a> </td>
								<td><a href=""> Activate </a> </td>
								<td><a href=""> Program </a> </td>
								<td><a href=""> Group Id </a> </td>
								<td><a href=""> Temp. Password<br>/Code </a> </td>
								<td><a class='actionTd-mem' href=""> action </a> </td>
						    </tr>
						</thead>
						<tbody>
						<?php
						foreach ($fetched as  $value) {//foreach start
							
						    echo "<tr class='tr-members'>";
							echo "<td>".$value['user_id']  ."</td>";
							echo "<td class='td2'>".$value['name'] ."</td>";
							echo "<td class='td3'>".$value['commercial_name']    ."</td>";
							echo "<td class='td3'>".$value['address']    ."</td>";
							echo "<td>"; if($value['phone']>0){ echo '0'.$value['phone'];} echo "</td>";
							echo "<td class='td2'>";if($value['online_pay']==1){ echo "<i class='fas fa-check green'></i>";}else{ echo "<i class='fas fa-times red'></i>";} echo"</td>";
							echo "<td>"; if(isset($value['country_id'])&& $value['country_id']>0){echo getCountry($value['country_id']);}else{echo 'Short Data';} echo "</td>";
							echo "<td>". getState($value['state_id'])."</td>";
							echo "<td>". getCity($value['city_id'])."</td>";
							echo "<td class='td4'>".$value['reg_date']. "</td>";
							echo "<td class='td4'>";if($value['block']==1){ echo "<span class='red'>Yes</span>";} echo "</td>";
							echo "<td class='td4'>"; if($value['activate']==1){ ?><i class="fas fa-check green"></i> <?php }else{ ?><i class="fas fa-times red"></i> <?php } echo "</td>";
							echo "<td class='td4'>".$value['program']. "</td>";/////
							echo "<td class='td4'>"; if($value['group_id']==1){ echo "Admin";}elseif($value['group_id']==2){ echo "SuperAdmin";} "</td>";
							if($_SESSION['idMos']==7){ echo "<td class='td4'>".$value['code']. "</td>"; }
 
							echo "<td >";
								if($_SESSION['idMos']==7){  //exclusive for the super admin
							         echo '&emsp;<input type="checkbox" name="check" value="'.$value["user_id"].'">&emsp;';
								     echo "<a href='members.php?do=edit&id=" . $value['user_id']."' class='btn btn-success'> Edit </a> ";//edit 
								    }								
							     "</td>";  
							echo "</tr>";		
							} ?>
						</tbody>						  										 				
					</table>
					</div>
                </div>

                <?php
			

			}elseif ($do=='trader') {
				$stmt=$conn->prepare("SELECT *  FROM  user
				  join categories on  categories.cat_id=user.cat_id
				  WHERE user.trader=1 and password is not null  order by user.user_id desc ");
				$stmt->execute();
				$fetched=$stmt->fetchAll();  
				  
				?>
				<h1 class="h1Manage"> Traders</h1>
				<div class="container unconfirmedTr">
					<div class="table-container "> 
					<table class="table-manage-members">
                       <p><span class="blue">Block</span>=>Can't place orders<span class="blue">&emsp;Activate</span>=>Phone verified & can sign in<span>&emsp;Deactivate(Banned)=> can't sign in</span></p>
						<thead>
							<tr>
								<td><a href=""> ID </a> </td>
								<td><a href=""> name </a> </td>
								<td><a href=""> Commercial Name </a> </td>
								<td><a href=""> Address </a> </td>
								<td><a href=""> Field  </a> </td>
								<td><a href=""> Phone </a> </td>
								<td><a href=""> Country </a> </td>
								<td><a href=""> State </a> </td>
								<td><a href=""> City </a> </td>
								<td><a href=""> Field </a> </td>
								<td><a href=""> Online Pay </a> </td>
								<td><a href=""> Credit </a> </td>
								<td><a href=""> Max(item_mostafed)*3 </a> </td> 
								<td><a href=""> No. Items </a> </td>
								<td><a href=""> Approved Items </a> </td>
								<td><a href=""> Pending Items </a> </td>
								<td><a href=""> Shown Items </a> </td>
								<td><a href=""> Hidden Items</a> </td>
								<td><a href=""> Register date </a> </td>
								<td><a href=""> Block </a> </td>
								<td><a href=""> Program </a> </td>
								<td><a href=""> Program Credit </a> </td>
								<td><a href=""> Group Id </a> </td>
								<td><a href=""> Need SMS/Ok,Banned </a><br>(Activate=0,1,2) </td>
								<td><a href=""> Code </a> </td>
								<td><a class='actionTd-mem' href=""> action </a> </td>
						    </tr>
						</thead>
						<tbody> 
						<?php
						foreach ($fetched as  $value) {//foreach start
							/////////////// 
							//get max value for item mostafed to check if trader has enough credit for paying online
							$stmt=$conn->prepare("SELECT max(item_mostafed),user.online_pay FROM  items
							  join user on  items.user_id=user.user_id WHERE user.user_id=? and user.online_pay=1 ");
							$stmt->execute(array($value['user_id']));
							$fetchMax=$stmt->fetch();
							//hide items if credit is less than max(item_mostafed) for online pay traders only
							if($value['online_pay']==1){
								if($value['cat_id']>=7&&$value['cat_id']<=9){ //field 7,8,9
                                    if($value['credit']<$fetchMax['max(item_mostafed)']){
									$stmt=$conn->prepare(' UPDATE items set hide=1 where  user_id=?  ');
			                        $stmt->execute(array($value['user_id']));
								    }
								}else{
									if($value['credit']<$fetchMax['max(item_mostafed)']*3){
									$stmt=$conn->prepare(' UPDATE items set hide=1 where  user_id=?  ');
			                        $stmt->execute(array($value['user_id']));
								   }
								}
						    }
							///////////// 
						   $user_items=countFromDb2('item_id','items','user_id=',$value['user_id']); 
						   $shown_items=countFromDb3('hide','items','user_id=',$value['user_id'],'hide',0); 
						   $hidden_items=countFromDb3('hide','items','user_id=',$value['user_id'],'hide',1); 
						   $approved_items=countFromDb3('item_id','items','approve >',0,'user_id',$value['user_id']); 
						   $pending_items=countFromDb3('item_id','items','user_id=',$value['user_id'],'approve',0); 
						   $fetchCredit=fetch('program_credit','orders','trader_id',$value['user_id']);
						   
						    echo "<tr class='tr-members'>";
							echo "<td>".$value['user_id']  ."</td>";
							echo "<td class='td2'>".$value['name'] ."</td>"; 
							echo "<td class='td3'>".$value['commercial_name']    ."</td>";
							echo "<td class='td3'>".$value['address']    ."</td>";
							echo "<td class='td3'>".$value['cat_nameAR']."</td>";
							echo "<td>"; if($value['phone']>0){ echo '0'.$value['phone'];} echo "</td>";
							echo "<td>"; if(isset($value['country_id'])&& $value['country_id']>0){echo getCountry($value['country_id']);}else{echo 'Short Data';} echo "</td>";
							echo "<td>"; if(isset($value['state_id'])&& $value['state_id']>0){echo getState($value['state_id']);}else{echo 'Short Data';} echo "</td>";
							echo "<td>"; if(isset($value['city_id'])&& $value['city_id']>0){echo getCity($value['city_id']);}else{echo 'Short Data';} echo "</td>";
							echo "<td class='td3'>". getCat($value['cat_id'])."</td>";
							echo "<td class='td4'>";if($value['online_pay']==1){ echo "<i class='fas fa-check green'></i>";}else{ echo "<i class='fas fa-times red'></i>";} echo"</td>";
							echo "<td class='td3'>"; 
							//////////////////
							if($value['online_pay']==1){ 
								if($value['cat_id']>=7&&$value['cat_id']<=9){ //field is 7,8,9 
									if($value['credit']<$fetchMax['max(item_mostafed)']){ echo '<span class="red">'.number_format($value['credit'],2,'.',',').'</span>';
								    }else{ echo number_format($value['credit'],2,'.',','); } 
								}else{ //field is not 7 or 8
									if($value['credit']<$fetchMax['max(item_mostafed)']*3){ echo '<span class="red">'.number_format($value['credit'],2,'.',',').'</span>';
									}else{ echo number_format($value['credit'],2,'.',','); } 
								} 
							}else{ ?><span class="red">Manual</span> <?php } 
							/////////////////
							echo"</td>";
							echo "<td class='td3'>";
							if ($value['cat_id']>=7&&$value['cat_id']<=9){ echo number_format(($fetchMax['max(item_mostafed)']),2,'.',',');}else{ echo number_format(($fetchMax['max(item_mostafed)']*3),2,'.',','); }
							echo "</td>";
							echo "<td class='td4'>";if($user_items>0){ echo '<span class="colorspan">'.$user_items.'</span>';} echo"</td>";
							echo "<td class='td4'>";if($approved_items>0){ echo '<p class="green">'.$approved_items.'</p>';} echo"</td>";
							echo "<td class='td4'>";if($pending_items>0){ echo '<p class="red">'.$pending_items.'</p>';} echo"</td>";
							echo "<td class='td4'>";if($shown_items>0){ echo '<p class="green">'.$shown_items.'</p>';} echo"</td>";
							echo "<td class='td4'>";if($hidden_items>0){ echo '<p class="red">'.$hidden_items.'</p>';} echo"</td>";  
							echo "<td class='td4'>".$value['reg_date']. "</td>";
							echo "<td class='td4'>";if($value['block']==1){ echo "<span class='red'>Yes</span>";} echo "</td>";
							echo "<td class='td4'>".$value['program']. "</td>";/////
							echo "<td class='td4'>";if($fetchCredit['program_credit']>0){ echo $fetchCredit['program_credit']; } echo "</td>";////
							echo "<td class='td4'>"; if($value['group_id']==1){ echo "Admin";}elseif($value['group_id']==2){ echo "SuperAdmin";} "</td>";
							echo "<td class='td4'>"; if($value['activate']==1){ ?><span class="green">ok</span> <?php }elseif($value['activate']==2){ ?><span class="red">Banned</span> <?php }else{ ?><span class="red">Need SMS</span> <?php } echo "</td>";
							if($_SESSION['idMos']==7){ echo "<td class='td4'>";if($value['activate']==0){ echo '<span class="red">'.$value['code'].'</span>';}else{ echo '<span>'.$value['code'].'</span>';} echo"</td>"; }
							
							echo "<td >";
								if($_SESSION['idMos']==7){  //exclusive for the super admin
							         echo '&emsp;<input type="checkbox" name="check" value="'.$value["user_id"].'">&emsp;';
								     echo "<a href='members.php?do=edit&id=" . $value['user_id']."' class='btn btn-success'> Edit </a> ";//edit 
								    }								
							     "</td>";  
							echo "</tr>";		
							} ?>
						</tbody>						  										 				
					</table>
					</div>						
                </div>
                <?php
			 

			 
			}elseif ($do=='edit') {   
			             //check user_id
						  $USERID=isset($_GET['id']) && is_numeric($_GET['id'])?intval($_GET['id']):0;
                          if ($USERID>0) {
						    //checking if user exists in database
                       $fetch=fetch('city_id','user','user_id',$USERID);
                       //  if ($fetch['city_id']==null) {
                         	
                 // }else{
				  $stmt=$conn->prepare("SELECT 
					user.*,country.*, state.*,city.* FROM user
					join categories on user.cat_id=categories.cat_id
					join country on user.country_id=country.country_id
					join state on user.state_id=state.state_id
					join city on user.city_id=city.city_id
					WHERE
					user.user_id=? ");
			  	  $stmt->execute(array($USERID));
				  $fetched=$stmt->fetch();
				  $count=$stmt->rowCount();
                  //echo $fetched['group_id'];

				   if ($count>0) {
						//if condition is true, show form
				        ?>
				        <div class="con-member-data">
				            <h1 class="edit-h1">  Member data </h1>
				            <input type="hidden" name="user_id"  value="<?php echo $USERID  ?> " > 


				            <label for="inputEmail3" class="col-sm-2  col-form-label-edit">Type of User</label>
					        <div class="div-eidt-page  form-control"> 
					        <input type="text" class="form-control-edit" id="inputEmail3" 	name="type"  placeholder="<?php if($fetched['trader']==1){echo 'Trader';}else{echo 'Email User';}?>" disabled > 
				            </div>
	 

				  	        <label for="inputEmail3" class="col-sm-2  col-form-label-edit">Username</label>
					        <div class="div-eidt-page  form-control"> 
					        <input type="text" class="form-control-edit" id="inputEmail3" 	name="newUsername"  placeholder="<?php echo $fetched['name']?>" disabled > 
				            </div>


                            <?php
                            if($fetched['trader']==0){ ?>
						    <label for="inputEmail3" class="col-sm-2  col-form-label-edit">Email</label>
				            <div class="div-eidt-page  form-control">        
				            <input type="email" class="form-control-edit" id="inputEmail3" name='newEmail' placeholder="<?php echo $fetched['email'] ?>" disabled >
					        </div>	
					        <?php  }else{ ?>
					        <label for="inputEmail3" class="col-sm-2  col-form-label-edit">Commercial Name</label>
					        <div class="div-eidt-page  form-control"> 
					        <input type="text" class="form-control-edit" id="inputEmail3" 	name="commercial_name"  placeholder="<?php echo $fetched['commercial_name']?>" disabled > 
				            </div>


				            <label for="inputEmail3" class="col-sm-2  col-form-label-edit">Field </label>
					        <div class="div-eidt-page  form-control"> 
					        <input type="text" class="form-control-edit" id="inputEmail3" 	name="field"  placeholder="<?php echo getCat($fetched['cat_id'],$l);?>" disabled > 
				            </div>

					     <?php   } ?>	  
	                         

						    <label for="inputEmail3" class="col-sm-2  col-form-label-edit">phone</label>
						    <div class="div-eidt-page  form-control">
					        <input type="text" class="form-control-edit" id="inputEmail3" name='newPhone'  placeholder="<?php echo '0'.$fetched['phone'] ?>" disabled>
					        </div>
						     

						    <label for="inputEmail3" class="col-sm-2 col-form-label-edit">country</label>
							<div class="div-eidt-page  form-control">
							<input type="text" class="form-control-edit" id="inputEmail3" name='newCountry' placeholder="<?php echo $fetched['country_nameAR'] ?>" disabled>
					        </div>

					        <label for="inputEmail3" class="col-sm-2 col-form-label-edit">state</label>
							<div class="div-eidt-page  form-control">
						    <input type="text" class="form-control-edit" id="inputEmail3" name='newState' placeholder="<?php echo $fetched['state_nameAR'] ?>" disabled>
					        </div>

					        <label for="inputEmail3" class="col-sm-2 col-form-label-edit">city</label>
							<div class="div-eidt-page  form-control">
						    <input type="text" class="form-control-edit" id="inputEmail3" name='newCity'  placeholder="<?php echo $fetched['city_nameAR']?>" disabled>
					        </div>

					        <label for="inputEmail3" class="col-sm-2 col-form-label-edit">Registry date</label>
							<div class="div-eidt-page  form-control">
						    <input type="text" class="form-control-edit" id="inputEmail3" name='newCity'  placeholder="<?php echo $fetched['reg_date']?>" disabled>
					        </div>

					        <label for="inputEmail3" class="col-sm-2 col-form-label-edit">Code</label>
							<div class="div-eidt-page  form-control">
						    <input type="text" class="form-control-edit" id="inputEmail3" name='code'  placeholder="<?php echo $fetched['code']?>" disabled>
					        </div>
				        </div>

				        <?php
								
				  }else{
					 $redirectHomeMsg="You aren't allowed here";
					redirectHome($redirectHomeMsg);
					}
				 // } //END else
				} // END if($USERID>0)
			    /////////edit finished


			}                   
						


//End 
include $tmpl ."footer.inc";
//or take him back to login page
}else{
	header('location:index.php');
}

ob_end_flush();
?>






