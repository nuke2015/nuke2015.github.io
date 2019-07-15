

explain 
SELECT 
COUNT(DISTINCT `ipv4`) AS `ip`,
COUNT(DISTINCT `uuid`) AS `uv`,
count(DISTINCT `url_md5`) AS `pv`,
COUNT(0) AS `vv`,
COUNT(DISTINCT `uuid`) AS `jump`,
hour_create_at AS `start_at`,
 `club_id`
FROM `tongji_pageview`
GROUP BY hour_create_at



 Modify	ip	uv	pv	vv	jump	start_at	club_id
 编辑	5	10	9	10	10	0	5
 编辑	4	11	8	32	11	1551934800	5
 编辑	1	2	8	40	2	1552093200	5
 编辑	1	3	6	23	3	1552100400	5
 编辑	1	3	18	44	3	1552104000	5
 编辑	1	2	2	4	2	1552125600	5
 编辑	1	1	3	5	1	1552129200	5
 编辑	1	6	9	29	6	1552150800	5
 编辑	1	5	7	17	5	1552266000	5
 编辑	2	23	18	126	23	1552269600	5


id	select_type	table	type	possible_keys	key	key_len	ref	rows	Extra
1	SIMPLE	tongji_pageview	index	hour_create_at	hour_create_at	4	NULL	49328	NULL


问题:
虽然对hour_create_at有index索引,但是全表数据4.9万条.
每次查询也是4.9万条,这不科学.

