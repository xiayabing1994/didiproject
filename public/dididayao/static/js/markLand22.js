var map = new AMap.Map('map', {
    resizeEnable: true,
    zoom:16,
    center: [113.772357,34.756547],
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
        return 'http://mt1.google.cn/vt/lyrs=y@142&hl=zh-CN&gl=cn&x='+ x +'&y='+ y +'&z='+ z +'&s=Galil';
    }
});

googleLayer.setMap(map);



/*var options = {
 'showButton': false,//是否显示定位按钮
 'buttonPosition': 'LB',//定位按钮的位置
 /!* LT LB RT RB *!/
 // 'buttonOffset': new AMap.Pixel(10, 20),//定位按钮距离对应角落的距离
 'showMarker': true,//是否显示定位点
 'markerOptions':{//自定义定位点样式，同Marker的Options
 'offset': new AMap.Pixel(-18, -36),
 'content':'<img src="https://a.amap.com/jsapi_demos/static/resource/img/user.png" style="width:36px;height:36px"/>'
 },
 'showCircle': true,//是否显示定位精度圈
 'circleOptions': {//定位精度圈的样式
 'strokeColor': '#0093FF',
 'noSelect': true,
 'strokeOpacity': 0.5,
 'strokeWeight': 1,
 'fillColor': '#02B0FF',
 'fillOpacity': 0.25
 }
 };
 AMap.plugin(["AMap.Geolocation"], function() {
 var geolocation = new AMap.Geolocation(options);
 map.addControl(geolocation);
 geolocation.getCurrentPosition()
 });*/



AMap.plugin('AMap.Geolocation', function() {

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
        'markerOptions':{
            //自定义定位点样式，同Marker的Options
            'offset': new AMap.Pixel(-18, -36),
            'content':'<img src="https://a.amap.com/jsapi_demos/static/resource/img/user.png" style="width:36px;height:36px"/>'
        },
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

    alert(data.position.getLng()+","+data.position.getLat());

    console.log(data);
    console.log(data.formattedAddress);

}

// 解析定位错误信息

function onError(data) {
    alert(data.message);
    console.log(data);
}












var beginNum = 0;
var clickListener ;
var beginPoints;
var beginMarks ;
var polygonEditor;
var resPolygon = [];
var resNum = 0;




function init(){
    beginPoints = [];
    beginMarks = [];
    beginNum = 0;
    polygonEditor = '';
    clickListener = AMap.event.addListener(map, "click", mapOnClick);

    var str = '[' +
        '{"J":39.91789947393269,"G":116.36744477221691,"lng":116.367445,"lat":39.917899},' +
        '{"J":39.91184292800211,"G":116.40658356616223,"lng":116.406584,"lat":39.911843},' +
        '{"J":39.88616249265181,"G":116.37963272998047,"lng":116.379633,"lat":39.886162}' +
        ']';
    var arr = json2arr(str);
    createPolygon(arr);
}

function mapOnClick(e) {
    // document.getElementById("lnglat").value = e.lnglat.getLng() + ',' + e.lnglat.getLat()
    console.log(e);
    beginMarks.push(addMarker(e.lnglat));
    beginPoints.push(e.lnglat);
    beginNum++;
    if(beginNum == 3){
        AMap.event.removeListener(clickListener);
        var polygon = createPolygon(beginPoints);
        polygonEditor = createEditor(polygon);
        clearMarks();
    }
};




function createPolygon(arr){
    var polygon = new AMap.Polygon({
        map: map,
        path: arr,
        strokeOpacity:.8,
        strokeWeight: 1,
        fillColor: "#f5deb3",
        fillOpacity: 0.35
    });
    return polygon;
}

function createEditor(polygon){
    var polygonEditor = new AMap.PolyEditor(map, polygon);
    polygonEditor.open();
    AMap.event.addListener(polygonEditor,'end',polygonEnd);
    return polygonEditor;
}


function polygonEnd(res){
    resPolygon.push(res.target);
    //alert(resPolygon[resNum].contains([116.386328, 39.913818]));
    appendHideHtml(resNum,res.target.getPath());
    //resNum++;
    //init();
}

function appendHideHtml(index,arr){
    var strify = JSON.stringify(arr);
    var html = '<input class="pathsInput" type="hidden" id="index" name="paths[]" value="'+strify+'">';
    $('#circleLandForm').html('').append(html);
    //console.log(arr);
    //$.ajax();
    var endPath = [];
    for(var i = 0; i<arr.length; i++){
        endPath.push([arr[i].R,arr[i].P]);
    }
    console.log(endPath);
    var area = Math.round(AMap.GeometryUtil.ringArea(endPath));
    var distance = Math.round(AMap.GeometryUtil.distanceOfLine(endPath));
    var mu = Math.ceil(area*0.0015);
    $('#measureArea').text(mu);
    $('#perimeter').text(distance);
    $('#railLand').attr('disabled','disabled');
    $('#railLandTxt').text('已完成');
}

function closeEditPolygon(){
    polygonEditor.close();
    circleLandType(0);
}


function clearMarks(){
    map.remove(beginMarks);
}

function json2arr(json){
    var arr = JSON.parse(json);
    var res = [];
    for (var i = 0; i < arr.length; i++) {
        var line = [];
        line.push(arr[i].lng);
        line.push(arr[i].lat);
        res.push(line);
    };
    return res;
}

// 实例化点标记
function addMarker(lnglat) {
    var marker = new AMap.Marker({
        //icon: "static/images/writeCircle.png",
        icon:'http://webapi.amap.com/theme/v1.3/markers/n/mark_b.png',
        position: lnglat
    });
    marker.setMap(map);
    return marker;
}



/*function quandi(that){
    var type = $(that).attr("data-type");
    if(type==0){
        drawPolygon();
        $(that).attr("data-type",1).addClass('yj-bg-main');
    }else{

    }
}*/

function clearTag(){
    //endPath=[];
    map.clearMap();
}
function reset(){
    clearTag();
    $('.pathsInput').remove();
    circleLandType(0);
    $('#railLandTxt').text('圈地');
    $('#railLand').removeAttr('disabled');
    $('#measureArea').text(0);
    $('#perimeter').text(0);
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
        $('.circleLandIcon').attr('src','/static/images/rail.png')
    }else{ //选中
        $("#railLand").addClass('yj-bg-main');
        $('.circleLandIcon').attr('src','/static/images/rail_white.png')
    }
}