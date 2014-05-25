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



<!-- 内容主题 Start -->
<div class="container">

    <!-- 头部幻灯片 Start -->
    <div class="main clearfix">
        <div class="banner">
            <div id="wrapper">
                <div id="scroller">
                    <ul id="thelist">
                        <?php if( $banner ){ ?>
                        <?php  foreach($banner as $k=>$v){ ?>
                        <li><p></p><a href="javascript:void(0)"><img src="<?php echo $v?>" /></a></li>
                        <?php } ?>
                        <?php }else{ ?>

                        <li style="display:block;"><img  src="<?php echo C('WEB_URL'); ?>/App/Weizhan/images/1.jpg" /></li>
                        <li><img  src="<?php echo C('WEB_URL'); ?>/App/Weizhan/images/2.jpg" /></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div id="nav">
                <div id="prev" onclick="myScroll.scrollToPage('prev', 0,400,3);return false">&larr; prev</div>
                <ul id="indicator">
                    <?php if($banner){ ?>
                    <?php  foreach($banner as $k=>$v){ $j = $k+1;?>
                    <li   <?php if($j==1) echo 'class="active"'; ?>  ><?php echo $j; ?></li>
                    <?php } ?>
                    <?php }else{ ?>
                    <li class="active" >1</li>
                    <li class="">2</li>
                    <?php } ?>

                </ul>
                <div id="next" onclick="myScroll.scrollToPage('next', 0);return false">next &rarr;</div>
            </div>
            <div class="clr"></div>
        </div>
    </div>
    <!-- 头部幻灯片 End -->


    <!-- 首页栏目 Start -->
    <div class="column clearfix">

        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><a href="<?php echo ($item["linkurl"]); ?>">
                <div class="column_group font_yahei">
                    <div class="column_group_inner">
                        <div class="column_icon">
                            <span class="icon_font <?php echo ($item["css_icon"]); ?>"></span>
                        </div>
                        <div class="column_title">
                            <span><?php echo ($item["column_name"]); ?></span>
                        </div>
                    </div>
                </div>
            </a><?php endforeach; endif; else: echo "" ;endif; ?>

    </div>
    <!-- 首页栏目 End -->


</div>




<!-- 内容主题 End -->


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