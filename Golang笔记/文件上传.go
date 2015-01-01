
//上传文件
func (this *ArticleController) Upload() {
	_, header, err := this.GetFile("upfile")
	ext := strings.ToLower(header.Filename[strings.LastIndex(header.Filename, "."):])
	out := make(map[string]string)
	out["url"] = ""
	out["fileType"] = ext
	out["original"] = header.Filename
	out["state"] = "SUCCESS"
	if err != nil {
		out["state"] = err.Error()
	} else {
		savepath := "./static/upload/" + time.Now().Format("20060102")
		if err := os.MkdirAll(savepath, os.ModePerm); err != nil {
			out["state"] = err.Error()
		} else {
			filename := fmt.Sprintf("%s/%d%s", savepath, time.Now().UnixNano(), ext)
			if err := this.SaveToFile("upfile", filename); err != nil {
				out["state"] = err.Error()
			} else {
				out["url"] = filename[1:]
			}
		}
	}

	this.Data["json"] = out
	this.ServeJson()
}
