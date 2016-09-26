RZB2.ajax.Review =
{
	Blog:
	{
		ChangePage: function ($target, page) {
			var $blog_comments = $('#blog_comments');
			
			$target.addClass('active').siblings('a').removeClass('active');
			$blog_comments.find('[id ^= "blog-comment-page-"]').hide().filter('[id ^= "blog-comment-page-' + page + '"]').show();
			
			RZB2.ajax.scrollPage($blog_comments);
		},
		
		Refresh: function () {
			var $formBlogComment = $('#form_comment_blog');
			
			if(!$formBlogComment.length) return false;
			
			var arBlogParams = $formBlogComment.serializeArray()
			var data = [];
			for(var key in arBlogParams)
			{
				if(arBlogParams[key].name == 'ID' || arBlogParams[key].name == 'IBLOCK_ID' || arBlogParams[key].name == 'ELEMENT_ID')
					data.push({name: arBlogParams[key].name, value: arBlogParams[key].value});
			}
			
			this.SendRequest(false, data, true);
			return true;
		},
		
		SendRequest: function ($form, data, fullRefresh) {
			if (typeof(data) == 'undefined') {
				data = [];
			}
			data.push({name: "REQUEST_URI", value: RZB2.ajax.params['REQUEST_URI']});
			data.push({name: "SCRIPT_NAME", value: RZB2.ajax.params['SCRIPT_NAME']});
			data.push({name: "rz_ajax", value: 'Y'});
			data.push({name: "comment_mode", value: 'blog'});
			data.push({name: "sessid", value: BX.bitrix_sessid()});
			var $blog_comments = $('#blog_comments');
			RZB2.ajax.loader.Start($blog_comments);
			$.ajax({
				type: "POST",
				url: SITE_DIR + "ajax/catalog_comments.php",
				data: data,
				success: function (res) {
					if(fullRefresh)
						$blog_comments.empty().html(res);
					else
					{
						$form.parent('.form-wrap').remove();
						$blog_comments.prepend(res);
						$blog_comments.find('div.mar-b-15').remove();
					}
					RZB2.ajax.loader.Stop($blog_comments);
					RZB2.ajax.Review.UpdateReviewTop();
				}
			})
		},
	},
	
	Forum:
	{
		params: [],
		ChangePage: function (page, pagen_key) {
			var $forum_comments = $('#forum_comments');
			var data = [];
			
			$.extend(data,this.params);
			data.push({name: pagen_key, value: page});
			this.SendRequest(data);
			RZB2.ajax.scrollPage($forum_comments);
		},
		
		Refresh: function () {
			var $formForumComment = $('#form_comment_forum');
			
			if(!$formForumComment.length) return false;
			
			var arForumParams = $formForumComment.serializeArray()
			var data = [];
			for(var key in arForumParams)
			{
				if(arForumParams[key].name == 'IBLOCK_ID' || arForumParams[key].name == 'ELEMENT_ID')
				{
					data.push({name: arForumParams[key].name, value: arForumParams[key].value});
					this.params.push({name: arForumParams[key].name, value: arForumParams[key].value});
				}
			}
			
			this.SendRequest(data);
			return true;
		},
		
		SendRequest: function (data) {
			if (typeof(data) == 'undefined') {
				data = [];
			}
			data.push({name: "REQUEST_URI", value: RZB2.ajax.params['REQUEST_URI']});
			data.push({name: "SCRIPT_NAME", value: RZB2.ajax.params['SCRIPT_NAME']});
			data.push({name: "rz_ajax", value: 'Y'});
			data.push({name: "comment_mode", value: 'forum'});
			data.push({name: "sessid", value: BX.bitrix_sessid()});
			var $forum_comments = $('#forum_comments');
			RZB2.ajax.loader.Start($forum_comments);
			$.ajax({
				type: "POST",
				url: SITE_DIR + "ajax/catalog_comments.php",
				data: data,
				success: function (res) {
					$forum_comments.replaceWith(res);
					RZB2.ajax.loader.Stop($forum_comments);
					RZB2.ajax.Review.UpdateReviewTop();
				}
			})
		},
	},

	Init: function () {
		if (RZB2.ajax.Review.Blog.Refresh()) return;
		if (RZB2.ajax.Review.Forum.Refresh()) return;
		RZB2.ajax.Review.UpdateReviewTop();
	},
	UpdateReviewTop: function () {
		if ($('.comment-wrap').length) {
			$('a.write-review_top .be-first').hide();
		} else {
			$('a.write-review_top .be-first').removeClass('init');
		}
	}
};


// SERVICES ON DETAIL PAGE
RZB2.ajax.Services =
{
	AddToBasket: function(product_name, iblock_id, quantity)
	{
		var data = {items:{}};
		data.action = 'addList';
		data.rz_ajax = 'y';
		data.iblock_id = iblock_id;
		$('.buy-block-additional input[type="checkbox"]').filter(':checked').each(function(){

			var id = parseInt($(this).data('service-id'), 10);
				
			data.items[id] = {
				id: id,
				quantity: parseInt(quantity, 10),
				props: [
					{NAME: BX.message('MESS_FOR'), VALUE: product_name}
				]
			};
		});

		if (data.items.length < 1) return;
		
		this.SendRequest(data);
	},
		
	SendRequest: function(data)
	{
		$.ajax({
			url: SITE_DIR + 'ajax/basket.php',
			type: "POST",
			data: data,
			dataType: 'json',
			success: function(data){
				RZB2.ajax.BasketSmall.Refresh();
			}
		});
	}
};
