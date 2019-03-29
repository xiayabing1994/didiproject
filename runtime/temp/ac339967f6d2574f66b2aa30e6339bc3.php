<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:77:"/www/wwwroot/didi.xlove99.top/public/../application/wap/view/index/share.html";i:1553757899;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<a onclick="wx_start()">hahhaa</a>

<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>
<script type="text/javascript">
	wx.config(<?php echo $wxconfig; ?>);
	function wx_start(){
		     alert('分享开始');
		    wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
			var shareData = {
				title: '标题',
				desc: '商城',//这里请特别注意是要去除html
				link: 'http://wx.xlove99.top/wap',//域名必须JS安全域名
				imgUrl: 'http://wx.xlove99.top/uploads/20190320/f6e5df8fc5c2551ee2f78bf752c6162f.jpg',
				success:function(){
					alert('分享成功');
				}
			};
			if(wx.onMenuShareAppMessage){ //微信文档中提到这两个接口即将弃用，故判断
				wx.onMenuShareAppMessage(shareData);//1.0 分享到朋友
				wx.onMenuShareTimeline(shareData);//1.0分享到朋友圈
			}else{
				wx.updateAppMessageShareData(shareData);//1.4 分享到朋友
				wx.updateTimelineShareData(shareData);//1.4分享到朋友圈
			}
		});
		wx.error(function(res){
			alert(res);
		});
	}


</script>
</body>
</html>