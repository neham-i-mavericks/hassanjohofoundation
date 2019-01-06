jQuery(document).ready(function($){

  /** Donation Plugin percent calc **/
  $('.give-goal-progress .raised .give-percentage').each(function(){
    var CalcRaise = $(this).text();
    var CalcVal = CalcRaise.replace('%', '');
    if( CalcVal > 100 ){
      var CalcRaise = '100%';
    }
    $(this).parent().css('margin-left','calc('+CalcRaise+' - 21px)');
  });

  if( charity_care_data.rtl == '1' ){
      var rtl = true;
  }else{
      var rtl = false;
  }
    
    /** Give Slider */
    $(".give-slider").owlCarousel({
        items       : 3,
        margin      : 20,
        loop        : true,
        nav         : true,
        dots        : false,
        lazyLoad    : true,
        mouseDrag   : false,
        navText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
        rtl         : rtl,
          responsive:{
           0:{
            items:1
          },
          768:{
            items:2
          },
          992:{
            items:3
          }
        }
    });

    function charity_care_align_community_content() {
      var width_body = jQuery('body').width();
      var width_page_wrap = jQuery('.site').width();
      var width_content = jQuery('body').find('.container').width();
      if (width_page_wrap != width_content) {
          var indent = (width_page_wrap - width_content) / 2;
          if (width_body > 768) {
              jQuery('.our-community .community-holder .columns-2 .hover-state').each(function() {
                  jQuery(this).css('padding-right', indent);
              });
              jQuery('.our-community .community-holder .columns-2:nth-of-type(even) .hover-state').each(function () {
                  jQuery(this).css('padding-left', indent);
                  jQuery(this).css('padding-right', 0);
              });
          } else {
              jQuery('.our-community .community-holder .hover-state').each(function() {
                  jQuery(this).css('padding', 0);
              });
          }
      }
  }

  charity_care_align_community_content();

  $(window).resize(function () {
      charity_care_align_community_content();
  });

  /* Give Section Equal Height */
  $('.give-section .give-holder .post .text-holder').matchHeight({
      byRow: true,
      property: 'height',
      target: null,
      remove: false,

  }); 

});
