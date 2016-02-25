
(function($){

$(document).on('click', '[data-hnd-toggle]', function() {
	history.pushState('', document.title, window.location.pathname);
	$($(this).data('hnd-toggle')).toggleClass('active');
});

$(document).on('click', '[role="anchor"]', function(event) {
	var name = $(this).attr('href').replace('#', '');
	var target = $('a[role="target"][name="'+name+'"]');
	var positionTop = target.offset().top;
	$('#about_us_page').scrollTop(positionTop);
	event.preventDefault();
	console.log('name', name);
	console.log('positionTop', positionTop);
	console.log('target', target);
});

$(document).foundation({
	tab: {
		callback : function (tab) {
			console.log(tab);
		}
	}
});

})(jQuery);