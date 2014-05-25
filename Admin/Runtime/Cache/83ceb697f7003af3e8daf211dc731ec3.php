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
            <span class="con_title font_yahei font_b">系统组管理</span>
            <span class="con_title2 font_yahei">列表</span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('UserManage/customList'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                    <tr>
                        <td width="5%">编号</td>
                        <td width="10%">组名</td>
                        <td width="30%">更新时间</td>
                        <td width="35%">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($groupList)): $i = 0; $__LIST__ = $groupList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo ($item["group_id"]); ?></td>
                            <td><?php echo ($item["group_name"]); ?></td>
                            <td><?php format_time($item['uptime']) ?></td>
                            <td>
                                <a class="" href="<?php echo appUrl('UserManage/groupAdd'); ?>/group_id/<?php echo ($item["group_id"]); ?>">编辑</a>
                                <a class="" onclick="return cfirm();" href="<?php echo appUrl('UserManage/groupList/op/del'); ?>/group_id/<?php echo ($item["group_id"]); ?>">删除</a>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                    <tbody>
                    <tr class="no_line">
                        <td colspan="6">
                            <div class="clearfix">
                                <button type="button" class="" onclick="location.href='/Admin/UserManage/groupAdd/'">添加</button>
                                <button type="submit" class="">提交更改</button>
                            </div>
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