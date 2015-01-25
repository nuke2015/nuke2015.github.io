

	//mongo/bson.m
	result :=m.Use("menu").One(nil)
	x:=result.(bson.M)
	this.dump(x["title"])
	