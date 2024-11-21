jQuery(document).ready(function($) {
  console.log(' do          1  ');
  $('.v-el').each(function(index, el) {
    $(this).click(function(event) {
      //modals
      var dm = $(this).data('v-modal');
      $('#' + dm).fadeIn(300);
      $('#' + dm + '.v-modal-content').addClass('fade-in-top');
      //side panels
      var ds = $(this).data('v-side');
      $('#' + ds).fadeIn(300);
      $('#' + ds + '.v-panel-conent').addClass('fade-in-right');
      
    });
    //close ALL
    $('.v-close-all').click(function(event) {
      $('.v-modal, .v-panel-right').fadeOut(300);
    });
  });


  //admin bar
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