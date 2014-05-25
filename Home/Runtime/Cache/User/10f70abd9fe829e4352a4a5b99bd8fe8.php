<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="__CSS__/1210.css" />
    <link rel="stylesheet" href="__JS__/validform/css/validform.css" />
    <link rel="stylesheet" href="<?php echo (APP_NAME); ?>/Resource/Css/iframe.css" />
    <script type="text/javascript" src="<?php echo (APP_NAME); ?>/Resource/Js/common.js"></script>
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
            <span class="con_title font_yahei font_b">WELCOME,欢迎来到用户中心！</span>
            <span class="con_title2 font_yahei"></span>
        </div>

        <div class="con_body">

            <div class="module">
                <!-- 热门应用 Start -->
                <div class="hotApp g800 fl_l">
                    <div class="hotHead">
                        <span class="font_yahei font_b">热门应用</span>
                    </div>
                    <div class="hotBody">
                        <ul class="clearfix">
                            <?php if(is_array($hotAppList)): $i = 0; $__LIST__ = $hotAppList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li class="appGroup font_yahei">
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
                                                <?php if( $item['is_check']===0 ){ ?>
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
                <!-- 热门应用 End -->

                <!-- 平台公告 Start -->
                <div class="module_right fl_l font_yahei">
                    <div class="appInfo">
                        <div class="infoItem"><?php echo $_SESSION['_User']['username']; ?>，您好！</div>
                        <div class="infoItem">已添加10个应用。</div>
                        <div class="infoItem"><a class="btn" href="<?php echo appUrl('m=App&a=my'); ?>">查看我的应用</a></div>
                    </div>
                    <div class="announce">
                        <div class="announceHead">
                            <span class="font_b">平台公告</span>
                        </div>
                        <div class="announceBody">
                            <ul>
                                <?php if(is_array($announceList)): $i = 0; $__LIST__ = $announceList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li class="announceItem">
                                        <a href="javascript:;" title="<?php echo ($item["title"]); ?>"><?php echo cut_str($item['title'], 13); ?></a>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </div>
                    </div>

                </div>
                <!-- 平台公告 End -->

            </div>

            <div class="module">
                <!-- 数据曲线图 Start -->
                <!-- 数据曲线图 End -->
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
    seajs.use('<?php echo (APP_NAME); ?>/Resource/Js/iframe', function( Iframe ) {

        window.page = Iframe.pageGo;
        window.localGo = Iframe.localGo;

        Iframe.validform();
        Iframe.multiSelect();
        Iframe.resetIframe();

    });
</script>
</body>
</html>