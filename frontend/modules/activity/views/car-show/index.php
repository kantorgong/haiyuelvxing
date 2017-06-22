<?php
$env = \components\XyXy::getEnv(true);
$path = '2016snake';
$site = 'http://qing.94uv.';
if ($env == 'dev')
{
    $path = 'other/2016snake';
    $site = 'http://qin.94uv.';
}
else if($env == 'test') {
    $path = '2016snake';
    $site = 'http://qin.94uv.';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>长沙车展vs贪食蛇大战</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <script>
    var deviceWidth =  parseInt(window.screen.width);var deviceScale = deviceWidth/750;var ua = navigator.userAgent;if (/Android (\d+\.\d+)/.test(ua)){var version = parseFloat(RegExp.$1);if(version>2.3){document.write('<meta name="viewport" content="width=750,initial-scale='+deviceScale+', minimum-scale = '+deviceScale+', maximum-scale = '+deviceScale+', target-densitydpi=device-dpi">');}else{document.write('<meta name="viewport" content="width=750,initial-scale=0.75,maximum-scale=0.75,minimum-scale=0.75,target-densitydpi=device-dpi" />');}} else {document.write('<meta name="viewport" content="width=750, user-scalable=no">');}
    </script>
    <link rel="stylesheet" type="text/css" href="<?=$site.$env?>/<?=$path?>/css/page.css">
</head>
<body>

<div class="wrap" id="load-img">
    <div style="display: none;"><img src="<?=$site.$env?>/<?=$path?>/images/share.jpg"></div>
    <section class="loading">
        <div class="percentage-box">
            <i id="percentage">1%</i>
            <div class="percentage-num">
                <span></span>
            </div>
        </div>
    </section>
    <div id="content">
        <div class="page1">
            <img src="<?=$site.$env?>/<?=$path?>/images/bg1.jpg">
            <div class="btn-box">
                <img src="<?=$site.$env?>/<?=$path?>/images/btn-start.png" class="btn-start">
                <img src="<?=$site.$env?>/<?=$path?>/images/btn-rank.png" class="btn-rank">
            </div>
        </div>
        <div class="page2">
            <img src="<?=$site.$env?>/<?=$path?>/images/bg2.jpg">
            <div id="info">
                <div class="time"><span id="time"></span>''</div>
                <div id="score" style="display: none"></div>
            </div>
            <div id="home"></div>
            <div id="<?=$site.$env?>/<?=$path?>/images" style="display: none"></div>
        </div>
        <div class="page3">
            <img src="<?=$site.$env?>/<?=$path?>/images/bg3.jpg">
            <img src="<?=$site.$env?>/<?=$path?>/images/over.png" class="fail">
            <img src="<?=$site.$env?>/<?=$path?>/images/suc.png" class="suc">
            <div class="result"></div>
            <div class="btn-box">
                <img src="<?=$site.$env?>/<?=$path?>/images/btn-again.png" class="btn-again">
                <img src="<?=$site.$env?>/<?=$path?>/images/btn-rank2.png" class="btn-rank">
                <img src="<?=$site.$env?>/<?=$path?>/images/btn-share.png" class="btn-share">
            </div>
        </div>
    </div>
    <div class="page-share">
        <img src="<?=$site.$env?>/<?=$path?>/images/page-share.png">
    </div>
    <div class="page-rank">
        <div class="box">
            <img src="<?=$site.$env?>/<?=$path?>/images/rank-bg.png">
            <img src="<?=$site.$env?>/<?=$path?>/images/close.png" class="rank-close">
            <ul class="rank-tab">
                <li class="cur">
                    <img src="<?=$site.$env?>/<?=$path?>/images/rank-yellow.png">
                    <img src="<?=$site.$env?>/<?=$path?>/images/rank-gray.png">
                </li>
                <li>
                    <img src="<?=$site.$env?>/<?=$path?>/images/prize-yellow.png">
                    <img src="<?=$site.$env?>/<?=$path?>/images/prize-gray.png">
                </li>
            </ul>
            <div class="rank-list rank-list1"><ul></ul><div class="rank-my"></div><img src="<?=$site.$env?>/<?=$path?>/images/tip1.png" class="tip"></div>
            <div class="rank-list rank-list2" style="display:none"><ul></ul></div>
        </div>
    </div>
    <div class="page-finger">
        <img src="<?=$site.$env?>/<?=$path?>/images/finger.png">
    </div>
    <section class="global-ctrl" id="g-ctrl">
        <!-- 音乐播放控制 -->
        <div class="player-btn">
            <div><audio class="bg-music" autoplay loop="true" src="<?=$site.$env?>/<?=$path?>/images/music.mp3" preload></audio></div>
        </div>
    </section>
    <input type="hidden" name="_csrf" id='csrf' value="<?= Yii::$app->request->csrfToken ?>">
</div>


<!-- 基础JS脚本部分 -->
<script src="http://qing.94uv.cn/common/jquery/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?=$site.$env?>/<?=$path?>/js/page.min.js"></script>
<!-- 微信分享文字自定义 -->
<script src="<?=$site.$env?>/common/weixin-plusxxcb.js"></script>
<script>

$(function() {
    var path = window.location.href;
    wxData = {
        imgUrl: '<?=$site.$env?>/<?=$path?>/images/share.jpg',
        link: path,
        title: '长沙车展vs贪食蛇大战',
        desc: '贪食蛇大战，赢长沙车展门票'
    };
    weixin.bindData(wxData);

    //微信下兼容音乐处理
    document.addEventListener("WeixinJSBridgeReady", function () {
        var music = $('audio')[0];
        var _me = $('.player-btn');
        if (_me.hasClass('player-btn-stop')) {
            music.pause();
        }
        else {
            music.play();
        }
    }, false);
})
</script>
<!-- PHPStat Start -->
<script language="JavaScript">var _trackData = _trackData || [];</script>
<script type="text/javascript" charset="utf-8" id="phpstat_js_id_10000011" src="//stat.xxcb.cn/phpstat/count/10000011/10000011.js"></script><noscript><img src="//stat.xxcb.cn/phpstat/count/10000011/10000011.php" alt="PHPStat Analytics"/></noscript>
<!-- PHPStat End -->
</body>
</html>