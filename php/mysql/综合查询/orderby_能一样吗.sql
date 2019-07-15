

-- 0.3秒
SELECT 
COUNT(DISTINCT `ipv4`) AS `ip`,
COUNT(DISTINCT `uuid`) AS `uv`,
count(distinct `url_md5`) AS `pv`,
COUNT(0) AS `vv`,
COUNT(DISTINCT `uuid`) AS `jump`,
unix_timestamp(`t_create_at`) AS `start_at`, 
`club_id` AS `club_id`
FROM `tongji_pageview` `tp`
GROUP BY t_create_at

-- 0.7秒
SELECT 
COUNT(DISTINCT `ipv4`) AS `ip`,
COUNT(DISTINCT `uuid`) AS `uv`,
count(distinct `url_md5`) AS `pv`,
COUNT(0) AS `vv`,
COUNT(DISTINCT `uuid`) AS `jump`,
unix_timestamp(`t_create_at`) AS `start_at`, 
`club_id` AS `club_id`
FROM `tongji_pageview` `tp`
GROUP BY start_at

