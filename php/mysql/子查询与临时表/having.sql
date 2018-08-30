
$sql = <<<doc
select us.user_id_spm,count(distinct(ac.user_id_friend)) as count,
(select sum(money) from ddys_user_spm_account where user_id=us.user_id_spm and status in (1,2)) as money
from ddys_user_spm_sign as us
left join ddys_user_spm_account as ac
on us.user_id_spm=ac.user_id
where us.user_id_spm>0
group by us.user_id_spm
having money>0
doc;

其中的money与count是抽象字段不能用where us.count,us.money之类的,
只能用having 并且having条件是在group by 之后.

