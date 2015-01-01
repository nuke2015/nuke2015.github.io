


if page, err = strconv.Atoi(this.Ctx.Input.Param(":page")); err != nil || page < 1 {
	page = 1
}
if pagesize, err = strconv.Atoi(this.getOption("pagesize")); err != nil || pagesize < 1 {
	pagesize = 10
}
