<?php

// 此处负责处理文件上传,可以自己写，并不复杂
// 引入 didiyuesao 大框架

list($code, $data) = \didiyuesao\com\org\Tupload::upload_oss();
echo json_encode(['code' => $code, 'data' => $data]);

