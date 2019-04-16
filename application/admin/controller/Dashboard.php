<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Config;
/**
 * 控制台
 *
 * @icon fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Dashboard extends Backend
{

    /**
     * 查看
     */
    public function index()
    {
        $seventtime = \fast\Date::unixtime('day', -7);
        $paylist = $createlist = [];
        for ($i = 0; $i < 7; $i++)
        {
            $day = date("Y-m-d", $seventtime + ($i * 86400));
            $createlist[$day] = mt_rand(20, 200);
            $paylist[$day] = mt_rand(1, mt_rand(1, $createlist[$day]));
        }
        $hooks = config('addons.hooks');
        $uploadmode = isset($hooks['upload_config_init']) && $hooks['upload_config_init'] ? implode(',', $hooks['upload_config_init']) : 'local';
        $addonComposerCfg = ROOT_PATH . '/vendor/karsonzhang/fastadmin-addons/composer.json';
        Config::parse($addonComposerCfg, "json", "composer");
        $config = Config::get("composer");
        $addonVersion = isset($config['version']) ? $config['version'] : __('Unknown');
        $totalUser=model('User')->getTotalUsers();
        $totalOrder=model('Order')->getTotalOrders();
        $totalPub=model('Porder')->getTotalPubs();
        $totalJoin=model('Pordernum')->getTotalJoins();
        $this->view->assign([
            'totaluser'        => $totalUser['totaluser'],
            'todayuserlogin'   => $totalUser['todayuserlogin'],
            'todayusersignup'  => $totalUser['todayusersignup'],
            'sevendnu'         => ($totalUser['sevendnu']*100).'%',
            'sevendau'         => ($totalUser['sevendau']*100).'%',
            'totalorder'       => $totalOrder['totalorder'],
            'totalorderamount' => $totalOrder['totalorderamount'],
            'todayorder'       => $totalOrder['todayorder'],
            'unpayorder'       => $totalOrder['unpayorder'],
            'totalpub'         => $totalPub['totalpub'],
            'totaljoin'        => $totalJoin['totaljoin'],
            'paylist'          => $paylist,
            'createlist'       => $createlist,
            'addonversion'       => $addonVersion,
            'uploadmode'       => $uploadmode
        ]);

        return $this->view->fetch();
    }

}
