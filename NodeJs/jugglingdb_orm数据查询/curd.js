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
// 条件删除
// console.log(model);
// model.find(109,function(err,res){
//     这个destroy比较奇怪,它不是model的直接方法,而是属性值.
//     if(res)res.destroy();
// });
// return;
// return;
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
    where: {
        id: {
            gt: 0
        }
    },
    order: "id desc",
    skip: 1,
    limit: 3,
}, function(err, res) {
    console.log(err);
    console.log(res);
});
// 添加或更新update and insert
// Model.upsert(data, callback);
// 更新update
// Model.update({
//     where: {
//         id: inst.id
//     },
//     update: {
//         field: 'data'
//     }
// });
// 游标查询
// Model.iterate(options, iterator, callback)
// 单条查询
// Model.find(id, callback);
// 条数查询
// Model.count([query, ]callback);
// 关联入库
// Book.create(function(err, book) {
//     // using 'chapters' scope for build:
//     var c = book.chapters.build({name: 'Chapter 1'});
//     // same as:
//     c = new Chapter({name: 'Chapter 1', bookId: book.id});
//     // using 'chapters' scope for create:
//     book.chapters.create();
//     // same as:
//     Chapter.create({bookId: book.id});
//     // using scope for querying:
//     book.chapters(function() {/* all chapters with bookId = book.id */ });
//     book.chapters({where: {name: 'test'}, function(err, chapters) {
//         // all chapters with bookId = book.id and name = 'test'
//     });
// });