
exports.index = function(req, res){
    res.render("index",{});
};

exports.check = function(req,res){
    user=req.body.user;
    pwd=req.body.pwd;
    if( user === 'admin' && pwd == 'admin'){
        req.session.user = user; //保存登陆信息;
        res.redirect("/index/index");
    }else{
        res.send('用户名或密码不正确!');
    }
}

exports.logout = function(req,res){
    req.session.user = '';
    res.redirect("/login/index");
}

