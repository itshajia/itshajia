-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 11 月 22 日 23:21
-- 服务器版本: 5.5.32
-- PHP 版本: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `itshajia`
--
CREATE DATABASE IF NOT EXISTS `itshajia` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `itshajia`;

-- --------------------------------------------------------

--
-- 表的结构 `uio_menu`
--
DROP TABLE IF EXISTS `uio_menu`;
CREATE TABLE IF NOT EXISTS `uio_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_ename` varchar(32) NOT NULL,
  `menu_name` varchar(32) NOT NULL,
  `listorder` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `uio_menu`
--

INSERT INTO `uio_menu` (`menu_id`, `menu_ename`, `menu_name`, `listorder`, `status`) VALUES
(1, 'config', '全局配置', 1, 1),
(2, 'article', '资讯管理', 2, 1),
(3, 'product', '产品管理', 3, 1),
(4, 'user', '用户管理', 4, 1),
(5, 'tool', '站长工具', 5, 1),
(6, 'app', '应用中心', 6, 1);

-- --------------------------------------------------------

--
-- 表的结构 `uio_nav`
--
DROP TABLE IF EXISTS `uio_nav`;
CREATE TABLE IF NOT EXISTS `uio_nav` (
  `nav_id` int(11) NOT NULL AUTO_INCREMENT,
  `nav_url` varchar(200) NOT NULL,
  `nav_title` varchar(20) NOT NULL,
  `nav_style` varchar(20) NOT NULL,
  `listorder` int(11) NOT NULL,
  `newwindow` int(11) NOT NULL,
  `ishide` int(11) NOT NULL,
  PRIMARY KEY (`nav_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `uio_config`
--
DROP TABLE IF EXISTS `uio_config`;
CREATE TABLE IF NOT EXISTS `uio_config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_key` varchar(50) NOT NULL,
  `config_value` varchar(200) NOT NULL,
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `uio_shortcuts`
--
DROP TABLE IF EXISTS `uio_shortcuts`;
CREATE TABLE IF NOT EXISTS `uio_shortcuts` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `uio_submenu`
--
DROP TABLE IF EXISTS `uio_submenu`;
CREATE TABLE IF NOT EXISTS `uio_submenu` (
  `submenu_id` int(11) NOT NULL AUTO_INCREMENT,
  `submenu_name` varchar(32) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `listorder` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`submenu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `uio_submenu`
--

INSERT INTO `uio_submenu` (`submenu_id`, `submenu_name`, `menu_id`, `listorder`, `status`) VALUES
(9, '系统配置', 1, 1, 1),
(10, '关于网站', 2, 1, 1),
(11, '文章模块', 2, 2, 1),
(12, '用户管理', 4, 1, 1),
(15, '系统组管理', 4, 2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `uio_submenu_resource`
--
DROP TABLE IF EXISTS `uio_submenu_resource`;
CREATE TABLE IF NOT EXISTS `uio_submenu_resource` (
  `resource_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_name` varchar(32) NOT NULL,
  `mod` varchar(30) NOT NULL,
  `act` varchar(30) NOT NULL,
  `resource_url` varchar(200) NOT NULL,
  `submenu_id` int(11) NOT NULL,
  `listorder` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`resource_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `uio_submenu_resource`
--

INSERT INTO `uio_submenu_resource` (`resource_id`, `resource_name`, `resource_url`, `submenu_id`, `listorder`, `status`) VALUES
(1, '测试菜单项', '/Test/index/view/show2', 6, 2, 1),
(2, '测试菜单项2', '/Test/index/view/show1', 6, 1, 1),
(3, '测试菜单项', '/Test/index/view/show', 13, 1, 1),
(4, '添加用户', 'UserManage/add', 12, 1, 1),
(5, '用户管理', 'UserManage/userList', 12, 2, 1),
(6, '用户组', 'UserManage/customList', 12, 3, 1),
(7, '系统组管理', 'UserManage/groupList', 15, 1, 1),
(8, '添加系统组', 'UserManage/groupAdd', 15, 2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `uio_admin`
--
DROP TABLE IF EXISTS `uio_admin`;
CREATE TABLE IF NOT EXISTS `uio_admin` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `truename` varchar(20) NOT NULL,
  `group_id` int(11) NOT NULL,
  `photo` varchar(255),
  `email` varchar(60) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `company` varchar(50),
  `description` varchar(255),
  `addtime` int(11) NOT NULL,
  `reg_ip` varchar(20) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `uio_admin`
--
INSERT INTO `uio_admin` (`uid`, `username`, `password`, `nickname`,`truename`, `group_id`, `photo`, `email`,`mobile`,`company`, `description`, `addtime`, `reg_ip`, `status`) VALUES
(1, 'itshajia', '96e79218965eb72c92a549dd5a330112', 'IT-沙加','周星', 1, '', 'itshajia@gmail.com','13852757093','', '', 0, '127.0.0.1', 1);


--
-- 表的结构 `uio_user`
--
DROP TABLE IF EXISTS `uio_user`;
CREATE TABLE IF NOT EXISTS `uio_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `truename` varchar(20) NOT NULL,
  `group_id` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `email` varchar(60) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `company` varchar(50),
  `wxnumber` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `addtime` int(11) NOT NULL,
  `reg_ip` varchar(20) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `uio_user`
--


--
-- 表的结构 `uio_user_info`
--
DROP TABLE IF EXISTS `uio_user_info`;
CREATE TABLE IF NOT EXISTS `uio_user_info` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `wxnumber` varchar(20),
  `wxpassword` varchar(20),
  `erwm` varchar(100),
  `appId` varchar(100),
  `appSecret` varchar(100),
  `company` varchar(20),
  `mobile` varchar(20),
  `tel` varchar(20),
  `email` varchar(20),
  `fax` varchar(20),
  `truename` varchar(20),
  `address` varchar(100),
  `addtime` int(11),
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `uio_user`
--

-- --------------------------------------------------------

--
-- 表的结构 `uio_user_group`
--
DROP TABLE IF EXISTS `uio_user_group`;
CREATE TABLE IF NOT EXISTS `uio_user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(20) NOT NULL,
  `group_rules` text,
  `is_admin` tinyint(1) default 0,
  `uptime` int(11) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `uio_user_group`
--

INSERT INTO `uio_user_group` (`group_id`, `group_name`, `group_rules`, `uptime`) VALUES
(1, '创始人', '', 1384779000),
(2, '超级管理员', '', 1384779300),
(5, '测试组', '4,5,7,8,', 1384779385);


--
-- 表的结构 `uio_article`
--

DROP TABLE IF EXISTS `uio_article`;
CREATE TABLE IF NOT EXISTS `uio_article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `module_tag` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `addtime` int(11) NOT NULL,
  `is_public` tinyint(1),
  `status` tinyint(1),
  `listorder` int(11),
  `views` int(11),
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `uio_article`
--


--
-- 表的结构 `uio_article_category`
--
DROP TABLE IF EXISTS `uio_article_category`;
CREATE TABLE IF NOT EXISTS `uio_article_category` (
  `catid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `module_tag` varchar(20) NOT NULL,
  `catname` varchar(20) NOT NULL,
  `is_sys` tinyint(1) DEFAULT 0,
  `listorder` int(11) NOT NULL,
  PRIMARY KEY (`catid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `uio_article_category`
--


--
-- 表的结构 `uio_app`
--
DROP TABLE IF EXISTS `uio_app`;
CREATE TABLE IF NOT EXISTS `uio_app` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11),
  `app_name` varchar(20) NOT NULL,
  `app_ename` varchar(20) NOT NULL,
  `thumb` varchar(100),
  `introduce` text,
  `price` varchar(255),
  `keywords` varchar(255),
  `description` text,
  `status` tinyint(1) default 0,
  `is_sys` tinyint(1) default 0,
  `is_fee` tinyint(1) default 0,
  `is_top` tinyint(1) default 0,
  `is_edit` tinyint(1) default 1,
  `listorder` int(11) NOT NULL,
  PRIMARY KEY (`app_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;
--
-- 转存表中的数据 `uio_app`
--


--
-- 表的结构 `uio_app_type`
--
DROP TABLE IF EXISTS `uio_app_type`;
CREATE TABLE IF NOT EXISTS `uio_app_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL,
  `type_ename` varchar(20) NOT NULL,
  `listorder` int(11) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `uio_app_type`
--

--
-- 表的结构 `uio_app_apply_record`
--
DROP TABLE IF EXISTS `uio_app_apply_record`;
CREATE TABLE IF NOT EXISTS `uio_app_apply_record` (
  `record_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `year` int(4) default 0,
  `addtime` int(11),
  `is_check` tinyint(1),
  `agent_id` int(11),
  PRIMARY KEY (`record_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `uio_app_apply_record`
--

--
-- 表的结构 `uio_app_apply`
--
DROP TABLE IF EXISTS `uio_app_apply`;
CREATE TABLE IF NOT EXISTS `uio_app_apply` (
  `apply_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `keywords` varchar(255),
  `keywordpic` varchar(500),
  `keyworddesc` text,
  `addtime` int(11),
  `starttime` int(11),
  `endtime` int(11),
  `status` tinyint(1),
  `agent_id` int(11),
  PRIMARY KEY (`apply_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `uio_app_apply`
--

--
-- 表的结构 `uio_news_cate`
--
DROP TABLE IF EXISTS `uio_news_cate`;
CREATE TABLE `uio_news_cate` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cate_name` varchar(20) NOT NULL,
  `parent_id` int(11) default 0,
  `listorder` int(11) default 0,
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20),
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_news`
--
DROP TABLE IF EXISTS `uio_news`;
CREATE TABLE IF NOT EXISTS `uio_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `description` text,
  `listorder` int(11) default 0,
  `addtime` int(11) DEFAULT NULL,
  `status` tinyint(1) default 0,
  `app_name` varchar(20),
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `uio_pro_cate`
--
DROP TABLE IF EXISTS `uio_pro_cate`;
CREATE TABLE `uio_pro_cate` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cate_name` varchar(20) NOT NULL,
  `parent_id` int(11) default 0,
  `listorder` int(11) default 0,
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20),
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_pro
--
DROP TABLE IF EXISTS `uio_pro`;
CREATE TABLE `uio_pro` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `pic` text,
  `description` text,
  `listorder` int(11) default 0,
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20),
  PRIMARY KEY (`pro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_page
--
DROP TABLE IF EXISTS `uio_page`;
CREATE TABLE `uio_page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `description` text,
  `listorder` int(11) default 0,
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20),
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_album_cate
--
DROP TABLE IF EXISTS `uio_album_cate`;
CREATE TABLE `uio_album_cate` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cate_name` varchar(20) NOT NULL,
  `parent_id` int(11) default 0,
  `listorder` int(11) default 0,
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20),
  `item_id` int(11),
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_album
--
DROP TABLE IF EXISTS `uio_album`;
CREATE TABLE `uio_album` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(20),
  `cate_id` int(11) NOT NULL,
  `description` text,
  `listorder` int(11) default 0,
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20),
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_album_pic
--
DROP TABLE IF EXISTS `uio_album_pic`;
CREATE TABLE `uio_album_pic` (
  `pic_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `pic_title` varchar(20),
  `album_id` int(11) NOT NULL,
  `pic_url` text,
  `is_cover` tinyint(1) default 0,
  `listorder` int(11) default 0,
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20),
  `item_id` int(11),
  PRIMARY KEY (`pic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_levelMsg
--
DROP TABLE IF EXISTS `uio_levelMsg`;
CREATE TABLE `uio_levelMsg` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `from_uid` int(11),
  `msg_name` varchar(20),
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20),
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_bzmap
--
DROP TABLE IF EXISTS `uio_bzmap`;
CREATE TABLE `uio_bzmap` (
  `bz_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `bzpoint` varchar(200),
  `company` varchar(30),
  `address` varchar(100),
  `tel` varchar(20),
  `fax` varchar(20),
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20),
  PRIMARY KEY (`bz_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_column
--
DROP TABLE IF EXISTS `uio_column`;
CREATE TABLE `uio_column` (
  `column_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `column_name` varchar(50),
  `css_icon` varchar(20),
  `image` varchar(100),
  `is_sys` tinyint(1) default 0,
  `is_show` tinyint(1) default 0,
  `is_home` tinyint(1) default 0,
  `sort` int(11) default 0,
  `linkurl` varchar(50) NOT NULL,
  `description` text,
  `addtime` int(11) DEFAULT NULL,
  `app_name` varchar(20),
  PRIMARY KEY (`column_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


--
-- 表的结构 `uio_reply_msg
--
DROP TABLE IF EXISTS `uio_reply_msg`;
CREATE TABLE `uio_reply_msg` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `subscribe_id` int,
  `nomsg_id` int,
  `addtime` int(11),
  PRIMARY KEY (`msg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


--
-- 表的结构 `uio_reply
--
DROP TABLE IF EXISTS `uio_reply`;
CREATE TABLE `uio_reply` (
  `reply_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `keyword` varchar(20),
  `reply` text,
  `reply_type` tinyint(1),
  `addtime` int(11),
  PRIMARY KEY (`reply_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_reply_img
--
DROP TABLE IF EXISTS `uio_reply_img`;
CREATE TABLE `uio_reply_img` (
  `img_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `reply_id` int(11) NOT NULL,
  `title` varchar(20),
  `image` varchar(200),
  `desc` varchar(100),
  `url` varchar(100),
  `is_first` tinyint(1),
  `sort` int(11) default 0,
  `addtime` int(11),
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_custom_menu
--
DROP TABLE IF EXISTS `uio_custom_menu`;
CREATE TABLE `uio_custom_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `menu_type` varchar(20),
  `title` varchar(20),
  `menu_key` varchar(20),
  `parent_id` int(11),
  `child_count` int(11),
  `listorder` int(11),
  `addtime` int(11),
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


--
-- 表的结构 `uio_subscribe_user
--
DROP TABLE IF EXISTS `uio_subscribe_user`;
CREATE TABLE `uio_subscribe_user` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `openid` varchar(100),
  `nickname` varchar(100),
  `sex` tinyint(1),
  `language` varchar(10),
  `city` varchar(20),
  `province` varchar(20),
  `headimgurl` varchar(200),
  `addtime` int(11),
  `s_date` varchar(20),
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_global_location
--
DROP TABLE IF EXISTS `uio_global_location`;
CREATE TABLE `uio_global_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `openid` varchar(100),
  `x` varchar(100),
  `y` varchar(100),
  `precision` varchar(100),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_msg
--
DROP TABLE IF EXISTS `uio_msg`;
CREATE TABLE `uio_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `openid` varchar(100),
  `content` text,
  `status` tinyint(1) default 0,
  `is_read` tinyint(1) default 0,
  `adddate` int(11),
  `addtime` int(11),
  `senddate` varchar(20),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_msg_notice
--
DROP TABLE IF EXISTS `uio_msg_notice`;
CREATE TABLE `uio_msg_notice` (
  `notice_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `content` text,
  `is_read` tinyint(1) default 0,
  `addtime` int(11),
  PRIMARY KEY (`notice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_app_ad
--
DROP TABLE IF EXISTS `uio_app_ad`;
CREATE TABLE `uio_app_ad` (
  `ad_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `pic_url` varchar(100),
  `pic_title` varchar(50),
  `linkurl` varchar(100),
  `listorder` int(11) default 0,
  `addtime` int(11),
  `app_name` varchar(20),
  PRIMARY KEY (`ad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
