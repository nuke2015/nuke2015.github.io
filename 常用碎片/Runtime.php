<?php

/**
 * 计时器统计任意两点间的时间,做接口耗时统计.
 * 锋子,2015年2月26日 11:35:53
 */

// 调用示例
dump('long long ago...it is a story about the time...');
dump('time now:');
$Runtime= new Runtime();
dump($Runtime->microtime());

$Runtime->start(array('eating','drinking','dancing'));
sleep(1);
$Runtime->stop('eating');
$Runtime->start('dancing');
sleep(1);
$Runtime->stop('drinking');
sleep(1);
$Runtime->stop('dancing');

dump('eating spent time:');
dump($Runtime->spent('eating'));
dump('drinking spent time:');
dump($Runtime->spent('drinking'));
dump('eat and dance spent time:');
dump($Runtime->spent(array('eating','dancing')));
dump('story time:');
dump($Runtime->spent());

function dump($v){
    echo '<pre>';
    print_r($v);
    echo '<pre>';
}

class Runtime
{
    var $StartTime = 0;
    var $StopTime = 0;
    var $log = array();
    
    //当前时间
    function microtime() {
        list($usec, $sec) = explode(' ', microtime());
        return ((float)$usec + (float)$sec);
    }
    
    //计时起点
    function start($sig = null) {
        if ($sig) {
            if (is_array($sig)) {
                foreach ($sig as $item) {
                    $this->log[$item]['start'] = $this->microtime();
                }
            } 
            else {
                $this->log[$sig]['start'] = $this->microtime();
            }
        } 
        else {
            $this->StartTime = $this->microtime();
        }
    }
    
    //计时终点
    function stop($sig = null) {
        if ($sig) {
            if (is_array($sig)) {
                foreach ($sig as $item) {
                    $this->log[$item]['stop'] = $this->microtime();
                }
            } 
            else {
                $this->log[$sig]['stop'] = $this->microtime();
            }
        } 
        else {
            $this->StopTime = $this->microtime();
        }
    }
    
    //耗时统计
    function spent($sig = null) {
        if ($sig) {
            if (is_array($sig)) {
                foreach ($sig as $item) {
                    if ($this->log[$item]) {
                        $result[$item] = round(($this->log[$item]['stop'] - $this->log[$item]['start']) * 1000, 1);
                    } 
                    else {
                        $result[$item] = - 1;
                    }
                }
                return $result;
            } 
            else {
                if ($this->log[$sig]) {
                    return round(($this->log[$sig]['stop'] - $this->log[$sig]['start']) * 1000, 1);
                } 
                else {
                    return -1;
                }
            }
        } 
        else {
            return $this->log;
        }
    }
}

