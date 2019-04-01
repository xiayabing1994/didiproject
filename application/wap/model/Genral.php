<?php
namespace  app\wap\model;
use think\Model;
use think\Db;
class Genral extends Model{
    public function getQuestionList(){
        return Db::name('question')->where(['iseffect'=>1])->select();
    }
}