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
            <span class="con_title font_yahei font_b">基本设置</span>
            <span class="con_title2 font_yahei"></span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('Blog/basic'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <th scope="row" width="130px;">博客名称：</th>
                        <td width="">
                            <input name="blog_name" class="txt" id="blog_name" value="<?php echo ($obj["blog_name"]); ?>" style="width:350px;" datatype="*"  nullmsg="请填写站点名称！" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">微信二维码：</th>
                        <td>
                            <!-- 图片上传 Start -->
                            <div><span id="image" class="uploadBtn">上传</span></div>
                            <div class="uploadImgWin">
                                <div class="uploadImgBox clearfix" id="uploadImgBox">
                                    <?php if($obj['wx_ewm']){ ?>
                                    <div class="uploadImgGroup">
                                        <div class="uploadImgPic">
                                            <img src="<?php echo ($obj['wx_ewm']); ?>" />
                                        </div>
                                        <div class="uploadImgOpe">
                                            <a href="javascript:;" class="uploadDel" data-src="<?php echo ($obj['wx_ewm']); ?>">删除</a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <input type="hidden" id="uploadimg" name="wx_ewm" value="<?php echo ($obj['wx_ewm']); ?>"  />
                            <script id="myeditorimg"></script>
                            <script type="text/x-jquery-tmpl" id="uploadImgTmpl">
                                <div class="uploadImgGroup">
                                    <div class="uploadImgPic">
                                        <img src="{{= src}}" />
                                    </div>
                                    <div class="uploadImgOpe"><a href="javascript:;" class="uploadDel" data-src="{{= src}}">删除</a></div>
                                </div>
                            </script>
                            <!-- 图片上传 End -->
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">博客简介：</th>
                        <td class="textarea">
                            <textarea name="blog_info" id="myEditor" datatype="*" nullmsg="请填写站点简介！"><?php echo ($obj["blog_info"]); ?></textarea>
                        </td>
                    </tr>
                    <tr class="no_line">
                        <th></th>
                        <td>
                            <?php if($obj){ ?>
                            <input type="hidden" name="blog_id" id="blog_id" value="<?php echo ($obj['blog_id']); ?>" />
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
        toolbars:[['FullScreen','Source', 'Undo', 'Redo','Bold','forecolor','test','link','unlink','fontfamily','fontsize','justifyleft', 'justifycenter', 'justifyright', 'justifyjustify','insertcode','map','gmap','insertimage','insertvideo',,'preview','searchreplace','cleardoc','date','time','horizontal']],
        wordCount:false,
        elementPathEnabled:false,
        initialFrameWidth: 800,
        initialFrameHeight: 300
    });
</script>
<!--UEditor End-->

<script>
    seajs.use('__AP__/<?php echo (APP_NAME); ?>/Resource/Js/iframe', function( Iframe ) {

        Iframe.setDate('addtime');

    });
</script>
<script>
    seajs.use('__AP__/<?php echo (APP_NAME); ?>/Resource/Js/imageUpload');
</script>


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