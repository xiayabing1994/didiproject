var map, geolocation,islocal;

//加载地图，调用浏览器定位服务

map = new AMap.Map('map', {
    resizeEnable: true,
    zoom:16,
    //center: [113.772357,34.756547],
    baseRender:'d',    //强制使用栅格图
    scrollWheel:true

});

map.plugin('AMap.Geolocation', function() {

    geolocation = new AMap.Geolocation({
        enableHighAccuracy: true, // 是否使用高精度定位，默认:true
        timeout: 10000,           // 超过10秒后停止定位，默认：无穷大
        maximumAge: 0,            // 定位结果缓存0毫秒，默认：0
        convert: true,            // 自动偏移坐标，偏移后的坐标为高德坐标，默认：true
        showButton: true,         // 显示定位按钮，默认：true
        buttonPosition: 'RB',     // 定位按钮停靠位置，默认：'LB'，左下角
        buttonOffset: new AMap.Pixel(10, 20), // 定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
        showMarker: true,         // 定位成功后在定位到的位置显示点标记，默认：true
        showCircle: true,         // 定位成功后用圆圈表示定位精度范围，默认：true
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
    islocal=true;
}
function onError(data) {
    var str = [];
    str.push('定位失败');
    //console.log(str.join('<br>'));
    console.log(data);
    islocal=false;
    alert(data.message+'\n 定位失败');
}






AMapUI.loadUI(['control/BasicControl'], function(BasicControl) {
    zoomCtrl2 = new BasicControl.Zoom({
        position: 'bl',
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





var pointArr = [];
var markers = [];
var marker;

var isFinish = false;

//标注当前位置
var i = 0;

var lastLng;
var lastLat;
function marksPoint(){
    if(islocal){
        if(i<10){
            //var basePoint = [116.3898, 39.8913];
            /*var lngSpan = parseFloat(basePoint[0] - Math.random()*0.1).toFixed(4);
             var latSpan = parseFloat(basePoint[1] - Math.random()*0.1).toFixed(4);*/
            /*sessionStorage.setItem("dingWei-lng",data.position.getLng());
             sessionStorage.setItem("dingWei-lat",data.position.getLat());*/
            var lngSpan = sessionStorage.getItem("dingWei-lng");
            var latSpan = sessionStorage.getItem("dingWei-lat");
            /*if(lngSpan==lastLng && latSpan==lastLat){
             $.toast('请先点击定位，后提取当前点','text');
             return;
             }*/
            var lnglat = [lngSpan, latSpan];
            pointArr.push(lnglat);
            marker = new AMap.Marker({
                icon: "https://webapi.amap.com/theme/v1.3/markers/n/mark_b" +(i+1)+".png",
                position: lnglat,
                extData:{
                    id: i + 1
                }
            });
            markers.push(marker);

            map.add(marker);
            map.setFitView();
            i++;
            /*lastLng = lngSpan;
             lastLat = latSpan;*/
            console.log(pointArr);
        }else{
            $.toast("最多标注10个", "text");
        }
    }else{
        $.toast("定位失败，无法获取当前点", "text");
    }
}
//撤销上一个标注点

/*function withdrawPoint(){
    //map.remove(marker);
    //i--;
    var targetId = markers.length;
    var targetMarker;



    for(var index = 0; index < markers.length; index++){
        // 获取存在每个 extData 中的 id
        var id = markers[index].getExtData().id;

        if(id === targetId){
            targetMarker = markers[index];
            break;
        }
    }
    map.remove(targetMarker);
    //i--;
    console.log(pointArr);
}*/

function withdrawPoint(){
    if(isFinish){
        $.toast('您已标注完成，修改请点击重新标注','text');
        return;
    }
    var targetId = markers.length;
    var targetMarker;
    var arr;
    var index = markers.length - 1;
    var id = markers[index].getExtData().id;
    if(id === targetId){
        targetMarker = markers[index];
        //arr = pointArr[]
    }
    map.remove(targetMarker);
    markers.splice(-1,1);
    pointArr.splice(-1,1);
    i--;
    map.remove(targetMarker);
    console.log(pointArr);
    if(i<3){
        isFinish = false;
    }
}



var area;
var distancen;
var mu;
var areaName;
//完成标记
function finishPoint(){
    //未完成 ， 低于三个标注点
    if(!isFinish && i<3){
        $.toast('请至少输入三个标记点','text');
    }
    // 未完成，大于等于三个标注点
    if(!isFinish && i>=3){
        $.prompt({
            title: '请输入地块名字',
            text: '',
            input: '地块名',
            empty: false, // 是否允许为空
            onOK: function (input) {
                //点击确认
                areaName=input;
                var polygon = new AMap.Polygon({
                    path: pointArr,
                    strokeColor: "#62CAA4",
                    strokeWeight: 1,
                    strokeOpacity: 1,
                    fillOpacity: 0.2,
                    fillColor: '#1791fc',
                    zIndex: 50,
                });
                map.add(polygon);
                //var area = Math.round(AMap.GeometryUtil.ringArea(endPath));

                $('.marksPointbtn').hide();
                $('.resetPointBtn').show();

                area = Math.round(AMap.GeometryUtil.ringArea(pointArr));
                distancen = Math.round(AMap.GeometryUtil.distanceOfLine(pointArr));
                $('#perimeter').text(distancen);
                mu = Math.ceil(area*0.0015);
                $('#area').text(area);
                $('#muArea').text(mu);
                isFinish = true;
                return;
            },
            onCancel: function () {
                //点击取消
                return;
            }
        });

    }
    if(isFinish){
        $.toast('您已标注完成,请点击保存提交','text');
    }

}
//重做标记
function resetPoint(){
    map.clearMap();
    $('.marksPointbtn').show();
    $('.resetPointBtn').hide();
    i=0;
    pointArr=[];
    markers = [];
    isFinish = false;
}

//保存
function saveMarker(){
    if(isFinish){
        $.ajax({
            url:'/wap/land/addland',
            dataType:"json",   //返回格式为json
            async:true,//请求是否异步，默认为异步，这也是ajax重要特性
            data:{
                'name':areaName,
                'point':JSON.stringify(pointArr),
                'area':mu,
                'perimeter':distancen,
                'landarea':area
            },    //参数值
            type:"POST",   //请求方式
            beforeSend:function(){
                //请求前的处理
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
            },
            error:function(msg){
                console.log(msg);
                alert(msg);
            }
        });
    }else{
        $.toast('请先完成标注','text');
    }
}