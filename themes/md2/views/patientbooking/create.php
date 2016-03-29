<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.formvalidate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/patientBooking.min.js?ts=' . time(), CClientScript::POS_END);
?>
<?php
/*
 * $model PatientBookingForm.
 */
$this->setPageID('pCreateBooking');
$this->setPageTitle('就诊信息');
$urlSubmit = $this->createUrl('patientbooking/ajaxCreate');
$urlProfile = $this->createUrl('doctor/profile', array('addBackBtn' => 1));
$urlReturn = $this->createUrl('order/view');
$urlRealName = $this->createUrl('doctor/profile');
$urlDoctorUploadCert = $this->createUrl('doctor/uploadCert');
$real = $userDoctorProfile;
$userDoctorCerts = $doctorCerts;
?>
<div id="section_container">
    <section id="patientBookingCreate_section" class="active" data-init="true">
        <article class="active" data-scroll="true">
            <div class="ml10 mr10 mb20">
                <div class="form-wrapper">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'booking-form',
                        'action' => $urlSubmit,
                        'htmlOptions' => array('data-url-return' => $urlReturn),
                        'enableClientValidation' => false,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'validateOnType' => true,
                            'validateOnDelay' => 500,
                            'errorCssClass' => 'error',
                        ),
                        'enableAjaxValidation' => false,
                    ));
                    ?>
                    <?php echo $form->hiddenField($model, 'patient_id', array('name' => 'booking[patient_id]')); ?>
                    <?php echo $form->hiddenField($model, 'user_agent', array('name' => 'booking[user_agent]')); ?>
                    <ul class="list">
                        <li>
                            <label for="booking_travel_type" class="">就诊方式:</label>
                            <div class="grid pl2 mt10">
                                <!--<legend>第一步:</legend>-->
                                <?php
                                $travelTrype = $model->travel_type;
                                $optionsTravelType = $model->loadOptionsTravelType();
                                foreach ($optionsTravelType as $key => $caption) {
                                    $inputId = 'booking_travel_type_' . $key;
                                    if ($travelTrype == $key) {
                                        echo "<div class='col-0 w50'><input type='radio' name='booking[travel_type]' id='$inputId' value='$key' checked/>";
                                    } else {
                                        echo "<div class='col-0 w50'><input type='radio' name='booking[travel_type]' id='$inputId' value='$key'/>";
                                    }
                                    echo "<label for='$inputId'>&nbsp;$caption</label></div>";
                                }
                                ?>
                                <?php echo $form->error($model, 'travel_type'); ?>
                            </div>                
                        </li>
                        <li>                
                            <h4>意向就诊日期</h4>
                            <div>
                                <label for="booking_date_start">最早：</label>     
                                <?php echo $form->textField($model, 'date_start', array('name' => 'booking[date_start]', 'placeholder' => '点击选择时间', 'class' => 'calendar')); ?>
                                <?php echo $form->error($model, 'date_start'); ?>
                            </div>
                            <div>
                                <label for="booking_date_start">最迟：</label>     
                                <?php echo $form->textField($model, 'date_end', array('name' => 'booking[date_end]', 'placeholder' => '点击选择时间', 'class' => 'calendar')); ?>
                                <?php echo $form->error($model, 'date_end'); ?>
                            </div>
                        </li>
                        <li>
                            <label for="booking_detail" class="">详情描述:</label>
                            <div>
                                <?php
                                echo $form->textArea($model, 'detail', array(
                                    'name' => 'booking[detail]',
                                    'maxlength' => 1000,
                                    'rows' => '6',
                                    'placeholder' => '请简要表述您的需求。例如：北京--阜外心血管病医院--成人外科--许建屏教授来我院完成该例手术。如无明确需求，请填写“无”，同时名医主刀会为您寻找该领域三甲医院副主任医生级别以上的医生前来就诊。'
                                ));
                                ?>                   
                            </div>
                            <?php echo $form->error($model, 'detail'); ?>                
                        </li>
                        <li>
<!--                            <input id="btnSubmit" class="btn btn-yes btn-block" type="button" name="yt0" value="提交">-->
                            <a id="btnSubmit" class="btn btn-yes btn-block">提交</a>
                        </li>
                    </ul>
                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </article>
    </section>
</div>
<script>
    Zepto(function ($) {
        //是否实名认证
        $realName = '<?php echo $real; ?>';
        $urlRealName = '<?php echo $urlRealName; ?>';
        $userDoctorCerts = '<?php echo $userDoctorCerts; ?>'
        $userDoctorUploadCert = '<?php echo $urlDoctorUploadCert; ?>';
        $('#booking-form #booking_date_start').tap(function () {
            J.popup({
                html: '<div id="popup_calendar"></div>',
                pos: 'center',
                backgroundOpacity: 0.4,
                showCloseBtn: false,
                onShow: function () {
                    new J.Calendar('#popup_calendar', {
                        date: new Date(),
                        months: ["01月", "02月", "03月", "04月", "05月", "06月",
                            "07月", "08月", "09月", "10月", "11月", "12月"],
                        days: ["日", "一", "二", "三", "四", "五", "六"],
                        onSelect: function (date) {
                            $("#booking_date_start").val(date);
                            J.closePopup();
                        }
                    });
                }
            });
        });
        $('#booking-form #booking_date_end').tap(function () {
            var dataStart = $("#booking_date_start").val();
            var nowDate = new Date();
            dataStart = dataStart ? getStartTiem(dataStart, 6) : nowDate;
            J.popup({
                html: '<div id="popup_calendar"></div>',
                pos: 'center',
                backgroundOpacity: 0.4,
                showCloseBtn: false,
                onShow: function () {
                    new J.Calendar('#popup_calendar', {
                        date: new Date(dataStart),
                        months: ["01月", "02月", "03月", "04月", "05月", "06月",
                            "07月", "08月", "09月", "10月", "11月", "12月"],
                        days: ["日", "一", "二", "三", "四", "五", "六"],
                        onSelect: function (date) {
                            $("#booking_date_end").val(date);
                            J.closePopup();
                        }
                    });
                }
            });
        });
    });
    //根据开始时间返回结束时间， +days天
    function getStartTiem(date, days) {
        var timestamp = new Date(date).getTime();
        var newDate = new Date(timestamp + days * 24 * 3600 * 1000);
        var y = newDate.getFullYear(), m = newDate.getMonth() + 1, d = newDate.getDate();
        m = (m < 10) ? ('0' + m) : m;
        d = (d < 10) ? ('0' + d) : d;
        return y + '-' + m + '-' + d;
    }
</script>