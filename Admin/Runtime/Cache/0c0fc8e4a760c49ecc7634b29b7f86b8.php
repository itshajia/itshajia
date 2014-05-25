<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="__JS__/validform/css/validform.css" />
    <link rel="stylesheet" href="__AP__/<?php echo (APP_NAME); ?>/Resource/Css/iframe.css" />
    <script type="text/javascript" src="__AP__/<?php echo (APP_NAME); ?>/Resource/Js/common.js"></script>
    <script type="text/javascript" src="__JS__/sea.js"></script>
    <script type="text/javascript">
        var zxPath = "";
        var basePath = "";
        seajs.config({
            base:zxPath,
            alias: {
                'jquery': '__JS__/jquery.js',
                'validform': '__JS__/validform/validform.js'
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
            <span class="con_title font_yahei font_b">文章模块管理</span>
            <span class="con_title2 font_yahei">新添加</span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('Develop/article/view/module/op/add'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <th scope="row" width="130px;">文章模块名称：</th>
                        <td width="">
                            <input name="module_name" class="txt" id="module_name" value="<?php echo ($obj["module_name"]); ?>" style="width:150px;" datatype="*" nullmsg="请填写模块名称！" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">文章模块Tag：</th>
                        <td width="">
                            <input name="module_ename" class="txt" id="module_ename" datatype="*" nullmsg="请填写文章模块Tag！" value="<?php echo ($obj["module_ename"]); ?>" style="width:150px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">排序：</th>
                        <td width="">
                            <input name="listorder" class="txt" id="listorder" value="<?php echo ($obj["listorder"]); ?>" style="width:150px;" />
                        </td>
                    </tr>
                    <tr class="no_line">
                        <th></th>
                        <td>
                            <?php if($obj){ ?>
                            <input type="hidden" name="module_id" id="module_id" value="<?php echo ($obj['module_id']); ?>" />
                            <?php } ?>
                            <button type="submit" class="button">提交</button>
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
    seajs.use('__AP__/<?php echo (APP_NAME); ?>/Resource/Js/iframe', function( Iframe ) {

        window.page = Iframe.pageGo;

        Iframe.validform();

    });
</script>
</body>
</html>