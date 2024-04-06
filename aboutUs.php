<?php
ob_start();
session_start();
$title='منصة مستفيد | من نحن  ';       //title of the page
$keywords='<meta name="keywords" content=  " مستفيد  ,  اوكازيون   , منتجات , عروض النت   ,  سعر ,  اسعار , تخفيض , تخفيضات , الجمعه ,  عروض اوكازيون   , خصم  , كود خصم   , خصومات  ,  منصة مستفيد  , mostfid  ,عرض   , منصة  ,  شراء  ,  اشترى    " >';
$description='<meta name="description" content=" مستفيد بيقدملك خصومات حقيقية على جميع المنتجات المعروضة بنسب يحددها مستفيد مسبقا تجعل سعرالمنتج على مستفيد أقل من سعره في السوق">';
include 'init.php';
 

?>
<div class="container div-aboutUs"> 
	<div class="sub-container">
		<h2 class=" h2-heading"><?php echo $lang['lafetaSite']?></h2>
		
		<h4 class="h4-aboutUs"><?php echo $lang['aboutUs-h4-1']?></h4>
		<p class="p-aboutUs"><?php echo $lang['aboutUs-p-1']?></p>

		<h4 class="h4-aboutUs"><?php echo $lang['aboutUs-h4-2']?></h4>	
		<p class="p-aboutUs"><?php echo $lang['aboutUs-p-2']?></p>
  </div>
</div>

<?php
 //counter eye to count page visits
 include 'counter.php';
 echo '<span class="eye-counter" id="'.$_SESSION['counterAboutUs'].'"></span>'; 
 ?>

 <!--ajax coner -->
 <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
 <script>
 $(document).ready(function(){
  //ajax call send page views
  var eye=$('.eye-counter').attr('id');
  $.ajax({
  url:"counterInsert.php",
  data:{aboutUs:eye}
     });
   //


	});
	</script>


<?php

include  $tmpl ."footer.inc";
include 'foot.php';
ob_end_flush();