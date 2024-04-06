<?php
session_start();
$title='مستفيد  | اربح معنا ';       //title of the page
$keywords='<meta name="keywords" content=  " مستفيد  ,  اوكازيون   , منتجات , عروض النت   ,  سعر ,  اسعار , تخفيض , تخفيضات , الجمعه ,  عروض اوكازيون   , خصم  , كود خصم   , خصومات   ,  الشروط    ,   الشروط والاحكام ,  منصة مستفيد  , mostfid  ,عرض   , منصة  ,  شراء  ,  اشترى    " >';
$description='<meta name="description" content="تابع الصفحة لمعرفة الجديد">';

include 'init.php';

?>
<div class="prizes-div"> 
  <h3 class="centered above-md bottom-lg">اربح معنا </h3>
 <p>تابع الصفحة لمعرفة الجديد </p>
  <!--<h2 class="mosprize">
    <p class="bold inline ">مسابقة مستفيد </p><span class="red2 inline">جديد </span>
  </h2>
  <p class="bold">بداية المسابقة: </p>
  <p>   13 مارس 2023 م </p>
  <p>21 شعبان 1444 هـ  </p>
  <p>قريبا ان شاء الله </p>
  <p class="bold">نهاية المسابقة: </p>
  <p> 10 رمضان  1444هـ </p>
  <p>لم  يتم التحديد بعد </p>
  <p class="bold">الجائزة: </p>
  <p>500 جنية مصري  </p>
  <p class="bold">الشروط: </p>
  <p>اشترك بخطوة أو أكثر من الخطوات الاتية  </p>
  <ul>
    <li>اذكر رأيك في منصة مستفيد من خلال صفحة اتصل بنا (فرصة واحدة للفوز) </li>
    <li>سجل الدخول الى منصة مستفيد (يمكنك الدخول بجوجل؛ فيسبوك أو البريد الالكتروني) ( فرصة  واحدة للفوز) </li>
    <li>اذكر اقتراح او فكرة لتطوير الموقع  من خلال صفحة اتصل بنا ( فرصة واحدة للفوز)  </li>
    <li>اشتري منتج أو خدمة من منصة مستفيد  (10 فرص للفوز) </li>
    <li>أضف منتج أو خدمة الى منصة مستفيد  (10 فرص للفوز) </li>
  </ul>
  <p class="bold">التفاصيل: </p>
  <p class="bottom-lg">يتم تجميع فرص الفوز؛ واجراء السحب في الموعد  المذكور ان شاء الله الكترونيا عن طريق الحاسب الآلي؛  ويتم تسليم الجائزة للفائز بصفة شخصية  اذا كان داخل مدينة قنا أو ارسالها له عن طريق فودافون كاش   اذا كان خارجها . وسيتم الاعلان عن اسم الفائز في هذه الصفحة وفي وسائل التواصل  </p>
 
  
  <p class="bold">برنامج الشراكة مع مستفيد </p>
  <p class="bold">التعريف بالبرنامج: </p>
  <p>يهدف البرنامج الى مساعدتك على تحقيق الربح من خلال قيامك بالتعريف بالموقع وتشجيع أصدقائك ومعارفك لشراء المنتجات والخدمات المعروضة بالموقع عن طريق ادخال الكود الخاص بك عند تقديم طلب الشراء؛ وبالتالي تصبح مشارك لمستفيد في الربح عند اتمام عملية الشراء بنجاح؛ فيتم اضافة الربح المستحق لك عن كل عملية شراء مكتملة الى رصيدك بالموقع.</p>
  <p class="bold">المهمة :</p>
  <p>بعد التسجيل في البرنامج سيتم ارسال كود اليك يكون بمثابة معرف لك؛ وما عليك الا نشر هذا الكود بين اصحابك او من هم في دائرة معارفك أو رواد مواقع التواصل في المجموعات التي تشارك فيها؛ وتذكيرهم بادخال هذا الكود عند تقديم طلب الشراء ليتم تحويل نسبة من أرباح مستفيد الى رصيدك عند اتمام صفقة الشراء.</p>
  <p class="bold">الأرباح: </p>
  <p>يمكنك متابعة أرباحك من مستفيد في صفحة حسابك (أدخل الى :حسابي – أرباحي)؛ مع العلم بأن أرباحك تظهر عندما يصل المبلغ المستحق لك الى 20 ج.م. ؛ بعدها يمكنك الضغط على أيقونة أرسل أرباحي ليتم ارسال المبلغ لك على رقمك المسجل لدينا فى الموقع عبر فودافون كاش.</p>
  <p>تبلغ أرباحك 25% من قيمة الأرباح المستحقة لمستفيد عن كل عملية شراء ناجحة؛ كلما ارتفع سعر المنتج أو الخدمة التي تم شراؤها كلما زادت أرباح مستفيد عن هذه العملية وبالتالي تزيد معها أرباحك</p>
    <p>في حالة نسيانك لرقم الكود الخاص بك؛ ستجده مدونا في صفحة حسابك ( اذهب الى حسابي - برنامج الشراكة  )</p>
   <p>قريبا ان شاء الله يبدأ العمل بالبرنامج </p>-->

<?php 
/*if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

if (isset($session)) {
    $fetchPhone=fetch('phone','user','user_id',$session);
    if ($fetchPhone['phone']>0) {

  ?>
  <p>للاشتراك أدخل رقم تليفونك المسجل لدينا في الموقع  ثم اضغط موافق </p>
  <form id="formProg">
    <input type="text" class="phoneProg" name="phoneProg" placeholder="أدخل رقمك المسجل في الموقع " autocomplete="off">
    <button class="button-all" type="submit">موافق </button>
    <p class="show red2"></p>
  </form>

  <?php
  

?>
<!--ajax coner -->
       <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
       <script>
       $(document).ready(function(){
        $("#formProg").on("submit", function(e){
          e.preventDefault();
          var phone=$('.phoneProg').val();
          var phoneLen=$('.phoneProg').val().length;
          if(phone==0){
            $('#formProg> button').addClass('disabled',true);
          }else if(phoneLen!=11){
            $('.show').text('الرقم غير صحيح ');
          }else{
          $.ajax({ 
          method:"POST",
          url:'reportItem.php', 
          beforeSend:function(){
            $('#formProg> button').append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            $('#formProg> button').addClass('disabled',true);
          },
          processData:false,
          contentType:false,
          data:new FormData(this),
          success: function(data){                             
            $(".show").html(data);
             },
             complete:function(){
              $('#formProg> button').removeClass('disabled',true);
              $('.spinner-border').remove();
             }
           });
           } // END else
        });
        //
        




        });
    </script>

     <?php 
    }else{ ?><span>للاشتراك في البرنامج؛  يجب تحديث بياناتك  واستكمال البيانات الناقصة؛ لتحديث بياناتك اذهب الى: حسابي - بياناتي  </span><?php }


 }else{ //END is session
   ?><span>للاشتراك  في البرنامج </span><a href="login.php">سجل الدخول </a><span>أو </span><a href="signUpU.php">أنشيء حساب  </a><?php
 }
*/
?></div><?php
//counter eye to count page visits
 include 'counter.php';
 ?><span class="eye-counter" id='<?php echo $_SESSION['counterPrizes']?>'></span><!--span class="fas fa-eye eye-counter"></span>-->





<!--ajax coner -->
<script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
//ajax call 
  var eye=$('.eye-counter').attr('id');
  $.ajax({
  url:"counterInsert.php",
  data:{prizes:eye}
     });
   //

   });
 </script>



<?php
include  $tmpl ."footer.inc";
include 'foot.php';