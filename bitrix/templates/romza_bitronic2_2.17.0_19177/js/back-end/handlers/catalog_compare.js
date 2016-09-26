function RZB2_initCompareHandlers($){
	// COMPARE PAGE
	$('main.compare-page')
	.on('click', '.remove-property', function(e){
		e.preventDefault();
		var _ = $(this);
		var spinner = RZB2.ajax.spinner(_.closest('th, td'));
		spinner.Start({width:2, radius:5, color:RZB2.themeColor});

		RZB2.ajax.ComparePage.SendRequest(_, function(res){
			//stop spinner
			spinner.Stop();
			delete spinner;
			//remove deleted table row
			var tr = _.closest('tr');
			var tbody = tr.parent('tbody');
			var trClass = tr.attr('class');
			var scroller = $('.compare-outer-wrapper .scroller');
			scroller.height(scroller.height() - tr.height());
			$('.compare-table tr.'+trClass).remove();
			if (tbody.length > 0 && tbody.children().not('.section-header').length < 1) {
				scroller.height(scroller.height() - tbody.height());
				$('.compare-table tbody.'+tbody.attr('class')).remove();
			}
			//update list of deleted properties
			var $res = $(res);
			var $deletedRes = $res.find('.deleted-properties');
			var $deletedDiv = $('.deleted-properties');
			if ($deletedDiv.length > 0) {
				$deletedDiv.html($deletedRes.html());
			} else {
				$('main.compare-page').append($deletedRes);
			}
		});
	})
	.on('click', '.compare-switch, .compare-item .btn-close, .deleted-property a', function(e){
		e.preventDefault();
		var spinner = RZB2.ajax.spinner($(this));
		spinner.Start({width:2, radius:5});

		var $container = $('main.compare-page');
		RZB2.ajax.loader.Start($container);

		RZB2.ajax.ComparePage.SendRequest($(this), function(res){
			$body.off('.b2comparepage');
			$(window).off('.b2comparepage');

			var $res = $('<div>'+res+'</div>');
			var $main = $res.find('main.compare-page');//.andSelf().filter('main.compare-page');
			if($main.length)
			{
				$container.html($main.html());
				b2.init.comparePage();
			}
			else
			{
				$container.html($res.html());
			}
			$newURL = $res.find('#compareURL');
			if ($newURL.length > 0) {
				RZB2.ajax.setLocation($newURL.val());
				RZB2.ajax.Compare.Refresh();
			}
			
			$(window)
				.trigger('scroll.b2comparepage')
				.trigger('b2ready');
			RZB2.ajax.BasketSmall.RefreshButtons();
			RZB2.ajax.loader.Stop($container);
		});
	});
}

if (typeof domReady != "undefined" && domReady == true) {
	RZB2_initCompareHandlers(jQuery);
} else {
	jQuery(document).ready( RZB2_initCompareHandlers );
}
