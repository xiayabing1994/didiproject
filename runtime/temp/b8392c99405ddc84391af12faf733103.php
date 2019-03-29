<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:79:"/www/wwwroot/didi.xlove99.top/public/../application/wap/view/option/option.html";i:1553161300;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/header.html";i:1553069199;}*/ ?>
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
    <span>意见反馈</span>
    <a class="yj-header-meau"></a>
</header>
<div class="yj-content yj-mainH">
    <div class="weui-cells yj-mar-t ">
        <div class="weui-cell">
            <div class="weui-cell__bd yj-text-usual">
                <textarea id='suggest' class="weui-textarea" placeholder="请输入您的反馈意见" rows="7"></textarea>
            </div>
        </div>
    </div>
    <div class="yj-pad-lr-bigger" style="margin-top: 3rem;">
        <a onclick="addSuggest()" class="yj-btn yj-main yj-big yj-block">确定</a>
    </div>
</div>
<script type="text/javascript" src="/wapassets/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/wapassets/weui/js/jquery-weui.js"></script>
<script>
    function addSuggest(){
        var userid=<?php echo \think\Session::get('user.id'); ?>;
        var suggest=$('#suggest').val();
        if(suggest=='') {
            $.alert('反馈内容为空');
        }else{
            $.ajax({
                url:'/api/person/addsuggest',
                type:'post',
                data:{userid:userid,suggest:suggest},
                success:function(data){
                    $.alert(data.msg);
                    $('#suggest').val('')
                }
            })
        }

    }

</script>

</body>
</html>