var Store = require("jfs");
var db = new Store("data");

var d = {
  foo: "bar"
};
dump(d);

// save with custom ID
db.save("anId", d, function(err){
  // now the data is stored in the file data/anId.json
});

db.get("anId", function(err, obj){
  // obj = { foo: "bar" }
  dump(obj);
})

// get all available objects
db.all(function(err, objs){
  // objs is a map: ID => OBJECT
  dump(objs);
});

// delete synchronously
db.delete("myId");

function dump(v){
    console.log(v);
}
