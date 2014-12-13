exports.index = function(req, res){
	res.render('index',{'data':req.session});
};

exports.set=function(req,res){
	req.session.user=req.body.user;
	req.session.time=new Date().getTime();
	res.redirect('/session/index');
}