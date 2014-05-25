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
                'easyLayer.css': '__JS__/zxEasyLayer/Css/zxEasyLayer.css',
                'easyLayer': '__JS__/zxEasyLayer/Js/jquery.zxEasyLayer.js',
                'imageUpload': '__JS__/imageUpload.js'
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
            <span class="con_title font_yahei font_b">自定义菜单</span>
            <span class="con_title2 font_yahei">授权设置</span>
        </div>

        <div class="con_body">

            <div class="con_msg c333 font_yahei">
                <div class="con_msg_item">使用本模块，必须要在微信公众平台"开发模式"下使用自定义菜单，首先要在公众平台申请自定义菜单使用的<strong class="red">AppId</strong>和<strong class="red">AppSecret</strong>。</div>
            </div>
            <form action="<?php echo appUrl('m=User&a=menuAuth'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />

                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <th scope="row" width="130px;">应用ID：</th>
                        <td>
                            <input name="appId" id="appId" value="<?php echo ($obj["appId"]); ?>" class="txt" datatype="*" nullmsg="请填写应用Id！" style="width:300px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">应用密钥：</th>
                        <td>
                            <input name="appSecret" id="appSecret" value="<?php echo ($obj["appSecret"]); ?>" class="txt" datatype="*" nullmsg="请填写应用密钥！" style="width:300px;" />
                        </td>
                    </tr>
                    <tr class="no_line">
                        <th></th>
                        <td>
                            <?php if($obj){ ?>
                            <input type="hidden" name="info_id" id="info_id" value="<?php echo ($obj['info_id']); ?>" />
                            <?php } ?>
                            <button type="submit" class="uio_btn">保存</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>

        </div>

    </div>
</div>
<!--内容主体 End-->


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