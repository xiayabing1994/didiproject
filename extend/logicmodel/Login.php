<?php
namespace logicmodel;
use think\Cache;
use tybservice\TybSendMessage;
use tybservice\TybValidator;
use think\Log;
use tybservice\TybUpload;

class Login
{
    private $_alluser;
    public function __construct()
    {
        $this->_alluser = new \datamodel\User();
    }

    /** 发送登陆验证码
     * @param $mobile
     * @param $appid
     * @return mixed
     */
    public function sendLoginCode($mobile, $appid)
    {
        return $this->sendCode($mobile,$appid);
    }

    /** 发送验证码
     * @param $mobile
     * @param $appid
     * @return array
     */
    private function sendCode($mobile,$appid)
    {

        if(TybValidator::isPhone($mobile)&&strlen($appid)>0) {
            $mcode = mt_rand(100000, 999999);
            $res = TybSendMessage::sendSMS($mobile, $mcode);
            \think\Log::info('短信接口调用结果为'.json_encode($res));
            if ($res['errcode'] === 0) {
                Cache::set("{$appid}mcode", ['code' => $mcode, 'mobile' => $mobile], 300);
                return ['errcode' => 0, 'msg' => '短信已发送'];
            } else {
                return ['errcode' => 2, 'msg' => '短信发送失败'];
            }
        }
        else
        {
            return ['errcode'=>5,'msg'=>"手机号格式不正确或appid为空"];
        }
    }


    /** 账号密码登录
     * @param string $mobile
     * @param string $pwd
     * @param string $appid
     * @param string|int $jtoken
     * @return array
     * @throws \think\Exception
     */
    public function login($mobile,$pwd,$jtoken)
    {
        if(TybValidator::isPhone($mobile))
        {
            if($myuser = $this->getUserByMobile($mobile))
            {
                $u = $this->getUserByPwd($mobile,md5($pwd.$myuser['salt']));
                if($u)
                {
                    if($u['state']==1){
                        return ['errcode'=>7,'msg'=>'用户被禁止登陆'];
                    }
                    Log::info('用户信息错误'.json_encode($u));
                    if($u['jtoken']!=$jtoken)
                    {
                        $this->_alluser->updateEntity(['id'=>$u['id']],['jtoken'=>$jtoken]);
                    }
                    $usersign=\tybservice\Tim::getSign($mobile);
                    return ['errcode'=>0,'msg'=>'登录成功','result'=>['res'=>$myuser,'userusign'=>$usersign]];
                }
                else
                {
                    return ['errcode'=>6,'msg'=>'用户名或密码不正确'];
                }

            }
            else
            {
                return ['errcode'=>3,'msg'=>'登录错误，用户不存在'];
            }


        }
        else
        {
            return ['errcode'=>5,'msg'=>"手机号格式不正确或密码太短"];
        }
    }

    //根据手机号查找用户

    /**
     * @param string $mobile : 手机号
     * @return array $u[0] : 用户信息
     * @throws \think\Exception
     */
    private function getUserByMobile($mobile)
    {
        $u = $this->_alluser->queryfind(['mobile' => $mobile], ['*']);
        Log::info(empty($u));
        if(empty($u)){
            return null;
        }
        return $u;

    }

    /** 用户注册
     * @param string $mobile : 手机号
     * @param string $code : 验证码
     * @param string $pwd : 密码
     * @param string $appid : 手机标识
     * @param string|int $jtoken : 极光推送id
     * @return array
     * @throws \think\Exception
     */
    public function regUser($mobile,$code,$pwd,$appid,$jtoken)
    {
        $mycode = Cache::get("{$appid}mcode");
        \think\Log::info('缓存中的验证码为：'.json_encode($mycode));
        if($mycode&&$mycode['code']==$code&&$mycode['mobile']==$mobile) {
        $u=$this->getUserByMobile($mobile);
        if($u)
        {
            return ['errcode' => 7,'msg'=> '此手机号已经被注册，请更换手机号'];
        }
        else {
                $salt = mt_rand(100000, 999999);
                $pwd = md5($pwd . $salt);
                $username = uniqid();
                $userdata = ['mobile' => $mobile,'nickname'=>'农场主', 'salt' => $salt, 'name' => $username, 'password' => $pwd, 'jtoken'=>$jtoken,'addtime' => date('Y-m-d H:i:s')];
                $uid = $this->_alluser->addEntityReturnID($userdata);
                if ($uid > 0) {
                    $userusign=\tybservice\Tim::getSign($mobile);
                    return ['errcode'=>0,'msg'=>'注册成功','result'=>['uid'=>$uid,'userusign'=>$userusign]];
                }
                return ['errcode' => 5, 'msg' => "注册失败，请重试"];
            }

        }
        else
        {
            return ['errcode'=>2,'msg'=>'验证码错误，请重试'];
        }
    }

    /** 查询账号密码是否正确
     * @param string $mobile
     * @param string $pwd
     * @return mixed
     * @throws \think\Exception
     */
    public function getUserByPwd($mobile,$pwd)
    {
        $where['mobile']=$mobile;
        $where['password']=$pwd;
        $u = $this->_alluser->queryEntity($where,["*"]);
        if (empty($u)){
            return false;
        }else{
            return $u[0];
        }
    }

    /** 注册验证码
     * @param string $mobile
     * @param string $appid
     * @return array
     * @throws \think\Exception
     */
    public function sendRegCode($mobile,$appid)
    {
        $u = $this->getUserByMobile($mobile);
        if ($u) {
            return ['errcode' => 1,'msg'=> '此手机号已经被注册，请更换手机号'];

        } else {
            return $this->sendCode($mobile,$appid);
        }
    }

    /** 根据验证码修改密码
     * @param string $mobile : 手机号
     * @param string $code : 验证码
     * @param string $pwd : 密码
     * @param string $appid : 手机唯一标识
     * @return array
     * @throws \think\Exception
     */
    public function updatePwd($mobile,$code,$pwd,$appid)
    {
        $mycode = Cache::get("{$appid}mcode");
        \think\Log::info('缓存中的验证码为：'.json_encode($mycode));
        if($mycode&&($mycode['code']==$code)&&($mycode['mobile']==$mobile))
        {
            $u = $this->getUserByMobile($mobile);
            if(!$u)
            {
                return ['errcode'=>3,'msg'=>'用户不存在'];
            }
            else
            {
                $pwd=md5($pwd.$u['salt']);
                $userdata=['password'=>$pwd];
                $res= $this->_alluser->updateEntity(['id'=>$u['id']],$userdata);
                if($res!==false)
                {
                    return ['errcode'=>0,'msg'=>"密码更改成功"];
                }
                else
                {
                    return ['errcode'=>1,'msg'=>"密码更改失败"];
                }
            }
        }
        else
        {
            return ['errcode'=>2,'msg'=>'验证码错误，请重试'];
        }
    }

    /**上传头像
     * @param $uid int 用户uid
     * @param $base64 string base64文件
     * @return array
     */
    public function baseUpload($uid, $base64)
    {
        if(isset($base64))
        {
            $rootPath = './uploads/userlogo/';
            $res = TybUpload::uploadBase64($rootPath,$base64);
            if($res['errcode']==0)
            {
                $data['headimg'] = '/uploads/userlogo/'.$res['result'];
                $where['id']=$uid;
                $up = $this->_alluser->updateEntity($where,$data);
                if($up!==false)  return '/uploads/userlogo/'.$res['result'];
                return false;
            }
            return false;
        }
    }
    public function fileUpload($uid,$file){
        // 获取表单上传文件 例如上传了001.jpg
        $rootPath = './uploads';
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move($rootPath);
            if($info){
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $img_path=$info->getSaveName();
                $up = $this->_alluser->updateEntity(['id'=>$uid],['headimg'=>'/uploads/'.$img_path]);
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                if($up) return '/uploads/'.$img_path;
                return false;
            }else{
                return false;
            }
        }
    }

    /**更新昵称
     * @param $uid
     * @param $name
     * @return array
     */
    public function updateUserInfo($uid,$name)
    {

        if(mb_strlen($name,'UTF-8')>15){
            return ['errcode'=>1,'msg'=>'昵称不能超过15个字符'];
        }
        $where['id'] = $uid;
        $res = $this->_alluser->updateEntity($where,['nickname'=>$name]);
        if($res!==false)
        {
            return ['errcode'=>0,'msg'=>'修改成功'];
        }else
        {
            return ['errcode'=>1,'msg'=>'修改失败'];
        }
    }

    /**修改用户性别
     * @param $uid int 用户id
     * @param $sex int 用户性别
     * @return array
     */
    public function changeSex($uid,$sex)
    {
        $where['id'] = $uid;
        $res = $this->_alluser->updateEntity($where,['sex'=>$sex]);
        if($res!==false)
        {
            return ['errcode'=>0,'msg'=>'修改成功'];
        }else
        {
            return ['errcode'=>1,'msg'=>'修改失败'];
        }
    }
}