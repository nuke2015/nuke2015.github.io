exports.index = function(req, res){
	res.render('index',{'data':req.cookies});
};

exports.set=function(req,res){
	u=req.body.user
	res.cookie('user',u);
	res.cookie('time',new Date().getTime());
	res.redirect('/cookie/index');
}