function RZB2_initCatalogHandlers($){
	// CATALOG - change quantity
	$('.catalog-page .show-by select.show-by').on('change', function(e){
		e.stopPropagation();
		
		var $select = $('.catalog-page .show-by select.show-by');
		$select.find('option[value="'+$(this).val()+'"]').prop('selected', true);
		$select.ikSelect('reset');
		
		RZB2.ajax.CatalogSection.Start(this, {'page_count':$(this).val()});
	})
	.closest('.show-by.disabled').removeClass('disabled');
	
	// CATALOG - change view
	$('.catalog-page .sort-n-view .view-type a').on('click', function(e){
		e.stopPropagation();
		e.preventDefault();

		var $_ = $(this);
		
		if($_.hasClass('active'))
		{
			return;
		}
		else
		{
			$_.addClass('active').siblings('a').removeClass('active');
			RZB2.ajax.CatalogSection.Start(this, {'view':$_.data('view')}, smallSpinnerParams);
		}
	});
	
	// CATALOG - change page
	$('.catalog-page .pagination').on('click', 'a',function(e){
		e.preventDefault();
		e.stopPropagation();
		if (!$(this).hasClass('active'))
		{
			var pagenKey = $(this).attr('data-pagen-key');
			var params = {};
			params[$(this).attr('data-pagen-key')] = $(this).attr('data-page');
			RZB2.ajax.CatalogSection.Start(this, params, smallSpinnerParams);
		}
	});
	// CATALOG - change page by infinity loader
	$('.catalog-page').on('click', '.more-catalog', function (e) {
		e.preventDefault();
		e.stopPropagation();
		if (!$(this).hasClass('disabled')) {
			var pagenKey = $(this).attr('data-pagen-key');
			var params = {};
			params[$(this).attr('data-pagen-key')] = $(this).attr('data-page');
			params['MORE_CLICK'] = 1;
			RZB2.ajax.CatalogSection.Start($(this).find('.btn-plus'), params);
		}
	});
	
	// CATALOG - change sort MOBILE
	$('.catalog-page #sort-by').on('change', function(e){
		var sortItem = $(this).find('option:selected');
		RZB2.ajax.CatalogSection.Start(this, {'sort': sortItem.data('sort') , 'by' : sortItem.data('sort-by')}, smallSpinnerParams);
	});
	
	// CATALOG - change sort
	$('.catalog-page ul.sort-list li').on('click', function(e){
		if($(this).hasClass('active'))
		{
			if($(this).data('sort-by') == 'asc')
			{
				$(this).data('sort-by', 'desc');
			}
			else
			{
				$(this).data('sort-by', 'asc');
			}
		}
		RZB2.ajax.CatalogSection.Start(this, {'sort': $(this).data('sort') , 'by' : $(this).data('sort-by')}, smallSpinnerParams);		
	});
	
	// CATALOG - TABLE - add to basket list
	$('.catalog-page').on('click', '#add_basket_table', function(e){
		$(this).css('position', 'relative').addClass('disabled');
		RZB2.ajax.CatalogSection.Table.AddToBasket(this, {radius: 5, color: RZB2.themeColor, top: '45%'});
	});

	// CATALOG BRANDS
	$('.brands-catalog').on('togglebrand', function(e, data){
		var id = data.item.data('checkbox');
		$('#'+id).click();
	});

	RZB2.ajax.CatalogSection.RefreshButtons();
}

if (typeof domReady != "undefined" && domReady == true) {
	RZB2_initCatalogHandlers(jQuery);
} else {
	jQuery(document).ready( RZB2_initCatalogHandlers );
}

//@ sourceURL=js/back-end/handlers/catalog_section.js
