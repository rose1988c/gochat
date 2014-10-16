<?php

function curl_setopt_check($url, $options = array())
{
    $options = empty($options) ? array (
        'connecttimeout' => 3,
        'timeout' => 3 
    ) : $options;
    
    // 开启线程资源
    $ci = curl_init($url);
    curl_setopt($ci, CURLOPT_FAILONERROR, true);
    curl_setopt($ci, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $options ['connecttimeout']);
    curl_setopt($ci, CURLOPT_TIMEOUT, $options ['timeout']); // 设置超时时间
    $result = curl_exec($ci); // 读取数据
                              
    // 关闭线程
    curl_close($ci);
    
    return $result;
}
