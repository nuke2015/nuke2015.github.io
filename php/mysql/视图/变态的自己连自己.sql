


-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `bestphp_address_areainfo`;
CREATE TABLE `bestphp_address_areainfo` (
  `id` int(11) NOT NULL COMMENT '主键',
  `code` int(11) NOT NULL COMMENT '区域编码',
  `belong_code` int(11) NOT NULL COMMENT '上级区域',
  `city_name` varchar(50) NOT NULL COMMENT '区域名称',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='省份城市区县三级联动表.';


-- 2018-06-15 14:47:36


-- 举个例子
 -- Modify id  code    belong_code city_name
 -- 编辑 0   100000  0   北京
 -- 编辑 1   100073  0   上海
 -- 编辑 2   100168  0   天津
 -- 编辑 3   100216  0   重庆
 -- 编辑 4   101254  0   河北省
 -- 编辑 5   101439  0   山西省
 -- 编辑 6   101570  0   河南省
 -- 编辑 7   101770  0   辽宁省
 -- 编辑 8   101890  0   吉林省



-- 变态的自己连自己
select a.id,
a.code as town_code,a.city_name as town_name,
b.code as city_code,b.city_name as city_name,
c.code as province_code,c.city_name as province_name
from bestphp_address_areainfo as a
left join bestphp_address_areainfo as b
on a.belong_code=b.code
left join bestphp_address_areainfo as c
on b.belong_code=c.code


-- 得到数据,举个例子
-- 2095   103213  南山区 103212  深圳市 103198  广东省
-- 2096    103214  罗湖区 103212  深圳市 103198  广东省
-- 2097    103215  福田区 103212  深圳市 103198  广东省
-- 2098    103216  宝安区 103212  深圳市 103198  广东省
-- 2099    103217  光明新区    103212  深圳市 103198  广东省
-- 2100    103218  龙岗区 103212  深圳市 103198  广东省
-- 2101    103219  坪山新区    103212  深圳市 103198  广东省
-- 2102    103220  大鹏新区    103212  深圳市 103198  广东省
-- 2103    103221  盐田区 103212  深圳市 103198  广东省
-- 2104    103222  龙华新区    103212  深圳市 103198  广东省






