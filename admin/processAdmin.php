<?php
//ob_start();
session_start();       //important in every php page
$title='Action';       //title of the page
include 'init.php';
date_default_timezone_set('Africa/Cairo');


 
//coming from DASHBOARD top part 
if (isset($_SESSION['idMos'])) {
	//main Page => dashboard navbar  
      $d=isset($_GET['d'])?$_GET['d']:'none';
      if ($d=='none') {

			if ($_SERVER['REQUEST_METHOD']=='POST') {
				?><span class="spinner-border spinner-border-del"></span> <?php
				 $nav=$_POST['nav']; //GO TO INDEX
				 $session=$_SESSION['idMos'];
				 
				 if ($nav==1) {
				 	?><script>location.href='dashboard.php';</script> <?php 
				 }elseif ($nav==2) {
				 	?><script>location.href='members.php?do=edit&id=<?php echo $_SESSION['idMos'] ?>';</script> <?php 
				 }elseif ($nav==3) {
				 	?><script>location.href='categories.php';</script> <?php
				 }elseif ($nav==4) {
				 	?><script>location.href='../index.php';</script> <?php
				 }elseif ($nav==5) {
				 	?><script>location.href='logout.php';</script> <?php 
				 }
			}


 //ACTIONS(CONFIRM ORDERS, UNCONFIRM, DELETE & BLOCK) 
 //Approve ORDERS AND PASS TO TRADERS
  }elseif ($d=='confirm') {
  	if (isset($_GET['i'])&&is_numeric($_GET['i'])&&$_GET['i']>0 ) {
  		$order_id=intval($_GET['i']);
  		$approve_date=time(); 
  		
  		$stmt=$conn->prepare(' UPDATE orders set approve=1 , approve_date=? where order_id=? ');
  		$stmt->execute(array($approve_date,$order_id)); 
	  		if ($stmt) {
	  			$trader_id=fetch('trader_id','orders','order_id',$order_id);//trader_id
	  			$o_mostafed=fetch('order_mostafed','orders','order_id',$order_id);//mostafed value
	  			$prog2=fetch('prog2','orders','order_id',$order_id);//partner's code
	  			$tot=$o_mostafed['order_mostafed']/4; //.25% of o_mostafed
	  			$credit=fetch('*','user','user_id',$trader_id['trader_id']);//credit
                   //cut mostafed value from trader credit
                if ($credit['online_pay']>0&&$credit['credit']>0) {
                	$newCredit=($credit['credit'])-($o_mostafed['order_mostafed']);
                	$stmt=$conn->prepare(' UPDATE user set credit=?  where user_id=? ');
  	            	$stmt->execute(array($newCredit,$trader_id['trader_id']));
                }
                //set value for partner's program
                if ($prog2['prog2']!=null) {
  	            	$stmt=$conn->prepare(' UPDATE orders set program_credit=?  where order_id=? ');
	            	$stmt->execute(array($tot,$order_id));
	  	        }
	  	        ?>
	  			<div class="block-green">Order Approved<br> You will be redirected to previous page</div> 
	  			<script>setTimeout(function go(){ location.href='dashboard.php?dash=orders';},700);</script>
	  			<?php
	  		}
  	}else{
  		include 'notFound.php';
  	}
  	


//CANCEL CONFIRM AND RETURN ORDER TO UNCONFIRMED
  }elseif ($d=='return') {
  	if (isset($_GET['i'])&&is_numeric($_GET['i'])&&$_GET['i']>0 ) {
  		$order_id=intval($_GET['i']);
  		//return what was cut before
  		$o_mostafed=fetch('order_mostafed','orders','order_id',$order_id);//mostafed value
        $trader_id=fetch('trader_id','orders','order_id',$order_id);//trader_id
        $credit=fetch('*','user','user_id',$trader_id['trader_id']);//credit
        $newCredit=($credit['credit']) + ($o_mostafed['order_mostafed']);

        $stmt1=$conn->prepare(' UPDATE user set credit=?  where user_id=? ');
        $stmt1->execute(array($newCredit,$trader_id['trader_id']));
        if ($stmt1) {
	  		$stmt=$conn->prepare(' UPDATE orders set approve=0 where order_id=? ');
	  		$stmt->execute(array($order_id));
	  		if ($stmt) {
	  			 $stmt3=$conn->prepare(' UPDATE orders set program_credit=0 where order_id=? ');
	  		     $stmt3->execute(array($order_id));
	  		     if ($stmt3) {
	  		     	$stmt4=$conn->prepare(' UPDATE orders set program_credit=0  where order_id=? ');
	            	$stmt4->execute(array($order_id));
	  			?>
	  			<div class="block-green">Order Returned to Unapproved <br> You will be redirected to previous page ...</div>
	  			<script>setTimeout(function go(){ location.href='dashboard.php?dash=orders';},900);</script>
	  		<?php	}
	  			
	  		}
      }

  	}else{
  		include 'notFound.php';
  	}
  



  //DELETE ORDER & return cut value(mostafed rates) back to credit =>from dash=reported
  }elseif ($d=='del') {
	  	 if (isset($_GET['i'])&&is_numeric($_GET['i'])&&$_GET['i']>0  ) {
	  		$order_id=intval($_GET['i']);//order id
	  		    //reurn back mostafed value before deleting order
	  		    $o_mostafed=fetch('order_mostafed','orders','order_id',$order_id);//mostafed value
                $trader_id=fetch('trader_id','orders','order_id',$order_id);//trader_id
                $credit=fetch('*','user','user_id',$trader_id['trader_id']);//credit
                $newCredit=($credit['credit']) + ($o_mostafed['order_mostafed']);

                $stmt1=$conn->prepare(' UPDATE user set credit=?  where user_id=? ');
  	            $stmt1->execute(array($newCredit,$trader_id['trader_id']));
  	            if ($stmt1) {
		  			//delete order
			  		$stmt2=$conn->prepare(' DELETE from  orders  where order_id=? ');
			  		$stmt2->execute(array($order_id));
			  		if ($stmt2) {
			  			?><div class="block-green">Order Deleted <br> You will be redirected to previous page ...</div>
	                     <script>setTimeout(function go(){
	  				       location.href='dashboard.php?dash=orders';
	  			           },1500);</script>
			  			<?php
			  		}
		    	}
	  		
	  	}else{
	  		include 'notFound.php';
	  	}




  //block user OR  trader => stop buying coming from dashboard & dash=reported
  }elseif ($d=='block') {
  	    if (isset($_GET['i'])&&is_numeric($_GET['i'])&&$_GET['i']>0 && isset($_GET['t'])&&is_numeric($_GET['t'])&&$_GET['t']>0 ) {
	  		$user_id=intval($_GET['i']);//buyer(trader or user)
	        $order_id=intval($_GET['t']);//order id
	        //reurn back mostafed value before deleting order
  		    $o_mostafed=fetch('order_mostafed','orders','order_id',$order_id);//mostafed value
            $trader_id=fetch('trader_id','orders','order_id',$order_id);//trader_id
            $credit=fetch('*','user','user_id',$trader_id['trader_id']);//credit
            $newCredit=($credit['credit']) + ($o_mostafed['order_mostafed']);
            $fetchId=fetch('trader','user','user_id',$user_id);
          
            $stmt1=$conn->prepare(' UPDATE user set credit=?  where user_id=? ');
            $stmt1->execute(array($newCredit,$trader_id['trader_id']));
            if ($stmt1) { 
            	//delete order
		  		$stmt2=$conn->prepare(' DELETE from  orders  where order_id=? ');
			  	$stmt2->execute(array($order_id));
			  	 if ($stmt2) { // block user
            	   	  $stmt=$conn->prepare(' UPDATE user set block=1  where user_id=? ');
					  $stmt->execute(array($user_id));
				       if($stmt){
				  			?><div class="block-green"><?php if ($fetchId['trader']==0) { echo 'User'; }else{ echo "Trader";} ?> blocked & Order Deleted  <br> You will be redirected to previous page ...</div>
			                 <script>setTimeout(function go(){ location.href='dashboard.php?dash=reported'; },3000);</script>
				  			<?php
			  			}
			  		 }
	  	    }//END if($stmt1)
        } //END if(isset())




//deactivate buyer or trader => coming from dashboard & dash=reported
}elseif ($d=='ban') {
	if (isset($_GET['i']) && is_numeric($_GET['i'])&&$_GET['i']>0) {
		$user_id=intval($_GET['i']);
		$check=checkItem('user_id','user',$user_id);
		$fetchId=fetch('trader','user','user_id',$user_id);
		if ($check>0) {
			//block buyer
			$stmt=$conn->prepare(' UPDATE user set activate=2  where user_id=? ');
			$stmt->execute(array($user_id));
		       if($stmt){
		  			?><div class="block-green"><?php if ($fetchId['trader']==0) { echo 'Buyer'; }else{ echo "Trader";} ?> deactivated (BANNED)<br> You will be redirected to previous page ...</div>
	                 <script>setTimeout(function go(){
					       location.href='dashboard.php?dash=reported';
				           },3000);</script> 
		  			<?php
	  			}
	    	}
	   } //END if (isset($_GET['i'])




//coimg from dash=mostafed
}elseif ($d=='details') {
	if (isset($_GET['i']) && is_numeric($_GET['i']) && $_GET['i']>0 ) {
		$user_id=intval($_GET['i']);
		$fetchTrData=fetch('*','user','user_id',$user_id);
		//sum order_mostafed
	    $stmt=$conn->prepare(' SELECT sum(order_mostafed) from orders where trader_id=? and approve_date>0 ');
        $stmt->execute(array($fetchTrData['user_id']));$sum_mostafed=$stmt->fetchColumn();


		$stmt=$conn->prepare(' SELECT * from orders 
	    join items on items.item_id=orders.item_id
	    join user on user.user_id=orders.trader_id
		join country on country.country_id=user.country_id
		join state on state.state_id=user.state_id
		join city on city.city_id=user.city_id
		where orders.trader_id=? and orders.approve_date>0 order by orders.approve_date desc  ');
		$stmt->execute(array($user_id));
	    $details=$stmt->fetchAll(); 
	    
	      ?>
	  
	    <div  class="containerDash details">  
		  <span class="containerDash-heading">تقرير عملاء مستفيد </span>
		 
		    <a class="report-print" href="report.php?trader=<?php echo $user_id?>">Print</a>
		    <div class="table-reponsive table-report">
		      <table class="table-manage">
		     	<div dir="rtl">
		     	  <span class="leftxx">اسم العميل :<?php echo $fetchTrData['commercial_name']?></span><span>التليفون  :</span><?php echo '0'.$fetchTrData['phone']?><br>
			      <span class="leftxx">الدولة :<?php echo getCountry($fetchTrData['country_id'],$l)?></span><span class="leftxx">المحافظة :<?php echo getState($fetchTrData['state_id'],$l)?></span><span class="leftxx">المدينة :<?php echo getCity($fetchTrData['city_id'],$l)?></span><span class="leftxx">العنوان  :<?php echo $fetchTrData['address']?></span>
			      <p>مستحقات مستفيد: <?php echo '<b>'.$sum_mostafed.'</b> '.'ج.م.'; ?></p>
			    </div>

			   <thead>
					<tr>
						<td> مستفيد  </td>
						<td> المدينة  </td>
						<td> المحافظة  </td>
						<td> الدولة  </td>
						<td> تليفون  المشتري  </td>
						<td> اسم المشتري  </td>
						<td> تاريخ التحويل  </td>
						<td> كود الخصم  </td>
						<td> اسم المنتج  </td> 
				    </tr>
				</thead>
				<tbody>
					<?php
					if (!empty($details)) {
						foreach ($details as $value) { 
							//mostafed profit 
                            $sum_mostafed=sumFromDb3('order_mostafed','orders','trader_id',$value['user_id'],'approve',1);
							?>
							<tr>
								<td><?php if($value['order_mostafed']==0){echo "تم الدفع ";}else{ echo $value['order_mostafed'];} ?></td>
								<td><?php echo getCity($value['city_id'],$l) ?></td>
								<td><?php echo getState($value['state_id'],$l) ?></td>
								<td><?php echo getCountry($value['country_id'],$l) ?></td>
								<td><?php echo '0'.$value['buyer_phone'] ?></td>
								<td><?php echo $value['buyer_name'] ?></td>
								<td><?php echo date('Y-m-d',$value['approve_date']); ?></td>
								<td><?php echo $value['order_code'] ?></td>
					        	<td><?php echo $value['title'] ?></td>
					        </tr>
					       <!--  -->
					     		<input type="hidden" name="title" value="<?php echo $value['title']?>">
					       <!-- -->
					   <?php }
					 } ?>
				  </tbody>
			   </table>

			   <div dir="rtl">
			   	<p>الرجاء مراجعة التقرير أعلاه والتواصل معنا على  الأرقام الاتية:</p>
			   	<span class="small">ادارة موقع مستفيد: 0103632800</span><br>
			   	<span class="small">فودافون كاش:  01013632800</span><br>

			   	
			   </div>
		    </div>
	    </div>
	    	
  <?php	}


	  //pay partners (in mostfid program) their money
	}elseif ($d=='payPartner') {
		if (isset($_GET['i']) ) {
			$code=$_GET['i'];
			$check=checkItem('program','user',$code);
			$check2=checkItem('prog2','orders',$code);
			$fechId=fetch('user_id','user','program',$code);
			//sum partner's values
            $stmt3=$conn->prepare("SELECT sum(program_credit) FROM orders where prog2=?  and paid=1 ");
		 	$stmt3->execute(array($code));$sum=$stmt3->fetchColumn();
			
			if ($check>0) {
				if ($check2>0) {
					//block buyer
					$stmt=$conn->prepare(' UPDATE orders set program_credit=0  where prog2=? ');
					$stmt->execute(array($code));
				       if($stmt){
				       	 //send him a message
				       	$msg='أرسلنا اليك مبلغ  "'.$sum.'" وهو قيمة رصيدكم في برنامج الشراكة مع مستفيد.';
				       	$date=time();
				       	$stmt=$conn->prepare("INSERT INTO   message(message_text,message_date,message_from,message_to )
					 	                      VALUES (:ztext,:zdate,7,:zto )");
			              $stmt->execute(array(
						   "ztext"    =>   $msg,
						   "zdate"    =>   $date,
						   "zto"      =>   $fechId['user_id']
			               ));
			  			?><div class="block-green"> SUCCESS .. value changed to zero & message sent</div>
		                 <script>setTimeout(function go(){ location.href='dashboard.php?dash=program'; },1400);</script> 
			  			<?php
			  			}
				}else{
					?><span class="block2">Oh! This partner has no orders.</span> <?php
				}
				
			}else{
				?><span class="block2">WRONG! We don't know this code.</span> <?php
			}
		}else{header('location:logout.php');exit();}
	}else{header('location:logout.php');exit();}
	  




}//END session



include $tmpl."footer.inc";


