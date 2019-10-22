
-- 原来的查询
SELECT day, start_at, COUNT(*) AS add_user
    , (
        SELECT COUNT(*)
        FROM zhihu_user_info
        WHERE (club_id = 0
            AND status = 1
            AND create_at < start_at + 86400)
    ) AS total_user
FROM (
    SELECT str AS day, t AS start_at
    FROM helper_view_day
    WHERE t <= unix_timestamp(utc_date())
        AND t >= unix_timestamp(utc_date()) - 86400 * 31
    LIMIT 31
) d
    LEFT JOIN (
        SELECT FROM_UNIXTIME(create_at, '%Y-%m-%d') AS day1
        FROM zhihu_user_info
        WHERE status = 1
    ) ui
    ON d.day = ui.day1
WHERE (1
    AND start_at >= 1569859200
    AND start_at + 86400 < 1572537599)
GROUP BY day
LIMIT 31


-- 输出的结果
-- array(31) {
--   [0]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-01"
--     ["start_at"]=>
--     int(1569859200)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(0)
--   }
--   [1]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-02"
--     ["start_at"]=>
--     int(1569945600)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(0)
--   }
--   [2]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-03"
--     ["start_at"]=>
--     int(1570032000)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(0)
--   }
--   [3]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-04"
--     ["start_at"]=>
--     int(1570118400)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(0)
--   }
--   [4]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-05"
--     ["start_at"]=>
--     int(1570204800)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(0)
--   }
--   [5]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-06"
--     ["start_at"]=>
--     int(1570291200)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(0)
--   }
--   [6]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-07"
--     ["start_at"]=>
--     int(1570377600)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(0)
--   }
--   [7]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-08"
--     ["start_at"]=>
--     int(1570464000)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(0)
--   }
--   [8]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-09"
--     ["start_at"]=>
--     int(1570550400)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(0)
--   }
--   [9]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-10"
--     ["start_at"]=>
--     int(1570636800)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(0)
--   }
--   [10]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-11"
--     ["start_at"]=>
--     int(1570723200)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(0)
--   }
--   [11]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-12"
--     ["start_at"]=>
--     int(1570809600)
--     ["add_user"]=>
--     int(1)
--     ["total_user"]=>
--     int(1)
--   }
--   [12]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-13"
--     ["start_at"]=>
--     int(1570896000)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(1)
--   }
--   [13]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-14"
--     ["start_at"]=>
--     int(1570982400)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(1)
--   }
--   [14]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-15"
--     ["start_at"]=>
--     int(1571068800)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(1)
--   }
--   [15]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-16"
--     ["start_at"]=>
--     int(1571155200)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(1)
--   }
--   [16]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-17"
--     ["start_at"]=>
--     int(1571241600)
--     ["add_user"]=>
--     int(2)
--     ["total_user"]=>
--     int(3)
--   }
--   [17]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-18"
--     ["start_at"]=>
--     int(1571328000)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(3)
--   }
--   [18]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-19"
--     ["start_at"]=>
--     int(1571414400)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(3)
--   }
--   [19]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-20"
--     ["start_at"]=>
--     int(1571500800)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(3)
--   }
--   [20]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-21"
--     ["start_at"]=>
--     int(1571587200)
--     ["add_user"]=>
--     int(1)
--     ["total_user"]=>
--     int(4)
--   }
--   [21]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-22"
--     ["start_at"]=>
--     int(1571673600)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(4)
--   }
--   [22]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-23"
--     ["start_at"]=>
--     int(1571760000)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(4)
--   }
--   [23]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-24"
--     ["start_at"]=>
--     int(1571846400)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(4)
--   }
--   [24]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-25"
--     ["start_at"]=>
--     int(1571932800)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(4)
--   }
--   [25]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-26"
--     ["start_at"]=>
--     int(1572019200)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(4)
--   }
--   [26]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-27"
--     ["start_at"]=>
--     int(1572105600)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(4)
--   }
--   [27]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-28"
--     ["start_at"]=>
--     int(1572192000)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(4)
--   }
--   [28]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-29"
--     ["start_at"]=>
--     int(1572278400)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(4)
--   }
--   [29]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-30"
--     ["start_at"]=>
--     int(1572364800)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(4)
--   }
--   [30]=>
--   array(4) {
--     ["day"]=>
--     string(10) "2019-10-31"
--     ["start_at"]=>
--     int(1572451200)
--     ["add_user"]=>
--     int(0)
--     ["total_user"]=>
--     int(4)
--   }
-- }


-- 优化成,只取目标数据,剩下的空数据,通过php进行格式化
SELECT COUNT(*) AS count, FROM_UNIXTIME(create_at, '%Y-%m-%d') AS day
FROM zhihu_user_info
WHERE (status = 1
    AND create_at >= 1569859200
    AND create_at + 86400 < 1572537599)
GROUP BY day


