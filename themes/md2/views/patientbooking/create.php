<?php
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.formvalidate.min.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/patientBooking.min.js?ts=' . time(), CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/patientBooking.js?ts=' . time(), CClientScript::POS_END);
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
        <article id="patientBookingCreate_article" class="active" data-scroll="true">
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
                    <div id="travel_type" class="mt20 triangleGreen">
                        <div class="font-s16">
                            <span class="">选择就诊意向</span>
                        </div>
                        <div class="grid mt10">
                            <?php
                            $travelTrype = $model->travel_type;
                            echo '' . $travelTrype;
                            $optionsTravelType = $model->loadOptionsTravelType();
                            $i = 1;
                            foreach ($optionsTravelType as $key => $caption) {
                                if ($travelTrype == $key) {
                                    echo '<div data-travel="' . $key . '" class="col-1 w50 intention">' . $caption . '</div>';
                                } else {
                                    if ($i == 1) {
                                        echo '<div data-travel="' . $key . '" class="col-1 w50 intention mr10">' . $caption . '</div>';
                                    } else {
                                        echo '<div data-travel="' . $key . '" class="col-1 w50 intention">' . $caption . '</div>';
                                    }
                                }
                                $i++;
                            }
                            ?>
                        </div>
                    </div>
                    <?php echo $form->hiddenField($model, 'travel_type', array('name' => 'booking[travel_type]')); ?>
                    <div class="mt20">
                        <label for="booking_doctor_name">请填写您想要预约的主刀医生</label>     
                        <?php echo $form->textField($model, 'doctor_name', array('name' => 'booking[doctor_name]', 'placeholder' => '如没有指定专家，可不填写，由名医助手匹配。', 'class' => 'mt10')); ?>
                        <div class="font-s12">示例：北京协和医院普外科刘跃武</div>
                        <?php echo $form->error($model, 'doctor_name'); ?>
                    </div>
                    <div class="mt20">
                        <label for="booking_detail" class="">诊疗意见</label>
                        <div>
                            <?php
                            echo $form->textArea($model, 'detail', array(
                                'name' => 'booking[detail]',
                                'maxlength' => 1000,
                                'rows' => '6',
                                'placeholder' => '如果有其他说明，请在此补充',
                                'class' => 'mt10'
                            ));
                            ?>                   
                        </div>
                        <?php echo $form->error($model, 'detail'); ?>                
                    </div>
                    <div>
<!--                            <input id="btnSubmit" class="btn btn-yes btn-block" type="button" name="yt0" value="提交">-->
                        <a id="btnSubmit" class="btn btn-yes btn-block">提交</a>
                    </div>
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
        $('.intention').click(function (e) {
            e.preventDefault();
            $('.noTravelType').remove();
            var travelType = $(this).attr('data-travel');
            $('input[name = "booking[travel_type]"]').attr('value', travelType);
            $('.intention').each(function () {
                $(this).removeClass('active');
            });
            $(this).addClass('active');
        });
    });
</script>