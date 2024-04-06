<?php
ob_start();
session_start();
$title='Homepage';       //title of the page
//abbreviations
$tmpl='include/templates/';
$css='layout/css/';
$js='layout/js/';
$images='layout/images/';
$fonts='layout/fonts/';
$language='include/languages/';
$func='include/functions/';
//important files
include 'lang.php';
include $tmpl."header.inc";
include 'connect.php'; //this file connects to database
include $func.'functions.php';




if( isset($_GET['sentCats'])&& isset($_GET['l'])  ){
   $Cat=$_GET['sentCats'];
   $l=$_GET['l'];//language

                 $stmt=$conn->prepare(" SELECT * from sub
                 join categories on categories.cat_id=sub.cat_id
                 where categories.cat_id=?  ");
                 $stmt->execute(array($Cat));
                 $sub=$stmt->fetchAll();
             
              if (!empty($sub)) {
                         ?><option value="0">اختر</option> <?php
                      if($l=='ar'){
                          foreach ($sub as  $val) {//if($l=='ar'){echo $val['subcat_nameAR'];}else{echo $val['subcat_name'];} echo
                                echo "<option id='li-cat' class='subitem'  value=".$val['subcat_id'].">".$val['subcat_nameAR']."</option>";
                          }                   
                       
                     }elseif ($l=='en') {
                          foreach ($sub as  $val) {//if($l=='ar'){echo $val['subcat_nameAR'];}else{echo $val['subcat_name'];} echo
                                echo "<option id='li-cat' class='dropdown subitem'  value=".$val['subcat_id'].">".$val['subcat_name']."</option>";
                         }
                     }


              }else{
                   echo "<option>لا توجد أقسام فرعية</option>";
              }
                  
       }








include  $tmpl ."footer.inc";
 ob_end_flush();
 ?>