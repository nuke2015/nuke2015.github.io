package controllers

import (
	"github.com/astaxie/beego"
	"fmt"
)

type MainController struct {
	beego.Controller
}

func (this *MainController) Get() {
	// this.Ctx.SetCookie("test","abctest",86400);
	// this.Ctx.SetCookie("test","abctest",2);
	// this.Ctx.SetCookie("test","abctest",-1);
	v:=this.Ctx.GetCookie("test");
	this.dump(v)	
}

func (this *MainController) dump(params interface{}) {
	fmt.Fprint(this.Ctx.ResponseWriter, params);
}

