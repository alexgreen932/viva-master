jQuery(document).ready(function($) {
  console.log(' do          5  ');
  


  // showFlag();
  // stick menu
/*$(window).scroll(function(event) {
  var scrollTop = $(window).scrollTop();
  var elementOffset = $('.v-stick-resize').offset().top;
  var isFixed = $('.v-stick-resize').is('v-stick-resize-fixed');

  if (scrollTop > elementOffset && !isFixed) {
    $('.v-stick-resize').addClass('v-stick-resize-fixed');
  } else if (scrollTop < elementOffset && isFixed) {
    $('.v-stick-resize').removeClass('v-stick-resize-fixed');
  }
});*/

/*   $(window).scroll(function(event) {
    var scrollTop = $(window).scrollTop();
    if ( scrollTop > $('.v-stick-resize').offset().top ) { 
      if ($('.v-stick-resize').is(":not(.v-stick-resize-fixed)")) {
        console.log(" not v-stick-resize-fixed");
        $('.v-stick-resize').addClass('v-stick-resize-fixed');
      }else{
        console.log("already v-stick-resize-fixed");

      }
      
    }else{
      if ($('.v-stick-resize').is('.v-stick-resize-fixed')) {
        $('.v-stick-resize').removeClass('v-stick-resize-fixed');
      }
    }
  }); */


  $('#v-show-admin-bar').click(function (e) {
    e.preventDefault();
    $('body').toggleClass('v-show-admin');
  });

  //mobile buttons - shows menu in mobile
  $('.v-mobile').each(function(index, el) {
    var i = $(this).data('v-show');
    $(this).click(function (e) {
      e.preventDefault();
      $('#' + i).toggleClass('v-slide-left');
    });
  });
  //hide menu on click outside
  $(document).mouseup(function (e) {
  if ($(e.target).closest(".v-menu").length === 0) {
  $(".v-menu").removeClass('v-slide-left');
  }
  });
  //functions
  //language switcher
  function showFlag() {
    /*function explode(){
      var f = $("#gtr select option:first").val();
      
    }*/
    // setTimeout(explode, 2000);
      // var f = $('#gtr select option').first().val();
    // let f = document.querySelectorAll(".goog-te-combo option")[0].value;
   /* $(".goog-te-combo option").on('change', function (event) {
          var str = $('option',this).val();
          
      })*/
$('.goog-te-combo').on('change',(event) => {
     alert( event.target.value );
     
 });
      // f = $(f).val();
      
      // var f = $(".goog-te-combo option:first").val();
/*      $(value).on('change', function (event) {
          var str = $(this).val();
          $('#ok_frame').contents().find(target).removeAttr('class');
          $('#ok_frame').contents().find(target).addClass(str);
      });*/
  }

});