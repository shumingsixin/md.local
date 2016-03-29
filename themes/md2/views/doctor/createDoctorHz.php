<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.formvalidate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/createDoctorHz.min.js?ts=' . time(), CClientScript::POS_END);
/*
 * $model UserDoctorMobileLoginForm.
 */
$this->setPageID('pCreateDoctorHz');
$this->setPageTitle('去外地会诊');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$urlSubmit = $this->createUrl('doctor/ajaxDoctorHz');
$urlReturn = $this->createUrl('doctor/drView');
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?> >
    <style>
        .formTip{color: #bbbbbb;font-size: 12px;}
        .fee .grid>.col-0{width: 10%;padding-top: 0.5em;}
        .noborder{border: 0!important;}
        .btn-contract{width:100%;margin:20px 0 0!important;background-color:#1199aa;color:#fff;border-radius: 6px;padding:10px!important;box-shadow:0 1px 0px #093d44;-moz-box-shadow:0 1px 0px #093d44;-webkit-box-shadow:0 1px 0px #093d44;}
        .w60p{width:60px;}
        .p11{padding:11px;}
        .checkNumber{border:none!important;border-bottom:1px solid #555!important;border-radius:0!important;-webkit-box-shadow:none!important;box-shadow:none!important;padding:0!important;height:20px!important;width:60px!important;text-align:center;}
    </style>
    <section id="createPatinal_section" class="active" data-init="true">
        <article class="active" data-scroll="true">
            <div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'docHz-form',
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
                echo $form->hiddenField($model, 'user_id', array('name' => 'DoctorHuizhenForm[user_id]'));
                echo $form->hiddenField($model, 'is_join', array('name' => 'DoctorHuizhenForm[is_join]', 'value' => 1));
                ?>
                <ul class="list">
                    <li class="fee">
                        <label>1.几台手术您愿意外出会诊?</label>
                        <div class="grid mt10 numberSurgery">
                            <div class="col-1 checkSurgery p11 selectSurgery1">
                                <input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery1d' class="surgery" value='1'/>
                                <label for="surgery1d" class="ui-btn ui-corner-all">1台</label>
                            </div>
                            <div class="col-1 checkSurgery p11 selectSurgery2">
                                <input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery2d' class="surgery" value='2'/>
                                <label for="surgery2d" class="ui-btn ui-corner-all">2台</label>
                            </div>
                            <div class="col-1 checkSurgery p11 selectSurgery3">
                                <input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery3d' class="surgery" value='3'/>
                                <label for="surgery3d" class="ui-btn ui-corner-all">3台</label>
                            </div>
                        </div>
                        <div class="mt10 grid surgeryNum pl10">
                            <div id="otherSurgery">
                                <input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery4d' class="surgery" value=''/>
                            </div>
                            <label class="pl10" for="surgery4d">其他:</label>
                            <div class="w60p"><?php echo $form->textField($model, 'min_no_surgery', array('class' => 'checkNumber', 'readonly' => 'true', 'name' => 'min_no_surgery')); ?></div>
                            <div class="">台</div>
                        </div>
                        <div id="surgery-error" class="error hide">请选择外出会诊要求</div>
                    </li>
                    <li class="fee">
                        <label for="DoctorHuizhenForm_fee">2.每台收费多少?</label>
                        <div class="grid mt10">
                            <div class="col-1">
                                <div>
                                    <?php echo $form->numberField($model, 'fee_min', array('name' => 'DoctorHuizhenForm[fee_min]', 'placeholder' => '最低额度')); ?>
                                </div>
                            </div>
                            <div class="col-0 text-center">
                                <span>~</span>
                            </div>
                            <div class="col-1">
                                <div>
                                    <?php echo $form->numberField($model, 'fee_max', array('name' => 'DoctorHuizhenForm[fee_max]', 'placeholder' => '最高额度')); ?>
                                </div>
                            </div>
                            <div class="col-0 text-center">
                                <span>元</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div>
                            <label>3.时间成本控制要求?<span class="color-green">(可多选)</span></label>
                        </div>
                        <div class="">
                            <div class="ui-block-a mt10">
                                <span class="checkDuration train3hSelect p11">
                                    <input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='train3h' value='train3h'/>
                                    <label for="train3h" class="ui-btn ui-corner-all">高铁3小时内</label>
                                </span>
                            </div>
                            <div class="ui-block-a mt20">
                                <span class="checkDuration train5hSelect p11">
                                    <input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='train5h' value='train5h'/>
                                    <label for="train5h" class="ui-btn ui-corner-all">高铁5小时内</label>
                                </span>
                            </div>
                            <div class="ui-block-a mt20">
                                <span class="checkDuration plane2hSelect p11">
                                    <input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='plane2h' value='plane2h'/>
                                    <label for="plane2h" class="ui-btn ui-corner-all">飞机2小时内</label>
                                </span>
                            </div>
                            <div class="ui-block-a mt20">
                                <div class="ui-block-b">
                                    <span class="checkDuration plane3hSelect p11">
                                        <input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='plane3h' value='plane3h'/>
                                        <label for="plane3h" class="ui-btn ui-corner-all">飞机3小时内</label>
                                    </span>
                                </div>
                            </div>
                            <div class="ui-block-a mt20">
                                <div class="ui-block-b">
                                    <span class="checkDuration noneSelect p11">
                                        <input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='none' value='none'/>
                                        <label for="none" class="ui-btn ui-corner-all">无</label>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix mt10"></div>
                        <?php echo $form->error($model, 'travel_duration'); ?>  
                    </li>
                    <li>
                        <label for="DoctorHuizhenForm_week_days">4.一般周几方便外出会诊?<span class="color-green">(可多选)</span></label>
                        <div class="grid mt10">
                            <div class="col-1 w33 p11 checkDay select-1">
                                <?php //echo $form->checkBox($model, 'week_days', array('name' => 'DoctorHuizhenForm[week_days]', 'id' => 'week_days1', 'value' => '1')); ?>
                                <input name="DoctorHuizhenForm[week_days]" id="week_days1" value="1" type="checkbox">
                                <label for="week_days1" class="ui-btn ui-corner-all">周一</label>
                            </div>
                            <div class="col-1 w33 p11 checkDay select-2">
                                <input name="DoctorHuizhenForm[week_days]" id="week_days2" value="2" type="checkbox">
                                <label for="week_days2" class="ui-btn ui-corner-all">周二</label>
                            </div>
                            <div class="col-1 w33 p11 checkDay select-3">
                                <input name="DoctorHuizhenForm[week_days]" id="week_days3" value="3" type="checkbox">
                                <label for="week_days3" class="ui-btn ui-corner-all">周三</label>
                            </div>
                        </div>
                        <div class="grid">
                            <div class="col-1 w33 p11 checkDay select-4">
                                <input name="DoctorHuizhenForm[week_days]" id="week_days4" value="4" type="checkbox">
                                <label for="week_days4" class="ui-btn ui-corner-all">周四</label>
                            </div>
                            <div class="col-1 w33 p11 checkDay select-5">
                                <input name="DoctorHuizhenForm[week_days]" id="week_days5" value="5" type="checkbox">
                                <label for="week_days5" class="ui-btn ui-corner-all">周五</label>
                            </div>
                            <div class="col-1 w33 p11 checkDay select-6">
                                <input name="DoctorHuizhenForm[week_days]" id="week_days6" value="6" type="checkbox">
                                <label for="week_days6" class="ui-btn ui-corner-all">周六</label>
                            </div>
                        </div>
                        <div class="grid">
                            <div class="col-1 w33 p11 checkDay select-7">
                                <input name="DoctorHuizhenForm[week_days]" id="week_days7" value="7" type="checkbox">
                                <label for="week_days7" class="ui-btn ui-corner-all">周日</label>
                            </div>
                            <div class="col-1 w33"></div>
                            <div class="col-1 w33"></div>
                        </div>
                    </li>
                    <li>
                        <?php //echo CHtml::activeLabel($model, 'patients_prefer'); ?>
                        <label for="DoctorHuizhenForm_patients_prefer">5.您希望会诊什么样的病人?</label>
                        <?php echo $form->textArea($model, 'patients_prefer', array('name' => 'DoctorHuizhenForm[patients_prefer]', 'placeholder' => '如没有特殊要求，可填"无"。', 'maxlength' => 500)); ?>
                        <?php echo $form->error($model, 'patients_prefer'); ?>
                    <li>
                        <?php //echo CHtml::activeLabel($model, 'freq_destination'); ?>
                        <label for="DoctorHuizhenForm_freq_destination">6.您常去哪些地区或医院会诊?</label>
                        <?php echo $form->textArea($model, 'freq_destination', array('name' => 'DoctorHuizhenForm[freq_destination]', 'placeholder' => '如没有特殊要求，可填"无"。', 'maxlength' => 500)); ?>
                        <?php echo $form->error($model, 'freq_destination'); ?>
                    </li>
                    <li class="noborder">
                        <?php //echo CHtml::activeLabel($model, 'destination_req'); ?>
                        <label for="DoctorHuizhenForm_action">7.您对手术地点/条件有何要求?</label>
                        <?php echo $form->textArea($model, 'destination_req', array('name' => 'DoctorHuizhenForm[destination_req]', 'placeholder' => '', 'maxlength' => 500, 'placeholder' => '医院规模是否三甲/二甲、既往手术量、设备条件、手术室条件等等。')); ?>
                        <?php echo $form->error($model, 'destination_req'); ?>
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


        //外出会诊
        var surgery = '<?php echo $model->min_no_surgery; ?>';
        if (surgery == '1') {
            $(".checkNumber").val("");
            $('.selectSurgery1').html("<input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery1d' class='surgery' value='1' checked='checked'/><label for='surgery1d' class='ui-btn ui-corner-all'> 1台</label>");
        } else if (surgery == '2') {
            $(".checkNumber").val("");
            $('.selectSurgery2').html("<input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery2d' class='surgery' value='2' checked='checked'/><label for='surgery2d' class='ui-btn ui-corner-all'> 2台</label>");
        } else if (surgery == '3') {
            $(".checkNumber").val("");
            $('.selectSurgery3').html("<input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery3d' class='surgery' value='3' checked='checked'/><label for='surgery3d' class='ui-btn ui-corner-all'> 3台</label>");
        } else if (surgery != '') {
            $('#otherSurgery').html("<input type='radio' name='DoctorHuizhenForm[min_no_surgery]' id='surgery4d' class='surgery' value='' checked='checked'/>");
        }

        //时间成本
        var travel = '<?php echo $model->travel_duration; ?>';
        if (travel != '') {
            var travelList = travel.split(',');
            if (travelList.length > 0) {
                for (var i = 0; i < travelList.length; i++) {
                    if (travelList[i] == "train3h") {
                        $('.train3hSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='train3h' value='train3h' checked='checked'/><label for='train3h' class='ui-btn ui-corner-all'> 高铁3小时内</label>");
                    }
                    if (travelList[i] == "plane2h") {
                        $('.plane2hSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='plane2h' value='plane2h' checked='checked'/><label for='plane2h' class='ui-btn ui-corner-all'> 飞机2小时内</label>");
                    }
                    if (travelList[i] == "train5h") {
                        $('.train5hSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='train5h' value='train5h' checked='checked'/><label for='train5h' class='ui-btn ui-corner-all'> 高铁5小时内</label>");
                    }
                    if (travelList[i] == "plane3h") {
                        $('.plane3hSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='plane3h' value='plane3h' checked='checked'/><label for='plane3h' class='ui-btn ui-corner-all'> 飞机3小时内</label>");
                    }
                    if (travelList[i] == "none") {
                        $('.noneSelect').html("<input type='checkbox' name='DoctorHuizhenForm[travel_duration]' id='none' value='none' checked='checked'/><label for='none' class='ui-btn ui-corner-all'> 无</label>");
                    }
                }
            }
        }

        //方便会诊时间
        var weekDays = '<?php echo $model->week_days; ?>';
        if (weekDays != '') {
            var dayList = weekDays.split(',');
            if (dayList.length > 0) {
                for (var i = 0; i < dayList.length; i++) {
                    if (dayList[i] == "1") {
                        $('.select-1').html('<input name="DoctorHuizhenForm[week_days]" id="week_days1" value="1" type="checkbox" checked="checked"><label for="week_days1" class="ui-btn ui-corner-all"> 周一</label>');
                    }
                    if (dayList[i] == "2") {
                        $('.select-2').html('<input name="DoctorHuizhenForm[week_days]" id="week_days2" value="2" type="checkbox" checked="checked"><label for="week_days2" class="ui-btn ui-corner-all"> 周二</label>');
                    }
                    if (dayList[i] == "3") {
                        $('.select-3').html('<input name="DoctorHuizhenForm[week_days]" id="week_days3" value="3" type="checkbox" checked="checked"><label for="week_days3" class="ui-btn ui-corner-all"> 周三</label>');
                    }
                    if (dayList[i] == "4") {
                        $('.select-4').html('<input name="DoctorHuizhenForm[week_days]" id="week_days4" value="4" type="checkbox" checked="checked"><label for="week_days4" class="ui-btn ui-corner-all"> 周四</label>');
                    }
                    if (dayList[i] == "5") {
                        $('.select-5').html('<input name="DoctorHuizhenForm[week_days]" id="week_days5" value="5" type="checkbox" checked="checked"><label for="week_days5" class="ui-btn ui-corner-all"> 周五</label>');
                    }
                    if (dayList[i] == "6") {
                        $('.select-6').html('<input name="DoctorHuizhenForm[week_days]" id="week_days6" value="6" type="checkbox" checked="checked"><label for="week_days6" class="ui-btn ui-corner-all"> 周六</label>');
                    }
                    if (dayList[i] == "7") {
                        $('.select-7').html('<input name="DoctorHuizhenForm[week_days]" id="week_days7" value="7" type="checkbox" checked="checked"><label for="week_days7" class="ui-btn ui-corner-all"> 周日</label>');
                    }
                }
            }
        }

    });
</script>