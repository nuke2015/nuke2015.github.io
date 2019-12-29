

-- 删除表示
drop table geotest;

-- 建表
CREATE TABLE `geotest` (
  `userid` int(10) NOT NULL,
  `geoaddr` geometry NOT NULL,
  `create_time` datetime DEFAULT NULL,
  UNIQUE KEY `unq_uid` (`userid`),
  SPATIAL KEY `spa_geo` (`geoaddr`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- 入数据
insert geotest values(10000, POINT(116.417480,40.003033), now());

insert geotest values(10001, POINT(116.437480,40.004033), now());

insert geotest values(10002, POINT(116.457480,40.005033), now());

insert geotest values(10003, POINT(116.477480,40.006033), now());



-- 距离查询
SELECT userid
	, ST_Distance_Sphere(POINT(116.4174800000000, 40.0030330000000), geoaddr) AS distance
FROM geotest
WHERE ST_Distance_Sphere(POINT(116.4174800000000, 40.0030330000000), geoaddr) < 5000
ORDER BY distance ASC;
-- userid	distance
-- 10000	0
-- 10001	1707.1384059048478
-- 10002	3414.2518917034054



-- 问题一:阿里云不支持innodb,改成myisam就行了




-- 问题二:空间函数不支持,改成ST_Distance
SELECT userid
	, ST_Distance(POINT(116.4174800000000, 40.0030330000000), geoaddr) * 1000 / 0.0111195 AS distance
FROM geotest
WHERE ST_Distance(POINT(116.4174800000000, 40.0030330000000), geoaddr) < 5000
ORDER BY distance ASC;

-- userid	distance
-- 10000	0
-- 10001	1800.8889243668057
-- 10002	3601.7778487348883
-- 10003	5402.666773101725




-- 虽然，mariadb 可以替代 mysql，但某些函数，mariadb 是没有的。比如，ST_Distance_Sphere 。当然，mariadb 拥有的函数 mysql 也不一定有。

-- 请参考：
-- https://mariadb.com/kb/en/library/function-differences-between-mariadb-102-and-mysql-57/

-- https://mariadb.com/kb/en/library/mysqlmariadb-spatial-support-matrix/

-- 看着 ST_Distance_Sphere 很好用，却不能用。那也没办法，可以试试 ST_DISTANCE 函数。

-- eg:
-- “
-- select ST_Distance_Sphere(ST_GeomFromText(‘Point(115.452081 30.486021)’), position) as distance from ball_invitations

-- select (ST_Distance(GeomFromText(‘Point(115.452081 30.486021)’), position) / 0.0111195) as distance from ball_invitations





