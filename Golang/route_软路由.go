package main

import (
	"jjys.golang/utils"
)

type ddys_banner_req struct {
	Title string
}

type ddys_banner_res struct {
	Nickname string
}

type ddys_banner struct {
	Req ddys_banner_req
	Res ddys_banner_res
    Company string
}

func (this *ddys_banner) Dump(params interface{}) {
	utils.Dump(params)
}

func (this *ddys_banner) ReqStruct() *ddys_banner_req {
	return &this.Req
}

func (this *ddys_banner) ResStruct() *ddys_banner_res {
	return &this.Res
}

func main() {
    var banner ddys_banner
	x := banner.ReqStruct()
    utils.Dump(x)
    x.Title="world"
	utils.Dump(x)
}
