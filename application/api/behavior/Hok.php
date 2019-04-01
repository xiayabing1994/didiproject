<?php
namespace app\api\behavior;

class Hok{
    public function run333(){
        file_put_contents('./run.txt','hook::run');
    }
    public function smsSend($data){
        dump($data);die;
        return 1111;
    }
    public function api_end(){
        echo '初始化结束';
    }
}