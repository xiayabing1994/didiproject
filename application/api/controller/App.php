<?php
namespace  app\api\controller;
use think\Controller;
use think\Db;
class App extends Controller{
    public function init(){
        return json(load_config());
    }

    public function sys_clear_all(){
        $arr['user']=Db::name('user')->delete(true);
        $arr['order']=Db::name('order')->delete(true);
        $arr['porder']=Db::name('porder')->delete(true);
        $arr['pordernum']=Db::name('pordernum')->delete(true);
        $arr['land']=Db::name('land')->delete(true);
        $arr['profit']=Db::name('profit')->delete(true);
        $arr['sms']=Db::name('sms')->delete(true);
        dump($arr);
    }
}