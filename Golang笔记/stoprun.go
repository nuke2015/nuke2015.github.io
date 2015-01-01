package controllers

import (
	"github.com/astaxie/beego"
	"fmt"
)

type MainController struct {
	beego.Controller
}

func (this *MainController) Get() {
	fmt.Println("adsf");
	this.StopRun()
}

func (this *MainController) dump(params interface{}) {
	fmt.Fprint(this.Ctx.ResponseWriter, params);
}
