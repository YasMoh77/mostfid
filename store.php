 <?php
 ?>
 <!--photos-->
    <!--<div class="div-input-container2  ">
          <div>
            <input type="file" class="upload alone above"  id=""  name='photo2'  >
            <span class="span-photo"><?php echo $lang['photo2']?> &nbsp;(<?php echo $lang['opt']?>)</span><br>
            <input type="file" class="upload alone above"  id=""  name='photo3'  >
            <span class="span-photo"><?php echo $lang['photo3']?> &nbsp;(<?php echo $lang['opt']?>)</span><br>
          </div>-->
          <!--<div>
            <input type="file" class="upload alone above"  id=""  name='photo4'  >
            <span class="span-photo"><?php echo $lang['photo4']?> &nbsp;(<?php echo $lang['opt']?>)</span><br>
            <input type="file" class="upload alone above"  id=""  name='photo5'  >
            <span class="span-photo"><?php echo $lang['photo5']?> &nbsp; (<?php echo $lang['opt']?>)</span>
         </div>
      </div>-->

      <!--<input type="checkbox" class="terms"  id="terms"  name='terms' required >
      <span class="span-terms"><?php echo $lang['iRead']?> <a href="terms.php"><?php echo $lang['terms']?></a> & <a href="policy.php"><?php echo $lang['priv']?></a></span>-->

<?php ?>

//////////////////////////////////////
//////////////////////////////////////
///////////////////////////////////////////
 //the most ordered products
 //index.php 
 <span>المنتجات   الأكثر طلبا </span>
    <?php
    $stmt=$conn->prepare(" SELECT count(orders.item_id), items.*,state.*,city.*,user.*,orders.*
         FROM orders
       JOIN user        ON orders.user_id=user.user_id
       JOIN items       ON orders.item_id=items.item_id
       JOIN state       ON orders.state_id=state.state_id
       JOIN city        ON orders.city_id=city.city_id
    group by(orders.item_id) ORDER BY  count(orders.item_id)  desc   limit 4");
    $stmt->execute();
    $itemsGET=$stmt->fetchAll();
<?php
/////////////////////////

 /* $dsn='mysql:host=localhost; dbname=mst_fd'; 
    $user='root';
    $password='';*/
    /////////////////صفحة اربح معنا  /////////////
    <?php
session_start();
$title='مستفيد  | اربح معنا ';       //title of the page
include 'init.php';

?>
<div class="div">
  <h3 class="centered above">اربح معنا </h3>
  <p class="bold">برنامج الشراكة مع مستفيد </p>
  <p class="bold">التعريف بالبرنامج: </p>
  <p>يهدف البرنامج الى مساعدتك على تحقيق الربح من خلال قيامك بالتعريف بالموقع وتشجيع أصدقائك ومعارفك لشراء المنتجات والخدمات المعروضة بالموقع عن طريق ادخال الكود الخاص بك عند تقديم طلب الشراء؛ وبالتالي تصبح مشارك لمستفيد في الربح عند اتمام عملية الشراء بنجاح؛ فيتم اضافة الربح المستحق لك عن كل عملية شراء مكتملة الى رصيدك بالموقع.</p>
  <p class="bold">المهمة :</p>
  <p>بعد التسجيل في البرنامج سيتم ارسال كود اليك يكون بمثابة معرف لك؛ وما عليك الا نشر هذا الكود بين اصحابك او من هم في دائرة معارفك أو رواد مواقع التواصل في المجموعات التي تشارك فيها؛ وتذكيرهم بادخال هذا الكود عند تقديم طلب الشراء ليتم تحويل نسبة من أرباح مستفيد الى رصيدك عند اتمام صفقة الشراء.</p>
  <p class="bold">الأرباح: </p>
  <p>يمكنك متابعة أرباحك من مستفيد في صفحة حسابك (أدخل الى :حسابي – أرباحي)؛ مع العلم بأن أرباحك تظهر عندما يصل المبلغ المستحق لك الى 20 ج.م. ؛ بعدها يمكنك الضغط على أيقونة أرسل أرباحي ليتم ارسال المبلغ لك على رقمك المسجل لدينا فى الموقع عبر فودافون كاش.</p>
  <p>تبلغ أرباحك 25% من قيمة الأرباح المستحقة لمستفيد عن كل عملية شراء ناجحة؛ كلما ارتفع سعر المنتج أو الخدمة التي تم شراؤها كلما زادت أرباح مستفيد عن هذه العملية وبالتالي تزيد معها أرباحك</p>
    <p>في حالة نسيانك لرقم الكود الخاص بك؛ ستجده مدونا في صفحة حسابك ( اذهب الى حسابي - برنامج الشراكة  )</p>
 <p>قريبا ان شاء الله يبدأ العمل بالبرنامج </p>

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

