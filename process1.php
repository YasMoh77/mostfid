<?php
ob_start();
session_start();       //important in every php page
$title='Action';       //title of the page
$tmpl='include/templates/';
$css='layout/css/';
$js='layout/js/';
$images='layout/images/';
$fonts='layout/fonts/';
$language='include/languages/'; 
$func='include/functions/';
//important files
include 'lang.php'; //must be before header or header words fail.
include $tmpl."header.inc";
include 'connect.php'; //this file connects to database
include $func.'functions.php';



//unserious buyers reported by traders
if (isset($_SESSION['traderid'])) {  //trader
	$d=isset($_GET['d'])?$_GET['d']:'nothing'; 
    if($d=='report'){
    include $tmpl.'navbar.php';
	//report
	if (isset($_GET['r']) && is_numeric($_GET['r']) && $_GET['r']>0 && isset($_GET['tr']) && is_numeric($_GET['tr']) && $_GET['tr']>0 && $_GET['tr']==$_SESSION['traderid'] ) {
		 $order_id=intval($_GET['r']);//order
		$fetchNum=fetch('num','orders','order_id',$order_id);
		?>
		<form class="form-rep above-lg" action="action.php" method="POST">
			<p>اختر سبب التبليغ </p> 
			<div><input type="radio" class="noSell" name="noSell" value="1" >&emsp;<span>لم تتم عملية الشراء  </span></div>
			
			<?php if($fetchNum['num']==1){ ?><div><input title="هذا الاختيار لا يناسب  الطلب  " type="radio" class="qnChange" name="qnChange" value="1"  disabled="">&emsp;<span>الكمية التي تم شراؤها أقل من الكمية المذكورة في طلب الشراء </span></div> <?php } 
            else{ ?><div><input type="radio" class="qnChange" name="qnChange" value="1" >&emsp;<span>الكمية التي تم شراؤها أقل من الكمية المذكورة في طلب الشراء </span></div> <?php }
			?>
			
			<div class="Process1R above below"> 
                <span class="none">أدخل الكمية التي تم شراؤها  منكم  </span>
				<input class="none" type="number" name="qnty" min='0' <?php if($fetchNum['num']==3){ ?>max="2"<?php }elseif($fetchNum['num']==2){ ?>max="1"<?php } ?> value='0'>
			</div>
			<input type="hidden" name="reportBuyer">
			<input type="hidden" name="order_id" value="<?php echo $order_id ?>">
			<input type="hidden" class="lang" value="<?php echo $l; ?>">
			<button class="confirmReport button-all" type="submit">ارسل  </button>
        </form> 
		<?php
		

	}else{
		header('location:logout.php?s=no');
		exit();
	}
   include 'foot.php';





   }elseif ($d=='unreport') {
   	include $tmpl.'navbar.php'; 
   	//CANCEL report
	if (isset($_GET['r']) && is_numeric($_GET['r']) && $_GET['r']>0 && isset($_GET['tr']) && is_numeric($_GET['tr']) && $_GET['tr']>0 && $_GET['tr']==$_SESSION['traderid'] ) {
		$order_id=intval($_GET['r']);
		?>
		<div class="height"> 
		<form class="form-rep above-lg" action="action.php" method="POST">
			<p>تأكيد سبب  التراجع عن التبليغ </p> 
			<div><input type="checkbox"  name="sold" value="1" >&emsp;<span>تمت  عملية الشراء  </span></div>
			<input type="hidden" name="unreport">
			<input type="hidden" name="order_id" value="<?php echo $order_id ?>">
			<input type="hidden" class="lang" value="<?php echo $l; ?>">
			<button class="confirmUnreport button-all above" type="submit">ارسل  </button>
        </form>
        </div>
		<?php

	}else{
		header('location:logout.php?s=no');
		exit();
	}
   include 'foot.php';




   //change orders to seen and clear their num on navbar&profile => coming from navbar
   }elseif ($d=='changeSeen') {
		if (isset($_GET['session'])) {
			 $trader_id=$_GET['session'];
			 $fetchTr=fetch('trader_id','orders','trader_id',$trader_id);
			 if ($fetchTr['trader_id']>0 ) {
			 	$stmt=$conn->prepare(" UPDATE orders set seen=1 where  trader_id=? ");
		        $stmt->execute(array($trader_id));
			 }
		}elseif (isset($_GET['session2'])) {
			 $trader_id=$_GET['session2'];
			 $fetchTr=fetch('trader_id','orders','trader_id',$trader_id);
			 if ($fetchTr['trader_id']>0 ) {
			 	$stmt=$conn->prepare(" UPDATE orders set seen=1 where  trader_id=? ");
		        $stmt->execute(array($trader_id));
			 }
		}
     


   //change seen fa-envelope in navbar
   }elseif ($d=='changeSeenNav') {
   	  if (isset($_GET['sessionNav'])) {
			 $trader_id=$_GET['sessionNav'];
			 $fetchTr=fetch('message_to','message','message_to',$trader_id);
			// if ($fetchTr['message_to']>0 ) {
			 	$stmt=$conn->prepare(" UPDATE message set message_status=1 where  message_to=? ");
		        $stmt->execute(array($trader_id));
			// }
		}
     
   

   }else{
   	 include $tmpl.'navbar.php';
     header('location:logout.php?s=no');
	 exit();
     include 'foot.php';
   }










}else{ //END if session
	header('location:logout.php?s=no');
	exit();
}






include $tmpl."footer.inc";
ob_end_flush();
