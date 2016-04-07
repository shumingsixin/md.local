<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.formvalidate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/patient.js?ts=' . time(), CClientScript::POS_END);
/*
 * $model PatientInfoForm.
 */
$this->setPageID('pCreatePatient');
$this->setPageTitle('创建患者');
$urlSavePatient = $this->createUrl('patient/savePatient');
$urlLoadCity = $this->createUrl('/region/loadCities', array('state' => ''));
$urlSubmit = $this->createUrl('patient/ajaxCreate');
$urlReturn = $this->createUrl('patient/uploadMRFile', array('type' => 'create'));
$currentUrl = $this->getCurrentRequestUrl();
$urlDoctorTerms = $this->createAbsoluteUrl('doctor/doctorTerms');
$urlDoctorTerms.='?returnUrl=' . $currentUrl;
$urlDoctorView = $this->createUrl('doctor/view');
$checkTeamDoctor = $teamDoctor;
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?> >
    <section id="createPatinal_section" class="active" data-init="true">
        <article class="active" data-scroll="true">
            <div class="ml10 mr10 mb20">
                <div calss="form-wrapper">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'patient-form',
                        'htmlOptions' => array('data-url-action' => $urlSubmit, 'data-url-return' => $urlReturn),
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
                    <?php echo $form->hiddenField($model, 'country_id', array('name' => 'patient[country_id]')); ?>
                    <ul class="list">
                        <li>
                            <?php //echo CHtml::activeLabel($model, 'name'); ?>                                            
                            <label for="PatientInfoForm_name">患者姓名</label>
                            <?php echo $form->textField($model, 'name', array('name' => 'patient[name]', 'placeholder' => '请填写真实姓名', 'maxlength' => 45)); ?>
                            <?php echo $form->error($model, 'name'); ?>  
                        </li>
                        <li>
                            <?php //echo CHtml::activeLabel($model, 'mobile'); ?>    
                            <label for="PatientInfoForm_mobile">患者手机号码</label>
                            <?php echo $form->textField($model, 'mobile', array('name' => 'patient[mobile]', 'placeholder' => '请填写手机号码', 'maxlength' => 50)); ?>
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
                            <div class="grid">
                                <div class="col-0 w50">
                                    <input type='radio' name='patient[gender]' id='patient_gender_male' value='1'/><label for='patient_gender_male'>&nbsp;男</label>
                                    <div></div>
                                </div>
                                <div class="col-0 w50">
                                    <input type='radio' name='patient[gender]' id='patient_gender_female' value='2'/><label for='patient_gender_female'>&nbsp;女</label>
                                    <div></div>
                                </div>
                            </div>
                            <?php echo $form->error($model, 'gender'); ?>
                        </li>
                        <li>
                            <?php echo CHtml::activeLabel($model, 'state_id'); ?>
                            <?php
                            $model->state_id = null;
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
<!--                                <input type="button" id="btnSubmit" class="btn-yes pl50 pr50 pt10 pb10 text-center" value="下一步" />-->
                                <a id="btnSubmit" class="btn-yes pl50 pr50 pt10 pb10 text-center">下一步</a>
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
<script type="text/javascript">
    $(document).ready(function () {
        //签约专家跳转过来的returnUrl
        $returnUrl = '<?php echo $returnUrl; ?>';

        if ('<?php echo $checkTeamDoctor; ?>' == 1) {
            J.customConfirm('您已实名认证',
                    '<div class="mt10 mb10">尚未签署《医生顾问协议》</div>',
                    '<a data="cancel" class="w50">暂不</a>',
                    '<a data="ok" class="color-green w50">签署协议</a>',
                    function () {
                        location.href = "<?php echo $urlDoctorTerms; ?>";
                    },
                    function () {
                        location.href = "<?php echo $urlDoctorView; ?>";
                    });
        }
        //初始化年月下拉菜单
        initDateSelect();
        $("select").change(function () {
            $(this).parents(".ui-select").find("span.error").removeClass(".error");
        });
        $("select#patient_state_id").change(function () {
            $("select#patient_city_id").attr("disabled", true);
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
                    $("select#patient_city_id").attr("disabled", false);
                    $("select#patient_city_id").removeAttr("disabled");
                }
            });
            return false;
        });
    });
    function initDateSelect() {
        var yearSelect = $("#patient_birth_year"),
                monthSelect = $("#patient_birth_month"),
                nowYear = new Date().getFullYear(),
                yearInnerHtml = '',
                monthInnerHtml = '';
        for (var i = 0; i <= 150; i++) {
            yearInnerHtml += '<option value="' + (nowYear - i) + '">' + (nowYear - i) + '年</option>';
        }
        yearSelect.append(yearInnerHtml);
        for (var i = 1; i < 13; i++) {
            monthInnerHtml += '<option value="' + i + '">' + i + '月</option>';
        }
        monthSelect.append(monthInnerHtml);
    }
</script>