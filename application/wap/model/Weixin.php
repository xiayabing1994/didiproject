<?php

namespace  app\wap\model;
use think\Model;
use think\Db;
class Weixin extends Model{

    /**
     * 微信登录前置钩子
     * @param $id  微信openid
     */
    public function weixinLogin($user){
        $userinfo=Db::name('user')->where(['wx_unionid'=>$user['id']])
            ->field('id,mobile')
            ->find();
        //注册添加记录
        if(empty($userinfo['id'])){
            $u=$user['original'];
            $insert_data=[
                'addtime'=>date("Y-m-d H:i:s"),
                'nickname'=>$u['nickname'],
                'sex'=>$u['sex']!=2 ? 1-$u['sex'] : 1,
                'headimg'=>$u['headimgurl'],
                'wx_unionid'=>$u['openid'],
                'login_type'=>'weixin',
            ];
            Db::name('user')->insertGetId($insert_data);

        }
        if(empty($userinfo['mobile'])) header('Location:/wap/user/bindmobile');
        $where=[
            'wx_unionid'=>['eq',$user['id']],
        ];
        Db::name('user')
            ->where($where)
//            ->update(['headimg'=>$user['original']['headimgurl'],'last_login_time'=>date("Y-m-d H:i:s")]);
            ->update(['last_login_time'=>date("Y-m-d H:i:s")]);
        $uinfo=model('User')->getUserInfo($userinfo['id']);
        session('user',$uinfo);
        return true;
    }

    /**
     * 获取easywechat需要的所有配置
     */
    public function getWxConfig(){
        $wx_config=model('Config')->getConfig('weixin');
        return [
            //1.常规参数
            'debug'=>true,
            'app_id' => $wx_config['app_id'],
            'secret'  => $wx_config['secret'],     // AppSecret
            'token'   => $wx_config['token'],          // Token
            'aes_key' => $wx_config['aes_key'],
            //2.支付配置
            'payment' => [
                'merchant_id'        => $wx_config['merchant_id'],
                'key'                => $wx_config['key'],
                'cert_path'          => $wx_config['cert_path'], // XXX: 绝对路径！！！！
                'key_path'           => $wx_config['key_path'],      // XXX: 绝对路径！！！！
                'notify_url'         => $wx_config['notify_url'],       // 你也可以在下单时单独设置来想覆盖它
                // 'device_info'     => '013467007045764',
                // 'sub_app_id'      => '',
                // 'sub_merchant_id' => '',
            ],
            //3.oauth 配置
            'oauth' => ['scopes'=> ['snsapi_userinfo'], 'callback'=>'/wap/index/notify'],
            //4.log记录
            'log' => ['level'=> 'debug','permission' => 0777, 'file'=> '/tmp/easywechat.log'],
            //5.Guzzle全局配置
            'guzzle' => ['timeout' => 3.0, 'verify' => false],

        ];

    }
}