	query := new(models.Post).Query().Filter("status", 0).Filter("urltype", 0)
	count, _ := query.Count()
	
	if count > 0 {
		query.OrderBy("-istop", "-posttime").Limit(pagesize, (page-1)*pagesize).All(&list)
	}

	//查询无出错
	user.Read() == nil 

	//指定字段更新与删除	
	switch op {
	case "topub": //移到已发布
		post.Query().Filter("id__in", idarr).Update(orm.Params{"status": 0})
	case "todrafts": //移到草稿箱
		post.Query().Filter("id__in", idarr).Update(orm.Params{"status": 1})
	case "totrash": //移到回收站
		post.Query().Filter("id__in", idarr).Update(orm.Params{"status": 2})
	case "delete": //批量删除
		for _, id := range idarr {
			obj := models.Post{Id: id}
			if obj.Read() == nil {
				obj.Delete()
			}
		}
	}

	//单一查询;
	if err := user.Read(); err != nil {
		this.showmsg("用户不存在")
	}

	//出错数组;
	errmsg := make(map[string]string)

	//删除;
	user := models.User{Id: id}
	if user.Read() == nil {
		user.Delete()
	}

	//数据更新;
	if user.Read("username") != nil || user.Password != models.Md5([]byte(password)) {
				this.Data["errmsg"] = "帐号或密码错误"
			} else if user.Active == 0 {
				this.Data["errmsg"] = "该帐号未激活"
			} else {
				user.Logincount += 1
				user.Lastip = this.getClientIp()
				user.Lastlogin = this.getTime()
				user.Update()
			}

	//查询单用户;
	user := models.User{Id: this.userid}
	if err := user.Read(); err != nil {
		this.showmsg(err.Error())
	}

"github.com/astaxie/beego/orm"
orm.RegisterDataBase("default", "mysql", dsn)
orm.RegisterModel(new(User), new(Post), new(Tag), new(Option), new(TagPost),new(Order))
