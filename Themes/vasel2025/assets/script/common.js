$(function (e) {
	($width = $(window).innerWidth()), (wWidth = windowWidth());

	$(document).ready(function (e) {
			mainVisual();
			btnTop();
			popup();
			videoRolling();
			dropdownMenu();
			popRolling();

			if (wWidth < 1025) {
			} else {
			}

			resEvt();
	});

	// resize
	function resEvt() {
			tabMenu();
			pagTabMenu();
			onIntro();
			datePicker();
			speakersRolling();
			sponsorBanner();
			supportBanner();
			subMenu();
			toggle();
			touchHelp();

			if (wWidth < 1025) {
					mGnb();
					subConHeight();
					mTabMenu();
					popRolling();

					if ($('.js-dim').hasClass('mobile')) {
							$('.js-dim').show();
							$('html, body').addClass('ovh');
					}
			} else {
                gnb();
                if ($('.js-dim').hasClass('mobile')) {
                        $('.js-dim').hide();
                        $('html, body').removeClass('ovh');
                }
                $('.js-nav').height('');
                $('.js-tab-menu, .js-tabcon-menu').removeAttr('style');
                $('.js-btn-tab-menu, .js-btn-tabcon-menu').removeClass('on');
                $('body').off('click');

                //subConScroll();
                //$('.sub-menu-depth01').find('ul').removeAttr("style");
                $('.sub-menu-depth02').find('ul').removeAttr('style');
                $('.sub-menu-depth02').find('a').removeClass('on');

                $('.js-sponsor-rolling').each(function(e){
                    $(this).slick("unslick");
                })
        }

        if (wWidth < 769) {
                touchHelp();
        }
	}

	$(window).resize(function (e) {
			($width = $(window).innerWidth()), (wWidth = windowWidth());
			resEvt();
	});

	$(window).scroll(function (e) {
			if ($(this).scrollTop() > 200) {
					$('.js-btn-top').addClass('on');
			} else {
					$('.js-btn-top').removeClass('on');
			}
	});
});

function Mobile() {
	return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

function windowWidth() {
	if ($(document).innerHeight() > $(window).innerHeight()) {
			if (Mobile()) {
					return $(window).innerWidth();
			} else {
					return $(window).innerWidth() + 17;
			}
	} else {
			return $(window).innerWidth();
	}
}

function subConHeight() {
	$(document).ready(function (e) {
			var subConHeight = $(window).outerHeight() - $('.js-header').outerHeight() - $('#footer').outerHeight();
			setTimeout(function (e) {
					$('.sub-contents').css('min-height', subConHeight);
			}, 100);
	});
}

function mainVisual() {
	if ($('.js-main-visual .main-visual-con').length > 1) {
			$('.js-main-visual').not('.slick-initialized').slick({
				dots: true,
				arrows: false,
				autoplay: true,
				autoplaySpeed: 3000,
				speed: 1000,
				infinite: true,
				fade: true
			});
	}
}

function gnb() {
	var max_h = 0;
	$('.js-gnb > li > ul').each(function (e) {
			$(this).height('');
			var h = parseInt($(this).css('height'));
			if (max_h < h) {
					max_h = h;
			}
			gnb_h = max_h + 60;
	});

	$('.js-gnb > li > ul').css('height', max_h);

	$('.js-gnb > li').off().on('mouseenter', function (e) {
		$('.gnb-wrap > .gnb-bg').css('height', max_h);
		$('.js-gnb > li > ul').stop().fadeIn(200);
	});

	$('.js-gnb').off().on('mouseleave', function (e) {
		$('.gnb-wrap > .gnb-bg').css('height', '');
		$('.js-gnb > li > ul').stop().fadeOut(200);
	});
}

function mGnb() {
	$('.js-gnb > li').off('mouseenter');
	$('.js-gnb').off('mouseleave');
	$('.js-gnb ul').removeAttr('style');
	$('.js-dim').removeAttr('style');

	$('.js-gnb > li > a')
			.off()
			.on('click', function (e) {
					if ($(this).next('ul').length) {
							$(this).parent('li').toggleClass('on');
							$('.js-gnb > li > a').not(this).parent('li').removeClass('on');
							$(this).next('ul').stop().slideToggle();
							$('.js-gnb > li > a').not(this).next('ul').stop().slideUp();
							return false;
					}
			});

	$('.js-btn-menu-open').on('click', function (e) {
			$('html, body').addClass('ovh');
			$('.js-dim').addClass('mobile').show();
			$('#gnb').stop().animate({ left: 0 }, 400);
	});
	$('.js-btn-menu-close, .js-dim').on('click', function (e) {
			$('html, body').removeClass('ovh');
			$('.js-dim').removeClass('mobile').stop().hide();
			$('#gnb').stop().animate({ left: '-100%' }, 400);
	});
}

function speakersRolling(){
	if($('.js-speakers-rolling > .speakers-con').length > 3) {
			$('.js-speakers-rolling').not('.slick-initialized').slick({
					dots: false,
					arrows: true,
					prevArrow: $('.btn-speakers-prev'),
					nextArrow: $('.btn-speakers-next'),
					autoplay: true,
					autoplaySpeed: 3000,
					speed: 1000,
					infinite: true,
					slidesToShow: 3,
					slidesToScroll: 1,
					responsive: [
							{
								breakpoint: 1024,
								settings: {
									slidesToShow: 2,
								}
							},
							{
								breakpoint: 400,
								settings: {
									slidesToShow: 1,
								}
							},
						]
			});
	}
}

function sponsorBanner() {
	$('.js-sponsor-rolling').each(function(e){
		$(this).not('.slick-initialized').slick({
				dots: false,
				arrows: false,
				autoplay: true,
				autoplaySpeed: 3000,
				speed: 1000,
				infinite: true,
				slidesToShow: 3,
				slidesToScroll: 1,
				responsive: [
					{
						breakpoint: 1024,
						settings: {
						slidesToShow: 3,
						slidesToScroll: 1
						}
					},
				]
		});
	});
}

function supportBanner() {
	$('.js-support-rolling').each(function(e){
		$(this).not('.slick-initialized').slick({
				dots: false,
				arrows: false,
				autoplay: true,
				autoplaySpeed: 3000,
				speed: 1000,
				infinite: true,
				slidesToShow: 2,
				slidesToScroll: 1,
		});
	});
}

function subMenu() {
	$('.js-btn-sub-menu').off().on('click', function (e) {
		$(this).next('ul').stop().slideToggle();
		$(this).toggleClass('on');
		$('.js-btn-sub-menu').not(this).removeClass('on').next('ul').stop().slideUp();
		return false;
	});
	$('body').off().on('click', function (e) {
		if ($('.js-sub-menu-list').has(e.target).length == 0) {
			$('.js-btn-sub-menu').removeClass('on');
			$('.js-btn-sub-menu:visible +  ul').stop().slideUp();
		}
	});
}

function toggle() {
	$("a.trigger").off();
	$("a.trigger").on("click", function(){
		var _currToggle = $(this).parent().parent(),
			sClass = $(this).parent().attr("class");
		
		if (sClass != "view") {
			$(this).parent().addClass("view");
			$(this).find("i").attr("class",  function(i){
				var src = $(this).attr("class");
				return src.replace("-down", "-up");
			});
			_currToggle.find(".toggleCon").slideDown();
		} else {
			$(this).parent().removeClass("view");
			$(this).find("i").attr("class",  function(i){
				var src = $(this).attr("class");
				return src.replace("-up", "-down");
			});
			_currToggle.find(".toggleCon").slideUp();
		}

		return false
	});
}

function tabMenu() {
	$('.js-tab-menu').each(function (e) {
			var cnt = $(this).children('li').length;
			$(this).addClass('n' + cnt + '');
	});
	$('.js-tab-menu li, .js-tabcon-menu li').off('click');

	$('.js-tab-menu2').each(function (e) {
			var cnt = $(this).children('li').length;
			$(this).addClass('n' + cnt + '');
	});

	tabConMenu();
}

function mTabMenu() {
	var activeTab = $('.js-tab-menu li.on > a').html();
	$('.js-btn-tab-menu').html(activeTab);
	$('.js-btn-tab-menu')
			.off()
			.on('click', function (e) {
					$(this).toggleClass('on');
					$(this).next('ul').stop().slideToggle();
					return false;
			});
	$('.js-btn-tab-menu + .js-tab-menu li')
			.off()
			.on('click', function (e) {
					var currentTab = $(this).html();
					$('.js-btn-tab-menu').html(currentTab);

					$(this).addClass('on');
					$(this).siblings().removeClass('on');

					$(this).parent('ul').stop().slideUp();
					$('.js-btn-tab-menu').removeClass('on');
			});

	var activeTabCon = $('.js-tabcon-menu li.on > a').html();
	$('.js-btn-tabcon-menu').html(activeTabCon);
	$('.js-btn-tabcon-menu')
			.off()
			.on('click', function (e) {
					$(this).toggleClass('on');
					$(this).next('ul').stop().slideToggle();
					return false;
			});
	// $('.js-tabcon-menu li').off().on('click',function(e){
	// 	var currentTab = $(this).html();
	// 	$('.js-btn-tabcon-menu').html(currentTab);

	// 	$(this).addClass('on');
	// 	$(this).siblings().removeClass('on');

	// 	$(this).parent('ul').stop().slideUp();
	// 	$('.js-btn-tabcon-menu').removeClass('on');
	// });
	tabConMenu();
}

function pagTabMenu () {
$("ul.pag-tab-menu a").on("click", function(){
	console.log('ghghggh')
	var nIdx = $(this).parent().index();
	if (nIdx > 0) 	{
		var viewNum = nIdx - 1;
		$("div.pag-con").not(':eq(' + viewNum + ')').slideUp();
		$("div.pag-con").eq(viewNum).slideDown();
	} else {
		$("div.pag-con").slideDown();
	}

	$("ul.pag-tab-menu li").removeClass("on").eq(nIdx).addClass("on");
	return false
});
}


//tab > tab �� 寃쎌슦
function tabConMenu() {
	$('.js-tab-menu li').on('click', function (e) {
		//console.log('�꾩븘��')
			var cnt = $(this).index();
			$(this).addClass('on');
			$(this).siblings().removeClass('on');
			$('.js-tab-con').hide().eq(cnt).stop().fadeIn();
			$('.js-link-tab-con').removeAttr('style');

			$('.js-tab-con').each(function (e) {
					$(this).children('.js-link-tab-menu').children('li').removeClass('on').eq(0).addClass('on');
			});
			return false;
	});
	$('.js-tab-con').each(function (e) {
			$(this).children('.js-link-tab-con').show();
			$(this)
					.children('.js-link-tab-menu')
					.children('li')
					.on('click', function (e) {
							$(this).addClass('on');
							$(this).siblings().removeClass('on');
							if ($(this).children('a').attr('href') !== '#all') {
									var cnt = $(this).children('a').attr('href');
									$('.js-link-tab-con').hide();
									$('.js-link-tab-con' + cnt + '')
											.stop()
											.fadeIn();
							} else {
									$('.js-link-tab-con').stop().show();
							}
							return false;
					});
	});
}

function subConScroll() {
	if ($('.sub-contents').length) {
			var subConTop = $('.sub-contents').offset().top;
			setTimeout(function (e) {
					$('html, body').stop().animate({ scrollTop: subConTop }, 500);
			}, 200);
	}
}

function btnTop() {
	$('.js-btn-top').on('click', function (e) {
			$('html, body').stop().animate({ scrollTop: 0 }, 400);
			return false;
	});
}

function touchHelp() {
	$('.scroll-x, .scroll-x-1024').each(function (e) {
			if ($(this).height() < 180) {
					$(this).addClass('small');
				}
				console.log($(this))
			$(this).scroll(function (e) {
				console.log('scroll')
				$(this).removeClass('touch-help');
					$(this).removeClass('.scroll-x-1024.touch-help');
			});
	});
}

function popup() {
	$('.js-pop-open').on('click', function (e) {
			var popCnt = $(this).attr('href');
			$('html, body').addClass('ovh');
			$(popCnt).css('display', 'flex');
			return false;
	});
	$('.js-pop-close').on('click', function (e) {
			$('html, body').removeClass('ovh');
			$(this).parents('.popup-wrap').css('display', 'none');
			return false;
	});
	$('.popup-wrap')
			.off()
			.on('click', function (e) {
					if ($('.popup-contents').has(e.target).length == 0) {
							$('html, body').removeClass('ovh');
							$('.popup-wrap').css('display', 'none');
					}
			});
}

function onIntro() {
	var introBtn = $('.intro-list a');

	if (wWidth > 1024) {
        //pc
        introBtn.removeClass('on');

        introBtn.on('mouseenter', function () {
                $(this).addClass('on');
        });

        introBtn.on('mouseleave', function () {
                $(this).removeClass('on');
        });
	} else {
        // mo
        introBtn.off('mouseenter');
        introBtn.off('mouseleave');

        introBtn.addClass('on');
	}
}

function datePicker () {
    if($('.js-date-picker').length){
        $('.js-date-picker').datepicker({
            dateFormat : "yy-mm-dd",
            dayNamesMin : ["��", "��", "��", "紐�", "湲�", "��", "��"],
            monthNamesShort : ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
            showMonthAfterYear: true, 
            changeMonth : true,
            changeYear : true,
            minDate: 0
        });
    }
}

function videoRolling(){
    if($('.video-rolling-wrap').length){
        var swiper = new Swiper(".video-rolling-wrap .swiper-container", {
            centeredSlides: false,
            slidesPerView: 1,  
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 5000,
            },
            navigation: {
                nextEl: '.video-rolling-wrap .btn-rolling-next',
                prevEl: '.video-rolling-wrap .btn-rolling-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 5,
                    centeredSlides: true,
                    effect: 'coverflow',
                    coverflow: {
                        rotate: 0,
                        stretch: 100,
                        depth: 150,
                        modifier: 1.5,
                        slideShadows : false,
                    },
                }
            },
        });
    }
}

function dropdownMenu(){
    $('.js-dropdown-menu-wrap').each(function(e){
        var btnMenu = $(this).find('.js-btn-dropdown'),
            dropdownMenu = $(this).find('.dropdown-menu');
        
        if(btnMenu.next('ul').length){
            btnMenu.off().on('click',function(e){
                $(this).stop().toggleClass('on');
                $(this).next('ul').stop().slideToggle();
            });
        }
    });
    $('html, body').off().on('click', function (e) {
        if ($('.newsletter-link-wrap').has(e.target).length == 0) {
            $('.js-btn-dropdown').removeClass('on');
            $('.dropdown-menu').stop().slideUp(200);
        }
    });
}

function popRolling(){
	if($('.js-pop-rolling .popup').length > 2){
        if($('.js-pop-rolling').hasClass('n4')){
            var cnt = 4;
        }else{
            var cnt = 3;
        }
		$('.js-pop-rolling').not('.slick-initialized').slick({
			dots: false,
			arrows: true,
			prevArrow: $('.btn-multi-prev'),
			nextArrow: $('.btn-multi-next'),
			autoplay: true,
			autoplaySpeed: 3000,
			speed: 1000,
			infinite: true,
			adaptiveHeight: true,
			slidesToShow: 2,
			slidesToScroll: 1,
			responsive: [{
				breakpoint: 1025,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1 
				}
			},{
				breakpoint: 769,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				}
			},{
				breakpoint: 426,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				}
			}]
		});
	}	
}