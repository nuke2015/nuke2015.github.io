#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
bin=${DIR}/../bin
lib=${DIR}/../lib

echo '
{
    "type" : "jdbc",
    "jdbc" : {
        "url" : "jdbc:mysql://192.168.1.248:3306/didiys",
        "user" : "root",
        "password" : "ddys13516",
        "sql" : "select * from ddys_article_cms;",
        "index" : "art",
        "type" : "cms",
        "index_settings" : {
            "index" : {
                "id" : 1,
                "title" : 1,
                "desp" : 1
            }
        }
    }
}
' | java \
    -cp "${lib}/*" \
    -Dlog4j.configurationFile=${bin}/log4j2.xml \
    org.xbib.tools.Runner \
    org.xbib.tools.JDBCImporter
