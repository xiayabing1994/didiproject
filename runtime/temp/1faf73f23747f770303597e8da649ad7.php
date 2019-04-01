<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:78:"/www/wwwroot/didi.xlove99.top/public/../application/wap/view/crowd/detail.html";i:1553925834;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/header.html";i:1553069199;}*/ ?>
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
        <a class="yj-header-return" href="javascript:history.go(-1)"><img src="/wapassets/static/images/arrow_return.png" alt=""></a>
        <span>拼单详情</span>
        <a href="" class="yj-header-meau"><img src="/wapassets/static/images/share_icon.png" alt=""></a>
    </header>
    <div class="yj-content yj-mainHF">
        <div class="yj-bg-fff yj-mar-t">
            <div class="yj-pad-lr-big yj-border-b">
                <div class="yj-list-item">
                    <span class="yj-list-item-text yj-elip-1"><?php echo $crowd_info['pname']; ?></span>
                    <i class="yj-color-main yj-text-sm"><?php echo explain_state($crowd_info['state']); ?></i>
                </div>
                <div class="yj-pad-b-big">
                    <span class="yj-color-red yj-text-big">&yen;<?php echo $crowd_info['price']; ?>/亩</span>
                    <span class="yj-color-gray yj-mar-l">当前价：&yen;<?php echo $crowd_info['current_price']; ?></span>
                </div>
            </div>
            <div class="yj-pad-b">
                <div class="yj-pad-tb-big yj-display-flex yj-text-center">
                    <div class="yj-flex-1">
                        <p class="yj-color-gray yj-text-sm">开始时间</p>
                        <p class="yj-mar-t"><?php echo $crowd_info['starttime']; ?></p>
                    </div>
                    <div class="yj-flex-1 yj-border-l">
                        <p class="yj-color-gray yj-text-sm">结束时间</p>
                        <p class="yj-mar-t"><?php echo $crowd_info['endtime']; ?></p>
                    </div>
                    <div class="yj-flex-1 yj-border-l">
                        <p class="yj-color-gray yj-text-sm">已拼</p>
                        <p class="yj-mar-t"><?php echo $crowd_info['hasland']; ?>亩</p>
                    </div>
                    <div class="yj-flex-1 yj-border-l">
                        <p class="yj-color-gray yj-text-sm">剩余</p>
                        <p class="yj-mar-t"><?php echo $crowd_info['sumarea']-$crowd_info['hasland']; ?>亩</p>
                    </div>
                </div>
                <div class="yj-pad-lr-big yj-pad-b-big">
                    <div class="yj-progress yj-circle">
                        <div class="yj-progress-bar" style="width: <?php echo floor($crowd_info['hasland']/$crowd_info['sumarea']*100); ?>%;"><?php echo floor($crowd_info['hasland']/$crowd_info['sumarea']*100); ?>%</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="yj-bg-fff yj-mar-t yj-pad-lr-big yj-pad-b-big">
            <p class="yj-list-item yj-text-big">详细信息</p>
            <div class="zh-merge-detailinfo">
                <p>
                    <span class="zh-merge-detailinfo-title">拼地面积：</span>
                    <span><?php echo $crowd_info['sumarea']; ?>亩</span>
                </p>
                <p>
                    <span class="zh-merge-detailinfo-title">已拼：</span>
                    <span><?php echo $crowd_info['hasland']; ?>亩</span>
                </p>
                <p>
                    <span class="zh-merge-detailinfo-title">开始事件：</span>
                    <span><?php echo $crowd_info['starttime']; ?></span>
                </p>
                <p>
                    <span class="zh-merge-detailinfo-title">用药类型：</span>
                    <span>杀虫剂</span>
                </p>
                <p>
                    <span class="zh-merge-detailinfo-title">详细地址：</span>
                    <span>云南大理南京</span>
                </p>
                <!--<?php if(is_array($crowd_info['land_points']) || $crowd_info['land_points'] instanceof \think\Collection || $crowd_info['land_points'] instanceof \think\Paginator): $i = 0; $__LIST__ = $crowd_info['land_points'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$point): $mod = ($i % 2 );++$i;?>
                   <?php echo $point['name']; ?>/<?php echo $point['point']; endforeach; endif; else: echo "" ;endif; ?>-->
            </div>
        </div>
        <div class="yj-mar-b-big" id="gaodeMap" style="width: 100%; height: 50vw;"></div>
    </div>
    <input type="hidden" value="<?php if(is_array($crowd_info['land_points']) || $crowd_info['land_points'] instanceof \think\Collection || $crowd_info['land_points'] instanceof \think\Paginator): $i = 0; $__LIST__ = $crowd_info['land_points'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$point): $mod = ($i % 2 );++$i;?><?php echo $point['point']; ?>/<?php endforeach; endif; else: echo "" ;endif; ?>" id="pointers">
    <footer class="yj-footer yj-pad-lr-bigger yj-border-box" style="height: 3rem;background-color: #F2F2F2">
        <a href="/wap/crowd/join/id/<?php echo $crowd_info['id']; ?>" class="yj-btn yj-main yj-block yj-big">立即加入</a>
    </footer>

    <script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.13&key=44c809431935b87f9c3d9c6f27f0af2f"></script>
    <script>

        var di = $('#pointers').val();
        var diArr = spiltStr(di,'/');
        var areaArr = [];
        for(var i = 0; i< diArr.length - 1;i++){
            var pointArr = spiltStr(diArr[i],';');
            var areaPoint = [];
            var aa = JSON.parse('['+pointArr+']');
            for(var n=0;n<aa.length;n++){
                areaPoint.push([aa[n+1],aa[n]]);
                n++
            }
            areaArr.push(areaPoint);
        }

        console.log(areaArr);
        var map = new AMap.Map('gaodeMap', {
            resizeEnable: true,
            zoomEnable:true,
            dragEnable: true,
            zoom:18,//级别
            center: [116.397428, 39.90923],//中心点坐标
        });



        var markers = [];

        for (var i = 0; i < areaArr.length; i++) {
            var marker = new AMap.Polygon({
                path: areaArr[i],
            });
            markers.push(marker);
        }

        // 创建覆盖物群组，并将 marker 传给 OverlayGroup
        var overlayGroups = new AMap.OverlayGroup(markers);

        // 对此覆盖物群组设置同一属性
        overlayGroups.setOptions({
            fillColor: '#fff', // 多边形填充颜色
            strokeColor: '#62CAA4', // 线条颜色
            strokeWeight:1,
        });

        // 统一添加到地图实例上
        map.add(overlayGroups);
        //无参数时，自适应所有覆盖物
        map.setFitView();







    </script>
</body>
</html>