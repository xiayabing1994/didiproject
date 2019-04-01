<?php
namespace app\wap\model;
use think\Db;
class Config {
    public function __construct(){

    }
    public function getConfig($group=''){
       $fields='id,name,group,value';
       if($group!=''){
           $configs=Db::name('config')->where('group',$group)->field($fields)->select();
           foreach($configs as $config){
               $res[$config['name']]=trim($config['value']);
           }
       }else{
           $configs=Db::name('config')->field($fields)->select();
           $res=[];
           foreach($configs as $config){
               $res[$config['group']][$config['name']]=trim($config['value']);
           }
       }
       return $res;
    }

}