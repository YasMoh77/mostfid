<?php
ob_start();
session_start();
$title='مستفيد | سياسة الخصوصية ';       //title of the page
$keywords='<meta name="keywords" content=  " مستفيد  ,  اوكازيون   , منتجات , عروض النت   ,  سعر ,  اسعار , تخفيض , تخفيضات , الجمعه ,  عروض اوكازيون   , خصم  , كود خصم   , خصومات  ,  منصة مستفيد  , mostfid  ,عرض   , منصة  ,  شراء  ,  اشترى    " >';
$description='<meta name="description" content="تستخدم المعلومات الشخصية المقدمة إلينا عبر موقعنا الإلكتروني في الأغراض الموضحة في هذه السياسة أو على الصفحات ذات الصلة من الموقع. قد نستخدم معلوماتك الشخصية في الأغراض التالية  ">';

include 'init.php';

?>
<div class="div-policy">
<h2><?php echo $lang['priv']; ?></h2>

<p><?php echo $lang['spanhead']; ?></p>
<h5><?php echo $lang['p1'];?></h5>
<p><?php echo $lang['span1'];?></p>
<ul>
	<li><?php echo $lang['li1'];?></li>
	<li><?php echo $lang['li2'];?></li>
	<li><?php echo $lang['li3'];?></li>
	<li><?php echo $lang['li4'];?></li>
	<li><?php echo $lang['li5'];?></li>
	<li><?php echo $lang['li6'];?></li>
	<li><?php echo $lang['li7'];?></li>
</ul>

<h5><?php echo $lang['p2'];?></h5>
<p><?php echo $lang['span2'];?></p>
<ul>
	<li><?php echo $lang['p2li1'];?></li>
	<li><?php echo $lang['p2li2'];?></li>
	<li><?php echo $lang['p2li3'];?></li>
	<li><?php echo $lang['p2li4'];?></li>
	<li><?php echo $lang['p2li5'];?></li>
	
</ul>
<!-- info releasing-->
<h5><?php echo $lang['p3'];?></h5>
<p><?php echo $lang['para3'];?></p>
<!-- info security-->
<h5><?php echo $lang['p4'];?></h5>
<p><?php echo $lang['para4'];?></p>
<!-- changes -->
<h5><?php echo $lang['p5'];?></h5>
<p><?php echo $lang['para5'];?></p>
<!-- third party sites -->
<h5><?php echo $lang['p6'];?></h5>
<p><?php echo $lang['para6'];?></p>
<!-- cookies -->
<h5><?php echo $lang['p7'];?></h5>
<p><?php echo $lang['para7'];?></p>
<!-- in analytics -->
<h5><?php echo $lang['p8'];?></h5>
<p><?php echo $lang['para8'];?></p>
<!-- cookies ads -->
<h5><?php echo $lang['p9'];?></h5>
<p><?php echo $lang['para9-1'];?></p>
<p><?php echo $lang['para9-2'];?></p>
<p><?php echo $lang['para9-3'];?></p>
<p><?php echo $lang['para9-4'];?></p>





</div>

<?php
 //counter eye to count page visits
 include 'counter.php';
 echo '<span class="eye-counter" id="'.$_SESSION['counterPolicy'].'"></span>'; 
 ?>

 <!--ajax coner -->
 <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
 <script>
 $(document).ready(function(){
  //ajax call send page views
  var eye=$('.eye-counter').attr('id');
  $.ajax({
  url:"counterInsert.php",
  data:{policy:eye}
     });
   //


	});
	</script>


<?php
include  $tmpl ."footer.inc";
include 'foot.php';