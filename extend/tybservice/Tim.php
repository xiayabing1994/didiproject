<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/21
 * Time: 10:09
 */
namespace tybservice;
class Tim
{
    public static function  getSign($id)
    {
        $private_pem_path = EXTEND_PATH."tim/ec_key.pem";
        import('tim.TimApi',EXTEND_PATH);
        $api = createRestAPI();
        // $api->init($sdkappid, $identifier);
        $api->init(' 1400191103', 'mengduo');
        $signature = get_signature();
        $expiry_after = 86400;//一天有效期
        $ret = $api->generate_user_sig((string)$id, $expiry_after, $private_pem_path, $signature);
        return $ret[0];
    }
}