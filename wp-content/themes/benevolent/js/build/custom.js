jQuery(document).ready(function($){
   
   /** Variables from Customizer for Slider settings */
    if( benevolent_data.auto == '1' ){
        var slider_auto = true;
    }else{
        var slider_auto = false;
    }
    
    if( benevolent_data.loop == '1' ){
        var slider_loop = true;
    }else{
        var slider_loop = false;
    }
    
    if( benevolent_data.pager == '1' ){
        var slider_control = true;
    }else{
        var slider_control = false;
    }
    if( benevolent_data.rtl == '1' ){
        var rtl = true;
    }else{
        var rtl = false;
    }

    if( benevolent_data.animation == 'slide' ){
        var slider_animation = '';
    }else{
        var slider_animation = 'fadeOut';
    }
    
    /** Home Page Slider */
    $("#banner-slider").owlCarousel({
        items           : 1,
        margin          : 0,
        loop            : slider_loop,
        autoplay        : slider_auto,
        nav             : false,
        dots            : slider_control,
        animateOut      : slider_animation,
        autoplayTimeout : benevolent_data.speed,
        lazyLoad        : true,
        mouseDrag       : false,
        rtl             : rtl,
        autoplaySpeed   : benevolent_data.a_speed,
    });
   
   $('.number').counterUp({
        delay: 10,
        time: 1000
    });
   
   $( "#tabs" ).tabs();
   
   $('#responsive-menu-button').sidr({
      name: 'sidr-main',
      source: '#site-navigation',
      side: 'right'
    });

   $('#responsive-secondary-menu-button').sidr({
      name: 'sidr-main2',
      source: '#top-navigation',
      side: 'left'
    });
   
});