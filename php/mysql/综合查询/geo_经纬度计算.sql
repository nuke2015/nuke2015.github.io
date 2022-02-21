


// 字符串转经纬度
SELECT a.name, a.latitude_longitude
	, substring_index(a.latitude_longitude, ',', 1) AS lat
	, substring_index(a.latitude_longitude, ',', -1) AS lng
FROM xiangyoujiangning_enjoyjnholidayhouse a;


// 已知地点,计算距离,单位是米
SELECT a.name, a.latitude_longitude
	, substring_index(a.latitude_longitude, ',', 1) AS lat
	, substring_index(a.latitude_longitude, ',', -1) AS lng
	, ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN((32.067420 * PI() / 180 - substring_index(a.latitude_longitude, ',', 1) * PI() / 180) / 2), 2) + COS(32.067420 * PI() / 180) * COS(substring_index(a.latitude_longitude, ',', 1) * PI() / 180) * POW(SIN((118.819005 * PI() / 180 - substring_index(a.latitude_longitude, ',', -1) * PI() / 180) / 2), 2))) * 1000) AS juli
FROM xiangyoujiangning_enjoyjnscenicarea a;



-- 用字符串存储经纬度技术
-- -- 数据库
-- {
--     "act": null,
--     "code": 0,
--     "msg": "success",
--     "version": "1.0",
--     "timestamp": 1645414912,
--     "data": {
--         "page": "1",
--         "size": "20",
--         "total": "15",
--         "count": "15",
--         "data": [
--             {
--                 "id": "15",
--                 "shop_title": "大足店",
--                 "create_at": "1645411477",
--                 "update_at": "1645411477",
--                 "status": "1",
--                 "contact": "15823209955",
--                 "address": "重庆市大足区棠香街道五星大道中段198号",
--                 "geo_addr": "105.735741,29.686591",
--                 "about": "",
--                 "weixin": "",
--                 "lat": "105.735741",
--                 "lng": "29.686591",
--                 "juli": "0"
--             },
--             {
--                 "id": "16",
--                 "shop_title": "永川店",
--                 "create_at": "1645411537",
--                 "update_at": "1645411697",
--                 "status": "1",
--                 "contact": "13002331566",
--                 "address": "重庆市永川区香缇时光5栋2单元2-1",
--                 "geo_addr": "105.95863,29.360864",
--                 "about": "",
--                 "weixin": "",
--                 "lat": "105.95863",
--                 "lng": "29.360864",
--                 "juli": "26715"
--             },
            
--             {
--                 "id": "9",
--                 "shop_title": "璧山秀湖鹭岛店",
--                 "create_at": "1645410812",
--                 "update_at": "1645410812",
--                 "status": "1",
--                 "contact": "18725992133",
--                 "address": "重庆市璧山区璧泉街道登云路秀湖鹭岛67幢",
--                 "geo_addr": "106.21058,29.586674",
--                 "about": "",
--                 "weixin": "",
--                 "lat": "106.21058",
--                 "lng": "29.586674",
--                 "juli": "52947"
--             },
--             {
--                 "id": "5",
--                 "shop_title": "璧山金科店",
--                 "create_at": "1645410143",
--                 "update_at": "1645410301",
--                 "status": "1",
--                 "contact": "15123860333",
--                 "address": "重庆市璧山区壁泉山路66号附119号",
--                 "geo_addr": "106.220017,29.593449",
--                 "about": "",
--                 "weixin": "",
--                 "lat": "106.220017",
--                 "lng": "29.593449",
--                 "juli": "53985"
--             },
--             {
--                 "id": "10",
--                 "shop_title": "璧山上海城店",
--                 "create_at": "1645410847",
--                 "update_at": "1645410847",
--                 "status": "1",
--                 "contact": "13634152647",
--                 "address": "重庆市璧山区金剑路91号",
--                 "geo_addr": "106.23935,29.594261",
--                 "about": "",
--                 "weixin": "",
--                 "lat": "106.23935",
--                 "lng": "29.594261",
--                 "juli": "56133"
--             },
--             {
--                 "id": "6",
--                 "shop_title": "璧山皮鞋城店",
--                 "create_at": "1645410773",
--                 "update_at": "1645410773",
--                 "status": "1",
--                 "contact": "15736135395",
--                 "address": "重庆市璧山区皮鞋城三路101号附5号",
--                 "geo_addr": "106.240754,29.600528",
--                 "about": "",
--                 "weixin": "",
--                 "lat": "106.240754",
--                 "lng": "29.600528",
--                 "juli": "56280"
--             },
--         ]
--     }
-- }
-- 实时查询,string(28) "lng=105.735741,lat=29.686591"
SELECT *, substring_index(a.geo_addr, ',', 1) AS lat
    , substring_index(a.geo_addr, ',', -1) AS lng
    , ROUND(6378.138 * 2 * ASIN(SQRT(POW(SIN((105.735741 * PI() / 180 - substring_index(a.geo_addr, ',', 1) * PI() / 180) / 2), 2) + COS(105.735741 * PI() / 180) * COS(substring_index(a.geo_addr, ',', 1) * PI() / 180) * POW(SIN((29.686591 * PI() / 180 - substring_index(a.geo_addr, ',', -1) * PI() / 180) / 2), 2))) * 1000) AS juli
FROM bestphp_shop a
WHERE status = 1

