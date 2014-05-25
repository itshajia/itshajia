<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="__AP__/<?php echo (APP_NAME); ?>/Resource/Css/login.css" />
    <script type="text/javascript" src="__JS__/sea.js"></script>
    <script type="text/javascript">
        var zxPath = "";
        seajs.config({
            base:zxPath
        });
    </script>
</head>
<body>
<div class="login">
    <div class="login_body">
        <div class="login_panel">
            <div class="login_header">
                <span class="login_title">后台管理系统</span>
            </div>
            <div class="login_form">
                <form id="admin_login" method="post" action="<?php echo appUrl('Index/login_do'); ?>">
                    <p class="loginMsg"><?php echo ($error); ?></p>
                    <p class="loginTitle">用户名：</p>
                    <p class="loginForm">
                        <input style="width: 200px;" type="text" name="username" class="txt" title="请填写正确的登录账号" />
                    </p>
                    <p class="loginTitle">密码：</p>
                    <p class="loginForm">
                        <input style="width: 200px;" type="password" name="password" class="txt" title="请填写正确的登录密码" />
                    </p>
                    <p class="loginBtn">
                        <button type="submit">登录</button>
                        <button type="reset">重置</button>
                    </p>
                </form>
            </div>
            <table cellspacing="0" cellpadding="0" border="0" style="display:none;">
                <tbody>
                <tr>
                    <td class="pl">
                        <div class="admin_logo"></div>
                    </td>
                    <td class="pr">
                        <div>
                            <form id="admin_login" method="post" action="<?php echo appUrl('Index/login_do'); ?>">
                                <p class="msg"><?php echo ($error); ?></p>
                                <p class="loginTitle">用户名：</p>
                                <p class="loginForm"><input type="text" name="username" class="txt" title="请填写正确的登录账号" /></p>
                                <p class="loginTitle">密码：</p>
                                <p class="loginForm"><input type="password" name="password" class="txt" title="请填写正确的登录密码" /></p>
                                <p class="loginBtn">
                                    <button type="submit">提交</button>
                                    <button type="reset">重置</button>
                                </p>
                            </form>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>