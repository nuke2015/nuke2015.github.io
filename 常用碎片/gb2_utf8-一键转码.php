<?php

convert_files();

#����c:�̴���Ŀ¼:webĿ¼,Ȼ���Ҫת�����ļ�,����web��~!;	
function convert_files($str='c:/web')
{
$dir=opendir($str); //���ļ���
while($any=readdir($dir)){
$path=$str.'/'.$any;
//����Ŀ¼�е��ļ�;
if (is_file($path)){
$file=file_get_contents($path);
$file=iconv("utf-8//IGNORE","gb2312",$file); 
#��������޸�ת�뷽��,Ҫע�����conv�ļ��б�����������,�����ת��ʧ��;
file_put_contents($path,$file);
echo '-->�ļ�: ['.$any.'] ,����ɹ�~<br>';
}
//����Ŀ¼�е�Ŀ¼;
if (is_dir($path) && $any !='.' && $any!='..'){
echo '<hr>������Ŀ¼ ['.$path.'] ,����ת����Ŀ¼!<br>';
convert_files($path);
}
}
echo '####Ŀ¼: ['.$str.'] �������~<br>';
}


