


-- join语句泊水也很深啊,关键就在于连接点是什么?



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
  `update_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort_at` int(11) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '状态[-1删除0草稿1正常]',
  `unit` varchar(50) NOT NULL COMMENT '单位',
  `thumb` varchar(250) NOT NULL COMMENT '封面图',
  `desp` varchar(250) NOT NULL COMMENT '套餐描述',
  `club_id` int(11) NOT NULL COMMENT '会所id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='套餐管理表';

-- 2018-06-21 12:03:10



-- 此条语句,会查询某个时间段内所有的套餐的排名,包括排名为0的套餐.
select sum(og.amount) as count,pa.id as refer_id,pa.title from bestphp_package as pa
left join bestphp_order_goods as og
on pa.id=og.refer_id and refer_type=3 
and og.create_at>1527782400 and og.create_at<1530374399
where pa.type=1 and pa.club_id=5
group by pa.id
order by count DESC
limit 0,20



-- 此条语句,只给出个某个时间段内的热销套餐的排名,无排名的套餐自动隐藏
select sum(og.amount) as count,pa.id as refer_id,pa.title from bestphp_package as pa
left join bestphp_order_goods as og
on pa.id=og.refer_id and refer_type=3 
where
pa.type=1 and pa.club_id=5
and og.create_at>1527782400 and og.create_at<1530374399
group by pa.id
order by count DESC
limit 0,20



