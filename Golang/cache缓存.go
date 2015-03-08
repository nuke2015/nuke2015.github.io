package controllers

import (
	"github.com/astaxie/beego"
    "github.com/astaxie/beego/cache"
	"fmt"
)

type MainController struct {
	beego.Controller
}

func (this *MainController) Get() {
	memory, _ := cache.NewCache("memory", `{"interval":60}`)
	memory.Put("astaxie", 1, 10)
	v:=memory.Get("astaxie")
	this.dump(v)
	// memory.Delete("astaxie")
	c:=memory.IsExist("astaxie")
	this.dump(c)
}

func (this *MainController) dump(params interface{}) {
	fmt.Fprint(this.Ctx.ResponseWriter, params);
}
