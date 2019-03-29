<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"/www/wwwroot/didi.xlove99.top/public/../application/wap/view/crowd/pindan.html";i:1553772481;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/header.html";i:1553069199;s:69:"/www/wwwroot/didi.xlove99.top/application/wap/view/Public/footer.html";i:1553769052;}*/ ?>
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
        <span>发布拼单</span>
    </header>
    <div class="yj-content yj-mainHF">
        <div class="yj-pad-tb yj-pad-lr-big">
            <p>活动规则</p>
            <ol class="yj-color-gray yj-text-sm yj-line-height-2">
                <li>
                    每亩单价为 &yen;50/亩
                </li>
                <li>
                    拼单需在规定时间完成
                </li>
            </ol>
        </div>
        <form action="/wap/crowd/deal.html" method="post" name="crowd_form" onsubmit="return checkEmpty()">
        <div class="weui-cells weui-cells_form yj-text-sm yj-mar-t-sm">
            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label"><i class="yj-color-red">*</i> 标题</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" name="pname" data-id="pname" id="pname" type="text" placeholder="请输入标题">
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label"><i class="yj-color-red">*</i> 作业面积</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" name="sumarea" id="sumarea" data-id="sumarea" type="text" placeholder="请输入需作业的面积">
                </div>
                <div class="weui-cell__ft yj-text-usual">
                    亩
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label"><i class="yj-color-red">*</i> 拼单开始时间</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" name='starttime' id="starttime" data-id="starttime" type="text" placeholder="请输入开始时间" id="startTime" readonly>
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label"><i class="yj-color-red">*</i> 拼单结束时间</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" name="endtime" id="endtime" data-id="endtime" type="text" placeholder="请输入结束时间" id="endTime">
                </div>
            </div>
        </div>

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
                                <!--<option value="2">杀虫剂</option>-->
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" id='land-area' name="area" value="">
            </div>

            <div class="weui-cell weui-cell_swiped">
                <div class="weui-cell__bd">
                    <div class="weui-cell weui-cell_select weui-cell_select-after">
                        <div class="weui-cell__bd">
                            <label for="" class="weui-label"><i class="yj-color-red">*</i> 选择农药</label>
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
            </div>



        </div>

        <!--<div class="weui-cells weui-cells_radio yj-mar-t-sm yj-text-sm">
            <label class="weui-cell weui-check__label" for="x11">
                <div class="weui-cell__bd">
                    <p>直接下单</p>
                </div>
                <div class="weui-cell__ft">
                    <input type="radio" class="weui-check" name="radio1" id="x11">
                    <span class="weui-icon-checked"></span>
                </div>
            </label>
            <label class="weui-cell weui-check__label" for="x12">

                <div class="weui-cell__bd">
                    <p>自动拼单</p>
                </div>
                <div class="weui-cell__ft">
                    <input type="radio" name="radio1" class="weui-check" id="x12" checked="checked">
                    <span class="weui-icon-checked"></span>
                </div>
            </label>
        </div>
-->
        <p class="yj-pad-bigger yj-pad-b-0 yj-mar-t-big"><input value='下 一 步' type='submit' class="yj-btn yj-main yj-block yj-big" ></p>

        </form>
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

    <script type="text/javascript">
        var localTime = localdate('YMDHM');
        $("#startTime").val(localTime);
        $("#endTime").datetimePicker({
           // min:localTime
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

        function checkEmpty(){
            var pname = $('#pname').val();
            var sumarea = $('#sumarea').val();
            var starttime = $('#starttime').val();
            var endtime = $('#endtime').val();
            var  shachongSel = $('#shachongSel').val();
            var  landSel = $('#landSel').val();
            if(pname==''){
                $.toast('标题不能为空','text');
                $("#pname").focus();
                return false;
            }else if(sumarea==''){
                $.toast('作业面积不能为空','text');
                $("#sumarea").focus();
                return false;
            }else if(starttime==''){
                $.toast('请选择拼单开始时间','text');
                $("#starttime").focus();
                return false;
            }else if(endtime==''){
                $.toast('请选择拼单结束时间','text');
                $("#endtime").focus();
                return false;
            }else if(shachongSel==''){
                $.toast('请选择您要拼单的地块','text');
                $("#shachongSel").focus();
                return false;
            }else if(landSel==''){
                $.toast('选择农药','text');
                $("#landSel").focus();
                return false;
            }else{
                //console.log(pname);
                return true;
            }

        }


    </script>

</body>
</html>