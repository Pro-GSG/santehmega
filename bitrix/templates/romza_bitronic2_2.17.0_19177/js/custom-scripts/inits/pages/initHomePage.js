b2.init.homePage = function(){
	b2.el.$coolSlider = $('#cool-slider');
	b2.el.$specialBlocks = $('#special-blocks');

	if ( b2.s.coolsliderEnabled && b2.el.$coolSlider.length && typeof UmCoolSlider === 'function'){
		b2.el.coolSlider = new UmCoolSlider(b2.el.$coolSlider);
	}
	$('.combo-link').children('a').on('click', function(e){
		e.stopPropagation();
	})
	if(typeof b2.el.$specialBlocks !='undefined' && b2.el.$specialBlocks.length > 0) {
		b2.el.specialBlocks = new UmComboBlocks(b2.el.$specialBlocks, {
			bp: 767,
			mode: b2.el.$specialBlocks.data('sb-mode'),
			defaultExpanded: ( b2.el.$specialBlocks.data('sb-mode-def-expanded') ) ? 'all' : (serverSettings.sbModeDefExpanded || 0),
			onOpen: function(target){
				setTimeout(function(){
					initPhotoThumbs(target);
				}, 10);
				target.trigger('b2SblockTabOpen');
				var slider = target.find('.special-blocks-carousel').data('UmSlider');
				if (typeof slider !== 'undefined' && !!slider){
					slider.updatePages();
				}
			}
		});
	}

	$('.combo-link a.i-number, .combo-header a.i-number').on('click', function(e){
		e.stopPropagation();
	});

	if (b2.s.wowEffect == 'Y') {
		new WOW({
			offset: 100,
		}).init();
	}

	$('#comments-carousel').on('swipeleft', function() {
		$(this).carousel('next');
	}).on('swiperight', function() {
		$(this).carousel('prev');
	});

	b2.init.feedbackCarousel('.feedback');
	initBigSlider();
	initSpecialBlocks(document);
	initCatalogHover(document);
	initPhotoThumbs(document);
	initTimers(document);

	function loadHomePageChunks(){
		require([
			'libs/bootstrap/carousel.min',
			'init/sliders/initBrandsCarousel',
			'util/basket',
//			'init/initBuyClick',  BACK_END not need in ready project
			'init/initVideo'
		], function(){
//			b2.init.buyClick();   BACK_END not need in ready project
			b2.init.brandsCarousel();
		})
	}

	if (windowLoaded) loadHomePageChunks();
	else $(window).load(loadHomePageChunks);
}