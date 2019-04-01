<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:79:"/www/wwwroot/didi.xlove99.top/public/../application/wap/view/user/my_order.html";i:1553941518;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/header.html";i:1553069199;}*/ ?>
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
<header class="yj-header yj-bg-fff yj-border-b">
    <a class="yj-header-return" href="javascript:history.go(-1)"><img src="/wapassets/static/images/arrow_return.png"></a>
    <span>我的订单</span>
    <a class="yj-header-meau"></a>
</header>
<div class="yj-content yj-mainH">
    <ul class="yj-pad-lr yj-mar-b">
        <?php if(is_array($myorders) || $myorders instanceof \think\Collection || $myorders instanceof \think\Paginator): $i = 0; $__LIST__ = $myorders;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;if($order['p_info']): ?>
                <li class=" yj-radius-sm yj-mar-t yj-pad-lr-big yj-pad-tb yj-line-height-2 yj-bg-fff">
                    <p class="yj-display-flex">
                        <span class="yj-flex-1 yj-elip-1"><?php echo $order['p_info']['pname']; ?></span>
                        <span class="yj-right yj-text-sm "><?php echo explain_state($order['state']); ?></span>
                    </p>
                    <div class="yj-color-gray-light">
                        <p>总价：¥<?php echo $order['p_info']['current_price']*$order['area']; ?></p>
                        <p>拼单时间：<?php echo $order['addtime']; ?></p>
                        <p>拼单面积：<?php echo $order['p_info']['sumarea']; ?>亩</p>
                    </div>
                    <!--订单操作按钮-->
                    <p class="yj-text-right">
                        <a class="yj-btn yj-sm">取消订单</a>
                        <a class="yj-btn yj-main yj-sm">立即付款</a>
                    </p>
                </li>
            <?php else: ?>
                <li class=" yj-radius-sm yj-mar-t yj-pad-lr-big yj-pad-tb yj-line-height-2 yj-bg-fff">
                    <p class="yj-display-flex">
                        <span class="yj-flex-1 yj-elip-1 yj-color-main">直接下单订单</span>
                        <span class="yj-right yj-text-sm yj-color-main"><?php echo explain_state($order['state']); ?></span>
                    </p>
                    <div class="yj-color-gray-light">
                        <p>总价：¥<?php echo $order['area']; ?></p>
                        <p>下单时间：<?php echo $order['addtime']; ?></p>
                        <p>下单亩数：<?php echo $order['area']; ?>亩</p>
                    </div>
                </li>
            <?php endif; endforeach; endif; else: echo "$empty" ;endif; ?>
    </ul>
</div>
<script type="text/javascript">

    //删除土地
    function delLand(num){
        $('#land_'+num).remove();
        $.toast("操作成功");
    }
</script>
</body>
</html>