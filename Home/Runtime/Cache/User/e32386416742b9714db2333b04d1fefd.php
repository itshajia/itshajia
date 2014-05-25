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
            <span class="con_title2 font_yahei">
                <?php if( $appType ){ ?>
                <?php echo ($appType['type_name']); ?>
                <?php }else{ ?>
                所有应用
                <?php } ?>
            </span>

            <span class="con_tool">
                <?php if(is_array($tools)): $i = 0; $__LIST__ = $tools;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tool): $mod = ($i % 2 );++$i;?><a href="<?php echo ($tool["url"]); ?>" <?php if($tool['tag']==$_GET['view']){ ?> class="active" <?php } ?>><?php echo ($tool["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
            </span>
        </div>

        <div class="con_body">

            <div class="module">
                <!-- 应用列表 Start -->
                <div class="app">
                    <div class="appBody">
                        <ul class="clearfix">
                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li class="appGroup font_yahei">
                                    <div class="appBg">
                                        <div class="appPicBox"><img src="<?php echo urlWithWebUrl($item['thumb']); ?>" /></div>
                                        <div class="appName"><?php echo ($item["app_name"]); ?></div>
                                    </div>
                                    <div class="appCover">
                                        <div class="appCoverTop">
                                            <a href="<?php echo ($item["url"]); ?>">查看</a>
                                        </div>
                                        <div class="appCoverBottom">
                                            <?php if( $item['is_apply'] ){ ?>
                                                <a href="<?php echo ($item["go"]); ?>">进入</a>
                                            <?php }else{ ?>
                                                <?php if( $item['is_check']===0){ ?>
                                                <a href="javascript:;">审核中</a>
                                                <?php }else{ ?>
                                                <a href="javascript:;">添加</a>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>

                        </ul>
                    </div>
                </div>
                <!-- 应用列表 End -->
                <?php echo ($pageHtml); ?>
            </div>



        </div>

    </div>
</div>
<!--内容主体 End-->

<script>
    seajs.use('<?php echo (APP_NAME); ?>/Resource/Js/effect', function( Effect ) {
        Effect.appEffect();
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