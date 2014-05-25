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
            <span class="con_title2 font_yahei">列表</span>

            <span class="con_tool">
                <?php if(is_array($tools)): $i = 0; $__LIST__ = $tools;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tool): $mod = ($i % 2 );++$i;?><a href="<?php echo ($tool["url"]); ?>" <?php if($tool['tag']==$_GET['view']){ ?> class="active" <?php } ?>><?php echo ($tool["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
            </span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('Develop/menu/view/nav'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                    <tr>
                        <td width="10%">排序</td>
                        <td width="30%">菜单名称</td>
                        <td width="30%">菜单Tag</td>
                        <td width="10%">是否显示</td>
                        <td width="20%">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($menuListO)): $i = 0; $__LIST__ = $menuListO;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><tr>
                            <td><input type="text" class="txt" size="12" name="menu[<?php echo ($menu["menu_id"]); ?>][listorder]" value="<?php echo ($menu["listorder"]); ?>" /></td>
                            <td><?php echo ($menu["menu_name"]); ?></td>
                            <td><?php echo ($menu["menu_ename"]); ?></td>
                            <td><?php if($menu['status']==1){ ?>显示<?php }else{ ?>隐藏<?php } ?></td>
                            <td>
                                <a class="" href="<?php echo appUrl('Develop/menu/view/nav/op/add'); ?>/menu_id/<?php echo ($menu["menu_id"]); ?>">编辑</a>
                                <a class="" onclick="return cfirm();" href="<?php echo appUrl('Develop/menu/view/nav/op/del'); ?>/menu_id/<?php echo ($menu["menu_id"]); ?>">删除</a>
                                <a class="" href="<?php echo appUrl('Develop/menu/view/sub'); ?>/menu_id/<?php echo ($menu["menu_id"]); ?>">子菜单</a>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                    <tbody>
                    <tr class="no_line">
                        <td colspan="6">
                            <div class="clearfix">
                                <button type="button" class="uio_btn" onclick="location.href='/Admin/Develop/menu/view/nav/op/add'">添加</button>
                                <button type="submit" class="uio_btn">保存</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </form>

            <?php echo ($pageHtml); ?>
            <input type="hidden" id="urlnopage" value="<?php echo getUrlNoPage(); ?>" />
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

        Iframe.multiSelect();


    });
</script>
</body>
</html>