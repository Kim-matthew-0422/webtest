$(document).ready(function(){
	$('#fullpage').fullpage({
		//responsiveWidth: 620,
        responsiveAutoHeight: 800,
		anchors: ['page1', 'page2', 'page3', 'page4', 'page5', 'page6'],
		navigation: true,
		navigationPosition: 'right',
		navigationTooltips: ['IM', 'BUSINESS', 'CLIENT', 'RECRUITMENT', 'INFO'],
		showActiveTooltip:true,
		onLeave: function(index, nextIndex, direction) {
			if (nextIndex > 1 && direction == 'down') {
				$('#header').addClass('activeHeader')
			} else if(nextIndex == 1 && direction == 'up'){
				$('#header').removeClass('activeHeader')
			}

			$(".quick-sns-fix").removeClass("on");
		}
	});

	var $mainSlide = $('.mainSlide');
		slideControls   = $('#mainVisual .slide-controls .dots');

	$('.revealing').revealing();
	$mainSlide.on('init', function(event, slick){
		$(".slick-slide").eq(0).addClass("active-item");
		$('.active-item .revealing').revealing('show');
		$('#mainVisual .active-item .TxtArea strong').animate({opacity:1}, 3000);
	});
	$mainSlide.on('beforeChange', function(event, slick, currentSlide, nextSlide){
		$('.revealing').revealing('hide');
		$('#mainVisual .active-item .TxtArea strong').animate({opacity:0}, 3000);
	});
	$mainSlide.on('afterChange', function(event, slick, currentSlide, nextSlide){
        $(".slick-slide").removeClass("active-item");
		$(this).find(".slick-slide").eq(currentSlide).addClass("active-item")
		$('.active-item .revealing').revealing('show');
		$('#mainVisual .active-item .TxtArea strong').animate({opacity:1}, 3000);
	});

	$mainSlide.slick({
		autoplay: true,
		autoplaySpeed: 5000,
		fade: true,
		dots: true,
		infinite: true,
		speed: 1000,
		slidesToShow: 1,
		arrows: false,
		pauseOnHover: false,
        appendDots: slideControls,
	});

	(function($) {
		$.fn.clickToggle = function(func1, func2) {
			var funcs = [func1, func2];
			this.data('toggleclicked', 0);
			this.click(function() {
				var data = $(this).data();
				var tc = data.toggleclicked;
				$.proxy(funcs[tc], this)();
				data.toggleclicked = (tc + 1) % 2;
			});
			return this;
		};
	}(jQuery));

	$('#mainVisual .btnPlay').clickToggle(function() {
		$mainSlide.slick('slickPause');
		$(this).addClass('play');
	}, function() {
		$mainSlide.slick('slickPlay');
		$(this).removeClass('play');
	});

	$(window).resize(function(){
		var winW = $(window).width();
			winH = $(window).height();

		if (winW > 1024 && winH < 800){
			$('#fullpage').addClass('pc_auto_height');
		} else if (640 < winW && winW < 1024 && winH < 750){
			$('#fullpage').addClass('pc_auto_height');
		} else {
			$('#fullpage').removeClass('pc_auto_height');
		}

		if (winW < 640){
			$('.fp-responsive .fp-section').addClass('fp-responsive-auto-height');
			$('#mainVisual').height(winH);
		} else {
			$('.fp-responsive .fp-section').removeClass('fp-responsive-auto-height');
		}
	}).resize();
});
