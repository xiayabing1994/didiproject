<?php
/**
 * Created shihe
 * User: shihe
 * desc: redis缓存的操作类，采用单例模式，防止单个请求重复重建redis实例
 * Date: 2017/4/27
 * Time: 17:18
 */
namespace tybservice;
use think\Config;
use think\Log;
use think\Request;
class TybUpload
{
    public static function uploadOne($filename,$rootpath)
    {
        $file = request()->file($filename);
        //$file->validate(['size'=>15678,'ext'=>'jpg,png,gif']);
        $info = $file->rule('md5')->move($rootpath);
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg

            return $info->getFilename();
        }else{
            // 上传失败获取错误信息
            return $file->getError();
        }
    }

    public static function uploadBase64($rootPath,$base64)
    {
        //$base64_image_content = $base64;
        //匹配出图片的格式
        $new_file = $rootPath;
        //dump($new_file);die;
        if (!file_exists($new_file)) {
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($new_file, 0777,true);
        }
        $new_file = $new_file.time().mt_rand(1000000,9999999) . ".jpg";
        if (file_put_contents($new_file, base64_decode($base64))) {
            $img_path = str_replace($rootPath, '', $new_file);
            return ['errcode'=>0,'msg'=>'新文件保存成功','result'=>$img_path];

        } else {
            return ['errcode'=>1,'msg'=>'新文件保存失败'];
        }

    }

}