b2.init.orderDetailsPage = function(){
	$('#ORDER_FORM').on('click', '.buyer-info-toggle', function(e){ 	// BACK_END change handler to live
		e.preventDefault();
		$('.buyer-info').slideToggle(400, function(){
			// refresh styled selects, because they are not initialized properly
			// due to display: none on .buyer-info on page load
			var selects = $(this).find('select');
			$.ikSelect && selects.ikSelect('redraw');
		});

		$(this).toggleClass('expanded');
		$('#showProps').val($('#showProps').val() === 'Y' ? 'N' : 'Y');

	})
}