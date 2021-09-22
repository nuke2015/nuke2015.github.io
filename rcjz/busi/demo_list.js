var api = {
    UserList: function() {
        api_crm(req, function(res) {
            var data = res.data;
            data.cols = [
                [{
                    field: "id",
                    title: "ID",
                    width:50,
                }, {
                    field: "title",
                    title: "标题",
                    width:100,
                }, {
                    field: "image",
                    title: "图片",
                    templet:function(d){
                        return "<img src='"+d.image+"' />";
                    },
                }, {
                    field: "category_id",
                    title: "分类",
                    width:400,
                }, {
                    field: "create_at",
                    title: "发布时间",
                    templet:function(d){
                        return helper.timeStampToDate(d.create_at);
                    },
                }, {
                    field: "",
                    title: "操作",
                    align: 'center',
                    fixed: 'right',
                    toolbar: '#table-attr-do'
                }]
            ];
            comm.datalist(data, function(page) {
                req.page = page;
                api.UserList(req);
            });
        }, function(err) {
            // err
        });
    }
}
var req = {
    methodName: "ArticleCmsList",
    size: 2,
    page: 1,
}
api.UserList(req);
layui.jquery("#DistributeAdd").click(function(){
    location.href="/hello/demo_info.html";
});