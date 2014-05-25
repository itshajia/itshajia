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
            <span class="con_title font_yahei font_b">日志管理</span>
            <span class="con_title2 font_yahei">列表</span>

            <!-- 搜索工具栏 Start -->
            <span class="fl_r con_search font_yahei">
                <form action="<?php echo appUrl('Blog/note'); ?>">
                    <input type="hidden" name="submit" value="search" />
                    分类：
                    <select name="catid" id="catid" style="width:150px;">
                        <?php if(is_array($cateList)): $i = 0; $__LIST__ = $cateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option value="<?php echo ($item["catid"]); ?>" <?php if($searchCatid==$item['catid']){ ?> selected="selected"<?php } ?>><?php echo ($item["catname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <button type="submit" class="uio_btn">搜索</button>
                </form>
            </span>
            <!-- 搜索工具栏 End -->

        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('Blog/note'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" id="submit" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                    <tr>
                        <td width="5%"><input type="checkbox" class="checkbox" />ID</td>
                        <td width="30%">标题</td>
                        <td width="10%">作者</td>
                        <td width="15%">分类</td>
                        <td width="14%">时间</td>
                        <td width="8%">评论</td>
                        <td width="8%">阅读</td>
                        <td width="10">操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                            <td><input type="checkbox" class="checkbox" name="article_id[<?php echo ($item["article_id"]); ?>]" /><?php echo ($item["article_id"]); ?></td>
                            <td class="no_lineH"><a href="javascript:;" class=""><?php echo ($item["title"]); ?></a></td>
                            <td><?php echo ($item["username"]); ?></td>
                            <td class="no_lineH"><?php echo ($item["catname"]); ?> -
                                <?php if($item['is_sys']==1){ ?>
                                <strong style="color:red;font-size:12px;">系统分类</strong>
                                <?php }else{ ?>
                                <strong style="color:green;font-size:12px;">自定义分类</strong>
                                <?php } ?>
                            </td>
                            <td><?php echo format_time($item['addtime']); ?></td>
                            <td><?php echo ($item["comment"]); ?></td>
                            <td><?php echo ($item["views"]); ?></td>
                            <td>
                                <a class="" href="<?php echo appUrl('Blog/note/view/add'); ?>/article_id/<?php echo ($item["article_id"]); ?>">编辑</a>
                                <a class="" onclick="return cfirm();" href="<?php echo appUrl('Blog/note/view/del'); ?>/article_id/<?php echo ($item["article_id"]); ?>"></span>删除</a>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                    <tbody>
                    <tr class="no_line">
                        <td colspan="6">
                            <div class="clearfix">
                                <button type="button" class="uio_btn" href="<?php echo appUrl('Blog/note/view/add'); ?>" onclick="localGo(this);">添加</button>
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

        window.localGo = Iframe.localGo;

        Iframe.validform();

        Iframe.multiSelect();


    });
</script>
</body>
</html>