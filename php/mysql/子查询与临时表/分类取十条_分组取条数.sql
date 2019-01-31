

-- 原表
DROP TABLE IF EXISTS `zhihu_product`;
CREATE TABLE `zhihu_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `type` varchar(200) NOT NULL COMMENT '基础类型[1物料2服务]',
  `serial_no` varchar(200) NOT NULL COMMENT '货号',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品分类(category表)',
  `price_real` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际售价',
  `price_market` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  `price_cost` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '进货价',
  `barcode` varchar(50) NOT NULL COMMENT '条形码',
  `minbuy` int(11) NOT NULL COMMENT '最小购买数量',
  `specification` varchar(30) NOT NULL DEFAULT '' COMMENT '规格',
  `create_at` int(11) NOT NULL COMMENT '添加时间',
  `update_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort_at` int(11) NOT NULL COMMENT '排序',
  `status` tinyint(1) NOT NULL COMMENT '状态[-1删除0草稿1正常]',
  `unit` varchar(50) NOT NULL COMMENT '单位',
  `thumb` varchar(200) NOT NULL COMMENT '封面图',
  `desp` varchar(250) NOT NULL COMMENT '产品描述',
  `goods_type` int(11) NOT NULL COMMENT ' 商品类型(goods_type表)',
  `attrdata` text COMMENT '类型属性配置json(goods_attr)',
  `club_id` int(11) NOT NULL COMMENT '会所id',
  `mode_id` tinyint(1) NOT NULL COMMENT '业务模式关联busy_mode表',
  `sys_cat_id` int(11) NOT NULL COMMENT '系统标准类目',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品管理表';


SELECT p1.id, p1.title, p1.sys_cat_id
FROM zhihu_product p1
WHERE (
    SELECT COUNT(*)
    FROM zhihu_product p2
    WHERE p1.sys_cat_id = p2.sys_cat_id
        AND p1.id < p2.id
) < 3
ORDER BY sys_cat_id ASC



-- 效果

-- id  title sys_cat_id
-- 192 泰式按摩super-plus  2
-- 193 2323  2
-- 194 月嫂等级  2
-- 183 第1集1  3
-- 184 第1集 3
-- 350 月子服 3
-- 103 满月中药熏蒸  7
-- 326 推拿SPA 7
-- 349 26天月子服务 7
-- 354 尿你一脸  8
-- 161 xgw3  14
-- 352 宝宝游泳  14
-- 314 荷兰牛栏  15
-- 355 爱他美（Aptamil） 婴儿配方奶粉(0–6月龄，1段) 800g  15
-- 186 新西兰爱他美  15
-- 101 隔尿垫 16
-- 351 月子鞋 17
-- 353 月子服 17
-- 185 月子服纽扣 17
-- 356 嘉宝Gerber婴幼儿辅食 甜薯玉米混合蔬菜泥 二段 6个月以上 113g*2 美国进口  18
-- 357 单人专业小儿全身推拿  20


-- 做活动的商品排在前面
SELECT p1.id, p1.title, p1.sys_cat_id
  , (
    SELECT COUNT(product_id)
    FROM zhihu_groupon_timelimit_product
    WHERE product_id = p1.id
    UNION
    SELECT product_id
    FROM zhihu_groupon_product
    WHERE product_id = p1.id
  ) AS is_groupon
FROM zhihu_product p1
WHERE (
  SELECT COUNT(*)
  FROM zhihu_product p2
  WHERE p1.sys_cat_id = p2.sys_cat_id
    AND p1.id < p2.id
) < 3
ORDER BY is_groupon DESC, sys_cat_id ASC

-- id  title sys_cat_id  is_groupon
-- 101 隔尿垫 16  6
-- 184 第1集 3 1
-- 161 xgw3  14  1
-- 194 月嫂等级  2 0
-- 192 泰式按摩super-plus  2 0
-- 193 2323  2 0
-- 183 第1集1  3 0
-- 350 月子服 3 0
-- 326 推拿SPA 7 0
-- 349 26天月子服务 7 0
-- 103 满月中药熏蒸  7 0
-- 354 尿你一脸  8 0
-- 352 宝宝游泳  14  0
-- 355 爱他美（Aptamil） 婴儿配方奶粉(0–6月龄，1段) 800g  15  0
-- 314 荷兰牛栏  15  0
-- 186 新西兰爱他美  15  0
-- 353 月子服 17  0
-- 351 月子鞋 17  0
-- 185 月子服纽扣 17  0
-- 356 嘉宝Gerber婴幼儿辅食 甜薯玉米混合蔬菜泥 二段 6个月以上 113g*2 美国进口  18  0
-- 357 单人专业小儿全身推拿  20  0


