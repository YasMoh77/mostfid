<?php
ob_start();
session_start();
$title=' مستفيد | الشروط والاحكام  ';       //title of the page
$keywords='<meta name="keywords" content=  " مستفيد  ,  اوكازيون   , منتجات , عروض النت   ,  سعر ,  اسعار , تخفيض , تخفيضات , الجمعه ,  عروض اوكازيون   , خصم  , كود خصم   , خصومات   ,  الشروط    ,   الشروط والاحكام ,  منصة مستفيد  , mostfid  ,عرض   , منصة  ,  شراء  ,  اشترى    " >';
$description='<meta name="description" content="يتوجب عليكم قراءة وفهم و الموافقة على هذه الشروط والأحكام للدخول إلى هذا الموقع وتصفحه و/أو استخدامه.">';

include 'init.php';

?>
<div class="div-policy">

<!-- main heading-->	
<h2><?php echo $lang['terms']; ?></h2> 
<p><?php echo $lang['span1T'];?></p>


<!-- definitions-->
<h5><?php echo $lang['p1T'];?></h5>
<ul>
	<li><?php echo $lang['para1T'];?></li>
	<li><?php echo $lang['para1T2'];?></li>
	<li><?php echo $lang['para1T3'];?></li>
	<li><?php echo $lang['para1T4'];?></li>
</ul>
<!-- age-->
<h5><?php echo $lang['p2T'];?></h5>
<p><?php echo $lang['para2T'];?></p>
<!-- reach -->
<h5><?php echo $lang['p3T'];?></h5>
<ul>
	<li><?php echo $lang['para3T'];?></li>
	<li><?php echo $lang['para3T2'];?></li>
</ul>

<!-- violations -->
<h5><?php echo $lang['p4T'];?></h5>
<p><?php echo $lang['span4T'];?></p>
<ul>
<li><?php echo $lang['para4T'];?></li>
<li><?php echo $lang['para4T2'];?></li>
<li><?php echo $lang['para4T3'];?></li>
<li><?php echo $lang['para4T4'];?></li>
<li><?php echo $lang['para4T5'];?></li>
<li><?php echo $lang['para4T6'];?></li>
<li><?php echo $lang['para4T7'];?></li>
<li><?php echo $lang['para4T8'];?></li>
</ul>
<!-- sign up policy -->
<h5><?php echo $lang['p5T'];?></h5>
<ul>
<li><?php echo $lang['para5T'];?></li>
<li><?php echo $lang['para5T2'];?></li>
<li><?php echo $lang['para5T3'];?></li>
</ul>
<!-- rights -->
<h5><?php echo $lang['p6T'];?></h5>
<ul>
	<li><?php echo $lang['para6T'];?></li>
	<li><?php echo $lang['para6T2'];?></li>
	<li><?php echo $lang['para6T3'];?></li>
</ul>
<!-- responsibility -->
<h5><?php echo $lang['p7T'];?></h5>
<ul>
	<li><?php echo $lang['para7T'];?></li>
	<li><?php echo $lang['para7T2'];?></li>
	<li><?php echo $lang['para7T3'];?></li>
	<li><?php echo $lang['para7T4'];?></li>
	<li><?php echo $lang['para7T5'];?></li>
	<li><?php echo $lang['para7T6'];?></li>
	<li><?php echo $lang['para7T7'];?></li>
	<li><?php echo $lang['para7T8'];?></li>
	<li><?php echo $lang['para7T9'];?></li>
</ul>
<!-- seriousness & positiveness -->
<h5><?php echo $lang['p17T'];?></h5>
<ul>
	<li><?php echo $lang['para17T'];?></li> 
	<li><?php echo $lang['para17T2'];?></li>
</ul>

<?php
if (isset($_SESSION['traderid'])||isset($_GET['d'])&&is_numeric($_GET['d'])&&$_GET['d']==1 ) { ?>
		<!-- promise -->
		<h5><?php echo $lang['prom'];?></h5>
		<p><?php echo $lang['spanProm'];?></p>
		<ul>
		<li><?php echo $lang['paraProm'];?></li>
		<li><?php echo $lang['paraProm2'];?></li>
		<li><?php echo $lang['paraProm3'];?></li>
		</ul>
		<!-- mostafed profits -->
		<!--<h5><?php //echo $lang['m-prof'];?></h5>
		<p><?php //echo $lang['param-prof'];?></p>-->
		<!-- paying mostafed profits  -->
		<!--<h5><?php //echo $lang['pay-m-prof'];?></h5>
		<p><?php //echo $lang['spanPay'];?></p>
		<ul>
		<li><?php //echo $lang['paraPay'];?></li>
		<li><?php //echo $lang['paraPay2'];?></li>
		</ul>-->
		<!-- hiding products -->
		<!--<h5><?php //echo $lang['hide-Prod'];?></h5>
		<p><?php //echo $lang['parHide-prod'];?></p>-->

<?php } ?>
<!-- security -->
<h5><?php echo $lang['p8T'];?></h5>
<p><?php echo $lang['para8T'];?></p>
<!-- no guarantee -->
<h5><?php echo $lang['p9T'];?></h5>
<ul>
	<li><?php echo $lang['para9T'];?></li>
	<li><?php echo $lang['para9T2'];?></li>
	<li><?php echo $lang['para9T3'];?></li>
	<li><?php echo $lang['para9T4'];?></li>
</ul>
<!-- compensation -->
<h5><?php echo $lang['p10T'];?></h5>
<!--<ul>-->
	<p><?php echo $lang['para10T'];?></p>
	<!--<li><?php //echo $lang['para10T2'];?></li>-->
<!--</ul>-->
<!-- external links -->
<h5><?php echo $lang['p11T'];?></h5>
<p><?php echo $lang['para11T'];?></p>
<!-- separate terms -->
<h5><?php echo $lang['p12T'];?></h5>
<p><?php echo $lang['para12T'];?></p>
<!-- changes -->
<h5><?php echo $lang['p13T'];?></h5>
<p><?php echo $lang['para13T'];?></p>
<!-- law -->
<h5><?php echo $lang['p14T'];?></h5>
<p><?php echo $lang['para14T'];?></p>
<!-- ending service -->
<h5><?php echo $lang['p15T'];?></h5>
<p><?php echo $lang['para15T'];?></p>
<!-- deleting account -->
<h5><?php echo $lang['p16T'];?></h5>
<?php
if (isset($_SESSION['traderid'])||isset($_GET['d'])&&is_numeric($_GET['d'])&&$_GET['d']==1 ) { ?>
<p><?php echo $lang['para16T'];?></p>
<?php }else{ ?><p><?php echo $lang['para16T2'];?></p> <?php } ?>







</div>

<?php
 //counter eye to count page visits
 include 'counter.php';
 echo '<span class="eye-counter" id="'.$_SESSION['counterTerms'].'"></span>'; 
 ?>

	<!--ajax coner -->
	<script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
	<script>
	$(document).ready(function(){
	  //ajax call send page views
	  var eye=$('.eye-counter').attr('id');
	  $.ajax({
	  url:"counterInsert.php",
	  data:{terms:eye}
	     });
	   //


	});
	</script>


<?php



include  $tmpl ."footer.inc";
include 'foot.php';
ob_end_flush();