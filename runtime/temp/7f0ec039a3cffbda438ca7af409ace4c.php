<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:78:"/www/wwwroot/didi.xlove99.top/public/../application/wap/view/user/my_land.html";i:1553860049;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/header.html";i:1553069199;}*/ ?>
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
    <span>我的土地</span>
    <a class="yj-header-meau"></a>
</header>
<div class="yj-content yj-mainH">
    <ul class="yj-mar-t">
        <?php if(is_array($my_land) || $my_land instanceof \think\Collection || $my_land instanceof \think\Paginator): $i = 0; $__LIST__ = $my_land;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$land): $mod = ($i % 2 );++$i;?>
        <li class="yj-bg-fff yj-mar-b yj-pad-lr" id="land_1" >
            <p class="yj-list-item yj-border-b">
                <!--onclick="changeName('<?php echo $land['id']; ?>',this)"-->
                <span class="yj-list-item-text"><?php echo $land['name']; ?><i class="yj-text-min yj-color-gray-light"><?php echo $land['state']==0?'闲置中' : '订单进行中'; ?></i></span>

                <img class="yj-list-item-more" src="/wapassets/static/images/trash.png" onclick="delLand('<?php echo $land['id']; ?>','<?php echo \think\Session::get('user.id'); ?>')">
            </p>
            <div class="yj-display-flex yj-pad-tb-big yj-middle yj-mar-t">
                <div class="yj-flex-1 yj-text-center yj-border-r" style="height: 25px;">
                    <div style="margin-top: -14px;">
                        <p class=""><?php echo $land['perimeter']; ?>米</p>
                        <p class="yj-color-gray-light yj-text-sm">周长</p>
                    </div>
                </div>
                <div class="yj-flex-1 yj-text-center yj-border-r" style="height: 25px;">
                    <div style="margin-top: -14px;">
                        <p class=""><?php echo $land['area']; ?>亩</p>
                        <p class="yj-color-gray-light yj-text-sm">面积</p>
                    </div>
                </div>
                <div class="yj-flex-1 yj-text-center" style="height: 25px;">
                    <div style="margin-top: -14px;">
                        <p class=""><?php echo $land['landarea']; ?>平方</p>
                        <p class="yj-color-gray-light yj-text-sm">总面积</p>
                    </div>
                </div>

            </div>
        </li>
        <?php endforeach; endif; else: echo "$empty" ;endif; ?>
    </ul>

    <div class="yj-mar-bigger">
        <!--href="addland.html"-->
        <a class="yj-btn yj-bg-gray yj-block yj-big"  onclick="addland()">
            <img src="/wapassets/static/images/share.png" class="yj-mar-r" height="20" style="margin-top: -4px;">
            增加土地
        </a>
    </div>
</div>
<script type="text/javascript" src="/wapassets/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/wapassets/weui/js/jquery-weui.js"></script>
<script type="text/javascript">

    //删除土地
    function delLand(landId,userid){
        $.confirm("确认删除该土地吗", function() {
           $.ajax({
               type:"post",
               data:{landid:landId,userid:userid},
               url:'/api/land/delLand',
               success:function(data){
                   data.errcode==0 ? window.location.reload() : $.alert('删除失败');

               }
           })
        }, function() {

        });
    }
    //修改土地名字
    function changeName(landId,that){
        $.prompt({
            title: '修改地块名字',
            text: '',
            input: '',
            empty: false, // 是否允许为空
            onOK: function (input) {
                $.ajax({
                    type:"post",
                    data:{land_id:landId,name:input},
                    url:'/wap/land/updLandName',
                    success:function(data){
                        data.errcode==0 ? $(that).text(input) : $.toast('修改失败','text');

                    }
                })
            },
            onCancel: function () {
                //点击取消
            }
        });
    }
    //增加土地
    function addland(){
        $.actions({
            actions: [{
                text: "实地测量",
                onClick: function() {
                    window.location.href="measure_auto.html"
                }
            },{
                text: "手动测量",
                onClick: function() {
                    window.location.href="measure.html"
                }
            }]
        });
    }
</script>
</body>
</html>