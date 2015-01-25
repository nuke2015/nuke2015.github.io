

	//mongo/bson.m
	result :=m.Use("menu").One(nil)
	x:=result.(bson.M)
	this.dump(x["title"])
	

	result :=m.Use("menu").All(nil)
	x := result.([]interface{})
	y :=x[0].(bson.M)
	this.dump(y["title"])

	