var ClickEvent = window.ontouchstart===null?"touchstart":"click";
;(function($){
	$(function(){
		$(window).on('load resize',function(){
			setTimeout(
			   function(){
			   	Contents.device();
			 },10);
		});
		$('.nav-tabs li').on(ClickEvent,function(){
			setTimeout(
			   function(){
				Contents.device();
			 },10);
		})
	});
	var break_points = {
			xs : '400',
			sm : '768',
			md : '992',
			lg : '1200'
	};

	var Contents = {

		device : function(){
				var main = $('.main');
				main.height('auto');
				var mainH = main.height();
				var winH = $(window).height();
				if(mainH <= winH){
					main.height(winH);
				}else{
					main.height('auto');
				}
				this.height();
		},
		height : function(){
				var winW = $(window).width();
				tile_heights('')
				function tile_heights(size){
					for (i = 1; i < 10; i++) {
						$('.height-'+ size + i).find('.height-el').tile(i);
					}
				}
				function reset_heights(size){
					for (i = 1; i < 10; i++) {
						$('.height-'+ size + i).find('.height-el').css('height','auto');
					}
				}
				if(break_points.xs >= winW){
					tile_heights('xs-');
				}else{
					reset_heights('xs-');
				}
				if(break_points.sm <= winW){
					tile_heights('sm-');
				}else{
					reset_heights('sm-');
				}
				if(break_points.md <= winW){
					tile_heights('md-');
				}else{
					reset_heights('md-');
				}
				if(break_points.lg <= winW){
					tile_heights('lg-');
				}else{
					reset_heights('lg-');
				}
		}

	};
})(jQuery);
