<?php
namespace  app\api\controller;
use think\Controller;
use JPush\Exceptions\APIConnectionException;
use JPush\Exceptions\APIRequestException;
use JPush\Client as JPush;



class Push extends Controller{
    public function  index(){
        $app_key="fb38ca8a89d253c642865bd9";
        $master_secret="951cb8a08c469bc329c15c26";
        $client = new JPush($app_key, $master_secret);
        $res=$client->push()
            ->setPlatform('all')
            ->addAllAudience('1507bfd3f78d76fe733')
            ->setNotificationAlert('hhaha')
            ->send();
        dump($res);
    }
}