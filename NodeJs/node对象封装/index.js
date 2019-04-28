//依赖模块,非标准模块引用需要写路径
var hello = require('./hello.js');
var h1 = hello.hello();
console.log(h1);
hello.goodbye();