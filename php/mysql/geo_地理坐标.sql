



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

