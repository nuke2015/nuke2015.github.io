valid := validation.Validation{}

//验证必填,验证密码
if password != "" {
	if v := valid.Required(password2, "password2"); !v.Ok {
		errmsg["password2"] = "请再次输入密码"
	} else if password != password2 {
		errmsg["password2"] = "两次输入的密码不一致"
	} else {
		user.Password = models.Md5([]byte(password))
	}
}

//验证邮件地址
if v := valid.Required(email, "email"); !v.Ok {
	errmsg["email"] = "请输入email地址"
} else if v := valid.Email(email, "email"); !v.Ok {
	errmsg["email"] = "Email无效"
} else {
	user.Email = email
}

//验证用户名;
if v := valid.Required(username, "username"); !v.Ok {
	errmsg["username"] = "请输入用户名"
} else if v := valid.MaxSize(username, 15, "username"); !v.Ok {
	errmsg["username"] = "用户名长度不能大于15个字符"
}

//验证密码;
if v := valid.Required(password, "password"); !v.Ok {
	errmsg["password"] = "请输入密码"
}

