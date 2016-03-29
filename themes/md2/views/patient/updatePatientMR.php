<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/patient.js', CClientScript::POS_END);
/*
 * $model PatientMRForm.
 */
$this->setPageID('pUpdatePatientMR');
$this->setPageTitle('修改患者病历');

$urlSubmitMR = $this->createUrl("patient/ajaxCreate");
$urlUploadFile = $this->createUrl("patient/ajaxUploadMRFile");
//$urlReturn = $this->createUrl('patient/view', array('id' => $model->id));
$urlReturn = $this->createUrl('patient/view');
$urlLoadCity = $this->createUrl('/region/loadCities', array('state' => ''));

if (isset($model->id)) {
    $urlPatientMRFiles = $this->createUrl('patient/patientMRFiles', array('id' => $model->id));
    $urldelectPatientMRFile = $this->createUrl('patient/delectPatientMRFile');
} else {
    $urlPatientMRFiles = "";
    $urldelectPatientMRFile = "";
}
//innit Form Parameter
$gender = $model->gender;
$birth_year = $model->birth_year;
$birth_month = $model->birth_month;
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="updatePatinal_section" class="active">
        <article class="active" data-scroll="true">
            <div class="ml10 mr10 mb20">
                <div calss="form-wrapper">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'patient-form',
                        'htmlOptions' => array('data-url-action' => $urlSubmitMR, 'data-url-return' => $urlReturn),
                        'enableClientValidation' => false,
                        'clientOptions' => array(
                            'validateOnSubmit' => true,
                            'validateOnType' => true,
                            'validateOnDelay' => 500,
                            'errorCssClass' => 'error',
                        ),
                        'enableAjaxValidation' => false,
                    ));
                    echo $form->hiddenField($model, 'country_id', array('name' => 'patient[country_id]'));
                    echo $form->hiddenField($model, 'id', array('name' => 'patient[id]'));
                    echo $form->hiddenField($model, 'name', array('name' => 'patient[name]'));
                    ?>
                    <ul class="list">
                        <li>
                            <label for="booking_info" class="patientinfo">患者姓名：<span class="patientname"><?php echo $model->name; ?></span></label>
                        </li>
                        <li>
                            <?php //echo CHtml::activeLabel($model, 'mobile'); ?>    
                            <label for="PatientInfoForm_mobile">患者联系方式</label>
                            <?php echo $form->textField($model, 'mobile', array('name' => 'patient[mobile]', 'placeholder' => '请填写患者的手机号码')); ?>
                            <?php echo $form->error($model, 'mobile'); ?>
                            <div></div>
                        </li>
                        <li>
                            <label for="PatientInfoForm_birth_year">出生年月</label>
                            <div class="ui-grid-a">
                                <div class="ui-block-a">
                                    <select name="patient[birth_year]" id="patient_birth_year">
                                        <option value>选择出生年份</option>
                                    </select>
                                </div>
                                <div class="ui-block-b pl10">
                                    <select name="patient[birth_month]" id="patient_birth_month">
                                        <option value>选择出生月份</option>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <?php echo $form->error($model, 'birth_year'); ?>
                            <?php echo $form->error($model, 'birth_year'); ?>
                        </li>
                        <li>
                            <?php echo CHtml::activeLabel($model, 'gender'); ?>  
                            <select name="patient[gender]" id="patient_gender">
                                <option value>选择性别</option>
                                <option value="1">男</option>
                                <option value="2">女</option>
                            </select>
                            <?php echo $form->error($model, 'gender'); ?>
                        </li>
                        <li>
                            <?php echo CHtml::activeLabel($model, 'state_id'); ?>
                            <?php
                            echo $form->dropDownList($model, 'state_id', $model->loadOptionsState(), array(
                                'name' => 'patient[state_id]',
                                'prompt' => '选择省份',
                                'class' => '',
                            ));
                            ?>

                            <?php echo $form->error($model, 'state_id'); ?> 
                        </li>
                        <li>
                            <?php echo CHtml::activeLabel($model, 'city_id'); ?>                                
                            <?php
                            echo $form->dropDownList($model, 'city_id', $model->loadOptionsCity(), array(
                                'name' => 'patient[city_id]',
                                'prompt' => '选择城市',
                                'class' => '',
                            ));
                            ?>
                            <?php echo $form->error($model, 'city_id'); ?>    
                        </li>
                        <li>
                            <?php echo CHtml::activeLabel($model, 'disease_name'); ?>                                            
                            <?php echo $form->textField($model, 'disease_name', array('name' => 'patient[disease_name]', 'placeholder' => '请输入疾病诊断', 'maxlength' => 50)); ?>
                            <?php echo $form->error($model, 'disease_name'); ?>   
                        </li>
                        <li>
                            <?php echo CHtml::activeLabel($model, 'disease_detail'); ?>                                            
                            <?php echo $form->textArea($model, 'disease_detail', array('name' => 'patient[disease_detail]', 'placeholder' => '请输入病史描述', 'maxlength' => 1000)); ?>
                            <?php echo $form->error($model, 'disease_detail'); ?>           
                        </li>
                        <li>
                            <div class="text-center btn-none">
<!--                                <input type="button" id="btnSubmit" class="btn-green pl50 pr50 pt10 pb10 text-center" value="提交" />-->
                                <a id="btnSubmit" class="btn-green pl50 pr50 pt10 pb10 text-center">提交</a>
                            </div>
                            <!--<input id="btnSubmit" class="" type="submit" name="yt0" value="提交">-->
                        </li>
                    </ul>
                    <?php
                    $this->endWidget();
                    ?>           
                </div>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        $returnUrl = '';
        
        var gender = '<?php echo $gender; ?>';
        var birth_year = '<?php echo $birth_year; ?>';
        var birth_month = '<?php echo $birth_month; ?>';
        initGender(gender);
        initDateSelect(birth_year, birth_month);
    });
    function initGender(gender) {
        var genderInnerHtml = '<option value="">选择性别</option>';
        for (var i = 1; i < 3; i++) {
            genderText = i == 1 ? '男' : '女';
            if (gender == i) {
                genderInnerHtml += '<option value="' + i + '" selected="selected">' + genderText + '</option>';
                $("#patient_gender-button>span").text(genderText);
            } else {
                genderInnerHtml += '<option value="' + i + '">' + genderText + '</option>';
            }
        }
        $("#patient_gender").html(genderInnerHtml);
    }
    function initDateSelect(birth_year, birth_month) {
        var yearSelect = $("#patient_birth_year"),
                monthSelect = $("#patient_birth_month"),
                nowYear = new Date().getFullYear(),
                yearInnerHtml = '',
                monthInnerHtml = '';
        for (var i = 0; i <= 150; i++) {
            yearVal = nowYear - i;
            if (yearVal == birth_year) {
                yearInnerHtml += '<option value="' + yearVal + '" selected="selected">' + yearVal + '年</option>';
                $("#patient_birth_year-button>span").text(yearVal + '年');
            } else {
                yearInnerHtml += '<option value="' + yearVal + '">' + yearVal + '年</option>';
            }
        }
        yearSelect.append(yearInnerHtml);
        for (var i = 1; i < 13; i++) {
            if (birth_month == i) {
                monthInnerHtml += '<option value="' + i + '"selected="selected">' + i + '月</option>';
                $("#patient_birth_month-button>span").text(birth_month + '月');
            } else {
                monthInnerHtml += '<option value="' + i + '">' + i + '月</option>';
            }
        }
        monthSelect.append(monthInnerHtml);
    }
    $("select#patient_state_id").change(function () {
        $("select#patient_city_id").prop("disabled", true);
        var stateId = $(this).val();
        var actionUrl = "<?php echo $urlLoadCity; ?>";// + stateId + "&prompt=选择城市";
        $.ajax({
            type: 'get',
            url: actionUrl,
            data: {'state': this.value, 'prompt': '选择城市'},
            cache: false,
            // dataType: "html",
            'success': function (data) {
                $("select#patient_city_id").html(data);
                // jquery mobile fix.
                captionText = $("select#patient_city_id>option:first-child").text();
                $("#patient_city_id-button>span:first-child").text(captionText);
            },
            'error': function (data) {
            },
            complete: function () {
                $("select#patient_city_id").prop("disabled", false);
            }
        });
        return false;
    });
</script>

