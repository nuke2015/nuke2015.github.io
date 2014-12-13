//mongodb settings for mongolab START
//重要说明:
//1.不要反复加载,浪费资源;
//2.此变量只在当前脚本有效,在controll中无法调用.
var db = require('mongoskin').db(process.env.MONGOLAB_URI || "mongodb://localhost/fengsucdn",{safe:true});//数据库连接串
//mongodb settings for mongolab END

//数据查看
dump=function(v){
	console.log(v);
}

//模型加载;
m=function(table){
	return db.bind(table);
}

