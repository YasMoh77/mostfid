<?php

//TITLE FUNCTION
function getTitle() {
	global $title;

if (isset($title)) {   //if this vaiable is found in a page
	echo $title;
}else{                 //if it isn't found in a page
	echo 'Lafetaa';
}
 }

 
 /********************* SATART REDIRECT FUNCTIONS  ***********************/
//redirect to previous page (on success)
 function redirectSimple($redirectMsg){	
		$url=$_SERVER['HTTP_REFERER'];		
		echo   $redirectMsg.'<br>'; 
		header("refresh:7; url=$url");
		exit();
}
//redirect to previous page (on success)
function redirect($redirectMsg){	
		$url=$_SERVER['HTTP_REFERER'];		
	    echo "<div class='container'> " ;
		echo   "<div class='alert alert-success'>".$redirectMsg.'<br>'; 
		echo 'Youll be directed to pevious page';
		header("refresh:7; url=$url");
		//exit();
		echo "</div> " ;
}

    //redirect to previous page (on error)
function redirectErr($redirectMsgErr){
	     $url=$_SERVER['HTTP_REFERER'];		
	    echo "<div class='container'> " ;
		echo "<div class='alert alert-danger'>". $redirectMsgErr."</div><br>";
		echo "<div class='alert alert-info'>Youll be directed to pevious page </div>";		 
		header("refresh:7; url=$url");
		//exit();
		echo "</div> " ;
}

//redirect to index
function redirectHome($redirectHomeMsg){		
	    echo "<div class='container'> " ;
		echo "<div class='alert alert-danger'>". $redirectHomeMsg."</div>" ;
		header('refresh:3; url=index.php');
		exit();
		echo "</div> " ;
}
/********************* END REDIRECT FUNCTIONS  ***********************/
//fetch anything
function fetch($field, $table, $field2, $value){ 
     global $conn;
     $stmt=$conn->prepare("SELECT $field FROM $table WHERE $field2 = ?");
     $stmt->execute(array($value));
	 return $stmt->fetch();  
}

//fetch anything 2
function fetch2($field,$table,   $field2,$value2,   $field3,$value3){
     global $conn;
     $stmt=$conn->prepare("SELECT $field FROM $table WHERE $field2=? and $field3=? ");
     $stmt->execute(array($value2,$value3));
   return $stmt->fetch();  
}

//fetch anything 2
function fetch3($field,$table,   $field2,$value2,   $field3,$value3,  $field4,$value4){
     global $conn;
     $stmt=$conn->prepare("SELECT $field FROM $table WHERE $field2=? and $field3=?  and field4=? ");
     $stmt->execute(array($value2,$value3,$value4));
   return $stmt->fetch();  
}

//checkItem function(suitable for add&insret)
function checkItem($field, $table, $value){
     global $conn;
     $stmt=$conn->prepare("SELECT $field FROM $table WHERE $field = ?  ");
     $stmt->execute(array($value));
	 return $stmt->rowCount();  
}

//checkItem2 function(suitable for edit&update)
function checkItem2($field, $table,$field2,$value,$value2){
     global $conn;
     $stmt=$conn->prepare("SELECT $field FROM $table WHERE $field = ? AND $field2=?");
     $stmt->execute(array($value,$value2));
	 return $stmt->rowCount();  
}


//count function
function countFromDb($field, $table){
	global $conn;
	$stmt3=$conn->prepare("SELECT COUNT($field) FROM $table");
	$stmt3->execute();
	return $stmt3->fetchColumn();
}

//count2 function
function countFromDb2($field, $table,$field2,$value2){
	global $conn;
	$stmt3=$conn->prepare("SELECT COUNT($field) FROM $table
		where $field2 $value2 ");
	$stmt3->execute();
	return $stmt3->fetchColumn();
}

//count3 function
function countFromDb3($field,$table,  $field2,$value2,  $field3,$value3){
  global $conn;
  $stmt3=$conn->prepare("SELECT COUNT($field) FROM $table
    where $field2 $value2 and $field3=$value3 ");
  $stmt3->execute();
  return $stmt3->fetchColumn();
}

//sum from sumFromDb3
function sumFromDb3($field, $table, $field2,$value, $field3,$value2){
  global $conn;
  $stmt3=$conn->prepare("SELECT sum($field) FROM $table 
    where $field2 = $value and $field3 = $value2 ");
  $stmt3->execute();
  return $stmt3->fetchColumn();
}

//the latest(users)function 
function theLatest($field, $table, $order, $limit){
	global $conn;
	$stmt=$conn->prepare("SELECT $field  FROM  $table  ORDER BY $order DESC  LIMIT $limit");
	$stmt->execute();
	return $stmt->fetchAll();
}


//the latest function 2
function theLatest2($numComms){
	global $conn;               
	$stmt=$conn->prepare("SELECT comments.*,user.*,items.*
	FROM comments
	INNER JOIN user
	ON comments.user_id=user.user_id
	 INNER JOIN items
	ON comments.item_id=items.item_id
	ORDER BY comments.c_id DESC LIMIT $numComms  ");
	$stmt->execute();
	return $stmt->fetchAll();
}


function getAll($field, $table,$where=NULL,$and=NULL,$orderField,$sorting='ASC') {
	
   global $conn;
   $stmt=$conn->prepare("SELECT $field FROM $table 
   	 where $where And $and ORDER BY $orderField  $sorting ");
   $stmt->execute();
   return $stmt->fetchAll();
}

function innerjS (){
	global $conn;
  $stmt=$conn->prepare("SELECT 
                        items.*,
                        categories.name,
                        admins.*
                        FROM
                        items
                        INNER JOIN categories 
                        ON categories.cat_id=items.CAT_ID
                        INNER JOIN admins
                        ON admins.user_id=items.USER_ID
                        ORDER BY item_id DESC 
                        ");
				$stmt->execute();
				 return $stmt->fetchAll(); 
}


//FROM LAFETAA
//get date 
 function getDate2($item,$lng){           
     $past= $item;
     $l=$lng;
     global $l;
     global $lang;
 //$now=time();
 $oo= time()-($past);

 $year =round($oo/60/60/24/365);
 $month =round($oo/60/60/24/30);
 $day   =round($oo/60/60/24);
 $hour =round($oo/60/60);
 $minute=round($oo/60);

    	if($year==1){
           $result= $lang['yearAgo'];
    	}elseif($year>1){
            if($l=='ar'){$result= 'منذ  '.$year.' سنة  ';}else{$result= $year.'years ago';} ;
    	}elseif ($month==1) {
    		$result= $lang['monthAgo'];
    	}elseif ($month>1&&$month<365) {
    		if($l=='ar'){$result= 'منذ  '.$month.' شهر  ';}else{$result=$month.'months ago ';}
    	}elseif ($day==1) {
    		$result= $lang['dayAgo'];
    	}elseif ($day>1) {
    		if($l=='ar'){$result= 'منذ  '.$day.' يوم  ';}else{$result= $day.' days ago';} ; 
    	}elseif ($hour==1) {
    		$result=$lang['hourAgo']; 
    	}elseif ($hour>1) {
    		if($l=='ar'){$result= 'منذ  '.$hour.' ساعة  ';}else{$result=$hour.'hours ago';}
    	}elseif($minute==1){
            $result= $lang['minAgo']; 
    	}elseif ($minute>1) {
    		if($l=='ar'){$result= 'منذ  '.$minute.' دقيقة  ';}else{$result= $minute.'minutes ago';}
    	}elseif ($minute<1) {
    		$result= $lang['now']; 
    	}

        return $result;
 }


//=========== GET countries BASED ON country_id =================
function getCountry($country_id){
    $country=$country_id;
    global $countryName;
      global $lang;

    if($country==1){$countryName=$lang['egypt'];}if($country==2){$countryName=$lang['saudi'];}
    if($country==3){$countryName=$lang['kuwait'];}if($country==4){$countryName=$lang['uae'];}
    if($country==5){$countryName=$lang['qatar'];}if($country==6){$countryName=$lang['oman'];}

return $countryName;
}


//phone 
function phone($COUNTRY,$PHONE){
   $country=$COUNTRY;
   $phone=$PHONE;
   $resultP='';
   $num='';
   $arr=[];
   global $resultP;

   if ( $country==1 && (strlen(trim($phone))<1 || strlen(trim($phone))!=11 ) ) {  $resultP=2;$num=11;}
   if ( $country==2 && (strlen(trim($phone))<1 || strlen(trim($phone))!=10 ) ) {  $resultP=2;$num=10;}
   if ( $country==3 && (strlen(trim($phone))<1 || strlen(trim($phone))!=8 ) ) {  $resultP=2;$num=8;}
   if ( $country==4 && (strlen(trim($phone))<1 || strlen(trim($phone))!=10 ) ) {  $resultP=2;$num=10;}
   if ( $country==5 && (strlen(trim($phone))<1 || strlen(trim($phone))!=8 ) ) {  $resultP=2;$num=8;}
   if ( $country==6 && (strlen(trim($phone))<1 || strlen(trim($phone))!=8 ) ) {  $resultP=2;$num=8;}

 $arr=[$resultP,$num];      
return  $arr;
}

// whatsapp
function whats($cont,$what){
   $country=$cont;
   $whats=$what;
   $result2='';
   $num='';
   $arr=[];
   global $result2;

       if ( $country==1 && (strlen(trim($whats))>0 && strlen(trim($whats))!=11 )) { $result2=2;$num=11;}
   elseif ( $country==2 && (strlen(trim($whats))>0 && strlen(trim($whats))!=10 )) { $result2=2;$num=10;}
   elseif ( $country==3 && (strlen(trim($whats))>0 && strlen(trim($whats))!=8 )) { $result2=2;$num=8;}
   elseif ( $country==4 && (strlen(trim($whats))>0 && strlen(trim($whats))!=10 )) { $result2=2;$num=10;}
   elseif ( $country==5 && (strlen(trim($whats))>0 && strlen(trim($whats))!=8 )) { $result2=2;$num=8;}
   elseif ( $country==6 && (strlen(trim($whats))>0 && strlen(trim($whats))!=8 )) { $result2=2;$num=8;}

 $arr=[$result2,$num];   

return $arr;//result2=0 =>no problem, result2=2 =>theres a problem
}



//=========== GET CATS BASED ON CAT_ID =================
function getCat($cat){
  $catid=$cat;
  global $catName;
  global $lang;

    if($catid==0){$catName=$lang['allCategories'];}elseif($catid==1){$catName=$lang['food'];}elseif($catid==2){$catName=$lang['devices'];}
    elseif($catid==3){$catName=$lang['home_needs'];}elseif($catid==4){$catName=$lang['beauty'];}elseif($catid==5){$catName=$lang['clohes'];}
    elseif($catid==6){$catName=$lang['building_painting'];}elseif($catid==7){$catName=$lang['property'];}
    elseif($catid==8){$catName=$lang['vehicles'];}elseif($catid==9){$catName=$lang['machinery'];}
    elseif($catid==10){$catName=$lang['parts'];}elseif($catid==11){$catName=$lang['designS'];} elseif($catid==12){$catName=$lang['transportS'];} 
    elseif($catid==13){$catName=$lang['repairS'];}elseif($catid==14){$catName=$lang['buildingS'];} elseif($catid==15){$catName=$lang['educationS'];} 
    elseif($catid==16){$catName=$lang['appearanceS'];}elseif($catid==17){$catName=$lang['joyS'];} elseif($catid==18){$catName=$lang['homeS'];} 


 return $catName;
}

//=========== GET states BASED ON state_id =================
function getState($state){
    $id=$state;
    global $Name;
    global $lang;
     
    //EGYPT 
    if($id==0){$Name=$lang['allstates'];}elseif($id==1){$Name=$lang['cairo'];}elseif($id==2){$Name=$lang['giza'];}elseif($id==3){$Name=$lang['alex'];}
    elseif($id==4){$Name=$lang['qalyobia'];}elseif($id==5){$Name=$lang['dakahlia'];}elseif($id==6){$Name=$lang['gharbia'];}
    elseif($id==7){$Name=$lang['sharkia'];}elseif($id==8){$Name=$lang['mnofia'];}elseif($id==9){$Name=$lang['beheira'];}
  elseif($id==10){$Name=$lang['KSheikh'];}elseif($id==11){$Name=$lang['PSaid'];}elseif($id==12){$Name=$lang['ismaelia'];}
  elseif($id==13){$Name=$lang['suez'];}elseif($id==14){$Name=$lang['domiat'];}elseif($id==15){$Name=$lang['matrouh'];}
  elseif($id==16){$Name=$lang['NSinai'];}elseif($id==17){$Name=$lang['SSinai'];}elseif($id==18){$Name=$lang['BSuef'];}
  elseif($id==19){$Name=$lang['fayoum'];}elseif($id==20){$Name=$lang['minia'];}elseif($id==21){$Name=$lang['assiut'];}
  elseif($id==22){$Name=$lang['sohag'];}elseif($id==23){$Name=$lang['qena'];}elseif($id==24){$Name=$lang['luxor'];}
  elseif($id==25){$Name=$lang['aswan'];}elseif($id==26){$Name=$lang['RSea'];}elseif($id==27){$Name=$lang['WGadid'];}
    //SAUDI ARABIA
  elseif($id==28){$Name=$lang['ryiadh'];}elseif($id==29){$Name=$lang['makka'];}elseif($id==30){$Name=$lang['madina'];}
  elseif($id==31){$Name=$lang['kasim'];}elseif($id==32){$Name=$lang['easternP'];}elseif($id==33){$Name=$lang['asir'];}
  elseif($id==34){$Name=$lang['tabuk'];}elseif($id==35){$Name=$lang['hail'];}elseif($id==36){$Name=$lang['northB'];}
  elseif($id==37){$Name=$lang['jazan'];}elseif($id==38){$Name=$lang['najran'];}elseif($id==39){$Name=$lang['baha'];}elseif($id==40){$Name=$lang['jawf'];}
  //KUWAIT
  elseif($id==41){$Name=$lang['kuwait'];}elseif($id==42){$Name=$lang['ahmadi'];}elseif($id==43){$Name=$lang['farwanyia'];}
  elseif($id==44){$Name=$lang['hawali'];}elseif($id==45){$Name=$lang['jahra'];}elseif($id==46){$Name=$lang['mubarak'];}
  //U.A.E
  elseif($id==47){$Name=$lang['abuDhabi'];}elseif($id==48){$Name=$lang['dubai'];}elseif($id==49){$Name=$lang['sharjah'];}
  elseif($id==50){$Name=$lang['ajman'];}elseif($id==51){$Name=$lang['rasKhaima'];}elseif($id==52){$Name=$lang['fujaira'];}
  elseif($id==53){$Name=$lang['umQuain'];}
  //QATAR
  elseif($id==54){$Name=$lang['doha'];}elseif($id==55){$Name=$lang['rayyan'];}elseif($id==56){$Name=$lang['umSalal'];}
  elseif($id==57){$Name=$lang['khor'];}elseif($id==58){$Name=$lang['wakra'];}elseif($id==59){$Name=$lang['shamal'];}
  //Oman
  elseif($id==60){$Name=$lang['Adakhlyia'];}elseif($id==61){$Name=$lang['Adhahera'];}elseif($id==62){$Name=$lang['AlBatinaN'];}
  elseif($id==63){$Name=$lang['AlBatinaS'];}elseif($id==64){$Name=$lang['Al-Buraimi'];}elseif($id==65){$Name=$lang['AlWusta'];}
  elseif($id==66){$Name=$lang['AsharqyiaN'];}elseif($id==67){$Name=$lang['AsharqyiaS'];}elseif($id==68){$Name=$lang['dhofar'];}
  elseif($id==69){$Name=$lang['muscat'];}elseif($id==70){$Name=$lang['musandam'];}


return $Name;
}


//=========== GET cities BASED ON city_id =================
function getCity($city){
    $id=$city;
    global $Name;
    global $lang;
     
    //EGYPT 
  if($id==0){$Name=$lang['allcities'];}    elseif($id==1){$Name=$lang['salam'];}   elseif($id==2){$Name=$lang['marg'];}elseif($id==3){$Name=$lang['matria'];}
  elseif($id==4){$Name=$lang['nozha'];}    elseif($id==5){$Name=$lang['AinShams'];}elseif($id==6){$Name=$lang['NasrCity'];}
  elseif($id==7){$Name=$lang['heliopolis'];}elseif($id==8){$Name=$lang['azbakia'];}elseif($id==9){$Name=$lang['mosky'];}
    elseif($id==10){$Name=$lang['waily'];}   elseif($id==11){$Name=$lang['BSharia'];}elseif($id==12){$Name=$lang['bolaq'];}
    elseif($id==13){$Name=$lang['abdeen'];}  elseif($id==14){$Name=$lang['KasrNil'];}elseif($id==15){$Name=$lang['MonshatNaser'];}
    elseif($id==16){$Name=$lang['darSalam'];}elseif($id==17){$Name=$lang['15May'];}  elseif($id==18){$Name=$lang['basatin'];}
    elseif($id==19){$Name=$lang['tebin'];}   elseif($id==20){$Name=$lang['khalifa'];}elseif($id==21){$Name=$lang['sayeda'];}
    elseif($id==22){$Name=$lang['maadi'];}   elseif($id==23){$Name=$lang['mokatam'];}elseif($id==24){$Name=$lang['helwan'];}
    elseif($id==25){$Name=$lang['OldCairo'];}elseif($id==26){$Name=$lang['amiria'];} elseif($id==27){$Name=$lang['Zhamra'];}
    elseif($id==28){$Name=$lang['zaiton'];}elseif($id==29){$Name=$lang['sharabya'];} elseif($id==30){$Name=$lang['hadaykKoba'];}
    elseif($id==31){$Name=$lang['rodeFaraj'];}elseif($id==32){$Name=$lang['shobra'];} elseif($id==33){$Name=$lang['gardenCity'];}
    elseif($id==34){$Name=$lang['zamalek'];}elseif($id==35){$Name=$lang['NewCapital'];} elseif($id==36){$Name=$lang['manial'];}
    elseif($id==37){$Name=$lang['gesrSuez'];}elseif($id==38){$Name=$lang['babLouk'];} elseif($id==39){$Name=$lang['monira'];}
    elseif($id==40){$Name=$lang['abbasyia'];}elseif($id==41){$Name=$lang['azhar'];} elseif($id==42){$Name=$lang['5thSettlement'];}
    elseif($id==43){$Name=$lang['embaba'];}elseif($id==44){$Name=$lang['moneeb'];} elseif($id==45){$Name=$lang['mohandesen'];}
    elseif($id==46){$Name=$lang['dokki'];}elseif($id==47){$Name=$lang['ajouza'];} elseif($id==48){$Name=$lang['haram'];}
    elseif($id==49){$Name=$lang['omranya'];}elseif($id==50){$Name=$lang['warak'];} elseif($id==51){$Name=$lang['bolaqDakror'];}
    elseif($id==52){$Name=$lang['kitkat'];}elseif($id==53){$Name=$lang['6thOctober'];} elseif($id==54){$Name=$lang['montazah'];}
    elseif($id==55){$Name=$lang['haiShark'];}elseif($id==56){$Name=$lang['haiWasat'];} elseif($id==57){$Name=$lang['haiGharb'];}
    elseif($id==58){$Name=$lang['gomrok'];}elseif($id==59){$Name=$lang['Amirya'];} elseif($id==60){$Name=$lang['agami'];}
    elseif($id==61){$Name=$lang['borgArab'];}elseif($id==62){$Name=$lang['banha'];} elseif($id==63){$Name=$lang['kalyoub'];}
    elseif($id==64){$Name=$lang['kanater'];}elseif($id==65){$Name=$lang['shobraKhaima'];} elseif($id==66){$Name=$lang['khanka'];}
    elseif($id==67){$Name=$lang['kafrShokr'];}elseif($id==68){$Name=$lang['shbenKanater'];} elseif($id==69){$Name=$lang['tokh'];}
    elseif($id==70){$Name=$lang['obour'];}elseif($id==71){$Name=$lang['kaha'];} elseif($id==72){$Name=$lang['khosous'];}
    elseif($id==73){$Name=$lang['mansoura'];}elseif($id==74){$Name=$lang['sinblawen'];} elseif($id==75){$Name=$lang['meetGhamr'];}
    elseif($id==76){$Name=$lang['dekernes'];}elseif($id==77){$Name=$lang['Matarya'];} elseif($id==78){$Name=$lang['belkas'];}
    elseif($id==79){$Name=$lang['manzala'];}elseif($id==80){$Name=$lang['talkha'];} elseif($id==81){$Name=$lang['gamalya'];}
    elseif($id==82){$Name=$lang['menetNasr'];}elseif($id==83){$Name=$lang['sherbin'];} elseif($id==84){$Name=$lang['tamaAmdid'];}
    elseif($id==85){$Name=$lang['meetSalsil'];}elseif($id==86){$Name=$lang['beniEbeid'];} elseif($id==87){$Name=$lang['aja'];}
    elseif($id==88){$Name=$lang['ekhtab'];}elseif($id==89){$Name=$lang['nabarouh'];} elseif($id==90){$Name=$lang['gamasa'];}
    elseif($id==91){$Name=$lang['kafrZayat'];}elseif($id==92){$Name=$lang['santa'];} elseif($id==93){$Name=$lang['mahalaKobra'];}
    elseif($id==94){$Name=$lang['basioun'];}elseif($id==95){$Name=$lang['zefta'];} elseif($id==96){$Name=$lang['samanoud'];}
    elseif($id==97){$Name=$lang['tanta'];}elseif($id==98){$Name=$lang['katour'];} elseif($id==99){$Name=$lang['zagazig'];}
    elseif($id==100){$Name=$lang['housainia'];}elseif($id==101){$Name=$lang['fakous'];} elseif($id==102){$Name=$lang['belbis'];}
    elseif($id==103){$Name=$lang['meniaKamh'];}elseif($id==107){$Name=$lang['newSalhyia'];} elseif($id==111){$Name=$lang['mashtolSouk'];}
    elseif($id==104){$Name=$lang['abuHamad'];}elseif($id==108){$Name=$lang['kafrSakr'];} elseif($id==112){$Name=$lang['dyarbNegm'];}
    elseif($id==105){$Name=$lang['awladSakr'];}elseif($id==109){$Name=$lang['abukebeir'];} elseif($id==113){$Name=$lang['ibrahymia'];}
    elseif($id==106){$Name=$lang['10thramadan'];}elseif($id==110){$Name=$lang['kanayat'];} elseif($id==114){$Name=$lang['hehya'];}
    elseif($id==115){$Name=$lang['karen'];}elseif($id==119){$Name=$lang['menouf'];} elseif($id==123){$Name=$lang['berketsaba'];}
    elseif($id==116){$Name=$lang['sanHagar'];}elseif($id==120){$Name=$lang['kwesna'];} elseif($id==124){$Name=$lang['shohadaa'];}
    elseif($id==117){$Name=$lang['aziziaEG'];}elseif($id==121){$Name=$lang['bagour'];} elseif($id==125){$Name=$lang['ashmon'];}
    elseif($id==118){$Name=$lang['shbenKom'];}elseif($id==122){$Name=$lang['tala'];} elseif($id==126){$Name=$lang['sadat'];}
    elseif($id==127){$Name=$lang['rasheed'];}elseif($id==131){$Name=$lang['hoshEisa'];} elseif($id==135){$Name=$lang['dmanhor'];}
    elseif($id==128){$Name=$lang['shobraket'];}elseif($id==132){$Name=$lang['kafrDawar'];} elseif($id==136){$Name=$lang['mahmoudya'];}
    elseif($id==129){$Name=$lang['etayBarod'];}elseif($id==133){$Name=$lang['delengat'];} elseif($id==137){$Name=$lang['edku'];}
    elseif($id==130){$Name=$lang['aboHomos'];}elseif($id==134){$Name=$lang['komHamada'];} elseif($id==138){$Name=$lang['abuMatamer'];}
    elseif($id==139){$Name=$lang['rahmanyia'];}elseif($id==143){$Name=$lang['kafrSheikh'];} elseif($id==147){$Name=$lang['kallin'];}
    elseif($id==140){$Name=$lang['nobaryia'];}elseif($id==144){$Name=$lang['desouk'];} elseif($id==148){$Name=$lang['sidiSalem'];}
    elseif($id==141){$Name=$lang['wadiNatron'];}elseif($id==145){$Name=$lang['fouah'];} elseif($id==149){$Name=$lang['RYiadh'];}
    elseif($id==142){$Name=$lang['badr'];}elseif($id==146){$Name=$lang['motobas'];} elseif($id==150){$Name=$lang['beyala'];}
    elseif($id==151){$Name=$lang['hamoul'];}elseif($id==155){$Name=$lang['talKabeer'];} elseif($id==159){$Name=$lang['kassasin'];}
    elseif($id==152){$Name=$lang['borolos'];}elseif($id==156){$Name=$lang['fayed'];} elseif($id==160){$Name=$lang['suezCity'];}
    elseif($id==153){$Name=$lang['portSaid'];}elseif($id==157){$Name=$lang['kantara'];} elseif($id==161){$Name=$lang['domiatCity'];}
    elseif($id==154){$Name=$lang['ismaeliaCity'];}elseif($id==158){$Name=$lang['abuSwer'];} elseif($id==162){$Name=$lang['farskor'];}
    elseif($id==163){$Name=$lang['kafrSaad'];}elseif($id==167){$Name=$lang['hamam'];} elseif($id==171){$Name=$lang['barrani'];}
    elseif($id==164){$Name=$lang['zarka'];}elseif($id==168){$Name=$lang['alamen'];} elseif($id==172){$Name=$lang['salom'];}
    elseif($id==165){$Name=$lang['kafrBateekh'];}elseif($id==169){$Name=$lang['alDabaa'];} elseif($id==173){$Name=$lang['siwa'];}
    elseif($id==166){$Name=$lang['marsaMatroh'];}elseif($id==170){$Name=$lang['nagela'];} elseif($id==174){$Name=$lang['arish'];}
    elseif($id==175){$Name=$lang['rafah'];}elseif($id==179){$Name=$lang['nweiba'];} elseif($id==183){$Name=$lang['beniSwefCity'];}
    elseif($id==176){$Name=$lang['shZweid'];}elseif($id==180){$Name=$lang['shSheikh'];} elseif($id==184){$Name=$lang['wasta'];}
    elseif($id==177){$Name=$lang['tor'];}elseif($id==181){$Name=$lang['saintKatrin'];} elseif($id==185){$Name=$lang['ehnasia'];}
    elseif($id==178){$Name=$lang['dahab'];}elseif($id==182){$Name=$lang['taba'];} elseif($id==186){$Name=$lang['beba'];}
    elseif($id==187){$Name=$lang['samasta'];}elseif($id==191){$Name=$lang['snores'];} elseif($id==195){$Name=$lang['yusifSedik'];}
    elseif($id==188){$Name=$lang['fashn'];}elseif($id==192){$Name=$lang['ebshwai'];} elseif($id==196){$Name=$lang['meniaCity'];}
    elseif($id==189){$Name=$lang['nasser'];}elseif($id==193){$Name=$lang['atsa'];} elseif($id==197){$Name=$lang['maghaga'];}
    elseif($id==190){$Name=$lang['fayoumCity'];}elseif($id==194){$Name=$lang['tamia'];} elseif($id==198){$Name=$lang['beniMazar'];}
    elseif($id==199){$Name=$lang['matai'];}elseif($id==203){$Name=$lang['deermouas'];} elseif($id==207){$Name=$lang['kousia'];}
    elseif($id==200){$Name=$lang['samalot'];}elseif($id==204){$Name=$lang['oudwa'];} elseif($id==208){$Name=$lang['abnob'];}
    elseif($id==201){$Name=$lang['abuKorkas'];}elseif($id==205){$Name=$lang['asuitCity'];} elseif($id==209){$Name=$lang['manflot'];}
    elseif($id==202){$Name=$lang['malawi'];}elseif($id==206){$Name=$lang['dairot'];} elseif($id==210){$Name=$lang['alFath'];}
    elseif($id==211){$Name=$lang['abuteeg'];}elseif($id==215){$Name=$lang['sedfa'];} elseif($id==219){$Name=$lang['sakolta'];}
    elseif($id==212){$Name=$lang['ghanaem'];}elseif($id==216){$Name=$lang['sohagCity'];} elseif($id==220){$Name=$lang['maragha'];}
    elseif($id==213){$Name=$lang['sahlselim'];}elseif($id==217){$Name=$lang['ekhmem'];} elseif($id==221){$Name=$lang['tahta'];}
    elseif($id==214){$Name=$lang['badari'];}elseif($id==218){$Name=$lang['darAlsalam'];} elseif($id==222){$Name=$lang['tema'];}
    elseif($id==223){$Name=$lang['gehena'];}elseif($id==227){$Name=$lang['abuTisht'];} elseif($id==231){$Name=$lang['qenaCity'];}
    elseif($id==224){$Name=$lang['monshah'];}elseif($id==228){$Name=$lang['farshot'];} elseif($id==232){$Name=$lang['qeft'];}
    elseif($id==225){$Name=$lang['gerga'];}elseif($id==229){$Name=$lang['nagHamadi'];} elseif($id==233){$Name=$lang['qus'];}
    elseif($id==226){$Name=$lang['baliana'];}elseif($id==230){$Name=$lang['dishna'];} elseif($id==234){$Name=$lang['wakf'];}
    elseif($id==235){$Name=$lang['nakada'];}elseif($id==239){$Name=$lang['korna'];} elseif($id==243){$Name=$lang['edfu'];}
    elseif($id==236){$Name=$lang['luxorCity'];}elseif($id==240){$Name=$lang['zeinia'];} elseif($id==244){$Name=$lang['daraw'];}
    elseif($id==237){$Name=$lang['esna'];}elseif($id==241){$Name=$lang['armant'];} elseif($id==245){$Name=$lang['komumbo'];}
    elseif($id==238){$Name=$lang['toud'];}elseif($id==242){$Name=$lang['aswanCity'];} elseif($id==246){$Name=$lang['nasrNuba'];}
    elseif($id==247){$Name=$lang['hurghada'];}elseif($id==251){$Name=$lang['rasGhareb'];} elseif($id==255){$Name=$lang['blat'];}
    elseif($id==248){$Name=$lang['safaga'];}elseif($id==252){$Name=$lang['kharga'];} elseif($id==256){$Name=$lang['baris'];}
    elseif($id==249){$Name=$lang['marsaAlam'];}elseif($id==253){$Name=$lang['dakhla'];} 
    elseif($id==250){$Name=$lang['quseir'];}elseif($id==254){$Name=$lang['farafra'];} 


  return $Name;
}
 


 //fetchAll anything
function fetchAll($field, $table, $field2, $value){
     global $conn;
     $stmt=$conn->prepare("SELECT $field FROM $table WHERE $field2 = ?");
     $stmt->execute(array($value));
   return $stmt->fetchAll();  
}


//fetchMax CANCELLED
function fetchmax($field,$table,$user,$value){
  global $conn;
   $stmt=$conn->prepare("SELECT $field FROM  $table
    WHERE $user=?  ");
  $stmt->execute(array($value));
  return $stmt->fetch();
}



//hide items if credit is less than max(item_mostafed)
function hideItems(){ 
        global $conn;
        $stmt=$conn->prepare("SELECT *  FROM  user
          WHERE trader=1 and online_pay=1 and password is not null  order by user_id desc ");
        $stmt->execute();
        $fetched=$stmt->fetchAll(); 
        if (!empty($fetched)) {
          foreach ($fetched as $value) {
            //get max value for item mostafed to check if trader has enough credit for paying online
            $stmt=$conn->prepare("SELECT max(item_mostafed),user.online_pay FROM  items
              join user on  items.user_id=user.user_id WHERE user.user_id=? and user.online_pay=1 ");
            $stmt->execute(array($value['user_id']));
            $fetchMax=$stmt->fetch();
            //hide items if credit is less than max(item_mostafed) for online pay traders only
              if($value['online_pay']==1){
                 if($value['cat_id']>=7&&$value['cat_id']<=9){ //field is 7,8,9
                    if($value['credit']<$fetchMax['max(item_mostafed)']){
                      //hide items
                      $stmt=$conn->prepare(' UPDATE items set hide=1 where  user_id=?  ');
                      $stmt->execute(array($value['user_id'])); 
                      //unfavourite hidden items in all users' favourites
                      $fetchIt=fetchAll('item_id','items','user_id',$value['user_id']); 
                      if (!empty($fetchIt)) {
                         foreach ($fetchIt as $key ) {
                           $stmt2=$conn->prepare(' UPDATE favourite set favourite_status=0 where  item_id=?  ');
                           $stmt2->execute(array($key['item_id']));
                         }
                      }
                    }
              }else{ //field is not 7 or 8
                  if($value['credit']<$fetchMax['max(item_mostafed)']*3){
                    //hide items
                    $stmt=$conn->prepare(' UPDATE items set hide=1 where  user_id=?  ');
                    $stmt->execute(array($value['user_id'])); 
                    //unfavourite hidden items in all users' favourites
                    $fetchIt=fetchAll('item_id','items','user_id',$value['user_id']); 
                    if (!empty($fetchIt)) {
                       foreach ($fetchIt as $key ) {
                         $stmt2=$conn->prepare(' UPDATE favourite set favourite_status=0 where  item_id=?  ');
                         $stmt2->execute(array($key['item_id']));
                       }
                    }
                  }
              }
             }//END  if($value['online_pay']==1)
           }//END foreach ($fetched as $value) 
         } //END  if (!empty($fetched))
        
}

//call hideItems 
hideItems();
