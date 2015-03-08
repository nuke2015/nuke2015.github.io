
	var theme string
	if v, ok := this.options["theme"]; ok && v != "" {
		theme = v
	} else {
		theme = "default"
	}
	if _, err := os.Stat(beego.ViewsPath + "/" + theme + "/layout.html"); err == nil {
		this.Layout = theme + "/layout.html"
	}

	if _, ok := result[year]; !ok {
		result[year] = make([]*models.Post, 0)
	}
	result[year] = append(result[year], v)

	if keyword != "" {
		switch searchtype {
		case "title":
			query = query.Filter("title__icontains", keyword)
		case "author":
			query = query.Filter("author__icontains", keyword)
		case "tag":
			query = query.Filter("tags__icontains", keyword)
		}
	}