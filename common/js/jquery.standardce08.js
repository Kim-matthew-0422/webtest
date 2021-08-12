jQuery(function($){
	//topmenu GNB
	$.fn.topmenu = function(options) {
		var opts = $.extend(options);
		var topmenu = $(this);
		var topmenuList = topmenu.find('>ul>li');
		var submenu = topmenu.find('.submenu');
		var submenuList = submenu.find('>ul>li');

		function showMenu() {
			t = $(this).parent('li');
			if (!t.hasClass('m_active')) {
				topmenuList.removeClass('m_active');
				t.addClass('m_active');
				submenu.hide();
				t.find('.submenu').show().css('top', 50).animate( { top: 70, opacity:1 }, 200 );
			}
		}

		function hideMenu() {
			topmenuList.removeClass('m_active');
			submenu.hide();
			activeMenu();
		}

		function activeMenu() {
			if(opts.d1) {
				t = topmenuList.eq(opts.d1-1);
				t.addClass('m_active');
				t.find('.submenu').show().css('top', 50).animate( { top: 70, opacity:1 }, 200 );
				if(opts.d2) {
					t.find('.submenu>ul>li').eq(opts.d2-1).addClass('on');
				}
			}
		}

		return this.each(function() {
			activeMenu();
			topmenuList.find('>a').mouseover(showMenu).focus(showMenu);
			topmenu.mouseleave(hideMenu);
		});
	}

	$('#layerPop01, #layerPop02, #layerPop03, #layerPop04').hide();
	$('.layerPop01').click(function(){
		$('#layerPop01').fadeIn();
	});
	$('.layerPop02').click(function(){
		$('#layerPop02').fadeIn();
	});
	$('.layerPop03').click(function(){
		$('#layerPop03').fadeIn();
	});
	$('.layerPop04').click(function(){
		$('#layerPop04').fadeIn();
	});
	$('.closeBtn .close').click(function(){
		$('#layerPop01, #layerPop02, #layerPop03, #layerPop04').fadeOut();
	});

});



//체크박스, 라디오 박스 커스텀
function setuplabel(){
	if ($('.comm_check_label input').length) {
		$('.comm_check_label').each(function(){
			$(this).removeClass('check_on');
		});
		$('.comm_check_label input:checked').each(function(){
			$(this).parent('label').addClass('check_on');
		});
	};
	if ($('.comm_radio_label input').length) {
		$('.comm_radio_label').each(function(){
			$(this).removeClass('radio_on');
		});
		$('.comm_radio_label input:checked').each(function(){
			$(this).parent('label').addClass('radio_on');
		});
	};
};


$(document).ready(function(){

	//체크박스, 라디오 박스 커스텀 - 이벤트 실행
	$('.comm_check_label, .comm_radio_label').click(function(){
		setuplabel();
	});
	setuplabel();

	function scrollH(){
		var scT = $(window).scrollTop();

		if ($('#wrap').hasClass('sub') || ($('#wrap').hasClass('main') && $(window).width() < 640 ) ){
			if (scT >= 0){
				$('#header').addClass('blackHeader');
			} else {
				$('#header').removeClass('blackHeader');
			}
		}
	}
	scrollH();

	$(window).scroll(function(){
		scrollH();
	})

	$('.overlay').click(function(){
		if ($('#allMenu').hasClass('active')){
			closeAllmenu();
		}
	})

	$(".allmenu_wrap ul li a").click(function(){
		setTimeout(function(){
			closeAllmenu();
		},250);
	});

	$(window).resize(function(){
		var winW = $(window).width();
			winH = $(window).height();

		if (winW > 1024){
			if ($('#allMenu').hasClass('active')){
				closeAllmenu()
			}
		}
	}).resize();





	var wow = new WOW(
	  {
		boxClass:     'ani',      // animated element css class (default is wow)
		animateClass: 'animated', // animation css class (default is animated)
		offset:       0,          // distance to the element when triggering the animation (default is 0)
		mobile:       true,       // trigger animations on mobile devices (default is true)
		live:         true,       // act on asynchronously loaded content (default is true)
		callback:     function(box) {
		  // the callback is fired every time an animation is started
		  // the argument that is passed in is the DOM node being animated
		},
		scrollContainer: null // optional scroll container selector, otherwise use window
	  }
	);
	wow.init();











});

//전체메뉴
function allMenu(){
	$('#allMenu').addClass('active');
	$('.overlay').fadeIn(300);
	 $('html').addClass('fixed');
	disableScroll();
}

function closeAllmenu(){
	$('#allMenu').removeClass('active');
	$('.overlay').fadeOut(300);
	$('html').removeClass('fixed');
	enableScroll();
}

// 모바일 스크롤 락 & 언락 설정
function preventDefault(e){
	e.preventDefault();
}
function disableScroll(){
	document.body.addEventListener('touchmove', preventDefault, { passive: false });
}
function enableScroll(){
	document.body.removeEventListener('touchmove', preventDefault, { passive: false });
}
