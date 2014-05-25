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
            <span class="con_title font_yahei font_b">用户组管理</span>
            <span class="con_title2 font_yahei">新添加</span>

            <span class="con_tool">
                <?php if(is_array($tools)): $i = 0; $__LIST__ = $tools;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tool): $mod = ($i % 2 );++$i;?><a href="<?php echo ($tool["url"]); ?>" <?php if($tool['tag']==$_GET['view']){ ?> class="active" <?php } ?>><?php echo ($tool["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>

            </span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('UserManage/groupAdd'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <th scope="row" width="130px;">组名：</th>
                        <td width="">
                            <input name="group_name" class="txt" id="group_name" value="<?php echo ($obj["group_name"]); ?>" style="width:150px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">权限：</th>
                        <td width="" class="lineh_25">
                            <?php if(is_array($leftMenu)): $i = 0; $__LIST__ = $leftMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><b><?php echo ($menu["menu_name"]); ?></b>
                                <br/>
                                <div style="border-bottom: 1px solid #e8e8e8;margin-bottom:5px;">
                                    <?php if(is_array($menu["sons"])): $j = 0; $__LIST__ = $menu["sons"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$son): $mod = ($j % 2 );++$j;?><dl>
                                            <dt><?php echo ($son["submenu_name"]); ?>：</dt>
                                            <dd>
                                                <ul>
                                                    <?php if(is_array($son["three_sons"])): $i = 0; $__LIST__ = $son["three_sons"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$three_son): $mod = ($i % 2 );++$i;?><label>
                                                            <input type="checkbox" name="group_rules[]" value="<?php echo ($three_son["resource_id"]); ?>" <?php if(in_array($three_son['resource_id'], $group_rules)){ ?> checked="checked" <?php } ?> />
                                                            <?php echo ($three_son["resource_name"]); ?>
                                                        </label><?php endforeach; endif; else: echo "" ;endif; ?>
                                                </ul>
                                            </dd>
                                        </dl><?php endforeach; endif; else: echo "" ;endif; ?>
                                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                        </td>
                    </tr>
                    <tr class="no_line">
                        <th></th>
                        <td>
                            <?php if($obj){ ?>
                            <input type="hidden" name="group_id" id="group_id" value="<?php echo ($obj['group_id']); ?>" />
                            <?php } ?>
                            <button type="submit" class="">提交</button>
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