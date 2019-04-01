<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:79:"/www/wwwroot/didi.xlove99.top/public/../application/wap/view/user/question.html";i:1553909379;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/header.html";i:1553069199;}*/ ?>
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
    <span>常见问题</span>
    <a class="yj-header-meau"></a>
</header>

<div class="yj-content yj-mainH">
    <div class="yj-bg-fff yj-mar-t">
        <!--<p class="yj-text-big yj-pad-lr-big yj-border-b yj-light yj-pad-tb yj-pad-lr-big yj-text-bold">常见问题</p>-->
        <ul class="yj-pad-lr-big">
            <?php if(is_array($questions) || $questions instanceof \think\Collection || $questions instanceof \think\Paginator): $k = 0; $__LIST__ = $questions;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$question): $mod = ($k % 2 );++$k;?>
            <li class="yj-pad-tb yj-border-b yj-light">
                <div class="yj-fold-title">
                   <?php echo $k; ?>.<?php echo $question['title']; ?>
                </div>
                <div class="yj-bg-gray-light yj-pad yj-mar-t yj-text-sm yj-radius-sm yj-fold-content">
                    <?php echo $question['answer']; ?>
                </div>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('.yj-fold-title').click(function(){
            $(this).siblings('.yj-fold-content').toggleClass('yj-none');
        });
    })
</script>

</body>

</html>