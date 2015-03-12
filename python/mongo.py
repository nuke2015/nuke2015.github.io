# -*- coding: utf-8 -*
from pymongo import Connection
from bson.objectid import ObjectId

# 测试增删改查
con = Connection("127.0.0.1:27017")
db = con.test
article = db.article

# 总条数
count = article.count()
print(count)

# 条件查找
arts = article.find()
for i in arts:
    print i

# 添加
ins=article.insert({'title':'test'});
print(ins)

# 单条
one=article.find_one(ins)
print(one)

# 更新
anew={"title":"sljs"}
update=article.update({"_id":ins},anew)
print(update)

# 按objectid查找
find=article.find_one({"_id": ObjectId('55015b8aead13f112004b89a')})
print(find)


