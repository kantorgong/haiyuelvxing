<?php
$env = \components\XyXy::getEnv(true);
$path = 'zt/2017xclcj';
$site = 'http://s2.xxcb.';
if ($env == 'dev')
{
    $path = 'zt/2017xclcj';
    $site = 'http://s2.xxcb.';
}
else if($env == 'test') {
    $path = 'zt/2017xclcj';
    $site = 'http://s2.xxcb.';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>2017新春理财季</title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <script>
    var deviceWidth =  parseInt(window.screen.width);var deviceScale = deviceWidth/750;var ua = navigator.userAgent;if (/Android (\d+\.\d+)/.test(ua)){var version = parseFloat(RegExp.$1);if(version>2.3){document.write('<meta name="viewport" content="width=750,initial-scale='+deviceScale+', minimum-scale = '+deviceScale+', maximum-scale = '+deviceScale+', target-densitydpi=device-dpi">');}else{document.write('<meta name="viewport" content="width=750,initial-scale=0.75,maximum-scale=0.75,minimum-scale=0.75,target-densitydpi=device-dpi" />');}} else {document.write('<meta name="viewport" content="width=750, user-scalable=no">');}
    </script>
    <link rel="stylesheet" type="text/css" href="<?=$site.$env?>/<?=$path?>/css/page.css">
</head>
<body>
<div class="wrap2">
    <div style="display: none;"><img src="<?=$site.$env?>/<?=$path?>/images/share.jpg"></div>
    <div id="content">
        <section class="page page3 page-rank">
            <img class="tip" src="<?=$site.$env?>/<?=$path?>/images/tip.png" alt="温馨提示">
            <div class="rule">
                <p>游戏规则：3月29日-31日，每日9:00~22:00排行榜第一名将获得神秘大奖，2-10名也将获得精美礼品一份，领奖及获奖公布敬请关注“金融258”微信公众号。</p>
                <img src="<?=$site.$env?>/<?=$path?>/images/p3-arrow.png" class="arrow">
                <img src="<?=$site.$env?>/<?=$path?>/images/p3-ecode.png" class="ecode">
            </div>
            <?php if($currentDay): ?>
            <div class="rank-box">
                <img src="<?=$site.$env?>/<?=$path?>/images/rank-bg.png" alt="排行榜背景">
                <div class="tit">排行榜<span class="date">(<?= date('m月d日')?>)</span></div>
                <ul class="rank">
                    <?php foreach($currentDay as $value):?>
                        <li>
                            <span class="img"><img src=" <?=$value['avatar']?>"></span>
                            <span class="name"><?= $value['nick_name']?></span>
                            <span class="score"><?= $value['score']?>分</span>
                            <span class="time"><?= $value['mtime']?>s</span>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
            <?php endif;?>
            <?php foreach($topRank as $key=>$rank):?>
            <div class="rank-other">
                <div class="rank-box">
                    <img src="<?=$site.$env?>/<?=$path?>/images/rank-bg.png" alt="排行榜背景">
                    <div class="tit">排行榜<span class="date">(<?= date('m月d日', strtotime($key));?>)</span></div>
                    <ul class="rank">
                        <?php foreach($rank as $val):?>
                            <li>
                                <span class="img"><img src=" <?=$val['avatar']?>"></span>
                                <span class="name"><?= $val['nick_name']?></span>
                                <span class="score"><?= $val['score']?>分</span>
                                <span class="time"><?= $val['mtime']?>s</span>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
            <?php endforeach;?>

        </section>
    </div>
</div>

<script src="http://qing.94uv.cn/common/jquery/jquery-1.10.2.min.js"></script>

<!-- 微信分享文字自定义 -->
<script src="http://qing.94uv.cn/common/weixin-plusxxcb.js"></script>
<script type="text/javascript" src="<?=$site.$env?>/<?=$path?>/js/page.min.js"></script>
<?php echo $this->render('common'); ?>
</body>
</html>