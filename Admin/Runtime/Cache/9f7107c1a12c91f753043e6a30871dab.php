<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="__JS__/validform/css/validform.css" />
    <link rel="stylesheet" href="<?php echo (APP_NAME); ?>/Resource/Css/iframe.css" />
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
            <span class="con_title font_yahei font_b">会员管理</span>
            <span class="con_title2 font_yahei">新添加</span>

            <span class="con_tool">
                <?php if(is_array($tools)): $i = 0; $__LIST__ = $tools;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tool): $mod = ($i % 2 );++$i;?><a href="<?php echo ($tool["url"]); ?>" <?php if($tool['tag']==$_GET['view']){ ?> class="active" <?php } ?>><?php echo ($tool["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>

            </span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('m=User&a=add'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <th scope="row" width="130px;">用户组：</th>
                        <td width="">
                            <select name="group_id" id="group_id" style="width:150px;" datatype="*" nullmsg="请选择用户组！">
                                <option value="">--请选择用户组--</option>
                                <?php if(is_array($groupList)): $i = 0; $__LIST__ = $groupList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option value="<?php echo ($item["group_id"]); ?>" <?php if($obj['group_id']==$item['group_id']){ ?> selected="selected"<?php } ?>><?php echo ($item["group_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">用户名称：</th>
                        <td width="">
                            <input name="username" class="txt" id="username" value="<?php echo ($obj["username"]); ?>" datatype="*" nullmsg="请填写用户名称！" style="width:150px;" />
                        </td>
                    </tr>
                    <?php if(!$obj){ ?>
                    <tr>
                        <th scope="row" width="130px;">用户密码：</th>
                        <td width="">
                            <input type="password" name="password" class="txt" id="password" value="<?php echo ($obj["password"]); ?>" datatype="*" nullmsg="请填写用户密码！" style="width:150px;" />
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th scope="row" width="130px;">Email：</th>
                        <td width="">
                            <input name="email" class="txt" id="email" value="<?php echo ($obj["email"]); ?>" datatype="*" nullmsg="请填写Email！" style="width:150px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">真实姓名：</th>
                        <td width="">
                            <input name="truename" class="txt" id="truename" value="<?php echo ($obj["truename"]); ?>" datatype="*" nullmsg="请填写真实姓名！" style="width:150px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">公司名称：</th>
                        <td width="">
                            <input name="company" class="txt" id="company" value="<?php echo ($obj["company"]); ?>" datatype="*" nullmsg="请填写公司名称！" style="width:150px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">微信号码：</th>
                        <td width="">
                            <input name="wxnumber" class="txt" id="wxnumber" value="<?php echo ($obj["wxnumber"]); ?>" datatype="*" nullmsg="请填写微信号！" style="width:150px;" />
                        </td>
                    </tr>
                    <tr class="no_line">
                        <th></th>
                        <td>
                            <?php if($obj){ ?>
                            <input type="hidden" name="uid" id="uid" value="<?php echo ($obj['uid']); ?>" />
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