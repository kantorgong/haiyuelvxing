<?php
$env = \components\XyXy::getEnv(true);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>2016年度“潇湘房地产风云榜”入围榜单</title>
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="stylesheet" href="http://s2.xxcb.<?=$env?>/zt/2016bangyang/css/page.css"></head>
<body>
<div class="error">
    <?php if ($message):?>
        <h2 style="color: #fff; height: 300px; line-height: 300px;">活动已结束！</h2>
    <?php else: ?>
        <img src="http://s2.xxcb.<?=$env?>/zt/2016bangyang/img/error-txt.png">
    <?php endif; ?>
</div>
<!-- 基础JS脚本部分 -->
<script src="http://qing.94uv.cn/common/jquery/jquery-1.10.2.min.js"></script>
<!-- 当前页面自定义JS -->
<!-- 微信分享文字自定义 -->
<script>
    $(function () {
        var winH = $(window).height();
        $('.error').height(winH);
    })
</script>
<!-- PHPStat Start -->
<script language="JavaScript">var _trackData = _trackData || [];</script>
<script type="text/javascript" charset="utf-8" id="phpstat_js_id_10000011" src="//stat.xxcb.cn/phpstat/count/10000011/10000011.js"></script><noscript><img src="//stat.xxcb.cn/phpstat/count/10000011/10000011.php" alt="PHPStat Analytics"/></noscript>
<!--/PHPStat End -->
</body>
</html>