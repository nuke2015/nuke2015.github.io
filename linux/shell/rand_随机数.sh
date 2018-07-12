#!/bin/bash
 
#随机数,表示随机一个3以内的数
randNum=$(($RANDOM%3))
if [[ $randNum == 1 ]]
then
echo 'cache' ${randNum}
else 
echo 'lost' ${randNum}
fi
