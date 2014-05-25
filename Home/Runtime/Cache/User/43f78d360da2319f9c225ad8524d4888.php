<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title><?php echo ($title); ?></title>
    <link rel="stylesheet" href="__CSS__/reset.css" />
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="__CSS__/u.css" />
    <script type="text/javascript" src="__JS__/sea.js"></script>
    <script type="text/javascript">
        var zxPath = "";
        seajs.config({
            base:zxPath,
            alias: {
                'jquery': '__JS__/jquery'
            }
        });
    </script>
</head>
<body onscroll="no">
<div class="u">
    <!-- 左侧主导航 Start -->
<div class="nav_panel">
    <div class="nav" id="nav">
        <ul>
            <?php if(is_array($menuList)): $i = 0; $__LIST__ = $menuList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="item">
                    <div class="nav_box">
                        <a href="javascript:;" class="icon icon_app_<?php echo ($menu["menu_ename"]); ?> <?php if( $i==1 ){ ?> active <?php } ?>" title="<?php echo ($menu["menu_name"]); ?>" rel="<?php echo ($menu["menu_ename"]); ?>"  ></a>
                    </div>
                    <div class="nav_tag hidden"><?php echo ($menu["menu_name"]); ?></div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
</div>

<!-- 左侧主导航 End -->

<!-- 用户信息模块 Start -->
<div class="userInfo_panel font_yahei">
    <div class="userInfo">
        <div class="userHead">
            欢迎 <?php echo $_SESSION['_User']['username']; ?>，<a href="<?php echo appUrl('m=Index&a=logout'); ?>">安全退出</a>
        </div>
    </div>
</div>
<!-- 用户信息模块 End -->

<!-- 顶部公告 Start -->
<div class="msg_panel font_yahei">
    <div class="msg_item"><a href="javascript:;">今日新增 <span class="orange">5</span> 位关注用户</a></div>
    <div class="msg_item"><a href="javascript:;">收到 <span class="orange">2</span> 条新消息</a></div>
    <div class="link_group fl_r clearfix">
        <a href="<?php echo appUrl(''); ?>">首页</a>
        <a href="javascript:;" onclick="window.history.back()">返回</a>
        <a href="javascript:;" id="fresh">刷新</a>
    </div>
</div>
<!-- 顶部公告 End -->
    <!--后台管理左菜单栏 start-->
<div class="slide_panel font_yahei">
    <div class="slide_bar">
        <div class="slide_group">
            <?php if(is_array($leftMenu)): $i = 0; $__LIST__ = $leftMenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><div class="menu_bar <?php if(!$menu['show']){ ?> hidden <?php } ?>" id="<?php echo ($menu["tag"]); ?>">
                    <?php if(is_array($menu["sons"])): $j = 0; $__LIST__ = $menu["sons"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$son): $mod = ($j % 2 );++$j; if($son['three_sons']){ ?>
                        <dl>
                            <dt><?php echo ($son["submenu_name"]); ?></dt>
                            <dd <?php if($j!=1){ ?>style=""<?php } ?>>
                            <ul>
                                <?php if(is_array($son["three_sons"])): $i = 0; $__LIST__ = $son["three_sons"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$three_son): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($three_son["resource_url"]); ?>" target="display_frame"><?php echo ($three_son["resource_name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                            </dd>
                        </dl>
                        <?php } endforeach; endif; else: echo "" ;endif; ?>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</div>
<!--后台管理左菜单栏 end-->
    <div class="frame_box">
        <div class="frame_panel">
            <iframe style="" id="display_frame" name="display_frame"  scrolling="auto"  src="<?php echo appUrl('m=Home&a=index'); ?>"
                    frameborder="0" ></iframe>
        </div>
    </div>
    

</body>
</html>
</div>

<script>
    seajs.use('__JS__/u');
</script>
</body>
</html>