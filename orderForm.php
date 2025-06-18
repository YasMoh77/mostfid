<?php
ob_start();
session_start();
//abbreviations
$title='Order';
include 'init.php';




//receiving orders from order.php
?><div class="success-order"> <?php

if (isset($_SESSION['traderid'])) { $session=$_SESSION['traderid']; } //trader
elseif (isset($_SESSION['userEid'])) { $session=$_SESSION['userEid']; } //user email
elseif (isset($_SESSION['userGid'])) { $session=$_SESSION['userGid']; } //user google
elseif (isset($_SESSION['userFid'])) { $session=$_SESSION['userFid']; } //user fb

if ($session) {
  
      if ($_SERVER['REQUEST_METHOD']=='POST') {
         $name   =$_POST['name'];
         $phone  =$_POST['phone'];
         $cat    =$_POST['cat'];
         $sub    =$_POST['sub'];
         $country=1;  
         $state  =$_POST['state'];
         $city   =$_POST['city'];
         $trader_id  =$_POST['trader'];
         $traderPhone=$_POST['traderPhone'];
         $item_id    =$_POST['item'];
         $num        =$_POST['num'];
         $date       =time();
         $prog1=isset($_POST['prog'])&&!empty($_POST['prog'])?$_POST['prog']:0;//program code
        // $prog2=filter_var(trim($prog1),FILTER_SANITIZE_STRING);
         $prog2=htmlspecialchars(trim($prog1));
         $prog=strlen($prog2)==5?$prog2:'';
          
          
         // print_r($mostafed) ;
          $code=rand(1000,10000);

          $filteredName=htmlspecialchars(trim($name));
          $phone=preg_replace('/[^0-9]/', '', $phone);
          $filteredPhone=filter_var($phone,FILTER_VALIDATE_INT);
          $result=phone($country,$filteredPhone);//checks if phone suits country
         
          $error=array();
          //item hidden or not
          for ($i=0; $i <count($item_id) ; $i++) { 
              $fetchHide=fetch('hide','items','item_id',$item_id[$i]);
              if ($fetchHide['hide']>0) {
               $error[]=$lang['notAvail'];
              }
          }
          //blocked or not
          
          for ($a=0; $a <count($item_id) ; $a++) { 
            $fetched=fetch2('*','user','user_id',$session,'block',1);
            $fetchTitle=fetch('title','items','item_id',$item_id[$a]);
            if ($fetched>0) {
             $error[]='<span class="short cut2"> ('.$fetchTitle.')</span> .. لا يمكنك تقديم طلب شراء؛ تم حظرك لعدم جديتك عند تقديم طلبات  لاعلانات سابقة  </span>';
           }
         }
          
         if (!empty($error)) { 
          ?> <div> 
            <?php
               foreach ($error as  $value) {
                   echo '<span class="block2 order-form-notice">'.$value.'</span>';
                }
          ?> </div> <?php 
         }else{ 
          //insert order 
          for ($i=0; $i <count($cat) ; $i++) { 
               $stmt=$conn->prepare(' SELECT * from orders where  user_id=? and item_id=?  and approve=? ');
               $stmt->execute(array($session,$item_id[$i],0));
               $row=$stmt->rowCount();
               $fetchN=fetch('*','items','item_id',$item_id[$i]);
               //mostafed rates
              $fetchS=fetch('*','items','item_id',$item_id[$i]);
              $price=$fetchS['price'];
              $discount=$fetchS['discount'];
              $AfterCutPrice=$price-($price*$discount)/100;
              $sub=$fetchS['subcat_id'];
              
              if ($sub==22||$sub==28||$sub==59||$sub==60||$sub==61) { //22=cloth,28=ceramic,59=electric works,60 painting,61 ceramic works
                 if ($sub==22) {$mostafed1=2;$mostafed=$mostafed1*$num[$i];}else{$mostafed1=3;$mostafed=$mostafed1*$num[$i];}
              }else{
                //.5% of the after discount price is mostafed rate 
                 $mostafed1=$AfterCutPrice*(.5/100);
                 //multiply by quantity
                 $mostafed=($mostafed1*$num[$i]);
              } //END  if ($sub==22||


            if ($row==0) {  
                    $stmt2=$conn->prepare("INSERT INTO  
                    orders(user_id,order_date,buyer_name,num,order_mostafed,buyer_phone,country_id,state_id,city_id,cat_id,subcat_id,item_id,trader_id,trader_phone,order_code,prog2 )
                    VALUES (:zuser,:zdate,:zname,:znum,:zmost,:zphone,:zcont,:zstate,:zcity,:zcat,:zsub,:zitem,:ztrader,:ztrphone,:zcode,:zprog )");
                    $stmt2->execute(array(
                     "zuser"         =>   $session, 
                     "zdate"         =>   $date,
                     "zname"         =>   $filteredName,
                     "znum"          =>   $num[$i],
                     "zmost"         =>   $mostafed,
                     "zphone"        =>   $filteredPhone,
                     "zcont"         =>   $country,
                     "zstate"        =>   $state,
                     "zcity"         =>   $city,
                     "zcat"          =>   $cat[$i],
                     "zsub"          =>   $sub,
                     "zitem"         =>   $item_id[$i],
                     "ztrader"       =>   $trader_id[$i],
                     "ztrphone"      =>   $traderPhone[$i],
                     "zcode"         =>   $code,
                     "zprog"         =>   $prog
                      ));
                    
                    if($stmt2){  ?>
                          <div class='alert alert-success block-green order-form-notice' style="height:50vh;">
                            <?php echo '<span  class="short cut2">( '.$fetchN['title'].')</span>';?>تم استلام  الطلب ؛سنتصل بكم بعد قليل ؛ احتفظ برقم الكود  لكي تحصل على الخصم   ..رقم الكود: <?php echo '&nbsp;'.$code ?>
                          </div>
                        <?php
                        
                      }else{
                         echo $lang['connectFail'];
                         } 
                    
                }else{ // repeated orders ?>
                <div style="height:50vh;">
                <span  class="block2 order-form-notice"> <?php echo '<span class="short cut2">('.$fetchN['title'].')</span>';?>&emsp;تم استلام طلب بخصوص هذا الاعلان وهو  قيد المراجعة؛ سنتصل بكم بعد قليل</span>
                </div>
            
                  <?php   unset($_SESSION['cart']);
                 }//end else
                }//end for
  	              
          
                
              }  // END else => empty error  
           }else{ header('location:index.php');exit(); } //END if($_SERVER['REQUEST'])

      }else{ header('location:index.php');exit(); } //END session

 ?></div> <?php





include  $tmpl ."footer.inc";
include  "foot.php";
 ob_end_flush();
