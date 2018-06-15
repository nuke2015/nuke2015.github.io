

-- 这个不能加club_id
select sum(ai.money),user_id from zhihu_account_in as ai group by user_id

-- 查询出错 (1055): Expression #3 of SELECT list is not in GROUP BY clause and contains nonaggregated column 'zhihukeji.ai.club_id' which is not functionally dependent on columns in GROUP BY clause; this is incompatible with sql_mode=only_full_group_by
select sum(ai.money),user_id,club_id from zhihu_account_in as ai group by user_id

-- 但是这个可以.
SELECT SUM(`ai`.`money`) AS `account_in`, `ui`.`id` AS `user_id`, `ui`.`club_id` AS `club_id`
FROM `zhihu_account_in` `ai`
    LEFT JOIN `zhihu_user_info` `ui` ON `ui`.`id` = `ai`.`user_id`
WHERE `ui`.`id` > 0
GROUP BY `ui`.`id`

