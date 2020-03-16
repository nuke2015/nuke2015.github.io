

delete from jiazhen_skiller_sku_map

-- 批量的从旧表
-- 表: jiazhen_config_skiller
-- 分离出skiller_id+sku_id,并且入库到新的数据表jiazhen_skiller_sku_map中.



-- 表: jiazhen_config_skiller
-- 列	类型	注释
-- id	int(11) 自动增量	主键id
-- skiller_id	int(11)	技师id
-- create_at	int(11)	添加时间
-- update_at	int(11)	更新时间
-- status	tinyint(1)	状态[-1删除0草稿1正常]
-- config_id	int(11)	配置id
-- club_id	int(11)	归属公司id
-- sku_id	int(11) [0]	sku主键,iazhen_jjmy_product_dict_sku.id

-- 表: jiazhen_skiller_sku_map
-- 列	类型	注释
-- id	int(11) 自动增量	主键id
-- skiller_id	int(11)	技师jiazhen_skiller.id
-- product_dict_sku_id	int(11)	配置信息jiazhen_jjmy_product_dict_sku.id



INSERT INTO jiazhen_skiller_sku_map (id, skiller_id, product_dict_sku_id)
SELECT 0, skiller_id, sku_id FROM jiazhen_config_skiller where sku_id>0 and status=1


