
exports.index = function(req, res){
    checklogin(req,res);
    m('shop').find({}).toArray(function (err, result){
        if(!err){
            res.render('index', {shops:result,data:[]});
        }else{
            //没连接上;
            res.send("mongodb please!");
        }
    });
};

exports.insert = function(req, res){
	checklogin(req,res);
    var post=req.body;
	var data = {
      'username': post.username,
      'password': post.password,
      'type': post.type,
      'remark': post.remark,
      'css': '',
    };
	m('shop').insert(data, function (err, result) {
      if (!err) {
        res.redirect('/index/index');
      }else{
		console.log("err");
	  }
    });
};

exports.edit = function(req, res){
    checklogin(req,res);
	var shop=m('shop');
	shop.find({}).toArray(function (err, shops){
		shop.findOne({'_id': shop.ObjectID.createFromHexString(req.query.id)}, function (err, shop){
			res.render('index',{"data":shop,"shops":shops});
		});
	});
};

exports.update=function(req,res,next){
    checklogin(req,res);
	var post=req.body;
	var data = {
      'username': post.username,
      'password': post.password,
      'type': post.type,
      'remark': post.remark,
      'css': '',
    };
	var  shop=m('shop');
	shop.update({'_id':shop.ObjectID.createFromHexString(req.body.id)},data,function(err){
		if(!err){
			res.redirect('/index/index');
		}else{
			next();
		}
	})
}

exports.remove=function(req,res,next){
    checklogin(req,res);
	var shop=m('shop');
	shop.remove({"_id": shop.ObjectID.createFromHexString(req.query.id)}, function (err, result) {
		if(!err){
			res.redirect('/index/index');
		}else{
			next();
		}
	});
}

exports.vpnok=function(req,res,next){
    checklogin(req,res);
    m('shop').find({}).toArray(function (err,data){
        var txt="# Secrets for authentication using CHAP\r\n";
        txt+="#锋速VPN,全球领先!\r\n";
        for(i in data){
            var item=data[i];
            txt+=item['username']+" "+item['type']+" "+item['password']+" * \r\n";
        }
        //file_put_contents("/etc/ppp/vpn.txt",txt);
        file_put_contents("vpn.txt",txt);
        res.redirect('/index/index');    
    });
}

//输出文件;
function file_put_contents(file,txt){
    var fs = require('fs');
    fs.writeFile(file,txt,function(err){
        if(err){
            dump(err);
        }
    });
}

//登陆判断;
function checklogin(req,res){
    var user=req.session.user;
    if(!user)res.redirect('/login/index'); 
}
