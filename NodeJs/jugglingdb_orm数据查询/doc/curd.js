// 数据库相关操作
// https://github.com/1602/jugglingdb/blob/master/docs/model.md
var Schema = require('jugglingdb').Schema;
var db = new Schema('mysql', {
    database: 'test',
    username: 'root'
});
// 清除数据库
// 一个指向就够了,不用详细定义
var model = db.define('hello');
console.log(model);
model.destroyAll(function(err) {
    console.log(err);
});
// 入库一批数据
// 这是代码端的数据定义,若不定义则入库为空
var model = db.define('hello', {
    title: Schema.Text,
    time: Schema.Text
});
for (var i = 5; i >= 0; i--) {
    model.create({
        title: 'test ' + i,
        time: new Date().toLocaleString(),
    }, function(err, res) {
        console.log(err);
        console.log(res);
    });
}
// 全部数据
model.all({
    id: {
        gt: 0
    }
}, function(err, res) {
    console.log(err);
    console.log(res);
});
// 分页查询
model.all({
    where:{
        id: {
            gt: 0
        }
    },
    order:"id desc",
    skip:1,
    limit:3,
}, function(err, res) {
    console.log(err);
    console.log(res);
});
