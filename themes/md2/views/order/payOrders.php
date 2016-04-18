<?php
$bookingId = Yii::app()->request->getQuery('bookingId', '');
$this->setPageTitle('支付订单');
$orders = $data->results->orders;
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section class="active" data-scroll="true">
        <article class="active" data-scroll="true">
            <div>
                <ul class="list">
                    <?php
                    if (isset($orders) && (count($orders) > 0)) {
                        for ($i = 0; $i < count($orders); $i++) {
                            $order = $orders[$i];
                            ?>
                            <li>
                                <div class="grid">
                                    <div class="col-1 w60 pl20 vertical-center">
                                        支付<span class="color-yellow"><?php echo $order->finalAmount; ?></span>元
                                    </div>
                                    <?php
                                    if ($order->isPaid == '待支付') {
                                        echo '<div data-refNo="' . $order->refNo . '" class="pay col-1 w50p br5 bg-yellow color-white text-center pt7 pb5">支付</div>';
                                    } else {
                                        echo '<div class="col-1 w50p br5 bg-gray color-white text-center pt7 pb5">已支付</div>';
                                    }
                                    ?>
                                </div>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        $('.pay').click(function () {
            var refNo = $(this).attr('data-refNo');
            location.href = '<?php echo $this->createUrl('order/view', array('bookingId' => $bookingId, 'refNo' => '')); ?>/' + refNo;
        });
    });
</script>