var express = require('express');
var app = module.exports = express();
app.set('views', __dirname + '/views');
app.set('view engine', 'html');
app.engine("html", require('jqtpl/lib/express').render);
app.use(express.static(__dirname + '/public'));
app.get('/', function(req, res) {
    res.render('index', {
        title: 'express+jqtpl is ok',
        content: "hello jqtpl"
    });
});
app.listen(10861);