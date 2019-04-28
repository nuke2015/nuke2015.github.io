说明
fslog.php是业务脚本.
fslog.bat是调用入口.全局可直接调用
fslog.bat abc abc abc 能记录所有参数.

post-commit.bat是钩子文件
把它放在svn的项目目录中的hooks就能执行了.
它是提交后触发的.


