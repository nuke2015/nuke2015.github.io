
if post.Read() != nil {
			goto RD
		}

func(){
...........		
RD:
	this.Redirect("/admin/article/list", 302)
}
