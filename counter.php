<?php 
 
//details.php  
$GetDetails=fetch('value','page_views','page_name','details');$_SESSION['counterDetails']=$GetDetails['value']+1; 
//search.php
$GetSearchK=fetch('value','page_views','page_name','searchK');$_SESSION['counterSearchK']=$GetSearchK['value']+1; 
$GetAside=fetch('value','page_views','page_name','searchAside');$_SESSION['counterSearchAside']=$GetAside['value']+1; 
//index.php
$GetIndex=fetch('value','page_views','page_name','index');$_SESSION['counterIndex']=$GetIndex['value']+1; 
//general.php
$GetGeneral=fetch('value','page_views','page_name','general');$_SESSION['counterGeneral']=$GetGeneral['value']+1; 
//service.php
$GetService=fetch('value','page_views','page_name','service');$_SESSION['counterService']=$GetService['value']+1; 
//faq.php
$GetFaq=fetch('value','page_views','page_name','faq');$_SESSION['counterFAQ']=$GetFaq['value']+1; 
//aboutUs.php
$GetAboutUs=fetch('value','page_views','page_name','aboutUs');$_SESSION['counterAboutUs']=$GetAboutUs['value']+1; 
//contactUs.php
$GetContactUs=fetch('value','page_views','page_name','contactUs');$_SESSION['counterContactUs']=$GetContactUs['value']+1; 
//policy.php
$GetPolicy=fetch('value','page_views','page_name','policy');$_SESSION['counterPolicy']=$GetPolicy['value']+1; 
//terms.php
$GetTerms=fetch('value','page_views','page_name','terms');$_SESSION['counterTerms']=$GetTerms['value']+1; 
//map.php
//if (empty($_SESSION['counterMap'])) {$_SESSION['counterMap']=1;}else{$_SESSION['counterMap']+=1;}
//countries.php
//if (empty($_SESSION['counterCountries'])) {$_SESSION['counterCountries']=1;}else{$_SESSION['counterCountries']+=1;}
//prizes.php
$GetPrizes=fetch('value','page_views','page_name','prizes');$_SESSION['counterPrizes']=$GetPrizes['value']+1; 
//order.php
$GetOrder=fetch('value','page_views','page_name','order');$_SESSION['counterOrder']=$GetOrder['value']+1; 





