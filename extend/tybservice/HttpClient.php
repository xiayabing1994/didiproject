<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/25
 * Time: 16:28
 */
namespace tybservice;
use think\Exception;
vendor("vendor/autoload");
use GuzzleHttp\Exception\RequestException;
class HttpClient
{
    private $_guzzle;
    private  $_header;
    private $_timeout;



    public function __construct(float $timeout=20)
    {
        $this->_guzzle = new \GuzzleHttp\Client(['verify' => false]);
        //$this->_guzzle = new \GuzzleHttp\Client();

        $this->_timeout=$timeout;


    }

    public function get(string $url,array $query=null)
    {


        if($query)
        {
            $query= ['query'=>$query];
        }


         return $this->excuteRequest('GET',$url,$query);


    }

    /**
     * desc:发送post请求
     * @param string $url
     * @param float $timeout
     * @param array|null $postData,发送的key_value数组，会自动转换form表单的key=value形式，如果参数的value是json字符串，请json_encode(数组)或手动拼接，e.q:
     * $postData=['data'=>"[{\"userid\":3212,\"orderid\":1000,\"couponid\":857506,\"usecoupon\":10},{\"userid\":3212,\"orderid\":121000,\"couponid\":857156,\"usecoupon\":9}]"],此处data为key,值是一个json数组字符串

     * @return \Psr\Http\Message\StreamInterface
     */
    public function post(string $url,array $postData=null)
    {

        if($postData)
        {
           $postData=['form_params'=>$postData];
        }
       return $this->excuteRequest('POST',$url,$postData);
    }
    public function postJson(string $url,array $jsonData=null)
    {
        if($jsonData)
        {
            $jsonData=['json'=>$jsonData];
        }
        return $this->excuteRequest('POST',$url,$jsonData);
    }
    public function excuteRequest(string $requestType,$url,$param)
    {
//        $res='method not run,please check';
        try
        {
            $sendData=['timeout'=>$this->_timeout];
            if($param)
            {
                $sendData=array_merge($sendData,$param);
            }
            if($this->_header)
            {
                $sendData=array_merge($sendData,['headers'=>$this->_header]);
            }
            $res=$this->_guzzle->request($requestType,$url,$sendData)->getBody();

        }
        catch (RequestException $e)
        {
           $res=$e->getMessage();
           throw new Exception("Error Processing Request".$res, 44444);
    
        }
        return $res;
    }
    public function setTimeOut(float $timeout)
    {
        $this->_timeout=$timeout;


    }
    public function setHeader(array $header)
    {
        $this->_header=$header;
    }

}