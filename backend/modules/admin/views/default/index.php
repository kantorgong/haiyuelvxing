<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\MenuWidget;

$this->context->layout = false; //不使用布局
//$this->context->layout = 'main'; //设置使用的布局文件

$this->title = Yii::$app->name;
$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" xmlns="http://www.w3.org/1999/html">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head(); ?>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
              type="text/css"/>
        <link
            href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css"
            rel="stylesheet" type="text/css"/>
        <link
            href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css"
            rel="stylesheet" type="text/css"/>
        <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css"
              rel="stylesheet" type="text/css"/>
        <link
            href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"
            rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->
        <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/jquery-notific8/jquery.notific8.min.css"
            rel="stylesheet" type="text/css"/>
        <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css" />
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <!--        <link href="-->
        <? //= Yii::getAlias('@web') ?><!--/theme/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />-->
        <!--        <link href="-->
        <? //= Yii::getAlias('@web') ?><!--/theme/metronic/assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />-->
        <!--        <link href="-->
        <? //= Yii::getAlias('@web') ?><!--/theme/metronic/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />-->
        <!--        <link href="-->
        <? //= Yii::getAlias('@web') ?><!--/theme/metronic/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />-->
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/css/components.min.css" rel="stylesheet"
              id="style_components" type="text/css"/>
        <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/css/plugins.min.css" rel="stylesheet"
              type="text/css"/>
        <!-- END THEME GLOBAL STYLES -->

        <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/apps/css/index.css" rel="stylesheet"
              type="text/css"/>
        <?php
        //皮肤加载，默认皮肤样式darkblue
        $skin = 'darkblue';
        //获取用户设置的皮肤
        if (isset(Yii::$app->user->identity->setting))
        {
            $setting = Yii::$app->user->identity->setting;
            $settingObj = json_decode($setting);
            if ($settingObj->skin != '')
            {
                $skin = $settingObj->skin;
//                $_COOKIE['metronic_skin'] = $skin;
            }
        }
        ?>
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/css/layout.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/css/themes/<?= $skin ?>.min.css"
              rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/css/custom.min.css"
              rel="stylesheet" type="text/css"/>
        <!-- END THEME LAYOUT STYLES -->
        <link href="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/apps/css/common.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="favicon.ico"/>
    </head>
    <!-- END HEAD -->


    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">


    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="/">
                    <img src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/logo.png" alt="logo"
                         class="logo-default"/> </a>

                <div class="menu-toggler sidebar-toggler">
                    <span></span>
                </div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
               data-target=".navbar-collapse">
                <span></span>
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">

                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <img alt="" class="img-circle"
                                 src="<?=\components\XyXy::formatAvatar(Yii::$app->user->identity->avatar)?>"/>
                            <span
                                class="username username-hide-on-mobile"> <?= Yii::$app->user->identity->name != '' ? Yii::$app->user->identity->name : Yii::$app->user->identity->username ?> </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="javascript:openapp('/admin/user/updateme.html','4','修改个人信息')"">
                                <i class="icon-user"></i> 个人资料 </a>
                            </li>
                            <li>
                                <a href="<?= Url::to(["logout"]); ?>">
                                    <i class="icon-key"></i> 退出 </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <!-- <li class="dropdown dropdown-quick-sidebar-toggler">
                        <a href="javascript:;" class="dropdown-toggle">
                            <i class="icon-logout"></i>
                        </a>
                    </li> -->
                    <!-- END QUICK SIDEBAR TOGGLER -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- BEGIN THEME PANEL -->
    <div class="theme-panel hidden-xs hidden-sm">
        <div class="toggler"></div>
        <div class="toggler-close"></div>
        <div class="theme-options">
            <div class="theme-option theme-colors clearfix">
                <span> 主题配色 </span>
                <ul>
                    <li class="color-default <?= $skin == 'default' ? 'current' : ''; ?>  tooltips"
                        data-style="default" data-container="body" data-original-title="Default"></li>
                    <li class="color-darkblue <?= $skin == 'darkblue' ? 'current' : ''; ?> tooltips"
                        data-style="darkblue" data-container="body" data-original-title="Dark Blue"></li>
                    <li class="color-blue <?= $skin == 'blue' ? 'current' : ''; ?> tooltips"
                        data-style="blue" data-container="body" data-original-title="Blue"></li>
                    <li class="color-grey <?= $skin == 'grey' ? 'current' : ''; ?> tooltips"
                        data-style="grey" data-container="body" data-original-title="Grey"></li>
                    <li class="color-light <?= $skin == 'light' ? 'current' : ''; ?> tooltips"
                        data-style="light" data-container="body" data-original-title="Light"></li>
                    <li class="color-light2 <?= $skin == 'light2' ? 'current' : ''; ?> tooltips"
                        data-style="light2" data-container="body" data-html="true"
                        data-original-title="Light 2"></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- END THEME PANEL -->
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"></div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <!-- BEGIN SIDEBAR -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <div class="page-sidebar navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->



                <?php

                echo MenuWidget::widget([
                    'options' => ['class' => 'page-sidebar-menu  page-header-fixed',
                        'data-keep-expanded' => 'false',
                        'data-auto-scroll' => 'true',
                        'data-slide-speed' => '200',
                        'style' => 'padding-top: 0px'
                    ],
                    'itemOptions' => [
                        'class' => 'nav-item ',
                    ],
                    'submenuTemplate' => '<ul class="sub-menu">{items}</ul>',
                ]);
                ?>

                <!-- END SIDEBAR MENU -->
                <!-- END SIDEBAR MENU -->
            </div>
            <!-- END SIDEBAR -->
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">

            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!--tags切换开始-->
                <div class="breadcrumbs content-tabs" id="breadcrumbs">
                    <div id="loading"><i class="loadingicon"></i><span style="color: #ccc">正在加载...</span></div>
                    <div id="right_tools_wrapper">
                        <span id="refresh_wrapper" title="刷新当前页"><i class="fa fa-refresh right_tool_icon"></i></span>
                    </div>
                    <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i></button>
                    <div id="task-content" class="J_menuTabs">
                        <ul class="macro-component-tab page-tabs-content" id="task-content-inner">
                            <li class="macro-component-tabitem noclose J_menuTab" app-id="0" app-url="/admin/default/sysindex.html"
                                app-name="系统首页">
                                <span class="macro-tabs-item-text">系统首页</span>
                            </li>
                        </ul>
                        <div style="clear:both;"></div>
                    </div>
                    <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i></button>
                    <div class="btn-group roll-nav roll-right">
                        <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

                        </button>
                        <ul role="menu" class="dropdown-menu dropdown-menu-right">
                            <li class="J_tabShowActive"><a>定位当前选项卡</a>
                            </li>
                            <li class="divider"></li>
                            <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                            </li>
                            <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--tags切换结束-->
                <!-- BEGIN PAGE HEADER-->

                <!-- BEGIN PAGE BAR -->
                <div class="col-xs-12" id="content">
                    <iframe src="<?= \yii\helpers\Url::to(['sysindex']) ?>" style="width:100%;height:100%;" frameborder="0"
                            id="appiframe-0" class="appiframe"></iframe>
                </div>
            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
        <!-- BEGIN QUICK SIDEBAR -->
        <a href="javascript:;" class="page-quick-sidebar-toggler">
            <i class="icon-login"></i>
        </a>

        <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
            <div class="page-quick-sidebar">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"> Users
                            <span class="badge badge-danger">2</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" data-target="#quick_sidebar_tab_2" data-toggle="tab"> Alerts
                            <span class="badge badge-success">7</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> More
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                    <i class="icon-bell"></i> Alerts </a>
                            </li>
                            <li>
                                <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                    <i class="icon-info"></i> Notifications </a>
                            </li>
                            <li>
                                <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                    <i class="icon-speech"></i> Activities </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:;" data-target="#quick_sidebar_tab_3" data-toggle="tab">
                                    <i class="icon-settings"></i> Settings </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                        <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd"
                             data-wrapper-class="page-quick-sidebar-list">
                            <h3 class="list-heading">Staff</h3>
                            <ul class="media-list list-items">
                                <li class="media">
                                    <div class="media-status">
                                        <span class="badge badge-success">8</span>
                                    </div>
                                    <img class="media-object"
                                         src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar3.jpg"
                                         alt="...">

                                    <div class="media-body">
                                        <h4 class="media-heading">Bob Nilson</h4>

                                        <div class="media-heading-sub"> Project Manager</div>
                                    </div>
                                </li>
                                <li class="media">
                                    <img class="media-object"
                                         src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar1.jpg"
                                         alt="...">

                                    <div class="media-body">
                                        <h4 class="media-heading">Nick Larson</h4>

                                        <div class="media-heading-sub"> Art Director</div>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-status">
                                        <span class="badge badge-danger">3</span>
                                    </div>
                                    <img class="media-object"
                                         src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar4.jpg"
                                         alt="...">

                                    <div class="media-body">
                                        <h4 class="media-heading">Deon Hubert</h4>

                                        <div class="media-heading-sub"> CTO</div>
                                    </div>
                                </li>
                                <li class="media">
                                    <img class="media-object"
                                         src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar2.jpg"
                                         alt="...">

                                    <div class="media-body">
                                        <h4 class="media-heading">Ella Wong</h4>

                                        <div class="media-heading-sub"> CEO</div>
                                    </div>
                                </li>
                            </ul>
                            <h3 class="list-heading">Customers</h3>
                            <ul class="media-list list-items">
                                <li class="media">
                                    <div class="media-status">
                                        <span class="badge badge-warning">2</span>
                                    </div>
                                    <img class="media-object"
                                         src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar6.jpg"
                                         alt="...">

                                    <div class="media-body">
                                        <h4 class="media-heading">Lara Kunis</h4>

                                        <div class="media-heading-sub"> CEO, Loop Inc</div>
                                        <div class="media-heading-small"> Last seen 03:10 AM</div>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-status">
                                        <span class="label label-sm label-success">new</span>
                                    </div>
                                    <img class="media-object"
                                         src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar7.jpg"
                                         alt="...">

                                    <div class="media-body">
                                        <h4 class="media-heading">Ernie Kyllonen</h4>

                                        <div class="media-heading-sub"> Project Manager,
                                            <br> SmartBizz PTL
                                        </div>
                                    </div>
                                </li>
                                <li class="media">
                                    <img class="media-object"
                                         src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar8.jpg"
                                         alt="...">

                                    <div class="media-body">
                                        <h4 class="media-heading">Lisa Stone</h4>

                                        <div class="media-heading-sub"> CTO, Keort Inc</div>
                                        <div class="media-heading-small"> Last seen 13:10 PM</div>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-status">
                                        <span class="badge badge-success">7</span>
                                    </div>
                                    <img class="media-object"
                                         src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar9.jpg"
                                         alt="...">

                                    <div class="media-body">
                                        <h4 class="media-heading">Deon Portalatin</h4>

                                        <div class="media-heading-sub"> CFO, H&D LTD</div>
                                    </div>
                                </li>
                                <li class="media">
                                    <img class="media-object"
                                         src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar10.jpg"
                                         alt="...">

                                    <div class="media-body">
                                        <h4 class="media-heading">Irina Savikova</h4>

                                        <div class="media-heading-sub"> CEO, Tizda Motors Inc</div>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-status">
                                        <span class="badge badge-danger">4</span>
                                    </div>
                                    <img class="media-object"
                                         src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar11.jpg"
                                         alt="...">

                                    <div class="media-body">
                                        <h4 class="media-heading">Maria Gomez</h4>

                                        <div class="media-heading-sub"> Manager, Infomatic Inc</div>
                                        <div class="media-heading-small"> Last seen 03:10 AM</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="page-quick-sidebar-item">
                            <div class="page-quick-sidebar-chat-user">
                                <div class="page-quick-sidebar-nav">
                                    <a href="javascript:;" class="page-quick-sidebar-back-to-list">
                                        <i class="icon-arrow-left"></i>Back</a>
                                </div>
                                <div class="page-quick-sidebar-chat-user-messages">
                                    <div class="post out">
                                        <img class="avatar" alt=""
                                             src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar3.jpg"/>

                                        <div class="message">
                                            <span class="arrow"></span>
                                            <a href="javascript:;" class="name">Bob Nilson</a>
                                            <span class="datetime">20:15</span>
                                            <span class="body"> When could you send me the report ? </span>
                                        </div>
                                    </div>
                                    <div class="post in">
                                        <img class="avatar" alt=""
                                             src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar2.jpg"/>

                                        <div class="message">
                                            <span class="arrow"></span>
                                            <a href="javascript:;" class="name">Ella Wong</a>
                                            <span class="datetime">20:15</span>
                                            <span class="body"> Its almost done. I will be sending it shortly </span>
                                        </div>
                                    </div>
                                    <div class="post out">
                                        <img class="avatar" alt=""
                                             src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar3.jpg"/>

                                        <div class="message">
                                            <span class="arrow"></span>
                                            <a href="javascript:;" class="name">Bob Nilson</a>
                                            <span class="datetime">20:15</span>
                                            <span class="body"> Alright. Thanks! :) </span>
                                        </div>
                                    </div>
                                    <div class="post in">
                                        <img class="avatar" alt=""
                                             src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar2.jpg"/>

                                        <div class="message">
                                            <span class="arrow"></span>
                                            <a href="javascript:;" class="name">Ella Wong</a>
                                            <span class="datetime">20:16</span>
                                            <span class="body"> You are most welcome. Sorry for the delay. </span>
                                        </div>
                                    </div>
                                    <div class="post out">
                                        <img class="avatar" alt=""
                                             src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar3.jpg"/>

                                        <div class="message">
                                            <span class="arrow"></span>
                                            <a href="javascript:;" class="name">Bob Nilson</a>
                                            <span class="datetime">20:17</span>
                                            <span class="body"> No probs. Just take your time :) </span>
                                        </div>
                                    </div>
                                    <div class="post in">
                                        <img class="avatar" alt=""
                                             src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar2.jpg"/>

                                        <div class="message">
                                            <span class="arrow"></span>
                                            <a href="javascript:;" class="name">Ella Wong</a>
                                            <span class="datetime">20:40</span>
                                            <span class="body"> Alright. I just emailed it to you. </span>
                                        </div>
                                    </div>
                                    <div class="post out">
                                        <img class="avatar" alt=""
                                             src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar3.jpg"/>

                                        <div class="message">
                                            <span class="arrow"></span>
                                            <a href="javascript:;" class="name">Bob Nilson</a>
                                            <span class="datetime">20:17</span>
                                            <span class="body"> Great! Thanks. Will check it right away. </span>
                                        </div>
                                    </div>
                                    <div class="post in">
                                        <img class="avatar" alt=""
                                             src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar2.jpg"/>

                                        <div class="message">
                                            <span class="arrow"></span>
                                            <a href="javascript:;" class="name">Ella Wong</a>
                                            <span class="datetime">20:40</span>
                                            <span class="body"> Please let me know if you have any comment. </span>
                                        </div>
                                    </div>
                                    <div class="post out">
                                        <img class="avatar" alt=""
                                             src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/img/avatar3.jpg"/>

                                        <div class="message">
                                            <span class="arrow"></span>
                                            <a href="javascript:;" class="name">Bob Nilson</a>
                                            <span class="datetime">20:17</span>
                                            <span class="body"> Sure. I will check and buzz you if anything needs to be corrected. </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="page-quick-sidebar-chat-user-form">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Type a message here...">

                                        <div class="input-group-btn">
                                            <button type="button" class="btn green">
                                                <i class="icon-paper-clip"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane page-quick-sidebar-alerts" id="quick_sidebar_tab_2">
                        <div class="page-quick-sidebar-alerts-list">
                            <h3 class="list-heading">General</h3>
                            <ul class="feeds list-items">
                                <li>
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-info">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> You have 4 pending tasks.
                                                        <span class="label label-sm label-warning "> Take action
                                                            <i class="fa fa-share"></i>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> Just now</div>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-success">
                                                        <i class="fa fa-bar-chart-o"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> Finance Report for year 2013 has been released.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 20 mins</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-danger">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> You have 5 pending membership that requires a quick
                                                    review.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 24 mins</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-info">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> New order received with
                                                    <span class="label label-sm label-success"> Reference Number: DR23923 </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 30 mins</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> You have 5 pending membership that requires a quick
                                                    review.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 24 mins</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-info">
                                                    <i class="fa fa-bell-o"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> Web server hardware needs to be upgraded.
                                                    <span class="label label-sm label-warning"> Overdue </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 2 hours</div>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-default">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> IPO Report for year 2013 has been released.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 20 mins</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <h3 class="list-heading">System</h3>
                            <ul class="feeds list-items">
                                <li>
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-info">
                                                    <i class="fa fa-check"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> You have 4 pending tasks.
                                                        <span class="label label-sm label-warning "> Take action
                                                            <i class="fa fa-share"></i>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> Just now</div>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-danger">
                                                        <i class="fa fa-bar-chart-o"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> Finance Report for year 2013 has been released.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 20 mins</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-default">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> You have 5 pending membership that requires a quick
                                                    review.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 24 mins</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-info">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> New order received with
                                                    <span class="label label-sm label-success"> Reference Number: DR23923 </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 30 mins</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-success">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> You have 5 pending membership that requires a quick
                                                    review.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 24 mins</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="col1">
                                        <div class="cont">
                                            <div class="cont-col1">
                                                <div class="label label-sm label-warning">
                                                    <i class="fa fa-bell-o"></i>
                                                </div>
                                            </div>
                                            <div class="cont-col2">
                                                <div class="desc"> Web server hardware needs to be upgraded.
                                                    <span class="label label-sm label-default "> Overdue </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col2">
                                        <div class="date"> 2 hours</div>
                                    </div>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <div class="col1">
                                            <div class="cont">
                                                <div class="cont-col1">
                                                    <div class="label label-sm label-info">
                                                        <i class="fa fa-briefcase"></i>
                                                    </div>
                                                </div>
                                                <div class="cont-col2">
                                                    <div class="desc"> IPO Report for year 2013 has been released.</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col2">
                                            <div class="date"> 20 mins</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane page-quick-sidebar-settings" id="quick_sidebar_tab_3">
                        <div class="page-quick-sidebar-settings-list">
                            <h3 class="list-heading">General Settings</h3>
                            <ul class="list-items borderless">
                                <li> Enable Notifications
                                    <input type="checkbox" class="make-switch" checked data-size="small"
                                           data-on-color="success" data-on-text="ON" data-off-color="default"
                                           data-off-text="OFF"></li>
                                <li> Allow Tracking
                                    <input type="checkbox" class="make-switch" data-size="small" data-on-color="info"
                                           data-on-text="ON" data-off-color="default" data-off-text="OFF"></li>
                                <li> Log Errors
                                    <input type="checkbox" class="make-switch" checked data-size="small"
                                           data-on-color="danger" data-on-text="ON" data-off-color="default"
                                           data-off-text="OFF"></li>
                                <li> Auto Sumbit Issues
                                    <input type="checkbox" class="make-switch" data-size="small" data-on-color="warning"
                                           data-on-text="ON" data-off-color="default" data-off-text="OFF"></li>
                                <li> Enable SMS Alerts
                                    <input type="checkbox" class="make-switch" checked data-size="small"
                                           data-on-color="success" data-on-text="ON" data-off-color="default"
                                           data-off-text="OFF"></li>
                            </ul>
                            <h3 class="list-heading">System Settings</h3>
                            <ul class="list-items borderless">
                                <li> Security Level
                                    <select class="form-control input-inline input-sm input-small">
                                        <option value="1">Normal</option>
                                        <option value="2" selected>Medium</option>
                                        <option value="e">High</option>
                                    </select>
                                </li>
                                <li> Failed Email Attempts
                                    <input class="form-control input-inline input-sm input-small" value="5"/></li>
                                <li> Secondary SMTP Port
                                    <input class="form-control input-inline input-sm input-small" value="3560"/></li>
                                <li> Notify On System Error
                                    <input type="checkbox" class="make-switch" checked data-size="small"
                                           data-on-color="danger" data-on-text="ON" data-off-color="default"
                                           data-off-text="OFF"></li>
                                <li> Notify On SMTP Error
                                    <input type="checkbox" class="make-switch" checked data-size="small"
                                           data-on-color="warning" data-on-text="ON" data-off-color="default"
                                           data-off-text="OFF"></li>
                            </ul>
                            <div class="inner-content">
                                <button class="btn btn-success">
                                    <i class="icon-settings"></i> Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END QUICK SIDEBAR -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <div class="page-footer-inner"> XXCB

        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <!-- END FOOTER -->
    <!--[if lt IE 9]>
    <script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/respond.min.js"></script>
    <script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/excanvas.min.js"></script>
    <![endif]-->
    <!-- BEGIN CORE PLUGINS -->
    <script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/jquery.min.js"
            type="text/javascript"></script>
    <script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js"
            type="text/javascript"></script>
    <script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/js.cookie.min.js"
            type="text/javascript"></script>
    <script
        src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"
        type="text/javascript"></script>
    <script
        src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"
        type="text/javascript"></script>
    <script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/jquery.blockui.min.js"
            type="text/javascript"></script>
    <script
        src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
        type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/scripts/app.min.js"
            type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/scripts/layout.min.js"
            type="text/javascript"></script>
    <script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/layout/scripts/demo.min.js"
            type="text/javascript"></script>
    <script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/layouts/global/scripts/quick-sidebar.min.js"
            type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/global/plugins/bootstrap-toastr/toastr.min.js" type="text/javascript"></script>

    <script src="<?= Yii::getAlias('@web') ?>/theme/metronic/assets/apps/scripts/index.js"
            type="text/javascript"></script>
    <script>

        /**通知方法
         *
         * 操作反馈通知，错误、警告、成功等形式的通知
         *
         * @parma   {string}    title   标题
         * @parma   {string}    message   信息
         * @parma   {string}    noticeype   类型（info,success,warning,error）
         * @returns void
         *
         * @data    2016-11-18
         * @author  gongjt@xxcb.cn
         */
        function xcms_notific(title, message, noticeype){
                    if(title == ''){
                        title = '通知';
                    }
                    switch (noticeype){
                        case 'info':toastr.info(message, title);break;
                        case 'success':toastr.success(message, title);break;
                        case 'warning':toastr.warning(message, title);break;
                        case 'error':toastr.error(message, title);break;
                    }
                }

        /**通知方法
         *
         * 操作反馈通知，错误、警告、成功、其他等形式的通知
         *
         * @parma   {string}    title   标题
         * @parma   {string}    theme   主题类型[teal(蓝色),amethyst(紫色),ruby(红色),tangerine(黄色),lemon(浅黄),lime(绿色),ebony(黑色),smoke(灰色)]
         * @parma   {object}    onInit   初始化回调
         * @parma   {object}    onCreate   创建回调
         * @parma   {object}    onClose   关闭回调
         * @returns void
         *
         * @data    2016-10-28
         * @author  gongjt@xxcb.cn
         */
//        function xcms_notific(title, theme, onInit, onCreate, onClose) {
//            //标题
//            title = title || '未知';
//
//            //自动关闭时间
////                life = life || 5000;
//
//            // short heading for the notification
////                heading = heading || '<a href="#">通知</a> test';
//            //蓝色   紫色      红色   黄色      浅黄     绿色   黑色      灰色
//            // teal, amethyst,ruby, tangerine, lemon, lime, ebony, smoke
//            theme = theme || 'teal';
//
//            // boolean for whether or not the notification should stick
////                sticky = sticky || true;
//
//            // string value for top or bottom of the page
////                horizontalEdge = horizontalEdge || 'bottom';
//
//            // string value for left or right of the page
////                verticalEdge = verticalEdge|| 'left';
//
//            // integer value for the z-index
////                zindex = zindex || 3000;
//
//            // set an icon for notifications
////                icon = icon || false;
//
//            // string for the text on the close button
////                closeText = closeText || '关闭';
//
//            // callbacks
//            onInit = onInit || null;
//            onCreate = onCreate || null;
//            onClose = onClose || null;
//            $.notific8(title, {
//                life: 5000,
//                heading: '通知',
//                theme: theme,
//                sticky: false,
//                horizontalEdge: 'top',
//                verticalEdge: 'right',
//                zindex: 1500,
//                icon: false,
//                closeText: '关闭',
//                onInit: onInit,
//                onCreate: onCreate,
//                onClose: onClose
//            });
//        }


        //弹出窗口
        function dialogGridViewConfirm(url) {
            errorMsg = '操作失败，请重试，或者联系管理员，谢谢';
            $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'json',
                    success: function (data) {
                        //操作失败
                        if (!(data.status == 0)) {
                            if (data.message != '')
                                errorMsg = data.message;
                            xcms_notific('', errorMsg, 'error');
                            return false;
                        }
                        else {
                            //操作成功,刷新当前框架
                            xcms_notific('', '操作成功', 'success');
                            $('#refresh_wrapper').click();
                        }
                    },
                    //操作失败
                    error: function () {
                        xcms_notific('', errorMsg, 'error');
                        return false;
                    }
                }
            );
        }
    </script>


    </body>

    </html>
<?php $this->endPage() ?>