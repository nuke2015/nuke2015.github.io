


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

