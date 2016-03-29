<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/createDoctorZz.min.js?ts=' . time(), CClientScript::POS_END);
/*
 * $model UserDoctorMobileLoginForm.
 */
$this->setPageID('pCreateDoctorZz');
$this->setPageTitle('接受病人转诊');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$urlSubmit = $this->createUrl('doctor/ajaxDoctorZz');
$urlReturn = $this->createUrl('doctor/drView');
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?> >
    <style>
        .formTip{color: #bbbbbb;font-size: 12px;}
        .noborder{border: 0!important;}
        .btn-contract{width:100%;margin:20px 0 0!important;background-color:#1199aa;color:#fff;border-radius: 6px;padding:10px!important;box-shadow:0 1px 0px #093d44;-moz-box-shadow:0 1px 0px #093d44;-webkit-box-shadow:0 1px 0px #093d44;}
        .w70p{width:70px;}
        .p11{padding:11px;}
        .checkNumber{border:none!important;border-bottom:1px solid #555!important;border-radius:0!important;-webkit-box-shadow:none!important;box-shadow:none!important;padding:0!important;height:20px!important;width:60px!important;text-align:center;}
    </style>
    <section id="createPatinal_section" class="active" data-init="true">
        <article class="active" data-scroll="true">
            <div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'docZz-form',
                    'action' => $urlSubmit,
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
                    'htmlOptions' => array('role' => 'form', 'autocomplete' => 'off', 'data-ajax' => 'false', 'data-url-return' => $urlReturn),
                    'enableClientValidation' => false,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnType' => true,
                        'validateOnDelay' => 500,
                        'errorCssClass' => 'error',
                    ),
                    'enableAjaxValidation' => false,
                ));
                echo $form->hiddenField($model, 'user_id', array('name' => 'DoctorZhuanzhenForm[user_id]'));
                echo $form->hiddenField($model, 'is_join', array('name' => 'DoctorZhuanzhenForm[is_join]', 'value' => 1));
                ?>
                <ul class="list">
                    <li>
                        <label for="DoctorZhuanzhenForm_preferred_patient">1.对转诊病例有何要求?</label>
                        <?php echo $form->textArea($model, 'preferred_patient', array('name' => 'DoctorZhuanzhenForm[preferred_patient]', 'placeholder' => '如没有特殊要求，可填"无"。', 'maxlength' => 500)); ?>
                        <?php echo $form->error($model, 'preferred_patient'); ?>
                    </li>
                    <li>
                        <div>
                            <label>2.是否需要转诊费?</label>
                        </div>
                        <div class="grid mt10 numberFee">
                            <div class="col-1 checkFee p11 selectFee0">
                                <input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee0' value='0'/>
                                <label for="fee0" class="ui-btn ui-corner-all">不需要</label>
                            </div>
                            <div class="col-1 checkFee p11 selectFee500">
                                <input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee500' value='500'/>
                                <label for="fee500" class="ui-btn ui-corner-all">500元</label>
                            </div>
                            <div class="col-1 checkFee p11 selectFee1000">
                                <input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee1000' value='1000'/>
                                <label for="fee1000" class="ui-btn ui-corner-all">1000元</label>
                            </div>
                        </div>
                        <div class="grid mt10 feeNum pl10">
                            <div id="otherFee">
                                <input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee4' value=''/>
                            </div>
                            <label class="pl10" for="fee4">其他:</label>
                            <div class="w70p"><?php echo $form->textField($model, 'fee', array('class' => 'checkNumber', 'readonly' => 'ture', 'name' => 'fee')); ?></div>
                            <div class="">元</div>
                        </div>
                        <div class="clearfix mt10"></div>
                        <?php echo $form->error($model, 'fee'); ?>
                    </li>
                    <li class="noborder">
                        <div>
                            <label>3.您最快多久能够安排床位?</label>   
                        </div>
                        <div class="mt10">
                            <span class="checkPrepDay p11 select-3d">
                                <input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='3d' value='3d'/>
                                <label for="3d" class="ui-btn ui-corner-all">三天内</label>
                            </span>
                        </div>
                        <div class="mt20">
                            <span class="checkPrepDay p11 select-1w">
                                <input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='1w' value='1w'/>
                                <label for="1w" class="ui-btn ui-corner-all">一周内</label>
                            </span>
                        </div>
                        <div class="mt20">
                            <span class="checkPrepDay p11 select-2w">
                                <input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='2w' value='2w'/>
                                <label for="2w" class="ui-btn ui-corner-all">两周内</label>
                            </span>
                        </div>
                        <div class="mt20">
                            <span class="checkPrepDay p11 select-3w">
                                <input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='3w' value='3w'/>
                                <label for="3w" class="ui-btn ui-corner-all">三周内</label>
                            </span>
                        </div>
                        <div class="clearfix mt15"></div>
                        <?php echo $form->error($model, 'prep_days'); ?>
                    </li>

                    <li class="noborder">
                        <button id="btnSubmit" class="btn btn-contract btn-block">提交</button>      
                    </li>
                </ul>
                <?php $this->endWidget(); ?>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        //转诊费
        var fee = '<?php echo $model->fee; ?>';
        if (fee == '0') {
            $(".checkNumber").val("");
            $('.selectFee0').html("<input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee0' value='0' checked='checked'/><label for='fee0' class='ui-btn ui-corner-all'> 不需要</label>");
        } else if (fee == '500') {
            $(".checkNumber").val("");
            $('.selectFee500').html("<input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee500' value='500' checked='checked'/><label for='fee500' class='ui-btn ui-corner-all'> 500元</label>");
        } else if (fee == '1000') {
            $(".checkNumber").val("");
            $('.selectFee1000').html("<input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee1000' value='1000' checked='checked'/><label for='fee1000' class='ui-btn ui-corner-all'> 1000元</label>");
        } else if (fee != '') {
            $('#otherFee').html("<input type='radio' name='DoctorZhuanzhenForm[fee]' id='fee4' value='' checked='checked'/>");
        }

        //安排床位时间
        var days = '<?php echo $model->prep_days; ?>';
        if (days != '') {
            if (days == '3d') {
                $('.select-3d').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='3d' value='3d' checked='checked'/><label for='3d' class='ui-btn ui-corner-all'> 三天内</label>");
            }
            if (days == '1w') {
                $('.select-1w').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='1w' value='1w' checked='checked'/><label for='1w' class='ui-btn ui-corner-all'> 一周内</label>");
            }
            if (days == '2w') {
                $('.select-2w').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='2w' value='2w' checked='checked'/><label for='2w' class='ui-btn ui-corner-all'> 两周内</label>");
            }
            if (days == '3w') {
                $('.select-3w').html("<input type='radio' name='DoctorZhuanzhenForm[prep_days]' id='3w' value='3w' checked='checked'/><label for='3w' class='ui-btn ui-corner-all'> 三周内</label>");
            }
        }
    });
</script>