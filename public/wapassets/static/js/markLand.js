
var map,geolocation;

map = new AMap.Map('map', {
    resizeEnable: true,
    zoom:16,
    //center: [113.772357,34.756547],
    baseRender:'d',    //强制使用栅格图
    scrollWheel:true
});

AMapUI.loadUI(['control/BasicControl'], function(BasicControl) {
    zoomCtrl2 = new BasicControl.Zoom({
        position: 'LB',
    });
    map.addControl(zoomCtrl2);
});

var googleLayer = new AMap.TileLayer({
    //getTileUrl: 'http://www.google.cn/maps/vt?lyrs=y&gl=cn&x=%d&s=&y=%d&z=%d',
    zIndex:2,
    getTileUrl: function(x , y, z){
        return 'https://mt1.google.cn/vt/lyrs=y@142&hl=zh-CN&gl=cn&x='+ x +'&y='+ y +'&z='+ z +'&s=Galil';
    }
});

googleLayer.setMap(map);


map.plugin('AMap.Geolocation', function() {

    geolocation = new AMap.Geolocation({
        enableHighAccuracy: true, // 是否使用高精度定位，默认:true
        //timeout: 1000,           // 超过10秒后停止定位，默认：无穷大
        maximumAge: 0,            // 定位结果缓存0毫秒，默认：0
        convert: true,            // 自动偏移坐标，偏移后的坐标为高德坐标，默认：true
        showButton: true,         // 显示定位按钮，默认：true
        buttonPosition: 'LB',     // 定位按钮停靠位置，默认：'LB'，左下角
        buttonOffset: new AMap.Pixel(10, 20), // 定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
        showMarker: true,         // 定位成功后在定位到的位置显示点标记，默认：true
        useNative: true,
        /*'markerOptions':{
            //自定义定位点样式，同Marker的Options
            'offset': new AMap.Pixel(-18, -36),
            'content':'<img src="https://a.amap.com/jsapi_demos/static/resource/img/user.png" style="width:36px;height:36px"/>'
        },*/
        showCircle: true,         // 定位成功后用圆圈表示定位精度范围，默认：true

        circleOptions: {
            //定位精度圈的样式
            'strokeColor': '#0093FF',
            'noSelect': true,
            'strokeOpacity': 0.5,
            'strokeWeight': 1,
            'fillColor': '#02B0FF',
            'fillOpacity': 0.25
        },
        panToLocation: true,      // 定位成功后将定位到的位置作为地图中心点，默认：true
        zoomToAccuracy:true       // 定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false

    });

    map.addControl(geolocation);

    geolocation.getCurrentPosition();

    AMap.event.addListener(geolocation, 'complete', onComplete); //返回定位信息

    AMap.event.addListener(geolocation, 'error', onError); //返回定位出错信息

});



//解析定位结果
function onComplete(data) {
    if(data.status == 1){
        console.log("定位成功");
        $("#addressInput").val(data.formattedAddress);
        sessionStorage.setItem("dingWei-lng",data.position.getLng());
        sessionStorage.setItem("dingWei-lat",data.position.getLat());
    }
    var str = [];
    str.push('经度：' + data.position.getLng());
    str.push('纬度：' + data.position.getLat());
    str.push('是否经过偏移：' + (data.isConverted ? '是' : '否'));
    console.log(str.join('<br>'));
    console.log(data.isConverted);
}
function onError() {
    var str = [];
    str.push('定位失败');
    console.log(str.join('<br>'));
}







var beginNum = 0;
var clickListener ;
var path=[];
var beginMarks ;
var polygonEditor;
var resPolygon = [];
var resNum = 0;

function init(){
    //path = [];
    beginMarks = [];
    beginNum = 0;
    polygonEditor = '';
    clickListener = AMap.event.addListener(map, "click", mapOnClick);
}

var marker;
var markers = [];
// 实例化点标记
function addMarker(lnglat) {
    marker = new AMap.Marker({
        //icon: "static/images/writeCircle.png",
        icon:'http://webapi.amap.com/theme/v1.3/markers/n/mark_b.png',
        position: lnglat
    });
    marker.setMap(map);
    markers.push(marker);
    //return marker;
}


// 实例化 线标记
var polyline;
var polylines = [];

var isFinish = false;
function mapOnClick(e) {
    beginMarks.push(addMarker(e.lnglat));
    path.push(e.lnglat);
    polyline = new AMap.Polyline({
        path: path,
        isOutline: false,
        strokeColor: "#3366FF",
        strokeOpacity: 1,
        strokeWeight: 2,
        zIndex: 50,
    });
    polyline.setMap(map);
    polylines.push(polyline);
};


//实例化 撤销点
/*function revoke(){
    path.splice(-1,1);
    map.remove(polylines);
    polyline = new AMap.Polyline({
        path: path,
        isOutline: false,
        strokeColor: "#3366FF",
        strokeOpacity: 1,
        strokeWeight: 2,
        zIndex: 50,
    });
    polyline.setMap(map);
    console.log(path);
}*/


function resetMarks(){
    map.clearMap();
    path = [];
    isFinish = false;
    $('#perimeter').text(0);
    $('#area').text(0);
    $('#muArea').text(0);
    $('#railLand').removeAttr('disabled');
}


var area;
var distancen;
var mu;
var polygon;
var areaName;


//实例化 面
function drawArea(){
    if(!isFinish){
        if(path.length>2){
            $.prompt({
                title: '请输入地块名字',
                text: '',
                input: '地块名',
                empty: false, // 是否允许为空
                onOK: function (input) {
                    areaName = input;
                    polygon = new AMap.Polygon({
                        path: path,
                        fillColor: '#fff', // 多边形填充颜色
                        fillOpacity: 0.4,
                        borderWeight: 2, // 线条宽度，默认为 1
                        strokeColor: 'red', // 线条颜色
                    });
                    map.remove(polylines);
                    map.remove(markers);
                    polygon.setMap(map);
                    circleLandType(0);

                    /* var dispath = [];
                     dispath=path;
                     dispath.push(path[0]);*/
                    area = Math.round(AMap.GeometryUtil.ringArea(path));
                    distancen = Math.round(AMap.GeometryUtil.distanceOfLine(path));
                    $('#perimeter').text(distancen);
                    mu = Math.ceil(area*0.0015);
                    $('#area').text(area);
                    $('#muArea').text(mu);
                    $('#railLand').attr('disabled','disabled');
                    console.log(path);
                    isFinish=true;
                    return path;
                },
                onCancel: function () {
                    //点击取消
                    return;
                }
            });

        }else{
            $.toast('至少输入三个标注点','text');
            return;
        }
    }else{
        $.toast('点击保存可提交数据','text');
        return false;
    }
}


//保存
function saveArea(){
    if(isFinish){
        $.ajax({
            url:'/wap/land/addland',
            dataType:"json",   //返回格式为json
            async:true,//请求是否异步，默认为异步，这也是ajax重要特性
            data:{
                'name':areaName,
                'point':JSON.stringify(path),
                'area':mu,
                'perimeter':distancen,
                'landarea':area
            },    //参数值
            type:"POST",   //请求方式
            beforeSend:function(){

            },
            success:function(data){
                //请求成功时处理
                console.log(data);
                if(data.errcode==0){
                    $.toast('提交成功',function(){
                        window.location.href='myland.html'
                    });
                }else{
                    $.toast('提交失败','cancel');
                    return;
                }
            },
            complete:function(msg){

                //请求完成的处理
                //$.toast('成功','text');
            },
            error:function(msg){
                console.log(msg);
                alert(msg);
                //请求出错处理
                //$.toast('操作失败,稍后重新操作...','text');
            }
        });

    }else{
        $.toast('请先完成标注点','text');
    }
    //$.toast("成功", "text");
}

function circleLand(){
    init();
    circleLandType(1);
    $('#railLandTxt').text('圈地中');
}


function circleLandType(type){
    //未选中
    if(type==0){
        $("#railLand").removeClass('yj-bg-main');
        $('.circleLandIcon').attr('src','/wapassets/static/images/rail.png');
        AMap.event.removeListener(clickListener);
        $('#railLandTxt').text('圈地');
    }else{ //选中
        $("#railLand").addClass('yj-bg-main');
        $('.circleLandIcon').attr('src','/wapassets/static/images/rail_white.png');
        init();
        $('#railLandTxt').text('圈地中');
    }
}