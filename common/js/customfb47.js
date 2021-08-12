
// Random Stars
var generateStars = function(){

    var $galaxy = $(".galaxy");
    var iterator = 0;

    while (iterator <= 100){
        var xposition = Math.random();
        var yposition = Math.random();
        var star_type = Math.floor((Math.random() * 3) + 1);
        var position = {
            "x" : $galaxy.width() * xposition,
            "y" : $galaxy.height() * yposition,
        };

        $('<div class="star star-type' + star_type + '"></div>').appendTo($galaxy).css({
            "top" : position.y,
            "left" : position.x
        });

        iterator++;
    }

};

generateStars();

(function($){
    function proweb_intro() {
        var pw_intro_ani = new gsap.timeline();
        pw_intro_ani
        .call(function() {
            // $('html').addClass('overflow');
            $('.main-title-ani').removeClass('hidden');
        }, null, null, 2)
        .to('.ht-svg', {
            duration: 2,
            opacity: 1,
            y: '0',
            ease: Power3.in
        }, "+=1")
        .to('.h-intro-we', {
            duration: 0.4,
            opacity: 1,
            y: '0',
            ease: Power3.in
        }, "-=2")
        .to('.h-intro-rotate', {
            duration: 0.4,
            opacity: 1,
            y: '0',
            ease: Power3.in
        }, "-=1.7")
        .call(function() {
            // $('html').removeClass('overflow');
        }, null, null, 2)
    }
    function main_title_ani() {
        $('.h-intro-rotate__item').typed({
            strings: ['trans<div class="intro_sec_row text-outline goth-black lh-1">lation</div>^2000', 'inter<div class="intro_sec_row text-outline goth-black lh-1">pretation</div>^2000', 'inno<div class="intro_sec_row text-outline goth-black lh-1">vation.</div>^2000'],
            typeSpeed: 100,
            loop: true,
            contentType: 'html'
        });
    }
    $( document ).ready(function() {
        gsap.defaults({overwrite:"auto"});
        if($('.h-intro-rotate__item').length) {
            main_title_ani();        }
        if ($('.ht-svg').length) {
            proweb_intro();
        }
    });

})(jQuery);
