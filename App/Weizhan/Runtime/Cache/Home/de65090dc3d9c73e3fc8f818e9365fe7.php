<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=uft-8" />
    <title><?php echo ($title); ?></title>
    <base href="." />
    <meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="__CSS__/font-awesome.css" />
    <link rel="stylesheet" href="__APP_H_CSS__/common.css" />
    <link rel="stylesheet" href="__AP__/<?php echo (APP_NAME); ?>/Resource/Skin_1/Css/layout.css" />
    <!--<link rel="stylesheet" href="__AP__/<?php echo (APP_NAME); ?>/Resource/Skin_1/Css/common.css" />
    <link rel="stylesheet" href="__AP__/<?php echo (APP_NAME); ?>/Resource/Skin_1/Css/layout.css" />-->

    <script src="__JS__/sea.js"></script>
    <script type="text/javascript">
        var zxPath = "";
        var basePath = "";
        seajs.config({
            base:'',
            alias: {
                'jquery': '__JS__/jquery.js',
                'uio': '__JS__/jquery.uio.js',
                'tmpl': '__JS__/jquery.tmpl.js',
                'validform': '__JS__/validform/validform.js',
                'json': '__JS__/jquery.json.js',
                'iscroll.css': '__APP_H_JS__/iscroll/iscroll.css',
                'iscroll': '__APP_H_JS__/iscroll/iscroll.js'
            }
        });
    </script>
</head>
<body>


<!-- headTop Start -->
<div class="headTop font_yahei">
    <ul>
        <li class="topItem"><a href="javascript:;" class="goback" title="返回" onclick="history.go(-1);"></a></li>
        <li class="topItem">
            <a href="javascript:;" id="headMenuBtn" class="headMenuBtn" title="顶部导航">顶部导航</a>
            <div id="headMenu" class="headMenu clearfix hidden">
                <ul>
                    <?php if(is_array($topList)): $i = 0; $__LIST__ = $topList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li class="menuItem">
                            <a href="<?php echo ($item["linkurl"]); ?>"><?php echo ($item["column_name"]); ?></a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </li>
        <li class="topItem noLine"><a href="javascript:;" class="refresh" title="刷新" onclick="location.reload();"></a></li>
    </ul>
</div>
<!-- headTop End -->

<!-- 内容主体 Start -->
<div class="container">
    <div class="about">
        <?php echo ($app["wz_intro"]); ?>
    </div>
</div>
<!-- 内容主体 End -->


<!-- Footer Start -->
<div class="footer">
    <div class="footer_inner">
        您身边的微信营销专家&nbsp;&nbsp;&nbsp;&nbsp;Tel：400-8000-800
        <span class="fl_r"><a href="javascript:;" id="share" class="share">关注分享</a></span>
    </div>
</div>

<div id="coverBg" class="coverBg hidden"></div>
<div id="shareBox" class="shareBox hidden">
    <div id="shareBg" class="shareBg"></div>
    <img src="__APP_H_IMG/pic/share.png" />
</div>
<!-- Footer End -->

<script>
    seajs.use('__APP_H_JS__/app', function( App ) {

        // 顶部幻灯片
        App.iScroll();
        // 顶部导航下拉
        App.headMenu();
        // 分享
        App.share();
    });
</script>
</body>
</html>