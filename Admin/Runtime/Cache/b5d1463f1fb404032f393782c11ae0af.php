<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="__AP__/<?php echo (APP_NAME); ?>/Resource/Css/iframe.css" />
    <script type="text/javascript" src="__AP__/<?php echo (APP_NAME); ?>/Resource/Js/common.js"></script>
    <script type="text/javascript" src="__JS__/sea.js"></script>
    <script type="text/javascript">
        var zxPath = "";
        var basePath = "";
        seajs.config({
            base:zxPath,
            alias: {
                'jquery': '__JS__/jquery.js'
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
            <span class="con_title font_yahei font_b">菜单管理</span>
            <span class="con_title2 font_yahei">列表</span>

            <span class="con_tool">
                <?php if(is_array($tools)): $i = 0; $__LIST__ = $tools;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tool): $mod = ($i % 2 );++$i;?><a href="<?php echo ($tool["url"]); ?>" <?php if($tool['tag']==$_GET['view']){ ?> class="active" <?php } ?>><?php echo ($tool["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>

            </span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('Develop/menu/view/resource'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />
                <input type="hidden" name="submenu_id" value="<?php echo ($_GET['submenu_id']); ?>" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                    <tr>
                        <td width="5%">父排序</td>
                        <td width="10%">排序</td>
                        <td width="10%">菜单项名称</td>
                        <td width="10%">Module</td>
                        <td width="10%">Action</td>
                        <td width="20%">Url</td>
                        <td width="10%">父菜单名称</td>
                        <td width="10%">是否显示</td>
                        <td width="15%">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($resourceList)): $i = 0; $__LIST__ = $resourceList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo ($menu["plistorder"]); ?></td>
                            <td><input type="text" class="txt" size="12" name="resource[<?php echo ($menu["resource_id"]); ?>][listorder]" value="<?php echo ($menu["listorder"]); ?>" /></td>
                            <td><?php echo ($menu["resource_name"]); ?></td>
                            <td><input type="text" class="txt" name="resource[<?php echo ($menu["resource_id"]); ?>][mod]" value="<?php echo ($menu["mod"]); ?>" style="width:90%;" /></td>
                            <td><input type="text" class="txt" name="resource[<?php echo ($menu["resource_id"]); ?>][act]" value="<?php echo ($menu["act"]); ?>" style="width:90%;" /></td>
                            <td><input type="text" class="txt" name="resource[<?php echo ($menu["resource_id"]); ?>][resource_url]" value="<?php echo ($menu["resource_url"]); ?>" style="width:90%;" /></td>
                            <td><?php echo ($menu["submenu_name"]); ?></td>
                            <td><?php if($menu['status']==1){ ?>显示<?php }else{ ?>隐藏<?php } ?></td>
                            <td>
                                <a class="" href="<?php echo appUrl('Develop/menu/view/resource/op/add'); ?>/resource_id/<?php echo ($menu["resource_id"]); ?>/submenu_id/<?php echo ($_GET['submenu_id']); ?>/isSelect/1">编辑</a>
                                <a class="" onclick="return cfirm();" href="<?php echo appUrl('Develop/menu/view/resource/op/del'); ?>/resource_id/<?php echo ($menu["resource_id"]); ?>/submenu_id/<?php echo ($_GET['submenu_id']); ?>">删除</a>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                    <tbody>
                    <tr class="no_line">
                        <td colspan="6">
                            <div class="clearfix">
                                <button type="button" class="" onclick="location.href='/Admin/Develop/menu/view/resource/op/add/submenu_id/<?php echo ($_GET[submenu_id]); ?>'">添加</button>
                                <button type="submit" class="">保存</button>
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
    seajs.use('__AP__/<?php echo (APP_NAME); ?>/Resource/Js/iframe');
</script>
</body>
</html>