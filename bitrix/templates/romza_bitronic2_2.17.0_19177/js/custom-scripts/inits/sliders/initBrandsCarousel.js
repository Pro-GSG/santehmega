b2.init.brandsCarousel = function(){
	$(document).find('.brands-inner').each(function(){
		var $t = $(this),
			$prev = $t.siblings('.prev'),
			$next = $t.siblings('.next'),
			width = $t.outerWidth();
		
		$t.sly({
			prevPage: $prev,
			nextPage: $next
		})

		var timeout;
		$(window).resize(function(){
			clearTimeout(timeout);
			timeout = setTimeout(function(){
				if ( $t.outerWidth() !== width){
					width = $t.outerWidth();
					$t.sly('reload');
				}
			}, 200);
		})
	})
}