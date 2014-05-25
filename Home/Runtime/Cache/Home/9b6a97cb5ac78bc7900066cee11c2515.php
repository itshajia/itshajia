<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="__CSS__/1210.css" />
    <link rel="stylesheet" href="__CSS__/home.css" />
    <link rel="stylesheet" href="__JS__/validform/css/validform.css" />
    <script type="text/javascript" src="__JS__/common.js"></script>
    <script type="text/javascript" src="__JS__/sea.js"></script>
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
                'zxFadeSlider': '__JS__/zxFadeSlider/Js/jquery.zxFadeSlider',
                'zxFadeSlider.css': '__JS__/zxFadeSlider/Css/zxFadeSlider.css'
            }
        });
    </script>
</head>
<body>

<!-- Header Start -->
<div id="header" class="header">
    <div class="main">
        <div class="header_inner clearfix">
            <div class="logo"></div>

            <div id="nav" class="nav">
                <ul class="navGroup">
                    <li class="navItem on"><a href="javascript:;">首页</a></li>
                    <li class="navItem"><a href="javascript:;">产品介绍</a></li>
                    <li class="navItem"><a href="javascript:;">效果展示</a></li>
                    <li class="navItem"><a href="javascript:;">案例中心</a></li>
                    <li class="navItem"><a href="javascript:;">解决方案</a></li>
                    <li class="navItem"><a href="javascript:;">新闻动态</a></li>
                    <li class="navItem"><a href="javascript:;">联系我们</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>
<!-- Header End -->

<!-- 内容主体 Start -->

<!-- Banner Start -->
<div id="banner" class="banner">
    <div class="banner_inner" id="zxFadeSlider">
        <ul class="banner_group">
            <li class="banner_item zxFadeSliderItem" style="opacity: 1;">
                <a href="javascript:;" style="background-image: url(__IMG__/banner/banner1.jpg)"></a>
            </li>
            <li class="banner_item zxFadeSliderItem" style="opacity: 0;">
                <a href="javascript:;" style="background-image: url(__IMG__/banner/banner2.jpg)"></a>
            </li>
            <li class="banner_item zxFadeSliderItem" style="opacity: 0;">
                <a href="javascript:;" style="background-image: url(__IMG__/banner/banner3.jpg)"></a>
            </li>
            <li class="banner_item zxFadeSliderItem" style="opacity: 0;">
                <a href="javascript:;" style="background-image: url(__IMG__/banner/banner4.jpg)"></a>
            </li>
            <li class="banner_item zxFadeSliderItem" style="opacity: 0;">
                <a href="javascript:;" style="background-image: url(__IMG__/banner/banner5.jpg)"></a>
            </li>
        </ul>
    </div>
</div>
<!-- Banner End -->
<div class="main clearfix" style="margin-top: 35px;">

<!-- 新闻动态 Start -->
    <div class="news font_yahei">
        <div class="newsHead"><span class="newsTitle">新闻动态</span></div>
        <div class="newsBody">
            <ul class="newsGroup">
                <li class="newsItem"><a href="javascript:;">映盛中国小马哥场景互动2.0获最佳微信营微信营</a></li>
                <li class="newsItem"><a href="javascript:;">映盛中国小马哥场景互动2.0获最佳微信营</a></li>
                <li class="newsItem"><a href="javascript:;">映盛中国小马哥场景互动2.0获最佳微信营sd</a></li>
                <li class="newsItem"><a href="javascript:;">映盛中国小马哥场景互动2.0获最佳微信营</a></li>
                <li class="newsItem"><a href="javascript:;">映盛中国小马哥场景互动2.0获最佳微信营多少的</a></li>
                <li class="newsItem"><a href="javascript:;">映盛中国小马哥场景互动2.0获最佳微信营是滴是滴</a></li>
                <li class="newsItem"><a href="javascript:;">映盛中国小马哥场景互动2.0获最佳微信营是</a></li>
                <li class="newsItem"><a href="javascript:;">映盛中国小马哥场景互动2.0获最佳微信营</a></li>
            </ul>
        </div>
    </div>
<!-- 新闻动态 End -->

</div>
<!-- 内容主体 End -->



<!-- Footer Start -->
<div class="footer" id="footer">
    <div class="main">

        <div class="foot_group clearfix">
            <div class="foot_link">
                <a href="javascript:;">关于我们</a> |
                <a href="javascript:;">产品介绍</a> |
                <a href="javascript:;">合作渠道</a> |
                <a href="javascript:;">联系我们</a>
            </div>
        </div>

        <!-- 统计信息 Start -->
        <div class="foot_tongji">
            <span>联系地址：广陵区新城信息大道1号(扬州聲谷)11号楼A座2楼 ( 扬州 )</span>
            <span>联系电话：13852757093</span>
            <span>Copyright © UioWeb开发, All Rights Reserved. by IT沙加.</span>
            <span class="cznn">
                <!-- CNZZ 统计代码 Start -->
                <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1000369443'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s22.cnzz.com/z_stat.php%3Fid%3D1000369443%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>
                <!-- CNZZ 统计代码 End -->
            </span>

        </div>
        <!-- 统计信息 End -->


    </div>
</div>
<!-- Footer End -->

<script>
    seajs.use('__JS__/home', function( Home ) {

        // 首页幻灯片
        Home.fadeSlider();
    });
</script>
</body>
</html>