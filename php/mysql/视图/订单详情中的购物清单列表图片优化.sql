

explain
SELECT COUNT(*) AS count
FROM (
	SELECT os.id, od.id AS order_id, od.club_id, od.serial_no AS order_serial_no, od.status AS status_order
		, od.status_pay, og.price_market, og.price_real, v.thumb, os.pr_title
		, os.user_id, os.amount, os.amount_done, os.create_at, os.status
		, og.title AS title_goods
	FROM zhihu_order_service os
		LEFT JOIN zhihu_order_goods og ON os.order_goods_id = og.id
		LEFT JOIN zhihu_order od ON os.order_id = od.id
		LEFT JOIN view_thumb_from_order_goods v ON og.id = v.goods_id
	WHERE os.user_id = 5726
		AND os.club_id = 176
) _


id	select_type	table	type	possible_keys	key	key_len	ref	rows	Extra
1	PRIMARY	<derived2>	ALL	NULL	NULL	NULL	NULL	10	NULL
2	DERIVED	os	ref	user_id	user_id	4	const	1	Using where
2	DERIVED	og	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.os.order_goods_id	1	NULL
2	DERIVED	od	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.os.order_id	1	NULL
2	DERIVED	<derived3>	ref	<auto_key0>	<auto_key0>	4	didiys_tester.og.id	10	NULL
3	DERIVED	og	ALL	NULL	NULL	NULL	NULL	12887	Using where
3	DERIVED	pa	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.og.refer_id	1	NULL
4	UNION	og	ALL	NULL	NULL	NULL	NULL	12887	Using where
4	UNION	pr	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.og.refer_id	1	NULL
5	UNION	og	ALL	NULL	NULL	NULL	NULL	12887	Using where
5	UNION	pa	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.og.refer_id	1	NULL
5	UNION	pr	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.pa.product_id	1	Using index
5	UNION	pr	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.pr.id	1	NULL
NULL	UNION RESULT	<union3,4,5>	ALL	NULL	NULL	NULL	NULL	NULL	Using temporary


-- 拆分
explain

	SELECT os.id, od.id AS order_id, od.club_id, od.serial_no AS order_serial_no, od.status AS status_order
		, od.status_pay, og.price_market, og.price_real, v.thumb, os.pr_title
		, os.user_id, os.amount, os.amount_done, os.create_at, os.status
		, og.title AS title_goods
	FROM zhihu_order_service os
		LEFT JOIN zhihu_order_goods og ON os.order_goods_id = og.id
		LEFT JOIN zhihu_order od ON os.order_id = od.id
		LEFT JOIN view_thumb_from_order_goods v ON og.id = v.goods_id
	WHERE os.user_id = 5726
		AND os.club_id = 176
id	select_type	table	type	possible_keys	key	key_len	ref	rows	Extra
1	PRIMARY	os	ref	user_id	user_id	4	const	1	Using where
1	PRIMARY	og	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.os.order_goods_id	1	NULL
1	PRIMARY	od	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.os.order_id	1	NULL
1	PRIMARY	<derived2>	ref	<auto_key0>	<auto_key0>	4	didiys_tester.og.id	10	NULL
2	DERIVED	og	ALL	NULL	NULL	NULL	NULL	12887	Using where
2	DERIVED	pa	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.og.refer_id	1	NULL
3	UNION	og	ALL	NULL	NULL	NULL	NULL	12887	Using where
3	UNION	pr	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.og.refer_id	1	NULL
4	UNION	og	ALL	NULL	NULL	NULL	NULL	12887	Using where
4	UNION	pa	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.og.refer_id	1	NULL
4	UNION	pr	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.pa.product_id	1	Using index
4	UNION	pr	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.pr.id	1	NULL
NULL	UNION RESULT	<union2,3,4>	ALL	NULL	NULL	NULL	NULL	NULL	Using temporary




-- 涉及到视图,view_thumb_from_order_goods
SELECT `og`.`id` AS `goods_id`, `og`.`refer_id` AS `refer_id`, `og`.`refer_type` AS `refer_type`, `pr`.`thumb` AS `thumb`, `og`.`club_id` AS `club_id`
FROM `zhihu_order_goods` `og`
	LEFT JOIN `zhihu_product` `pr` ON `og`.`refer_id` = `pr`.`id` and og.refer_type=1
WHERE `og`.`refer_type` = 1
UNION
SELECT `og`.`id` AS `goods_id`, `og`.`refer_id` AS `refer_id`, `og`.`refer_type` AS `refer_type`, `pr`.`thumb` AS `thumb`, `og`.`club_id` AS `club_id`
FROM `zhihu_order_goods` `og`
	LEFT JOIN `view_to_product_from_attrsku` `v` ON `og`.`refer_id` = `v`.`pa_id`
	LEFT JOIN `zhihu_product` `pr` ON `v`.`pr_id` = `pr`.`id` and og.refer_type=2
WHERE `og`.`refer_type` = 2

把zhihu_order_goods优化加上索引refer_id后,从0.483降到0.1秒.但仍然没达到上线标准(三个0).





explain
SELECT `og`.`id` AS `goods_id`, `og`.`refer_id` AS `refer_id`, `og`.`refer_type` AS `refer_type`, `pr`.`thumb` AS `thumb`, `og`.`club_id` AS `club_id`
FROM `zhihu_order_goods` `og`
	LEFT JOIN `zhihu_product` `pr` ON `og`.`refer_id` = `pr`.`id`
WHERE `og`.`refer_type` = 1

id	select_type	table	type	possible_keys	key	key_len	ref	rows	Extra
1	SIMPLE	og	ALL	NULL	NULL	NULL	NULL	12887	Using where
1	SIMPLE	pr	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.og.refer_id	1	NULL

rows太大了.有问题




-- 看来得改写这个视图了,view_thumb_from_order_goods
SELECT `og`.`id` AS `goods_id`, `og`.`refer_id` AS `refer_id`, `og`.`refer_type` AS `refer_type`, `pr`.`thumb` AS `thumb`, `og`.`club_id` AS `club_id`
FROM `zhihu_product` `pr`
	LEFT JOIN `zhihu_order_goods` `og`
	ON `pr`.`id` = `og`.`refer_id`
		AND og.refer_type = 1
WHERE og.id > 0
	AND og.refer_type = 1
UNION
SELECT og.id, og.refer_id, og.refer_type, pr.thumb, og.club_id
FROM zhihu_product_attrsku pa
	LEFT JOIN zhihu_product pr ON pa.product_id = pa.id
	LEFT JOIN `zhihu_order_goods` `og`
	ON `pa`.`id` = `og`.`refer_id`
		AND og.refer_type = 2
WHERE og.id > 0
	AND og.refer_type = 2


-- 效果不明显还是一样,说明数据量是一样的.

id	select_type	table	type	possible_keys	key	key_len	ref	rows	Extra
1	PRIMARY	og	range	PRIMARY,refer_id,refer_type	PRIMARY	4	NULL	6443	Using where
1	PRIMARY	pr	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.og.refer_id	1	NULL
2	UNION	pa	index	PRIMARY	product_id	4	NULL	14	Using index
2	UNION	og	ref	PRIMARY,refer_id,refer_type	refer_id	4	didiys_tester.pa.id	8	Using index condition; Using where
2	UNION	pr	ALL	NULL	NULL	NULL	NULL	1729	Using where; Using join buffer (Block Nested Loop)
NULL	UNION RESULT	<union1,2>	ALL	NULL	NULL	NULL	NULL	NULL	Using temporary

-- 扫描涉及的rows有所减少但是总体性能还是不理想






-- 再改,view_thumb_from_order_goods
SELECT `og`.`id` AS `goods_id`, `og`.`refer_id` AS `refer_id`, `og`.`refer_type` AS `refer_type`, `pr`.`thumb` AS `thumb`, `og`.`club_id` AS `club_id`
FROM `zhihu_order_goods` `og`
	LEFT JOIN `zhihu_product` `pr` ON `og`.`refer_id` = `pr`.`id` and og.refer_type=1
WHERE `og`.`refer_type` = 1 
UNION
SELECT `og`.`id` AS `goods_id`, `og`.`refer_id` AS `refer_id`, `og`.`refer_type` AS `refer_type`, `pr`.`thumb` AS `thumb`, `og`.`club_id` AS `club_id`
FROM `zhihu_order_goods` `og`
	LEFT JOIN `view_to_product_from_attrsku` `v` ON `og`.`refer_id` = `v`.`pa_id`
	LEFT JOIN `zhihu_product` `pr` ON `v`.`pr_id` = `pr`.`id` and og.refer_type=2
WHERE `og`.`refer_type` = 2

-- 拆分分开执行,居然第一条更慢.

id	select_type	table	type	possible_keys	key	key_len	ref	rows	Extra
1	SIMPLE	og	ALL	refer_type	NULL	NULL	NULL	12887	Using where
1	SIMPLE	pr	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.og.refer_id	1	NULL

id	select_type	table	type	possible_keys	key	key_len	ref	rows	Extra
1	SIMPLE	og	ref	refer_type	refer_type	1	const	384	NULL
1	SIMPLE	pa	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.og.refer_id	1	NULL
1	SIMPLE	pr	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.pa.product_id	1	Using index
1	SIMPLE	pr	eq_ref	PRIMARY	PRIMARY	4	didiys_tester.pr.id	1	NULL

-- 也许是因为目前的业务发展情况,第二种积累的数据量比较少.


这个视图已经优化到极限了,
如果进一步优化,只有把视图删除,把提数据的sql语句放到代码里,在查询的时候,进行where控制,这样就能减少表格扫描的行数.
另一个解决的办法是:删除视图,把thumb做到基础表结构里面去.


