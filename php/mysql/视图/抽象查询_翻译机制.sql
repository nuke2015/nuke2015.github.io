


-- Adminer 4.3.2-dev MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `bestphp_order_goods`;
CREATE TABLE `bestphp_order_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `order_id` int(11) NOT NULL COMMENT '关联的订单id,被动关联.',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `serial_no` varchar(200) NOT NULL DEFAULT '' COMMENT '商品库存编号',
  `create_at` int(11) NOT NULL COMMENT '添加时间',
  `sort_at` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '状态[-1删除0草稿1正常]',
  `club_id` int(11) NOT NULL COMMENT '会所id',
  `amount` int(11) NOT NULL COMMENT '数量',
  `amount_done` int(11) NOT NULL DEFAULT '0' COMMENT '已完成数量',
  `price_market` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '市场价格',
  `price_real` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '实际价格',
  `refer_id` int(11) NOT NULL COMMENT '相关id()',
  `refer_type` tinyint(1) NOT NULL COMMENT '商品类型[1product,2product_sku3package]',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单关联货物表';


DROP TABLE IF EXISTS `bestphp_package`;
CREATE TABLE `bestphp_package` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `type` tinyint(1) NOT NULL COMMENT '[1组合套餐2免费赠品]',
  `serial_no` varchar(200) NOT NULL DEFAULT '' COMMENT '货号',
  `price_real` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '实际售价',
  `price_market` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '市场价格',
  `create_at` int(11) NOT NULL COMMENT '添加时间',
  `sort_at` int(11) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '状态[-1删除0草稿1正常]',
  `unit` varchar(50) NOT NULL COMMENT '单位',
  `thumb` varchar(250) NOT NULL COMMENT '封面图',
  `desp` varchar(250) NOT NULL COMMENT '套餐描述',
  `club_id` int(11) NOT NULL COMMENT '会所id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='套餐管理表';


DROP TABLE IF EXISTS `bestphp_package_relate`;
CREATE TABLE `bestphp_package_relate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `package_id` int(11) NOT NULL COMMENT '套餐id',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `create_at` int(11) NOT NULL COMMENT '添加时间',
  `sort_at` int(11) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '状态[-1删除0草稿1正常]',
  `refer_type` tinyint(1) NOT NULL COMMENT '类型[1产品product2产品属性product_attrsku]',
  `product_attrsku_id` int(11) NOT NULL COMMENT '产品组合属性id',
  `amount` int(11) NOT NULL COMMENT '数量',
  `price_real` decimal(8,0) NOT NULL COMMENT '实际售价',
  `price_market` decimal(8,0) NOT NULL COMMENT '市场价',
  `club_id` int(11) NOT NULL COMMENT '会所id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='营销套餐打包销售管理表';


DROP TABLE IF EXISTS `bestphp_product`;
CREATE TABLE `bestphp_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `type` varchar(200) NOT NULL COMMENT '基础类型[1物料2服务3人员]',
  `serial_no` varchar(200) NOT NULL COMMENT '货号',
  `category_id` int(11) NOT NULL COMMENT '商品分类(category表)',
  `price_real` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '实际售价',
  `price_market` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `create_at` int(11) NOT NULL COMMENT '添加时间',
  `sort_at` int(11) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '状态[-1删除0草稿1正常]',
  `unit` varchar(50) NOT NULL COMMENT '单位',
  `thumb` varchar(200) NOT NULL COMMENT '封面图',
  `desp` varchar(250) NOT NULL COMMENT '产品描述',
  `goods_type` int(11) NOT NULL COMMENT ' 商品类型(goods_type表)',
  `attrdata` text COMMENT '类型属性配置json(goods_attr)',
  `club_id` int(11) NOT NULL COMMENT '会所id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品管理表';


DROP TABLE IF EXISTS `bestphp_product_attrsku`;
CREATE TABLE `bestphp_product_attrsku` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `product_id` int(11) NOT NULL COMMENT '产品id',
  `sku_no` varchar(250) NOT NULL DEFAULT '' COMMENT '库存编码',
  `sku_list` varchar(200) NOT NULL COMMENT '产品属性链表',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `create_at` int(11) NOT NULL COMMENT '添加时间',
  `sort_at` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '状态[-1删除0草稿1正常]',
  `price_market` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `price_real` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '实际售价',
  `club_id` int(11) NOT NULL COMMENT '会所id',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品属性组合管理列表';


-- 2018-05-27 19:47:38



-- 单查产品表
select og.id as goods_id,og.title,og.amount,og.amount_done,pr.title as pr_title,pr.category_id as pr_category_id,pr.id as pr_id from bestphp_order_goods as og
left join bestphp_product as pr
on og.refer_id=pr.id 
where
(
    og.refer_type=1
    and
    og.id in (select id as goods_id_tmp from view_order_goods_service)
)


-- 单查属性表
select og.id as goods_id,og.title,og.amount,og.amount_done,pr.title as pr_title,pr.category_id as pr_category_id,pr.id as pr_id from bestphp_order_goods as og
left join bestphp_product_attrsku as pa
on og.refer_id=pa.id 
left join bestphp_product as pr
on pa.product_id=pr.id
where
(
    og.refer_type=2
    and
    og.id in (select id as goods_id_tmp from view_order_goods_service)
)


-- 单查套餐表,实现太复杂,开始使用视图翻译.to be continue;


-- package.1.套餐->产品
select pl.id as pl_id,pl.refer_type as pl_type,pr.* from bestphp_package as pk
right join
bestphp_package_relate as pl
on pk.id=pl.package_id
left join bestphp_product as pr
on pl.product_attrsku_id=pr.id
where
pl.refer_type=1;

-- package.2.套餐->属性->产品
select pl.id as pl_id,pl.refer_type as pl_type,pr.* from bestphp_package as pk
right join
bestphp_package_relate as pl
on pk.id=pl.package_id
left join bestphp_product_attrsku as pa
on pl.product_attrsku_id=pa.id
left join bestphp_product as pr
on pa.product_id=pr.id
where
pl.refer_type=2;


-- package to product,套餐=>产品

select pl.id as pl_id,pl.refer_type as pl_type,pr.id as pr_id,pr.title as pr_title,pr.category_id as pr_category_id from bestphp_package as pk
right join
bestphp_package_relate as pl
on pk.id=pl.package_id
left join bestphp_product as pr
on pl.product_attrsku_id=pr.id
where
pl.refer_type=1


UNION


select pl.id as pl_id,pl.refer_type as pl_type,pr.id as pr_id,pr.title as pr_title,pr.category_id as pr_category_id from bestphp_package as pk
right join
bestphp_package_relate as pl
on pk.id=pl.package_id
left join bestphp_product_attrsku as pa
on pl.product_attrsku_id=pa.id
left join bestphp_product as pr
on pa.product_id=pr.id
where
pl.refer_type=2;


-- package to product+product_attr,套餐=>产品(+细化区分信息)
select pk.id as pk_id,pl.id as pl_id,pl.refer_type as pl_type,pr.id as pr_id,pr.title as pr_title,pr.category_id as pr_category_id,
0 as pa_id,0 as pa_title
from bestphp_package as pk
right join
bestphp_package_relate as pl
on pk.id=pl.package_id
left join bestphp_product as pr
on pl.product_attrsku_id=pr.id
where
pl.refer_type=1


UNION


select pk.id as pk_id,pl.id as pl_id,pl.refer_type as pl_type,pr.id as pr_id,pr.title as pr_title,pr.category_id as pr_category_id,
pa.id as pa_id,pa.title as pa_title
 from bestphp_package as pk
right join
bestphp_package_relate as pl
on pk.id=pl.package_id
left join bestphp_product_attrsku as pa
on pl.product_attrsku_id=pa.id
left join bestphp_product as pr
on pa.product_id=pr.id
where
pl.refer_type=2;



-- product_attr to product,属性->产品
select pa.id as pa_id,pa.title as pa_title,pr.id as pr_id,pr.title as pr_title,pr.category_id as pr_category_id from bestphp_product_attrsku as pa
left join bestphp_product as pr
on pa.product_id =pr.id





-- 使用抽象视图(view_to_product_from_attrsku),单查属性表
select og.id as goods_id,og.title,og.amount,og.amount_done,pr_title,pr_category_id,pr_id from bestphp_order_goods as og
left join view_to_product_from_attrsku as v
on og.refer_id=v.pr_id 
where
(
    og.refer_type=2
    and
    og.id in (select id as goods_id_tmp from view_order_goods_service)
)

-- 使用抽象视图(view_to_product_from_package_relate),单查套餐表
select og.id as goods_id,og.title,og.amount,og.amount_done,pr_title,pr_category_id,pr_id from bestphp_order_goods as og
left join view_to_product_from_package_relate as v
on og.refer_id=v.pk_id 
where
(
    og.refer_type=3
    and
    og.id in (select id as goods_id_tmp from view_order_goods_service)
)


-- 细化综合查询,goods to product
select og.id as goods_id,og.title,og.amount,og.amount_done,pr.title as pr_title,pr.category_id as pr_category_id,pr.id as pr_id from bestphp_order_goods as og
left join bestphp_product as pr
on og.refer_id=pr.id 
where
(
    og.refer_type=1
    and
    og.id in (select id as goods_id_tmp from view_order_goods_service)
)

UNION

select og.id as goods_id,og.title,og.amount,og.amount_done,pr_title,pr_category_id,pr_id from bestphp_order_goods as og
left join view_to_product_from_attrsku as v
on og.refer_id=v.pa_id 
where
(
    og.refer_type=2
    and
    og.id in (select id as goods_id_tmp from view_order_goods_service)
)

UNION

select og.id as goods_id,og.title,og.amount,og.amount_done,pr_title,pr_category_id,pr_id from bestphp_order_goods as og
left join view_to_product_from_package_relate as v
on og.refer_id=v.pk_id 
where
(
    og.refer_type=3
    and
    og.id in (select id as goods_id_tmp from view_order_goods_service)
)



-- 细化综合查询,goods to product+product_attrsku
select og.id as goods_id,og.refer_type,og.refer_id,og.title,og.amount,og.amount_done,pr.title as pr_title,pr.category_id as pr_category_id,pr.id as pr_id,
0 as pa_id,0 as pa_title
from bestphp_order_goods as og
left join bestphp_product as pr
on og.refer_id=pr.id 
where
(
    og.refer_type=1
    and
    og.id in (select id as goods_id_tmp from view_order_goods_service)
)

UNION

select og.id as goods_id,og.refer_type,og.refer_id,og.title,og.amount,og.amount_done,pr_title,pr_category_id,pr_id,
pa_id,pa_title
from bestphp_order_goods as og
left join view_to_product_from_attrsku as v
on og.refer_id=v.pa_id 
where
(
    og.refer_type=2
    and
    og.id in (select id as goods_id_tmp from view_order_goods_service)
)

UNION

select og.id as goods_id,og.refer_type,og.refer_id,og.title,og.amount,og.amount_done,pr_title,pr_category_id,pr_id,
pa_id,pa_title
from bestphp_order_goods as og
left join view_to_product_from_package_relate as v
on og.refer_id=v.pk_id 
where
(
    og.refer_type=3
    and
    og.id in (select id as goods_id_tmp from view_order_goods_service)
)


