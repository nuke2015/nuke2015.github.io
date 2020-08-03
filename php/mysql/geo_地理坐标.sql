



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


