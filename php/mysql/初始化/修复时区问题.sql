
-- 解决mysql少了8个小时的问题
select now();
set global time_zone = '+8:00';
flush privileges;
select now();


