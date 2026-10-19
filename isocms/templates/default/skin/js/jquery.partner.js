;(function($){
  $.fn.rotate = function(options){
  var defaults = {
    speed:6,
    slide1:".slide1"
  }
  var options = $.extend(defaults, options);

  this.each(function(){
	var $ww = $(window).width();
    var thisR = $(this),
        thisC = thisR.children();
    thisR.append('<a href="javascript:;" class="rotate-prev">Prev</a>');
    thisC.append('<ul class="slide2" style="margin:0;padding:0;">'+ $(options.slide1).html() +'</ul>');
    thisR.css({'overflow':'hidden','width':options.width});
	thisC.css('width',$width_slide_panner*20).children().css({'float':'left','width':$width_slide_panner});
    function Marquee(){
      if(thisR.scrollLeft() >= $(options.slide1).width()){
        thisR.scrollLeft(0);
      }else{
        thisR.scrollLeft(thisR.scrollLeft()+1);
      }
    }
      var sliding=setInterval(Marquee,options.speed);
      thisR.hover(function() {
        clearInterval(sliding);
      },function(){
        sliding=setInterval(Marquee,options.speed);
      });
    });

}})(jQuery);
