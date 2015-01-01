//域名
this.Data["hostname"], _ = os.Hostname()

//版本号
this.Data["version"] = beego.AppConfig.String("AppVer")

//golang版本
this.Data["gover"] = runtime.Version()

//操作系统
this.Data["os"] = runtime.GOOS

//cpu
this.Data["cpunum"] = runtime.NumCPU()

//goarch
this.Data["arch"] = runtime.GOARCH

