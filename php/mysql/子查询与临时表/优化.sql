

-- 此版本,取出各自的回复第一条,按时间倒序.
select id,user_id,pid,content,update_at,user_id,count_view,count_comment,is_buy,price from (select * from ddys_ask_special where pid in (96,8,84,90,12,83) order by is_buy DESC,id DESC)_ group by pid 
-- 运算结果:
id,user_id,pid,content,update_at,user_id,count_view,count_comment,is_buy,price
6,1,8,"断奶是一件比较痛苦的过程,这时候的宝宝已经习惯了母乳喂养,还不完全习惯改吃其 他食品,一般反应都是又哭又吵,会让爸爸妈妈们非常烦躁。",1470207541,1,0,0,1,0.00
92,1,12,什么是世界上最大的月饼?,1470388123,1,0,0,0,0.00
89,37,83,"咱们老百姓啊,今个儿真高兴.",1470387886,37,0,0,0,0.00
94,37,84,你真逗,1470388533,37,0,0,0,0.00
93,37,90,没吃过.,1470388521,37,0,0,0,0.00
97,37,96,"不会都要钱吧,这是什么情况.",1470395297,37,0,0,0,0.00

-- 延伸需求.每组各取三条,排序可自定义

