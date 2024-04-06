<?php
ob_start();
session_start();
//abbreviations
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


//checking if request method is 'POST'
  if($_SERVER['REQUEST_METHOD']=='POST') {            
    //store data in variables
      $name    =$_POST['Name'];
      $phone   =$_POST['Phone'];
      $reason1 =isset($_POST['reason'])?$_POST['reason']:0;
      $message =$_POST['message'];
      $code    =$_POST['code'];
      $today=date('Y-m-d');

      //sanitize
      $filteredName   =filter_var(trim($name),FILTER_SANITIZE_STRING);
      $filteredPhone  =filter_var(trim($phone),FILTER_SANITIZE_NUMBER_INT);
      $filteredMessage=filter_var(trim($message),FILTER_SANITIZE_STRING);
      $filteredCode   =filter_var(trim($code),FILTER_SANITIZE_STRING);
        
        if ($reason1==1) {
          $reason='Inquiry';
        }elseif ($reason1==2) {
          $reason='Suggestion';
        }elseif ($reason1==3) {
          $reason='Complaint';
        }elseif ($reason1==4) {
          $reason='Opinion'; 
        }elseif ($reason1==5) {
          $reason='Other reason'; 
        }
 
 
        $error=[];
        //name
        if (strlen($filteredName)<4) {
          $error[]=$lang['enterName'];
        }
        //phone
        /*if( strlen($filteredPhone)!=11 ) { 
          $error[]=$lang['checkPhoneNum'];
        } elseif (empty($filteredPhone) ) {
          $error[]=$lang['enterPhone']; 
        }*/
       

        //PHONE 
          $start=strpos($filteredPhone,'01');
          $start2=strpos($filteredPhone,'3');
          $country=1;

              $result1=phone($country,$filteredPhone);//checks if phone suits country
             // $fetch2=fetch('phone','user','phone',$filteredPhone);
              $fetch2=checkItem('Phone','contact',$filteredPhone);
              if (empty($filteredPhone) ) {
                $error[]=$lang['enterPhone']; 
              }elseif ($result1[0]==2) {
              $error[]=$lang['checkPhoneNum'].' .. '.$lang['insert'].' '.$result1[1].' '.$lang['digit'];
              }elseif ($start!==0) {
              $error[]=$lang['checkPhoneNum'];
              }elseif ($start2===2) {
              $error[]=$lang['checkPhoneNum'];
              }elseif ($fetch2>1) {
              $error[]='عفوا؛ لا يمكنك ارسال مزيد من الرسائل ';
              }

        
        //reason
        if ($reason1==0) {
          $error[]=$lang['whyContact'];
        }

 
        //message
        if (empty($filteredMessage) && strlen($filteredMessage)==0) {
          $error[]=$lang['forgotMsg'];
        }elseif (empty($filteredMessage) && strlen($filteredMessage)==1) {
          $error[]=$lang['checkMsg'];
        }elseif (strlen($filteredMessage)<5) {
          $error[]='الرسالة قصيرة جدا ';
        }elseif (strlen($filteredMessage)>2500) {
          $error[]=$lang['longMsg'];
        }

        //code
        if ($filteredCode!==$_SESSION['codeContact']) {
          $error[]=$lang['wrongCode'];
        }




       if (!empty($error)) {
            foreach ($error as  $value) {
              echo  '<div class="block2 ">'.$value.'</div>';
            }
       }else{
        $stmt=$conn->prepare( " INSERT into contact(Name,Phone,Reason,Message,today)
          values(:zname,:zph,:zre,:zmes,:ztoday)" );
        $stmt->execute(array(
         "zname"  => $filteredName,
         "zph"    => $filteredPhone,
         "zre"    => $reason,
         "zmes"   => $filteredMessage,
         "ztoday" => $today
        ));
        if ($stmt) {
          ?>
          <div class="block-green ">تم الارسال  .. سيتم توجيهك للصفحة الرئيسية  </div> 
          <script>setTimeout(function go(){ location.href='index.php';},3000);</script>
          <?php
        }


        //connect to database
        //array with info
       /* ?> <span class="spinner-border spinner-border-del" role="status" aria-hidden="true"></span> <?php
        $_SESSION['contactUs']=array($filteredName,$filteredPhone,$reason,$filteredMessage);
        ?> <script>location.href='emailContactUs.php';</script> <?php
        */
       }








  }else{ //end $_SERVER['REQUEST_METHOD'] condition
    header('location:login.php');
    exit();
  }


include $tmpl."footer.inc";   
ob_end_flush();