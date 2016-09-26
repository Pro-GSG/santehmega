b2.init.scrollbarsTargeted = function(target){
	$(target).find('.scroller_v').baron({
		bar: '.scroller__bar_v',
		barOnCls: 'baron',
		direction: 'v',
	});
}

b2.init.scrollbars = function(){
	if (!$().baron) return;
	b2.init.scrollbarsTargeted(document);

	var $categories = $('#categories');
	$categories.length && $categories.find('.slides').baron({
		bar: '.scroller__bar_h',
		barOnCls: 'baron_h',
		direction: 'h',
	}).controls({
		track: '.scroller__track'
	});

	var $compareScroller = $('.compare-outer-wrapper>.scroller');
	$compareScroller.length && $compareScroller.baron({
		bar: '.scroller__bar_h',
		barOnCls: 'baron_h',
		direction: 'h',
	}).controls({
		track: '.scroller__track'
	});
}