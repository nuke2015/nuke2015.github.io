

-- �˰汾,ȡ�����ԵĻظ���һ��,��ʱ�䵹��.
select id,user_id,pid,content,update_at,user_id,count_view,count_comment,is_buy,price from (select * from ddys_ask_special where pid in (96,8,84,90,12,83) order by is_buy DESC,id DESC)_ group by pid 
-- ������:
id,user_id,pid,content,update_at,user_id,count_view,count_comment,is_buy,price
6,1,8,"������һ���Ƚ�ʹ��Ĺ���,��ʱ��ı����Ѿ�ϰ����ĸ��ι��,������ȫϰ�߸ĳ��� ��ʳƷ,һ�㷴Ӧ�����ֿ��ֳ�,���ðְ������Ƿǳ����ꡣ",1470207541,1,0,0,1,0.00
92,1,12,ʲô�������������±�?,1470388123,1,0,0,0,0.00
89,37,83,"�����ϰ��հ�,����������.",1470387886,37,0,0,0,0.00
94,37,84,���涺,1470388533,37,0,0,0,0.00
93,37,90,û�Թ�.,1470388521,37,0,0,0,0.00
97,37,96,"���ᶼҪǮ��,����ʲô���.",1470395297,37,0,0,0,0.00

