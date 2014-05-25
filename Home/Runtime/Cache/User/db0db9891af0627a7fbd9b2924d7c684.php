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
            <span class="con_title font_yahei font_b">消息回复</span>
            <span class="con_title2 font_yahei">回复设置</span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('m=User&a=replySet'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />

                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <th scope="row" width="130px;">关注欢迎词设置：</th>
                        <td>
                            <select name="subscribe_id" id="subscribe_id" style="width:150px;">
                                <option value="">--请选择回复内容--</option>
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option <?php if( $replyMsg['subscribe_id']==$item['reply_id'] ){ ?> selected="selected" <?php } ?> value="<?php echo ($item["reply_id"]); ?>"><?php echo ($item["keyword"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">无匹配消息设置：</th>
                        <td>
                            <select name="nomsg_id" id="nomsg_id" style="width:150px;">
                                <option value="">--请选择回复内容--</option>
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option <?php if( $replyMsg['nomsg_id']==$item['reply_id'] ){ ?> selected="selected" <?php } ?> value="<?php echo ($item["reply_id"]); ?>"><?php echo ($item["keyword"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr class="no_line">
                        <td colspan="6">
                            <?php if($replyMsg){ ?>
                            <input type="hidden" name="msg_id" id="msg_id" value="<?php echo ($replyMsg['msg_id']); ?>" />
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