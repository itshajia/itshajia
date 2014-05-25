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
            <span class="con_title font_yahei font_b">Demo管理</span>
            <span class="con_title2 font_yahei">发布demo</span>
            <span class="fl_r"><?php if( $obj && $obj['linkurl'] ){ ?><a target="_blank" href="<?php echo ($obj['linkurl']); ?>">查看</a><?php } ?></span>
        </div>

        <div class="con_body">

            <form action="<?php echo appUrl('Product/demo/view/add'); ?>" method="post" id="frm" name="frm" enctype="multipart/form-data">
                <input type="hidden" name="submit" value="1" />
                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                    <tr>
                        <th scope="row" width="130px;">Demo标题：</th>
                        <td width="">
                            <input name="title" class="txt" id="title" value="<?php echo ($obj["title"]); ?>" style="width:350px;" datatype="*"  nullmsg="请填写Demo标题！" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">Demo上传：</th>
                        <td class="textarea">
                            <div id="fileContainer">

                                <!--FileUpload Tool Start-->
                                <div class="row fileupload-buttonbar">
                                    <div class="col-lg-7">
                                        <span class="btn btn-success fileinput-button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>上传</span>
                                            <input type="file"  id="fileupload" name="files[]">
                                        </span>
                                        <!--<button class="btn btn-warning cancel" type="reset">
                                            <i class="glyphicon glyphicon-ban-circle"></i>
                                            <span>取消</span>
                                        </button>
                                        <button class="btn btn-danger delete" type="button">
                                            <i class="glyphicon glyphicon-trash"></i>
                                            <span>删除</span>
                                        </button>-->
                                    </div>
                                    <div class="col-lg-5 fileupload-progress fade">

                                        <div aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress progress-striped active">
                                            <div style="width:0%;" class="progress-bar progress-bar-success"></div>
                                        </div>
                                        <div class="progress-extended">&nbsp;</div>
                                    </div>
                                </div>
                                <!--FileUpload Tool End-->

                                <!--FileUpload List Start-->
                                <table class="table table-striped" role="presentation">
                                <tbody class="files" id="files">

                                </tbody>
                                </table>
                                <!--FileUpload Tool End-->

                            </div>

                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">Demo分类：</th>
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
                            <input type="hidden" name="product_id" id="product_id" value="<?php echo ($obj['product_id']); ?>" />
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


<!--FileUpload Start-->
<script type="text/x-jquery-tmpl" id="uploadTmpl">
<tr class="template-upload fade in">
    <td>
        <input type="hidden" name="linkurl" value="{{= url}}" />
        <input type="hidden" name="dirname" value="{{= name}}" />
        <span class="preview"><canvas width="80" height="80"></canvas></span>
    </td>
    <td>
        <p class="name">{{= name}}</p>
    </td>
    <td>
        <p class="size">{{= size}}</p>
    </td>
    <td>
        <button type="button" data-name="{{= name}}"  class="btn btn-danger delete">
            <span>删除</span>
        </button>
    </td>
</tr>
</script>
<input type="hidden" id="uploadDemo" value="<?php echo appUrl('Ajax/demoUpload'); ?>" />
<script>

    var UploadObj = {
        multi: false,
        data: {
            name: "<?php echo $obj['dirname']; ?>",
            url: "<?php echo $obj['linkurl']; ?>"
        }
    };
    seajs.use('__AP__/<?php echo (APP_NAME); ?>/Resource/Js/fileupload', function() {

    });
</script>
<!--FileUpload End-->


<script>
    seajs.use('__AP__/<?php echo (APP_NAME); ?>/Resource/Js/iframe', function( Iframe ) {

        Iframe.setDate('addtime');

    });
</script>


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