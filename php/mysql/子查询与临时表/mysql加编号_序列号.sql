

Select (@i:=@i+1) as RowNum, A.* from ddys_order A,(Select @i:=0) B order by A.id desc limit 0, 10;


RowNum  id  title   status
1   1868    住家月子服务(5天)  1
2   1867    住家月子服务(26天) 1
3   1866    其它服务项目(线下收款)    3
4   1865    短期月子服务  1
5   1863    短期月子服务  1
6   1862    育婴师（1年） 1
7   1861    育婴师（1年） 1
8   1860    家家催乳服务  1
9   1859    育婴师（1年） 1
10  1858    住家月子服务(26天) 1


