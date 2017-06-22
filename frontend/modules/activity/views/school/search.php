<!DOCTYPE html>
<html>
<head>
    <title>2017长沙小学学区房查询</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="http://s4.xxcb.cn/2017xqf/mobile/css/page.css">
    <script type="text/javascript" src="http://s4.xxcb.cn/2017xqf/mobile/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="http://s4.xxcb.cn/2017xqf/mobile/js/page.js"></script>
<body>
<div class="page">
    <div class="title">关于<?php if(\Yii::$app->request->get('type', 1) == 1){echo '小区';}else{echo '学校';} ?><span>“<?= $keyWords ?>”</span>的查询结果</div>
    <div>
        <a class="back" href="index.html">重新查询</a>
        <a class="share">分享到朋友圈</a>
    </div>
    <ul>
		<?php foreach($list as $key=>$value):?>
        <li>
            <div>
                <strong><?= $value['school']?></strong>
                <em><?= $value['area']?></em>
            </div>
            <p>
                <?= $value['extent']?>
            </p>
            <?php if($value['remark']):?>
            <p>
                备注：<?= $value['remark']?>
            </p>
            <?php endif;?>
        </li>
		<?php endforeach;?>
    </ul>
    <div class="tips">
        数据来源：长沙教育信息网
    </div>
    <div class="pop">
        <img src="http://s4.xxcb.cn/2017xqf/mobile/img/share.png" alt="分享到朋友圈">
    </div>
</div>
<script src="http://qing.94uv.cn/common/weixin-plusxxcb.js"></script>
<script>
    $(function(){
        // 微信分享
        var wxData;
        var path = window.location.href;
        var baseUrl = path.substr(0, path.lastIndexOf('/') + 1);
        var text = '2017长沙最新小学学区房信息';
        wxData = {
            imgUrl:'http://s4.xxcb.cn/2017xqf/mobile/img/share.jpg',
            link: path,
            title: text,
            desc: '快来看看你的小区属于哪个学区吧。',
            success: function () {
                $('.pop').hide();
            }
        };
        weixin.on('ready', function () {
            weixin.bindData(wxData);
            weixin.bindShareInfo();
        });
			
    })
</script>
<div id="xxstata" style="display:none">
    <!--cnzz统计开始-->
    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1000357880'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s22.cnzz.com/z_stat.php%3Fid%3D1000357880' type='text/javascript'%3E%3C/script%3E"));</script>
    <!--cnzz统计结束-->
    <!--baidu统计开始-->
    <script type="text/javascript">
        var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
        document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F0250e3b9e44988fab79712e22f4c9b8a' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <!--www扩展统计 开始-->
    <!-- PHPStat Start -->
    <script language="JavaScript" charset="utf-8" id="phpstat_js_id" src="//stat.xxcb.cn/phpstat/count/10000001/10000001.js" ></script><noscript><img src="//stat.xxcb.cn/phpstat/count/10000001/10000001.php" alt="" style="border:0" /></noscript>
    <!--/PHPStat End -->
    <script type="text/javascript">
        var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
        document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F0' type='text/javascript'%3E%3C/script%3E"));
    </script><!--www扩展统计 结束-->
    <!--baidu统计结束-->
</div><!--全站统计-->
</body>
</html>