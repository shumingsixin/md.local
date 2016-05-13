<?php
$orderView = $this->createUrl('order/orderView');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$this->show_footer = false;
?>
<header id="payResult_header" class="bg-green">
    <h1 class="title">支付成功</h1>
    <nav class="right">
        <?php
        if ($order->order_type = 'deposit') {
            echo '<a href="' . $orderView . '/bookingid/' . $order->bk_id . '/status/1">确认</a>';
        } else {
            echo '<a href="' . $orderView . '/bookingid/' . $order->bk_id . '/status/5">确认</a>';
        }
        ?>
    </nav>
</header>
<div id="section_container" <?php echo $this->createPageAttributes(); ?> >
    <section id="addPatient_section" class="active" data-init="true">
        <article id="payResult_article" class="active" data-scroll="true">
            <div class="font-s14">
                <div class="text-center pt50">
                    <img src="http://7xsq2z.com2.z0.glb.qiniucdn.com/146285229270718" class="w79p">
                </div>
                <div class="font-s16 text-center color-orange pt20 pb20">
                    <?php
                    if ($order->order_type = 'deposit') {
                        echo '手术预约金支付成功！';
                    } else {
                        echo '您已成功预约' . $order->final_doctor_name . '专家！';
                    }
                    ?>
                </div>
                <div class="pt20 bt-gray pl10 pr10 color-gray">
                    <?php
                    if ($order->order_type = 'deposit') {
                        echo '名医助手已开始为您联系专家，并会在8小时内与您回访确认，请保持手机畅通，谢谢！';
                    } else {
                        echo '名医助手会协助安排您尽快手术，感谢您对名医主刀的信任。';
                    }
                    ?>
                </div>
                <div class="font-s12 text-center pt60 color-green">
                    <div>
                        如有疑问欢迎拨打客服热线400-6277-120
                    </div>
                    <div>
                        工作时间为每天9:30-18:00
                    </div>
                </div>
            </div>
        </article>
    </section>
</div>