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
            <span class="con_title font_yahei font_b">财务管理</span>
            <span class="con_title2 font_yahei">购买记录</span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('m=Application&a=appList'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" id="submit" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                    <tr>
                        <td width="5%"><input type="checkbox" class="checkbox" />ID</td>
                        <td width="15%">应用名称</td>
                        <td width="15%">客户账号</td>
                        <td width="20%">申请时间</td>
                        <td width="10%">年限</td>
                        <td width="10%">应收总价</td>
                        <td width="15%">代理商</td>
                        <td width="10%">状态</td>
                    </tr>
                    </thead>
                    <tbody class="">
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                            <td><input type="checkbox" class="checkbox" name="app_id[<?php echo ($item["app_id"]); ?>]" /><?php echo ($item["app_id"]); ?></td>
                            <td><a href="javascript:;" class=""><?php echo ($item["app_name"]); ?></a></td>
                            <td><?php echo ($item["username"]); ?></td>
                            <td><?php echo format_time($item['addtime']); ?></td>
                            <td><?php echo ($item["year"]); ?></td>
                            <td>
                                <?php if( $item['is_fee'] ){ ?>
                                <?php echo ($item['price']*5); ?>
                                <?php }else{ ?>
                                免费
                                <?php } ?>
                            </td>
                            <td>
                                <?php if( $item['agend_id'] ){ ?>
                                <strong class="green">有</strong>
                                <?php }else{ ?>
                                <strong class="red">无</strong>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if( $item['is_check'] ){ ?>
                                <strong class="green">已审核</strong>
                                <?php }else{ ?>
                                <strong class="red">未什么</strong>
                                <?php } ?>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                    <tbody>
                    <tr class="no_line">
                        <td colspan="6">
                            <div class="clearfix">
                                <button type="button" class="uio_btn" onclick="location.href='<?php echo appUrl('m=Application&a=buyCheck'); ?>'">添加</button>
                                <!--<button type="submit" class="uio_btn">提交更改</button>-->
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <!--表单工具栏 Start-->
                <div class="form_tool" id="form_tool">
                    <span class="tool_group">
                        <a href="javascript:;" class="sel_all">全选</a>/<a href="javascript:;" class="sel_cancel">取消</a>
                    </span>

                </div>
                <!--表单工具栏 End-->
            </form>
            <?php echo ($pageHtml); ?>
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