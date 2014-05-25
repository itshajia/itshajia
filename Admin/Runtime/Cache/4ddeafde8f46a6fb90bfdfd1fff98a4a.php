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
            <span class="con_title2 font_yahei">写文章</span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('m=Article&a=note&view=add'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <th scope="row" width="130px;">日志标题：</th>
                        <td width="">
                            <input name="title" class="txt" id="title" value="<?php echo ($obj["title"]); ?>" style="width:350px;" datatype="*"  nullmsg="请填写日志标题！" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">日志正文：</th>
                        <td class="textarea">
                            <textarea name="description" id="myEditor" datatype="*" nullmsg="请填写日志正文内容！"><?php echo ($obj["description"]); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">文章分类：</th>
                        <td>
                            <select name="catid" id="catid" style="width:150px;">
                                <?php if(is_array($cateList)): $i = 0; $__LIST__ = $cateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option value="<?php echo ($item["catid"]); ?>" <?php if($obj['catid']==$item['catid']){ ?> selected="selected"<?php } ?>><?php echo ($item["catname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">发表时间：</th>
                        <td>
                            <input name="addtime" class="txt" id="addtime" value="<?php echo format_time($obj.addtime); ?>" style="width:150px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">是否公开：</th>
                        <td>
                            <input type="checkbox" name="is_public" id="is_public" <?php if($obj['is_public']==1) { ?> checked="checked" <?php } ?>  />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">排序：</th>
                        <td width="">
                            <input name="listorder" class="txt" id="listorder" value="<?php echo ($obj["listorder"]); ?>" style="width:150px;" />
                        </td>
                    </tr>
                    <tr class="no_line">
                        <th></th>
                        <td>
                            <?php if($obj){ ?>
                            <input type="hidden" name="article_id" id="article_id" value="<?php echo ($obj['article_id']); ?>" />
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

<!--UEditor Start-->
<script type="text/javascript" src="__JS__/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="__JS__/ueditor/ueditor.all.js"></script>
<script type="text/javascript" charset="utf-8" src="__JS__/ueditor/lang/zh-cn/zh-cn.js"></script>
<script style="text/javascript">
    UE.getEditor("myEditor", {
        toolbars:[['FullScreen','Source', 'Undo', 'Redo','Bold','forecolor','test','link','unlink','fontfamily','fontsize','justifyleft', 'justifycenter', 'justifyright', 'justifyjustify','map','gmap','insertimage','insertvideo','music','preview','searchreplace','cleardoc','date','time','horizontal']],
        wordCount:false,
        elementPathEnabled:false,
        initialFrameWidth: 800,
        initialFrameHeight: 300
    });
</script>
<!--UEditor End-->

<script>
    seajs.use('<?php echo (APP_NAME); ?>/Resource/Js/iframe', function( Iframe ) {

        Iframe.setDate('addtime');

    });
</script>


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