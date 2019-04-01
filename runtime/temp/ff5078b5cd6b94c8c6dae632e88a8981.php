<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:76:"/www/wwwroot/didi.xlove99.top/public/../application/wap/view/user/index.html";i:1553924252;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/header.html";i:1553069199;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/footer.html";i:1553769052;}*/ ?>
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
<body>
<header class="yj-header yj-bg-main">
    <a class="yj-header-meau"></a>
    <span>个人中心</span>
    <a class="yj-header-meau" href="user/userinfo" style="font-size: 0;"><img class="yj-header-img" src="/wapassets/static/images/redact.png"></a>
</header>

<div class="yj-content yj-mainHF  yj-color-gray-dark">
    <div class="zh-user-header yj-bg-main">
        <div class="yj-text-center zh-user-baseinfo yj-color-gray-dark">
            <div class="yj-bg-fff" style="margin-top: -1px;">
                <p class="yj-mar-b zh-user-baseinfo-photo">
                    <img class="zh-user-photo" src="<?php echo \think\Session::get('user.headimg'); ?>">
                </p>
                <p>昵称：<?php echo \think\Session::get('user.nickname'); ?> <img src="/wapassets/static/images/<?php echo $sex_img; ?>.png" height="12"></p>
                <p class="yj-color-gray yj-text-sm">ID：<?php echo \think\Session::get('user.id'); ?></p>

                <ul class="yj-display-flex yj-text-center yj-pad-tb">
                    <li class="yj-flex-1">
                        <p>累计订单</p>
                        <p class="yj-color-main yj-text-big"><?php echo \think\Session::get('user.ordercount'); ?></p>
                    </li>
                    <li class="yj-flex-1">
                        <p>累计收益</p>
                        <p class="yj-color-main yj-text-big">&yen;<?php echo \think\Session::get('user.remainmoney'); ?></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="yj-mar-t yj-bg-fff">
        <a class="weui-cell weui-cell_access yj-border-b" href="user/myorder">
            <div class="weui-cell__bd">
                <p>我的订单</p>
            </div>
            <div class="weui-cell__ft yj-text-sm">
                查看全部订单
            </div>
        </a>
        <div class="yj-display-flex yj-pad-tb-big">
            <a class="yj-flex-1 yj-text-center" href="user/myorder/map/0">
                <span class="yj-grid-icon yj-message">
                    <img src="/wapassets/static/images/payment.png" width="30">
                    <i class="yj-message-num"><?php echo !empty($order_states[0])?$order_states[0] : 0; ?></i>
                </span>
                <p class="yj-text-sm yj-mar-t">待拼单</p>
            </a>
            <a class="yj-flex-1 yj-text-center" href="user/myorder/map/2">
                <span class="yj-grid-icon yj-message">
                    <img src="/wapassets/static/images/await.png" width="30">

                    <i class="yj-message-num"><?php echo !empty($order_states[2])?$order_states[2] : 0; ?></i>
                </span>
                <p class="yj-text-sm yj-mar-t">待作业</p>
            </a>
            <a class="yj-flex-1 yj-text-center" href="user/myorder/map/1">
                <span class="yj-grid-icon yj-message">
                    <img src="/wapassets/static/images/order.png" width="30">
                    <i class="yj-message-num"><?php echo !empty($order_states[1])?$order_states[1] : 0; ?></i>
                </span>
                <p class="yj-text-sm yj-mar-t">待付款</p>
            </a>
            <a class="yj-flex-1 yj-text-center" href="user/myorder/map/3">
                <span class="yj-grid-icon yj-message">
                    <img src="/wapassets/static/images/finish.png" width="30">
                    <!--<i class="yj-message-num"><?php echo !empty($order_states[3])?$order_states[3] : 0; ?></i>-->
                </span>
                <p class="yj-text-sm yj-mar-t">已完成</p>
            </a>
        </div>
    </div>
    <div class="weui-cells yj-mar-t">

        <a class="weui-cell weui-cell_access" href="user/myland" target="_blank">
            <div class="weui-cell__hd"><img class="yj-p-icon" src="/wapassets/static/images/land.png" ></div>
            <div class="weui-cell__bd">
                <p>我的土地</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="user/myprofit">
            <div class="weui-cell__hd"><img class="yj-p-icon" src="/wapassets/static/images/brokerage.png"></div>
            <div class="weui-cell__bd">
                <p>我的收益</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
    </div>
    <div class="weui-cells yj-mar-tb">
        <a class="weui-cell weui-cell_access" href="tel:037155556666;">
            <div class="weui-cell__hd"><img class="yj-p-icon" src="/wapassets/static/images/service.png"></div>
            <div class="weui-cell__bd">
                <p>联系客服</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="option/option">
            <div class="weui-cell__hd"><img class="yj-p-icon" src="/wapassets/static/images/coupleback.png"></div>
            <div class="weui-cell__bd">
                <p>意见反馈</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
        <a class="weui-cell weui-cell_access" href="user/question">
            <div class="weui-cell__hd"><img class="yj-p-icon" src="/wapassets/static/images/coupleback.png"></div>
            <div class="weui-cell__bd">
                <p>常见问题</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>
    </div>
</div>

<footer class="yj-footer yj-border-t">
    <a class="yj-footer-item" href="/wap/index">
        <img class="yj-footer-icon" src="/wapassets//static/images/home<?php echo request()->controller()=='Index' ? '_active' : ''; ?>.png">
        <p class="yj-footer-title <?php echo request()->controller()=='Index' ? 'yj-active' : ''; ?>">首页</p>
    </a>
    <!--href="/wap/crowd"-->
    <a class="yj-footer-item" href="/wap/crowd">
        <img class="yj-footer-icon" src="/wapassets//static/images/share<?php echo request()->controller()=='Crowd' ? '_active' : ''; ?>.png">
        <p class="yj-footer-title <?php echo request()->controller()=='Crowd' ? 'yj-active' : ''; ?> " >下单</p>
    </a>
    <a class="yj-footer-item" href="/wap/user">
        <img class="yj-footer-icon" src="/wapassets//static/images/my<?php echo request()->controller()=='User' ? '_active' : ''; ?>.png">
        <p class="yj-footer-title <?php echo request()->controller()=='User' ? 'yj-active' : ''; ?>">我的</p>
    </a>
</footer>
<!--
<script type="text/javascript">
    function orderType(){
        $.actions({
            actions: [{
                text: "我要拼单",
                onClick: function() {
                    window.location.href="/wap/crowd";
                }
            },{
                text: "直接下单",
                onClick: function() {
                    //do something
                    window.location.href="/wap/crowd/join"
                }
            }]
        });
    }
</script>-->


<script type="text/javascript">
    $('.yj-message-num').each(function(){
        var thisVal = $(this).text();
        if(thisVal==0){
            $(this).remove();
        }
    })
</script>

</body>
</html>