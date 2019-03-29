<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:83:"/www/wwwroot/didi.xlove99.top/public/../application/wap/view/user/measure_auto.html";i:1553581587;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/header.html";i:1553069199;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no, viewport-fit=cover">
    <title>滴滴打药</title>
    <link rel="stylesheet" href="/wapassets/weui/lib/weui.min.css">
    <link rel="stylesheet" href="/wapassets/weui/css/jquery-weui.css">
    <link rel="stylesheet" href="/wapassets/static/css/page.css">
</head>
<script type="text/javascript" src="/wapassets/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/wapassets/weui/js/jquery-weui.js"></script>
<script type='text/javascript' src='/wapassets/weui/js/swiper.js'></script>
<script type="text/javascript" src="/wapassets/static/js/my.js"></script>
<style type="text/css">
    .mapBox{
        position: absolute;
        padding-top: 2.25rem;
        padding-bottom: 6rem;
        width: 100%;
        height: 100%;
        z-index: 1;
        left: 0;
        top: 0;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    #map {
        width: 100%;
        height: 100%;
    }
    .zh-measure-land{
        position: absolute;
        top:10px;
        right:10px;
        width:2.2rem;
        height:2.2rem;
        -webkit-border-radius:3px;
        -moz-border-radius:3px;
        border-radius:3px;
        z-index: 1;
        background-color: #fff;
        color: #62CAA4;
        text-align: center;

    }
    .zh-measure-land p,.mapSavaReturn p{
        line-height: 20px;
    }
    /* .mapBigSm{
         position: absolute;
         width:2rem;
         bottom: 60px;
         left:10px;
         z-index: 1;
         text-align: center;
         line-height: 2rem;
     }*/
    .mapBigSm span{
        width:2.2rem;
        height: 2.2rem;
        background-color: rgba(255,255,255,.7);
        margin-top:1px;
    }
    .mapSavaReturn{
        position: absolute;
        bottom: 20px;
        right:10px;
        z-index: 1;
        text-align: center;
        width:2.2rem;
    }
    .mapSavaReturn span{
        width:2.2rem;
        height:2.2rem;
        -webkit-border-radius:3px;
        -moz-border-radius:3px;
        border-radius:3px;
        background-color: #fff;
    }
    .yj-bg-main{
        background-color: #62CAA4;
    }
    .mapdata{
        width: 100%;
        height: 6rem;
        bottom: 0;
        left: 0;
        /*padding-top:.4rem;*/
    }
</style>

<body>
<header class="yj-header yj-bg-fff">
    <a class="yj-header-return" href="javascript:history.go(-1);">
        <img src="/wapassets/static/images/arrow_return.png">
    </a>
    <span>实地测量</span>
    <a class="yj-text-sm yj-color-main yj-pad-r" onclick="saveMarker()">保存</a>
</header>
<div class="yj-content yj-mainH">
    <div class="mapBox">
        <div class="yj-relative" style="width: 100%; height: 100%;">
            <div id="map"></div>
        </div>
        <div class="mapdata yj-text-center yj-bg-fff">
            <p class="yj-pad-tb yj-border-b">
                <a class="yj-btn yj-sm marksPointbtn" onclick="marksPoint()">标注当前点</a>
                <a class="yj-btn yj-sm resetPointBtn" style="display: none;" onclick="resetPoint()">重新标注</a>
                <a class="yj-btn yj-sm yj-mar-lr-big" onclick="withdrawPoint()">撤回标注</a>
                <a class="yj-btn yj-sm yj-main" onclick="finishPoint()">标注完成</a>
            </p>

            <div class="yj-display-flex yj-pad-t">
                <div class="yj-flex-1">
                    <p>周长</p>
                    <p class="yj-color-main"><i id="perimeter">0</i>m</p>
                </div>
                <div class="yj-flex-1">
                    <p>面积</p>
                    <p class="yj-color-main"><i id="area">0</i>㎡</p>
                </div>
                <div class="yj-flex-1">
                    <p>亩数</p>
                    <p class="yj-color-main"><i id="muArea">0</i>亩</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</body>
<script type="text/javascript" src="/wapassets/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/wapassets/weui/js/jquery-weui.js"></script>
<script src="https://webapi.amap.com/maps?v=1.4.13&key=0601e77dea5d2aeaaa9fdfac91f4952e&plugin=AMap.PolyEditor"></script>


<!-- UI组件库 1.0 -->
<script src="https://webapi.amap.com/ui/1.0/main.js?v=1.0.11"></script>
<script type="text/javascript" src="/wapassets/static/js/markLand_auto.js"></script>
</html>