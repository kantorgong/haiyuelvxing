<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use  yii\helpers\Url;
use frontend\assets\ThemeAsset;
use components\helper\CommonUtility;

use components\XyXy;

$site = 'http://s1.teencn.' . XyXy::getEnv().'/composition/';//js、css站点地址
$domain = XyXy::getFrontendWebUrl();//前台站点 'http://cwds.teencn.dev/';
$teen = 'http://www.teencn.' . XyXy::getEnv();//十几岁网站
$awards = CommonUtility::getDictsList('cwds_awards', 0, true);
?>

    <!-- 第一屏 start -->
    <div class="bg-blue cl box-page1">
        <div class="wrap">
            <!-- 轮播图 start -->
            <div id="sld" class="fl">
                <ul class="slides_container">
                <?php foreach ($banner as $v):?>
                    <li>
                        <a href="<?=$domain?>teen/news/view.html?id=<?=$v['article_id']?>" target="_blank">
                            <img src="<?=$v['title_pic']?>" width="610" height="524"/>
                            <span></span>
                            <strong><?=$v['title']?></strong>
                        </a>
                    </li>
                <?php endforeach;?>
                </ul>
            </div>
            <!-- 轮播图 end -->
            <!-- 新闻 start -->
            <div class="fr i-news">
                <?php foreach ($top as $v):?>
                <dl>
                    <dt><h2><a href="<?=$domain?>teen/news/view.html?id=<?=$v['article_id']?>"><?=$v['title']?></a></h2></dt>
                    <dd><?=$v['desc']?></dd>
                </dl>
                <?php endforeach;?>
                <ul class="i-list">
                    <?php foreach ($news as $v):?>
                    <li><a href="<?=$domain?>teen/news/view.html?id=<?=$v['article_id']?>"  target="_blank"><?=$v['title']?></a></li>
                    <?php endforeach;?>
                </ul>
            </div>
            <!-- 新闻 end -->
        </div>
    </div>
    <!-- 第一屏 end -->

    <!-- 第二屏 start -->
    <div class="bg-cyan cl box-page2">
        <div class="wrap">
            <!-- 荣誉评委 start -->
            <div class="fl i-rypw">
                <div class="i-tit">
                    <a href="<?=$domain?>teen/rater/index.html" class="fr more"  target="_blank">更多>></a>
                    <h3 class="icon">荣誉评委</h3>
                </div>
                <div class="cl list">
                    <ul>
                        <?php foreach ($rater as $v):?>
                        <li>
                            <div class="img"><img src="<?=$v['photo']?>" height="120" width="120" alt="<?=$v['name']?>"></div>
                            <strong><?=$v['name']?></strong>
                            <p><?=$v['desc']?></p>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
            <!-- 荣誉评委 end -->
            <!-- 出版作品集专栏 start -->
            <div class="fr i-cbzp">
                <div class="i-tit">
                    <h3 class="icon">出版作品集专栏</h3>
                </div>

                <div class="img">
                    <img src="<?=$ttopworks['title_pic']?>" height="260" width="560" alt="<?=$ttopworks['title']?>">
                    <span></span>
                    <strong><?=$ttopworks['title']?></strong>
                </div>

                <div class="cl hot">
                    <div class="fl pic">
                        <img src="<?=$topworks['title_pic']?>" height="160" width="120" alt="<?=$topworks['title']?>">
                    </div>
                    <h3><a href="<?=$domain?>teen/news/view.html?id=<?=$v['article_id']?>" target="_blank"><?=$topworks['title']?></a></h3>
                    <p><?=$topworks['desc']?></p>
                </div>

                <div class="i-list">
                    <ul>
                        <?php foreach ($works as $v):?>
                        <li><a href="<?=$domain?>teen/news/view.html?id=<?=$v['article_id']?>" target="_blank"><?=$v['title']?></a></li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
            <!-- 出版作品集专栏 end -->
        </div>
    </div>
    <!-- 第二屏 end -->

    <!-- 第三屏 名师教写作 start -->
    <div class="bg-blue cl box-page3">
        <div class="wrap i-msxz">
            <div class="i-tit">
                <a href="<?=$domain?>teen/teacher/index.html" class="fr more" target="_blank">更多>></a>
                <h3 class="icon">名师教写作</h3>
            </div>
            <div class="slider-box slider-box1">
                <div class="slider">
                    <ul>
                        <?php foreach ($teacher as $v):?>
                        <li>
                            <a href="<?=$domain?>teen/news/view.html?id=<?=$v['writing']['article_id']?>" target="_blank">
                                <strong><?=$v['writing']['title']?></strong>
                                <p class="txt"><?=$v['writing']['desc']?></p>
                            </a>
                            <div class="pic">
                                <img src="<?=$v['photo']?>" height="120" width="120" alt="<?=$v['name']?>">
                                <span class="info">
                                    <p class="name"><?=$v['name']?></p>
                                    <p><?=$v['desc']?></p>
                                </span>
                            </div>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <div class="icon btl"></div>
                <div class="icon btr"></div>
            </div>
        </div>
    </div>
    <!-- 第三屏 名师教写作 end -->

    <!-- 第四屏 签约小作家 start -->
    <div class="bg-cyan cl box-page4">
        <div class="wrap i-qyzj">
            <div class="i-tit">
                <a href="<?=$domain?>teen/writer/index.html" class="fr more" target="_blank">更多>></a>
                <h3 class="icon">签约小作家</h3>
            </div>
            <div class="slider-box slider-box2">
                <div class="slider">
                    <ul>
                        <?php foreach ($writer as $v):?>
                        <li>
                            <a href="<?=$domain?>teen/writer/view.html?id=<?=$v['user_id']?>" target="_blank">
                                <img src="<?=$v['photo']?>" height="184" width="157" alt="<?=$v['name']?>">
                                <strong><?=$v['name']?></strong>
                                <p><?=$v['from']?></p>
                            </a>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <div class="icon btl"></div>
                <div class="icon btr"></div>
            </div>
        </div>
    </div>
    <!-- 第四屏 签约小作家 end -->
    <!-- 第五屏 start -->
    <div class="bg-white cl box-page5">
        <!-- 赛事图库 start -->
        <div class="wrap i-sstk">
            <div class="i-tit">
                <a href="<?=$domain?>teen/match/index.html" class="fr more" target="_blank">更多>></a>
                <h3 class="icon">赛事图库</h3>
            </div>
            <div id="focus-box">
                <span class="icon prev">&nbsp;</span>
                <span class="icon next">&nbsp;</span>
                <ul>
                  <?php foreach ($matches as $v):?>
                    <li>
                        <a href="<?=$domain?>teen/match/view.html?id=<?=$v['gallery_id']?>" target="_blank">
                            <img width="240" height="310" src="<?=$v['title_pic']?>"  alt="<?=$v['title']?>" />
                        </a>
                        <p><?=$v['title']?></p>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
        <!-- 赛事图库 end -->
        <!-- 佳作展示 start -->
        <div class="wrap i-jzzs">
            <div class="i-tit">
                <h3 class="icon">佳作展示</h3>
            </div>
            <div class="cl">
                <div class="fl item">
                    <div class="cl dl">
                        <span class="icon icon1 dt">小低组</span>
                        <span class="dd">2016届小低组<br>获奖作品</span>
                    </div>
                    <ul>
                      <?php foreach ($xbottomwriting as $k=>$v):?>
                        <li>
                            <a href="<?=$domain?>teen/news/view.html?id=<?=$v['article_id']?>"  target="_blank">
                                <span><?=$k+1?></span>
                                【<?=$awards[$v['awards']]?>】<?=$v['title']?>/  <strong><?=$v['name']?></strong>
                            </a>
                        </li>
                        <?php endforeach;?>
                        <li class="last">
                            <a href="#">查看更多></a>
                        </li>
                    </ul>
                </div>
                <div class="fl item">
                    <div class="cl dl">
                        <span class="icon icon2 dt">小高组</span>
                        <span class="dd">2016届小高组<br>获奖作品</span>
                    </div>
                    <ul>
                        <?php foreach ($xtopwriting as $k=>$v):?>
                        <li>
                            <a href="<?=$domain?>teen/news/view.html?id=<?=$v['article_id']?>"  target="_blank">
                                <span><?=$k+1?></span>
                                【<?=$awards[$v['awards']]?>】<?=$v['title']?>/  <strong><?=$v['name']?></strong>
                            </a>
                        </li>
                        <?php endforeach;?>
                        <li class="last">
                            <a href="#">查看更多></a>
                        </li>
                    </ul>
                </div>
                <div class="fl item">
                    <div class="cl dl">
                        <span class="icon icon3 dt">初中组</span>
                        <span class="dd">2016届初中组<br>获奖作品</span>
                    </div>
                    <ul>
                        <?php foreach ($middlewriting as $k=>$v):?>
                        <li>
                            <a href="<?=$domain?>teen/news/view.html?id=<?=$v['article_id']?>" target="_blank">
                                <span><?=$k+1?></span>
                                【<?=$awards[$v['awards']]?>】<?=$v['title']?>/  <strong><?=$v['name']?></strong>
                            </a>
                        </li>
                        <?php endforeach;?>
                        <li class="last">
                            <a href="#">查看更多></a>
                        </li>
                    </ul>
                </div>
                <div class="fl item">
                    <div class="cl dl">
                        <span class="icon icon4 dt">高中组</span>
                        <span class="dd">2016届高中组<br>获奖作品</span>
                    </div>
                    <ul>
                        <?php foreach ($topwriting as $k=>$v):?>
                        <li>
                            <a href="<?=$domain?>teen/news/view.html?id=<?=$v['article_id']?>" target="_blank">
                                <span><?=$k+1?></span>
                                【<?=$awards[$v['awards']]?>】<?=$v['title']?>/  <strong><?=$v['name']?></strong>
                            </a>
                        </li>
                        <?php endforeach;?>
                        <li class="last">
                            <a href="#">查看更多></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- 佳作展示 end -->
    </div>
    <!-- 第五屏 end -->

    <!-- 第六屏 杂志精选 start -->
    <div class="bg-cyan cl box-page6">
        <div class="wrap i-zzjx">
            <div class="i-tit">
                <h3 class="icon"><a href="<?=$teen?>/magazine/index.html" target="_blank">杂志精选</a></h3>
            </div>
            <div class="cl">
                <?php if ($magzine[0]):?>
                <div class="fl pic">
                    <a href="<?=$teen?>/magazine/<?=$magzine[0]['m_id']?>/list.html">
                        <span class="icon icon-new"></span>
                        <img src="<?=$magzine[0]['title_pic']?>" height="522" width="390" alt="">
                        <p><?php if ($magzine[0]['myear']) echo $magzine[0]['myear'].'年';?><?=$magzine[0]['mnum']?></p>
                    </a>
                </div>
                <?php endif;?>
                <ul class="fl list">
                <?php foreach ($magzine as $k=>$v):?>
                    <?php if ($k > 0):?>
                    <li>
                        <a href="<?=$teen?>/magazine/<?=$v['m_id']?>/list.html"  target="_blank">
                            <img src="<?=$v['title_pic']?>" height="229" width="170" alt="">
                            <p><?php if ($v['myear']) echo $v['myear'].'年';?><?=$v['mnum']?></p>
                        </a>
                    </li>
                    <?php endif;?>
                <?php endforeach;?> 
                </ul>
            </div>
        </div>
    </div>
    <!-- 第六屏 杂志精选 end -->
    <!-- 第七屏 参赛学校 start -->
    <div class="bg-blue cl box-page7">
        <div class="wrap i-csxx">
            <div class="i-tit">
                <h3 class="icon">参赛学校</h3>
            </div>
            <div class="cl ct">
                <dl>
                    <dt>小学组学校：</dt>
                    <dd>
                    <?php foreach ($bottomschool as $k=>$v):?>
                        <?php if ($k > 0):?>
                          |  
                        <?php endif;?>
                        <a href="<?=$v['site_url']?>"  target="_blank"><?=$v['name']?></a>
                    <?php endforeach;?>
                                                                （排名不分先后）
                    </dd>
                </dl>
                <dl>
                    <dt>中学组学校：</dt>
                    <dd>
                    <?php foreach ($middleschool as $k=>$v):?>
                        <?php if ($k > 0):?>
                          |  
                        <?php endif;?>
                        <a href="<?=$v['site_url']?>"  target="_blank"><?=$v['name']?></a>
                    <?php endforeach;?>
                                                                （排名不分先后）
                    </dd>
                </dl>
                <dl>
                    <dt>高中组学校：</dt>
                    <dd>
                    <?php foreach ($topschool as $k=>$v):?>
                        <?php if ($k > 0):?>
                          |  
                        <?php endif;?>
                        <a href="<?=$v['site_url']?>"  target="_blank"><?=$v['name']?></a>
                    <?php endforeach;?>
                                                                （排名不分先后）
                    </dd>
                </dl>
            </div>
        </div>
    </div>
    <!-- 第七屏 参赛学校 end -->
    <!-- 第八屏 友情链接 start -->
    <div class="cl box-page8">
        <div class="wrap i-link">
            <div class="i-tit">
                <h3 class="icon">友情链接</h3>
            </div>
            <ul class="cl list">
                <?php foreach ($link as $k=>$v):?>
                <li><a href="<?=$v['site_url']?>"><?=$v['name']?></a></li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
    <!-- 第八屏 友情链接 end -->

    <!--js调用 start -->
    <script src="<?=$site?>js/mySystem.js"></script>
    <script src="<?=$site?>js/slides.min.jquery.js" type="text/javascript"></script>
    <script src="<?=$site?>js/zoomPic.js" type="text/javascript"></script>
    <!--js调用 end -->
