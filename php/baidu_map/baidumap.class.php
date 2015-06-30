<?php
include_once (__DIR__ . '/http.class.php');
class baidumap {
    
    /**
     * 去百度根据经纬度查城市名;
     * @param  [type] $locx [description]
     * @param  [type] $locy [description]
     * @return [type]       [description]
     */
    public function get_info_by_location($locx, $locy) {
        global $baidu_conf;
        $mapkey = $baidu_conf['mapkey'];
        $url = "http://api.map.baidu.com/geocoder?location={$locy},{$locx}&output=json&key={$mapkey}&qq-pf-to=pcqq.c2c";
        $data = http::curl($url);
        if ($data) {
            $result = json_decode($data, 1);
            if ($result['status'] == 'OK') {
                return $result['result'];
            }
        }
        return array();
    }
    
    /**
     * 火星转百度坐标;
     * @return [type] [description]
     */
    public function location_to_baidu($locx,$locy) {
        global $baidu_conf;
        $mapkey = $baidu_conf['mapkey'];
        $url = "http://api.map.baidu.com/geoconv/v1/?coords={$locx},{$locy}&from=3&to=5&ak={$mapkey}";
        $data = http::curl($url);
        if ($data) {
            $result = json_decode($data, 1);
            if ($result['status'] == '0') {
                if(count($result['result'][0])){
                    return array(1,$result['result'][0]);
                }
            }
        }
        return array(0,array());
    }
}
