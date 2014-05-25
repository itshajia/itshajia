<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
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
            <span class="con_title font_yahei font_b">菜单管理</span>
            <span class="con_title2 font_yahei">新添加</span>

            <span class="con_tool">
                <?php if(is_array($tools)): $i = 0; $__LIST__ = $tools;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tool): $mod = ($i % 2 );++$i;?><a href="<?php echo ($tool["url"]); ?>" <?php if($tool['tag']==$_GET['view']){ ?> class="active" <?php } ?>><?php echo ($tool["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>

            </span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('m=Develop&a=menu&view=resource&op=add'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <th scope="row" width="130px;">父级菜单：</th>
                        <td width="">
                            <?php if($pObj && !$_GET['isSelect']){ ?>
                            <?php echo ($pObj['submenu_name']); ?>
                            <input type="hidden" name="submenu_id" value="<?php echo ($pObj['submenu_id']); ?>" />
                            <?php } else { ?>
                            <select name="submenu_id" id="submenu_id" style="width:160px;" datatype="*" nullmsg="请选择父级菜单！">
                                <option value="">--请选择父级菜单--</option>
                                <?php if(is_array($subList)): $i = 0; $__LIST__ = $subList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><option value="<?php echo ($menu["submenu_id"]); ?>" <?php if($menu['submenu_id']==$obj['submenu_id']){ ?> selected="selected"<?php } ?>><?php echo ($menu["submenu_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                            <?php } ?>

                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">菜单项名称：</th>
                        <td width="">
                            <input name="resource_name" class="txt" id="resource_name" value="<?php echo ($obj["resource_name"]); ?>" datatype="*" nullmsg="请填写菜单项名称！" style="width:150px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">菜单项Module：</th>
                        <td width="">
                            <input name="mod" class="txt" id="m" value="<?php echo ($obj["mod"]); ?>" datatype="*" nullmsg="请填写菜单项Module！" style="width:150px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">菜单项Action：</th>
                        <td width="">
                            <input name="act" class="txt" id="a" value="<?php echo ($obj["act"]); ?>" datatype="*" nullmsg="请填写菜单项Action！" style="width:150px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">菜单项URL：</th>
                        <td width="">
                            <input name="resource_url" class="txt" id="resource_url" datatype="*" nullmsg="请填写菜单项URL！" value="<?php echo ($obj["resource_url"]); ?>" style="width:300px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">排序：</th>
                        <td width="">
                            <input name="listorder" class="txt" id="listorder" value="<?php echo ($obj["listorder"]); ?>" style="width:150px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">是否显示：</th>
                        <td>
                            <input type="checkbox" name="status" <?php if($obj['status']==1){ ?> checked="checked" <?php } ?> />
                        </td>
                    </tr>
                    <tr class="no_line">
                        <th></th>
                        <td>
                            <?php if($obj){ ?>
                            <input type="hidden" name="resource_id" id="resource_id" value="<?php echo ($obj['resource_id']); ?>" />
                            <?php } ?>
                            <button type="submit" class="uio_btn">提交</button>
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
    seajs.use('<?php echo (APP_NAME); ?>/Resource/Js/iframe', function( Iframe ) {

        window.page = Iframe.pageGo;

        Iframe.validform();

        Iframe.multiSelect();


    });
</script>
</body>
</html>