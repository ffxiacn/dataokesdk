<?php

/**
 * 大淘客开放平台SDK
 * @author https://bb.ffxia.cn/
 * Class Dataoke
 */
class Dataoke
{
    
    private $host = "https://openapi.dataoke.com";
    private $appKey;
    private $appSecret;
    private $version = '1';
    
    
    public function __construct ($appKey, $appSecret, $host = '')
    {
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
        if ( strlen($host) )
        {
            $this->host = rtrim($host, '/');
        }
    }
    
    /**
     * 执行数据请求
     *
     * @param $data
     *
     * @return string
     * @throws \Exception
     */
    public function exec ($data)
    {
        if ( !is_array($data) || !$data )
        {
            throw new Exception("参数必须是数组，且不能为空");
        }
        if ( !isset($data['apiName']) && strlen($data['apiName']) == 0 )
        {
            throw new Exception("apiName 不能为空,如：api/goods/get-goods-list");
        }
        $apiName = ltrim($data['apiName'], '/');
        unset($data['apiName']);
        //签名
        $data['appKey'] = $this->appKey;
        if ( !isset($data['version']) )
        {
            $data['version'] = $this->version;
        }
        $data['sign'] = $this->makeSign($data, $this->appSecret);
        
        $httpQuery = http_build_query($data);
        $result = $this->request($this->host . '/' . $apiName . '?' . $httpQuery);
        
        return $result;
    }
    
    public function makeSign ($data, $appSecret)
    {
        ksort($data);
        $str = '';
        foreach ( $data as $k => $v )
        {
            $str .= '&' . $k . '=' . $v;
        }
        $str = trim($str, '&');
        $sign = strtoupper(md5($str . '&key=' . $appSecret));
        return $sign;
    }
    
    public function request ($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    
    
}