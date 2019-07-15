
-- 基础结构
SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `tongji_pageview`;
CREATE TABLE `tongji_pageview` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `uuid` char(32) NOT NULL COMMENT 'uuid',
  `sess_id` char(26) NOT NULL DEFAULT '' COMMENT '会话id,用户',
  `url` varchar(250) NOT NULL COMMENT '当前页面',
  `url_md5` char(32) NOT NULL COMMENT '当前页面',
  `url_refer` varchar(250) DEFAULT NULL COMMENT '来路页面',
  `url_refer_md5` char(32) NOT NULL COMMENT '来路页面',
  `create_at` int(11) NOT NULL COMMENT '创建时间',
  `sys` varchar(20) NOT NULL COMMENT '系统',
  `browser` varchar(20) NOT NULL COMMENT '浏览器',
  `is_mobile` tinyint(1) NOT NULL COMMENT '是否移动端',
  `ipv4` char(16) NOT NULL COMMENT 'ipv4',
  `display` varchar(20) NOT NULL COMMENT '分辨率',
  `title` varchar(50) NOT NULL COMMENT '页面标题',
  `club_id` int(11) NOT NULL COMMENT '会所id',
  `hour_create_at` int(11) NOT NULL DEFAULT '0' COMMENT '小时段',
  `t_create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '每小时间优化',
  PRIMARY KEY (`id`),
  KEY `url_md5` (`url_md5`),
  KEY `url_refer_md5` (`url_refer_md5`),
  KEY `ipv4` (`ipv4`),
  KEY `sess_id` (`sess_id`),
  KEY `uuid` (`uuid`),
  KEY `club_id` (`club_id`),
  KEY `hour_create_at` (`hour_create_at`),
  KEY `t_create_at` (`t_create_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COMMENT='会所页面访问表';


-- 2019-07-15 15:25:47


explain 
SELECT 
COUNT(DISTINCT `ipv4`) AS `ip`,
COUNT(DISTINCT `uuid`) AS `uv`,
count(DISTINCT `url_md5`) AS `pv`,
COUNT(0) AS `vv`,
COUNT(DISTINCT `uuid`) AS `jump`,
hour_create_at AS `start_at`,
 `club_id`
FROM `tongji_pageview`
GROUP BY hour_create_at



 Modify	ip	uv	pv	vv	jump	start_at	club_id
 编辑	5	10	9	10	10	0	5
 编辑	4	11	8	32	11	1551934800	5
 编辑	1	2	8	40	2	1552093200	5
 编辑	1	3	6	23	3	1552100400	5
 编辑	1	3	18	44	3	1552104000	5
 编辑	1	2	2	4	2	1552125600	5
 编辑	1	1	3	5	1	1552129200	5
 编辑	1	6	9	29	6	1552150800	5
 编辑	1	5	7	17	5	1552266000	5
 编辑	2	23	18	126	23	1552269600	5


id	select_type	table	type	possible_keys	key	key_len	ref	rows	Extra
1	SIMPLE	tongji_pageview	index	hour_create_at	hour_create_at	4	NULL	49328	NULL


问题:
虽然对hour_create_at有index索引,但是全表数据4.9万条.
每次查询也是4.9万条,这不科学.


explain SELECT * FROM `tongji_view_pageview_count` LIMIT 100

id	select_type	table	type	possible_keys	key	key_len	ref	rows	Extra
1	PRIMARY	<derived2>	ALL	NULL	NULL	NULL	NULL	48653	NULL
2	DERIVED	tongji_pageview	index	hour_create_at	hour_create_at	4	NULL	48653	NULL


