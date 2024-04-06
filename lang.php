<?php
//session_start();
//header('Cache-control: private'); // IE 6 FIX

if(isset($_GET['lang'])){
	  $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;

}elseif(isset($_SESSION['lang'])){
    $lang = $_SESSION['lang'];

}else{
    $lang = 'ar';
}

//$l=$lang;//to translate database words

switch ($lang) {
// if ENGLISH is available
 /* case 'en':
  $lang_file = 'english.php';
  $style_file = 'en.css';
  break;*/
  
  case 'en':
  $lang_file = 'arabic.php';
  $style_file = 'styleEn.css';
  break;
  
  case 'ar':
  $lang_file = 'arabic.php';
  $style_file = 'style.css';
  break;

  default:
  $lang_file = 'arabic.php';
  $style_file = 'style.css';

}


include 'include/languages/'.$lang_file;
$l=$lang['lang'];
?>
