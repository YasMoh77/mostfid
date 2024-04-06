<?php
ob_start();
session_start();       //important in every php page
$title='مستفيد | تسجيل مقدم خدمة ';       //title of the page
$keywords='<meta name="keywords" content="   عرض   , منصة  ,  شراء  ,  اشترى  ,  سعر ,  اسعار ,  دروس , عرض , اجهزة , خصم , تخفيضات , الجمعة  ,  نقل , ترجمة  , عروض   , مطلوب   , خصم  , كود خصم   , خصومات      ">';
$description='<meta name="description" content="لو عندك منتج او خدمة بتقدم عليها خصم اعرضها مجانا على منصة مستفيد؛ مستفيد بيروج لمنتجاتك او خدماتك وبيساعد المشتري انه يشتري بسعر ميسر؛ انضم الى مستفيد وكن من الميسرين  ">';

include 'init.php';   //included files
	
 

?>
<form class="center" id="form-check-trader" action="signUpTrader.php" method="POST" >
   <p class="centered red2"> الرجاء التواصل مع ادارة الموقع لتسجيلك في قاعدة  البيانات واعطائك كلمة سر مؤقتة</p>
	 <div class="centered">
    <i class="fas fa-phone"></i>&ensp;<span>01013632800</span>
  </div>

   <p class="centered bottom-md p-check">اذا كنت قد  قمت بهذه الخطوة؛  املأ الحقول أدناه</p>
   <div class="centered">
     <input type="text" name="phoneCheck" id="phoneCheck" class="phone-check-trader" placeholder="أدخل رقم تليفونك المحمول">
     <span class="guide red2 "></span>
     <div class="p-check-eye">
       <input type="password" name="passCheck" id="passCheck"  class="inputPassword phone-check-trader2" placeholder="أدخل كلمة السر المؤقتة" autocomplete="off">
  	   <i class="fas fa-eye showPassAddOpen"></i><i class="fas fa-eye-slash showPassAddClosed"></i>
     </div>
     <span class="guide2 red2"></span>
     <button class="btn-check-trader" type="submit">أرسل  </button>
  </div> 
</form>

<div class="show-check-trader centered"></div>

<?php




include $tmpl."footer.inc";   
include "foot.php";        
ob_end_flush();

