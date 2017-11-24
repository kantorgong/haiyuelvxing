// 是否有微信API
var weixinChecked;

var weixin = (function () {
    window.jQuery || document.write(''
        + '<script src="http://s1.bdstatic.com/r/www/cache/static/jquery/jquery-1.10.2.min_f2fb5194.js">'
        + '<' + '/script>');


    window.wx || document.write(''
        + '<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js">'
        + '<' + '/script>');

    var exports = $({});

    // 微信分享默认DATA
    var _wxData = {
        imgUrl: '',
        link: window.location.href,
        title: document.title,
        desc: '-'
    }

    // 网络类型
    var _networkType;

    var mobile = 'm.';

    if (window.checkIsPC) {
        if (checkIsPC()) {
            mobile = '';
        }

    }
    var path = window.location.href;
    $.ajax({
        url: 'http://plus.haiyuelvxing.com/wechat/js/index.html?url=' + encodeURIComponent(path),
        dataType: 'json',
        success: function (data) {
            if (data.timestamp && data.noncestr && data.signature) {
                if (!window.wx) {
                    $.getScript('http://res.wx.qq.com/open/js/jweixin-1.0.0.js', function () {
                        weixinInit(data);
                    });
                }
                else {
                    weixinInit(data);
                }

            }
        }
    });

    function weixinInit(data) {
        var debug = location.href.indexOf('debug') > -1;
        wx.config({
            debug: debug,
            appId: data.appid || 'wx2c4643a8a115af7f',
            timestamp: data.timestamp,
            nonceStr: data.noncestr,
            signature: data.signature,
            jsApiList: [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
                'hideMenuItems',
                'showMenuItems',
                'hideAllNonBaseMenuItem',
                'showAllNonBaseMenuItem',
                'translateVoice',
                'startRecord',
                'stopRecord',
                'onRecordEnd',
                'playVoice',
                'pauseVoice',
                'stopVoice',
                'uploadVoice',
                'downloadVoice',
                'chooseImage',
                'previewImage',
                'uploadImage',
                'downloadImage',
                'getNetworkType',
                'openLocation',
                'getLocation',
                'hideOptionMenu',
                'showOptionMenu',
                'closeWindow',
                'scanQRCode',
                'chooseWXPay',
                'openProductSpecificView',
                'addCard',
                'chooseCard',
                'openCard'
            ]
        });

        /**
         * 初始化微信分享信息
         */
        wx.ready(function () {
            exports.trigger('ready');
            weixinChecked = 1;

            wx.getNetworkType({
                success: function (res) {
                    _networkType = res.networkType; // 返回网络类型2g，3g，4g，wifi
                }
            });

            bindShareInfo();
        });
        wx.error(function(res){
            console.log('error', res);
        });
    }

    function bindData(data) {
        _wxData = $.extend(_wxData, data);
    }

    function bindShareInfo() {
        if (!weixinChecked) {
            console.log('weixin API hasnt been inited~~');
            return;
        }

        var shareInfo = $.extend({
            success: function () {},
            cancel: function () {}
        }, _wxData);

        // 分享朋友圈默认回调函数
        var sharesuc1 = {
            success: function() {
                $.ajax({
                    url: 'http://m.plus.94uv.com/index.php?app=share&act=index&mobile=1',
                    type: 'GET',
                    dataType: 'jsonp',
                    data: {
                        'type': '1',
                        'url': window.location.href,
                        'mapping_type':'qing'
                    }
                })
            },
            cancel: function () {}
        }
        typeof(wxData1) == 'undefined' ? Timeline = $.extend({}, sharesuc1, _wxData) : Timeline = $.extend({}, _wxData, wxData1);

        // 分享朋友默认回调函数
        var sharesuc2 = {
            success: function() {
                $.ajax({
                    url: 'http://m.plus.94uv.com/index.php?app=share&act=index&mobile=1',
                    type: 'GET',
                    dataType: 'jsonp',
                    data: {
                        'type': '2',
                        'url': window.location.href,
                        'mapping_type':'qing'
                    }
                })
            },
            cancel: function () {}
        }

        typeof(wxData2) == 'undefined' ? AppMessage = $.extend({}, sharesuc2, _wxData) : AppMessage = $.extend({}, _wxData, wxData2);

        wx.onMenuShareTimeline(Timeline);
        wx.onMenuShareAppMessage(AppMessage);
        wx.onMenuShareQQ(shareInfo);
        wx.onMenuShareWeibo(shareInfo);
    }

    exports.bindData = bindData;
    exports.bindShareInfo = bindShareInfo;

    return exports;
})();