<?php
namespace app\api\controller;
use app\common\controller\Api;
use think\Hook;
use \Yansongda\Pay\Pay;
use fast\Random;
use EasyWeChat\Foundation\Application;
use think\Controller;
use think\Cache;
class Test extends Base{
    private $user;
    public function test(){
        dump(load_config());
        $Rds=Cache::store('redis');
        dump($Rds->hset('hash:002',['age'=>12,'name'=>'小米','money'=>12.32]));
        dump($Rds->hget('hash:002','name'));
        dump($Rds->hincrby('hash:002','age',1));
        dump($Rds->hincrby('hash:002','money',2,'float'));
    }
    public function token(){
        return $this->getToken(12);
    }
    public function jpush(){
        $pushModel=new \logicmodel\Jpushlogic();
        $pushModel->payFinalPush(173);
        die;
    }


}
