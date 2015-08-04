<?php

//修改文件头
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=choujiang{$date}.xls");

echo <<<EOF
<table>
	<tr>
		<td>1</td>
		<td>测试</td>
		<td>号码</td>
	</tr>
	<tr>
		<td>1</td>
		<td>测试</td>
		<td>号码</td>
	</tr>
	<tr>
		<td>1</td>
		<td>测试</td>
		<td>号码</td>
	</tr>
	<tr>
		<td>1</td>
		<td>测试</td>
		<td>号码</td>
	</tr>
	<tr>
		<td>1</td>
		<td>测试</td>
		<td>号码</td>
	</tr>
</table>
EOF;
