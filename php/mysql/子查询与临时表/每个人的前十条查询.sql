


-- Adminer 4.3.2-dev MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `goods_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `worker_id` int(11) unsigned NOT NULL,
  `city_id` int(11) NOT NULL COMMENT '城市',
  `describe` varchar(12) NOT NULL DEFAULT '' COMMENT '关键词，新上或者推荐才有',
  `name` varchar(60) NOT NULL DEFAULT '',
  `price` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '售价',
  `origin_price` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '市场价',
  `type_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品类型',
  `mark` varchar(8) NOT NULL DEFAULT '' COMMENT '商品标记',
  `sold_count` int(11) NOT NULL DEFAULT '0' COMMENT '销量  数据可修改 不是真实的',
  `rc` int(11) NOT NULL DEFAULT '0' COMMENT '真实销量',
  `banner` varchar(4096) NOT NULL DEFAULT '' COMMENT 'banner展示图片',
  `detail` varchar(400) NOT NULL DEFAULT '' COMMENT '介绍',
  `image` varchar(4096) NOT NULL DEFAULT '' COMMENT '详情图片',
  `status` tinyint(11) NOT NULL DEFAULT '0' COMMENT '商品状态 0未提交 1已下架 2已上架 3审核中 4未通过',
  `recommend` tinyint(4) NOT NULL DEFAULT '0' COMMENT '推荐  0否1是',
  `is_hot` tinyint(4) NOT NULL DEFAULT '0' COMMENT '主页热门推荐',
  `is_new` tinyint(4) NOT NULL DEFAULT '0' COMMENT '主页今日新品',
  `deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '删除标记',
  `set_new_at` timestamp NULL DEFAULT NULL COMMENT '设置上新的时间',
  `set_hot_at` timestamp NULL DEFAULT NULL COMMENT '设置热门的时间',
  `apply_at` timestamp NULL DEFAULT NULL COMMENT '最近一次提交审核时间',
  `examine_at` timestamp NULL DEFAULT NULL COMMENT '最近一次审核通过时间',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`goods_id`),
  KEY `worker_id` (`worker_id`),
  KEY `city_id` (`city_id`,`sold_count`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品';


-- 2021-12-06 08:48:12

-- 每个人筛选出前十
SELECT p1.goods_id, p1.name, p1.worker_id,p1.status
FROM goods p1
WHERE status=2 and (
    SELECT COUNT(*)
    FROM goods p2
    WHERE p1.worker_id = p2.worker_id
        AND p1.goods_id < p2.goods_id
) < 10
ORDER BY goods_id DESC



-- 随机20条
SELECT goods_id,worker_id,name
FROM goods
where status=2
ORDER BY RAND()
limit 20


-- 随机20条
SELECT goods_id,worker_id,name
from goods
where goods_id in
(
    SELECT goods_id
    FROM goods
    where status=2
    ORDER BY RAND()
    limit 20
) as tmp

-- 报错1235


-- 随机20条,解决1235问题
SELECT goods_id,worker_id,name
from goods
where goods_id in
(
    SELECT t2.goods_id
    from
    (SELECT goods_id
    FROM goods
    where status=2
    ORDER BY RAND()
    limit 20) as t2
)



-- 更新20条
update goods
set update_at='2021-12-06 15:58:21'
where goods_id in
(
    SELECT t2.goods_id
    from
    (SELECT goods_id
    FROM goods
    where status=2
    ORDER BY RAND()
    limit 20) as t2
)


