
$(function(){
///////////////////////////////////signUp/////////////////////////////////////
//show and hide password1 
var show=$('.showPassAddClosed');
var hide=$('.showPassAddOpen');
var input=$('.inputPassword');
//show
$(show).click(function(){
input.attr('type','text');
$(this).hide();
hide.show();
});
//hide
$(hide).click(function(){
input.attr('type','password'); 
$(this).hide();
show.show();
});
//show and hide password2 
var show2=$('.showPassAddClosed2');
var hide2=$('.showPassAddOpen2'); 
var input2=$('.inputPassword2');
//show
$(show2).click(function(){
input2.attr('type','text'); 
$(this).hide();
hide2.show();
});
//hide
$(hide2).click(function(){
input2.attr('type','password');
$(this).hide();
show2.show();
});

/***** passwords in forgotPass.php ******/
//show and hide password1 
var show3=$('.eyeClosedF');
var hide3=$('.eyeOpenF');
var input3=$('.inputPassword');
//show
$(show3).click(function(){
input3.attr('type','text');
$(this).hide();
hide3.show();
});
//hide
$(hide3).click(function(){
input3.attr('type','password');
$(this).hide();
show3.show();
});

//show and hide password2
var show4=$('.eyeClosedF2');
var hide4=$('.eyeOpenF2');
var input4=$('.inputPassword2');
//show
$(show4).click(function(){
input4.attr('type','text');
$(this).hide();
hide4.show();
});
//hide
$(hide4).click(function(){
input4.attr('type','password');
$(this).hide();
show4.show();
});

//hide and show placeholder
'use strict';
$('[placeholder]').focus(function(){

$(this).attr('go',$(this).attr('placeholder') );
$(this).attr('placeholder', ' ');
});

$('[placeholder]').blur(function(){
    $(this).attr('placeholder',$(this).attr('go')); 
});
/****** disable copy & paste in password fields in form2 ->signUpU.php *******/
$('.relative-signUp #form2 #pass,.relative-signUp #form2 #pass2,input[type="password"]').on('copy paste',function(e) {
    e.preventDefault(); return false; 
});
/******** signUpTrader.php ********/
var phone   =$('#phoneCheck').val();
var password=$('#passCheck').val();
//phone
$('#phoneCheck').blur(function(){
  if ($(this).val().length==0) {
   $('.btn-check-trader').prop('disabled',true);
    $('.guide').text('أدخل رقم تليفونك  المحمول  ');
    }else if ($(this).val().length!=11){
     $('.btn-check-trader').prop('disabled',false);
     $('.guide').text('رقم المحمول غير صحيح  ');
    }else if($(this).val().length==11){
     $('.btn-check-trader').prop('disabled',false);
     $('.guide').html('<span class="fas fa-check green"></span>');
    } 
});
//pass
$('#passCheck').focus(function(){
  if ($('#phoneCheck').val().length==0) {
     $('.btn-check-trader').prop('disabled',true);
     $('.guide').text('أدخل رقم تليفونك  المحمول  ');
  }else if ($('#phoneCheck').val().length!=11) {
     $('.btn-check-trader').prop('disabled',true);
     $('.guide').text('رقم المحمول غير صحيح  ');
  }else if ($('#phoneCheck').val().length==11 && $(this).val().length>1){
     $('.btn-check-trader').prop('disabled',false);
     $('.guide').html('<span class="fas fa-check green"></span>');
     $('.guide2').html('<span class="fas fa-check green"></span>');
    } 
    
}).keyup(function(){
  if ($(this).val().length==0) {
    $('.btn-check-trader').prop('disabled',true);
    $('.guide2').text('أدخل كلمة السر  المؤقتة ');
  }else if($(this).val().length!=0 && $('#phoneCheck').val().length==0){
    $('.btn-check-trader').prop('disabled',true);
    $('.guide').text('أدخل رقم تليفونك  المحمول  ');
  }else if($(this).val().length!=0 && $('#phoneCheck').val().length!=11){
    $('.btn-check-trader').prop('disabled',true);
    $('.guide').text('رقم المحمول غير صحيح  ');
  }else if($(this).val().length>0 && $('#phoneCheck').val().length==11){
    $('.btn-check-trader').prop('disabled',false);
    $('.guide2').html('<span class="fas fa-check green"></span>');
    }
}).blur(function(){
  if ($(this).val().length==0) {
    $('.btn-check-trader').prop('disabled',true);
    $('.guide2').text('أدخل كلمة السر  المؤقتة ');
  }else if($(this).val().length!=0 && $('#phoneCheck').val().length==0){
    $('.btn-check-trader').prop('disabled',true);
    $('.guide').text('أدخل رقم تليفونك  المحمول  ');
  }else if($(this).val().length!=0 && $('#phoneCheck').val().length!=11){
    $('.btn-check-trader').prop('disabled',true);
    $('.guide').text('رقم المحمول غير صحيح  ');
  }else if($(this).val().length>0 && $('#phoneCheck').val().length==11){
    $('.btn-check-trader').prop('disabled',false);
    $('.guide2').html('<span class="fas fa-check green"></span>');
    }
});
//pass
$('.btn-check-trader').click(function(){
  if ($('#phoneCheck').val().length!=11 ) { 
      $(this).prop('disabled',true);
      $('.guide').text('تأكد من بيانات الدخول  ');
  }else if($('#passCheck').val().length==0){
      $(this).prop('disabled',true);
      $('.guide2').text('أدخل كلمة السر  المؤقتة ');
  }else{
     $(this).prop('disabled',false); 
   }
});

/****** signin.php ********/
//show and hide password 
var show1=$('.showPassAddClosed1');
var hide1=$('.showPassAddOpen1'); 
var input1=$('.inputPassword1');
//show
$(show1).click(function(){
input1.attr('type','text');
$(this).hide();
hide1.show();
});
//hide
$(hide1).click(function(){
input1.attr('type','password');
$(this).hide();
show1.show();
});
///////////////////////////////////upper bar/////////////////////////////////////
  

///////////////////////////////////navbar/////////////////////////////////////
//click on name on navbar to 
$('.name-nav,.name').click(function(){
  $('.div-hide-nav').toggle();
});
//when scroll change navbar to fixed
 $(window).scroll( function(){
 if ($(document).scrollTop()>60){
  $('.fixed-top').css({
    'position':'fixed',
    'width'   :'101%'
  });
  $('.div-hide-nav').css({'display':'none','top':'11vh'});
  //$('.itemsNum-searc').css('top','32vh');9vh
 }else{
  $('.fixed-top').css({
    'position':'initial',
    'width'   :'100%'
  });
  $('.div-hide-nav').css('top','16vh');
 } 
});
 //click on fa-sort2
$('.enter,.fa-sort1').click(function(){
  $('.userPc').hide();
  $('.traderPc').toggle(); 
});
//click on fa-sort2
$('.enterPc,.fa-sort2').click(function(){
  $('.userPc').toggle();
  $('.traderPc').hide();
  $('.mob').hide();
});
//click on enterMob to show mobile sign in box
$('.enterMob,.fa-sortMob').click(function(){
  $('.mob').toggle();
  $('.userPc').hide();
});
//hide navbar divs
$('.navbar').click(function(){
  $('.div-hide-nav-trader').hide();
  $('.div-hide-nav-user').hide();
});
//

///////////////////////////////////signinu.php/////////////////////////////////////
/** check code **/
$('.form-control2').keyup(function(){
  var code=$('.spanCode').attr('id');
  var inputVal=$(this).val();
  if ($(this).val().length>=6) {
    if (inputVal===code) { $('.goodCode').show().text('جيد ');$('.badCode').hide(); }else{ $('.badCode').show().text('خطأ ');$('.goodCode').hide();}
  }
});
///////////////////////////////////Homepage/////////////////////////////////////
//span in  div show (search)
$('.spanSearch').mouseover(function(){
  $(this).css('backgroundColor','#2dad85');
});
//span in  div show (search)
$('.spanSearch').mouseout(function(){
  $(this).css('backgroundColor','#d0ede4');
});
//hover on search button
$('#btn-search-index').mouseover(function(){
  $(this).css('backgroundColor','orange');
});
//hover on ads  .flex-child,
$(".flex-child").mouseover(function(){
  $(this).css({
   // boxShadow: '0px 3px 6px 7px #d1d1d1'
  });
});

//mouseout on ads to change flex-child css
$(".flex-child").mouseout(function(){
  $(this).css({
  //  boxShadow: '0px 0px 0px white'
  });
});
//mouseout on ads to show gold-search div
$(".flex-child").hover(function(){
  $(this).children('.description-container').children('.gold-search,.silver-search').show();
},function(){
    $(this).children('.description-container').children('.gold-search,.silver-search').hide();
});
//click on icons to show hidden divs with contact info in (section-under-h3)
$('.icon-mail').click(function(){
  $(this).prev().toggle();
  $('.div-info-circle').hide();
  $('.div-mail').not($(this).prev()).hide();
});
$('.icon-link').click(function(){
  $(this).prev().toggle();
  $('.div-mail').hide();
 $('.div-info-circle').not($(this).prev()).hide();
});
/****** click anywhere to hide div-mail & div-info-circle *******/
/*$(".div-icons-container").siblings().click(function(){
  $('.div-mail,.div-info-circle').hide();
});
$(".div-icons-container").parent().siblings().click(function(){
  $('.div-mail,.div-info-circle').hide();
});*/
//add to favourite (index)
$('.fav').click(function(){
      if ($(this).hasClass('purple') ) {
         $(this).removeClass('purple'); 
         $(this).addClass('grey'); 

      }else if($(this).hasClass('grey') ){
         $(this).removeClass('grey');
         $(this).addClass('purple');
      }
});
/****** click .dots to toggle div-msg-report (show and hide icons of message&report) ******/
$('.dots').click(function(){
  $(this).next().toggle();
});
/****** click parents of .dots to hide div-msg-report ******/
$('.dots').parent().siblings().click(function(){
 $('.dots').next().hide();
 $('.div-msg-report').hide();
});
$('.dots').parent().parent().siblings().click(function(){
 $('.dots').next().hide();
 $('.div-msg-report').hide();
});

/***** click times to hide container (icons in homepage) ******/
$('.times').click(function(){
 $(this).parents('.div-subcat-show').hide();
});
//
$('.times').click(function(){
 $('.close-search-div').hide();
 $('.show-search,.show2-search,.show3-search').hide();
});
//close div containing subcategories in index.php
$('.close-cat').click(function(){
 $('.div-subcat-show').hide();
 $(this).hide();
});
//
$('.cat').click(function(){
  setTimeout(function sh(){
  $('.close-cat').show();
  },400);
});


/**************************************/
 //click on span in  div-show(search), it's value jump in the box 
/*$('.spanSearch').click(function(){
  $('#inputSearch').val($(this).text());

});
 //close ajax suggestions
$(".close-search,.close-search2").click(function(){
  $('.show-search,.show2-search,.close-search-div').hide();
});

//get ajax suggestions to show in search input field
$(".spanSearch").click(function(){
  $('#input-search').val($(this).text());
  $('.show-search,.show2-search,.show3-search,.close-search,.close-search2,.close-search3').hide();
});

//get value to jump into input search box
$(".nav-cats,.subCatNavLi,.subCatNavLi1").click(function(){
  $('.div-categories-container>span').text($(this).text());
  $('.div-categories,.show-subcats').hide();
});
*/
//show ul that contains cats
$('#btn-cat').click(function(){
  $('#cat-ul').toggle();
});
//show ul that contains subs
$('#btn-sub').click(function(){
  $('#sub-ul').toggle();
});
//get cat names to jump into the btn
$('.dropdown-item').click(function(){
  $('#btn-cat').text($(this).text() );
  $('#cat-ul').hide();
});
//hide ul with cat names
$('.show').click(function(){
  $('ul').filter('#cat-ul').hide();
});


 ///////////////////////////////////ad.php/////////////////////////////////////
  // textarea on add sign
  var maxDes=2000; //max description
  var minDes=20; //min description
  var maxName=60; //max description
  var minName=8; //min description
  var sub=$('#subcat').val();
  //prevent default after reaching max 
  $('#name').keypress(function(e){
     if ( $('#name').val().length>=maxName ) {  e.preventDefault(); }
  });
  //prevent default after reaching max 
  $('#description').keypress(function(e){
     if ($('#description').val().length>=maxDes ) {  e.preventDefault(); }
  });
 /*%%%%%%%%%%%%%%% subcat %%%%%%%%%%%%%%%%%*/
$('#subcat').blur(function(){
    if ($('#subcat').val()==0  ) { $('#subcat').css('backgroundColor','#f5b3b3'); }   
   else { $('#subcat').css('backgroundColor','white'); } 
  }).change(function(){
   if ($('#subcat').val()==0  ) { $('#subcat').css('backgroundColor','#f5b3b3'); }   
   else { $('#subcat').css('backgroundColor','white'); }
});
/*%%%%%%%%%%%%%%% subcat2 %%%%%%%%%%%%%%%%%*/
$('#subcat2').click(function(){
  if ($('#subcat').val()==0  ) { $('#subcat').css('backgroundColor','#f5b3b3'); }   
  else { $('#subcat').css('backgroundColor','white'); } 
}).blur(function(){
    if ($('#subcat2').val()==0  ) { $('#subcat2').css('backgroundColor','#f5b3b3'); }   
   else { $('#subcat2').css('backgroundColor','white'); } 
  }).change(function(){
   if ($('#subcat2').val()==0  ) { $('#subcat2').css('backgroundColor','#f5b3b3'); }   
   else { $('#subcat2').css('backgroundColor','white'); }
});
/*%%%%%%%%%%%%%%% name %%%%%%%%%%%%%%%%%*/
$('#name').focus(function(){
  if ($('#name').val().length>maxName ) { $('#name').css('backgroundColor','#f5b3b3'); }
  else { $('#name').css('backgroundColor','white'); }
  if ($('#subcat').val()==0  ) { $('#subcat').css('backgroundColor','#f5b3b3'); }   
  else { $('#subcat').css('backgroundColor','white'); } 
  if ($('#subcat2').val()==0  ) { $('#subcat2').css('backgroundColor','#f5b3b3'); }   
  else { $('#subcat2').css('backgroundColor','white'); } 
}).blur(function(){ 
   if ($('#name').val().length>maxName ||  ($('#name').val().length>0 && $('#name').val().length<minName || $('#name').val().length==0 ) ) { $('#name').css('backgroundColor','#f5b3b3'); }
   else { $('#name').css('backgroundColor','white'); }
  });
/*%%%%%%%%%%%%%%% description %%%%%%%%%%%%%%%%%%%*/
$('#description').focus(function(){ 
    if ($('#description').val().length>maxDes ) { $('#description').css('backgroundColor','#f5b3b3'); }
    else { $('#description').css('backgroundColor','white'); }
    if ($('#name').val().length==0){ $('#name').css('backgroundColor','#f5b3b3'); } 
    if ($('#subcat').val()==0  ) { $('#subcat').css('backgroundColor','#f5b3b3'); }   
    else { $('#subcat').css('backgroundColor','white'); } 
  }).blur(function(){
    if ($('#description').val().length>maxDes ||  ($('#description').val().length>0 && $('#description').val().length<minDes || $('#description').val().length==0) ) {
       $('#description').css('backgroundColor','#f5b3b3');
     }
  });
//when change state & city
$('#country,#state,#city').click(function(){
     if ($('#description').val().length<1) { $('#description').css('backgroundColor','#f5b3b3'); }
     if ($('#name').val().length<1) { $('#name').css('backgroundColor','#f5b3b3'); }
     if ($('#subcat').val()==0) { $('#subcat').css('backgroundColor','#f5b3b3'); }
     else { $('#subcat').css('backgroundColor','white'); }
     if ($('#subcat2').val()==0) { $('#subcat2').css('backgroundColor','#f5b3b3'); }
     else { $('#subcat2').css('backgroundColor','white'); }
  }).blur(function(){
    if ($(this).val()==0) { $(this).css('backgroundColor','#f5b3b3'); }
     else { $(this).css('backgroundColor','white'); }
  }).change(function(){
    if ($(this).val()==0) { $(this).css('backgroundColor','#f5b3b3'); }
     else { $(this).css('backgroundColor','white'); }
   });
//when click on state
$('#state').click(function(){
  if ($('#country').val()==0) { $('#country').css('backgroundColor','#f5b3b3'); }
  else { $('#country').css('backgroundColor','white'); }
  });
//when click on city
$('#city').click(function(){
  if ($('#country').val()==0) { $('#country').css('backgroundColor','#f5b3b3'); }
  else { $('#country').css('backgroundColor','white'); }
  if ($('#state').val()==0) { $('#state').css('backgroundColor','#f5b3b3'); }
  else { $('#state').css('backgroundColor','white'); }
  });
//phone & whats
$('.phoneListing2,#whats').focus(function(){
  if ($('#state').val()==0) { $('#state').css('backgroundColor','#f5b3b3'); }
  else { $('#state').css('backgroundColor','white'); }
  if ($('#city').val()==0) { $('#city').css('backgroundColor','#f5b3b3'); }
  else { $('#city').css('backgroundColor','white'); }
  if ($('#description').val().length<1) { $('#description').css('backgroundColor','#f5b3b3'); }
  if ($('#name').val().length<1) { $('#name').css('backgroundColor','#f5b3b3'); }
  if ($('#subcat').val()==0) { $('#subcat').css('backgroundColor','#f5b3b3'); }
  else { $('#subcat').css('backgroundColor','white'); }
  if ($('#subcat2').val()==0) { $('#subcat2').css('backgroundColor','#f5b3b3'); }
  else { $('#subcat2').css('backgroundColor','white'); }
});

//price
$('#price').focus(function(){
  if ($('#name').val().length<1) { $('#name').css('backgroundColor','#f5b3b3'); }
  if ($('#description').val().length<1) { $('#description').css('backgroundColor','#f5b3b3'); }
  if ($('#subcat').val()==0) { $('#subcat').css('backgroundColor','#f5b3b3'); }
  else { $('#subcat').css('backgroundColor','white'); }
  if ($('#subcat2').val()==0) { $('#subcat2').css('backgroundColor','#f5b3b3'); }
  else { $('#subcat2').css('backgroundColor','white'); }
  if ($('#state').val()==0) { $('#state').css('backgroundColor','#f5b3b3'); }
  else { $('#state').css('backgroundColor','white'); }
  if ($('#city').val()==0) { $('#city').css('backgroundColor','#f5b3b3'); }
  else { $('#city').css('backgroundColor','white'); }
}).blur(function(){
  if ($(this).val().length<1) { $(this).css('backgroundColor','#f5b3b3'); }
  else { $(this).css('backgroundColor','white'); }
});
//discount
$('#discount').focus(function(){
  if ($('#name').val().length<1) { $('#name').css('backgroundColor','#f5b3b3'); }
  if ($('#description').val().length<1) { $('#description').css('backgroundColor','#f5b3b3'); }
  if ($('#subcat').val()==0) { $('#subcat').css('backgroundColor','#f5b3b3'); }
  else { $('#subcat').css('backgroundColor','white'); }
  if ($('#subcat2').val()==0) { $('#subcat2').css('backgroundColor','#f5b3b3'); }
  else { $('#subcat2').css('backgroundColor','white'); }
  if ($('#state').val()==0) { $('#state').css('backgroundColor','#f5b3b3'); }
  else { $('#state').css('backgroundColor','white'); }
  if ($('#city').val()==0) { $('#city').css('backgroundColor','#f5b3b3'); }
  else { $('#city').css('backgroundColor','white'); }
  if ($('#price').val().length<1) { $('#price').css('backgroundColor','#f5b3b3'); }
  else { $('#price').css('backgroundColor','white'); }
}).blur(function(){
  if ($(this).val().length<1) { $(this).css('backgroundColor','#f5b3b3'); }
  else { $(this).css('backgroundColor','white'); }
});
//terms
$('#add-listing-submit').click(function(){
 // if ($('#terms').is(':checked')) { $(this).css('backgroundColor','#f38514').removeClass('disabled',true);$('.span-terms').css('color','black'); }
// else{ $(this).css('backgroundColor','#f5b3b3').addClass('disabled',true);$('.span-terms').css('color','red'); }
});

////// shown-phone ///////
function func(cont){
 if(cont==1) { return 11;}
 else if(cont==2) { return 10;}
 else if(cont==3) { return 8;}
 else if(cont==4) { return 10;}
 else if(cont==5) { return 8;}
 else if(cont==6) { return 8;}
}
//variables 
  var exceedAllowed=$('.exceedAllowed').val();
  var sixCharacters=$('.sixCharacters').val();
  var twentyChars=$('.twentyChars').val();
  var charsLeft=$('.charsLeft').val();
  var noMoreChars=$('.noMoreChars').val();
  var onlyNums=$('.onlyNums').val();
  var aboveZero=$('.aboveZero').val();
  var req=$('.req').val();
  var good=$('.good').val();

///// show-name ///////
$('#name').keyup(function(){
  var len=$(this).val().length;//input value length 
  var num=60;
  var calc=num-len;
  if (len>num) {
  $('#show-name').css({'color':'red'}).text(exceedAllowed);
  }else if (len>0&&len<8 ){
  $('#show-name').css({'color':'red'}).text(sixCharacters);
  }else if (len>=8&&len<num) {
  $('#show-name').css({'color':'green'}).text(good+' .. '+charsLeft+' '+calc);
  $(this).css('backgroundColor','white')
  }else if (len==num) {
  $('#show-name').css({'color':'red'}).text(noMoreChars);
  }else if (calc<0) {
  $calc=0;
  $('#show-name').css({'color':'red'}).text(calc+' '+charsLeft);} 
  });

///// show-desc ///////
$('#description').keyup(function(){
  var len=$(this).val().length;//input value length
  var num=2000;
  var calc=num-len;
    
  if (len>num) {
  $('#show-desc').css({'color':'red'}).text(exceedAllowed);
  }else if (len>0&&len<20 ){
  $('#show-desc').css({'color':'red'}).text(twentyChars);
  }else if (len>=20&&len<2000) {
  $('#show-desc').css({'color':'green'}).text(good+' .. '+charsLeft+' '+calc);
  }else if (len==2000) {
  $('#show-desc').css({'color':'red'}).text(noMoreChars);
  }else if (calc<0) {
  $calc=0;
  $('#show-desc').css({'color':'red'}).text(calc+' '+charsLeft);} 
  });


///// show-price ///////
$('#price').keyup(function(){
  var num=$(this).val();//input value
  var len=$(this).val().length;//input value length
  var cat=$('#subcat').val();//category value
  
  
  if(cat<1){
    $(this).css('backgroundColor','#f5b3b3');
    $('#show-price').css('color','red').text('اختر تصنيف  ');
  }else if(cat>=1){
      if( $.isNumeric(num)  && num>0){
        $(this).css('backgroundColor','white');
        $('#show-price').css('color','green').text(good);
      }else if (!$.isNumeric(num) && len>0 ) { 
        $(this).css('backgroundColor','#f5b3b3');
        $('#show-price').css('color','red').text(onlyNums);
        $('#showPriceAfter').val('');
        $('#show-discount').text('');
      }else if($.isNumeric(num)  && num>0){
        $(this).css('backgroundColor','white');
        $('#show-price').css('color','green').text(good);
      }else if($.isNumeric(num) && num<1){
         $(this).css('backgroundColor','#f5b3b3');
         $('#show-price').css('color','red').text(aboveZero);
      }else{
        $(this).css('backgroundColor','white');
        $('#show-price').css({'color':'green','display':'none'});
      }
  }
}).focus(function(){
  var cat=$('#subcat').val();//input value
  var num=$(this).val();//input value
  if(cat>=1 ){
      if ($.isNumeric(num)  && num>0) {
        $(this).css('backgroundColor','white');
        $('#show-price').css('color','green').text(good);
      }else{
        $(this).css('backgroundColor','#f5b3b3');
        $('#show-price').css('color','red').text(onlyNums);
      }
  }
});


//show-phone
$('#phone').keyup(function(){
  var cont=$('.country').val();
  var num=$(this).val();//input value
  var len=$(this).val().length;
  var insert=$('.insert').val();
  var digit=$('.digit').val();
  if (!$.isNumeric(num)) { $('.show-phone').css({'color':'red'}).text(onlyNums);} 
  else if ($.isNumeric(num) && cont==1 && len !=11) {$('.show-phone').css({'color':'red'}).text(insert + func(cont)+digit);}
  else if ($.isNumeric(num) && cont==2&&len!=10) {$('.show-phone').css({'color':'red'}).text(insert + func(cont)+digit);}
  else if ($.isNumeric(num) && cont==3&&len!=8) {$('.show-phone').css({'color':'red'}).text(insert + func(cont)+digit);}
  else if ($.isNumeric(num) && cont==4&&len!=10) {$('.show-phone').css({'color':'red'}).text(insert + func(cont)+digit);}
  else if ($.isNumeric(num) && cont==5&&len!=8) {$('.show-phone').css({'color':'red'}).text(insert + func(cont)+digit);}
  else if ($.isNumeric(num) && cont==6&&len!=8) {$('.show-phone').css({'color':'red'}).text(insert + func(cont)+digit);}
  else{$('.show-phone').css({'color':'green'}).text(good);}
}).blur(function(){
  var enterPhone=$('.enterPhone').val();
  var len=$(this).val().length;
  if(len<1){$('.show-phone').css({'color':'red'}).text(enterPhone);}
});


////// show-discount ///////
$('.calc').click(function(){
  var num   =$('#discount').val();//input value 
  var numlen=$('#discount').val().length;//discount value length
  var price =$('#price').val();
  var cat   =$('#subcat').val();
  var cat2  =$('#subcat2').val();
  var priceAfter=$('#showPriceAfter').val();
  var insert=$('.insert').val();  
  var digit =$('.digit').val();
  var good  =$('.good').val();

  var price=$('#price').val();
  var discount=$('#discount').val();
  var ratio=price*(discount/100);
  var finalPrice=Math.round(price-ratio);
  $("#showPriceAfter").css('color','green').val(finalPrice);
 
  if (!$.isNumeric(price)|| !$.isNumeric(num)) { $('#show-discount').text(''); $('#showPriceAfter').val('أدخل قيم رقمية في  الحقول أعلاه');}
  else{
    if(cat>=1){ /* food & other categories */ 
        if(cat==1){ /* only food */
           if (price>=51 && num>0&&num<5) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 5% للأسعار فوق 50جنية مصري (فئة طعام فقط )'); $('#showPriceAfter').css({'color':'red'}).val('راجع نسبة الخصم ');}
           else if (price<=50 && num>0&&num<10) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 10% للأسعار حتى 50 جنية مصري (فئة طعام فقط )'); $('#showPriceAfter').css({'color':'red'}).val('راجع نسبة الخصم ');}
           else{$('#show-discount').css({'color':'green'}).text(good+' ');}
        }else if(cat==12){
           if (price<=4000 && num>0&&num<7) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 7% للأسعار في هذه الفئة '); $('#showPriceAfter').css({'color':'red'}).val('راجع نسبة الخصم ');}
           else if (price>4000 && num>0&&num<6) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 6% لأسعار في هذه الفئة '); $('#showPriceAfter').css({'color':'red'}).val('راجع نسبة الخصم ');}
           else{$('#show-discount').css({'color':'green'}).text(good+' ');}
        }else if(cat==17){ 
            if(cat2==70){
               if (price<5000 && num>0&&num<5) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 5% للأسعار في هذه الفئة '); $('#showPriceAfter').css({'color':'red'}).val('راجع نسبة الخصم ');}
             else if (price>=5000 && num>0&&num<4) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 4% لأسعار في هذه الفئة '); $('#showPriceAfter').css({'color':'red'}).val('راجع نسبة الخصم ');}
             else{$('#show-discount').css({'color':'green'}).text(good+' ');}
            }else{
              ////// 
              if (numlen>0&&num<1) {$('#show-discount').css({'color':'red'}).text('أدخل  رقم أكبر من الصفر ؛ مثال : 10'+' ');} 
            else if (price<1&&num>0) {$('#show-discount').css({'color':'red'}).text('أدخل السعر أولا');} 
            else if (price>=1 && price<=300 && num>0 && num<10) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 10% للأسعار حتى 300 جنية مصري'); $('#showPriceAfter').css({'color':'red'}).val('راجع نسبة الخصم ');}
            else if (price>=301 && price<=600 && num>0 && num<8) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 8% للأسعار  من 301 حتى 600 جنية مصري'); $('#showPriceAfter').css({'color':'red'}).val('راجع نسبة الخصم ');}
            else if (price>=601 && price<=1000 && num>0 && num<5) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 5% للأسعار  من 601 حتى 1,000  جنية مصري'); $('#showPriceAfter').css({'color':'red'}).val('راجع نسبة الخصم ');}
            else if (price>=1001 && price<=40000 && num>0 && num<2) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 2% للأسعار  من 1001 حتى 40,000  جنية مصري'); $('#showPriceAfter').css({'color':'red'}).val('راجع نسبة الخصم ');}
            else if (price>=40001 && num>0 && num<1) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 1% للأسعار  فوق  40,000  جنية مصري');}
            else{$('#show-discount').css({'color':'green'}).text(good+' ');}
              //////
            } 

        }else{ /* other categories */
          if (numlen>0&&num<1) {$('#show-discount').css({'color':'red'}).text('أدخل  رقم أكبر من الصفر ؛ مثال : 10'+' ');} 
          else if (price<1&&num>0) {$('#show-discount').css({'color':'red'}).text('أدخل السعر أولا');} 
          else if (price>=1 && price<=300 && num>0 && num<10) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 10% للأسعار حتى 300 جنية مصري'); $('#showPriceAfter').css({'color':'red'}).val('راجع نسبة الخصم ');}
          else if (price>=301 && price<=600 && num>0 && num<8) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 8% للأسعار  من 301 حتى 600 جنية مصري'); $('#showPriceAfter').css({'color':'red'}).val('راجع نسبة الخصم ');}
          else if (price>=601 && price<=1000 && num>0 && num<5) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 5% للأسعار  من 601 حتى 1,000  جنية مصري'); $('#showPriceAfter').css({'color':'red'}).val('راجع نسبة الخصم ');}
          else if (price>=1001 && price<=40000 && num>0 && num<2) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 2% للأسعار  من 1001 حتى 40,000  جنية مصري'); $('#showPriceAfter').css({'color':'red'}).val('راجع نسبة الخصم ');}
          else if (price>=40001 && num>0 && num<1) {$('#show-discount').css({'color':'red'}).text('نسبة الخصم لا تقل عن 1% للأسعار  فوق  40,000  جنية مصري');}
          else{$('#show-discount').css({'color':'green'}).text(good+' ');}
      }
    }else{ //End if cat>=1
      {$('#show-discount,#show-price').css({'color':'red'}).text('اختر تصنيف  ');};
      {$('#showPriceAfter').css({'color':'red'}).val('اختر تصنيف  ');};
    }
 }//End else
});//
//
$('#discount').keyup(function(){
  var num=$(this).val();//input value
  var numlen=$(this).val().length;//discount value length
  var price=$('#price').val();
  var priceAfter=$('#showPriceAfter').val();
  if (!$.isNumeric(num)&&numlen>0 ) { 
    $('#show-discount').css({'color':'red'}).text(onlyNums);
    $('#showPriceAfter').val('');
  } 
});
//////hide delivery if category==7(property) or category>10 (services)////// 
var cat=$('#subcat').val();//category value
if((cat>=7&&cat<=9)||cat>10){$('#lblDeliv,#spanDeliv,#divDeliv').hide();}else{ $('#lblDeliv,#spanDeliv,#divDeliv').show(); }
if(cat==7||cat==8){$('#lblProp,#spanProp,#divProp').show();}else{ $('#lblProp,#spanProp,#divProp').hide(); }
//interchange to decide owner or middle man
$('#sit1').click(function(){
  $(this).prop('checked',true);
  $('#sit2').prop('checked',false);
});
//
$('#sit2').click(function(){
  $(this).prop('checked',true);
  $('#sit1').prop('checked',false);
});
////////////// check boxes for delivery //////////////
//delivery1
$('#delivery1').click(function(){
  $(this).prop('checked',true);
  $('#delivery2').prop('checked',false);
  $('#delivery3').prop('checked',false);
  $('#delivery4').prop('checked',false);
  $('#delivery5').prop('checked',false);
  $('#delivery6').prop('checked',false);
  $('#delivery7').prop('checked',false);
  $('#delivery8').prop('checked',false);
  $('#delivery9').prop('checked',false);
});
//delivery2
$('#delivery2').click(function(){
  $(this).prop('checked',true);
  $('#delivery1').prop('checked',false);
  $('#delivery3').prop('checked',false);
  $('#delivery4').prop('checked',false);
  $('#delivery5').prop('checked',false);
  $('#delivery6').prop('checked',false);
  $('#delivery7').prop('checked',false);
  $('#delivery8').prop('checked',false);
  $('#delivery9').prop('checked',false);
});
//delivery3
$('#delivery3').click(function(){
  $(this).prop('checked',true);
  $('#delivery1').prop('checked',false);
  $('#delivery2').prop('checked',false);
  $('#delivery4').prop('checked',false);
  $('#delivery5').prop('checked',false);
   $('#delivery6').prop('checked',false);
  $('#delivery7').prop('checked',false);
  $('#delivery8').prop('checked',false);
  $('#delivery9').prop('checked',false);
});
//delivery4
$('#delivery4').click(function(){
  $(this).prop('checked',true);
  $('#delivery1').prop('checked',false);
  $('#delivery2').prop('checked',false);
  $('#delivery3').prop('checked',false);
  $('#delivery5').prop('checked',false);
   $('#delivery6').prop('checked',false);
  $('#delivery7').prop('checked',false);
  $('#delivery8').prop('checked',false);
  $('#delivery9').prop('checked',false);
});
//delivery5
$('#delivery5').click(function(){
  $(this).prop('checked',true);
  $('#delivery1').prop('checked',false);
  $('#delivery2').prop('checked',false);
  $('#delivery3').prop('checked',false);
  $('#delivery4').prop('checked',false);
   $('#delivery6').prop('checked',false);
  $('#delivery7').prop('checked',false);
  $('#delivery8').prop('checked',false);
  $('#delivery9').prop('checked',false);
});
//delivery6
$('#delivery6').click(function(){
  $(this).prop('checked',true);
  $('#delivery1').prop('checked',false);
  $('#delivery2').prop('checked',false);
  $('#delivery3').prop('checked',false);
  $('#delivery4').prop('checked',false);
   $('#delivery5').prop('checked',false);
  $('#delivery7').prop('checked',false);
  $('#delivery8').prop('checked',false);
  $('#delivery9').prop('checked',false);
});
//delivery7
$('#delivery7').click(function(){
  $(this).prop('checked',true);
  $('#delivery1').prop('checked',false);
  $('#delivery2').prop('checked',false);
  $('#delivery3').prop('checked',false);
  $('#delivery4').prop('checked',false);
   $('#delivery5').prop('checked',false);
  $('#delivery6').prop('checked',false);
  $('#delivery8').prop('checked',false);
  $('#delivery9').prop('checked',false);
});
//delivery8
$('#delivery8').click(function(){
  $(this).prop('checked',true);
  $('#delivery1').prop('checked',false);
  $('#delivery2').prop('checked',false);
  $('#delivery3').prop('checked',false);
  $('#delivery4').prop('checked',false);
  $('#delivery5').prop('checked',false);
  $('#delivery6').prop('checked',false);
  $('#delivery7').prop('checked',false);
  $('#delivery9').prop('checked',false);
});
//delivery9
$('#delivery9').click(function(){
  $(this).prop('checked',true);
  $('#delivery1').prop('checked',false);
  $('#delivery2').prop('checked',false);
  $('#delivery3').prop('checked',false);
  $('#delivery4').prop('checked',false);
   $('#delivery5').prop('checked',false);
  $('#delivery6').prop('checked',false);
  $('#delivery7').prop('checked',false);
  $('#delivery8').prop('checked',false);
});


///////order.php/////
/** report unserious buyers from action.php& d=report **/
$('.qnChange').click(function(){
  $('.Process1R> .none').show();
  $(this).prop('checked',true);
  $('.noSell').prop('checked',false);
});
$('.noSell').click(function(){
  $('.Process1R> .none').hide();
  $(this).prop('checked',true);
  $('.qnChange').prop('checked',false);
});


 ///////////////////////////////////profile/////////////////////////////////////
//confirm to delete
$('.confirm').click(function(){
  var l=$('.lang').val();
  if(l=='ar'){ return confirm("هل ترغب في الحذف ؟"); }
  else{ return confirm(" Are you sure you want to delete ?"); }
});
//confirm to activate
$('.confirmActivate').click(function(){
  return confirm('Are you sure you want to activate ?');
});
//confirm to approve
$('.confirmApprove').click(function(){
  return confirm('Are you sure you want to approve ?');
});
//confirm to delete
$('.confirmDelete').click(function(){
  var l=$(this).nextAll('.language').val();
  if(l=='ar'){ return confirm("هل ترغب في الحذف ؟"); }
  else{ return confirm(" Are you sure you want to delete ?"); }
});
//confirm to delete account
$('.confirmDeleteAcc').click(function(){
  var l=$(this).nextAll('.language').val();
  if(l=='ar'){ return confirm("هل ترغب في  حذف حسابك ؟ "); }
  else{ return confirm(" Are you sure you want to delete your account ?"); }
});
//confirm to hide
$('.confirmHide').click(function(){
  var l=$(this).nextAll('.language').val();
  if(l=='ar'){ return confirm("هل ترغب في تنفيذ الحجب ؟ "); }
  else{ return confirm(" Are you sure you want to Hide checked items ?"); }
});
//confirm to unhide
$('.confirmUnHide').click(function(){
  var l=$('.language').val();
  if(l=='ar'){ return confirm("هل ترغب في الغاء الحجب ؟ "); }
  else{ return confirm(" Are you sure you want to show checked items ?"); }
});
//confirm to delete
$('.confirmDeleteOrder').click(function(){
  var l=$(this).nextAll('.language').val();
  if(l=='ar'){ return confirm("هل ترغب في  الغاء الطلب  ؟"); }
  else{ return confirm(" Are you sure you want to cancel order ?"); }
});
//confirm to remove
$('.confirmRemove').click(function(){
  var l=$(this).nextAll('.language').val();
  if(l=='ar'){ return confirm("هل ترغب في  مسح بيانات  الدخول  المحفوظة مسبقا؟"); }
  else{ return confirm(" Are you sure you want to remove saved login data ?"); }
});
//confirm report
$(".confirmReport").click(function(){
 var l=$(this).nextAll('.language').val();
 var l2=$('.lang').val();
  if(l=='ar'||l2=='ar'){ return confirm("هل ترغب في التبليغ ؟ "); }
  else{ return confirm(" Are you sure you want to report?"); }
});
//confirm report
$(".confirmUnreport").click(function(){
 var l=$('.lang').val();
  if(l=='ar'){ return confirm("هل ترغب في التراجع عن التبليغ ؟."); }
  else{ return confirm(" Are you sure you want to cancel report ?"); }
});
//confirm to complete profile info
$(".completeInfo").click(function(){
 var l=$(this).nextAll('#langu').val();
  if(l=='ar'){ return confirm("لكي تستطيع تمييز اللافتة يجب تكملة البيانات الناقصة  في حسابك أولا"); }
  else{ return confirm(" To feature a sign, Please complete missing data in profile"); }
});
//confirm2 to complete profile info
$(".completeInfo2").click(function(){
 var l=$(this).nextAll('#langu').val();
  if(l=='ar'){ return confirm("لكي تستطيع اضافة لافتة يجب تكملة البيانات الناقصة  في حسابك أولا"); }
  else{ return confirm(" To add a sign, Please complete missing data in profile"); }
});
//confirm2 to go ahead to place order
$(".confirmAhead").click(function(){
 var l=$('.lang').val();
  if(l=='ar'){ return confirm("إرسال الطلب  ؟ "); }
  else{ return confirm("Place order?"); }
});
//============== the span reportBought================//
//hover
$('.reportBought').hover(function(){
  $(this).css('cursor','pointer'); 
});
//show & hide notice when trying to ad an item 
$('.adNote').click(function(){
  $('.adNote2').show();
});
$('.adNote3').click(function(){
   $('.adNote2').hide();
});
/******* profile.php -> check the checkboxes to delete items *********/
//when page loads
if ( !$('.del-checkbox').is(':checked')) {$('.del-btn').prop('disabled',true).css('backgroundColor','#b588de');}
//click on the checkbox
$('.del-checkbox').click(function(){ 
   if ( !$('.del-checkbox').is(':checked')) {$('.del-btn').prop('disabled',true).css('backgroundColor','#b588de');}
  else{$('.del-btn').prop('disabled',false).css('backgroundColor','blueviolet');} 
});
//click on the button to delete
$('.del-btn').click(function(){
  if ( !$('.del-checkbox').is(':checked')) {$('.del-btn').prop('disabled',true).css('backgroundColor','#b588de');}
  else{$('.del-btn').prop('disabled',false).css('backgroundColor','blueviolet');} 
});


//p='msg' check the checkboxes to delete messages
//when page loads
if ( !$('.del-msg').is(':checked')) {$('.btnchk').prop('disabled',true).css('backgroundColor','#d47a7a');}
//click on the checkbox
$('.del-msg').click(function(){ 
   if ( !$('.del-msg').is(':checked')) {$('.btnchk').prop('disabled',true).css('backgroundColor','#d47a7a');}
  else{$('.btnchk').prop('disabled',false).css('backgroundColor','#f12121');} 
});
//click on the button to delete
$('.btnchk').click(function(){
  if ( !$('.del-msg').is(':checked')) {$('.btnchk').prop('disabled',true).css('backgroundColor','#d47a7a');}
  else{$('.btnchk').prop('disabled',false).css('backgroundColor','#f12121');} 
});
//=====================================================//
// input field focus
$('.form-control-edit').focus(function(){
  $(this).css({
    'border':'#f5b3b3',
  });
});
// input field blur
$('.form-control-edit').blur(function(){
  $(this).css({
    'border':'1px solid blue',
  });
});

/****** notifications part in profile.php*******/
$('.notify-container-all,.notify-a').click(function(){
  $('.notify-container-all').css('backgroundColor','white');
});

/********************** Edit ads   ***********************/
$('.kkl').click(function(){
  $('.img-edit-ads-page').hide();
});

/********************** action.php   ***********************/
//update users from action-us.php
$('.BtnUpdate').click(function(e){
  if ( $('#cityUp').val()==0 && $('#stateUp').val()>0 ) { e.preventDefault(); $('#cityUp').css('border','1px solid red');$('.note').addClass('red2 right').text('اختر مدينة '); }else{ return true;  }
});
// when changing city
$('#cityUp').change(function(){
  if ( $(this).val()>0 && $('#stateUp').val()>0 ) {  $(this).css('border','1px solid white');$('.note').addClass('red2 right').text(' '); }
  else if($(this).val()==0 && $('#stateUp').val()>0){  $(this).css('border','1px solid red');$('.note').addClass('red2 right').text('اختر مدينة '); }
});
//check accept terms first before submit => from action update trader data
$('.trData').submit(function(e){
  if (! $('.termsUpdate').is(':checked') ) {
    e.preventDefault();
    $('.read').css('border','1px solid red');
  }else if($('.termsUpdate').is(':checked')){
    $(this).unbind('submit').submit()
    $('.read').css('border','1px solid transparent');
  }
});


/*  DIV RELATIVE & ABSOLUTE TOGGLE  */
$('.div-absolute,.fa-minus').css('display','none');
$(".div-relative").click(function(){
 $(this).nextAll(".div-absolute").toggle();
 $(this).children(".fa-minus").toggle();
 $(this).children(".fa-plus").toggle();
}); 
//show input file when updating an item
$('.showFile').click(function(){
  $(this).nextAll('.new-photo-tr').toggle();
});
//



//=====================DETAILS PAGE=========================
//copy to clipboard
$('.btn-copy').click(function(){
  $('.inputCopy').select();
   document.execCommand("copy");
  $('.spanCopy').text('تم النسخ  ');
});

//enlarge details pic
$('.carousel-inner-dt img').hover(function(){
  $(this).css({'position':'absolute','z-index':'10','transition':'transform 0s ease 0s','transform':' scale(1.5)'}); 
},function(){
 $(this).css({'transform':'initial'}); 
});

//SENDING VOTES
//star1
var two=2; var three=3; var four=4; var five=5;
$('.rate1').click(function(){
  $(this).css('color','orange');
  $('.rate2,.rate3,.rate4,.rate5').css('color','grey');
  $('#one').val(1);
}); 
//star2
$('.rate2').click(function(){
  $('.rate1,.rate2').css('color','orange');
  $('.rate3,.rate4,.rate5').css('color','grey');
  $('#two').val(2);
}); 
//star3
$('.rate3').click(function(){
  $('.rate1,.rate2,.rate3').css('color','orange');
  $('.rate4,.rate5').css('color','grey');
  $('#three').val(3);
}); 
//star4
$('.rate4').click(function(){
  $('.rate1,.rate2,.rate3,.rate4').css('color','orange');
  $('.rate5').css('color','grey');
  $('#four').val(4);
}); 
//star5
$('.rate5').click(function(){
  $('.rate1,.rate2,.rate3,.rate4,.rate5').css('color','orange');
  $('#five').val(5);
}); 
//SENDING TO AJAX TO GET (Your vote is)
var hint=$('#hint').val();
  if(hint==1){$('.rate1').addClass('orange');}
  if(hint==2){$('.rate1,.rate2').addClass('orange');}
  if(hint==3){$('.rate1,.rate2,.rate3').addClass('orange');}
  if(hint==4){$('.rate1,.rate2,.rate3,.rate4').addClass('orange');}
  if(hint==5){$('.rate1,.rate2,.rate3,.rate4,.rate5').addClass('orange');}
 /////////////////////////////
//thumbs up   
$('.chngThumb').on('click', function(){
  if($(this).hasClass('far')){
    $(this).removeClass('far');
    $(this).addClass('fas');  
  }else{
    $(this).removeClass('fas');
    $(this).addClass('far');
  }
});
//report comments -> change icon
$('.Rflag').on('click', function(){
  if($(this).hasClass('far')){
    $(this).removeClass('far');
    $(this).addClass('fas');  
  }else{
    $(this).removeClass('fas');
    $(this).addClass('far');
  }  
});

//click to show report
$('.fa-exclamation').on('click', function(){
  $('.div-report').toggle();   
});

/////////////////////
//radios for sending report
$('.immoral').click(function(){
  //'use strict';
  $(this).prop('checked',true);
  $('.repeated').prop('checked',false);
  $('.fraud').prop('checked',false);
  $('.other').prop('checked',false);
});
$('.repeated').click(function(){
  //'use strict';
  $(this).prop('checked',true);
  $('.immoral').prop('checked',false);
  $('.fraud').prop('checked',false);
  $('.other').prop('checked',false);
});
$('.fraud').click(function(){
  //'use strict';
  $(this).prop('checked',true);
  $('.immoral').prop('checked',false);
  $('.repeated').prop('checked',false);
  $('.other').prop('checked',false);
});
$('.other').click(function(){
  //'use strict';
  $(this).prop('checked',true);
  $('.immoral').prop('checked',false);
  $('.repeated').prop('checked',false);
  $('.fraud').prop('checked',false);
});
// click on other to show input to write a report
$('.other').click(function(){
  $('.input-report').show();
});
//click on (immoral,.repeated,.fraud) to hide input 
$('.immoral,.repeated,.fraud').click(function(){
  $('.input-report').hide();
});



// click on old-sales to show ended sales
$('.old-sales,.click-here').click(function(){
  $('.sale2').toggle();
});
/******* cv *******/
$('.showCv').click(function(){
  $('.div-cv-hidden').toggle();
});

/***** edit or delete comments *****/
/* click on dots */
$('.dotEdit').click(function(){
  $(this).nextAll('.edit-delete-container').toggle();
  $('.edit-delete-container').not($(this).nextAll('.edit-delete-container') ).hide();
  $(this).parents('.div-comm-1').nextAll('.div-comm-2').children('#inputEditText').hide();
  $('.p-comment-homepage').show();
  $('.cancel').hide();
  $('.formEditText').hide();
});
/**** click on pen *****/
$('.fa-pen').click(function(){
 $(this).parents('.div-comm-1').nextAll('.div-comm-2').children('.p-comment-homepage').toggle();
 $(this).parents('.div-comm-1').nextAll('.div-comm-2').children('.cancel').toggle();
 $(this).parents('.div-comm-1').nextAll('.div-comm-2').children('#inputEditText').toggle();
});
//click on cancel
$('.cancel').click(function(){
 $(this).prevAll('#inputEditText').hide();
 $(this).nextAll('.p-comment-homepage').show();
 $(this).hide();
 $('.edit-delete-container').hide();
});
//disable sendEdit if text is empty
$('.sendEdit').click(function(e){
  var text=$(this).prevAll('.newText').val().length;
  if(text<1){
    e.preventDefault();
    $(this).addClass('disabled',true);
  }
});
// report improper comments
$('.dotReport').click(function(){
  $(this).nextAll('.report-container').toggle();
  $('.report-container').not($(this).nextAll('.report-container') ).hide();
});

//========================== END details.php =================================




});//END MAIN FUNCTION & END JS PAGE




 
 