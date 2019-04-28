var orm = require("orm");
orm.connect("mysql://root:@127.0.0.1/test", function(err, db) {
    if (err) throw err;
    var Person = db.define("person_test", {
        title: String,
        time: String,
    });
    // add the table to the database
    db.sync(function(err) {
        if (err) throw err;
        // add a row to the person table
        Person.create({
            title: "John",
            time: '2016-12-21 09:43:00',
        }, function(err) {
            console.log('err', err);
            if (err) throw err;
            // query the person table by surname
            Person.find({
                title: "John"
            }, function(err, people) {
                // SQL: "SELECT * FROM person WHERE surname = 'Doe'"
                if (err) throw err;
                console.log("People found", people);
            });
        });
    });
});