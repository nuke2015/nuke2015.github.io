
//读参数
this.Ctx.Input.Param(":id")

//框架入口
beego.run()

//停止运行
this.StopRun()

//模板渲染
this.diaplay('index')

//模板变量赋值
this.Data["post"] = post

//自定义的扩展的方法
this.setHeadMetas(post.Title, strings.Trim(post.Tags, ","), post.Title)

//404中断
this.Abort("404")

//取控制器
controllerName, actionName := this.GetControllerAndAction()

//302重定向
this.Redirect("/admin/login", 302)

//全局调用配置文件;
beego.AppConfig.String("AppVer")

//引用路径;
this.Ctx.Request.Referer()

//马上渲染
this.Render()

//请求方法类型
this.Ctx.Request.Method 

//取变量;
this.GetString(key)
this.GetInt32(key)
this.GetInt64(key)

