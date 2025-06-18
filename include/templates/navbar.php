<?php
if(!session_id()) { session_start(); }



    if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb
 //session['cart']
if (isset($_SESSION['cart'])&&count($_SESSION['cart'])>0) { $cart=count($_SESSION['cart']);}else{ $cart=0;}



?>
<!------------------------------- Above navbar -------------------------------> 
    <div class="upper-bar">
       <?php if(! isset($session)){ ?>
          <span class="enter ">مقدموا الخدمات  </span><i class="fas fa-sort-down fa-sort1"></i>
          <div class="div-hide-nav-trader pc traderPc">
           <a class="logout-a" href="signinP.php"  >دخول  مقدم خدمة </a>
           <a class="logout-a" href="partnerCheck.php"  >تسجيل مقدم خدمة </a>   
          </div>
          <div id="div1" class="upper-bar-child"><!-- container inside uper bar -->
               <a class="countries hide-mobile" href="index.php"> الرئيسية </a> 
               <a href="aboutUs.php" id="login-nav" class="countries a-one" > من نحن </a> 
               <a href="faq.php"  class="countries ">أسئلة شائعة </a>
               <a href="contactUs.php"  class="countries hide-mobile">اتصل بنا</a>
          </div> 
          <span class="enter2 fas fa-bars enterMob" data-bs-toggle="offcanvas" data-bs-target="#mob" aria-controls="offcanvasWithBothOptions"> </span><span class="enter2 enterPc">دخول  الأعضاء  </span>
          <i class="fas fa-sort-down fa-sort2"></i>
          <div class="div-hide-nav-user pc userPc">
             <a class="logout-a" href="login.php"  >دخول   الأعضاء </a>
             <a class="logout-a" href="signUpU.php"  > تسجيل عضو جديد </a>
          </div>
          <div class="offcanvas offcanvas-start mob" id="mob" data-bs-scroll="true" tabindex="-1" id="mob" aria-labelledby="offcanvasWithBothOptionsLabel">
              <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                 <a class="logout-a " href="signinP.php"  >دخول  مقدم خدمة </a>
                 <a class="logout-a " href="partnerCheck.php"  >تسجيل مقدم خدمة </a>
                 <a class="logout-a" href="login.php"  >دخول   الأعضاء </a>
                 <a class="logout-a" href="signUpU.php"  > تسجيل عضو جديد </a>
              </div>
        </div>
        <?php }else{ ?>
           <div id="div1" class="upper-bar-child-session "><!-- container inside uper bar --> 
               <a class="countries hide-top-a" href="index.php"> الرئيسية </a> 
               <a href="aboutUs.php" id="login-nav" class="countries" > من نحن </a> 
               <a href="faq.php"  class="countries ">أسئلة شائعة </a>
               <a href="contactUs.php"  class="countries hide-top-a ">اتصل بنا</a>
               <?php  $countMsg=countFromDb3('message_id','message','message_to',$session,'message_status',0);
               if(isset($_SESSION['traderid'])){
               if($countMsg>0){ ?><a href="profile.php?i=<?php echo $session?>&p=msg" id='aMsg' class="countries aMsg"><i class="fas red2 fa-envelope"></i></a><input type="hidden" id="sess" value="<?php echo $session ?>"> <?php }
                else{ ?><a class="countries "><i class="fas fa-envelope"></i></a> <?php } } ?>
          </div>
          <?php if($cart>0){ ?><a class="CART" href="cart.php?d=fulfil&t=i&main=g"><span><?php echo $cart; ?></span><i class="fas fa-shopping-cart "></i></a> <?php } ?>
       <?php } ?> 
    </div>
           
<!------------------------------- Main navbar ------------------------------->
<nav class="navbar navbar-light bg-light fixed-top">
  <div class="container-fluid">
    <noscript>
    pls enable js
   </noscript>
   <a href="index.php" class="logo font1">مستفيد</a>
   <div class="middle">
      <a href="index.php?id=#head-pp" class="one font1"> منتجات  </a>
      <a href="index.php?id=#head-ps" class="two font1">خدمات  </a>
      
    </div>
    <?php
    if (!isset($session)) {  ?>
      <span  class="link2 font1">روج لخدماتك ومنتجاتك</span>
      <div class="top-div">
        <a class="font1 bold" href="partnerCheck.php">انضم الينا</a> 
      </div>
   <?php  }else{ ?>
      <!--<span class="name-nav link3 ">أهلا  </span>--><?php 
         // $_SESSION['traderid']
        if(isset($_SESSION['traderid'])){ 
          // my new orders
          $stmt2=$conn->prepare(' SELECT count(order_id) from orders where trader_id=? and approve=1 and seen=0 ');
          $stmt2->execute(array($_SESSION['traderid']));$MyNewOrders=$stmt2->fetchColumn();
          ?>
           <span class="name cut2 font1" data-bs-toggle="offcanvas" data-bs-target="#mob2" aria-controls="offcanvasWithBothOptions"><?php echo $_SESSION['trader']?>&nbsp;<i class="fas fa-sort-down"></i></span>
           <!--///////////////////-->
           <div class="offcanvas offcanvas-start mob" id="mob2" data-bs-scroll="true" tabindex="-1" id="mob2" aria-labelledby="offcanvasWithBothOptionsLabel">
              <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <a class="logout-a " href="profile.php?i=<?php echo $_SESSION['traderid'];?>&p=orders">حسابي</a>
                <a id="ordersLink" class="font1 ordersLinkMobile" href="profile.php?i=<?php echo $_SESSION['traderid']?>&p=orders">طلبات الشراء</a>
                <input type="hidden" id="sess" value="<?php echo $_SESSION['traderid'];?>">
                <?php if($MyNewOrders>0){ echo ' <span class="o_num"><span>'.$MyNewOrders.'</span></span>'; } ?>
                <a class="logout-a " href="logout.php?s=no">تسجيل الخروج</a>
              </div>
           </div>
           <!--//////////////////-->
          <div class="top-div3">
            <a id="ordersLink2" class="font1" href="profile.php?i=<?php echo $_SESSION['traderid']?>&p=orders">طلبات الشراء</a>
            <input type="hidden" id="sess2" value="<?php echo $_SESSION['traderid'];?>">
          </div>
     <?php if($MyNewOrders>0){ echo ' <span class="orderNum"><span>'.$MyNewOrders.'</span></span>'; } ?></span>
          <!-- $_SESSION['userGid'] -->
      <?php }elseif(isset($_SESSION['userGid'])){  
           /*if(isset($_SESSION['googlePic'])){ ?> <img class="imgNav" src='<?php echo $_SESSION['googlePic']; ?>'> <?php }*/
           ?>
           <span class="name cut2" data-bs-toggle="offcanvas" data-bs-target="#mob2" aria-controls="offcanvasWithBothOptions"><?php echo $_SESSION['userG']?>&nbsp;<i class="fas fa-sort-down"></i></span>
            <!--///////////////////-->
           <div class="offcanvas offcanvas-start mob" id="mob2" data-bs-scroll="true" tabindex="-1" id="mob2" aria-labelledby="offcanvasWithBothOptionsLabel">
              <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <a class="logout-a " href="profile.php?i=<?php echo $_SESSION['userGid'];?>&p=data">حسابي</a>
                <a class="logout-a " href="logout.php?s=no">تسجيل الخروج</a>
              </div>
           </div>
           <!--//////////////////-->
            <div class="top-div3">
               <a class="font1" href="search.php?cat=0&state=0&ordering=1">تصفح المنتجات</a>
            </div>
           <!-- $_SESSION['userEid'] -->
      <?php }elseif(isset($_SESSION['userEid'])){ ?>
            <span class="name cut2" data-bs-toggle="offcanvas" data-bs-target="#mob2" aria-controls="offcanvasWithBothOptions"><?php echo $_SESSION['userE']?>&nbsp;<i class="fas fa-sort-down"></i></span>
            <!--///////////////////-->
           <div class="offcanvas offcanvas-start mob" id="mob2" data-bs-scroll="true" tabindex="-1" id="mob2" aria-labelledby="offcanvasWithBothOptionsLabel">
              <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <a class="logout-a " href="profile.php?i=<?php echo $_SESSION['userEid'];?>&p=data">حسابي</a>
                <a class="logout-a " href="logout.php?s=no">تسجيل الخروج</a>
              </div>
           </div>
           <!--//////////////////-->
            <div class="top-div3">
               <a class="font1" href="search.php?cat=0&state=0&ordering=1">تصفح المنتجات</a>
            </div>
          <?php }elseif(isset($_SESSION['userFid'])){  
            if(isset($_SESSION['fbPic'])){ ?> <img class="imgNav" src='<?php echo $_SESSION['fbPic']; ?>'> <?php }
            ?> 
            <span class="name cut2" data-bs-toggle="offcanvas" data-bs-target="#mob2" aria-controls="offcanvasWithBothOptions"><?php echo $_SESSION['userF']?>&nbsp;<i class="fas fa-sort-down"></i></span>
            <!--///////////////////-->
           <div class="offcanvas offcanvas-start mob" id="mob2" data-bs-scroll="true" tabindex="-1" id="mob2" aria-labelledby="offcanvasWithBothOptionsLabel">
              <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <a class="logout-a " href="profile.php?i=<?php echo $_SESSION['userFid'];?>&p=data">حسابي</a>
                <a class="logout-a " href="logout.php?s=no">تسجيل الخروج</a>
              </div>
           </div> 
           <!--//////////////////-->
            <div class="top-div3">
               <a class="font1" href="search.php?cat=0&state=0&ordering=1">تصفح المنتجات</a>
            </div>
           <!-- $_SESSION['userEid'] -->
      <?php } ?>
         

   <?php } ?>
    <!--<div class="top-div2"> 
      <i class="fab fa-whatsapp"></i>
      <i class="fab fa-facebook-messenger"></i> 
      <i class="fas fa-envelope"></i> 
    </div>-->
  </div>
</nav>

<!--ajax coner --> 
   <script type="text/javascript" src="<?php echo $js; ?>jquery-3.6.0.min.js"></script>
   <script>
   $(document).ready(function(){
    $('#ordersLink').click(function(){ 
        var sess=$('#sess').val();
        $.ajax({
        url:'process1.php?d=changeSeen',
        data:{session:sess}
      });
    });
    //
    $('#ordersLink2').click(function(){ 
        var sess2=$('#sess2').val();
        $.ajax({
        url:'process1.php?d=changeSeen',
        data:{session2:sess2}
      }); 
    });
    // when message read
    $('.aMsg').click(function(){ 
        var sess=$('.aMsg').nextAll('#sess').val();
        $.ajax({
        url:'process1.php?d=changeSeenNav',
        data:{sessionNav:sess}
      });
    });
    //
    
       


  });
 </script>



  <?php
         
