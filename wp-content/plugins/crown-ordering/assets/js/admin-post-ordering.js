(function($) {

	var isHierarchical = crownOrderingAdminPostOrderingData.isHierarchical;

	$(document).ready(function() {
		
		$('#sortable-posts-list > ol').nestedSortable({
			items: 'li',
			toleranceElement: '> div.sortable-post',
			handle: 'div.sortable-post',
			start: startSort,
			isTree: true,
			expandOnHover: 700,
			startCollapsed: false
		});
		$('#sortable-posts-list .collapse-toggle').on('click', function() {
			$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
		});

		$('.save-sortable-posts-list').on('click', savePostOrder);

	});

	function startSort(e, ui) {
		ui.placeholder.append('<div class="outline"></div>');
		$('.outline', ui.placeholder).height(ui.placeholder.height() - 2);
	}

	function savePostOrder(e) {
		var button = $(this);
		button.addClass('button-primary-disabled');
		button.next('.spinner').addClass('is-active');
		var posts = $('#sortable-posts-list > ol').nestedSortable('toHierarchy');
		var updatedPosts = getPostOrderData(posts, 0);
		$.post(crownOrderingAdminPostOrderingData.ajaxUrl, { action: 'update_post_order_meta_data', updatedPosts: updatedPosts }, function() {
			button.removeClass('button-primary-disabled');
			button.next('.spinner').removeClass('is-active');
		});
	}
	function getPostOrderData(posts, postParent) {
		var updatedPosts = new Array();
		for(var i = 0; i < posts.length; i++) {
			var postData = {
				ID: posts[i].id,
				menu_order: i + 1,
				post_parent: postParent
			};
			updatedPosts.push(postData);
			if(posts[i].children) {
				updatedPosts = updatedPosts.concat(getPostOrderData(posts[i].children, posts[i].id));
			}
		}
		return updatedPosts;
	}

})(jQuery);