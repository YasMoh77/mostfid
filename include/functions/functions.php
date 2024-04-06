<?php
include 'lang.php';
//FRONT END FUNCTIONS FIRST
/*functions called in this page are:
1-hideItems => to hide items in case of credit is less than the higest mostafed item value
2-deleteOrders => to delete orders older than 3 months
3-unfavourite items => unfavourite all items if credit is short
4-banned =>if activated==0 => email updated but not verified & if user or trader is banned
5-program => add credit to program partners 
6-deleteMessage => delete messages older than 1 month
7-changePaidToOne => change all online pay traders to paid=1 in orders table to enable partners get their money

*/
/*********** header and pages**********/
//title function
function getTitle() {
	global $title;
  global $keywords;
  global $description;
  global $canonical;
if (isset($title)) { echo $title; }else{ echo 'مستفيد ';}
if (isset($keywords)) { echo $keywords; }
if (isset($description)) { echo $description; }
if (isset($canonical)) { echo $canonical; }

 }

// countdown counter for index.php
 function counter($itemID){
   $item_id=$itemID;
   global $conn;
   
   $stmt=$conn->prepare(" SELECT eventDate from items where item_id=? ");
   $stmt->execute(array($item_id));
   $fetchAll=$stmt->fetchAll();

   foreach ($fetchAll as $fetch ) {
   	$eventDate=$fetch['eventDate'];
    }
    $today1 =date('Y-m-d h:i:sa');//today's date 
    $today=strtotime($today1);//today's date in timestamp

    $days=floor(($eventDate-$today)/60/60/24);
    $hours=floor(($eventDate-$today)%(60*60*24)/60/60 );
    $min=floor(($eventDate-$today)%(60*60)/60 );
    $sec=floor(($eventDate-$today)%(60) );

  return $result=[$days,$hours,$min,$sec,$eventDate,$today];
 }

//price for index & details
function price($Country){
  $country=$Country;
  $curr='';
  global $lang;
  global $curr;

       if($country==1){ $curr='<span class="small">'.$lang['pound'].'</span>';}elseif($country==2){ $curr='<span class="small">'.$lang['ryialSa'].'</span>';}
   elseif($country==3){ $curr='<span class="small">'.$lang['dinarKw'].'</span>';} elseif($country==4){ $curr='<span class="small">'.$lang['dirhamUae'].'</span>';} 
   elseif($country==5){ $curr='<span class="small">'.$lang['ryialQat'].'</span>';} elseif($country==6){ $curr='<span class="small">'.$lang['ryialOman'].'</span>';}
   elseif($country==1000){ $curr='<span class="small">'.$lang['usDollar'].'</span>';} 

 return $curr;
}

//price2 for pay to feature ads
function price2($Country){
  $country=$Country;
  $curr='';
  global $lang;
  global $curr;

       if($country==1){ $curr=$lang['pound'];}elseif($country==2){ $curr=$lang['ryialSa'];}
   elseif($country==3){ $curr=$lang['dinarKw'];} elseif($country==4){ $curr=$lang['dirhamUae'];} 
   elseif($country==5){ $curr=$lang['ryialQat'];} elseif($country==6){ $curr=$lang['ryialOman'];}
   elseif($country==1000){ $curr=$lang['usDollar'];} 

 return $curr;
}

//amount for pricing table in action.php
function amount($Country){
  $country=$Country;
  $num=[];
  global $lang;
  global $num;

       if($country==1){ $num[0]=150;$num[1]=300;}elseif($country==2){ $num[0]=30;$num[1]=60; }
   elseif($country==3){ $num[0]=4;$num[1]=8; } elseif($country==4){ $num[0]=30;$num[1]=60; } 
   elseif($country==5){ $num[0]=30;$num[1]=60; } elseif($country==6){ $num[0]=4;$num[1]=8; }
   elseif($country==1000){ $num[0]=8 ;$num[1]=16; } 


 return $num;
}


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

//=========== GET SUBCATS BASED ON SUCAT_ID =================
function getSub($sub){
	$subcat=$sub;
	global $subName;
	global $lang;

    if($subcat==0){$subName=$lang['allSubCats'];}elseif($subcat==1){$subName=$lang['r-meals'];}elseif($subcat==2){$subName=$lang['home-food'];}elseif($subcat==3){$subName=$lang['nature-food'];}
    elseif($subcat==4){$subName=$lang['electrical-dev'];}  elseif($subcat==5){$subName=$lang['electronic-dev'];}elseif($subcat==6){$subName=$lang['phones'];}elseif($subcat==7){$subName=$lang['otherDev'];}elseif($subcat==8){$subName=$lang['furniture'];}
    elseif($subcat==9){$subName=$lang['home-stuff'];}     elseif($subcat==10){$subName=$lang['kids-needs'];}elseif($subcat==11){$subName=$lang['cloth'];}elseif($subcat==12){$subName=$lang['carpets'];}
    elseif($subcat==13){$subName=$lang['detergents'];} elseif($subcat==14){$subName=$lang['other-home-needs'];}elseif($subcat==15){$subName=$lang['perfumes'];}elseif($subcat==16){$subName=$lang['care-products'];}
    elseif($subcat==17){$subName=$lang['accessories'];}  elseif($subcat==18){$subName=$lang['other-beauty'];}elseif($subcat==19){$subName=$lang['menWear'];}elseif($subcat==20){$subName=$lang['womenWear'];}
    elseif($subcat==21){$subName=$lang['kidsWear'];}      elseif($subcat==22){$subName=$lang['CLOTH2'];}elseif($subcat==23){$subName=$lang['shoes'];}elseif($subcat==24){$subName=$lang['leatherStuff'];}elseif($subcat==25){$subName=$lang['OtherClothes'];}elseif($subcat==26){$subName=$lang['iron'];}elseif($subcat==27){$subName=$lang['cement'];}
    elseif($subcat==28){$subName=$lang['ceramics'];}   elseif($subcat==29){$subName=$lang['paints'];}elseif($subcat==30){$subName=$lang['bricks'];}elseif($subcat==31){$subName=$lang['other-building-paints'];}elseif($subcat==32){$subName=$lang['land'];}
    elseif($subcat==33){$subName=$lang['flats'];}   elseif($subcat==34){$subName=$lang['blocks'];}elseif($subcat==35){$subName=$lang['villas'];}elseif($subcat==36){$subName=$lang['chalets'];}elseif($subcat==37){$subName=$lang['repositories'];}
    elseif($subcat==38){$subName=$lang['other-property'];} elseif($subcat==39){$subName=$lang['cars'];}elseif($subcat==40){$subName=$lang['motorbikes'];}elseif($subcat==41){$subName=$lang['bikes'];}elseif($subcat==42){$subName=$lang['other-vehicles'];}
    elseif($subcat==43){$subName=$lang['agricul-machines'];}elseif($subcat==44){$subName=$lang['other-machinery'];}elseif($subcat==45){$subName=$lang['carParts'];}elseif($subcat==46){$subName=$lang['homeDeviceParts'];}elseif($subcat==47){$subName=$lang['machineParts'];}
    elseif($subcat==48){$subName=$lang['otherParts'];}elseif($subcat==49){$subName=$lang['desSigns'];}elseif($subcat==50){$subName=$lang['desWeb'];}elseif($subcat==51){$subName=$lang['desOther'];}elseif($subcat==52){$subName=$lang['transportPeople'];}
    elseif($subcat==53){$subName=$lang['transportGoods'];}elseif($subcat==54){$subName=$lang['repairDevices'];}elseif($subcat==55){$subName=$lang['repairCars'];}elseif($subcat==56){$subName=$lang['repairMachines'];}
    elseif($subcat==57){$subName=$lang['repairClothes'];}elseif($subcat==58){$subName=$lang['repairOther'];}elseif($subcat==59){$subName=$lang['buildElect'];}elseif($subcat==60){$subName=$lang['buildPaint'];}elseif($subcat==61){$subName=$lang['buildCeramic'];}      
    elseif($subcat==62){$subName=$lang['buildFurn'];}elseif($subcat==63){$subName=$lang['buildOther'];}elseif($subcat==64){$subName=$lang['eduCourses'];}elseif($subcat==65){$subName=$lang['eduPrivate'];}elseif($subcat==66){$subName=$lang['eduOther'];}
    elseif($subcat==67){$subName=$lang['appearanceMen'];}elseif($subcat==68){$subName=$lang['appearanceWomen'];}elseif($subcat==69){$subName=$lang['appearanceOther'];}elseif($subcat==70){$subName=$lang['joyRoom'];}elseif($subcat==71){$subName=$lang['joyPark'];}      
    elseif($subcat==72){$subName=$lang['joyStudio'];}elseif($subcat==73){$subName=$lang['joyTour'];}elseif($subcat==74){$subName=$lang['joyOther'];}

    elseif($subcat==84){$subName=$lang['otherF'];}


    
 return $subName;
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
    //SAUDI ARABIA
    elseif($id==257){$Name=$lang['ryiadhCity'];}elseif($id==261){$Name=$lang['majmaa'];} elseif($id==265){$Name=$lang['zulfi'];}
    elseif($id==258){$Name=$lang['diraiah'];}elseif($id==262){$Name=$lang['quaieia'];} elseif($id==266){$Name=$lang['shakraa'];}
    elseif($id==259){$Name=$lang['kharj'];}elseif($id==263){$Name=$lang['wadidawaser'];} elseif($id==267){$Name=$lang['hawtetBenitmaem'];}
    elseif($id==260){$Name=$lang['dawadmi'];}elseif($id==264){$Name=$lang['aflaj'];} elseif($id==268){$Name=$lang['afif'];}
    elseif($id==269){$Name=$lang['sulayl'];}elseif($id==273){$Name=$lang['thadek'];} elseif($id==277){$Name=$lang['makkaCity'];}
    elseif($id==270){$Name=$lang['dhurma'];}elseif($id==274){$Name=$lang['huraimela'];} elseif($id==278){$Name=$lang['jeddah'];}
    elseif($id==271){$Name=$lang['muzahmiah'];}elseif($id==275){$Name=$lang['hareek'];} elseif($id==279){$Name=$lang['taif'];}
    elseif($id==272){$Name=$lang['rimah'];}elseif($id==276){$Name=$lang['ghat'];} elseif($id==280){$Name=$lang['konfodah'];}
   
    elseif($id==281){$Name=$lang['laith'];}elseif($id==285){$Name=$lang['ranyah'];} elseif($id==289){$Name=$lang['yanbu'];}
    elseif($id==282){$Name=$lang['jumum'];}elseif($id==286){$Name=$lang['turbah'];} elseif($id==290){$Name=$lang['badrSA'];}
    elseif($id==283){$Name=$lang['rabegh'];}elseif($id==287){$Name=$lang['khurmah'];} elseif($id==291){$Name=$lang['ulah'];}
    elseif($id==284){$Name=$lang['khulays'];}elseif($id==288){$Name=$lang['kamel'];} elseif($id==292){$Name=$lang['mahd'];}
   
    elseif($id==293){$Name=$lang['hunakyiah'];}elseif($id==297){$Name=$lang['buraida'];} elseif($id==301){$Name=$lang['bukairia'];}
    elseif($id==294){$Name=$lang['khayber'];}elseif($id==298){$Name=$lang['unaizah'];} elseif($id==302){$Name=$lang['badayaa'];}
    elseif($id==295){$Name=$lang['ais'];}elseif($id==299){$Name=$lang['rass'];} elseif($id==303){$Name=$lang['asyah'];}
    elseif($id==296){$Name=$lang['wadifara'];}elseif($id==300){$Name=$lang['miznab'];} elseif($id==304){$Name=$lang['nebhanyiah'];}
   
    elseif($id==305){$Name=$lang['shemasyah'];}elseif($id==309){$Name=$lang['damam'];} elseif($id==313){$Name=$lang['jubail'];}
    elseif($id==306){$Name=$lang['oyounelJewa'];}elseif($id==310){$Name=$lang['khobar'];} elseif($id==314){$Name=$lang['dahran'];}
    elseif($id==307){$Name=$lang['ryiadhAlkhabra'];}elseif($id==311){$Name=$lang['qatif'];} elseif($id==315){$Name=$lang['khafji'];}
    elseif($id==308){$Name=$lang['ahsa'];}elseif($id==312){$Name=$lang['hafrelBatin'];} elseif($id==316){$Name=$lang['rastanura'];}
   
    elseif($id==317){$Name=$lang['abqaiq'];}elseif($id==321){$Name=$lang['muhail'];} elseif($id==325){$Name=$lang['majarda'];}
    elseif($id==318){$Name=$lang['nairiah'];}elseif($id==322){$Name=$lang['khamisMushayt'];} elseif($id==326){$Name=$lang['bareq'];}
    elseif($id==319){$Name=$lang['qaryetAlUlia'];}elseif($id==323){$Name=$lang['bishah'];} elseif($id==327){$Name=$lang['saratUbaidah'];}
    elseif($id==320){$Name=$lang['abha'];}elseif($id==324){$Name=$lang['ahdRifaidah'];} elseif($id==328){$Name=$lang['rijalAlma'];}
   
    elseif($id==329){$Name=$lang['tathleth'];}elseif($id==333){$Name=$lang['dubah'];} elseif($id==337){$Name=$lang['hailCity'];}
    elseif($id==330){$Name=$lang['alnamas'];}elseif($id==334){$Name=$lang['alWajh'];} elseif($id==338){$Name=$lang['baqaa'];}
    elseif($id==331){$Name=$lang['tabukCity'];}elseif($id==335){$Name=$lang['umluj'];} elseif($id==339){$Name=$lang['ghazalah'];}
    elseif($id==332){$Name=$lang['tayma'];}elseif($id==336){$Name=$lang['haql'];} elseif($id==340){$Name=$lang['shanan'];}
  
    elseif($id==341){$Name=$lang['hait'];}elseif($id==345){$Name=$lang['muaqaq'];} elseif($id==349){$Name=$lang['jazaan'];}
    elseif($id==342){$Name=$lang['shamli'];}elseif($id==346){$Name=$lang['arar'];} elseif($id==350){$Name=$lang['sabya'];}
    elseif($id==343){$Name=$lang['sulaimi'];}elseif($id==347){$Name=$lang['rafhaa'];} elseif($id==351){$Name=$lang['samtah'];}
    elseif($id==344){$Name=$lang['sumaira'];}elseif($id==348){$Name=$lang['turaif'];} elseif($id==352){$Name=$lang['abuArish'];}
    
    elseif($id==353){$Name=$lang['ahdMasarha'];}elseif($id==357){$Name=$lang['alDarb'];} elseif($id==361){$Name=$lang['badrAljnub'];}
    elseif($id==354){$Name=$lang['baish'];}elseif($id==358){$Name=$lang['najranCity'];} elseif($id==362){$Name=$lang['yadama'];}
    elseif($id==355){$Name=$lang['alArida'];}elseif($id==359){$Name=$lang['sharurah'];} elseif($id==363){$Name=$lang['thar'];}
    elseif($id==356){$Name=$lang['damad'];}elseif($id==360){$Name=$lang['hubuna'];} elseif($id==364){$Name=$lang['khubash'];}
    
    elseif($id==365){$Name=$lang['albaha'];}elseif($id==369){$Name=$lang['alaqeeq'];} elseif($id==373){$Name=$lang['tabarjal'];}
    elseif($id==366){$Name=$lang['baljurashi'];}elseif($id==370){$Name=$lang['sakaka'];} 
    elseif($id==367){$Name=$lang['almandaq'];}elseif($id==371){$Name=$lang['qurayyatSA'];} 
    elseif($id==368){$Name=$lang['almekhwah'];}elseif($id==372){$Name=$lang['dumatJandal'];} 
    //Kuwait
    elseif($id==374){$Name=$lang['abdallahsalim'];}elseif($id==378){$Name=$lang['alDasma'];} elseif($id==382){$Name=$lang['khalidia'];}
    elseif($id==375){$Name=$lang['adilia'];}elseif($id==379){$Name=$lang['alfaiha'];} elseif($id==383){$Name=$lang['almansurya'];}
    elseif($id==376){$Name=$lang['bneidAlKar'];}elseif($id==380){$Name=$lang['jaberAlAhmed'];} elseif($id==384){$Name=$lang['alnozha'];}
    elseif($id==377){$Name=$lang['aldaia'];}elseif($id==381){$Name=$lang['kaifan'];} elseif($id==385){$Name=$lang['alkadysia'];}
    
    elseif($id==386){$Name=$lang['kurtuba'];}elseif($id==390){$Name=$lang['sulaibikhat'];} elseif($id==394){$Name=$lang['abuhalifa'];}
    elseif($id==387){$Name=$lang['rawda'];}elseif($id==391){$Name=$lang['surra'];} elseif($id==395){$Name=$lang['alahmadi'];}
    elseif($id==388){$Name=$lang['alshark'];}elseif($id==392){$Name=$lang['yarmuk'];} elseif($id==396){$Name=$lang['aleqaila'];}
    elseif($id==389){$Name=$lang['shwaikh'];}elseif($id==393){$Name=$lang['shamyia'];} elseif($id==397){$Name=$lang['daher'];}
    
    elseif($id==398){$Name=$lang['fahaihel'];}elseif($id==402){$Name=$lang['mahbula'];} elseif($id==406){$Name=$lang['wafra'];}
    elseif($id==399){$Name=$lang['fintas'];}elseif($id==403){$Name=$lang['mangaf'];} elseif($id==407){$Name=$lang['subahAhmedSea'];}
    elseif($id==400){$Name=$lang['hadyia'];}elseif($id==404){$Name=$lang['riqqa'];} elseif($id==408){$Name=$lang['abraqKhaitan'];}
    elseif($id==401){$Name=$lang['jaberAlAli'];}elseif($id==405){$Name=$lang['subahyia'];} elseif($id==409){$Name=$lang['andalus'];}
    
    elseif($id==410){$Name=$lang['alriqae'];}elseif($id==414){$Name=$lang['khaitan'];} elseif($id==418){$Name=$lang['jabryia'];}
    elseif($id==411){$Name=$lang['arydia'];}elseif($id==415){$Name=$lang['salymia'];} elseif($id==419){$Name=$lang['rumaithya'];}
    elseif($id==412){$Name=$lang['farwanyiaa'];}elseif($id==416){$Name=$lang['hawallii'];} elseif($id==420){$Name=$lang['bayan'];}
    elseif($id==413){$Name=$lang['jleebShwaikh'];}elseif($id==417){$Name=$lang['salwa'];} elseif($id==421){$Name=$lang['mishref'];}
    
    elseif($id==422){$Name=$lang['shaab'];}elseif($id==426){$Name=$lang['mubarakAlAbdalah'];} elseif($id==430){$Name=$lang['anjafa'];}
    elseif($id==423){$Name=$lang['salamKuwait'];}elseif($id==427){$Name=$lang['alshohada'];} elseif($id==431){$Name=$lang['alJahra'];}
    elseif($id==424){$Name=$lang['hattin'];}elseif($id==428){$Name=$lang['albada'];} elseif($id==432){$Name=$lang['alWaha'];}
    elseif($id==425){$Name=$lang['alzahra'];}elseif($id==429){$Name=$lang['alsiddiq'];} elseif($id==433){$Name=$lang['alUyoun'];}
    
    elseif($id==434){$Name=$lang['alqaser'];}elseif($id==438){$Name=$lang['alSalmy'];} elseif($id==442){$Name=$lang['amghara'];}
    elseif($id==435){$Name=$lang['alNaseem'];}elseif($id==439){$Name=$lang['oamAlAish'];} elseif($id==443){$Name=$lang['saadAlabdAllah'];}
    elseif($id==436){$Name=$lang['taimaa'];}elseif($id==440){$Name=$lang['kabd'];} elseif($id==444){$Name=$lang['mubarakAlKabeer'];}
    elseif($id==437){$Name=$lang['alNaeem'];}elseif($id==441){$Name=$lang['kazma'];} elseif($id==445){$Name=$lang['subahAlsalem'];}
    
    elseif($id==446){$Name=$lang['misila'];}elseif($id==450){$Name=$lang['abuHassani'];} 
    elseif($id==447){$Name=$lang['adan'];}elseif($id==451){$Name=$lang['abuFutaira'];} 
    elseif($id==448){$Name=$lang['alqusour'];}elseif($id==452){$Name=$lang['sabhan'];} 
    elseif($id==449){$Name=$lang['alqurain'];}elseif($id==453){$Name=$lang['funaitis'];} 
    //UAE
    elseif($id==454){$Name=$lang['abudhabiGate'];}elseif($id==458){$Name=$lang['alFalahnew'];} elseif($id==462){$Name=$lang['alkhabisi'];}
    elseif($id==455){$Name=$lang['aldafra'];}elseif($id==459){$Name=$lang['alGurm'];} elseif($id==463){$Name=$lang['alKhalydyia'];}
    elseif($id==456){$Name=$lang['alAin'];}elseif($id==460){$Name=$lang['alHosn'];} elseif($id==464){$Name=$lang['khorAlMaqta'];}
    elseif($id==457){$Name=$lang['alBateen'];}elseif($id==461){$Name=$lang['alKarama'];} elseif($id==465){$Name=$lang['alKhubaira'];}
    
    elseif($id==466){$Name=$lang['alMafraq'];}elseif($id==470){$Name=$lang['alMina'];} elseif($id==474){$Name=$lang['alMusalla'];}
    elseif($id==467){$Name=$lang['almanhal'];}elseif($id==471){$Name=$lang['alMirfa'];} elseif($id==475){$Name=$lang['alMushrif'];}
    elseif($id==468){$Name=$lang['alMaqta'];}elseif($id==472){$Name=$lang['alMuntazah'];} elseif($id==476){$Name=$lang['alNahyan'];}
    elseif($id==469){$Name=$lang['alMatar'];}elseif($id==473){$Name=$lang['alMoror'];} elseif($id==477){$Name=$lang['alRas'];}
    
    elseif($id==478){$Name=$lang['alReef'];}elseif($id==482){$Name=$lang['alShawamekh'];} elseif($id==486){$Name=$lang['jebelAli'];}
    elseif($id==479){$Name=$lang['alRawda'];}elseif($id==483){$Name=$lang['alWahda'];} elseif($id==487){$Name=$lang['masdar'];}
    elseif($id==480){$Name=$lang['alSafa'];}elseif($id==484){$Name=$lang['alZahraAbuDhabi'];} elseif($id==488){$Name=$lang['abuHail'];}
    elseif($id==481){$Name=$lang['alShamekha'];}elseif($id==485){$Name=$lang['beniYasCity'];} elseif($id==489){$Name=$lang['alBadaDubai'];}
    
    elseif($id==490){$Name=$lang['alBaraha'];}elseif($id==494){$Name=$lang['alHodaiba'];} elseif($id==498){$Name=$lang['alMankhoul'];}
    elseif($id==491){$Name=$lang['alBarari'];}elseif($id==495){$Name=$lang['alJafilya'];} elseif($id==499){$Name=$lang['alMarqadah'];}
    elseif($id==492){$Name=$lang['alBarsha'];}elseif($id==496){$Name=$lang['alMamzar'];} elseif($id==500){$Name=$lang['alQouz'];}
    elseif($id==493){$Name=$lang['alGarhoud'];}elseif($id==497){$Name=$lang['alManara'];} elseif($id==501){$Name=$lang['riggatAlButen'];}
    
    elseif($id==502){$Name=$lang['jumeira'];}elseif($id==506){$Name=$lang['alNahda'];} elseif($id==510){$Name=$lang['horAlAnz'];}
    elseif($id==503){$Name=$lang['muhaisena'];}elseif($id==507){$Name=$lang['alRifaa'];} elseif($id==511){$Name=$lang['burDubai'];}
    elseif($id==504){$Name=$lang['waresan'];}elseif($id==508){$Name=$lang['alQusais'];} elseif($id==512){$Name=$lang['deira'];}
    elseif($id==505){$Name=$lang['mirdif'];}elseif($id==509){$Name=$lang['alSatwa'];} elseif($id==513){$Name=$lang['dubaiMarina'];}
    
    elseif($id==514){$Name=$lang['alMizhar'];}elseif($id==518){$Name=$lang['alJaddaf'];} elseif($id==522){$Name=$lang['alSharja'];}
    elseif($id==515){$Name=$lang['alRigga'];}elseif($id==519){$Name=$lang['rasAlKhor'];} elseif($id==523){$Name=$lang['kalba'];}
    elseif($id==516){$Name=$lang['alRashydia'];}elseif($id==520){$Name=$lang['ummSuqaim'];} elseif($id==524){$Name=$lang['alDhaid'];}
    elseif($id==517){$Name=$lang['alWarka'];}elseif($id==521){$Name=$lang['alKaramaDubai'];} elseif($id==525){$Name=$lang['khorFakkan'];}
    
    elseif($id==526){$Name=$lang['dibbaAlHisn'];}elseif($id==530){$Name=$lang['rasAlKhaimaCity'];} elseif($id==534){$Name=$lang['qidfa'];}
    elseif($id==527){$Name=$lang['ajmanCity'];}elseif($id==531){$Name=$lang['dibbaAlFujaira'];} elseif($id==535){$Name=$lang['alBethna'];}
    elseif($id==528){$Name=$lang['masfot'];}elseif($id==532){$Name=$lang['alBadyiah'];} elseif($id==536){$Name=$lang['ummAlQuwainCity'];}
    elseif($id==529){$Name=$lang['manama'];}elseif($id==533){$Name=$lang['masafi'];} 
    
    elseif($id==537){$Name=$lang['alBidaaQatar'];}elseif($id==541){$Name=$lang['alSaad'];} elseif($id==545){$Name=$lang['mushaireb'];}
    elseif($id==538){$Name=$lang['alDafna'];}elseif($id==542){$Name=$lang['alWaab'];} elseif($id==546){$Name=$lang['najma'];}
    elseif($id==539){$Name=$lang['alGhanim'];}elseif($id==543){$Name=$lang['BinMahmoud'];} elseif($id==547){$Name=$lang['oldAirport'];}
    elseif($id==540){$Name=$lang['alMarkhya'];}elseif($id==544){$Name=$lang['madinatKhalifa'];} elseif($id==548){$Name=$lang['qutaifya'];}
    
    elseif($id==549){$Name=$lang['rumailah'];}elseif($id==553){$Name=$lang['alAziziaQatar'];} elseif($id==557){$Name=$lang['ummSalalAli'];}
    elseif($id==550){$Name=$lang['ummGhuwailia'];}elseif($id==554){$Name=$lang['gharfatAlRayan'];} elseif($id==558){$Name=$lang['alKhorCity'];}
    elseif($id==551){$Name=$lang['westBay'];}elseif($id==555){$Name=$lang['alWajba'];} elseif($id==559){$Name=$lang['rasLaffan'];}
    elseif($id==552){$Name=$lang['abuHamour'];}elseif($id==556){$Name=$lang['ummSalalMahmud'];} elseif($id==560){$Name=$lang['alWakraCity'];}
    
    elseif($id==561){$Name=$lang['alWukeir'];}
    elseif($id==562){$Name=$lang['madinatAlShamal'];}
    elseif($id==563){$Name=$lang['arRuwais'];}
    elseif($id==564){$Name=$lang['abuDhalouf'];}
    //Oman
    elseif($id==565){$Name=$lang['nizwa'];}elseif($id==569){$Name=$lang['alHamra'];} elseif($id==573){$Name=$lang['ibri'];}
    elseif($id==566){$Name=$lang['samail'];}elseif($id==570){$Name=$lang['manah'];} elseif($id==574){$Name=$lang['yankul'];}
    elseif($id==567){$Name=$lang['bahla'];}elseif($id==571){$Name=$lang['izki'];} elseif($id==575){$Name=$lang['dhank'];}
    elseif($id==568){$Name=$lang['adam'];}elseif($id==572){$Name=$lang['bidbid'];} elseif($id==576){$Name=$lang['sohar'];}
    
    elseif($id==577){$Name=$lang['shinas'];}elseif($id==581){$Name=$lang['suwaiq'];} elseif($id==585){$Name=$lang['wadiAlMaawl'];}
    elseif($id==578){$Name=$lang['liwa'];}elseif($id==582){$Name=$lang['rustaq'];} elseif($id==586){$Name=$lang['barka'];}
    elseif($id==579){$Name=$lang['saham'];}elseif($id==583){$Name=$lang['alAwabi'];} elseif($id==587){$Name=$lang['alMusnah'];}
    elseif($id==580){$Name=$lang['alKhaboura'];}elseif($id==584){$Name=$lang['nakhal'];} elseif($id==588){$Name=$lang['alBuraimiCity'];}
    
    elseif($id==589){$Name=$lang['mahda'];}elseif($id==593){$Name=$lang['mahout'];} elseif($id==597){$Name=$lang['alMudaibi'];}
    elseif($id==590){$Name=$lang['alSunaynah'];}elseif($id==594){$Name=$lang['alJazer'];} elseif($id==598){$Name=$lang['bidia'];}
    elseif($id==591){$Name=$lang['haima'];}elseif($id==595){$Name=$lang['ibra'];} elseif($id==599){$Name=$lang['demaWaTaieen'];}
    elseif($id==592){$Name=$lang['duqm'];}elseif($id==596){$Name=$lang['alKabil'];} elseif($id==600){$Name=$lang['wadiBeniKhalid'];}
    
    elseif($id==601){$Name=$lang['sur'];}elseif($id==605){$Name=$lang['masirah'];} elseif($id==609){$Name=$lang['muqshin'];}
    elseif($id==602){$Name=$lang['alKamilAndAlWafi'];}elseif($id==606){$Name=$lang['alMazunah'];} elseif($id==610){$Name=$lang['rakhyut'];}
    elseif($id==603){$Name=$lang['jalanBeniBuHasan'];}elseif($id==607){$Name=$lang['dhalkot'];} elseif($id==611){$Name=$lang['sadah'];}
    elseif($id==604){$Name=$lang['jalanBeniBuAli'];}elseif($id==608){$Name=$lang['merbat'];} elseif($id==612){$Name=$lang['salalah'];}
    
    elseif($id==613){$Name=$lang['shalimAndHalaniat'];}elseif($id==617){$Name=$lang['alAmrat'];} elseif($id==621){$Name=$lang['alSeeb'];}
    elseif($id==614){$Name=$lang['taqah'];}elseif($id==618){$Name=$lang['bawsher'];} elseif($id==622){$Name=$lang['Khasab'];}
    elseif($id==615){$Name=$lang['thumrait'];}elseif($id==619){$Name=$lang['mutrah'];} elseif($id==623){$Name=$lang['bukha'];}
    elseif($id==616){$Name=$lang['muscatCity'];}elseif($id==620){$Name=$lang['qurayyatOman'];} elseif($id==624){$Name=$lang['dibbaAlBayaa'];}

    elseif($id==625){$Name=$lang['madhaa'];}
    














return $Name;
}


//states and their cities
function stateCity($State,$City){
	$state=$State;
	$city =$City;
	$result=1;
	global $result;//$result==0 => correct city // $result==1 => wrong city

	      if($state==1&&($city>=1||$city<=42) ){$result=0;}elseif($state==2&&($city>=43||$city<=52) ){$result=0;}elseif($state==3&&($city>=53||$city<=60) ){$result=0;}
     elseif($state==4&&($city>=61||$city<=71) ){$result=0;}elseif($state==5&&($city>=73||$city<=90) ){$result=0;}elseif($state==6&&($city>=91||$city<=98) ){$result=0;}
     elseif($state==7&&($city>=99||$city<=117) ){$result=0;}elseif($state==8&&($city>=118||$city<=126) ){$result=0;}elseif($state==9&&($city>=127||$city<=142) ){$result=0;}
     elseif($state==10&&($city>=143||$city<=152) ){$result=0;}elseif($state==12&&($city>=154||$city<=159) ){$result=0;}elseif($state==14&&($city>=161||$city<=165) ){$result=0;}
     elseif($state==15&&($city>=166||$city<=173) ){$result=0;}elseif($state==16&&($city>=174||$city<=176) ){$result=0;}elseif($state==17&&($city>=177||$city<=182) ){$result=0;}
     elseif($state==18&&($city>=183||$city<=189) ){$result=0;}elseif($state==19&&($city>=190||$city<=195) ){$result=0;}elseif($state==20&&($city>=196||$city<=204) ){$result=0;}
     elseif($state==21&&($city>=205||$city<=215) ){$result=0;}elseif($state==22&&($city>=216||$city<=226) ){$result=0;}elseif($state==23&&($city>=227||$city<=235) ){$result=0;}
     elseif($state==24&&($city>=236||$city<=241) ){$result=0;}elseif($state==25&&($city>=242||$city<=246) ){$result=0;}elseif($state==26&&($city>=247||$city<=251) ){$result=0;}
     elseif($state==27&&($city>=252||$city<=256) ){$result=0;}elseif($state==28&&($city>=257||$city<=276) ){$result=0;}elseif($state==29&&($city>=277||$city<=288) ){$result=0;}
     elseif($state==30&&($city>=289||$city<=296) ){$result=0;}elseif($state==31&&($city>=297||$city<=307) ){$result=0;}elseif($state==32&&($city>=308||$city<=319) ){$result=0;}
     elseif($state==33&&($city>=320||$city<=330) ){$result=0;}elseif($state==34&&($city>=331||$city<=336) ){$result=0;}elseif($state==35&&($city>=337||$city<=345) ){$result=0;}
     elseif($state==36&&($city>=346||$city<=348) ){$result=0;}elseif($state==37&&($city>=349||$city<=357) ){$result=0;}elseif($state==38&&($city>=358||$city<=364) ){$result=0;}
     elseif($state==39&&($city>=365||$city<=369) ){$result=0;}elseif($state==40&&($city>=370||$city<=373) ){$result=0;}elseif($state==41&&($city>=374||$city<=393) ){$result=0;}
     elseif($state==42&&($city>=394||$city<=407) ){$result=0;}elseif($state==43&&($city>=408||$city<=414) ){$result=0;}elseif($state==44&&($city>=415||$city<=430) ){$result=0;}
     elseif($state==45&&($city>=431||$city<=443) ){$result=0;}elseif($state==46&&($city>=444||$city<=453) ){$result=0;}elseif($state==47&&($city>=454||$city<=500) ){$result=0;}



	 elseif($state==2&&$city==72){$result=0;}//6th of october city
	 elseif($state==11&&$city==153){$result=0;}//port said
	 elseif($state==13&&$city==160){$result=0;}//suez


return $result;//0=wrong, 1==correct
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

// code for whatsapp
function code($cont){
   $country=$cont;
   $code='';
   global $code;

   if($country==1){$code=20;}elseif($country==2){$code=966;}
   elseif($country==3){$code=965;}elseif($country==4){$code=971;}
   elseif($country==5){$code=974;}elseif($country==6){$code=968;} 

return $code;
}

// digit for phone & whatsapp
function sendDigit($cont){
   $country=$cont;
   $digit='';
   global $digit;

   if($country==1){$digit=11;}elseif($country==2){$digit=10;}
   elseif($country==3){$digit=8;}elseif($country==4){$digit=10;}
   elseif($country==5){$digit=8;}elseif($country==6){$digit=8;} 

return $digit;
}
//camera number (number of phots shown for every item)
function cameraNum($PHOTO2,$PHOTO3,$PHOTO4,$PHOTO5){
  $value['photo2']=$PHOTO2;
  $value['photo3']=$PHOTO3;
  $value['photo4']=$PHOTO4;
  $value['photo5']=$PHOTO5;
  $num='';
  global $num;

   if($value['photo2']>0&&$value['photo3']>0&&$value['photo4']>0&&$value['photo5']>0){ echo $num= '<span class=" fas fa-camera camera"><span class="small">&nbsp;4</span> </span>'; } 
   elseif(($value['photo2']>0&&$value['photo3']>0&&$value['photo4']>0) || ($value['photo2']>0&&$value['photo3']>0&&$value['photo5']>0) || ($value['photo3']>0&&$value['photo4']>0&&$value['photo5']>0) ){ echo $num= '<span class=" fas fa-camera camera"><span class="small">&nbsp;3</span> </span>'; }
   elseif(($value['photo2']>0 && $value['photo3']>0) || ($value['photo2']>0 && $value['photo4']>0)||($value['photo2']>0 && $value['photo5']>0)||($value['photo3']>0 && $value['photo4']>0)||($value['photo3']>0 && $value['photo5']>0) ){ echo $num= '<span class=" fas fa-camera camera"><span class="small">&nbsp;2</span> </span>'; }
   elseif($value['photo2']>0||$value['photo3']>0||$value['photo4']>0||$value['photo5']>0){ echo $num= '<span class=" fas fa-camera camera"><span class="small">&nbsp;1</span> </span>';  }
   
return  $num;
}



//simple get items
/*function getAll($field,$table,$condition=NULL,$ordering,$sorting=DESC){
	global $conn;
	$stmt=$conn->prepare(" SELECT $field FROM $table 
	                      WHERE $condition 
	                      ORDER BY $ordering  $sorting ");
						  $stmt->execute();
						  return $stmt->fetchAll();
    }*/



// items with category name (profile & index) /*or (items.item_id  )*/
function getItems( $field,$Cat){
  $FIELD=$field;
  $cat=$Cat;
	global $conn;
	$stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,user.*
         FROM items
	     JOIN categories  ON items.cat_id=categories.cat_id
	     JOIN sub         ON items.subcat_id=sub.subcat_id
	     JOIN user        ON items.user_id=user.user_id
	     JOIN country     ON items.country_id=country.country_id
	     JOIN state       ON items.state_id=state.state_id
	     JOIN city        ON items.city_id=city.city_id
	WHERE $FIELD=? 	and items.approve>0	and items.hide=0	
	ORDER BY   items.item_id   DESC  LIMIT 18");
	$stmt->execute(array($cat));
	return $stmt->fetchAll();
			}




//Bring user data from database
function itemFetch($field,$ITEMID){
  $FIELD=$field;
  $item_id=$ITEMID;
  global $conn;
  $stmt=$conn->prepare(" SELECT items.*,categories.*,sub.*,country.*,state.*,city.*,traders.*
         FROM items
       JOIN categories  ON items.cat_id=categories.cat_id
       JOIN sub         ON items.subcat_id=sub.subcat_id
       JOIN traders     ON items.trader_id=traders.trader_id
       JOIN country     ON items.country_id=country.country_id
       JOIN state       ON items.state_id=state.state_id
       JOIN city        ON items.city_id=city.city_id
  WHERE $FIELD=?            
  ORDER BY   items.item_id   DESC  LIMIT 18");
  $stmt->execute(array($item_id));
  return $stmt->fetch();
      }



////////////////////////////////////// 
//use this function in details.php 
function items($field,$id){
   $ITEMID=$id; //item_id
   global $conn;
   $arr=[];
   global $arr;
 $stmt=$conn->prepare("SELECT items.*,categories.*,user.*, sub.*,city.*,
             country.*,state.* FROM items
          JOIN categories ON categories.cat_id=items.cat_id
          JOIN user ON user.user_id=items.user_id
          JOIN sub ON sub.subcat_id=items.subcat_id
          JOIN country ON country.country_id=items.country_id
          JOIN state ON state.state_id=items.state_id
          JOIN city ON city.city_id=items.city_id
      WHERE $field=? and items.approve>0 and items.hide=0 ");
       $stmt->execute(array($ITEMID));
       $items=$stmt->fetchAll();
       $count=$stmt->rowCount();
    return   $arr=[$items,$count];      
}	


///////////  from thumb.php 
//up
function up($comm){
  $comment=$comm;
  global $conn;
  $stmt=$conn->prepare("SELECT count(thumb_up) FROM thumb
  WHERE thumb_c_id=? and thumb_up=1 ");
  $stmt->execute(array($comment));
  $up=$stmt->fetchColumn();
  return $up;        
}

//up2
function up2($comm,$sess){
  $session=$sess;
  $comment=$comm;
  global $conn;
 $stmt2=$conn->prepare("SELECT count(thumb_up) FROM thumb
 WHERE thumb_c_id=? and user_id=? and thumb_up=1 ");
 $stmt2->execute(array($comment,$session));
 $up2=$stmt2->fetchColumn();  
 return $up2;        
}

/************************8888*** important ******************************/
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
                 if($value['cat_id']>=7&&$value['cat_id']<=9){ //field is 7 or 8
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

//////////////////////
//change all online pay traders to paid=1 in orders table to enable partners get their money
function changePaidToOne(){
 global $conn;
  $stmt=$conn->prepare(" SELECT user_id FROM  user WHERE online_pay=1 and trader=1   ");
  $stmt->execute();
  $fetched=$stmt->fetchAll();
  if (!empty($fetched)) {
    foreach ($fetched as $value) {
      $stmt=$conn->prepare(' UPDATE orders set paid=1 where  trader_id=?  ');
      $stmt->execute(array($value['user_id']));
    }
  }

}

changePaidToOne();



//////////////////////
 //if activated==0 => email updated but not verified & if user or trader is banned
function banned($sess){
  global $conn;
  $session=$sess;
  $stmt=$conn->prepare(" SELECT activate FROM  user WHERE user_id=?   ");
  $stmt->execute(array($session));
  $fetch=$stmt->fetch();
   if($fetch['activate']==2){ ?><script>location.href='logout.php?s=no';</script> <?php }
   elseif($fetch['activate']==0){ ?><script>location.href='emailChkCodeUpdate.php';</script> <?php }                  
}


/////////////////////////////
//delete orders older than 3 months
function deleteOrders(){
  global $conn;  
  $stmt=$conn->prepare(" DELETE  FROM  orders WHERE order_date < (unix_timestamp()-3600*24*30*3) ");
  $stmt->execute();
}
deleteOrders();

//delete messages older than 1 month
function deleteMessage(){
global $conn; 
$stmt=$conn->prepare(' DELETE from message  where  message_date<(UNIX_TIMESTAMP()-3600*24*30)  ');
$stmt->execute();
}
deleteMessage();
/*********************************************************/
// get url to decide t=..&main=.. CANCELLED   
/*function linkBack($URL){
$url=$URL; 
$link='';  
global $link;    
$pr=preg_match('/t=s&main=g/', $url);$pr2=preg_match('/t=s&main=v/', $url); //use for details pathinfo
$pr3=preg_match('/t=i&main=g/', $url);$pr4=preg_match('/t=i&main=v/', $url);
$pr5=preg_match('/t=p&main=p/', $url);$pr6=preg_match('/t=admin&main=admin/', $url);

if ($pr==1){ $link='t=s&main=g';}elseif ($pr2==1){ $link='t=s&main=v';}elseif ($pr3==1){ $link='t=i&main=g';}
elseif ($pr4==1){ $link='t=i&main=v';}elseif ($pr5==1){ $link='t=p&main=p';}elseif ($pr6==1){ $link='t=admin&main=admin';}
return $link;

}*/



					//START BACKEND FUNCTIONS 
 /*****************  SATART REDIRECT FUNCTIONS  ****************/
//redirect to previous page (on success)
function redirect($redirectMsg){	
		$url=$_SERVER['HTTP_REFERER'];		
	    echo "<div class='container'> " ;
		echo   "<div class='alert alert-danger'>".$redirectMsg.'<br>'; 
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
		header('refresh:7; url=index.php');
		//exit();
		echo "</div> " ;
}

function YourVote($YourMsg){        
            echo  $YourMsg ;
            header('refresh:3; url=index.php');
            exit();
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

//fetch anything 3
function fetch3($field, $table, $field2, $value2, $field3, $value3, $field4, $value4){
     global $conn;
     $stmt=$conn->prepare("SELECT $field FROM $table WHERE $field2=? and $field3=? and $field4=? ");
     $stmt->execute(array($value2,$value3,$value4));
   return $stmt->fetch();  
}


//fetch double things
function fetchDouble($field,$field2,  $table,  $field3,$value3,  $field4,$value4){
     global $conn;
     $stmt=$conn->prepare("SELECT $field,$field2 FROM $table WHERE $field3=? and $field4=? ");
     $stmt->execute(array($value3,$value4));
   return $stmt->fetch();  
}


//fetchAll anything
function fetchAll($field, $table, $field2, $value){
     global $conn;
     $stmt=$conn->prepare("SELECT $field FROM $table WHERE $field2 = ?");
     $stmt->execute(array($value));
   return $stmt->fetchAll();  
}

//fetchAll anything
function fetchAll2($field, $table, $value){
     global $conn;
     $arr=[];
     global $arr;
     $stmt=$conn->prepare("SELECT $field FROM $table WHERE $field = ? ");
     $stmt->execute(array($value));
    $all=$stmt->fetchAll();
    $row=$stmt->rowCount();

   return $arr=[$all,$row];     
}

//fetch greater than
function fetchAllGreater($field, $table, $value){
     global $conn;
     $stmt=$conn->prepare(" SELECT $field FROM $table WHERE $field >= $value ");
     $stmt->execute();
   return $stmt->fetchAll();  
}

//fetchAll special
function fetchAllSpecial($field,$table,$field2,$equal2,$value2,$field3,$equal3,$value3,$ordering,$orderingValue){
     $arr=[];
     global $conn;
     global $arr;

     $stmt=$conn->prepare("SELECT $field FROM $table WHERE $field2 $equal2 ? and $field3 $equal3 ? order by $ordering $orderingValue ");
     $stmt->execute(array($value2,$value3));
     $fetchAll=$stmt->fetchAll(); 
     $count=$stmt->rowCount();
     
     $arr=[$fetchAll,$count];
    return $arr;
}

//fetch general
function fetchGeneral($field,$table){
  $arr=[];
  global $conn;
  global $arr;
   $stmt=$conn->prepare("SELECT $field FROM $table  ");
   $stmt->execute();
   $fetchAll=$stmt->fetchAll(); 
   $count=$stmt->rowCount();

  $arr=[$fetchAll,$count];
  return $arr;
}

//fetchMax
function fetchmax($field,$table,$user,$value){
   $stmt=$conn->prepare("SELECT max($field) FROM  $table
    WHERE $user=?  ");
  $stmt->execute(array($value));
  return $stmt->fetch();
}


//update
function update($table,    $field,$value,    $field2,$value2){
  global $conn;
   $stmt=$conn->prepare("UPDATE $table set $field =? where $field2=? ");
   $stmt->execute(array($value,$value2));
}


//checkItem function(suitable for add&insret)
function checkItem($field, $table, $value){
     global $conn;
     $stmt=$conn->prepare("SELECT $field FROM $table WHERE $field = ?");
     $stmt->execute(array($value));
   return $stmt->rowCount();  
}

//checkItem2 function(suitable for edit&update)
function checkItem2($field, $table,$value,$field2,$value2){
     global $conn;
     $stmt=$conn->prepare("SELECT $field FROM $table WHERE $field = ? AND $field2=?");
     $stmt->execute(array($value,$value2));
	 return $stmt->rowCount();  
}

//checkItem2 function(suitable for edit&update)
function checkItem3($field,$field2,$table,$value,$value2){
     global $conn;
     $stmt=$conn->prepare("SELECT $field,$field2 FROM $table WHERE $field = ? AND $field2=?");
     $stmt->execute(array($value,$value2));
   return $stmt->rowCount();  
}

//checkItem4 function(suitable for edit&update)
function checkItem4($field,$table,$value,$field2,$value2,$field3,$value3){
     global $conn;
     $stmt=$conn->prepare("SELECT $field FROM $table WHERE $field = ? AND $field2=? and $field3=? ");
     $stmt->execute(array($value,$value2,$value3));
   return $stmt->rowCount();  
}

//count function
function countFromDb($field, $table){
	global $conn;
	$stmt3=$conn->prepare("SELECT COUNT($field) FROM $table");
	$stmt3->execute();
	return $stmt3->fetchColumn();
}

//count function (2)
function countFromDb2($field, $table,$field2,$value){
	global $conn;
	$stmt3=$conn->prepare("SELECT COUNT($field) FROM $table 
		where $field2 = $value ");
	$stmt3->execute();
	return $stmt3->fetchColumn();
}

//count function 3
function countFromDb3($field,$table,  $field2,$value2,  $field3,$value3){
  global $conn;
  $stmt3=$conn->prepare("SELECT COUNT($field) FROM $table 
    where $field2 = $value2 and $field3=$value3 ");
  $stmt3->execute();
  return $stmt3->fetchColumn();
}

//count function (4)
function countFromDb4($field,$table,  $field2,$equal2,$value2,  $field3,$equal3,$value3,  $field4,$equal4,$value4){
  global $conn;
  $stmt3=$conn->prepare("SELECT COUNT($field) FROM $table 
  where $field2 $equal2 $value2 and $field3 $equal3 $value3 and $field4 $equal4 $value4 ");
  $stmt3->execute();
  return $stmt3->fetchColumn();
}

//sum from sumFromDb2
function sumFromDb2($field, $table, $field2, $value){
  global $conn;
  $stmt3=$conn->prepare("SELECT sum($field) FROM $table 
    where $field2 = $value ");
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

//
function theLatest2($table,$table2,$field1,$table3,$field2,$field3,$field4,$field5,$field6,$order,$numComms){
	global $conn;
	$stmt=$conn->prepare("SELECT $table.*,$table2.$field1,$table3.$field2
	FROM $table
	INNER JOIN $table2 ON $table2.$field3=$table.$field4
	INNER JOIN $table3 ON $table3.$field5=$table.$field6
	ORDER BY $order DESC LIMIT $numComms  ");
	$stmt->execute();
	return $stmt->fetchAll();
}



//////////////////////    DELETE    //////////////////////////
//delete msgs after 15 days
/*function delete_msgs(){
  global $conn;
  $stmt=$conn->prepare(' DELETE  FROM  message  WHERE message_date <= (UNIX_TIMESTAMP()-1296000) ');
  $stmt->execute();
}
//delete msgs after 15 days
function delete_reply_msgs(){
  global $conn;
  $stmt=$conn->prepare(' DELETE  FROM  replymsg  WHERE replyMsg_date <= (UNIX_TIMESTAMP()-1296000) ');
  $stmt->execute();
}*/


