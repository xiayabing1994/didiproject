<?php
namespace  app\wap\controller;
use think\Request;
use think\Cache;
class User extends Base{
    private $_request;
    public function __construct(Request $request){
        $this->_request=$request;
        parent::__construct();
    }

    public function index(){
        $userinfo=session('user');
        $sex_img=$userinfo['sex']==0 ? 'man' : 'woman';
        $this->assign('order_states',model('Order')->getOrderStates($userinfo['id']));
        $this->assign('sex_img',$sex_img);
        return $this->fetch();
    }
    public function userinfo(){
        $this->assign('sex',session('user.sex'));
        return $this->fetch();
    }
    public function myOrder(){
        $state='';
        if(input('?map'))  $state=input('map');
        $myorders=model('Order')->getOrders(session('user.id'),$state);
        $this->assign('empty','<div class="yj-text-center"><img src="/wapassets/static/images/nodatapic.png" width="60%"><p class="yj-color-gray-light yj-mar-t-big">暂无数据</p></div>');
        $this->assign('myorders',$myorders);
        return $this->fetch();
    }
    public function myLand(){
        $my_land=model('user')->getMyLand(session('user.id'));
        $this->assign('empty','<div class="yj-text-center"><img src="/wapassets/static/images/nodatapic.png" width="60%"><p class="yj-color-gray-light yj-mar-t-big">暂无数据</p></div>');
        $this->assign('my_land',$my_land);
        return $this->fetch();
    }
    public function addLand(){
        return $this->fetch();
    }
    public function myProfit(){
        $profits=model('User')->getTotalProfit(session('user.id'));
        $this->assign('profits',$profits);
        return $this->fetch();
    }
    public function rename(){
        return $this->fetch();
    }
    public function bindMobile(){
        return $this->fetch();
    }
    public function measure_auto(){
        return $this->fetch();
    }
    public function measure(){
        return $this->fetch();
    }
    //微信登录绑定手机号处理
    public function bind(){
        $mobile = $this->_request->param('mobile');
        if(db('user')->where('mobile',$mobile)->find()){
            $this->error('该手机号码已经绑定','bindmobile');
        }
        $code = $this->_request->param('code');
        $mycode = Cache::get("{$mobile}mcode");
        if($mycode&&$mycode['code']==$code&&$mycode['mobile']==$mobile) {
             $wx_user=session('wx_user');
             if(db('user')->where('wx_unionid',$wx_user['id'])->update(['mobile'=>$mobile])){
                 $this->success('绑定成功','/wap/index');
             }else{
                 $this->error('绑定失败','bindmobile');
             }

        }else{
            $this->error('绑定失败','bindmobile');
        }
    }
    public function sessionRefresh(){
        $userinfo=model('User')->getUserInfo(session('user.id'));
        return session('user',$userinfo);

    }
    public function question(){
        $this->assign('questions',model('Genral')->getQuestionList());
        return $this->fetch();
    }
}