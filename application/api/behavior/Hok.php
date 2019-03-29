<?php
namespace app\api\behavior;

class Hok{
    public function run(){
        file_put_contents('./run.txt','hook::run');
    }
    public function apiTest(){
        return 1111;
    }
    public function api_end(){
        echo '初始化结束';
    }
}