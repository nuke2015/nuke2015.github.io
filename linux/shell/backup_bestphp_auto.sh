# /bin/bash


#crontab backup-auto
#30 4 * * * flock -xn /tmp/php_bestphp.lock -c "/bin/bash /home/backup_feng_auto.sh"



find /nfs/backup/feng/ -mtime +7 -name "*.tar.gz" -exec rm -f {} \;

cd /nfs/backup/feng/

echo "backup start at $(date)">> auto_backup.log

(ls feng_$(date +%Y_%m_%d).tar.gz || nohup tar -cvzf feng_$(date +%Y_%m_%d).tar.gz /git/feng/online/ > /dev/null & ) || echo "exist!"

echo "done!";

