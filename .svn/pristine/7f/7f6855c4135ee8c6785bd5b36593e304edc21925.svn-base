$task_content_inner = null;
$mainiframe=null;
var tabwidth=119;
$loading=null;
$nav_wraper=$("#nav_wraper");
$(function () {
	$mainiframe=$("#mainiframe");
	$content=$("#content");
	$loading=$("#loading");
	var headerheight=45;
    var header1 = 33;
    var header2 = 32;
	$content.height($(window).height()-headerheight-header1-header2 -20);
    $('body').height($(window).height());

	$nav_wraper.height($(window).height()-headerheight-27);
	//$nav_wraper.niceScroll();
	$(window).resize(function(){
		$content.height($(window).height()-headerheight-header1-header2 -20);
        $('body').height($(window).height());
		 calcTaskitemsWidth();
	});
	$("#content iframe").load(function(){
    	$loading.hide();
    });
    handle_side_menu();
    $task_content_inner = $("#task-content-inner");





    ///

    $(document).on("click",'.apps_container li', function () {
        var app = '<li><span class="delete" style="display:inline">×</span><img src="" class="icon"><a href="#" class="title"></a></li>';
        var $app = $(app);
        $app.attr("data-appname", $(this).attr("data-appname"));
        $app.attr("data-appid", $(this).attr("data-appid"));
        $app.attr("data-appurl", $(this).attr("data-appurl"));
        $app.find(".icon").attr("src", $(this).attr("data-icon"));
        $app.find(".title").html($(this).attr("data-appname"));
        $app.appendTo("#appbox");
        $("#appbox  li .delete").off("click");
        $("#appbox  li .delete").click(function () {
            $(this).parent().remove();
            return false;
        });
    });

    // 左移
    $(".J_tabLeft").on("click", a);

    // 右移
    $(".J_tabRight").on("click", b);


    ///
    $("#tdshortcutsmor1").click(function () {
        $(".window").hide();
    });

    $(document).on("click", ".task-item", function () {
        var appid = $(this).attr("app-id");
        var $app = $('#' + appid);
        showTopWindow($app);
    });

    $(document).on("click",'#task-content-inner li', function () {
        //appiframe-settingserver

        $("#task-content-inner .current").removeClass("current");
        $(this).addClass("current");
        $(".appiframe").hide();
    	$('#appiframe-'+$(this).attr('app-id')).show();
        g(this);
    	return false;
    });

    $(".J_tabShowActive").on("click", j);

    $(document).on("dblclick","#task-content-inner li", function () {
    	closeapp($(this));
    	return false;

    });
    $(document).on("click","#task-content-inner a.macro-component-tabclose", function () {
    	closeapp($(this).parent());
        g(this);
        return false;
    });

    $(".J_tabCloseAll").on("click",function() {
        $(".page-tabs-content").children("[app-id]").not(":first").each(function() {
            $('#appiframe-' + $(this).attr("app-id")).remove();
            $(this).remove()
        });
        $(".page-tabs-content").children("[app-id]:first").each(function() {
            $('#appiframe-' + $(this).attr("app-id")).show();
            $(this).addClass("current")
        });
        $(".page-tabs-content").css("margin-left", "0")
    });

    $(".J_tabCloseOther").on("click", i);


    $("#refresh_wrapper").click(function(){
    	var $current_iframe=$("#content iframe:visible");
    	$loading.show();
    	//$current_iframe.attr("src",$current_iframe.attr("src"));
    	$current_iframe[0].contentWindow.location.reload();
    	return false;
    });

    calcTaskitemsWidth();
});


function i() {
    $(".page-tabs-content").children("[app-id]").not(":first").not(".current").each(function() {
        $('#appiframe-' + $(this).attr("app-id")).remove();
        $(this).remove()
    });
    $(".page-tabs-content").css("margin-left", "0")
}

function g(n) {
    var o = f($(n).prevAll()),
        q = f($(n).nextAll());
    var l = f($(".content-tabs").children().not(".J_menuTabs"));
    var k = $(".content-tabs").outerWidth(true) - l;
    var p = 0;
    console.log($(".page-tabs-content").outerWidth());
    if ($(".page-tabs-content").outerWidth() < k) {
        p = 0
    } else {
        if (q <= (k - $(n).outerWidth(true) - $(n).next().outerWidth(true))) {
            if ((k - $(n).next().outerWidth(true)) > q) {
                p = o;
                var m = n;
                while ((p - $(m).outerWidth()) > ($(".page-tabs-content").outerWidth() - k)) {
                    p -= $(m).prev().outerWidth();
                    m = $(m).prev()
                }
            }
        } else {
            if (o > (k - $(n).outerWidth(true) - $(n).prev().outerWidth(true))) {
                p = o - $(n).prev().outerWidth(true)
            }
        }
    }
    $(".page-tabs-content").animate({
            marginLeft: 0 - p + "px"
        },
        "fast")
}

function a() {
    var o = Math.abs(parseInt($(".page-tabs-content").css("margin-left")));
    var l = f($(".content-tabs").children().not(".J_menuTabs"));
    var k = $(".content-tabs").outerWidth(true) - l;
    var p = 0;
    if ($(".page-tabs-content").width() < k) {
        return false
    } else {
        var m = $(".J_menuTab:first");
        var n = 0;
        while ((n + $(m).outerWidth(true)) <= o) {
            n += $(m).outerWidth(true);
            m = $(m).next()
        }
        n = 0;
        if (f($(m).prevAll()) > k) {
            while ((n + $(m).outerWidth(true)) < (k) && m.length > 0) {
                n += $(m).outerWidth(true);
                m = $(m).prev()
            }
            p = f($(m).prevAll())
        }
    }
    $(".page-tabs-content").animate({
            marginLeft: 0 - p + "px"
        },
        "fast")
}

function b() {
    var o = Math.abs(parseInt($(".page-tabs-content").css("margin-left")));
    var l = f($(".content-tabs").children().not(".J_menuTabs"));
    var k = $(".content-tabs").outerWidth(true) - l;
    var p = 0;
    if ($(".page-tabs-content").width() < k) {
        return false
    } else {
        var m = $(".J_menuTab:first");
        var n = 0;
        while ((n + $(m).outerWidth(true)) <= o) {
            n += $(m).outerWidth(true);
            m = $(m).next()
        }
        n = 0;
        while ((n + $(m).outerWidth(true)) < (k) && m.length > 0) {
            n += $(m).outerWidth(true);
            m = $(m).next()
        }
        p = f($(m).prevAll());
        if (p > 0) {
            $(".page-tabs-content").animate({
                    marginLeft: 0 - p + "px"
                },
                "fast")
        }
    }
}

function f(l) {
    var k = 0;
    $(l).each(function() {
        k += $(this).outerWidth(true)
    });
    return k
}

function j() {
    g($(".J_menuTab.current"));
}




function calcTaskitemsWidth() {
//    var width = $("#task-content-inner li").length * tabwidth;
//    $("#task-content-inner").width(width);
//    if (($(window).width()-268-119- 30 * 2) < width) {
//        $("#task-content").width($(window).width() -268-119- 30 * 2);
//        $("#task-next,#task-pre").show();
//    } else {
//        $("#task-next,#task-pre").hide();
//        $("#task-content").width(width);
//    }
}

function close_current_app(){
	closeapp($("#task-content-inner .current"));
}

function closeapp($this){
	if(!$this.is(".noclose")){
		$this.prev().click();
    	$this.remove();
    	calcTaskitemsWidth();
    	$("#task-next").click();
	}
}



var task_item_tpl ='<li class="macro-component-tabitem J_menuTab">'+
'<span class="macro-tabs-item-text"></span>'+
'<a class="macro-component-tabclose" href="javascript:void(0)" title="点击关闭标签"><span></span><b class="macro-component-tabclose-icon">x</b></a>'+
'</li>';

var appiframe_tpl='<iframe style="width:100%;height: 100%;" frameborder="0" class="appiframe"></iframe>';

function openapp(url, appid, appname, selectObj) {
    var $app = $("#task-content-inner li[app-id='"+appid+"']");

    $("#task-content-inner .current").removeClass("current");

    //取消当前菜单父菜平行的其他菜单选中
    $(selectObj).parent().parent().parent().siblings().removeClass('active');
    //使当前菜单的父菜单选中
    $(selectObj).parent().parent().parent().addClass('active');

    //子菜单取消其他选中，使当前选中
    $(selectObj).parent('.nav-item').addClass('active').siblings().removeClass('active').parents('.nav-item').addClass('active').siblings().removeClass('active');

    //缺口选中
    if(!$(selectObj).parent('.nav-item').parents('.nav-item').find('.selected').size()) {
        $(selectObj).parent('.nav-item').parents('.nav-item').find('.nav-link').append('<span class="selected"></span>');
    }




    if ($app.length == 0) {
        //标签还未开启
        var task = $(task_item_tpl).attr("app-id", appid).attr("app-url",url).attr("app-name",appname).addClass("current");
        task.find(".macro-tabs-item-text").html(appname);
        $task_content_inner.append(task);
        $(".appiframe").hide();

        $loading.show();
        $appiframe=$(appiframe_tpl).attr("src",url).attr("id","appiframe-"+appid);
        $appiframe.appendTo("#content");
        $appiframe.load(function(){
        	$loading.hide();
        });
        calcTaskitemsWidth();
    } else {
        //标签已经开启
    	$app.addClass("current");
    	$(".appiframe").hide();
    	var $iframe=$("#appiframe-"+appid);
    	var src=$iframe.get(0).contentWindow.location.href;
    	src=src.substr(src.indexOf("://")+3);

    		$loading.show();
    		$iframe.attr("src",url);

            $loading.hide();

    	$iframe.show();
    	$mainiframe.attr("src",url);
    }

}

function handle_side_menu() {
    $("#menu-toggler").on('click', function () {
        $("#sidebar").toggleClass("display");
        $(this).toggleClass("display");
        return false
    });
    var b = $("#sidebar").hasClass("menu-min");
    $("#sidebar-collapse").on('click', function () {
        $("#sidebar").toggleClass("menu-min");
        $(this).find('[class*="fa-"]:eq(0)').toggleClass("fa-angle-double-right");
        b = $("#sidebar").hasClass("menu-min");
        if (b) {
            $(".open > .submenu").removeClass("open")
        }
    });
    var a = "ontouchend" in document;
    $(".nav-list").on('click', function (g) {
        var f = $(g.target).closest("a");
        if (!f || f.length == 0) {
            return
        }
        if (!f.hasClass("dropdown-toggle")) {
            if (b && 'click' == "tap" && f.get(0).parentNode.parentNode == this) {
                var h = f.find(".menu-text").get(0);
                if (g.target != h && !$.contains(h, g.target)) {
                    return false
                }
            }
            return
        }
        var d = f.next().get(0);
        if (!$(d).is(":visible")) {
            var c = $(d.parentNode).closest("ul");
            if (b && c.hasClass("nav-list")) {
                return
            }
            c.find("> .open > .submenu").each(function () {
                if (this != d && !$(this.parentNode).hasClass("active")) {
                    $(this).slideUp(200).parent().removeClass("open")
                }
            })
        } else {
        }
        if (b && $(d.parentNode.parentNode).hasClass("nav-list")) {
            return false
        }
        $(d).slideToggle(200).parent().toggleClass("open");
        return false
    })
}


