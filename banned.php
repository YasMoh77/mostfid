<?php
ob_start();
$title='banned';
?>
<link rel="canonical" href="https://www.mostfid.com/terms.php" > 
<?php
include 'init.php';
?>
<div class="height">
<p class="above-lg center darkgrey">هذا المستخدم غير مسموح له  بتسجيل الدخول  لمخالفته  <a href="https://www.mostfid.com/terms.php" target="_blank">الشروط والأحكام  </a></p>
<?php include 'block.php'; ?>
</div>  



<?php
include $tmpl."footer.inc"; 
include 'foot.php';       
ob_end_flush();
