# -*- coding: utf-8 -*-from selenium import webdriver
import json


# 通用日志
def vlog(file, data):
    with open(file, 'a+') as f:
        txt = json.dumps(data)
        f.write(txt + "\r\n")
