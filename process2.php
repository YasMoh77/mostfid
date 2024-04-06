<?php
//ob_start();
session_start();       //important in every php page
$title='sendEmail';       //title of the page
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




//send item views coming from general.php and other pages having item link
if (isset($_GET['itemView'])) {
  $item_id=$_GET['itemView'];
  $fechViews=fetch('seen','items','item_id',$item_id);
    
  $num=$fechViews['seen']==0?1:$fechViews['seen']+1;
  $stmt2=$conn->prepare(" UPDATE items set seen=? WHERE item_id=? ");
  $stmt2->execute(array($num,$item_id) );
     
}//END if (isset($_GET['itemView']))





//Cancel Order
if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google 
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

if (isset($session) ) { //IF THERE IS A SESSION
  if (isset($_GET['c'])&&isset($_GET['i'])&&isset($_GET['r'])  ) {
    include $tmpl.'navbar.php';
     if ($_GET['c']=='cancelOrder' && is_numeric($_GET['i']) && $_GET['i']>0 && is_numeric($_GET['r']) && $_GET['r']>0 ) {
         $user_id=intval($_GET['i']);
         $order_id=intval($_GET['r']);
         $checkOrder=checkItem2('order_id','orders',$order_id,'approve',0);
         if ($checkOrder==0) {
          ?>
          <div class="height cancelOrder">
             <a class="rightxx alone above-md" href="profile.php?i=<?php echo $user_id?>&p=bought"></a>
             <div class="block2">لا يمكنك  الغاء  هذا الطلب؛ تم قبوله بواسطة ادارة الموقع <br> سيتم توجيهك  للصفحة السابقة  ...</div>
             <script>setTimeout(function direct(){location.href="profile.php?i=<?php echo $user_id?>&p=bought"},6000);</script>
          </div>
          <?php
         }else{
         $stmt=$conn->prepare(" DELETE  from orders where order_id=? "); 
         $stmt->execute(array($order_id));
         if ($stmt) {
        ?>
        <div class="height">
          <a class="rightxx alone above-md" href="profile.php?i=<?php echo $user_id?>&p=bought"></a>
          <div class="block-green">تم الغاء الطلب   <br> سيتم توجيهك  للصفحة السابقة  ...</div>
           <script>setTimeout(function direct(){location.href="profile.php?i=<?php echo $user_id?>&p=bought"},4000);</script>
        </div>
    <?php } }


     }else{
      include 'notFound.php';  
     }
     include 'foot.php';





     //cancel report trader => coming from profile-bought
  }elseif (isset($_GET['Bought']) && is_numeric($_GET['Bought'])&&$_GET['Bought']>0 ) {
         include $tmpl.'navbar.php';
          $order_id=intval($_GET['Bought']);
          $stmt=$conn->prepare(" UPDATE orders set report_trader=0,report_value='' WHERE order_id=? ");
          $stmt->execute(array($order_id) );
          if ($stmt) { ?>
              <div class="height above-lg cancelReTr">
                <div class="block-green">تم  الغاء التبليغ ... </div>
                <script>setTimeout(function go(){ location.href="profile.php?i=<?php echo $session;?>&p=bought"},2500);</script>
              </div>
                
        <?php  }

     include 'foot.php';

  


//report comment => from details.php
}elseif (isset($_GET['comid'])&& is_numeric($_GET['comid']) && isset($_GET['reporter']) && is_numeric($_GET['reporter'])  ) {
  $comment_id=intval($_GET['comid']);
  $reporter=intval($_GET['reporter']);

    $stmt=$conn->prepare(" SELECT comment_id from reportcomm WHERE comment_id=? ");
      $stmt->execute(array($comment_id) );
      $comm=$stmt->rowCount();

      if ($comm>0) {
        $stmt2=$conn->prepare(" SELECT comment_id from reportcomm WHERE comment_id=? and value=1 ");
        $stmt2->execute(array($comment_id) );
        $comm2=$stmt2->rowCount();
           if ($comm2>0) {
            $stmt2=$conn->prepare(" UPDATE reportcomm set value=0 WHERE comment_id=? ");
            $stmt2->execute(array($comment_id) );
           }else{
            $stmt2=$conn->prepare(" UPDATE reportcomm set value=1 WHERE comment_id=? ");
              $stmt2->execute(array($comment_id) );
           }
      }else{ //not found -> insert
         $stmt=$conn->prepare("INSERT INTO  
            reportcomm(comment_id,value,user_id  )
            VALUES (:zcomm,1,:zuser )");
             $stmt->execute(array(
               "zcomm"          =>   $comment_id,
               "zuser"           =>   $reporter
                 ));
             }




//reply to or delete messages => from profile.php
}elseif (isset($_GET['msg'])) {
   if ($_GET['msg']=='reply') { //reply to message
     if (isset($_GET['i']) && is_numeric($_GET['i']) &&$_GET['i']>0 ) {
       $msgid=intval($_GET['i']);
        
     }else{include 'notFound.php';}

   }elseif ($_GET['msg']=='del') { //delete message
     include $tmpl.'navbar.php';
     if (isset($_GET['i']) && is_numeric($_GET['i']) &&$_GET['i']>0 ) {
       $msgid=intval($_GET['i']);
       $getMsg=fetch('message_id','message','message_id',$msgid);
       if ($getMsg['message_id']>0) {
             $stmt=$conn->prepare(" DELETE  from message where message_id=? "); 
             $stmt->execute(array($getMsg['message_id']));
               if ($stmt) { ?>
              <div class="height">
                <a class="rightxx alone above-md" href="profile.php?i=<?php echo $session?>&p=msg"></a>
                <div class="block-green">تم حذف الرسالة <br> سيتم توجيهك  للصفحة السابقة  ...</div>
                 <script>setTimeout(function direct(){location.href="profile.php?i=<?php echo $session?>&p=msg"},3500);</script>
              </div>
          <?php }
       }else{ ?><div class="height"><div class="block2">عفواً؛ لم نعثر على هذه الرسالة  </div></div> <?php }

        
     }else{include 'notFound.php';}
      include 'foot.php';

      
   }else{
     include 'notFound.php';
   }


}else{
    include $tmpl.'navbar.php';
      include 'notFound.php';
    include 'foot.php';
  }




}//END session




include $tmpl."footer.inc"; 
