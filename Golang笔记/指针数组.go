//无序数组
var list []*models.Post

//有序数组
result = make(map[string][]*models.Post)
result[year] = make([]*models.Post, 0)
options := make(map[string]string)

//都是无序数组
var list []*models.Post
var pids []int64 = make([]int64, 0)

//数组遍历
for _, v := range tp {
	pids = append(pids, v.Postid)
}

//即时定义数组;
keys := []string{"sitename", "siteurl", "subtitle", "pagesize", "keywords", "description", "email", "theme", "timezone", "stat"}

//取ids
idarr := make([]int64, 0)
for _, v := range ids {
	if id, _ := strconv.Atoi(v); id > 0 {
		idarr = append(idarr, int64(id))
	}
}