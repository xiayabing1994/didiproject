<?php
namespace app\api\controller;
use Firebase\JWT\JWT;
use think\Cache;
class Example{
    public function getToken(){
        $uid=12;
        $key = load_config('app')['encrypt_key'];  //上一个方法中的 $key 本应该配置在 config文件中的
        $token = [
            "iss"=>"",  //签发者 可以为空
            "aud"=>"", //面象的用户，可以为空
            "iat" => time(), //签发时间
            "nbf" => time(), //在什么时候jwt开始生效  （这里表示生成100秒后才生效）
            "exp" => time()+7200, //token 过期时间
            "uid" => $uid //记录的userid的信息，这里是自已添加上去的，如果有其它信息，可以再添加数组的键值对
        ];
        $jwt = JWT::encode($token,$key,"HS256"); //根据参数生成了 token
        session('token',$jwt);
//        Cache::set('name','xiaoming');
        return $jwt;
    }
}