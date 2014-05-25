<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="__CSS__/1210.css" />
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
            <span class="con_title font_yahei font_b">导航管理</span>
            <span class="con_title2 font_yahei"></span>

            <span class="con_tool">
                <?php if(is_array($tools)): $i = 0; $__LIST__ = $tools;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tool): $mod = ($i % 2 );++$i;?><a href="<?php echo appUrl($tool['url']); ?>" <?php if($tool['tag']==$_GET['view']){ ?> class="active" <?php } ?>><?php echo ($tool["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
            </span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('Blog/nav'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />
                <?php if( $_GET['position'] ){ ?>
                <input type="hidden" name="position" value="<?php echo $_GET['position']; ?>" />
                <?php } ?>
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                    <tr>
                        <td width="5%"><input type="checkbox" class="checkbox" />ID</td>
                        <td width="10%">序号</td>
                        <td width="20%">导航</td>
                        <td width="15%">状态</td>
                        <td width="40%">地址</td>
                        <td width="10">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                            <td><input type="checkbox" class="checkbox" name="nav_id[<?php echo ($item["nav_id"]); ?>]" /><?php echo ($item["nav_id"]); ?></td>
                            <td><input type="text" class="txt" size="12" name="nav[<?php echo ($item["nav_id"]); ?>][listorder]" value="<?php echo ($item["listorder"]); ?>" /></td>
                            <td><?php echo ($item["nav_name"]); ?></td>
                            <td>
                                <?php if( $item['is_show'] ==1){ ?>
                                <strong style="color: green;">显示</strong>
                                <?php }else{ ?>
                                <strong style="color: red;">隐藏</strong>
                                <?php } ?>
                            </td>
                            <td><?php echo ($item["linkurl"]); ?></td>
                            <td>
                                <?php if( $_GET['position']){ ?>
                                <a class="" href="<?php echo appUrl('Blog/nav/view/custom'); ?>/nav_id/<?php echo ($item["nav_id"]); ?>/position/<?php echo $_GET['position']; ?>">编辑</a>
                                <a class="" onclick="return cfirm();" href="<?php echo appUrl('Blog/nav/view/del'); ?>/nav_id/<?php echo ($item["nav_id"]); ?>/position/<?php echo $_GET['position']; ?>"></span>删除</a>
                                <?php }else{ ?>
                                <a class="" href="<?php echo appUrl('Blog/nav/view/custom'); ?>/nav_id/<?php echo ($item["nav_id"]); ?>">编辑</a>
                                <a class="" onclick="return cfirm();" href="<?php echo appUrl('Blog/nav/view/del'); ?>/nav_id/<?php echo ($item["nav_id"]); ?>"></span>删除</a>
                                <?php } ?>

                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                    <tbody>
                    <tr class="no_line">
                        <td colspan="6">
                            <div class="clearfix">
                                <button type="submit" class="uio_btn">提交更改</button>
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
                    <span class="tool_group">
                        选中项：<button name="tool" onclick="return cfirm();" value="delAll">删除</button>
                    </span>

                </div>
                <!--表单工具栏 End-->

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

        window.localGo = Iframe.localGo;

        Iframe.validform();

        Iframe.multiSelect();


    });
</script>
</body>
</html>