<?php
$baseUrl = 'http://md.mingyizhudao.com';

function isClientWeixin() {
    $ua = $_SERVER['HTTP_USER_AGENT'];
    $wxStr = 'micromessenger';
    return stripos($ua, $wxStr) > 0; // ignore case.
}

if (isClientWeixin() === false) {
    $url = $baseUrl . '/mobiledoctor/order/view?' . http_build_query($_GET);
    header("Location: " . $url);
}
$refNo = '';
if (isset($_GET['refNo'])) {
    $refNo = $_GET['refNo'];
}
$loadOrderDataUrl = $baseUrl . '/mobiledoctor/order/loadOrderPay?refNo=' . $refNo;
$cancelUrl = $baseUrl . '/mobiledoctor/doctor/view';
$payUrl = $baseUrl . '/mobiledoctor/payment/doPingxxPay';
$refUrl = $baseUrl . '/mobiledoctor/order/view?refNo=' . $refNo;
//$openid = 'o9D7bsrlWC5ecKJdSuyVAYLedjVc' ;                            //(可选，使用微信公众号支付时必须传入)';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
        <meta charset="utf-8">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="expires" content="0">
        <meta http-equiv="pragma" content="no-cache">
        <title>订单</title>
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/themes/md2/css/Jingle.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl . '/themes/md2/css/form.css?ts=' . time(); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/themes/md2/css/app.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $baseUrl . '/themes/md2/css/md.css?ts=' . time(); ?>">
        <script type="text/javascript" src="<?php echo $baseUrl; ?>/themes/md2/js/lib/zepto.min.js"></script>
        <link rel="stylesheet" type="text/css" href="http://md.mingyizhudao.com/themes/md2/js/pingpp-html5-master/example-wap/styles/pinus.css">
        <script type="text/javascript" src="http://myzd.oss-cn-hangzhou.aliyuncs.com/static/web/js/jquery-1.9.1.min.js"></script>
    </head>
    <body>
        <header class="bg-green">
            <!--<nav class="left"><a href="#" class="color-000" data-target="back" data-icon="previous"><i class="icon previous"></i></a></nav>    -->
            <h1 class="title color-white">订单</h1>
            <nav class="right">
                <a class="header-user" data-target="link" data-icon="user" href="<?php echo $cancelUrl; ?>"><i class="icon user"></i></a>
            </nav>
        </header>
        <div id="section_container">
            <section id="createPatinal_section" class="active" data-init="true">
                <article id="order" class="active" data-scroll="true">
                    <div class="order-content"><span class="title color-green">请支付</span><span class="color-green pull-right"><span id="orderAmount" class="color-green"></span>元</span></div>
                    <div class="divider"></div>
                    <div class="order-content"><span class="title color-green">订单号:</span><span id="orderNo"></span></div>
                    <div class="order-content"><span class="title color-green">订单标题:</span><span id="orderSubject"></span></div>
                    <div class="order-content">
                        <div class="title color-green mb5">订单详情:</div>
                        <span id="orderDesc"></span>
                    </div>
                    <div class="order-content"><span class="title color-green">订单状态:</span><span id="orderStatus"></span></div>
                    <div class="">
                        <form class="form-horizontal">
                            <input id="ref_no" type="hidden" name="order[ref_no]" value="" />
                        </form>
                    </div>
                    <div class="divider"></div>
                    <br/>
                    <div id="payBtn" class="ui-grid-a">                     
                        <div class="ui-block-a">
                            <a id="btnCancel" href="<?php echo $cancelUrl; ?>" class="btn btn-default btn-block" data-target="link">暂不支付</a>

                        </div>
                        <div class="ui-block-b">
                            <a id="pay" href="javascript:;" class="btn btn-yes btn-block">立即支付</a>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </article>
            </section>
        </div>
    </body>
    <script type="text/javascript" src="http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/pingpp-one/pingpp-one.js"></script>
    <script type="text/javascript">
        //var orderno = document.getElementById('ref_no').value;
        //var amount = 0.01;
        Zepto(function ($) {

            loadOrderData();
            var pingAmount = '', pingOrderno = '', pingOpenid = '';

            function initPing() {
                //    var openid='';
                document.getElementById('pay').addEventListener('click', function (e) {
                    pingpp_one.init({
                        app_id: 'app_SWv9qLSGWj1GKqbn', //该应用在ping++的应用ID
                        order_no: pingOrderno, //订单在商户系统中的订单号
                        amount: pingAmount * 100, //订单价格，单位：人民币 分
                        // 壹收款页面上需要展示的渠道，数组，数组顺序即页面展示出的渠道的顺序
                        // upmp_wap 渠道在微信内部无法使用，若用户未安装银联手机支付控件，则无法调起支付                
                        // channel: ['alipay_wap', 'wx_pub', 'yeepay_wap', 'upacp_wap', 'jdpay_wap', 'bfb_wap'],
                        channel: ['wx_pub', 'alipay_wap', 'yeepay_wap'], //'wx_pub'
                        //channel: ['alipay_wap', 'yeepay_wap'],
                        charge_url: "<?php echo $payUrl; ?>", //商户服务端创建订单的url              
                        charge_param: {ref_url: "<?php echo $refUrl; ?>"}, //(可选，用户自定义参数，若存在自定义参数则壹收款会通过 POST 方法透传给 charge_url)                        
                        open_id: pingOpenid
                    }, function (res) {
                        console.log("res data...");
                        console.log(res);
                        //alert(res.msg);
                        if (!res.status) {
                            //处理错误
                            console.log(res);
                            //alert(res.msg);
                        }
                        else {
                            //若微信公众号渠道需要使用壹收款的支付成功页面，则在这里进行成功回调，调用 pingpp_one.success 方法，你也可以自己定义回调函数
                            //其他渠道的处理方法请见第 2 节
                            pingpp_one.success(function (res) {
                                if (!res.status) {
                                    alert(res.msg);
                                } else {
                                    window.location.href = '<?php echo $refUrl; ?>';
                                }
                            }, function () {
                                //这里处理支付成功页面点击“继续购物”按钮触发的方法，例如：若你需要点击“继续购物”按钮跳转到你的购买页，则在该方法内写入 window.location.href = "你的购买页面 url"
                                window.location.href = '<?php echo $refUrl; ?>';
                                //alert("支付成功的跳转");
                            });
                        }
                    });
                });
            }
            function loadOrderData() {
                $.ajax({
                    url: "<?php echo $loadOrderDataUrl; ?>",
                    success: function (data) {
                        if (data.status == "ok") {
                            var order = data.data;
                            //var returnUrl = data.returnUrl;
                            console.log(order);
                            //  console.log(returnUrl);
                            updateData(order);
                            initPing();
                        } else {
                            console.log(data);
                            //alert(data);
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        //alert(data);
                    }
                });
            }

            function updateData(order) {
                $("#orderNo").html(order.refNo);
                $("#orderAmount").html(order.finalAmount);
                $("#orderSubject").html(order.subject);
                $("#orderDesc").html(order.description);
                if (order.isPaid == "0") {
                    $("#orderStatus").html("未支付");
                } else {
                    $("#orderStatus").html("已支付");
                    $('#payBtn').addClass('hide');
                }
                $("#btnCancel").attr("href", order.returnUrl);
                pingAmount = order.finalAmount;
                pingOrderno = order.refNo;
                pingOpenid = order.openid;
            }

        });
    </script>
</html>