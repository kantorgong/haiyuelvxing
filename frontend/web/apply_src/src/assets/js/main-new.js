/**
 * @file 轻杂志的JS交互
 */

/**
 * app 模块
 *
 * @namespace
 */
var app = {};
app.isPC = false;
app.width;
app.height;
app.loop = false;  // 循环展示
app.DEFAULT_WIDTH = 414;
app.DEFAULT_HEIGHT = 736;

app.init = function (options) {

    options = options || {};
    app.loop = options.loop || getUrlParameterByName('loop') || false;

    // 加载完成后隐藏loading
    loading.init('.swiper-slide', function () {
        $('.loading').fadeOut();
    });

    if (checkIsPC()) {
        app.isPC = true;
        app.width = app.DEFAULT_WIDTH;
        app.height = Math.min(app.DEFAULT_HEIGHT, app.height);
    }

    // 调整页面元素高度
    $('.wrap, .swiper-slide, .swiper-container').height(app.height).width(app.width);

    // new swiper
    var swiperOptions = $.extend({
        direction: 'vertical',  // 是竖排还是横排滚动，默认是竖排
        loop: app.loop,  // 循环展示
        longSwipesRatio: 0.1,
        preventClicks: false,
        preventClicksPropagation: false
    }, options || {});

    app.swiper = new Swiper('.swiper-container', swiperOptions);

    app.initPC();

    // 初始化箭头指示
    app.initArrow();

    // 初始化音乐按钮
    app.music.init();

    // 初始化回到首页按钮事件
    $('.home-btn').on('click', function () {
        app.swiper.slideTo(0);
        return false;
    });


    if (options.hashnav) {
        // 绑定hash变化的事件
        $(window).on('hashchange', function (e) {
            var hash = getLocationHash().replace('#', '');

            if (!hash) {
                return;
            }

            for (var i = 0, length = app.swiper.slides.length; i < length; i++) {
                var slide = $(app.swiper.slides).eq(i);
                var slideHash = slide.attr('data-hash');
                if (slideHash === hash && !slide.hasClass(app.swiper.params.slideDuplicateClass)) {
                    var index = slide.index();
                    if (app.swiper.activeIndex == index) {
                        return;
                    }
                    app.swiper.slideTo(index);
                }
            }
        });
    }

};

/**
 * 获取hash值
 *
 * @return {string} #hash-name
 */
function getLocationHash() {
    // Firefox下`location.hash`存在自动解码的情况，
    // 比如hash的值是**abc%3def**，
    // 在Firefox下获取会成为**abc=def**
    // 为了避免这一情况，需要从`location.href`中分解
    var index = location.href.indexOf('#');
    var url = index === -1 ? '' : location.href.slice(index + 1);

    return url;
}

/**
 * 获取URL中的参数
 *
 * @param {string} name 参数名
 * @return {string} 参数值
 */
function getUrlParameterByName(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)'),
    results = regex.exec(location.search);
    return results === null ? '': decodeURIComponent(results[1].replace(/\+/g, ' '))
}

// 箭头在最后一页的显示隐藏
app.initArrow = function () {
    if (app.loop) {
        return;
    }

    var arrow = $('.arrow');
    var slideCount = app.swiper.slides.length;
    app.swiper.on('SlideChangeEnd', function (swiper) {
        var curIndex = app.swiper.activeIndex;
        hanldeAnimate();
        // 是否最后一页
        if (curIndex >= slideCount - 1) {
            arrow.hide();
        }
        else {
            arrow.show();
        }
    });
};

// PC上的事件初始化
app.initPC = function () {

    if (!app.isPC) {
        return false;
    }

    var left = $(window).width() / 2 + app.width / 2;

    var copyright = $('#copyright');
    copyright.css({
        'top': app.height + 'px',
        'opacity': 1
    });
    copyright.show();

    var pcboard = $('#pc-board');
    pcboard.find('.qrcode div')
        .html('<img src=\"http://plus.94uv.com/qrcode/urlQrcode.html?data=' + decodeURIComponent(location.href) + '\"/>');

    pcboard.css({
        left: left + 'px'
    }).show();

    app.initPager();
};
app.initPager = function () {
    // 初始化PC上的翻页按钮事件
    var pager = $('#pc-board .pager a');
    var pPrev = $('#btn-prev');
    var pNext = $('#btn-next');
    pager.show();

    var slideCount = app.swiper.slides.length;

    pNext.on('click', function () {
        app.swiper.slideNext();
        return false;
    });
    pPrev.on('click', function () {
        app.swiper.slidePrev();
        return false;
    });

    var adjustPagers = function () {
        if (app.loop) {
            return false;
        }

        var curIndex = app.swiper.activeIndex;

        // 是否最后一页
        pager.css('visibility', 'visible');
        if (curIndex >= slideCount - 1) {
            pNext.css('visibility', 'hidden');
        }
        else if (curIndex == 0) {
            pPrev.css('visibility', 'hidden');
        }
        else {
            pager.show();
        }
    };

    app.swiper.on('SlideChangeEnd', adjustPagers);
    adjustPagers();
};



/**
 * 加载模块
 *
 * @type {Object}
 *
 * 使用方法：
 *
 *  loading.init('.slide', function () {
 *      $('.loading').hide();
 *  });
 */
var loading = (function () {

    // 要加载图片的总数
    var allcount;

    // 开始检测加载的时间戳
    var startTime;

    // 已加载图片的数量
    var loadedCount = 0;

    // 要加载的图片
    var loadImgs = [];

    // 是否强制停留至少1s的loading
    var isForcetime;
    var forceTime = 1000;

    // 完成加载图片时的执行函数
    var callbackFn = function () {};

    function init(selector, readycallback, forcetime) {
        if (forcetime) {
            isForcetime = 1;
        }

        if (typeof readycallback == 'function') {
            callbackFn = readycallback;
        }

        // 用于判断是否有重复图片
        var imgMap = {};

        $(selector).each(function (i) {

            var page = $(this);

            // 取这个selector里面的所有img标签的图片进行加载
            page.find('img').each(function () {
                var url = this.src;
                if (imgMap[url]) {
                    return;
                }

                imgMap[url] = 1;
                loadImgs.push(url);
            });

            // 取这个classname的背景图片
            var bgimg = page.css('background-image');
            if (bgimg == 'none' || imgMap[bgimg]) {
                return;
            }
            imgMap[bgimg] = 1;

            bgimg = bgimg.replace(/(\'|\")/g, '').replace('url(', '').replace(')', '');
            //console.log('pre-image:' + bgimg);
            loadImgs.push(bgimg);


        });

        allcount = loadImgs.length;


        // 启动超时监控
        startTime = new Date();

        // 启动图片的预加载
        start();

        // 检测图片是否加载完成
        check();
    }

    function start() {
        $.each(loadImgs, function (i, imgurl) {
            var img = new Image();
            img.src = imgurl;
            img.onload = function () {
                if (this.complete) {
                    loadedCount++;
                    // 更新百分比
                    updatePercent(Math.round(loadedCount / allcount * 100));
                }
            };
        });
    }

    var percentText = $('#percentage');

    function updatePercent(value) {
        if (!percentText.length) {
            return;
        }

        percentText.text(value + '%');
    }

    function check() {
        var nowTime = new Date();
        var gap = nowTime - startTime;

        if (isForcetime) {
            if (loadedCount >= allcount && gap > forceTime) {

                // 加载完成，执行回调函数
                callbackFn();
            }
            else {
                setTimeout(function () {
                    check();
                }, 200);
            }
        }
        else {
            if (loadedCount >= allcount) {

                // 加载完成，执行回调函数
                callbackFn();
            }
            else {
                setTimeout(function () {
                    check();
                }, 200);
            }
        }
    }


    return {
        init: init
    };
})();

/**
 * 返回是否是PC页面
 *
 * @return {boolean} true / false
 */
function checkIsPC() {
    var system = {
        win: false,
        mac: false,
        xll: false
    };
    var p = navigator.platform;
    system.win = p.indexOf('Win') == 0;
    system.mac = p.indexOf('Mac') == 0;
    system.x11 = (p == 'X11') || (p.indexOf('Linux') == 0);
    var winWidth = $(window).width();
    if (winWidth > app.DEFAULT_WIDTH && (system.win || system.mac || system.xll)) {
        return true;
    }
    else {
        return false;
    }
}


app.music = (function () {
    var exports = $({});

    var music = $('audio')[0];
    var PAUSE_CLASS = 'player-btn-stop';

    exports.init = function () {
        $('.player-btn').on('click', function () {
            var _me = $(this);
            if (_me.hasClass('player-btn-stop')) {
                exports.on();
            }
            else {
                exports.off();
            }
        });
    };

    exports.on = function () {
        $('.player-btn').removeClass(PAUSE_CLASS);
        music.play();
    };

    exports.off = function () {
        $('.player-btn').addClass(PAUSE_CLASS);
        music.pause();
    };

    return exports;
})();

function hanldeAnimate() {
	var curIndex = window.Swiper.activeIndex;

	// 找到有[data-anim]属性的DOM元素，分别给它们加上data-anim设定的动画classname
	$('.swiper-slide').find('[data-anim]').each(function () {
		$(this).removeClass($(this).data('anim'));
	});
	$('.swiper-slide').eq(curIndex).find('[data-anim]').each(function () {
		$(this).addClass($(this).data('anim'));
	});
}
// 弹出框
var tip = {
	timer: null,
	show: function(msg, duration) {
		var tip = $('#page-tip-layer');
		if (!tip.length) {
			tip = $('<div>').attr('id', 'page-tip-layer').addClass('tip-layer').appendTo($(document.body));
		}
		var winHeight = $(window).height();
		var winWidth = $(window).width();
		var scrollTop = $(document.body).scrollTop();
		tip.text(msg).show();

		tip.css({
			position: 'absolute',
			left: (winWidth - tip.width()) / 2,
			top: scrollTop + (winHeight - tip.height()) / 2
		});
		if (duration) {
			if (tip.timer) {
				clearTimeout(tip.timer);
			}
			tip.timer = setTimeout(function () {
				tip.remove();
			}, duration);
		}
	}
};

exports.app = app;
exports.loading = loading;
exports.checkIsPC = checkIsPC;
exports.hanldeAnimate = hanldeAnimate;
exports.tip = tip;
exports.getUrlParameterByName = getUrlParameterByName
