<?php

namespace tybservice;

use think\Log;

class TybJpush
{
    public static function push($data, $jtoken)
    {
        try{
            vendor('Jpush.autoload');
            $app_key = 'fb38ca8a89d253c642865bd9';
            $master_secret = '951cb8a08c469bc329c15c26';
            $client = new \JPush\Client($app_key, $master_secret);
            $pusher = $client->push();
            $pusher->setPlatform('all');
            if ($jtoken !== 'all') {
                $pusher->addRegistrationId($jtoken);
                Log::info(json_encode(['jtoken' => $jtoken]));
            } else {
                $pusher->addAllAudience();
                Log::info('全部');
            }
            $pusher->setNotificationAlert($data['content']);
            $pusher->iosNotification($data['content'], [
                'sound' => 'yuyin.caf',
                'badge' => '+1',
                'mutable-content' => true,
                'extras' => [
                    'url' => $data['url'],
                    'id' => $data['id'],
                    'type' => $data['type']
                ]
            ]);
            $pusher->androidNotification($data['content'], [
                'title' => $data['title'],
                'extras' => [
                    'url' => $data['url'],
                    'id' => $data['id'],
                    'type' => $data['type'],
                    'title' => $data['title'],
                    'content' => $data['content']
                ]
            ]);
            $pusher->options(['apns_production' => true]);

            $pusher->send();

            $res = $pusher->validate();
            //return $res;
            Log::info(json_encode($res));
            if ($res['body']['sendno'] > 0) {
                return true;
            } else {
                return false;
            }


        }catch (\Exception $e){
            Log::error('jpush异常3' . $e->getMessage());
            return false;
        }
    }

}