<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="__CSS__/1210.css" />
    <link rel="stylesheet" href="__JS__/validform/css/validform.css" />
    <link rel="stylesheet" href="__CSS__/iframe.css" />
    <script type="text/javascript" src="__CSS__/common.js"></script>
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
                'upload.ui.css': '__JS__/fileUpload/css/jquery.fileupload-ui.css',
                'upload.ui.widget': '__JS__/fileUpload/js/vendor/jquery.ui.widget.js',
                'upload.iframe.transport': '__JS__/fileUpload/js/jquery.iframe-transport.js',
                'upload.fileupload': '__JS__/fileUpload/js/jquery.fileupload.js',
                'upload.xdr.transport': '__JS__/fileUpload/js/cors/jquery.xdr-transport.js'
            }
        });
    </script>
</head>
<body>

<div class="frame_box">
    <div class="frame_panel">



<!--内容主体 Start-->
<div class="container">
    <div class="panel">

        <div class="con_header">
            <span class="con_title font_yahei font_b">应用商店</span>
            <span class="con_title2 font_yahei">详情介绍</span>

            <span class="con_tool">
                <?php if(is_array($tools)): $i = 0; $__LIST__ = $tools;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tool): $mod = ($i % 2 );++$i;?><a href="<?php echo ($tool["url"]); ?>" <?php if($tool['tag']==$_GET['view']){ ?> class="active" <?php } ?>><?php echo ($tool["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
            </span>
        </div>

        <div class="con_body">

            <div class="module">
                <!-- 应用详情介绍 Start -->
                <div class="app">
                    <div class="appHead font_yahei clearfix">
                        <img class="appPic fl_l" src="<?php echo urlWithWebUrl($obj['thumb']); ?>" />
                        <div class="appInfoBox fl_l">
                            <div class="font_b appTitle"><?php echo ($obj["app_name"]); ?></div>
                            <p class="appIntro"><?php echo ($obj["introduce"]); ?></p>
                        </div>
                        <div class="buyBox fl_r">
                            <?php if( $obj['is_apply'] ){ ?>
                                <a href="javascript:;" class="buyNow" id="">进入应用</a>
                            <?php }else{ ?>
                                <?php if( $obj['is_check']===0 ){ ?>
                                <a href="javascript:;" class="buyed">审核中</a>
                                <?php }else{ ?>
                                    <a href="javascript:;" class="buyNow" id="buyNow">
                                        <?php if( $obj['is_fee'] ){ ?>
                                        立即申请
                                        <?php }else{ ?>
                                        立即添加
                                        <?php } ?>
                                    </a>
                                <?php } ?>
                            <?php } ?>

                            <a href="javascript:;" class=collect>添加收藏</a>
                        </div>

                    </div>
                    <div class="appBody">

                    </div>
                </div>
                <!-- 应用详情介绍 End -->
            </div>



        </div>

    </div>
</div>
<!--内容主体 End-->

<script>
    seajs.use('<?php echo (APP_NAME); ?>/Resource/Js/cart', function( Cart ) {
        Cart.buyNow("<?php echo $obj['app_id']; ?>");
    });
</script>

    </div>
</div>
<script>
    seajs.use('__JS__/iframe', function( Iframe ) {

        window.page = Iframe.pageGo;
        window.localGo = Iframe.localGo;

        Iframe.validform();
        Iframe.multiSelect();
        Iframe.resetIframe();

    });
</script>
</body>
</html>