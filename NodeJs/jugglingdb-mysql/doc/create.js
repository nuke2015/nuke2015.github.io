// 数据库相关操作
// https://github.com/1602/jugglingdb/blob/master/docs/model.md
var Schema = require('jugglingdb').Schema;
var db = new Schema('mysql', {
    database: 'test',
    username: 'root'
});
var model = db.define('hello');
console.log(model);
model.create({
    title: 'dsfn',
    time: '2016-12-01 16:01:02',
}, function(err, res) {
    console.log(err);
    console.log(res);
});