--
-- 表的结构 `uio_app_wz`
--
DROP TABLE IF EXISTS `uio_app_wz`;
CREATE TABLE IF NOT EXISTS `uio_app_wz` (
  `wz_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `wz_name` varchar(32) NOT NULL,
  `wz_intro` text,
  `wz_contact` text,
  `status` tinyint(1) default 0,
  PRIMARY KEY (`wz_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

