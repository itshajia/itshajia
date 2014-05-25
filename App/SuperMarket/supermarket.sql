--
-- 表的结构 `uio_app_supermarket`
--
DROP TABLE IF EXISTS `uio_app_supermarket`;
CREATE TABLE IF NOT EXISTS `uio_app_supermarket` (
  `sm_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `sm_name` varchar(32) NOT NULL,
  `sm_banner` text,
  `sm_intro` text,
  `sm_contact` text,
  `status` tinyint(1) default 0,
  PRIMARY KEY (`sm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- 表的结构 `uio_app_supermarket_goods_cate`
--
DROP TABLE IF EXISTS `uio_app_supermarket_goods_cate`;
CREATE TABLE `uio_app_supermarket_goods_cate` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cate_name` varchar(20) NOT NULL,
  `parent_id` int(11) default 0,
  `listorder` int(11) default 0,
  `addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_app_supermarket_goods`
--
DROP TABLE IF EXISTS `uio_app_supermarket_goods`;
CREATE TABLE `uio_app_supermarket_goods` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `pic` text,
  `is_new` tinyint(1) default 0,
  `is_hot` tinyint(1) default 0,
  `is_recommend` tinyint(1) default 0,
  `market_price` float(10,2),
  `sale_price` float(10,2),
  `stock` int(11) default 0,
  `unit` varchar(10),
  `description` text,
  `listorder` int(11) default 0,
  `status` tinyint(1) default 0,
  `addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`pro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 表的结构 `uio_app_supermarket_goods_format`
--
DROP TABLE IF EXISTS `uio_app_supermarket_goods_format`;
CREATE TABLE `uio_app_supermarket_goods_format` (
  `format_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `format_name` varchar(50) NOT NULL,
  `format_value` text,
  `format_desc` text,
  `listorder` int(11) default 0,
  `addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`format_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
