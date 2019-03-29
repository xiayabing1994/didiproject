<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:77:"/www/wwwroot/didi.xlove99.top/public/../application/wap/view/index/index.html";i:1553765361;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/header.html";i:1553069199;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/footer.html";i:1553769052;}*/ ?>
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
    <div class="yj-header-search">
        <input class="yj-header-search-input" value="<?php echo input('keyword'); ?>" type="text" placeholder="XU2360" id="enterSearch">
    </div>
    <a href="" class="yj-header-scan">
        <img src="/wapassets/static/images/scan.png">
    </a>
</header>
<div class="yj-content yj-mainHF">
    <!-- index banner -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php if(is_array($banners) || $banners instanceof \think\Collection || $banners instanceof \think\Paginator): $i = 0; $__LIST__ = $banners;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$banner): $mod = ($i % 2 );++$i;?>
            <a href="<?php echo $banner['url']; ?>" class="swiper-slide"><img src="<?php echo $banner['image']; ?>" alt=""></a>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    <div class="yj-bg-fff yj-mar-t">
        <div class="zx-index-title1 yj-border-b">
            <p>&nbsp;</p>
            <div class="weui-loadmore weui-loadmore_line">
                <span class="weui-loadmore__tips">附近拼单</span>
            </div>
        </div>
        <!-- i -->
        <div class="weui-cells" style="margin-top: -1px;">
            <div class="weui-cell weui-cell_select">
                <form class="weui-cell__bd" name="land_form">
                    <select class="weui-select" name="land_id" onchange="land_form.submit()">
                        <option selected="" value="">选择地块</option>
                        <?php if(is_array($myland) || $myland instanceof \think\Collection || $myland instanceof \think\Paginator): $i = 0; $__LIST__ = $myland;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$land): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $land['id']; ?>" <?php echo input('land_id')==$land['id'] ? 'selected' : ''; ?>><?php echo $land['name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </form>
            </div>
        </div>
        <!--<p class="yj-list-item yj-pad-lr-big">
            &lt;!&ndash;<span class="yj-list-item-text yj-color-gray" id="areaName">选择地块</span>
            <span class="yj-list"></span>
            <img class="yj-list-item-more" src="/wapassets/static/images/arrow_right.png" alt="">&ndash;&gt;
            <select class="yj-select" name="" id="" style="width: 100%;">
                <option value="0">选择地块</option>
                <option value="1">地块1</option>
                <option value="2">地块2</option>
            </select>
        </p>-->
    </div>
    <!--地块 拼单 信息-->
    <div class="yj-mar-t zh-merge ">
        <!-- list  -->
        <?php if(is_array($aroundOrders) || $aroundOrders instanceof \think\Collection || $aroundOrders instanceof \think\Paginator): $i = 0; $__LIST__ = $aroundOrders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($i % 2 );++$i;?>
        <a class="yj-bg-fff yj-mar-b zh-merge-list yj-block"  href="/wap/crowd/detail/id/<?php echo $order['id']; ?>.html">
            <div class="yj-pad-lr-big yj-border-b">
                <div class="yj-list-item">
                    <span class="yj-list-item-text yj-elip-1"><?php echo $order['pname']; ?></span>
                    <i class="yj-color-main yj-text-sm">等待拼单</i>
                </div>
                <div class="yj-pad-b-big">
                    <span class="yj-color-red yj-text-big"><?php echo $order['originalprice']; ?>&yen;/亩</span>
                    <span class="yj-color-gray yj-mar-l">当前价:<?php echo $order['nowprice']; ?>&yen;/亩</span>
                </div>
            </div>
            <div class="yj-pad-b">
                <div class="yj-pad-tb-big yj-display-flex yj-text-center">
                    <div class="yj-flex-1">
                        <p class="yj-color-gray yj-text-sm">开始时间</p>
                        <p class="yj-mar-t"><?php echo $order['starttime']; ?></p>
                    </div>
                    <div class="yj-flex-1 yj-border-l">
                        <p class="yj-color-gray yj-text-sm">结束时间</p>
                        <p class="yj-mar-t"><?php echo $order['endtime']; ?></p>
                    </div>
                    <div class="yj-flex-1 yj-border-l">
                        <p class="yj-color-gray yj-text-sm">已拼(亩)</p>
                        <p class="yj-mar-t"><?php echo $order['hasland']; ?></p>
                    </div>
                    <div class="yj-flex-1 yj-border-l">
                        <p class="yj-color-gray yj-text-sm">剩余(亩)</p>
                        <p class="yj-mar-t"><?php echo $order['sumarea']-$order['hasland']; ?></p>
                    </div>
                </div>
                <div class="yj-pad-lr-big yj-pad-b-big">
                    <div class="yj-progress yj-circle">
                        <div class="yj-progress-bar" style="width:<?php echo floor($order['hasland']/$order['sumarea']*100); ?>%"><?php echo floor($order['hasland']/$order['sumarea']*100); ?>%</div>
                    </div>
                </div>
                <div class="yj-pad-lr-big">
                    <span class="yj-color-gray-light yj-text-min">距您:<?php echo deal_distance($order['distance']); ?></span>
                    <span class="yj-btn yj-main yj-sm yj-right">去拼单</span>
                </div>
            </div>
        </a>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        <!--  list end  -->

    </div>

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


<!-- search 引导 -->
<div class="yj-search-guide yj-none">

    <div class="yj-header yj-bg-fff">
        <form class="yj-header-search" id="search_from">
            <input class="yj-header-search-input" value="<?php echo input('keyword'); ?>" name='keyword' type="search" placeholder="请输入搜索内容" id="searchInput">
        </form>
        <a class="yj-search-cancel yj-color-gray" id="cancelSearch">取消</a>
    </div>
    <div class="yj-pad-header yj-text-usual">
        <!--<div class="yj-bg-fff yj-pad-l-big yj-mar-t">
            <p class="yj-color-gray yj-pad-tb">热门搜索</p>

            <div class="yj-pad-b yj-search-label">
                <a class="yj-btn yj-sm yj-radius yj-mar-r yj-mar-b">新乡化纤</a>
                <a class="yj-btn yj-sm yj-radius yj-mar-r yj-mar-b">杀虫剂药</a>
            </div>
            &lt;!&ndash; 加载中，数据正常时 显示 &ndash;&gt;
            <p class="yj-text-center yj-pad-b"><a class="yj-color-gray yj-text-usual"><img class="yj-mar-r" src="/wapassets/static/images/refresh.png" height="16"> 换一批</a></p>
            &lt;!&ndash; 加载中，数据没有返回时 显示 &ndash;&gt;
            &lt;!&ndash;<p class="yj-text-center yj-pad-b"><a class="yj-color-gray yj-text-usual"><img class="yj-mar-r" src="/wapassets/static/images/refresh.png" height="16"> 正在加载...</a></p>&ndash;&gt;
        </div>-->

        <!-- 最近搜索 -->
        <!--<div class="yj-bg-fff yj-pad-l-big yj-mar-t">
            <p class="yj-color-gray yj-pad-tb yj-pad-r-big">
                最近搜索 <img class="yj-right" src="/wapassets/static/images/trash.png" height="14" onclick="delHistory()">
            </p>
            <div class="yj-pad-b yj-search-label" id="searchHistoryBox">

            </div>
        </div>-->
    </div>

</div>


<script type="text/javascript">
    new Swiper('.swiper-container', {
        autoplay: 3000
    });

    $('#enterSearch').focus(function(){
        $('.yj-search-guide').show();
        $('#searchInput').focus();
    });

    $('#cancelSearch').click(function(){
        $('.yj-search-guide').hide();
    });

    $('.yj-search-label a').click(function(){
        $(this).addClass('yj-main').siblings().removeClass('yj-main');
    });


    var historyJson;
    $(function(){
       // searchHistory = [];
        //console.log(sessionStorage.getItem('searchName'));
        historyJson = JSON.parse(sessionStorage.getItem('searchName'));
        if(!historyJson){
            historyJson=[];
        }
        appendHistioryHtml();
        //$.toast('初始化完成','text');

        //点击软键盘 搜索按钮 触发
        $("#keyword").on('keypress',function(e) {
            var keycode = e.keyCode;
            var searchName = $(this).val();
            if(keycode=='13') {
                e.preventDefault();
                searchForm();

            }
        });

        //点击最近搜索 项目
        $('#searchHistoryBox a').click(function(){
            var thisVal = $(this).text();
            $('#searchInput').val(thisVal);
            searchForm();
        });

        $('#search_from').submit(function(){
            searchForm();
        });
    });

    //搜索
    function searchForm(){
        var inputVal = $('#searchInput').val();
        if(inputVal==''){
            $.toast('请输入关键字','text');
            return false;
        }else{

            /*if(isRepeat(historyJson)){
                historyJson.splice($.inArray(inputVal,historyJson),1);
            }*/
            historyJson.unshift(inputVal);
            sessionStorage.setItem('searchName',JSON.stringify(historyJson));
            //console.log();
            $('#searchHistoryBox').prepend('<a class="yj-btn yj-sm yj-radius yj-mar-r yj-mar-b">'+inputVal+'</a>');
            // return false;
        }
    }

    //最近搜索显示
    function appendHistioryHtml(){
        var html='';
        var aa = historyJson.length;
        if(aa<=0){
            $('#searchHistoryBox').html('<p class="yj-color-gray yj-color-gray-light yj-text-sm yj-text-center">您还没有搜索哦，请所有您需要的</p>');
        }else {
            for(var i=0; i<aa; i++){
                html+='<a class="yj-btn yj-sm yj-radius yj-mar-r yj-mar-b">'+historyJson[i]+'</a>'
            }
            $('#searchHistoryBox').html(html);
        }
    }

    //删除历史记录（最近搜索）
    function delHistory(){
        historyJson=[];
        sessionStorage.setItem('searchName',null);
        $('#searchHistoryBox').html('<p class="yj-color-gray yj-color-gray-light yj-text-sm yj-text-center">您还没有搜索哦，请所有您需要的</p>');
    }
    //判断是否有重复
    /*function isRepeat(arr) {
        var hash = {};
        for(var i in arr) {
            if(hash[arr[i]])
            {
                console.log('有重复');
                return true;
            }
            // 不存在该元素，则赋值为true，可以赋任意值，相应的修改if判断条件即可
            hash[arr[i]] = true;
        }
        return false;
    }*/
</script>
</body>
</html>