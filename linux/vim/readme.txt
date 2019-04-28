apt-get install git
安装bundle
git clone https://github.com/gmarik/vundle.git ~/.vim/bundle/vundle

复制_vimrc到/etc/vim/vimrc文件中

然后 打开vim
执行:BundleInstall
它会自动安装相关插件

再次打开提示ctags没有
apt-get install -y exuberant-ctags cscope



"  锋子兼容sublime的配置;
" 上移一行ctrl+shift+up
nnoremap <C-S-Up> dd2kp
" 下移一行ctrl+shift+down
nnoremap <C-S-Down> ddp


