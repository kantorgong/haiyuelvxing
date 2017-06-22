/*!
 * author:jieyou
 * see https://github.com/jieyou/lazyload
 * part of the code fork from tuupola's https://github.com/tuupola/jquery_lazyload
 */
! function(a) {
    "function" == typeof define && define.amd ? define(["jquery"], a) : a(window.jQuery || window.Zepto)
}(function(a) {
    function i() {}

    function j(a, b) {
        var e;
        return e = b._$container == d ? ("innerHeight" in c ? c.innerHeight : d.height()) + d.scrollTop() : b._$container.offset().top + b._$container.height(), e <= a.offset().top - b.threshold
    }

    function k(b, e) {
        var f;
        return f = e._$container == d ? d.width() + (a.fn.scrollLeft ? d.scrollLeft() : c.pageXOffset) : e._$container.offset().left + e._$container.width(), f <= b.offset().left - e.threshold
    }

    function l(a, b) {
        var c;
        return c = b._$container == d ? d.scrollTop() : b._$container.offset().top, c >= a.offset().top + b.threshold + a.height()
    }

    function m(b, e) {
        var f;
        return f = e._$container == d ? a.fn.scrollLeft ? d.scrollLeft() : c.pageXOffset : e._$container.offset().left, f >= b.offset().left + e.threshold + b.width()
    }

    function n(a, b) {
        var c = 0;
        a.each(function(d) {
            function g() {
                f.trigger("_lazyload_appear"), c = 0
            }
            var f = a.eq(d);
            if (!b.skip_invisible || f.width() || f.height() || "none" === f.css("display"))
                if (b.vertical_only)
                    if (l(f, b));
                    else if (j(f, b)) {
                if (++c > b.failure_limit) return !1
            } else g();
            else if (l(f, b) || m(f, b));
            else if (j(f, b) || k(f, b)) {
                if (++c > b.failure_limit) return !1
            } else g()
        })
    }

    function o(a) {
        return a.filter(function(b) {
            return !a.eq(b)._lazyload_loadStarted
        })
    }
    var h, c = window,
        d = a(c),
        e = {
            threshold: 0,
            failure_limit: 0,
            event: "scroll",
            effect: "show",
            effect_params: null,
            container: c,
            data_attribute: "original",
            data_srcset_attribute: "original-srcset",
            skip_invisible: !0,
            appear: i,
            load: i,
            vertical_only: !1,
            minimum_interval: 300,
            use_minimum_interval_in_ios: !1,
            url_rewriter_fn: i,
            no_fake_img_loader: !1,
            placeholder_data_img: "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC",
            placeholder_real_img: "http://ditu.baidu.cn/yyfm/lazyload/0.0.1/img/placeholder.png"
        },
        f = /(?:iphone|ipod|ipad).*os/gi.test(navigator.appVersion),
        g = f && /(?:iphone|ipod|ipad).*os 5/gi.test(navigator.appVersion);
    h = function() {
        var a = Object.prototype.toString;
        return function(b) {
            return a.call(b).replace("[object ", "").replace("]", "")
        }
    }(), a.fn.hasOwnProperty("lazyload") || (a.fn.lazyload = function(b) {
        var k, l, p, j = this,
            m = null;
        return a.isPlainObject(b) || (b = {}), a.each(e, function(f, g) {
            -1 != a.inArray(f, ["threshold", "failure_limit", "minimum_interval"]) ? b[f] = "String" == h(b[f]) ? parseInt(b[f], 10) : g : "container" == f ? (b._$container = b.hasOwnProperty(f) ? b[f] == c || b[f] == document ? d : a(b[f]) : d, delete b.container) : !e.hasOwnProperty(f) || b.hasOwnProperty(f) && h(b[f]) == h(e[f]) || (b[f] = g)
        }), k = "scroll" == b.event, l = k || "scrollstart" == b.event || "scrollstop" == b.event, j.each(function(c) {
            var e = this,
                f = j.eq(c),
                g = f.attr("src"),
                h = f.attr("data-" + b.data_attribute),
                k = b.url_rewriter_fn == i ? h : b.url_rewriter_fn.call(e, f, h),
                m = f.attr("data-" + b.data_srcset_attribute),
                n = f.is("img");
            return 1 == f._lazyload_loadStarted || g == k ? (f._lazyload_loadStarted = !0, j = o(j), void 0) : (f._lazyload_loadStarted = !1, n && !g && f.one("error", function() {
                f.attr("src", b.placeholder_real_img)
            }).attr("src", b.placeholder_data_img), f.one("_lazyload_appear", function() {
                function g() {
                    d && f.hide(), n ? (m && f.attr("srcset", m), k && f.attr("src", k)) : f.css("background-image", 'url("' + k + '")'), d && f[b.effect].apply(f, c ? b.effect_params : []), j = o(j)
                }
                var d, c = a.isArray(b.effect_params);
                f._lazyload_loadStarted || (d = "show" != b.effect && a.fn[b.effect] && (!b.effect_params || c && 0 == b.effect_params.length), b.appear != i && b.appear.call(e, j.length, b), f._lazyload_loadStarted = !0, b.no_fake_img_loader || m ? (b.load != i && f.one("load", function() {
                    b.load.call(e, j.length, b)
                }), g()) : a("<img />").one("load", function() {
                    g(), b.load != i && b.load.call(e, j.length, b)
                }).attr("src", k))
            }), l || f.on(b.event, function() {
                f._lazyload_loadStarted || f.trigger("_lazyload_appear")
            }), void 0)
        }), l && (p = 0 != b.minimum_interval, b._$container.on(b.event, function() {
            return !k || !p || f && !b.use_minimum_interval_in_ios ? n(j, b) : (m || (m = setTimeout(function() {
                n(j, b), m = null
            }, b.minimum_interval)), void 0)
        })), d.on("resize load", function() {
            n(j, b)
        }), g && d.on("pageshow", function(a) {
            a.originalEvent && a.originalEvent.persisted && j.trigger("_lazyload_appear")
        }), a(function() {
            n(j, b)
        }), this
    })
});