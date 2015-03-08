//取时间
func (this *baseController) getTime() time.Time {
	options := models.GetOptions()
	timezone := float64(0)
	if v, ok := options["timezone"]; ok {
		timezone, _ = strconv.ParseFloat(v, 64)
	}
	add := timezone * float64(time.Hour)
	return time.Now().UTC().Add(time.Duration(add))
}

//获取用户IP地址
func (this *baseController) getClientIp() string {
	s := strings.Split(this.Ctx.Request.RemoteAddr, ":")
	return s[0]
}

//md5加密
authkey := models.Md5([]byte(this.getClientIp() + "|" + user.Password))

//"crypto/md5"
func Md5(buf []byte) string {
	hash := md5.New()
	hash.Write(buf)
	return fmt.Sprintf("%x", hash.Sum(nil))
}

func Rawurlencode(str string) string {
	return strings.Replace(url.QueryEscape(str), "+", "%20", -1)
}

