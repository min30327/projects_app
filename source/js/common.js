;(function($){
	$(function(){
		Contents.device();
	});

	var Contents = {

		device : function(){
			$(window).on('load resize',function(){
				var mainH = $('.main').height();
				var winH = $(window).height();
				if(mainH < winH){
					$('.main').height(winH);
				}
			})
		}

	}
})(jQuery);
