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
            <span class="con_title font_yahei font_b">用户管理</span>
            <span class="con_title2 font_yahei">列表</span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('UserManage/list'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                    <tr>
                        <td width="5%"><input type="checkbox" />UID</td>
                        <td width="10%">用户名</td>
                        <td width="10%">用户组</td>
                        <td width="10%">用户状态</td>
                        <td width="20%">注册时间</td>
                        <td width="20%">注册IP</td>
                        <td width="35%">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($userList)): $i = 0; $__LIST__ = $userList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                            <td><input type="checkbox" name="uid[<?php echo ($item["uid"]); ?>]" /><?php echo ($item["uid"]); ?></td>
                            <td><?php echo ($item["username"]); ?></td>
                            <td><?php echo ($item["group_name"]); ?></td>
                            <td><?php if($item['status']==1){ ?>正常<?php }else{ ?>禁用<?php } ?></td>
                            <td>
                                <?php if( $item['uid']==1 ){ ?>
                                <strong style="color:red;">远古时代</strong>
                                <?php }else{ ?>
                                <?php format_time($item['addtime']) ?>
                                <?php } ?>
                            </td>
                            <td><?php echo ($item["reg_ip"]); ?></td>
                            <td>
                                <a class="" href="<?php echo appUrl('UserManage/add'); ?>/uid/<?php echo ($item["uid"]); ?>">编辑</a>
                                <a class="" href="<?php echo appUrl('UserManage/userList/op/disabled'); ?>/uid/<?php echo ($item["uid"]); ?>"><?php if($item['status']==1){ ?>禁用<?php }else{ ?>启用<?php } ?></a>
                                <a class="" onclick="return cfirm();" href="<?php echo appUrl('UserManage/userList/op/del'); ?>/uid/<?php echo ($item["uid"]); ?>">删除</a>

                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                    <tbody>
                    <tr class="no_line">
                        <td colspan="6">
                            <div class="clearfix">
                                <button type="button" class="uio_btn" onclick="location.href='/Admin/UserManage/add/uid/<?php echo ($_GET[uid]); ?>'">添加</button>
                                <button type="submit" class="uio_btn">提交更改</button>
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

        Iframe.multiSelect();


    });
</script>
</body>
</html>