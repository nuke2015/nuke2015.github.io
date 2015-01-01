package controllers

import (
	"github.com/astaxie/beego"
	"fmt"
)

type MainController struct {
	beego.Controller
}

func (this *MainController) Get() {
	buf := make([]string, 0, 3)
	buf=append(buf,"abcd1")
	buf=append(buf,"abce2")
	buf=append(buf,"abcf3")
	buf=append(buf,"abcg4")
	this.dump(buf)
}

func (this *MainController) dump(params interface{}) {
	fmt.Fprint(this.Ctx.ResponseWriter, params);
}
