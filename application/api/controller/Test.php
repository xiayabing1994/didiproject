<?php
namespace app\api\controller;
use app\common\controller\Api;
use think\Hook;
use \Yansongda\Pay\Pay;
use addons\epay\library\Service;
use fast\Random;
use think\addons\Controller;
use Yansongda\Pay\Log;
use Exception;
use EasyWeChat\Foundation\Application;
class Test extends Api{
    private $user;
    public function __construct(\app\api\controller\Test1 $user){
        $this->user=$user;
    }

    public function test(){
        file_put_contents('./test.txt','hahha');
    }
    public function test1(){
         dump(Hook::listen('api_test1'));
    }
    public function testPay(){
        $pay = Pay::alipay(Service::getConfig('alipay'));
        //构建订单信息
        $order = [
            'out_trade_no' => date("YmdHis"),//你的订单号
            'total_amount' => 1,//单位元
            'subject'      => 'FastAdmin企业支付插件测试订单',
        ];

        //跳转或输出
        return $pay->app($order)->send();
    }
    public function wxTest(){
        $options = [
            'debug'     => true,
            'app_id'    => 'wx1fa8d41c0b470d46',
            'secret'    => 'e6d68173f5667c092fe89d9950f36b38',
            'token'     => 'AITAOSHENG2019',
            'log' => [
                'level' => 'debug',
                'file'  => '/tmp/easywechat.log',
            ],
            // ...
        ];

        $app = new Application($options);

        $server = $app->server;
        $user = $app->user;

        $server->setMessageHandler(function($message) use ($user) {
            $fromUser = $user->get($message->FromUserName);

            return "{$fromUser->nickname} 您好！欢迎关注 overtrue!";
        });

        $server->serve()->send();
    }
    public function usersig(){
        $id=11;
        $private_pem_path = EXTEND_PATH."tim/ec_key.pem";
        import('tim.TimApi',EXTEND_PATH);
        $api = createRestAPI();
        // $api->init($sdkappid, $identifier);
        $api->init(' 1400054293', 'ning7');
        $signature = get_signature();
        $expiry_after = 86400;//一天有效期
        $ret = $api->generate_user_sig((string)$id, $expiry_after, $private_pem_path, $signature);
        dump($ret);
    }
    public function testPush(){
        vendor('jpush.src.JPush.Client');
        $push= new \Client('aa','aa');
        dump($push);
    }

}



    function  sq($a){
        return $a*$a;
    }
