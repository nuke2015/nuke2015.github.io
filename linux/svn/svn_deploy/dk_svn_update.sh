# /bin/bash



#更新并同步覆盖,只读操作
svn update /svn_read --username myuser --password hello --force --no-auth-cache 
rsync -av --exclude-from=/svn_rsync_exclude.list --delete /svn_read /www/




echo done! @$(date);
