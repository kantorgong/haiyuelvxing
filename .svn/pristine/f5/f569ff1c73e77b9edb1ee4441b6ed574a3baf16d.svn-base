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

<body>
<div class="index">
    <img class="logo" src="http://s4.xxcb.cn/2017xqf/mobile/img/logo.png" alt="潇湘晨报">
    <h1>2017长沙小学学区房查询</h1>
    <form id="areaForm" class="area" method="get">
        <table>
            <tr>
                <td>
                    <input class="areatext" placeholder="请输入小区名称" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" class="arealbt" id="areaclick">按小区查询</button>
                </td>
            </tr>
        </table>
    </form>
    <form id="schoolForm" class="school" method="get" >
        <table>
            <tr>
                <td>
                    <input class="schooltext" placeholder="请输入学校名称" type="text">
                </td>
            </tr>
            <tr>
                <td>
                    <button type="button" id="schoolclick" class="schoolbt">按学校查询</button>
                </td>
            </tr>
        </table>
    </form>
    <div class="erro">
        请输入要查询的内容
    </div>
</div>
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
<script type="text/javascript" src="http://s4.xxcb.cn/2017xqf/mobile/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="http://s4.xxcb.cn/2017xqf/mobile/js/page.js"></script>
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
            link: baseUrl + 'index.html',
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
		$('#areaclick').click(function(){
			var areatext = $('.areatext').val();
            if(areatext == ''){
                $('.erro').show();
                return false;
            }
            else
            {
                window.location.href = 'search.html?type=1&keyWords='+areatext;
            }


		})
		$('#schoolclick').click(function(){
			var schooltext = $('.schooltext').val();
            if(schooltext == ''){
                $('.erro').show();
                return false;
            }
            else
            {
                window.location.href = 'search.html?type=2&keyWords='+schooltext;
            }

		})

    });
</script>
</html>