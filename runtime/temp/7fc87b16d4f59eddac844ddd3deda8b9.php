<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:76:"/www/wwwroot/didi.xlove99.top/public/../application/wap/view/crowd/join.html";i:1553668802;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/header.html";i:1553069199;}*/ ?>
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
    <span>加入拼单</span>
</header>
<div class="yj-content yj-mainH">
    <form action="/wap/crowd/join_deal.html" method="post" name="crowd_form">
        <div class="weui-cells yj-text-sm yj-mar-t-sm" >

            <div class="weui-cell weui-cell_swiped">
                <div class="weui-cell__bd">
                    <div class="weui-cell weui-cell_select weui-cell_select-after">
                        <div class="weui-cell__bd">
                            <label for="" class="weui-label"><i class="yj-color-red">*</i> 选择地块</label>
                        </div>
                        <div class="weui-cell__ft">
                            <select class="weui-select yj-color-gray" name="land_id" id="landSel">
                                <option value="">请选择</option>
                                <?php if(is_array($my_land) || $my_land instanceof \think\Collection || $my_land instanceof \think\Paginator): $i = 0; $__LIST__ = $my_land;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$land): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $land['id']; ?>" data-area="<?php echo $land['area']; ?>"><?php echo $land['name']; ?></option>
                                <?php endforeach; endif; else: echo "$empty" ;endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" id='land-area' name="area" value="">
                <input type="hidden" id='p_id' name="p_id" value="<?php echo input('id'); ?>">
                <div class="weui-cell__ft">
                    <a class="weui-swiped-btn weui-swiped-btn_warn delete-swipeout" href="javascript:">删除</a>
                    <a class="weui-swiped-btn weui-swiped-btn_default close-swipeout" href="javascript:">关闭</a>
                </div>
            </div>

            <div class="weui-cell weui-cell_swiped">
                <div class="weui-cell__bd">
                    <div class="weui-cell weui-cell_select weui-cell_select-after">
                        <div class="weui-cell__bd">
                            <label for="" class="weui-label"><i class="yj-color-red">*</i> 选择杀虫剂</label>
                        </div>
                        <div class="weui-cell__ft">
                            <select class="weui-select yj-color-gray" name="pesticide" id="shachongSel">
                                <option value="">请选择</option>
                                <?php if(is_array($pesticides) || $pesticides instanceof \think\Collection || $pesticides instanceof \think\Paginator): $i = 0; $__LIST__ = $pesticides;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$pesticide): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $pesticide['id']; ?>" data-price="<?php echo $pesticide['price']; ?>"><?php echo $pesticide['name']; ?></option>
                                <?php endforeach; endif; else: echo "$empty" ;endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="weui-cell__ft">
                    <a class="weui-swiped-btn weui-swiped-btn_warn delete-swipeout" href="javascript:">删除</a>
                    <a class="weui-swiped-btn weui-swiped-btn_default close-swipeout" href="javascript:">关闭</a>
                </div>
            </div>

        </div>
        <p class="yj-pad-bigger yj-pad-b-0 yj-mar-t-big"><input value='下 一步' type='submit' class="yj-btn yj-main yj-block yj-big" ></p>

    </form>
</div>

<script type="text/javascript">
    var localTime = localdate('YMDHM');
    $("#startTime").val(localTime);
    $("#endTime").datetimePicker({
        min:localTime
    });
    $('.delete-swipeout').click(function () {
        $(this).parents('.weui-cell').remove()
    });
    $('.close-swipeout').click(function () {
        $(this).parents('.weui-cell').swipeout('close')
    });


    var unitPrice = 0;
    var area = 0;
    $('#landSel').change(function () {
        var area=$('#landSel').find("option:selected").attr('data-area');
        $('#land-area').val(area);
        var count=unitPrice*area;
        $('#yajinNum').text(count);
    });
    $('#landSel,#shachongSel').change(function () {
        console.log('change');
        var unitPrice = $('#shachongSel').find("option:selected").attr('data-price');
        var area = $('#landSel').find("option:selected").attr('data-area');
        var count=unitPrice*area;
        $('#yajinNum').text(count);
    });

</script>

</body>
</html>