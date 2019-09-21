
-- 记一次慢查询优化过程 
-- 0.038
SELECT COUNT(*) AS count
FROM (
	SELECT user_info.id, user_info.user_name, user_info.phone, user_info.customer_origin, user_info.first_source
		, user_info.status_live, user_info.create_at, user_info.schedule_date, user_info.idcard, user_map.create_time
		, IFNULL(user_belong.category, 0) AS category, member.name AS saler_name
		, IFNULL(attention_user.status, 0) AS attension
	FROM zhihu_user_info user_info
		LEFT JOIN zhihu_user_map user_map ON user_info.id = user_map.user_id
		LEFT JOIN zhihu_user_belong user_belong
		ON user_belong.user_id = user_info.id
			AND user_belong.status = 1
		LEFT JOIN zhihu_group_member group_member
		ON user_belong.group_member_id = group_member.id
			AND group_member.group_id IN (3, 6, 12)
		LEFT JOIN zhihu_member member
		ON member.id = group_member.member_id
			AND member.status = 1
		LEFT JOIN zhihu_attention_user attention_user
		ON attention_user.user_id = user_info.id
			AND attention_user.member_id = 960
		LEFT JOIN zhihu_user_label_map user_label_map ON user_label_map.user_id = user_info.id
		LEFT JOIN zhihu_user_will_map user_will_map ON user_will_map.user_id = user_info.id
	WHERE (user_info.club_id = 131
			AND user_info.status = 1
			AND user_info.phone != ''
			AND user_info.id NOT IN (
				SELECT user_id
				FROM zhihu_user_collect_pool
				WHERE club_id = 131
			)
			AND (user_info.user_name LIKE '%BabyYuqianqian%'
				OR user_info.phone LIKE '%BabyYuqianqian%')
		)
	GROUP BY user_info.id
) _



-- 0.273
SELECT COUNT(*) AS count
FROM (
	SELECT user_info.id, user_info.user_name, user_info.phone, user_info.customer_origin, user_info.first_source
		, user_info.status_live, user_info.create_at, user_info.schedule_date, user_info.idcard, user_map.create_time
		, IFNULL(user_belong.category, 0) AS category, member.name AS saler_name
		, IFNULL(attention_user.status, 0) AS attension
	FROM zhihu_user_info user_info
		LEFT JOIN zhihu_user_map user_map ON user_info.id = user_map.user_id
		LEFT JOIN zhihu_user_belong user_belong
		ON user_belong.user_id = user_info.id
			AND user_belong.status = 1
		LEFT JOIN zhihu_group_member group_member
		ON user_belong.group_member_id = group_member.id
			AND group_member.group_id IN (3, 6, 12)
		LEFT JOIN zhihu_member member
		ON member.id = group_member.member_id
			AND member.status = 1
		LEFT JOIN zhihu_attention_user attention_user
		ON attention_user.user_id = user_info.id
			AND attention_user.member_id = 960
		LEFT JOIN zhihu_user_label_map user_label_map ON user_label_map.user_id = user_info.id
		LEFT JOIN zhihu_user_will_map user_will_map ON user_will_map.user_id = user_info.id
	WHERE (user_info.club_id = 131
		AND user_info.status = 1
		AND user_info.phone != ''
		AND user_info.id NOT IN (
			SELECT user_id
			FROM zhihu_user_collect_pool
			WHERE club_id = 131
		)
	)
	GROUP BY user_info.id
) _

-- 0.002
SELECT user_info.id, user_info.user_name, user_info.phone, user_info.customer_origin, user_info.first_source
		, user_info.status_live, user_info.create_at, user_info.schedule_date, user_info.idcard, user_map.create_time
		, IFNULL(user_belong.category, 0) AS category, member.name AS saler_name
		, IFNULL(attention_user.status, 0) AS attension
FROM zhihu_user_info user_info
	LEFT JOIN zhihu_user_map user_map ON user_info.id = user_map.user_id
	LEFT JOIN zhihu_user_belong user_belong
	ON user_belong.user_id = user_info.id
		AND user_belong.status = 1
	LEFT JOIN zhihu_group_member group_member
	ON user_belong.group_member_id = group_member.id
		AND group_member.group_id IN (3, 6, 12)
	LEFT JOIN zhihu_member member
	ON member.id = group_member.member_id
		AND member.status = 1
	LEFT JOIN zhihu_attention_user attention_user
	ON attention_user.user_id = user_info.id
		AND attention_user.member_id = 960
	LEFT JOIN zhihu_user_label_map user_label_map ON user_label_map.user_id = user_info.id
	LEFT JOIN zhihu_user_will_map user_will_map ON user_will_map.user_id = user_info.id
WHERE (user_info.club_id = 131
	AND user_info.status = 1
	AND user_info.phone != ''
	AND user_info.id NOT IN (
		SELECT user_id
		FROM zhihu_user_collect_pool
		WHERE club_id = 131
	)
)
GROUP BY user_info.id
limit 20

-- 0.036
select id from zhihu_user_info as user_info 
	WHERE user_info.club_id = 131
		AND user_info.status = 1
		AND user_info.phone != ''
		AND user_info.id NOT IN (
			SELECT user_id
			FROM zhihu_user_collect_pool
			WHERE club_id = 131
		)
		AND (user_info.user_name LIKE '%BabyYuqianqian%'
			OR user_info.phone LIKE '%BabyYuqianqian%')
limit 5

-- 0.001
select id from zhihu_user_info as user_info 
	WHERE user_info.club_id = 131
		AND user_info.status = 1
		AND user_info.phone != ''
		AND user_info.id NOT IN (
			SELECT user_id
			FROM zhihu_user_collect_pool
			WHERE club_id = 131
		)
limit 5

-- 0.034
select id from zhihu_user_info as user_info 
	WHERE user_info.club_id = 131
		AND (user_info.user_name LIKE '%BabyYuqianqian%'
			OR user_info.phone LIKE '%BabyYuqianqian%')
limit 5

-- 加索引测试,无效果,因为user_name是vachar字段,重点是like
ALTER TABLE `zhihu_user_info`
ADD INDEX `user_name` (`user_name`);


-- 0.034
select id from zhihu_user_info as user_info
WHERE (user_info.club_id = 131
		AND user_info.status = 1
		AND user_info.phone != ''
		AND user_info.id NOT IN (
			SELECT user_id
			FROM zhihu_user_collect_pool
			WHERE club_id = 131
		)
		AND (user_info.user_name LIKE '%BabyYuqianqian%'
			OR user_info.phone LIKE '%BabyYuqianqian%'))
limit 20



-- 0.035
SELECT COUNT(*) AS count
FROM (
	SELECT user_info.id, user_info.user_name, user_info.phone, user_info.customer_origin, user_info.first_source
		, user_info.status_live, user_info.create_at, user_info.schedule_date, user_info.idcard, user_map.create_time
		, IFNULL(user_belong.category, 0) AS category, member.name AS saler_name
		, IFNULL(attention_user.status, 0) AS attension
	FROM zhihu_user_info user_info
		LEFT JOIN zhihu_user_map user_map ON user_info.id = user_map.user_id
		LEFT JOIN zhihu_user_belong user_belong
		ON user_belong.user_id = user_info.id
			AND user_belong.status = 1
		LEFT JOIN zhihu_group_member group_member
		ON user_belong.group_member_id = group_member.id
			AND group_member.group_id IN (3, 6, 12)
		LEFT JOIN zhihu_member member
		ON member.id = group_member.member_id
			AND member.status = 1
		LEFT JOIN zhihu_attention_user attention_user
		ON attention_user.user_id = user_info.id
			AND attention_user.member_id = 960
		LEFT JOIN zhihu_user_label_map user_label_map ON user_label_map.user_id = user_info.id
		LEFT JOIN zhihu_user_will_map user_will_map ON user_will_map.user_id = user_info.id
	WHERE user_info.id in 
	(
		select id from zhihu_user_info as user_info
		WHERE (user_info.club_id = 131
				AND user_info.status = 1
				AND user_info.phone != ''
				AND user_info.id NOT IN (
					SELECT user_id
					FROM zhihu_user_collect_pool
					WHERE club_id = 131
				)
				AND (user_info.user_name LIKE '%BabyYuqianqian%'
					OR user_info.phone LIKE '%BabyYuqianqian%'))
	)
	GROUP BY user_info.id
) _


-- 那就只剩下一个问题了,就是mysql的like查询如何优化.0.035和他0.034
-- 结论,用elastic search

