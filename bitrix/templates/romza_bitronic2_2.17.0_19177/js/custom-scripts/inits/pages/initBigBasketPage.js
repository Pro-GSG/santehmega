b2.init.bigBasketPage = function(){
	new UmTabs('.um_tab', {
		onChange: function(target){
			$.ikSelect && $(target).find('select').ikSelect('redraw');
		}
	});
}