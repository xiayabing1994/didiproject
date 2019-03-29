<?php

namespace  app\api\controller;
use app\common\controller\Api;
use EasyWeChat\Foundation\Application;

class Weixin  {

    private $config;
    private $app;
    public function __construct(){
        $this->config=[
            'debug'  => true,

            /**
             * 账号基本信息，请从微信公众平台/开放平台获取
             */
//            'app_id'  => 'wx1fa8d41c0b470d46',         // AppID
            'app_id'  => 'wxc4a80eccc9d578b7',         // AppID
//            'secret'  => 'e6d68173f5667c092fe89d9950f36b38',     // AppSecret
            'secret'  => '33e1719dd8d77bf03140d405f9ddd20b',     // AppSecret
            'token'   => 'AITAOSHENG2019',          // Token
            'aes_key' => '',
            'oauth' => [
                'scopes'   => ['snsapi_userinfo'],
                'callback' => '/api/weixin/notify',
            ],
            'payment' => [
                'merchant_id'        => '',
                'key'                => '',
                'cert_path'          => '', // XXX: 绝对路径！！！！
                'key_path'           => '',      // XXX: 绝对路径！！！！
                'notify_url'         => '默认的订单回调地址',       // 你也可以在下单时单独设置来想覆盖它
                // 'device_info'     => '013467007045764',
                // 'sub_app_id'      => '',
                // 'sub_merchant_id' => '',
                // ...
            ],
            // ..
        ];
        $this->app=new Application($this->config);
    }

    public function index(){
        $server=$this->app->server;
        $server->setMessageHandler(function ($message) {
            switch ($message->MsgType) {
                 case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'event':
                    switch($message->Event){
                        case 'subscribe':
                            return '欢迎订阅我的公众号';
                            break;
                        case 'unsubscribe':
                            return '您舍得我吗';
                            break;
                    }

                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }

            // ...
        });
        $response=$server->serve();
        $response->send();
    }

    public function menuAdd(){
        $menu = $this->app->menu;
        $buttons = [
            [
                "type" => "click",
                "name" => "看看",
                "key"  => "USER_VIEW"
            ],
            [
                "name"       => "我的",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "信息",
                        "url"  => "http://wx.xlove99.top/wap/index"
                    ],
                    [
                        "type" => "view",
                        "name" => "拼单",
                        "url"  => "http://v.qq.com/"
                    ],
                    [
                        "type" => "click",
                        "name" => "赞一下我们",
                        "key" => "V1001_GOOD"
                    ],
                ],
            ],
        ];
        dump($menu->add($buttons));
    }
    public function menuDestroy(){
        $menu = $this->app->menu;
        dump($menu->destroy());
    }
    public function pay(){
        dump(db('config')->where('group','peace')->select());
        $payment = $this->app->payment;
        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => 'iPad mini 16G 白色',
            'detail'           => 'iPad mini 16G 白色',
            'out_trade_no'     => '1217752501201407033233368018',
            'total_fee'        => 5388, // 单位：分
            'notify_url'       => 'http://xxx.com/order-notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];
        $order= new \EasyWeChat\Payment\Order($attributes);
        $result = $payment->prepare($order);

    }
}