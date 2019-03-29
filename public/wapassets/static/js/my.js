function localdate(type, split) {
    var myDate = new Date();
    var year = myDate.getFullYear();
    var month = myDate.getMonth() + 1;
    var day = myDate.getDate();
    var hour = myDate.getHours();  //获得小时、分钟、秒
    var minute = myDate.getMinutes();
    var symbol;
    if (split) {
        symbol = split;
    } else {
        symbol = '-';
    }
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (day >= 0 && day <= 9) {
        day = "0" + day;
    }
    var getedDate;
    if (type == 'Y') {
        getedDate = year;
    }
    if (type == 'M') {
        getedDate = month;
    }
    if (type == 'D') {
        getedDate = day;
    }
    if (type == 'YM') {
        getedDate = year + symbol + month;
    }
    if (type == 'YMD') {
        getedDate = year + symbol + month + symbol + day;
    }
    if(type == 'YMDHM'){
        getedDate = year + symbol + month + symbol + day + ' ' + hour + ':' +minute;

    }
    return getedDate;
}

/*
* 拆分字符串
* str 字符串类型
* b 分割点
* */
function spiltStr(str,b){
    var arr = str.split(b);
    return arr;
}