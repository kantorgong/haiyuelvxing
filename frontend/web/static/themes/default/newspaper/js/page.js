/**
 * @file 轻杂志的JS交互
 */

/**
 * ==============================
 * 页面主要JS逻辑交互
 * ===============================
 */
$(function () {
    var app = window.app || {};

    app.loop = false;  // 是否循环展示
    app.height = $(window).height();
    app.width = $(window).width();

    // PC端展现的宽度和高度，根据实际的设计图去调整这个高宽
    app.DEFAULT_WIDTH = 640;
    app.DEFAULT_HEIGHT = Math.min(1004, app.height - 50);
    
    // 滑屏初始化
    app.init({
        // 滑屏方向默认是竖屏，'horizontal' 是横屏
        direction: 'vertical',
        //刷新当前页
        // hashnav: true
    });

    // 加载完成后隐藏loading
    loading.init('.swiper-slide', function () {
        $('.loading').fadeOut();
        initPageEvents();
    });
    
    // init();
});

 

/**
 * 其他的页面行为JS写在这里
 */


function initPageEvents() {
    app.swiper.on('SlideChangeStart', function (swiper) {

        // 找到所有页面有[data-anim]属性的DOM元素，去掉data-anim设定的动画classname
        $('.swiper-slide').find('[data-anim]').each(function () {
            $(this).removeClass($(this).data('anim'));
        });
    });
    app.swiper.on('SlideChangeEnd', function (swiper) {
        hanldeAnimate();
        $('.pop').hide();
    
        
    });

    hanldeAnimate();
}
$('.pop').on('click', function(){
    $('.pop').hide();
});
var buttonsT = $(window).height()*0.7+15;
$('.buttons').css('top',buttonsT);

function hanldeAnimate() {
    var index = app.swiper.activeIndex;

    // 找到有[data-anim]属性的DOM元素，分别给它们加上data-anim设定的动画classname
    $('.swiper-slide').eq(index).find('[data-anim]').each(function () {
        $(this).addClass($(this).data('anim'));
    });
    $('.pop').on('click', function(){
        $('.pop').hide();
    })
}