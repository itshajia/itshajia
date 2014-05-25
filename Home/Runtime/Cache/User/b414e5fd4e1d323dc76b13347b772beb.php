<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="<?php echo (APP_NAME); ?>/Resource/Css/login.css" />
    <script type="text/javascript" src="__JS__/sea.js"></script>
    <script type="text/javascript">
        var zxPath = "";
        seajs.config({
            base:zxPath,
            alias: {
                'jquery': '__JS__/jquery.js',
                'uio': '__JS__/jquery.uio.js',
                'tmpl': '__JS__/jquery.tmpl.js',
                'validform': '__JS__/validform/validform.js',
                'json': '__JS__/jquery.json.js'
            }
        });
    </script>
</head>
<body>
<div class="login">
    <!--Header Start-->
    <div class="header">

    </div>
    <!--Header End-->

    <!--Banner Start-->
    <div class="banner">

        <!--Sign Start-->
        <div class="sign">

            <!--登录 Start-->
            <div class="signup <?php if( $reg==1 ){ ?> hidden <?php } ?>" id="signup">
                <div class="signgroup">
                    <div class=signhead>
                        <div class="pad10">
                            <a href="javascript:;" class="cur">登录</a>
                            <a href="javascript:;" class="next js-next">注册账号</a>
                        </div>
                    </div>
                    <div class="signbody">
                        <div class="pad10">
                            <form method="post" action="<?php echo appUrl('m=Index&a=login_do'); ?>">
                                <?php if( $reg!=1 ){ ?>
                                <div class="signMsg"><?php echo ($error); ?></div>
                                <?php } ?>
                                <div class="signitem">
                                    <input class="txt1" name="username" placeholder="用户名" style="width: 210px;" />
                                </div>
                                <div class="signitem">
                                    <input type="password" class="txt1" name="password" placeholder="密码" style="width: 210px;" />
                                </div>
                                <div class="signitem">
                                    <button type="submit" class="btn font_b">我要登录</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!--注册 Start-->
            <div class="signin <?php if( $reg!=1 ){ ?> hidden <?php } ?>" id="signin">
                <div class="signgroup">
                    <div class=signhead>
                        <div class="pad10">
                            <a href="javascript:;" class="cur">注册账号</a>
                            <a href="javascript:;" class="next js-next">登录</a>
                        </div>
                    </div>
                    <div class="signbody">
                        <div class="pad10">
                            <form method="post" action="<?php echo appUrl('m=Index&a=register_do'); ?>">
                                <?php if( $reg==1 ){ ?>
                                <div class="signMsg"><?php echo ($error); ?></div>
                                <?php } ?>
                                <div class="signitem">
                                    <input class="txt1" name="username" placeholder="用户名" style="width: 210px;" />
                                </div>
                                <div class="signitem">
                                    <input class="txt1" name="email" placeholder="邮箱" style="width: 210px;" />
                                </div>
                                <div class="signitem">
                                    <input type="password" class="txt1" name="password" placeholder="密码" style="width: 210px;" />
                                </div>
                                <div class="signitem">
                                    <input type="password" class="txt1" name="repassword" placeholder="确认密码" style="width: 210px;" />
                                </div>
                                <div class="signitem">
                                    <button type="submit" class="btn font_b">我要注册</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!--Sign End-->

    </div>
    <!--Banner End-->

    <!--Bodyer Start-->
    <div class="bodyer">

    </div>
    <!--Bodyer End-->

    <!--Footer Start-->
    <div class="footer">

    </div>
    <!--Footer End-->

</div>
<script>
    seajs.use('<?php echo (APP_NAME); ?>/Resource/Js/login', function( Login ) {

        Login.signSwitch();

    });
</script>
</body>
</html>