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
            <span class="con_title font_yahei font_b">应用管理</span>
            <span class="con_title2 font_yahei">新添加</span>

            <span class="con_tool">

            </span>
        </div>

        <div class="con_body">

            <?php if( $obj ) {?>
            <form action="<?php echo appUrl('m=Application&a=edit'); ?>" method="post" id="frm" name="frm">
            <?php }else{ ?>
            <form action="<?php echo appUrl('m=Application&a=add'); ?>" method="post" id="frm" name="frm">
            <?php } ?>
                <input type="hidden" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <th scope="row" width="130px;">应用名称：</th>
                        <td width="">
                            <input name="app_name" class="txt" id="app_name" value="<?php echo ($obj["app_name"]); ?>" datatype="*" nullmsg="请填写用户名称！" style="width:150px;" />
                        </td>
                    </tr>
                    <?php if( !$obj ){ ?>
                    <tr>
                        <th scope="row" width="130px;">应用选择：</th>
                        <td width="">
                            <select name="app_selected" id="app_selected" style="width:150px;" datatype="*" nullmsg="请选择用户组！">
                                <option value="">--请选择应用--</option>
                                <?php if(is_array($installApp)): $i = 0; $__LIST__ = $installApp;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option value="<?php echo ($item); ?>"><?php echo ($item); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if( $obj && $obj['is_fee'] ){ ?>
                    <tr>
                        <th scope="row" width="130px;">价格：</th>
                        <td>
                            <input name="price" class="txt" id="price" value="<?php echo ($obj["price"]); ?>" data-type="n" nullmsg="请填写价格！" style="width:150px;" /> / 年
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if( $obj ){ ?>
                    <tr>
                        <th scope="row" width="130px;">应用分类：</th>
                        <td>
                            <select name="type_id" id="type_id" style="width:150px;">
                                <option value="">--请选择分类--</option>
                                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option <?php if( $obj['type_id']==$item['type_id']){ ?> selected="selected" <?php } ?> value="<?php echo ($item["type_id"]); ?>"><?php echo ($item["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th scope="row" width="130px;">系统应用：</th>
                        <td>
                            <input type="checkbox" name="is_sys" <?php if($obj['is_sys']==1){ ?> checked="checked" <?php } ?> />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">默认启用：</th>
                        <td>
                            <input type="checkbox" name="status" <?php if(!$obj || $obj['status']==1){ ?> checked="checked" <?php } ?> />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">是否收费：</th>
                        <td>
                            <input type="checkbox" name="is_fee" <?php if($obj['is_fee']==1){ ?> checked="checked" <?php } ?> />
                        </td>
                    </tr>
                    <?php if( $obj ){ ?>
                    <tr>
                        <th scope="row" width="130px;">推荐应用：</th>
                        <td>
                            <input type="checkbox" name="is_top" <?php if($obj['is_top']==1){ ?> checked="checked" <?php } ?> />
                        </td>
                    </tr>
                    <?php } ?>
                    <tr class="no_line">
                        <th></th>
                        <td>
                            <?php if($obj){ ?>
                            <input type="hidden" name="app_id" id="app_id" value="<?php echo ($obj['app_id']); ?>" />
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