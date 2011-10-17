(function($){

	var book, book_cover, book_inside, book_back,
		app = {};

	app.init = (function() {
		app.load();
		app.bindEvents();
		app.start();
	})();

	app.load = function() {
		//loader cf impact.js
		//todo preload images
		less.env = 'development';
		less.watch();

		$.getJSON('javascripts/app/settings.json', function(data) {
			app.settings = data;
		});
	};

	app.bindEvents = function() {

		// Open links in an another tab
		$('.book-back li a').live('click', function() { 
			$(this).attr('target', '_blank');
		});

		//page_left.lettering();
		//page_right.lettering();
	};

	app.start = function() {
		window.setTimeout(function() {
			$('#book-inside')
				.tmpl(app.settings)
				.appendTo('#book');

			$('#book').fadeIn(1500, function() {
				app.displayInside();
			});
		}, 1000);
	};

	app.displayInside = function() {
		var exposition = $('.exposition');
		exposition.lettering();
		exposition.toggle();
		var letters = exposition.find('span'),
			last = letters.length - 1;

		$('.code').fadeIn(1500, function() {
			letters.each(function(index, value) {

				window.setTimeout(function() {
					$(value).fadeIn('slow');

					if (index === last) {
						$('.label').fadeIn(3000, function() {
							
						});
					}
				}, index * 15);

			});
		});
	};
	
})(jQuery);
