# layui-tinymce

[在线预览地址](http://chick1993.gitee.io/layui-tinymce/layui_exts/) | [Layui论坛讨论](https://fly.layui.com/jie/63668/) | [tinymce中文文档](http://tinymce.ax-z.cn/)
## 更新
2020.11.06 tinymce更新到5.5.1，上传图片时支持自定义字段名、支持同时上传其他数据<br>
2020.08.24 tinymce更新到5.4.2
## 食用

食用方式可参考tinymce官方文档

### 引入编辑器
```
layui.extend({
    tinymce: '{/}./tinymce/tinymce'
}).use(['tinymce'], function () {
    var t = layui.tinymce
    // code ...
    // 后面无特殊说明，其它代码均写在此处
    // ...
})
```
### 基础方法
#### 创建 t.render(option，load_callback)
```
<textarea id="edit"></textarea>

// 调用 t.render(option，load_callback) 创建编辑器
t.render({
    elem: "#edit"  
    // 支持tinymce所有配置      
},(opt)=>{
    //加载完成后回调 opt 是传入的所有参数
});

```
#### 编辑器实例 t.get(id)
```
// 如果页面只有一个编辑器，等同于官方的tinymce.activeEditor
// 如果页面有多个编辑器，等同于官方tinymce.editors[id]
var edit = t.get('#edit')
```
#### 获取内容 edit.getContent(option)
```
// 获取编辑器HTML内容
edit.getContent()
// 获取编辑器文本内容
edit.getContent({format:'text'})
```

#### 插入内容 edit.insertContent(html)
```
edit.insertContent('<b>插入内容</b>')
```

#### 设置内容 edit.setContent(html)
```
edit.setContent('<b>设置内容</b>')

// 清空编辑器，将内容设置为空字符串即可
edit.setContent('')
```
#### 重载 t.reload(option，load_callback)
```
t.reload({
    elem:'#edit'
    // 所有参数都可以重新设置 ...
},(opt) => {
    //重载完成后回调函数，会把所有参数回传，
    //重载仅仅重新渲染编辑器，不会清空textarea，可手动设置
})
```

#### 销毁 edit.destroy() 
```
edit.destroy() 
```

### 图片上传
#### 配置上传接口
##### 全局修改 layui_exts\tinymce\tinymce.js
```
var settings = {
    images_upload_url:'http(s)://yoursite/apipath'
    // ...
}
```
##### 初始化时传入
``` 
t.render({
    images_upload_url:'http(s)://yoursite/apipath'
    // ...
})
```
#### 默认上传
```
t.render({
    elem: "#edit"  
    ,images_upload_url:'http(s)://yoursite/apipath'//配置上传接口
    ,form:{
        name:'avatar'//配置上传文件的字段名称
        ,data:{ key:'value', ... } //其他需要一起上传的数据
    }
});
```

#### 自定义上传
```
// 回调函数 参数1：上传的文件数据，参数2：上传成功回调，参数3：上传异常回调
t.render({
    elem: "#edit"  
    ,images_upload_handler:function(blobInfo, succFun, failFun){
        // 你的代码 ...
    }
})
```
