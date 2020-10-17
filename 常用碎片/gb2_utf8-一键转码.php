<?php

convert_files();

#请在c:盘创建目录:web目录,然后把要转换的文件,放在web中~!;	
function convert_files($str='c:/web')
{
$dir=opendir($str); //打开文件夹
while($any=readdir($dir)){
$path=$str.'/'.$any;
//处理目录中的文件;
if (is_file($path)){
$file=file_get_contents($path);
$file=iconv("utf-8//IGNORE","gb2312",$file); 
#上面这句修改转码方向,要注意的是conv文件夹必须有码表存在,否则会转码失败;
file_put_contents($path,$file);
echo '-->文件: ['.$any.'] ,处理成功~<br>';
}
//处理目录中的目录;
if (is_dir($path) && $any !='.' && $any!='..'){
echo '<hr>发现子目录 ['.$path.'] ,立即转入子目录!<br>';
convert_files($path);
}
}
echo '####目录: ['.$str.'] 处理完成~<br>';
}


