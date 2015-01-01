package controllers

import (
	"github.com/astaxie/beego"
	"fmt"
)

type MainController struct {
	beego.Controller
}

func (this *MainController) Get() {
	// sessionon = true
	this.SetSession("abcf","fengzi");
	v:=this.GetSession("abcf");
	this.dump(v)
}

func (this *MainController) dump(params interface{}) {
	fmt.Fprint(this.Ctx.ResponseWriter, params);
}
