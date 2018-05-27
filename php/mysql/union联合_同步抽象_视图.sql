

-- 收入表与支出表是分开设计的,结构完全不同.但是用户消费与支出同步输出.
SELECT id,user_id,if(1,"1","-1") as abs,money,type,create_at,status from bestphp_account_in where user_id=1
UNION
SELECT id,user_id,if(0,"1","-1") as abs,money,type,create_at,status from bestphp_account_out where user_id=1


