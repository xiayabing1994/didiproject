<?php
namespace  app\wap\model;
use think\Db;
class Land extends Base{
    public function __construct(){
    }

    /**
     * 添加一条land表记录
     */
    public function addLand($data){
        $data['userid']=session('user.id');
        $points=$this->pointDeal($data['point']);
        $data['point']=$points['points'];
        $data['centerX']=$points['centX'];
        $data['centerY']=$points['centY'];
        $data['addtime']=date('Y-m-d H:i');
        return Db::name('land')->insertGetId($data);
    }

    /**
     * 更改土地名字
     */
    public function updLandName($land_id,$name){
        return Db::name('land')->where('id',$land_id)->update(['name'=>$name]);
    }

    /**
     * 根据土地id或ids串计算土地总面积
     */
    public function getLandArea($landid){
        $area=0;
        $land_arr=explode(',',$landid);
        foreach($land_arr as $v){
            $area+= Db::name('land')->where('id',$v)->find()['area'];
        }
        return $area;
    }
    private function pointDeal($points){
        $points=json_decode($points,1);
        $arr=[];
        $centX=0;
        $centY=0;
        foreach($points as $point){
            $arr[]=$point['lat'].','.$point['lng'];
            $centX+=$point['lat'];
            $centY+=$point['lng'];
        }
        $res=[
            'points'=>implode(';',$arr),
            'centX'=>$centX/count($arr),
            'centY'=>$centY/count($arr),
        ];
        return $res;
    }
}