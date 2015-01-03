package controllers

import(
    "gopkg.in/mgo.v2"
    "gopkg.in/mgo.v2/bson"
)

type MainController struct {
    BaseController
    query          *mgo.Query
    session       *mgo.Session
    collection    *mgo.Collection
}

type Person struct {
    Name string
    Phone string
}

func (this *MainController) Get() {
    this.Dial("127.0.0.1","test","people")
    // where := bson.M{"_id":Mongoid}
    // result:=this.One(where)
    // result:=this.One(nil)
    result:=this.All(nil)
    this.dump(result)
}

/**
 * 查询单条;
测试1:
    Mongoid:=this.Mongoid("54a6b7662b759fe4c0ff9b44")
    where := bson.M{"_id":Mongoid}
    this.Dial("127.0.0.1","test","people")
    result:=this.One(where)
    this.dump(result)
测试2:
    result:=this.One(nil);
    this.dump(result)
 */
func (this *MainController) One(where interface{}) interface{} {
    var result interface{}
    this.collection.Find(where).One(&result)
    defer this.session.Close()
    return result
}

/**
 * 查询全部;
	where := bson.M{"name":"fengfeng"}
	this.Dial("127.0.0.1","test","people")
	result:=this.All(where)
	this.dump(result)
 */
func (this *MainController) All(where interface{}) interface{} {
    var result [] interface{}
    this.collection.Find(where).All(&result)
    defer this.session.Close()
    return result
}

/**
 * 查询条数
测试1:
	result:=this.Count(nil)
测试2:
	where := bson.M{"name":"fengfeng"}
	result:=this.Count(where)
 */
func (this *MainController) Count(where interface{}) int {
    count,_:=this.collection.Find(where).Count()
    return count
}

/**
 * 执行自定义Mongo查询;
	测试:
	result:=this.Query(nil,1,10);
	result:=this.Query(nil,1,1);
 */
func (this *MainController) Query(where bson.M,skip int,limit int) interface{} {
    var result [] interface{}
    this.collection.Find(where).Skip(skip).Limit(limit).Iter().All(&result)
    defer this.session.Close()
    return result
}

/**
 * 连接mongo数据库
   测试1:
   this.Dial("127.0.0.1","test","people")
   this.dump(this.collection)
 */
func (this *MainController) Dial(ip string,db string,collect string){
    this.session,_ = mgo.Dial(ip)
    this.session.SetMode(mgo.Monotonic, true)
    this.collection =this.session.DB(db).C(collect)
    // 这里不能提前关闭
    // defer this.session.Close()
}

/**
 * 产生Mongo._id
	测试1:
	Mongoid:=this.Mongoid("54a6b7662b759fe4c0ff9b44")
	this.dump(Mongoid)
 */
func (this *MainController) Mongoid(id string) bson.ObjectId {
    return bson.ObjectIdHex(id)
}
