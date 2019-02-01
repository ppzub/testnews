/*global */
/*jshint devel:true */

(function ($, window, undefined) {
	// console.log('Hi world!');

	$('.js-slider-main').slick({
		prevArrow: '<button class="slick-prev arrow"></button>',
		nextArrow: '<button class="slick-next arrow"></button>',
		slidesToShow: 1,
		slidesToScroll: 1,
		dots: true,
		autoplay: true,
		autoplaySpeed: 4000
	});

	$('.js-slider-popular').slick({
		prevArrow: '<button class="slick-prev arrow"></button>',
		nextArrow: '<button class="slick-next arrow"></button>',
		slidesToShow: 3,
		slidesToScroll: 3,
		responsive: [
		  {
		    breakpoint: 960,
		    settings: {
		      slidesToShow: 4,
		      slidesToScroll: 4
		    }
		  },
		  {
		    breakpoint: 768,
		    settings: {
		      slidesToShow: 5,
		      slidesToScroll: 5
		    }
		  },
		  {
		    breakpoint: 641,
		    settings: {
		      slidesToShow: 4,
		      slidesToScroll: 4
		    }
		  },
		  {
		    breakpoint: 481,
		    settings: {
		      slidesToShow: 3,
		      slidesToScroll: 3
		    }
		  },
		  {
		    breakpoint: 361,
		    settings: {
		      slidesToShow: 2,
		      slidesToScroll: 2
		    }
		   }]
	});
	$('.js-slider-media').slick({
		prevArrow: '<button class="slick-prev arrow"></button>',
		nextArrow: '<button class="slick-next arrow"></button>',
		slidesToShow: 4,
		slidesToScroll: 4,
		responsive: [
		  {
		    breakpoint: 960,
		    settings: {
		      slidesToShow: 6,
		      slidesToScroll: 6
		    }
		  },
		  {
		    breakpoint: 768,
		    settings: {
		      slidesToShow: 5,
		      slidesToScroll: 5
		    }
		  },
		  {
		    breakpoint: 641,
		    settings: {
		      slidesToShow: 4,
		      slidesToScroll: 4
		    }
		  },
		  {
		    breakpoint: 481,
		    settings: {
		      slidesToShow: 3,
		      slidesToScroll: 3
		    }
		  },
		  {
		    breakpoint: 361,
		    settings: {
		      slidesToShow: 2,
		      slidesToScroll: 2
		    }
		   }]
	});

	$(".video_block, .block_news_chat").fitVids({ customSelector: "iframe[src*='ustream.tv']"});

	// $('.js-rates, .js-weather').on('click', function (event) {
	// 	event.preventDefault();
	// 	$(this).addClass('is-open');

	// });
	// $(document).on('click', function (event) {
	// 	if ($(event.target).closest('.js-rates').length) return;
	// 	$('.js-rates').removeClass('is-open');
	// 	event.stopPropagation();
	// });

	// $(document).on('click', function (event) {
	// 	if ($(event.target).closest('.js-weather').length) return;
	// 	$('.js-weather').removeClass('is-open');
	// 	event.stopPropagation();
	// });

	$('.avers-home a.view-online').on('click', function(){
		var leg=$('.yvideo').data("src");
    	$('.yvideo').attr("src",leg+'?autoplay=true');
    	setTimeout(function() {$('.avers-home').hide();$('.avers-tv').show();return false;}, 300);
    	
		return false;
	});

	$('.avers-tv a').on('click', function(){
		$('.avers-tv').hide();
		$('.avers-home').show();
	  	var leg=$('.yvideo').data("src");
    	$('.yvideo').attr("src",leg);
		return false;
	});
 
})(jQuery, window);
