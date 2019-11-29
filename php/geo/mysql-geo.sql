

-- 删除表示
drop table geotest;

-- 建表
CREATE TABLE `geotest` (
  `userid` int(10) NOT NULL,
  `geoaddr` geometry NOT NULL,
  `create_time` datetime DEFAULT NULL,
  UNIQUE KEY `unq_uid` (`userid`),
  SPATIAL KEY `spa_geo` (`geoaddr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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


