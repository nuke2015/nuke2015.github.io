

-- 这条语句是错误的.
SELECT SQL_CALC_FOUND_ROWS user_id, `create_time`
FROM `zhihu_user_map` `m`
    LEFT JOIN `zhihu_user_info` `u` ON `m`.`user_id` = `u`.`id`
WHERE u.club_id = 2
    AND u.user_name LIKE '%锋%'
    OR phone LIKE '%锋%'
    OR u.id = '锋'
ORDER BY u.id DESC
LIMIT 0, 20

-- 这条语句才是正确的.
SELECT SQL_CALC_FOUND_ROWS user_id, `create_time`
FROM `zhihu_user_map` `m`
    LEFT JOIN `zhihu_user_info` `u` ON `m`.`user_id` = `u`.`id`
WHERE 
u.club_id = 2
AND 
(u.user_name LIKE '%锋%' OR phone LIKE '%锋%'OR u.id = '锋')
ORDER BY u.id DESC
LIMIT 0, 20


