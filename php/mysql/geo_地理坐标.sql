



ALTER TABLE `ddys_corp_config`
ADD `geoaddr` geometry NOT NULL COMMENT '坐标(经纬度)';

ALTER TABLE `ddys_corp_config`
CHANGE `geoaddr` `geoaddr` geometry NOT NULL DEFAULT '' COMMENT '坐标(经纬度)' AFTER `seo_keyword`;

ALTER TABLE `ddys_corp_config`
ENGINE='MyISAM';

-- 清空
UPDATE `ddys_corp_config` SET `geoaddr` = POINT(0,0);

-- 加索引
ALTER TABLE `ddys_corp_config`
ADD  SPATIAL KEY `spa_geo` (`geoaddr`);

-- 入一条测试数据
update ddys_corp_config
set geoaddr=POINT(114,82)
where corp_id=2



DROP TABLE IF EXISTS `ddys_corp_geo`;
CREATE TABLE `ddys_corp_geo` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `geoaddr` geometry NOT NULL COMMENT '坐标(经纬度)',
  `create_at` int(11) NOT NULL COMMENT '创建时间',
  `corp_id` int(11) NOT NULL COMMENT '加盟商id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unq_uid` (`id`),
  SPATIAL KEY `spa_geo` (`geoaddr`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商户门店物理地址-经纬度';




-- 入一条测试数据
insert ddys_corp_geo
set geoaddr=POINT(114,82),1596426422,2
where corp_id=2





-- st_distance 函数 
-- st_distance 函数是从mysql5.6.1才加入的。 
SET @g1 = POINT(1,1), @g2 = POINT(2,2); 
select st_distance (@g1, @g2); 
-- 输出结果：1.4142135623730951
SELECT st_distance (point (1, 1),point(2,2) ) * 111195 


-- 坐标代入
-- $longitude = trim($p['longitude']);
-- $latitude = trim($p['latitude']);
$field_geo = "ST_Distance(POINT($longitude, $latitude), sg.geoaddr)/1000 as distance";

-- js描述
-- distance(120.134241, 30.271482, 120.139684, 30.269618); //613.6539808118416
-- sql对应,cg.geoaddr=POINT(30.271482 120.134241) 

-- select
-- corp_id,ST_Distance(POINT(30.269618, 120.139684), cg.geoaddr)*6371000*3.1415926535898/180 as distance
-- from ddys_corp_geo as cg
-- order by distance ASC
-- limit 3



-- select * 
-- from table
-- where x between 116.307852-1km and 116.307852+1km
-- and y between 40.057031-1km and 40.057031+1km

-- // 请注意并且要乘以地球半球,纬度跟纬度,经度跟经度
-- SELECT ST_Distance_Sphere(POINT(lng,lat), POINT(116.307852,40.057031)) as distance
-- FROM table 
-- where distance < 1000


-- SELECT
-- s.id,s.name,s.lng,s.lat,
-- (st_distance (point (lng, lat),point(117.069,35.86) ) *111195) AS distance
-- FROM
-- road_servicearea s
-- HAVING distance<50
-- ORDER BY distanc


