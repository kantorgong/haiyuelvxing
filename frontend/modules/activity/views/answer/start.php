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
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <script>
    var deviceWidth =  parseInt(window.screen.width);var deviceScale = deviceWidth/750;var ua = navigator.userAgent;if (/Android (\d+\.\d+)/.test(ua)){var version = parseFloat(RegExp.$1);if(version>2.3){document.write('<meta name="viewport" content="width=750,initial-scale='+deviceScale+', minimum-scale = '+deviceScale+', maximum-scale = '+deviceScale+', target-densitydpi=device-dpi">');}else{document.write('<meta name="viewport" content="width=750,initial-scale=0.75,maximum-scale=0.75,minimum-scale=0.75,target-densitydpi=device-dpi" />');}} else {document.write('<meta name="viewport" content="width=750, user-scalable=no">');}
    </script>
    <link rel="stylesheet" type="text/css" href="<?=$site.$env?>/<?=$path?>/css/page.css">
</head>
<body>
<div class="wrap">
    <div style="display: none;"><img src="<?=$site.$env?>/<?=$path?>/images/share.jpg"></div>
    <div id="content">
        <section class="page page2">
            <div class="tit">
                <img src="<?=$site.$env?>/<?=$path?>/images/p2-img.png" alt="新春理财季">
                <div class="q"><span id="que"><?= $question['answer'] ?></span></div>
                <div class="time"><span id="time">0</span>s</div>
                <div class="num"><span class="cur" id="num">1</span><span class="contact">/</span><span class="total">8</span></div>
            </div>
            <ul class="list" id="answer">
                <?php
                    foreach($question['option'] as $value):
                ?>
                    <li><span class="ans"><?= $value?></span></li>
                <?php
                    endforeach;
                ?>
            </ul>
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