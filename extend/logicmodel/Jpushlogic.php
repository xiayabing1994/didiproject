<?php
namespace  logicmodel;
use think\Db;
class Jpushlogic{
    private $_client;
    public function __construct(){
        $app_conf=load_config('app');
        $this->_client=new \JPush\Client($app_conf['jpush_appkey'],$app_conf['jpush_appsecret']);
    }

    /**
     * 补交尾款推送
     */
    public function  payFinalPush($pid){
        $res=[];
        $users=Db::name('pordernum')->alias('p')
            ->join('user u','p.userid=u.id','LEFT')
            ->join('porder po','p.porderid=po.id','LEFT')
            ->field('u.id as userid,u.nickname,u.jtoken,p.id,p.type,po.pname')
            ->where('p.porderid',$pid)
            ->where('p.state','2')
            ->select();
        dump($users);

        $lasttime=time()-load_config('app')['push_gap_second'];
        foreach($users as $user){
            if(Db::name('push_log')->where(['pnumid'=>$user['id'],'event'=>'final','createtime'=>['>',$lasttime]])->count()){
               continue;
            }
            $content=[
                'app'=>'滴滴打药',
                'user'=>$user,
                'title'=>'补交尾款通知',
                'describe'=>$user['nickname'].',您参与的【'.$user['pname']."】的拼单已经拼单完成,请及时补交尾款准备作业",
                'data'=>['event'=>'final','pnumid'=>$user['id'],'type'=>$user['type']],
            ];
            $res[]=$this->push($user['jtoken'],$content);
            $this->addPushLog($content,$res);
        }
       return $res;
    }
    /**
     * 作业完成推送
     */
    public function  finishPush($pid){
        $res=[];
        $users=Db::name('pordernum')->alias('p')
            ->join('user u','p.userid=u.id','LEFT')
            ->join('porder po','p.porderid=po.id','LEFT')
            ->field('u.id as userid,u.nickname,u.jtoken,p.id,p.type,po.pname')
            ->where('p.porderid',$pid)
            ->where('p.state','4')
            ->select();
        dump($users);

        $lasttime=time()-load_config('app')['push_gap_second'];
        foreach($users as $user){
            if(Db::name('push_log')->where(['pnumid'=>$user['id'],'event'=>'finish','createtime'=>['>',$lasttime]])->count()){
                continue;
            }
            $content=[
                'app'=>'滴滴打药',
                'user'=>$user,
                'title'=>'拼单完成通知',
                'describe'=>$user['nickname'].',您参与的【'.$user['pname']."】的拼单已经作业完成",
                'data'=>['event'=>'finish','pnumid'=>$user['id'],'type'=>$user['type']],
            ];
            $res[]=$this->push($user['jtoken'],$content);
            $this->addPushLog($content,$res);
        }
        return $res;
    }
    private function addPushLog($content,$res){
        $insert_arr=[
            'pnumid'=>$content['data']['pnumid'],
            'event'=>$content['data']['event'],
            'userid'=>$content['user']['userid'],
            'nickname'=>$content['user']['nickname'],
            'title'=>$content['title'],
            'describe'=>$content['describe'],
            'createtime'=>time(),
            'extras'=>json_encode($content['data'],JSON_UNESCAPED_UNICODE),
            'state'=>empty($res) ? 'fail' : 'success',
        ];
        return Db::name('push_log')->insertGetId($insert_arr);
    }
    private function push($audience_id,$content){
        $res=$this->_client->push()
            ->setPlatform('all')
//            ->addAllAudience('1507bfd3f78d76fe733')
            ->addRegistrationId($audience_id)
        ->setNotificationAlert($content['app'])
        ->androidNotification($content['describe'], array(
            'title' => $content['title'],
            // 'builder_id' => 2,
            'extras' => $content['data']
        ))
        ->message('message content', array(
            'title' => 'hello jpush',
            // 'content_type' => 'text',
            'extras' => array(
                'key' => 'value',
                'jiguang'
            ),
        ))
        ->options(array(
            // sendno: 表示推送序号，纯粹用来作为 API 调用标识，
            // API 返回时被原样返回，以方便 API 调用方匹配请求与返回
            // 这里设置为 100 仅作为示例
            // 'sendno' => 100,
            // time_to_live: 表示离线消息保留时长(秒)，
            // 推送当前用户不在线时，为该用户保留多长时间的离线消息，以便其上线时再次推送。
            // 默认 86400 （1 天），最长 10 天。设置为 0 表示不保留离线消息，只有推送当前在线的用户可以收到
            // 这里设置为 1 仅作为示例
             'time_to_live' => 86400,
            // apns_production: 表示APNs是否生产环境，
            // True 表示推送生产环境，False 表示要推送开发环境；如果不指定则默认为推送生产环境
            //'apns_production' => true,
            // big_push_duration: 表示定速推送时长(分钟)，又名缓慢推送，把原本尽可能快的推送速度，降低下来，
            // 给定的 n 分钟内，均匀地向这次推送的目标用户推送。最大值为1400.未设置则不是定速推送
            // 这里设置为 1 仅作为示例
            // 'big_push_duration' => 1
        ))
        ->send();
        return $res;
    }
}