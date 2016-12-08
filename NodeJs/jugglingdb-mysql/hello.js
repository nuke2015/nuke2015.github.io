var Schema = require('jugglingdb').Schema;
var db = new Schema('mysql', {
    database: 'test',
    username: 'root'
});
// console.log(db);
var query = function(sql, cb) {
    db.adapter.query(sql, cb);
};
var blankDatabase = function(db, cb) {
    var dbn = db.settings.database;
    var cs = db.settings.charset;
    var co = db.settings.collation;
    query('DROP DATABASE IF EXISTS ' + dbn, function(err) {
        var q = 'CREATE DATABASE ' + dbn;
        if (cs) {
            q += ' CHARACTER SET ' + cs;
        }
        if (co) {
            q += ' COLLATE ' + co;
        }
        query(q, function(err) {
            query('USE ' + dbn, cb);
        });
    });
};
getFields = function(model, cb) {
    query('SHOW FIELDS FROM ' + model, function(err, res) {
        if (err) {
            cb(err);
        } else {
            var fields = {};
            res.forEach(function(field) {
                fields[field.Field] = field;
            });
            cb(err, fields);
        }
    });
}
getIndexes = function(model, cb) {
    query('SHOW INDEXES FROM ' + model, function(err, res) {
        if (err) {
            //console.log(err);
            cb(err);
        } else {
            var indexes = {};
            // Note: this will only show the first key of compound keys
            res.forEach(function(index) {
                if (parseInt(index.Seq_in_index, 10) == 1) {
                    indexes[index.Key_name] = index
                }
            });
            cb(err, indexes);
        }
    });
};
getFields('hello', function(err, fields) {
    console.log(fields);
});
getIndexes('hello', function(err, indexes) {
    console.log(indexes);
});