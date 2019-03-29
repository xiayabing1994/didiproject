<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:77:"/www/wwwroot/didi.xlove99.top/public/../application/wap/view/crowd/index.html";i:1553772441;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/header.html";i:1553069199;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/footer.html";i:1553769052;}*/ ?>
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

<header class="yj-header yj-bg-fff">

    <span>下单类型</span>

</header>

<div class="yj-content yj-mainHF">

    <div class="yj-pad-tb yj-pad-lr-big">

        <p>活动规则</p>

        <ol class="yj-color-gray yj-text-sm yj-line-height-2">

            <li>

                每亩单价为 &yen;50/亩

            </li>

            <li>

                拼单需在规定时间完成

            </li>

        </ol>

    </div>

    <p class="yj-pad-bigger">
        <a href="/wap/crowd/pindan.html" class="yj-btn yj-main yj-block">我要拼单</a>
    </p>

    <div class="yj-pad-tb yj-pad-lr-big">

        <p>活动规则</p>

        <ol class="yj-color-gray yj-text-sm yj-line-height-2">

            <li>

                仅用于大面积用户

            </li>

            <li>

                低于20万亩禁止直接下单

            </li>

        </ol>

    </div>

    <p class="yj-pad-bigger">
        <a href="/wap/crowd/xiadan.html" class="yj-btn yj-main yj-block">直接下单</a>
    </p>

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




</body>

</html>