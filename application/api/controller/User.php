<?php
/**
 * Created by PhpStorm.
 * User: dang
 * Date: 2018/1/15
 * Time: 10:49
 */
namespace app\api\controller;
use think\Request;
use think\Log;
class User
{
    private $_request ;
    private $_userLogic ;
    private $_appid ;

    public function __construct(Request $request , \logicmodel\Login $alluser)
    {
        $this->_request = $request;
        $this->_userLogic = $alluser;
        $this->_appid=$this->_request->header('appid',123455);
    }
    /** 手机发送验证码
     * @return \think\response\Json
     */
    public function sendlogincode()
    {
        $mobile = $this->_request->param('mobile');
        return json($this->_userLogic->sendLoginCode($mobile,$this->_appid));
    }

    /** app账号密码登录接口
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function loginp()
    {
        $mobile = $this->_request->param('mobile');
        $pwd = $this->_request->param('pwd');
        $jtoken = $this->_request->param('jtoken');
        return json($this->_userLogic->login($mobile,$pwd,$jtoken));
    }

    /** app发送注册验证码
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function sendregcode()
    {
        $mobile = $this->_request->param('mobile');
        return json($this->_userLogic->sendRegCode($mobile,$this->_appid));

    }

    /** app用户注册
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function reguser()
    {
        $mobile = $this->_request->param('mobile');
        $pwd = $this->_request->param('pwd');
        $code = $this->_request->param('code');
        $appid = $this->_request->header('appid');
        Log::info($appid);
        $jtoken = $this->_request->param('jtoken');
        return json($this->_userLogic->regUser($mobile,$code,$pwd,$appid,$jtoken));
    }

    /** 根据验证码修改密码
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function updatepwd()
    {
        $mobile = $this->_request->param('mobile');
        $pwd = $this->_request->param('pwd');
        $code = $this->_request->param('code');
        return json($this->_userLogic->updatePwd($mobile,$code,$pwd,$this->_appid));
    }

    /**上传头像
     * @return \think\response\Json
     */
    public function uploadLogo()
    {
        $uid=$this->_request->param('userid');
        $base64 = $this->_request->param('image');
        return json($this->_userLogic->uploadHeading($uid,$base64));
    }

    /**修改用户性别
     * @return \think\response\Json
     */
    public function changeSex()
    {
        $uid=$this->_request->param('userid');
        $sex=$this->_request->param('sex');
        return json($this->_userLogic->changeSex($uid,$sex));
    }

    /**修改昵称
     * @return \think\response\Json
     */
    public function changeNickname()
    {
        $uid=$this->_request->param('userid');
        $name=$this->_request->param('name');
        return json($this->_userLogic->updateUserInfo($uid,$name));

    }

    public function test()
    {

        $data['title'] = '定金付款成功';
        $data['content'] = '定金付款金额￥20成功';
        $data['type'] = 10;
        $data['url'] = '#';
        $data['id'] = 0;
        $data['sendtime'] = date('Y-m-d H:i:s');
       \tybservice\TybJpush::push($data,'1507bfd3f78d76fe733');
    }


}