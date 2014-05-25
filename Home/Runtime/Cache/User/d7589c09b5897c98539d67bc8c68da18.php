<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="__CSS__/1210.css" />
    <link rel="stylesheet" href="__JS__/validform/css/validform.css" />
    <link rel="stylesheet" href="__CSS__/iframe.css" />
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
                'easyLayer.css': '__JS__/zxEasyLayer/Css/zxEasyLayer.css',
                'easyLayer': '__JS__/zxEasyLayer/Js/jquery.zxEasyLayer.js',
                'imageUpload': '__JS__/imageUpload.js'
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
            <span class="con_title font_yahei font_b">资料管理</span>
            <span class="con_title2 font_yahei">公众号管理</span>
        </div>

        <div class="con_body">
            <?php if( $obj ){ ?>
            <div class="con_msg c333 font_yahei">
                <div class="con_msg_item">您已绑定微信号：<strong class="red"><?php echo ($obj['wxnumber']); ?></strong>。如需修改，请联系管理员</div>
                <div class="con_msg_item">备注：复制接口配置信息。登陆公众帐号，进入高级功能 -> 开发模式 -> 填写相应的URL和Token进行验证。</div>
                <div class="con_msg_item">
                    URL：<?php echo C('WEB_URL').'/api.php?m=Interface&a=index&u='.$_SESSION['_User']['username']; ?>
                </div>
                <div class="con_msg_item">
                    Token：weixin
                </div>
            </div>
            <?php }else{ ?>
            <div class="con_msg font_yahei">
                <div class="con_msg_item red">请先绑定微信公众号！</div>
            </div>
            <?php } ?>
            <form action="<?php echo appUrl('m=User&a=comNum'); ?>" method="post" id="frm" name="frm">
                <input type="hidden" name="submit" value="1" />

                <table cellpadding="0" cellspacing="0" border="0">
                    <tbody>

                    <?php if( $obj ){ ?>
                    <tr>
                        <th scope="row" width="130px;">微信二维码：</th>
                        <td>
                            <!-- 图片上传 Start -->
                            <div><span id="imageBtn" class="uploadBtn">上传</span></div>
                            <div class="uploadImgWin">
                                <div class="uploadImgBox clearfix" id="uploadImgBox">
                                    <?php if($obj['erwm']){ ?>
                                    <div class="uploadImgGroup">
                                        <div class="uploadImgPic rect">
                                            <img src="<?php echo ($obj['erwm']); ?>" />
                                        </div>
                                        <div class="uploadImgOpe">
                                            <a href="javascript:;" class="uploadPullDown"></a>
                                            <div class="uploadMenu hidden">
                                                <ul>
                                                    <li><a href="javascript:;" class="uploadDel" data-src="<?php echo ($obj['erwm']); ?>" data-id="<?php echo ($obj['info_id']); ?>">删除</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <input type="hidden" name="erwm" value="<?php echo ($obj['erwm']); ?>" />
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <script id="myeditorImg"></script>
                            <script type="text/x-jquery-tmpl" id="uploadImgTmpl">
                                <div class="uploadImgGroup">
                                    <div class="uploadImgPic rect">
                                        <img src="{{= src}}" />
                                    </div>
                                    <div class="uploadImgOpe">
                                        <a href="javascript:;" class="uploadPullDown"></a>
                                        <div class="uploadMenu hidden">
                                            <ul>
                                                <li><a href="javascript:;" class="uploadDel" data-src="{{= src}}">删除</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <input type="hidden" name="erwm" value="{{= src}}" />
                                </div>
                            </script>
                            <!-- 图片上传 End -->
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">appId：</th>
                        <td>
                            <input name="appId" id="appId" value="<?php echo ($obj["appId"]); ?>" class="txt" datatype="*" nullmsg="请填写appId！" style="width:300px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">appSecret：</th>
                        <td>
                            <input name="appSecret" id="appSecret" value="<?php echo ($obj["appSecret"]); ?>" class="txt" datatype="*" nullmsg="请填写appSecret！" style="width:300px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">公司名称：</th>
                        <td>
                            <input name="company" id="company" value="<?php echo ($obj["company"]); ?>" class="txt" datatype="*" nullmsg="请填写公司名称！" style="width:200px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">手机号码：</th>
                        <td>
                            <input name="mobile" id="mobile" value="<?php echo ($obj["mobile"]); ?>" class="txt" datatype="*" nullmsg="请填写手机号码！" style="width:200px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">办公电话：</th>
                        <td>
                            <input name="tel" id="tel" value="<?php echo ($obj["tel"]); ?>" class="txt" datatype="*" nullmsg="请填写办公电话！" style="width:200px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">传真：</th>
                        <td>
                            <input name="fax" id="fax" value="<?php echo ($obj["fax"]); ?>" class="txt" datatype="*" nullmsg="请填写传真！" style="width:200px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">真实姓名：</th>
                        <td>
                            <input name="truename" id="truename" value="<?php echo ($obj["truename"]); ?>" class="txt" datatype="*" nullmsg="请填写真实姓名！" style="width:150px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">公司地址：</th>
                        <td>
                            <input name="address" id="address" value="<?php echo ($obj["address"]); ?>" class="txt" datatype="*" nullmsg="请填写公司地址！" style="width:400px;" />
                        </td>
                    </tr>
                    <?php }else{ ?>
                    <tr>
                        <th scope="row" width="130px;">微信号：</th>
                        <td>
                            <input name="wxnumber" id="wxnumber" class="txt" datatype="*" nullmsg="请填写微信号！" style="width:300px;" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" width="130px;">微信密码：</th>
                        <td>
                            <input type="password" name="wxpassword" id="wxpassword" class="txt" datatype="*" nullmsg="请填写微信密码！" style="width:300px;" />
                        </td>
                    </tr>
                    <?php } ?>
                    <tr class="no_line">
                        <th></th>
                        <td>
                            <?php if($obj){ ?>
                            <input type="hidden" name="info_id" id="info_id" value="<?php echo ($obj['info_id']); ?>" />
                            <?php } ?>
                            <button type="submit" class="uio_btn">保存</button>
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
<!--UEditor End-->

<script>
    seajs.use('__JS__/imageUpload', function( Image ){

        Image.upload({
            scriptId: 'myeditorImg',
            spanId: 'imageBtn',
            idName: 'info_id',
            tName: 'UserInfo',
            fName: 'erwm',
            id: "<?php echo $obj['info_id'] ?>"
        });
    });
</script>

    </div>
</div>
<script>
    seajs.use('__JS__/iframe', function( Iframe ) {

        window.page = Iframe.pageGo;
        window.localGo = Iframe.localGo;

        Iframe.validform();
        Iframe.multiSelect();
        Iframe.resetIframe();

    });
</script>
</body>
</html>