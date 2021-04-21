# /bin/bash

Mem=$(free -m | awk 'NR==2' | awk '{print $4}')
if [ $Mem -gt 1024 ];
     then
echo "Service memory capacity is normal!" > /dev/null
     else
sync
echo "1" > /proc/sys/vm/drop_caches
echo "2" > /proc/sys/vm/drop_caches
echo "3" > /proc/sys/vm/drop_caches
sync
fi

