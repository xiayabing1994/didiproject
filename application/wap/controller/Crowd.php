<?php
namespace  app\wap\controller;
use think\Controller;
use think\Env;
class Crowd extends Controller{
    /**
     * 发布拼单首页
     */
    public function index(){
        return $this->fetch();
    }

    /*
     * 1.直接下单
     */
    public function xiadan(){
        $myLand=model('User')->getMyLand(session('user.id')); //获取土地列表
        $pesticides=model('Crowd')->getPesticides();
        $this->assign('my_land',$myLand);
        $this->assign('pesticides',$pesticides);
        return $this->fetch();
    }
    /*
     * 2.拼单页面
     * */
    public function pindan(){
        $myLand=model('User')->getMyLand(session('user.id')); //获取土地列表
        $pesticides=model('Crowd')->getPesticides();
        $this->assign('my_land',$myLand);
        $this->assign('pesticides',$pesticides);
        $this->assign('empty','<span class="yj-color-red">没有数据</span>');
        return $this->fetch();
    }
    /**
     * 3.选择土地加入拼单
     */
    public function join(){
        $myLand=model('User')->getMyLand(session('user.id')); //获取土地列表
        $pesticides=model('Crowd')->getPesticides();
        $this->assign('my_land',$myLand);
        $this->assign('pesticides',$pesticides);
        return $this->fetch();
    }
    /**
     * 1.处理直接下单信息
     */
    public function placeDeal(){
        $data=input('param.');
        $p_no=model('Crowd')->addCrowd(0,$data);    //
        $price=model('\logicmodel\Pordernumlogic')->getPorderMoney($p_no); //根据土地面积获取订金价格
        $this->assign('p_no',$p_no);
        $this->assign('price',$price);
        $this->assign('p_msg','直接下单金额');
        return $this->fetch('deal');
    }

    /**
     * 2.处理发布拼单信息
     */
    public function deal(){
        $data=input('param.');
        $p_id=model('Crowd')->createCrowd($data);     //创建拼单信息
        $p_no=model('Crowd')->addCrowd($p_id,$data);    //添加参与拼单信息
        $price=model('\logicmodel\Pordernumlogic')->getPorderMoney($p_no); //根据土地面积获取订金价格
        $this->assign('p_no',$p_no);
        $this->assign('price',$price);
        $this->assign('p_msg','发布拼单订金');
        return $this->fetch();
    }
    /**
     * 3.处理加入拼单的信息
     */
    public function join_deal(){
        $data=input('post.');
        $p_no=model('Crowd')->addCrowd($data['p_id'],$data);  //添加参与拼单信息
        $price=model('\logicmodel\Pordernumlogic')->getPorderMoney($p_no); //根据土地面积获取订金价格
        $this->assign('p_no',$p_no);
        $this->assign('price',$price);
        $this->assign('p_msg','参与拼单订金');
        return $this->fetch('deal');
    }
    /**
     * 拼单信息详情页
     */
    public function detail(){
        $crowd_info=model('Order')->getPorderInfo(input('id'));
        $this->assign('crowd_info',$crowd_info);
        return view('detail');
    }

    /**
     * 拼单信息分享
     */
    public function share(){
        $wxconfig=[
            'appId'=>Env::get('weixin.appid'),
            'timestamp'=>time(),
            'nonceStr'=>time().rand(10000,99999),
            'signature'
        ];
        $this->assign('timestamp',time());
        return $this->fetch();
    }


}