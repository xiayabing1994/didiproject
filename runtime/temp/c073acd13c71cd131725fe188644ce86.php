<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:76:"/www/wwwroot/didi.xlove99.top/public/../application/wap/view/crowd/deal.html";i:1553737259;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/header.html";i:1553069199;}*/ ?>
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
    <a class="yj-header-return" href="javascript:history.go(-1)"><img src="/wapassets/static/images/arrow_return.png"></a>
    <span>提交支付</span>
    <a class="yj-header-meau"></a>
</header>
<div class="yj-content yj-mainHF">
    <!--<div class="weui-cells yj-mar-t">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>应付金额:1200</p>
            </div>
        </div>
    </div>-->
    
    <!--<div class="yj-mar-t-bigger yj-pad-lr-bigger">
        <a class="yj-btn yj-bg-gray yj-block yj-big" href="addland.html">
            <img src="/wapassets/static/images/share.png" class="yj-mar-r" height="20" style="margin-top: -4px;">添加地块</a>
    </div>-->

  <div class="weui-cells weui-cells_radio yj-mar-t-sm">
      <a href="/wap/pay/wxpay">
        <label class="weui-cell weui-check__label" for="x11">
            <div class="weui-cell__hd"><img class="yj-p-icon" src="/wapassets/static/images/wechatPay.png"></div>
            <div class="weui-cell__bd">
                <p>微信支付</p>
            </div>
            <div class="weui-cell__ft">
                <input type="radio" class="weui-check" name="radio1" id="x11">
                <span class="weui-icon-checked"></span>
            </div>
        </label>
    </a>
        <label class="weui-cell weui-check__label" for="x12">
            <div class="weui-cell__hd"><img class="yj-p-icon" src="/wapassets/static/images/alipayPay.png"></div>
            <div class="weui-cell__bd">
                <p>支付宝支付</p>
            </div>
            <div class="weui-cell__ft">
                <input type="radio" name="radio1" class="weui-check" id="x12" checked="checked">
                <span class="weui-icon-checked"></span>
            </div>
        </label>
    </div>

</div>
<div class="yj-footer yj-pay-footer">
    <div class="yj-flex-1 yj-list-item yj-pad-l-big yj-text-left yj-text-usual">
        实付款：<span class="yj-color-main"> ¥<i class="yj-text-bigger" id="yajinNum"><?php echo $sub_price; ?></i> 定金</span>
    </div>

    <div>
        <button class="yj-btn yj-main yj-block yj-radius-0 yj-footbig">立即支付</button>
    </div>
</div>
<script type="text/javascript" src="/wapassets/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/wapassets/weui/js/jquery-weui.js"></script>
<script type="text/javascript">
    $('.delete-swipeout').click(function () {
        $(this).parents('.weui-cell').remove()
    });
    $('.close-swipeout').click(function () {
        $(this).parents('.weui-cell').swipeout('close')
    });


    var unitPrice = 0;
    var area = 0;
    $('#landSel').change(function () {

        var count=unitPrice*area;
        $('#yajinNum').text(count);
    });
    $('#landSel,#shachongSel').change(function () {
        console.log('change');
        var unitPrice = $('#shachongSel').find("option:selected").attr('data-price');
        var area = $('#landSel').find("option:selected").attr('data-area');
        var count=unitPrice*area;
        $('#yajinNum').text(count);
    });

</script>
</body>
</html>