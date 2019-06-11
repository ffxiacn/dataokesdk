# 大淘客开放平台接口sdk （非官方）


### 使用方式(composer)  
```php
  require_once  'dataoke.php';
  $appKey = 'xxxxx';//应用的key
  $appSecret = 'xxxxxxxxxx';//应用的Secret
  $dataoke = new Dataoke($appKey, $appSecret);
  
  //列表api
  // https://openapi.dataoke.com/api/goods/get-goods-list
  $data = [
      'apiName'=>'api/goods/get-goods-list',  //apiName 就是去掉接口地址中的host的部分
      'pageSize'  => 10,
      'pageId'    => '1', 
      'juHuaSuan' => 1, 
  ]; 
  $result = $dataoke->exec($data); 
  print_r($result); 
```



### [帮助中心](https://bb.ffxia.cn)
