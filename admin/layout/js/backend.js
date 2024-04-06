
$(function(){

      //hide and show placeholder///////////////////////
     'use strict';
      $('[placeholder]').focus(function(){

      $(this).attr('go',$(this).attr('placeholder') );
      $(this).attr('placeholder', ' ');
      });

      $('[placeholder]').blur(function(){
          $(this).attr('placeholder',$(this).attr('go'));
      });


      //dropdowns toggle///////////////////////////////
      $('#dropdown-container').on('mouseover',function(){
        $('.div-img-dropdown-absolute').show();
      });
      $('#dropdown-container').on('mouseout',function(){
        $('.div-img-dropdown-absolute').hide();
      });



      //show and hide pass 
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


    //focus
    var inputstyle=$('.form-control-edit');
    $(inputstyle).focus(function(){
    $(this).css({
    'backgroundColor':'#f1fdff',
    'border':'1px solid transparent',
    'borderRadius':'6px'
    });});
    
    
// input fields for insert or update 
$(document).ready(function(){
  var inputstyle=$('.form-control-edit');
  $(inputstyle).css({
    'backgroundColor':'#f1fdff',
    
  });
});


//on focus
var inputstyle=$('.form-control-edit');
$(inputstyle).focus(function(){
    $(this).css({
    'backgroundColor':'#f1fdff',
    'border':'none',
  });
  });

 //on blur
  $(inputstyle).blur(function(){
    $(this).css({
    'backgroundColor':'#f1fdff',
    'border':'1px thin transparent',
  });
  });


  //placeholder for admin login
     var inputUsername= $('input[placeholder^="Enter email"]');
     var inputPassword= $('input[placeholder^="Enter password"]');

   //input username focus
 $(inputUsername).focus(function(){
  $(this).css({
    'backgroundColor':'#f1fdff',
    'border':         '3.5px solid blue',
    'borderRadius':   '6px',
    'width':          '300px',   
   
  });
});

   //input username blur
$(inputUsername).blur(function(){
  $(this).css({
    'backgroundColor':'#f1fdff',
    'border':'2px solid blue',
    'borderRadius':'6px',
    'width': '300px',
  });
});

   //input password focus
$(inputPassword).focus(function(){
  $(this).css({
    'backgroundColor':'#f1fdff',
    'border':         '3.5px solid blue',
    'borderRadius':   '6px',
    'width':          '300px',
  });
});

   //input password blur
$(inputPassword).blur(function(){
  $(this).css({
    'backgroundColor':'#f1fdff',
    'border':'2px solid blue',
    'borderRadius':'6px',
    'width': '300px',    
  });
});
/******* confirms ******/
//confirm to delete
$('.confirm').click(function(){
  return confirm('Are you sure you want to delete ?');
});
//confirm to remove row
$('.confirmRow').click(function(){
  return confirm('Are you sure you want to remove this row ?');
});
//confirm to activate
$('.confirmActivate').click(function(){
  return confirm('Are you sure you want to activate ?');
});
//confirm to ban
$('.confirmBan').click(function(){
  return confirm('Are you sure you want to ban ?');
});
//confirm to approve
$('.confirmApprove').click(function(){
  return confirm('Are you sure you want to approve ?');
});
//confirm action
$('.confirmAction').click(function(){
  return confirm('Are you sure you want to do this action ?');
});
//confirm to block
$('.confirmBlock').click(function(){
  return confirm('Are you sure you want to block this user ?');
});
//confirm to return
$('.confirmReturn').click(function(){
  return confirm('Are you sure you want to return this order ?');
});
//confirm to zero
$('.confirmZero').click(function(){
  return confirm('سيتم تصفير قيمة مستفيد ؛ موافق  ؟');
});

// input
$('.form-control-edit').focus(function(){
  $(this).css({
    'border':'1px solid red',
  });
});


$('.form-control-edit').blur(function(){
  $(this).css({
    'border':'1px solid blue',
  });
});

//preventDefault on update if category description is short or empty
$('#catInput').click(function(e){
  var des=$('#inputEmail33').val().length;
  var span=$('.span-hidden');

  if (des<20) {
     e.preventDefault();
       $(span).css({
       display:'block'
       });
       
  }else{
    return;
  }
});
/***** items.php *******/
$('.show-plans').click(function(){
  $(this).nextAll('.contain-plans').toggle();
  $('.contain-plans').not($(this).nextAll('.contain-plans')).hide();
});


/******** dashboard ********/
//refresh => das=reported
$('#refresh').click(function(){
  location.reload();
});
/*$('.home').click(function(){
 $('.containerDash').show();
$('.containerDash2,.containerDash3,.containerDash4').hide();
});
//
$('.latest').click(function(){
  $('.containerDash2').show();
  $('.containerDash,.containerDash3,.containerDash4,.containerDash5').hide();
});
//
$('.reported').click(function(){
 $('.containerDash3').show();
 $('.containerDash,.containerDash2,.containerDash4,.containerDash5').hide();
});
//
$('.messages').click(function(){
 $('.containerDash4').show();
 $('.containerDash,.containerDash2,.containerDash3,.containerDash5').hide();
});
//
$('.replies').click(function(){
 $('.containerDash5').show();
 $('.containerDash,.containerDash2,.containerDash3,.containerDash4').hide();
});*/














});