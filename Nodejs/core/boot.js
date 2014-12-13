
var express = require('express')
  , fs = require('fs');
  


module.exports = function(parent, options){
  var verbose = options.verbose;
  fs.readdirSync(__dirname + '/../controllers').forEach(function(name){
	name=name.substring(0,name.length-3);
    verbose && console.log('\n   Controller == %s:', name);
    var obj = require('./../controllers/' + name +'.js')
      , name = obj.name || name
      , prefix = obj.prefix || ''
      , app = express()
      , method
      , path;
	
    app.set('views', __dirname + '/../views/' + name);
	
	if(name=='index'){
		path = '/';
		app.all(path, obj.index);//默认路由;
		path = '/'+name;
		app.all(path, obj.index);//默认路由;
	}

	//path = prefix + path;
	if (obj.before){
		path = '/' + name;
		app.all(path, obj.before);//全部前置;
		verbose && console.log('     ALL %s -> before', path);
		for(var key in obj){
			if (~['name', 'prefix', 'index', 'before'].indexOf(key)) continue;
			path = '/' + name + '/' + key;
			app.all(path, obj.before);//全部前置;
			verbose && console.log('     ALL %s -> before', path);
		}
	}
	
    // generate routes based
    // on the exported methods
    for (var key in obj) {
      // "reserved" exports
      if (~['name', 'prefix', 'engine', 'before'].indexOf(key)) continue;

	  if(key && name){
		method = 'all';
        path = '/' + name + '/' +key;
		app[method](path, obj[key]);
	  }
	  if(key=='index'){
	  	method = 'all';
        path = '/' + name ;
		app[method](path, obj['index']); //默认方法;
		app[method](path+'/index', obj['index']); //默认方法;
	  }
      verbose && console.log('     %s %s -> %s', method.toUpperCase(), path, key);
    }
	
    // mount the app
    parent.use(app);
  });
};