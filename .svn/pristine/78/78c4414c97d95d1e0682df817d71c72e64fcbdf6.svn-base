<?php
$env = \components\XyXy::getEnv(true);
$path = '2017xclcj';
$site = 'http://s4.xxcb.';
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
<div>
    <div style="display: none;"><img src="<?=$site.$env?>/<?=$path?>/images/share.jpg"></div>
    <div id="content">
        <section class="page page5">
        <?php if(empty($newTopRank)):?>
            <div class="no-tip">没有您的中奖信息</div>
        <?php else:?>
            <?php $rankInfo = [1=>'一',2=>'二',3=>'三',4=>'四',5=>'五',6=>'六',7=>'七',8=>'八',9=>'九',10=>'十'];?>
			<?php foreach($newTopRank as $key=>$userInfo):?>
            <div class="list">
                <div class="img">
                    <img src="<?= $userInfo['avatar']?>" alt="头像">
                </div>
                <p><?= $userInfo['nick_name']?></p>
                <dl>
                    <dt>获奖时间：</dt>
                    <dd><?= $userInfo['date']?></dd>
                </dl>
                <dl>
                    <dt>奖品：</dt>
                    <dd><?= $rankInfo[$userInfo['rank']];?>等奖</dd>
                </dl>
				<?php if($userInfo['isHave'] == 1):?>
					<a href="javascript:;" class="btn">已领取</a>
				<?php else:?>
					<a href="javascript:;" class="btn btn-ok" data-date="<?= $key;?>">领取</a>
				<?php endif;?>
            </div>
			<?php endforeach;?>
        <?php endif;?>
        </section>
    </div>
    <div class="page-share">
        <img src="<?=$site.$env?>/<?=$path?>/images/page-share.png">
    </div>
</div>

<script src="http://qing.94uv.cn/common/jquery/jquery-1.10.2.min.js"></script>

<!-- 微信分享文字自定义 -->
<script src="http://qing.94uv.cn/common/weixin-plusxxcb.js"></script>
<script type="text/javascript" src="<?=$site.$env?>/<?=$path?>/js/page.min.js"></script>
<?php echo $this->render('common'); ?>
</body>
</html>