<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/mobile.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js', CClientScript::POS_HEAD);
/*
 * $model DoctorForm.
 */
$this->setPageID('pBookingInfo');
$this->setPageTitle('预约详情');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$urlPatientFiles = $this->createUrl('patient/patientMRFiles', array('mrId' => $data->booking->mrid));
?>

<div id="<?php echo $this->getPageID(); ?>" class="dr-view wheat" data-role="page" data-title="<?php echo $this->getPageTitle(); ?>" data-add-back-btn="true" data-back-btn-text="返回">
    <style>
        .ui-content{letter-spacing: 2px;}
        .bookingstate{font-size: 16px;color: #19aea5;}
        .bookingstate .fa{margin-right: 10px;}
        .title{color: #19aea5;padding-right: 20px;}
        .patientinfo span{padding: 0 10px;}
        .patientinfo .title{padding-left: 0;}
        .border-right{border-right: 1px solid #888;}
        .ui-grid-a img{background-color: #fff;margin: 10px 0;}
        .ui-grid-a>.ui-block-a{padding-right: 10px;}
        .ui-grid-a>.ui-block-b{padding-left: 10px;}
    </style>
    <div data-role="content">
        <div>
            <?php
            $booking = $data->booking;
            ?>
            <div class="text-center bookingstate"><i class="fa fa-heart"></i> <?php echo $booking->status ?></div>
            <div class="mt20">
                <span class="title">就诊意向：</span><span><?php echo $booking->travelType ?></span>
            </div>
            <div class="mt20">
                <span class="title">就诊时间：</span>
                <div class="mt10"><?php echo $booking->dateStart ?> -- <?php echo $booking->dateEnd ?></div>
            </div>
            <div class="mt20">
                <span class="title">就诊情况：</span>
                <div class="mt10"><?php echo $booking->detail ?></div>
            </div>
            <div class="mt50 patientinfo">
                <span class="title">患者情况：</span><span class="border-right"><?php echo $booking->name ?></span><span class="border-right"><?php echo $booking->gender ?></span><span class="border-right"><?php echo $booking->age ?>岁</span><span><?php echo $booking->cityName ?></span>
            </div>
            <div class="mt20">
                <span class="title">病情描述：</span>
                <div class="mt10"><?php echo $booking->diseaseDetail ?></div>
            </div>
            <div class="mt20">
                <span class="title">影像资料：</span>
                <div class="ui-grid-a imglist mt10">
                    
                </div>
            </div>
            <div class="mt30"></div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            urlPatientFiles = "<?php echo $urlPatientFiles; ?>";
            $.ajax({
                url: urlPatientFiles,
                success: function (data) {
                    setImgHtml(data.files);
                }
            });
            function setImgHtml(imgfiles) {
                var innerHtml = '';
                var uiBlock = '';
                if (imgfiles && imgfiles.length > 0) {
                    for (i = 0; i < imgfiles.length; i++) {
                        if (i % 2 === 0) {
                            uiBlock = 'ui-block-a';
                        }
                        else {
                            uiBlock = 'ui-block-b';
                        }
                        console.log(imgfiles[i]);
                        innerHtml +=
                                '<div class="' + uiBlock + '"><img src="' + imgfiles[i].absFileUrl + '"></div>';
                    }
                } else {
                    innerHtml += '无';
                }
                $(".imglist").html(innerHtml);
            }
        });
    </script>
</div>
