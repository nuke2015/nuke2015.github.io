<?
$f=fopen('filelist.txt','r');
$newline='';
$count=0;
$g=0;
while(!feof($f)){
	$line=fgets($f);
	preg_match('|(.*)\\\\|',$line,$rs);
	if ($newline!=$rs[0]){
		$newline=$rs[0];
		$count++;
		$g=0;
		$img[$count]=$line;
		}else{
		if($g>0){
			$ga[$count].=';'.$line;}
			else{
			$ga[$count]=$line;
			$g++;
		}
	}
}
?>