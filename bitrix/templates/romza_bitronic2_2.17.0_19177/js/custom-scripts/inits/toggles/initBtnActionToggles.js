b2.init.btnActionToggles = function(){
	$( document ).on('click', 'button.action.toggleable', function(){
		var _ = $(this);
		
		_.toggleClass('toggled');
		if ( _.hasClass('toggled') ){
			if ( _.hasClass('favorite') ){
				_.attr('title', 'Убрать из избранного').tooltip();
			} else if ( _.hasClass('compare') ){
				_.attr('title', 'Убрать из списка сравнения').tooltip();
			} else if ( _.hasClass('to-waitlist') ){
				_.attr('title', 'Убрать из отложенных').tooltip();
			}
		} else {
			_.attr('title', '').tooltip('destroy');
		}
	})

	$('.btn-action.compare').on('click', function(){
		var _ = $(this);
		_.toggleClass('toggled');
		if ( _.hasClass('toggled') ){
			_.attr('title', 'Убрать из списка сравнения');
		} else {
			_.attr('title', 'Добавить в <strong>список сравнения</strong>');
		}
		_.tooltip('fixTitle').tooltip('show');
	})
	$('.btn-action.favorite').on('click', function(){
		var _ = $(this);
		_.toggleClass('toggled');
		if ( _.hasClass('toggled') ){
			_.attr('title', 'Убрать из избранного');
		} else {
			_.attr('title', 'Добавить в <strong>избранное</strong>');
		}
		_.tooltip('fixTitle').tooltip('show');
	})
}