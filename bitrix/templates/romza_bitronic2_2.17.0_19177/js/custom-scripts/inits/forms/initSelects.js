b2.init.selects = function(target){
	var iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );
	//if ( iOS ) return;
	// SELECT STYLING

	$.ikSelect && $(target).find('select').ikSelect({
		syntax: '<div class="ik_select_link"> \
					<span class="ik_select_link_text"></span> \
					<div class="trigger"></div> \
				</div> \
				<div class="ik_select_dropdown"> \
					<div class="ik_select_list"> \
					</div> \
				</div>',
		dynamicWidth: true,
		ddMaxHeight: 120,
		equalWidths: false,

		onInit: function(inst){
			inst.$listInner.addClass('scroller')
			.append('<div class="scroller__track scroller__track_v"> \
						<div class="scroller__bar scroller__bar_v"></div> \
					</div>');
			inst.$listInner.find('.scroller__track').off('mousedown.b2').on('mousedown.b2', function(e){
				b2.scrollClicked = true;
			});
		},

		onShow: function(inst){
			if ( inst.$dropdown.outerWidth() < inst.$link.outerWidth() ){
				inst.$dropdown.css('width', inst.$link.outerWidth());
			}
			inst.$link.addClass('opened');
			var inited = typeof inst.$listInner.attr('data-baron-v-id') !== 'undefined';

			if ( inited ){
				inst.$listInner.baron().update();
				return;
			}

			$().baron && inst.$listInner.baron({
			 	bar: inst.$list.find('.scroller__bar_v'),
	 		 	barOnCls: 'baron',
	 		 	direction: 'v'
			});
		},
		onHide: function(inst){
			inst.$link.removeClass('opened');
		}
	});
	// END OF SELECT STYLING
}