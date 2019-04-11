<?php
namespace  app\wap\controller;
use EasyWeChat\Foundation\Application;
use think\Hook;
class Index extends Base{
    private $config;
    private $app;
    public function __construct(){
        parent::__construct();
        Hook::add('weixin_login',"\app\wap\model\Weixin");
        $this->config=model('Weixin')->getWxConfig();
        $this->app=new Application($this->config);
    }
    /**
     * 微信公众号首页页面    判断登录  显示首页信息
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\think\response\View
     */
    public function index(){
//        session(null);
       // 未登录
        if (!session("wx_user")) {
            $oauth = $this->app->oauth;
            return $oauth->redirect();
        }
        $user=session('wx_user');
        Hook::listen('weixin_login',$user);
        $map=input('param.');
        $aroundOrders=model('order')->getAroundOrders($map);
        $myland=model('user')->getMyLand(session('user.id'));
        $this->assign('myland',$myland);
        $this->assign('aroundOrders',$aroundOrders);
        $this->assign('banners',$this->getBanner());
        return $this->fetch('');
    }
    /**
     * 网页授权回调页面,负责承接业务逻辑跳转
     */
    public function notify(){
        $oauth = $this->app->oauth;
        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
        session('wx_user',  $user->toArray());
        $targetUrl =  '/wap/index';
        header('location:'. $targetUrl);
    }
    public function share(){
        $js = $this->app->js;
        $this->assign('wxconfig',$js->config(['onMenuShareAppMessage','onMenuShareTimeline','updateAppMessageShareData','updateTimelineShareData'],false));
        return $this->fetch();
    }
    /**
     *  获取banner数组
     */
    private function getBanner(){
      return db('banner')->where('isshow',0)->order('order','desc')->select();
    }
}