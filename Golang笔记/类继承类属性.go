
///////////////////////////////
//继承自beego类,扩展了moduleName等字段 //
///////////////////////////////
type baseController struct {
	beego.Controller
	moduleName     string
	controllerName string
	actionName     string
	options        map[string]string
}

//包内继承
type MainController struct {
	baseController
}

//函数内定义类变量
var (
		list     []*models.Post
		pagesize int
		err      error//错误也是一种类型
		page     int
	)

//类定义私有变量不能被继承
type baseController struct {
	beego.Controller
	userid         int64
	username       string
	moduleName     string
	controllerName string
	actionName     string
}

//管理
func (this *ArticleController) List() {
	var (
		page       int64
		pagesize   int64 = 10
		status     int64
		offset     int64
		list       []*models.Post //数组要用指针
		post       models.Post //单体不用指针
		searchtype string
		keyword    string
	)
}

