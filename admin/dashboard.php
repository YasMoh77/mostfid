<?php

session_start();//important in every php page
date_default_timezone_set('Africa/Cairo');
if (isset($_SESSION['idMos'])) {
	//start work after registering a session
$title='dashboard';
include 'init.php'; 
$l=$lang['lang'];  

/*$dash=isset($_GET['dash'])?$_GET['dash']:'none';
if ($dash=='none') {*/
	//main dashboard
 $numUsers=10;//latest users
 $numItems=10;//latest users 
 $numComms=10;
 $latestUsers=theLatest("*","user","user_id",$numUsers);//latest users function
 $latestItems=theLatest("*","items","item_id",$numItems);//latest users function 
 $latestComments=theLatest("*","comments","c_id",$numComms);//latest comments function 
 $latestComments2=theLatest2($numComms);//latest comments function 

?>
<!--start dashboard-->
<h1 class="h1-dashboard">Dashboard</h1>
<div class="flex-cont-dash ">
	<div class="list">
		<a href="dashboard.php" class="home">Home</a> 
		<a href="dashboard.php?dash=orders" class="messages">Orders</a>
		<a href="dashboard.php?dash=mostafed" class="messages">Mostafed <span class="small red">(Profit)</span></a>
		<a href="dashboard.php?dash=reported" class="reported">Reported</a>
		<a href="dashboard.php?dash=add" class="">Add </a>
		<a href="dashboard.php?dash=latest" class="latest">Latest</a>
		<a href="comments.php" class="messages">Comments</a>
		<a href="members.php" class="messages">Members</a>
		<a href="dashboard.php?dash=program" class="messages">Program</a>
		<a href="dashboard.php?dash=reviews" class="replies"> Reviews</a>
		<a href="dashboard.php?dash=messages" class="messages">Messages</a>
		<!--<a href="dashboard.php?dash=countries" class="replies">Countries & states</a>
		<a href="dashboard.php?dash=cities" class="replies">Cities</a>
		<a href="dashboard.php?dash=sales" class="replies">Sales</a>-->
		<a href="dashboard.php?dash=remarks" class="replies">Remarks</a>
	    <a  href="logout.php">Log out</a>
	</div>

	<?php
	$dash=isset($_GET['dash'])?$_GET['dash']:'main';
	if ($dash=='main') { ?>

	<div class="containerDash ">
			<div class="flex-container1">		
					<div> <!--   show email users   -->
						 <a class='a-users'  href="members.php?do=manage"><i class="fas fa-users"></i>
						 <span class="span-show-num"><?php echo countFromDb3("user_id","user",'came_from=',1,'trader',0)?></span>
						 <p>Email Users</p></a>

					</div>   
					
					<div>   <!--   show Social Media  users   -->
						<a class='a-users' href="members.php?do=social"><i class="fas fa-users"></i>
						<span class="span-show-num"><?php echo countFromDb3("user_id","user",'came_from>',1,'trader',0)?></span>
						<p>Social Media Users</p></a>
					</div>

					<div>   <!--   unconfirmed traders   -->
						<a class='a-users' href="members.php?do=null"><i class="fas fa-users"></i> 
						<span class="span-show-num"><?php echo countFromDb3("user_id","user",'password','is null','trader',1)?></span>
						<p>NULL Traders</p></a>
					</div>

					<div>   <!--   traders   -->
						<a class='a-users' href="members.php?do=trader"><i class="fas fa-users"></i>
						<span class="span-show-num"><?php echo countFromDb3("user_id","user",'password','is not null','trader',1)?></span>
						<p>Traders</p></a>
					</div>
					
					<div>    <!--   show Items   -->
						<a class='a-users' href="items.php"><i class="fas fa-tags"></i>
		                <span class="span-show-num"><?php echo countFromDb("item_id","items")?></span>
		                <p>Items</p></a>
					</div>
					<div>  <!--   show comments   -->
						<a class='a-users' href="comments.php"><i class="fas fa-comments"></i>
						<span class="span-show-num"><?php echo countFromDb("c_id","comments")?></span>
						<p>Comments</p></a>
					</div> 
			</div>
			
		     <!-- page views -->
		     <span class="page_views_span">SearchK=Reaching search page through links<br>
		     SearchAside= Reaching search page through side bar</span>
			<div class="page-views-holder">
				<div class="head">
					<p>PAGE VIEWS</p>
				</div>
				<div class="body">
					<?php
					$stmt=$conn->prepare(' SELECT * from page_views order by value desc');
					$stmt->execute();
		            $views=$stmt->fetchAll();
		            foreach ($views as $view) {
		            	?> <span><?php echo $view['page_name'].' ( '.$view['value'].' )'; ?></span> <?php
		            } ?>
					
				</div>
		    </div>
	</div> <?php

    

}elseif ($dash=='latest') { ?>
	<!--latest-->
	<div  class="containerDash2">
		<span class="containerDash-heading">Latest users & items</span>
		<div class="div-down-container">
				     <!--div for users-->
					<div class="div-latest-user-container">	
						<span class="span-div-lable">
						  <img src="layout/images/newuserblue.png">latest				
						  <span class="span-red"><?php echo $numUsers;?></span> registered users
					    </span>
					<?php 
					foreach ($latestUsers as $user) {
					echo "<div class='comments-loop-container'>";
					echo '<div class="latest-list-user">';if($user['name']!=null){echo $user['name'];}else{echo "Unconfirmed";} echo '</div><span class="span-small">'.$user['reg_date'].'</span>';		
					echo '<div class="div-activate">
					      <a title="preview" href="members.php?do=edit&id='.$user['user_id'].'"> <i class="fas fa-eye"></i> </a>
					      </div>';
					echo "</div>";
					   }
					?>
				    </div>
				    <div class="div-latest-item-container">
				    	<span class="span-div-lable">
						<img src="layout/images/label.png">latest
						<span class="span-red"><?php echo $numItems;?></span> Items
					</span>	

				     <?php
				    	foreach ($latestItems as  $item) { ?>
				    		<div class='comments-loop-container3'>
				    			<div class='latest-list-item'>
				    				<?php echo $item['title'];?>
				    				<span class="span-small2"><?php echo $item['item_date'];?></span>
				    			</div>

				    			<?php
				    			if (isset($_SESSION['idMos']) && $_SESSION['idMos']==7){ ?>
				    			<button class="btn btn-success  btn-latest-success2">
				    			    <a href="items.php?do=edit&id=<?php echo $item['item_id']?>">EDIT</a>
				    		    </button>
				    		    <?php } 

				    		     if ($item['approve']==2) { ?>
				    			<button class="btn btn-info  btn-latest-info">
				    				<a class="confirmActivate" href="items.php?do=approve&id=<?php echo $item['item_id']?>" >EDITED</a>
				    			</button>
	                       <?php }elseif($item['approve']==0){ ?>
	                       	    <button class="btn btn-info  btn-latest-info"> 
				    				<a href="items.php?do=approve&id=<?php echo $item['item_id']?>" >Approve</a>
				    			</button>
	                      <?php  } ?>
				    		</div>
				        <?php  } ?>
				    </div>
			        
		       </div>
		       
			      <!-- Third pat for comments-->
			   <span class="containerDash-heading">Latest comments</span>
			   <div class="container2below" >
					     <!-- div for comments-->
						<div class="div-latest-comments">	
						<?php 
						foreach ($latestComments2 as $comm) {
						echo "<div class='comments-loop-container2'>";	
						echo '<div class="latest-list2">' .$comm['name'].'<span class="span-small">'.$comm['c_date'] .'</span></div>';
						echo '<div class="latest-list3"><span class="bold">' .$comm['title'].'</span><p class="span-comment">'.$comm['c_text'] .'</p></div>';							
							echo   '<div class="div-activate-comments">';
                                     if(isset($_SESSION['idMos']) && $_SESSION['idMos']==7){
									     echo '<button class="btn btn-success  ">
									       <a href="comments.php?do=edit&id='.$comm['c_id'].'"><i class="fas fa-edit"></i></a>
									     </button> 
									     <button class="btn btn-danger  ">
									         <a href="comments.php?do=delete&id='.$comm['c_id'].'"><i class="fas fa-trash-alt"></i>  </a>
									     </button>';
									    }
							      echo '</div>';
						echo "</div>";      
						 }													   
						?>
					    </div>
					    <!-- End div part 3 for comments-->					
		    	</div>
	       </div>


<?php }elseif ($dash=='program') { ?>
	 <div class="table-reponsive table-report review">
				<?php
				$No=1;
				$stmt=$conn->prepare(" SELECT * from user where program !=''  ");
				$stmt->execute();
	            $program=$stmt->fetchAll();
	            if (!empty($program)) { ?>
					<p class="containerDash-heading bold">Program </p>
				<span>Credit appears in RED ONLY when (paid=1 =>manual traders pay & online traders have credit which makes their items show up)</span>
				<!-- make zeron -->
				<form class="above" id="partnerZero">
					<p><span>Insert zero value for all partners down here as we paid them all their money.</span><button type="submit">Make Zero</button></p>
				</form>
				<table class="table-manage">
					<thead>
						<tr>
							<td><a href=""> No </a> </td>
							<td><a href=""> Partner's Name </a> </td>
							<td><a href=""> Partnership Code </a> </td>
							<td><a href=""> State </a> </td>
							<td><a href=""> City </a> </td>
							<td><a href=""> Credit </a> </td>
							<td><a href=""> Vodafone Cash </a> </td>
							<td><a href=""> Pay Now </a> </td>
						</tr>
					</thead>
				<tbody>
			            <?php  foreach ($program as $prog) { 
			            $fetchPartner=fetch('*','orders','prog2',$prog['program']);
			            //sum partner's values
			            $stmt3=$conn->prepare("SELECT sum(program_credit) FROM orders where prog2 !=''  and prog2 = ? and paid=1 ");
					 	$stmt3->execute(array($prog['program']));$sum=$stmt3->fetchColumn();
			          ?>
			          <tr>
						<td><?php echo $No; ?></td>
						<td class="cut2"><?php if($prog['trader']==1){ echo $prog['commercial_name'];}else{ echo $prog['name']; } ?></td>
						<td><?php echo $prog['program']?></td>
						<td><?php echo getState($prog['state_id'])?></td>
						<td><?php echo getCity($prog['city_id'])?></td>
						<td><?php if($sum>0){ echo '<span class="green">'.$sum.'</span>';}else{echo '<span class="red">No credit</span>';}?></td>
						<td><?php echo '0'.$prog['phone']?></td>
						<td><?php if($sum>0){ ?><a class="confirmAction" href="processAdmin.php?d=payPartner&i=<?php echo $prog['program'];?>">PAY</a> <?php } ?></td>
				      </tr>
				    <?php $No++; } } ?>
			</tbody>
		</table>
    </div><!--END class="table-reponsive" -->




<?php }elseif ($dash=='reported') { 
	  //report orders => unserious users
	  $stmt=$conn->prepare(' SELECT count(order_id) from orders where report =1 or num2>0 ');
	  $stmt->execute();
	  $R_Orders=$stmt->fetchColumn();
	  //report orders => bad traders
	  $stmt=$conn->prepare(' SELECT count(report_trader) from orders where report_trader =1');
	  $stmt->execute();
	  $R_Orders_T=$stmt->fetchColumn();
      //report items
	  $stmt=$conn->prepare(' SELECT count(value) from report where value is not null');
	  $stmt->execute();
	  $R_items=$stmt->fetchColumn();
      //all reported comments
	  $stmt=$conn->prepare(' SELECT count(value) from reportcomm ');
	  $stmt->execute();
	  $comAll=$stmt->fetchColumn();
      //active reported comments -> not updated to un report by reporters
	  $stmt=$conn->prepare(' SELECT count(value) from reportcomm where value=1 ');
	  $stmt->execute();
	  $comActive=$stmt->fetchColumn();
	  //cancelled reported comments -> updated to un report by reporters
	  $stmt=$conn->prepare(' SELECT count(value) from reportcomm where value=0 ');
	  $stmt->execute();
	  $comCancelled=$stmt->fetchColumn();
	  
	  

	//<!--reported--> 
	?>
	<div  class="containerDash3">
		<span class="containerDash-heading bold">Reported Buyers (Unserious Buyers) </span>
		<span class="green">All= (<?php echo $R_Orders; ?>)</span>
		<br>
		<span class="red">QB=</span>Quantity before meeting trader<br>
		<span class="red">QA=</span>Quantity after meeting trader
	    <form id="formRepair" class="center" action="posts.php" method="POST">
	    	<span class="red">Dealing with reports , paying back after reducing quantity</span>
	    	<p><span>Repair Quantity</span><input type="text" name="order_id_Repair" placeholder="Only Insert order_id"><button type="submit">Repair</button><button id="refresh">REFRESH</button></p>
           <span class="showForm"></span>
        </form>


		<div class="table-reponsive table-report">
						<?php
						$stmt=$conn->prepare(' SELECT * from orders 
						join items on items.item_id=orders.item_id
						join user on user.user_id=orders.user_id 
						join state on state.state_id=orders.state_id
						join city on city.city_id=orders.city_id 
						where orders.report=1 OR orders.num2>0 order by orders.order_id desc');
						$stmt->execute();
			            $orders=$stmt->fetchAll();  
			            if (!empty($orders)) { ?>
			            	
				<table class="table-manage unserious-buyers">
			    <thead>
					<tr>
						<td><a href=""> Item</a> </td>
						<td class="tr"><a href=""> Trader Name</a> </td>
						<td class="tr"><a href=""> Trader Phone </a> </td>
						<td class="tr"><a href=""> Trader State</a> </td>
						<td class="tr"><a href=""> Trader City </a> </td>
						<td><a href=""> Quantity (QB) </a> </td>
						<td><a href=""> Reason </a> </td>
						<td><a href=""> Buyer Name </a> </td>
						<td><a href=""> Buyer Phone </a> </td>
						<td><a href=""> Buyer State </a> </td>
						<td><a href=""> Buyer City </a> </td>
						<td><a href=""> Order ID</a> </td>
						<td><a href=""> Action </a> </td>
				    </tr>
				</thead>
				<tbody> <?php
					foreach ($orders as $order) { 
			            	$fetchTrID=fetch('trader_id','orders','order_id',$order['order_id']);
			            	$fetchTrData=fetch('*','user','user_id',$fetchTrID['trader_id']);
			                ?>
					<tr>  
						<td><a href="../details.php?id=<?php echo $order['item_id']?>&source=admin"><?php echo $order['title']?></a> </td> 
						<td class="tr"><?php echo $fetchTrData['commercial_name']?></td>
						<td class="tr"><?php echo '0'.$fetchTrData['phone']?></td>
						<td class="tr"><?php echo getState($fetchTrData['state_id'],$l)?></td>
						<td class="tr"><?php echo getCity($fetchTrData['city_id'],$l)?></td>
						<td><?php echo $order['num'];?></td>
						<td><?php if($order['report']==1){ echo "<span class='red'>لم يحضر للشراء  </span>";}elseif($order['num2']>0){ echo "<span class='red'>QA= </span>".$order['num2'];}?></td>
						<td><?php echo $order['buyer_name']?></td>
						<td><?php echo '0'.$order['buyer_phone']?></td>
						<td><?php echo $order['state_nameAR']?></td>
						<td><?php echo $order['city_nameAR']?></td>
						<td class=""><?php echo $order['order_id']?></td>
						<td><?php if($order['report']==1){ ?><a class="confirm" title="Only delete order" href="processAdmin.php?d=del&i=<?php echo $order['order_id']?>">Delete Order</a>&emsp;<a class="confirm" title="Delete order & Block Buyer" href="processAdmin.php?d=block&i=<?php echo $order['user_id']?>&t=<?php echo $order['order_id']?>">Delete & Block Buyer</a><?php }else{ if($order['modefy']==0){ ?><span class="red">يلزم تعديل الكمية  </span> <?php }else{ ?><span class="fas fa-check green"></span>&emsp;تم تعديل الكمية  <?php } } ?></td>
				    </tr>
				    <?php } 
				} ?>
				</tbody>
		     </table>
     	   </div><!--END class="table-reponsive" -->



     	   <span class="containerDash-heading bold">Reported Traders (Bad Traders) </span>
		<span class="green">All= (<?php echo $R_Orders_T; ?>)</span>
		<div class="table-reponsive table-report">
		<table class="table-manage bad-traders">
			    <thead>
					<tr>
						<td><a href=""> Item</a> </td>
						<td class="tr"><a href=""> Trader Name</a> </td>
						<td class="tr"><a href=""> Trader Phone </a> </td>
						<td class="tr"><a href=""> Trader State</a> </td>
						<td class="tr"><a href=""> Trader City </a> </td>
						<td><a href=""> Buyer Name </a> </td>
						<td><a href=""> Buyer Phone </a> </td>
						<td><a href=""> Text </a> </td>
						<td><a href=""> Buyer State </a> </td>
						<td><a href=""> Buyer City </a> </td>
						<td><a href=""> Action </a> </td>
				    </tr>
				</thead>
				<tbody>
					<tr>
						<?php
						$stmt=$conn->prepare(' SELECT * from orders 
						join items on items.item_id=orders.item_id
						join user on user.user_id=orders.trader_id 
						join state on state.state_id=orders.state_id
						join city on city.city_id=orders.city_id 
						where orders.report_trader=1 order by orders.order_id desc ');
						$stmt->execute();
			            $orders=$stmt->fetchAll();

			            if (!empty($orders)) {
			            	foreach ($orders as $order) { 
			            	    $fetchTrData=fetch('*','user','user_id',$order['trader_id']);
			            	    $fetchBuyerId=fetch('user_id','orders','order_id',$order['order_id']);
                                  
			            		?>
						<td><a href="../details.php?id=<?php echo $order['item_id']?>&source=admin"><?php echo $order['title']?></a> </td> 
						<td class="tr"><?php echo $order['commercial_name']?></td>
						<td class="tr"><?php echo '0'.$order['trader_phone']?></td>
						<td class="tr"><?php echo getState($fetchTrData['state_id'],$l)?></td>
						<td class="tr"><?php echo getCity($fetchTrData['city_id'],$l)?></td> 
						<td><?php echo $order['buyer_name']?></td>
						<td><?php echo '0'.$order['buyer_phone']?></td> 
						<td><?php echo $order['report_value']?></td>  
						<td><?php echo $order['state_nameAR']?></td>
						<td><?php echo $order['city_nameAR']?></td>
						<td><a class="confirm" title="Only delete order" href="processAdmin.php?d=del&i=<?php echo $order['order_id']?>">Delete Order</a>&emsp;<a class="confirmBan" title="ban" href="processAdmin.php?d=ban&i=<?php echo $order['user_id']?>&t=<?php echo $order['order_id']?>">Deactivate Trader</a>&emsp;&emsp;<a class="confirmBan" title="ban" href="processAdmin.php?d=ban&i=<?php echo $fetchBuyerId['user_id'];?>">Deactivate Buyer</a></td>
				    </tr>
				    <?php } } ?>
				</tbody>

		     </table>
     	   </div><!--END class="table-reponsive" -->




		<span class="containerDash-heading bold">Reported Items </span>
		<span>From details page</span><br>
		<span class="green">All= (<?php echo $R_items; ?>)</span>
		<div class="table-reponsive table-report">
		<table class="table-manage">
			    <thead>
					<tr>
						<td><a href=""> Item Name </a> </td>
						<td><a href=""> Reason </a> </td>
						<td><a href=""> Report date </a> </td>
						<td><a href=""> Reporter </a> </td>
						<td><a href=""> Action </a> </td>
				    </tr>
				</thead>
				<tbody>
					<tr>
						<?php
						$stmt=$conn->prepare(' SELECT * from report 
						join items on items.item_id=report.item_id
						join user on user.user_id=report.user_id 
						where report.value is not null ');
						$stmt->execute();
			            $reports=$stmt->fetchAll();
			            if (!empty($reports)) {
			            	foreach ($reports as $report) { ?>
						<td><a href="../details.php?id=<?php echo $report['item_id']?>&source=admin"><?php echo $report['title']?></a> </td>
						<td>
							<?php if($report['value']==1){echo "اعلان غير أخلاقي ";}
						          elseif($report['value']==2){echo "اعلان متكرر ";}
						          elseif($report['value']==3){echo "احتيال ";} 
						          else{echo $report['value'];}
						    ?> 
						</td>
						<td><?php echo $report['report_date']?></td>
						<td><?php echo $report['name']?></td>
						<td><a  href="items.php?do=edit&id=<?php echo $report['item_id']?>">EDIT</a></td>
				    </tr>
				    <?php } } ?>
				</tbody>

		     </table>
     	   </div><!--END class="table-reponsive" -->

     	   <span class="containerDash-heading bold">Reported Comments </span>
     	   <span class="orange">All= (<?php echo $comAll; ?>)</span><br>
     	   <span class="green">Active= (<?php echo $comActive; ?>)</span><br>
     	   <span class="red">Cancelled= (<?php echo $comCancelled; ?>)</span>
     	   <div class="table-reponsive table-report">
		     <table class="table-manage">
			   <thead>
					<tr>
						<td><a href=""> Item Name </a> </td>
						<td><a href=""> Comment </a> </td>
						<td><a href=""> Reporter </a> </td>
						<td><a href=""> Status </a> </td>
						<td><a href=""> Action </a> </td>
				    </tr>
				</thead>
				<tbody> 
					<tr>
						<?php
						$stmt=$conn->prepare(' SELECT * from reportcomm 
						join user on user.user_id=reportcomm.user_id
						join comments on comments.c_id=reportcomm.comment_id ');
						$stmt->execute();
			            $reports=$stmt->fetchAll();
			            if (!empty($reports)) {
			            	foreach ($reports as $report) {
			            	$fetchID=fetch('item_id','comments','c_id',$report['comment_id']); 
			            	$fetchTitle=fetch('title','items','item_id',$fetchID['item_id']); 
			            	/*$stmt=$conn->prepare("SELECT title FROM $table WHERE $field2=? and $field3=? ");
                            $stmt->execute(array($value2,$value3));*/

			            ?> 
						<td class="cut2"><a href="../details.php?id=<?php echo $fetchID['item_id']?>&t=s&source=admin"><?php echo $fetchTitle['title']?></a> </td>
						<td class="cut2"><?php echo $report['c_text']?></td>
						<td class="cut2"><?php echo $report['name']?></td>
						<td class="cut2"><?php if($report['value']==1){echo "<i class='fas fa-check green'></i>";}else{ echo "<span class='red'>العضو تراجع عن التبليغ </span>";}?></td>
						<td><a title="Edit comment" href="comments.php?do=edit&id=<?php echo $report['c_id']?>">EDIT</a>&emsp;<a title="Delete comment" class="confirm" href="comments.php?do=delete&id=<?php echo $report['c_id']?>">DELETE</a>&emsp;<a title="Delete reporting but keep comment" class="confirmRow" href="comments.php?do=deleteRow&id=<?php echo $report['c_id']?>">DELETE REPORTING</a></td>
				    </tr>
				    <?php } } ?>
				</tbody>
		      </table>
     	   </div><!--END class="table-reponsive" -->
	</div><!--end containerDash2 -->
    <!--ajax coner -->
		       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
		       <script>
		       $(document).ready(function(){
		       	//send paid to change orders.paid to 1 or 0
		         $("#formRepair").on("submit", function(e){
		          e.preventDefault();
		          $.ajax({
		          url:"posts.php", 
		          method:"POST",
		          beforeSend:function(){
		            $('#formRepair> button').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
		            $('#formRepair> button').addClass('disabled',true);
		          },
		          processData:false,
		          contentType:false,
		          data:new FormData(this),
		          success: function(data){                             
		            $(".showForm").html(data);
		             },
		          complete:function(){
		         	$('#formRepair> button').removeClass('disabled',true);
		            $('.spinner-border').remove();
		           }
		           });
		        }); 
		        //





		         });
		     </script>



<?php }elseif ($dash=='orders') { 
	$stmt=$conn->prepare(' SELECT sum(order_mostafed) from orders ');
    $stmt->execute();$sum_mostafed=$stmt->fetchColumn();
    //count orders after 5 minutes of placing them 
    $stmt=$conn->prepare(' SELECT count(order_id) from orders WHERE UNIX_TIMESTAMP()>order_date+300 ');
    $stmt->execute();$count_orders=$stmt->fetchColumn();
    //count reported orders
    $stmt=$conn->prepare(' SELECT count(order_id) from orders where report=1 OR num2>0 ');
    $stmt->execute();$R_orders=$stmt->fetchColumn();
	?>
	<!--orders-->
	<div  class="containerDash4 orders"> 
		<span class="containerDash-heading">Orders <?php echo '('.$count_orders.')'; ?></span>
		<div class="table-reponsive table-report"> 
			<form class="OrTrPh">
				<span class="red">Calculate Mostafed Rates for </span><input type="text" name="TrPhone" placeholder=" Insert trader phone" autocomplete="off">
				<button>Go</button>
			</form>
			<span class="showForm">show result</span>
		     <table class="table-manage main">
			   <thead>
					<tr>
						
						<td><a> Product Name<br> <?php echo 'No. of Orders ='.$count_orders; ?></a> </td>
						<td><a> Trader Address  </a> </td>
						<td><a> Trader Phone  </a> </td>
						<td><a> Trader Name   </a> </td>
						<td class="up-wide"><a> Mostafed Rates<br>Item*Quantity<br> <?php echo '<span class="small">All orders here= </span>'.number_format($sum_mostafed,2,'.',','); ?>  </a> </td>
					    <td><a> Approve Date </a> </td>
						<td><a> Order Date </a> </td>
						<td><a> Order Code </a> </td> 
						<td><a> City </a> </td>
						<td><a> State </a> </td>
						<td><a> Buyer Phone </a> </td>
						<td><a> Buyer Name </a> </td>
						<td><a> Quantity </a> </td>
						<td><a> Is buyer reported? <br> <?php echo 'Num of R='.$R_orders; ?>    </a> </td>
						<td><a> Order ID  </a> </td>
						<td><a> Action </a> </td>
				    </tr>
				</thead>
				<tbody>
						<?php
						//ORDERS APPEAR IN DASHBOARD AFTER 20 MINUTES						
						$stmt=$conn->prepare(' SELECT items.*,user.*,state.*,city.*,orders.* from orders 
						join items on items.item_id=orders.item_id
						join user on user.user_id=orders.trader_id 
						join state on state.state_id=orders.state_id
						join city on city.city_id=orders.city_id
						 where orders.order_date< UNIX_TIMESTAMP()-(5*60)  order by order_id desc ');

						$stmt->execute();
			            $orders=$stmt->fetchAll(); 
			            if (!empty($orders)) { 
			            	foreach ($orders as $order) { 
			            ?><tr>
			            <td class="cut2 dir"><a class='title' href="../details.php?id=<?php echo $order['item_id']?>&t=admin&main=admin&source=admin"><?php echo $order['title']?></a></td>
			            <td class="cut2 name"><?php echo $order['address']?></td>
			            <td class="cut2 name"><?php echo '0'.$order['phone']?></td>
			            <td class="cut2 name"><?php echo $order['commercial_name']?></td>
			            <td class=" middle wide2"><?php echo number_format($order['order_mostafed'],2,'.',',')?></td>
			             <td class="cut2 middle wide"><?php if($order["approve_date"]>0){ echo $dt=date('Y-m-d h:i:s A',$order["approve_date"]); }else{ echo "Not Approved Yet";} ?></td>
			            <td class="cut2 middle wide"><?php echo date('Y/m/d h:i:s A',$order['order_date']);?></td> 
			            <td class="cut2 middle"><?php echo $order['order_code']?></td>
			            <td class="cut2 name2"><?php echo $order['city_nameAR']?></td>
			            <td class="cut2 name2"><?php echo $order['state_nameAR']?></td>
			            <td class="cut2 middle name2"><?php echo '0'.$order['buyer_phone']?></td>
			            <td class="cut2 name2"><?php echo $order['buyer_name'] ?></td> 
			            <td class="cut2 name2"><?php echo $order['num'] ?></td> 
			            <td class="cut2 middle wide"><?php if($order['report']==1){echo "<span class='red'>Buyer didn't come</span>";}elseif($order['num2']>0){echo "<span class='red'>Buyer bought less -'".$order['num2']."'</span>";}else{ echo "<span class='green'>No</span>";}  ?></td> 
						<td class="cut2 one"><?php if($order['report']==1||$order['num2']>0){ echo '<span class="red">'.$order['order_id'].'</span>';}else{ echo '<span class="green">'.$order['order_id'].'</span>'; }?></td>
						<td class="cut2 middle wide2"><?php if($order['approve']==1){?><div class="action-div"><a title="الغاء التحويل" class="confirmReturn" href="processAdmin.php?d=return&i=<?php echo $order['order_id']?>"><i class="fas fa-exchange-alt purple"></i></a>&emsp;&nbsp;<a title="حذف الطلب وحظر المشتري  " class="confirmBlock" href="processAdmin.php?d=block&i=<?php echo $order['user_id']?>&t=<?php echo $order['order_id']?>"><i class="fas fa-ban"></i></a>&emsp;  <a  title="حذف الطلب  "  href="processAdmin.php?d=del&i=<?php echo $order['order_id']?>"><i class="fas fa-trash confirm"></i></a>&emsp;<i title="تم التحويل للتاجر" class="fas fa-check approved"></i></div> <?php }else{ ?><div class="action-div"><a title="تحويل للتاجر " class="confirmApprove" href="processAdmin.php?d=confirm&i=<?php echo $order['order_id']?>"><i class="fas fa-share orange"></i></a>&emsp;&emsp;<a title="حذف الطلب  "  href="processAdmin.php?d=del&i=<?php echo $order['order_id']?>"><i class="fas fa-trash confirm"></i></a>&emsp;&emsp;<a title="Block Buyer"  class="confirmBlock" href="processAdmin.php?d=block&i=<?php echo $order['user_id']?>&t=<?php echo $order['order_id']?>"><i class="fas fa-ban"></i></a></div> <?php } ?></td>
				    </tr>
				    <?php } } ?> 
				</tbody>
		      </table>
     	   </div><!--END class="table-reponsive" -->

     	   <!--ajax coner -->
		       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
		       <script>
		       $(document).ready(function(){
		       	//send paid to change orders.paid to 1 or 0
		         $(".OrTrPh").on("submit", function(e){
		          e.preventDefault();
		          $.ajax({
		          url:"processAdmin2.php", 
		          method:"POST",
		          beforeSend:function(){
		            $('.OrTrPh> button').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
		            $('.OrTrPh> button').addClass('disabled',true);
		          },
		          processData:false,
		          contentType:false,
		          data:new FormData(this),
		          success: function(data){                             
		            $(".showForm").html(data);
		             },
		          complete:function(){
		         	$('.OrTrPh> button').removeClass('disabled',true);
		            $('.spinner-border').remove();
		           }
		           });
		        }); 
		        //





		         });
		     </script>

     	  <?php 
    }elseif ($dash=='mostafed') { 
	$stmt=$conn->prepare(' SELECT * from orders 
    join user on user.user_id=orders.trader_id
	join country on country.country_id=user.country_id
	join state on state.state_id=user.state_id
	join city on city.city_id=user.city_id
	where orders.approve=1 group by orders.trader_id order by orders.approve_date desc ');
	$stmt->execute();
    $traders=$stmt->fetchAll(); 

 	?>
 	<div  class="containerDash mostafed"> 
		<span class="containerDash-heading">Mostafed <span class="small red">(Profit)</span> <?php  ?></span>
			<form class="paid">
				<span>Set</span>
				<select name="payStatus">
					<option value="0">Choose</option>
					<option value="1">Yes, paid</option>
					<option value="2">No, didn't pay</option>
				</select>
				<span class="red">For</span>
				<input type="text" name="tr-phone" placeholder=" Insert manual trader phone" autocomplete="off">
				<button class="confirmAction">OK</button>
				&emsp;=> (For manual traders only)
			</form><br>

			<form class="zero"><p> Set <span class="red ">order_mostafed=0</span> for <input type="text" name="paidTr" placeholder="Insert manual trader Phone" autocomplete="off"> if <span class="red">paid=1</span><input type="hidden" name="setMosZero"><button class="confirmZero ">Execute</button>&emsp;=> (For manual traders only)... <span>Dangerous, take care!</span></p>
			</form>
		     <div class="showForm"></div>
		<div class="table-reponsive table-report">
		     <table class="table-manage">
			   <thead>
					<tr>
						<td> Trader ID </td> 
						<td> Commercial Name </td>
						<td> Phone </td>
						<td> Address </td>
						<td> Country </td>
						<td> State </td>
						<td> City </td>
						<td> Mostafed </td>
						<td> Paid? </td>
						<td> Action </td>
				    </tr>
				</thead>
				<tbody>
					<?php
					if (!empty($traders)) {
						foreach ($traders as $value) { 
							//mostafed profit on passed orders(approve=1)
                            $sum_mostafed=sumFromDb3('order_mostafed','orders','trader_id',$value['user_id'],'approve',1);
							?>
							<tr> 
					        	<td><?php echo $value['user_id'] ?></td>
					        	<td><?php echo $value['commercial_name'] ?></td>
					        	<td><?php echo '0'.$value['phone'] ?></td>
					        	<td><?php echo $value['address'] ?></td>
					        	<td><?php echo getCountry($value['country_id'],$l) ?></td>
					        	<td><?php echo getState($value['state_id'],$l) ?></td>
					        	<td><?php echo getCity($value['city_id'],$l) ?></td>
					        	<td><?php if($value['online_pay']==1){ ?><span class="small green"><?php echo number_format($sum_mostafed,2,'.',','); ?></span> <?php }else{ ?><span class="bold red"><?php echo number_format($sum_mostafed,2,'.',','); ?></span> <?php  }  ?></td>
					        	<td><?php if($value['online_pay']==1){ ?><span class="small">online</span><?php }else{ echo $value['paid'];} ?></td>
					        	<td> <?php if($value['online_pay']==0&&$sum_mostafed>0&&$value['paid']==0){ ?><a href="processAdmin.php?d=details&i=<?php echo $value['user_id']?>">Details</a> <?php }else{ ?><span class="green">-</span> <?php } ?></td>
					        </tr>
					<?php }
					} ?>
				</tbody>
			</table>
		</div>
	</div>
	           <!--ajax coner -->
		       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
		       <script>
		       $(document).ready(function(){
		       	//send paid to change orders.paid to 1 or 0
		         $(".paid").on("submit", function(e){
		          e.preventDefault();
		          $.ajax({
		          url:"processAdmin2.php", 
		          method:"POST",
		          beforeSend:function(){
		            $('.paid> button').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
		            $('.paid> button').addClass('disabled',true);
		          },
		          processData:false,
		          contentType:false,
		          data:new FormData(this), 
		          success: function(data){                             
		            $(".showForm").html(data);
		             },
		          complete:function(){
		         	$('.paid> button').removeClass('disabled',true);
		            $('.spinner-border').remove();
		           }
		           });
		        }); 
		        	//send paid to change orders.paid to 1 or 0
		         $(".zero").on("submit", function(e){
		          e.preventDefault(); 
		          $.ajax({
		          url:"processAdmin2.php", 
		          method:"POST",
		          beforeSend:function(){
		            $('.zero> button').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
		            $('.zero> button').addClass('disabled',true);
		          },
		          processData:false,
		          contentType:false,
		          data:new FormData(this),
		          success: function(data){                             
		            $(".showForm").html(data);
		             },
		          complete:function(){
		         	$('.zero> button').removeClass('disabled',true);
		            $('.spinner-border').remove();
		           }
		           });
		        });



		         });
		     </script>
 

 <?php }elseif ($dash=='add') { ?>
 	<!--add trader-->
	<div  class="containerDash4 orders addTr">
		<span class="containerDash-heading">Add Trader</span>
		<span class="red">Field is very important(it decides credit)</span>
		<form  id="form2"> <!-- action="processAdmin2.php" method="POST" -->
			<div class="trader-add-container">
			<input type="hidden" name="addTrader"> 
				<div>
					<label> trader name</label><br>
					<input type="text" name="username" placeholder="name">
					<input type="hidden" id="lng" value="<?php echo $l; ?>">
					<input type="hidden" name="cpanel" value="cpanel">
				</div>

				<div>
					<label> company name</label><br>
					<input type="text" name="commercial_name" placeholder="commercial name">
				</div>

				<div>
					<label> mobile phone </label><br>
					<input type="text" name="phone" placeholder="mobile phone">
				</div>

				<div>
					<label> Address </label><br>
					<input type="text" name="address" placeholder="Address">
				</div>


				<div>
					<label>Field</label><br>
					<select class=" inputPassword  select-country " id="Cat"  name='field'  required>
	                    <option value="0"><?php echo $lang['choose']?></option>
	                    <?php
	                    $stmt=$conn->prepare(" SELECT * from categories  ");
	                    $stmt->execute();
	                    $cats=$stmt->fetchAll();
	                    foreach ($cats as $cat) {
	                      if($l=='ar'){echo "<option value=".$cat['cat_id'].">".$cat['cat_nameAR']."</option>";}
	                      else{echo "<option value=".$cat['cat_id'].">".$cat['cat_nameAR']."</option>";}
	                     }  ?>
	                </select> 
				</div>


				<div>
					<label>country</label><br>
					<select class=" inputPassword  select-country " id="country"  name='country'  required>
	                    <option value="0"><?php echo $lang['choose']?></option>
	                    <?php
	                    $stmt=$conn->prepare(" SELECT * from country where country_id=1 ");
	                    $stmt->execute();
	                    $country=$stmt->fetchAll();
	                    foreach ($country as $cont) {
	                      if($l=='ar'){echo "<option value=".$cont['country_id'].">".$cont['country_nameAR']."</option>";}
	                      else{echo "<option value=".$cont['country_id'].">".$cont['country_name']."</option>";}
	                     }  ?>
	                </select>
				</div>

				<div>
					<label>State</label><br>
					<select class=" inputPassword  select-country " id="state"  name='state'  required>
	                    <option value="0"><?php echo $lang['choose']?></option>
	                </select>
				</div>

				<div> 
					<label>city</label><br> 
					<select class=" inputPassword  select-country " id="city"  name='city'  required>
	                    <option value="0"><?php echo $lang['choose']?></option>
	                </select>
				</div>

				<div>
					<label> Online Pay </label><br>
					<select class=" inputPassword  select-country " id="city"  name='onlinePay'  required='required'>
	                    <option value="0"><?php echo $lang['choose']?></option>
	                    <option value="1">Yes, will pay online</option>
	                    <option value="2">No, will pay manual</option>
	                </select>
				</div>

			</div>
			<button class="trader-add-btn" type="submit">ok</button>
		</form>
		<div class="showForm show1"></div>

        <br><br><br><br><br><br>
          <!--/////////////////////// Add Review //////////////////////////-->
		<span class="containerDash-heading add-review">Add Review</span>
		<form  id="form3"> <!-- action="processAdmin2.php" method="POST" -->
			<div class="trader-add-container"> 
				<div>
					<label> Reviewer Name</label><br>
					<input type="text" class="ReviewerN" name="name" placeholder="Insert name" autocomplete="off">
				</div>


				<div>
					<label> Review Text</label><br>
					<input type="text" class="ReviewerT" name="reviewText" placeholder="Insert review Text" autocomplete="off">
				</div>
				<button class="trader-add-btn btnBelow" type="submit">ok</button>
				<div class="showFormRev"></div>
			</div>
		</form>
		<div class="showForm show2"></div>
        

        <br><br><br><br><br><br>
          <!--/////////////////////// Add Credit //////////////////////////-->
		<span class="containerDash-heading add-review">Add Credit</span>
		<form  id="form4"> <!-- action="processAdmin2.php" method="POST" -->
			<div class="trader-add-container"> 
			<input type="hidden" name="addCredit">
				<div>
					<label> Trader Phone</label><br>
					<input type="text" class="ReviewerN" name="creditTrPhone" placeholder="Insert Trader Phone" autocomplete="off">
				</div>

				<div>
					<label> Amount</label><br>
					<input type="text" class="ReviewerT" name="creditTrAmount" placeholder="Insert Amount (0.00)" autocomplete="off">
				</div>
				<button class="trader-add-btn btnBelow" type="submit">Insert</button>
				<div class="showFormRev"></div>
			</div>
		</form>
		<div class="showForm show3"></div>



	</div>

	

	<!--ajax coner -->
       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
       	//ajax call country
        $("#country").on("change", function(){
          var countrySign=$(this).val();
          var L=$('#lng').val();
          $.ajax({
          url:"../receiveAjaxSign.php",
          data:{sentCountrySign:countrySign,l:L},
          success: function(data){                             
            $("#state").html(data);
             }
           });
        });
        //ajax call state
        $("#country,#state").on("change", function(){
          var stateSign=$('#state').val();
          var L=$('#lng').val();
          $.ajax({
          url:"../receiveAjaxSign.php",
          data:{sentStateSign:stateSign,l:L},
          success: function(data){                             
            $("#city").html(data);
             }
           });
        });
        //add new trader
        $("#form2").on("submit", function(e){
          e.preventDefault();
          var form2=$(this);
          $.ajax({
          url:"posts.php", 
          method:"POST",
          beforeSend:function(){ 
            $('#form2>.trader-add-btn').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#form2>.trader-add-btn').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $(".show1").html(data);
             },
          complete:function(){
         	$('#form2>.trader-add-btn').removeClass('disabled',true);
            $('.spinner-border').remove();
           }
           });
        });
        //add new review
        $("#form3").on("submit", function(e){ 
          e.preventDefault();
          var form3=$(this);
          $.ajax({
          url:"processAdmin2.php", 
          method:"POST",
          beforeSend:function(){
            $('#form3>.btnBelow').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#form3>.btnBelow').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $(".show2").html(data);
             },
          complete:function(){
         	$('#form3>.btnBelow').removeClass('disabled',true);
            $('.spinner-border').remove();
            $('.ReviewerN').val(' ');
            $('.ReviewerT').val(' ');
           }
           });
        });
        //add new review
        $("#form4").on("submit", function(e){
          e.preventDefault();
          //var form4=$(this);
          $.ajax({
          url:"posts.php", 
          method:"POST",
          beforeSend:function(){
            $('#form4>.btnBelow').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#form4>.btnBelow').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $(".show3").html(data);
             },
          complete:function(){
         	$('#form4>.btnBelow').removeClass('disabled',true);
            $('.spinner-border').remove();
            $('.ReviewerN').val(' ');
            $('.ReviewerT').val(' ');
           }
           });
        });
        
		       





        });
       </script>





<?php }elseif ($dash=='reviews') { ?>
		
		<div class="table-reponsive table-report review">
		<p class="containerDash-heading bold">New Reviews </p>
		<table class="table-manage">
			    <thead>
					<tr>
						<td><a href=""> ID </a> </td>
						<td><a href=""> Review </a> </td>
						<td><a href=""> By </a> </td>
						<td><a href=""> Status </a> </td>
						<td><a href=""> Action </a> </td>
				    </tr>
				</thead>
				<tbody>
					<tr>
						<?php
						$stmt=$conn->prepare(' SELECT * from review order by review_id desc');
						$stmt->execute();
			            $reviews=$stmt->fetchAll();
			            if (!empty($reviews)) {
			            	foreach ($reviews as $review) { ?>
						<td><?php echo $review['review_id'] ?></td>
						<td><?php echo $review['review_text']?></td>
						<td><?php echo $review['name']?></td>
						<td><?php if($review['approve']==1){ echo '<span class="green">Shown</span>';}else{echo '<span class="red">Pending</span>';}?></td>
						<td><a  href="processAdmin2.php?do=editReview&id=<?php echo $review['review_id']?>">EDIT</a>&emsp;&emsp;<a  href="processAdmin2.php?do=approveReview&id=<?php echo $review['review_id']?>">Approve</a>&emsp;&emsp;<a class="confirm" href="processAdmin2.php?do=deleteReview&id=<?php echo $review['review_id']?>">DELETE</a></td>
				    </tr>
				    <?php } } ?>
				</tbody>
		     </table>
     	   </div><!--END class="table-reponsive" -->


 


<?php }elseif($dash=='messages'){ ?>
		<div class="table-reponsive table-report">
			<p class="containerDash-heading"> Messages</p>
		     <table class="table-manage table-msg">
			   <thead>
					<tr>
					    <td><a href=""> No  </a> </td> 
						<td><a href=""> Date  </a> </td>
						<td class=" max"><a href=""> text </a> </td>
						<td><a href=""> Read or Not? </a> </td>
						<td><a href=""> From </a> </td>
						<td><a href=""> To </a> </td>
						<td><a href=""> Action </a> </td>
				    </tr>
				</thead>
				<tbody>
						<?php
					   $msgNum=countFromDb('message_id','message');
					   $adsPerPage=isset($_GET['th'])?$_GET['th']:30;
		              // $adsPerPage=30;
		               $NumberOfPages=ceil($msgNum/$adsPerPage);
		               $pageNum= isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page']<=$NumberOfPages&& $_GET['page']>0 ? intval($_GET['page']) : 1; 
		               $startFrom=($pageNum-1)* $adsPerPage;

		               $stmt=$conn->prepare(" SELECT * from message 
		               join user on user.user_id=message.message_to 
			     	   order by message.message_date desc  limit $startFrom,$adsPerPage ");	
					   $stmt->execute();
					   $messages=$stmt->fetchAll();
	                   $num=1;
			            if (!empty($messages)) { 
			            	foreach ($messages as $msg) { 
			            	$fetchFrom=fetch('name','user','user_id',$msg['message_from']);
			            	$fetchTo=fetch('name','user','user_id',$msg['message_to']);
			            ?>
			            <tr>
			            <td class="cut2"><?php echo $num?></td>
			            <td class=" "><?php echo date('Y/m/d',$msg['message_date'])?></td>
						<td class="cut2 max"><?php echo $msg['message_text']?></td>
						<td class="cut2"><?php echo $msg['message_status']?></td>
						<td class="cut2"><?php if($msg['message_from']==7){ echo "الادارة ";}else{ echo $fetchFrom['name'];} ?></td>
						<td class="cut2"><?php echo $fetchTo['name']?></td> <!--&n=num&m=<?php echo $ID;?> \\ &m=<?php echo $ID;?>-->
						<td class="cut2"><a href="?dash=edit&id=<?php echo $msg['message_id']?>">EDIT</a> &emsp;<a class="confirm" href="?dash=delete&id=<?php echo $msg['message_id']?>">DELETE</a></td>
				    </tr>
				    <?php $num++;
				     } } ?>
				</tbody>
		      </table>
		      <br><br>
		      <!-- show  how many pages-->
		      <a href="dashboard.php?dash=messages&th=10">10</a>&emsp;
		      <a href="dashboard.php?dash=messages&th=20">20</a>&emsp;
		      <a href="dashboard.php?dash=messages&th=50">50</a>


		      <?php
		      //===================start pagination=========================	
					    $jumpForward=1;
					 	$jumpBackward=1; 

					if($NumberOfPages>1 ){ 	?>
					 <nav aria-label="Page navigation example" class="pagination-container">
						  <ul class="pagination pagination-md">
						 <?php if(($pageNum-$jumpBackward)>=1 ){  //previous
						 ?> <li class="page-item"><a class="page-link prev" href="dashboard.php?dash=messages&page='. ($pageNum-$jumpBackward)?>"><?php echo $lang['prev'];?></a></li><?php
					      }else{
					      ?> <li class="page-item disabled"><a class="page-link"><?php echo $lang['prev'];?></a></li><?php
					      }
					      //$page=1; $page<= $NumberOfPages;  $page++
					  for ($page=max(1,$pageNum-2);$page<=min($pageNum+2,$NumberOfPages);$page++) {  //for loop
						if (isset($_GET['page'])&&$_GET['page']==$page ) {
							echo   '<li class="page-item"><a class="page-link active" href="dashboard.php?dash=messages&page='.$page.'">'.$page.'</a></li>';
						}elseif (!isset($_GET['page'])&&$page==1 ) {
						   echo   '<li class="page-item"><a class="page-link active" href="dashboard.php?dash=messages&page='.$page.'">'.$page.'</a></li>';
						}else{
							echo   '<li class="page-item"><a class="page-link" href="dashboard.php?dash=messages&page='.$page.'">'.$page.'</a></li>';
						} }
					    if(($pageNum+$jumpForward)<=$NumberOfPages){  //next
						?> <li class="page-item"> <a class="page-link next"  href="dashboard.php?dash=messages&page='. ($pageNum+$jumpForward)?>"><?php echo $lang['next'];?></a> </li><?php
					}else{
					   ?> <li class="page-item disabled"> <a class="page-link "><?php echo $lang['last'];?></a> </li><?php
					} ?>  
					    </ul > 
					</nav>
					<?php
					} ?>
			<!--////////////// END pagination //////////////-->
		      <p>SEND group message</p>
		      <form class="" id="txtMsg">
				<textarea  class="textarea-comment" name="sendAll" placeholder="Write your group message"></textarea>
				<?php
				$Traders=fetchAll('user_id','user','trader',1);
				if (!empty($Traders)) { 
				 foreach ($Traders as  $value) {
				 	?><input type="hidden" name="id[]" value="<?php echo $value['user_id'] ?>"> <?php
				  }
				}
				//users & traders => activated account only
				$All=fetchAll('user_id','user','activate',1);
				if (!empty($All)) { 
				 foreach ($All as  $key) {
				 	?><input type="hidden" name="all[]" value="<?php echo $key['user_id'] ?>"> <?php
				  }
				}
                ?> 
				<select name="selectAll">
					<option>Choose</option>
					<option value="1">Traders only</option>
					<option value="2">Traders & Users</option>
				</select>
				<button type="submit" class="button-all btn2">ارسل  </button><button id="refresh">REFRESH</button>
				<span class="grMsg"></span>
			  </form>
			  <br>
			  <form id="FormDelMsg">
			  	<span>Delete messages older than</span> 
			  	<select name="selectDelMsg">
					<option>Choose</option>
					<option value="1">A week</option>
					<option value="2">Two weeks</option>
					<option value="3">Three weeks</option>
				</select>
			  	<button type="submit" class="button-all">DELETE</button>
			  	<span class="grMsg2"></span>
			  </form>

     	   </div><!--END class="table-reponsive" -->
     	
     	<?php  // } ?> <!-- END if (isset($_GET['dash'])&& isset($_GET['d']) -->
	
  
	</div><!--end containerDash4 -->
  <!--ajax coner -->
       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
      //send group message from dash=message
         $("#txtMsg").on("submit", function(e){
          e.preventDefault();
          $.ajax({
          url:"processAdmin2.php", 
          method:"POST",
          beforeSend:function(){
            $('#txtMsg .btn2').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#txtMsg .btn2').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $(".grMsg").html(data);
             },
          complete:function(){
         	$('#txtMsg .btn2').removeClass('disabled',true);
            $('.spinner-border').remove();
           }
           }); 
        }); 
         //delete messages older than
         $("#FormDelMsg").on("submit", function(e){
          e.preventDefault();
          $.ajax({
          url:"processAdmin2.php", 
          method:"POST",
          beforeSend:function(){
            $('#FormDelMsg> button').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#FormDelMsg> button').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $(".grMsg2").html(data);
             },
          complete:function(){
         	$('#FormDelMsg> button').removeClass('disabled',true);
            $('.spinner-border').remove();
           }
           });
        });
        


         }); 
     </script>






<?php }elseif ($dash=='delete') { ?>
	<div  class="containerDash4">
		<span class="containerDash-heading">Delete message </span>
		<?php
		$ID=isset($_GET['id']) && is_numeric($_GET['id'])?intval($_GET['id']):0;				   
        $check=checkItem('message_id', 'message', $ID);
        if ($check>0) {  
	         $stmt=$conn->prepare('DELETE  FROM  message  WHERE  message_id = ? ');
			 $stmt->execute(array($ID));
			 $stmt->rowCount();

			echo '<h5>   success </h5>';							    
		    echo "<div class='alert alert-success'>".$stmt->rowCount(). " Message deleted </div>";     
        	echo "<div class='center above-lg'><a href='dashboard.php?dash=messages'> Back </a>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <a href='dashboard.php'> Dashboard </a></div>"; 
           
    	}else{
    	echo "<div class='container'> " ;
    	 $redirectHomeMsg='This message isn\'t exisiing';
		echo "</div>" ;
    	}
		?>
	</div>
<?php }elseif ($dash=='edit') { ?>
	<div  class="containerDash4"> 
		<span class="containerDash-heading">Edit message </span>
	<?php if(isset($_GET['id'])&& is_numeric($_GET['id']) && !isset($_GET['t'])){ 
          //EDIT message
          $ID=intval($_GET['id']);//message_id

      $fetch=fetch('*','message','message_id',$ID);
      ?><form action="?dash=update" method="POST"> <?php
      if($fetch['message_id']>0){
        ?> 
        <input type="text" class="inputEditMsg" name="reply" value="<?php echo $fetch['message_text']?>"> 
        <p class="EditMsgP"><?php echo $fetch['message_text']?></p>
        <input type="hidden" name="reply_id" value="<?php echo $fetch['message_id']?>"> 
        <?php if(isset($_GET['n'])){ ?><input type="hidden" name="num"><input type="hidden" name="msg" value="<?php echo $_GET['m'];?>"> <?php } 
       } ?>
     <button type="submit">OK</button>
     </form> 
     <?php

     }elseif (isset($_GET['id'])&& is_numeric($_GET['id']) && isset($_GET['t'])) {
     	 //EDIT replies
     	$ID=intval($_GET['id']);//reply_id
     	$fetch=fetch('*','message','message_id',$ID);
      ?><form action="?dash=update" method="POST"> <?php
      if($fetch['message_id']>0){
        ?> 
        <input type="text" name="reply" value="<?php echo $fetch['message_text']?>"> 
        <input type="hidden" name="reply_id" value="<?php echo $fetch['message_id']?>"> 
        <input type="hidden" name="replies">
        <?php if(isset($_GET['n'])){ ?><input type="hidden" name="num"><input type="hidden" name="msg" value="<?php echo $ID;?>"> <?php } 
       } ?>
     <button type="submit">OK</button>
     </form> 
     <?php

     }
   ?></div>
         
<?php }elseif ($dash=='update') {

	?><div  class="containerDash4"><?php
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		$reply=$_POST['reply'];
		$reply_id=$_POST['reply_id'];
		
        if (!isset($_POST['replies'])) {
		 //UPDATE messages
		$stmt=$conn->prepare('UPDATE  message  SET  message_text=?  WHERE  message_id=? ');
		$stmt->execute(array($reply,$reply_id));
		if ($stmt) {
			echo '<h5>   success </h5>';							    
		    echo "<div class='alert alert-success'>".$stmt->rowCount(). " Message Updated </div>";     
		   	echo "<div class='center above-lg'><a href='dashboard.php?dash=messages'> Back </a>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <a href='dashboard.php'> Dashboard </a></div>"; 
		}
      }else{ //END if (!isset($_POST['replies']))
        //UPDATE replies
        $stmt=$conn->prepare('UPDATE  reply  SET  reply=?  WHERE  message_id=? ');
		$stmt->execute(array($reply,$reply_id));
		if ($stmt) {
			echo '<h5>   success </h5>';							    
		    echo "<div class='alert alert-success'>".$stmt->rowCount(). " Reply Updated </div>";     
		    echo "<div class='center above-lg'><a href='dashboard.php?dash=messages'> Back </a>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <a href='dashboard.php'> Dashboard </a></div>"; 
		}
      }//END else
	}

    ?></div><?php
}elseif ($dash=='countries') {
	echo "countries";
}elseif ($dash=='cities') {
	echo "cities";
}elseif ($dash=='sales') {
	?><div  class="containerDash4 container">
	 <span class="containerDash-heading">Sales</span> 
	 <i class='fas fa-check green'></i>=still going &emsp;<i class='fas fa-times red'></i>=finished
		<div class="table-reponsive ">
		     <table class="table-manag2">
			   <thead>
					<tr>
						<td><a href=""> ID </a> </td>
						<td><a href=""> Title </a> </td>
						<td><a href=""> Details </a> </td>
						<td><a href=""> Start date </a> </td>
						<td><a href=""> End date </a> </td>
						<td><a href=""> Status </a> </td>
						<td><a href=""> Item </a> </td>
						<td><a href=""> By </a> </td>
						<td><a href=""> Action </a> </td>
				    </tr>
				</thead>
				<tbody>
					<tr>
						<?php
						$today=date('Y-m-d');
						$stmt=$conn->prepare(' SELECT * from sale 
						join items on items.item_id=sale.item_id
						join admins on admins.user_id=sale.user_id
						order by sale_id desc ');
						$stmt->execute();
			            $sales=$stmt->fetchAll();

			            if (!empty($sales)) {
			            	foreach ($sales as $sale) { ?>
						<td class="cut2"><?php echo $sale['sale_id']?></td>
						<td class="cut2"><?php echo $sale['sale_title'];?></td>
						<td class="cut2"><?php echo $sale['sale_details']?></td>
						<td class="cut2"><?php echo $sale['startDate'];?></td>
						<td class="cut2"><?php echo $sale['endDate'];?></td>
						<td class="cut2"><?php if($sale['endDate']<$today){ echo "<i class='fas fa-times red'></i>"; }else{ echo "<i class='fas fa-check green'></i>"; }?></td>
						<td class="cut2"><?php echo $sale['NAME']?></td>
						<td class="cut2"><?php echo $sale['username'];?></td>
						<td class="cut2"><a href="?dash=editSale&id=<?php echo $sale['sale_id']?>">EDIT</a> &emsp;<a class="confirm" href="?dash=deleteSale&id=<?php echo $sale['sale_id']?>">DELETE</a></td>
				    </tr>
				    <?php } } ?>
				</tbody>
		      </table>
     	   </div><!--END class="table-reponsive" -->
    </div><?php
}elseif ($dash=='editSale') {
	$ID=isset($_GET['id'])&& is_numeric($_GET['id'])?intval($_GET['id']):0;
      $fetch=fetch('*','sale','sale_id',$ID);
      
      ?><div  class="containerDash4 sale-container">
	    <span class="containerDash-heading">Edit Sale</span>
      <?php if (!empty($fetch)) { ?>
      	<form action="?dash=updateSale" method="POST">
	      	<label>Title</label>
	      	<input  type="text" name="title" value="<?php echo $fetch['sale_title'] ?>">
	        <input type="hidden" name="sale_id" value="<?php echo $fetch['sale_id'] ?>">
	        <br>
	        <label>Details</label>
	      	<input type="text" name="details" value="<?php echo $fetch['sale_details'] ?>">
	        <br>
	        <label>Start date</label>
	        <input class="date" type="date" name="start" value="<?php echo $fetch['startDate'] ?>">
	        <br>
	        <label> End date</label>
	      	<input class="date" type="date" name="end" value="<?php echo $fetch['endDate'] ?>">
            <br>
           <button type="submit">SAVE</button>
       </form>
   <?php   }
   ?></div>  

<?php }elseif ($dash=='updateSale') {
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		$check=checkItem('sale_id','sale',$_POST['sale_id']);
		if ($check>0) {
		
		$title  =$_POST['title'];
		$details=$_POST['details'];
		$start  =$_POST['start'];
		$end    =$_POST['end'];
		$id    =$_POST['sale_id'];

        if (empty($title)) {
			echo "Title field is empty";
		}elseif (empty($details)) {
			echo "<br>Details field is empty";
		}elseif (empty($start)) {
			echo "<br>Insert Start date";
		}elseif (empty($end)) {
			echo "<br>Insert End date"; 
		}else{
			//update
			$stmt=$conn->prepare(' UPDATE sale 
			 set sale_title=?,sale_details=?,startDate=?,endDate=?
			 where  sale_id=? ');
			$stmt->execute(array($title,$details,$start,$end,$id));
			if ($stmt) {
				echo "<div class='block-green'>Sale edited successfully</div>";
			}

		}
       }else{
       	echo "sale is not found";
       }
	 }//end if post
}elseif ($dash=='deleteSale') {

		$ID=isset($_GET['id'])&& is_numeric($_GET['id'])?intval($_GET['id']):0;
		$check=checkItem('sale_id','sale',$ID);
		
		if ($check>0) {
		$stmt=$conn->prepare('DELETE  FROM  sale  WHERE  sale_id = ? ');
		$stmt->execute(array($ID));
		if ($stmt) {
			echo "<div class='block-green'>Sale deleted successfully</div>";
		 }
	    
       }else{
       	echo "sale is not found";
       }



}elseif ($dash=='remarks') { ?>
	<div>
	<h2>Important Remarks</h2>
	<ul>
		<li>don't change the numerical order of categories as mostfid ratios(earnings) depend on them</li>
	    <li>transport (<=4000 at least 7 / >4000 at least 6)</li>
	    <li>entertaiment->party hall(<5000 at least 5 / >=5000 at least 4)</li>
	</ul>
       
    </div>


<?php }else{
	echo "NOOOOOO";
}
    

	



?></div> <!--end flex --><?php

           

include $tmpl ."footer.inc";
}else{ //End if session
	header('location:index.php');
}
