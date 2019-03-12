

-- 产生1-1000的序列数
use test
drop table if exists seq1000;
create table seq1000
(x int not null auto_increment primary key);
insert into seq1000 values ();
set @p= -1;
set @p=@p+1; insert into seq1000 select x+power(2,@p) from seq1000 where (x+power(2,@p)) <= 1000;
set @p=@p+1; insert into seq1000 select x+power(2,@p) from seq1000 where (x+power(2,@p)) <= 1000;
set @p=@p+1; insert into seq1000 select x+power(2,@p) from seq1000 where (x+power(2,@p)) <= 1000;
set @p=@p+1; insert into seq1000 select x+power(2,@p) from seq1000 where (x+power(2,@p)) <= 1000;
set @p=@p+1; insert into seq1000 select x+power(2,@p) from seq1000 where (x+power(2,@p)) <= 1000;
set @p=@p+1; insert into seq1000 select x+power(2,@p) from seq1000 where (x+power(2,@p)) <= 1000;
set @p=@p+1; insert into seq1000 select x+power(2,@p) from seq1000 where (x+power(2,@p)) <= 1000;
set @p=@p+1; insert into seq1000 select x+power(2,@p) from seq1000 where (x+power(2,@p)) <= 1000;
set @p=@p+1; insert into seq1000 select x+power(2,@p) from seq1000 where (x+power(2,@p)) <= 1000;
set @p=@p+1; insert into seq1000 select x+power(2,@p) from seq1000 where (x+power(2,@p)) <= 1000;
select * from seq1000;

