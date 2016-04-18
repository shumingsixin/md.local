<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.form.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/profile.js?ts=' . time(), CClientScript::POS_END);
?>
<?php
/*
 * $model UserDoctorProfileForm.
 */
$this->setPageID('pUserDoctorProfile');
$this->setPageTitle('个人信息');
$urlLogin = $this->createUrl('doctor/login');
$urlTermsPage = $this->createUrl('home/page', array('view' => 'terms'));
$urlLoadCity = $this->createUrl('/region/loadCities', array('state' => ''));
$urlSubmitProfile = $this->createUrl("doctor/ajaxProfile");
$urlReturn = $returnUrl;
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="profile_section" class="active" data-init="true">
        <article id="a1" class="active" data-scroll="true">
            <div class="pb20">
                <?php
                if ($register == 1) {
                    ?>
                    <div class="pad10">
                        注册成功
                    </div>
                    <div class="pad10">
                        请您完善基本信息，让我们认识您：
                    </div>
                    <?php
                }
                ?>
                <div class="form-wrapper">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'doctor-form',
                        'htmlOptions' => array('data-url-action' => $urlSubmitProfile, 'data-url-return' => $urlReturn),
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
                    <ul class="list">
                        <li>
                            <?php echo CHtml::activeLabel($model, 'name'); ?>
                            <?php echo $form->textField($model, 'name', array('name' => 'doctor[name]', 'placeholder' => '请输入真实姓名', 'maxlength' => 45)); ?>
                            <?php echo $form->error($model, 'name'); ?> 
                        </li>
                        <li>         
                            <?php echo CHtml::activeLabel($model, 'state_id'); ?>                
                            <?php
                            echo $form->dropDownList($model, 'state_id', $model->loadOptionsState(), array(
                                'name' => 'doctor[state_id]',
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
                                'name' => 'doctor[city_id]',
                                'prompt' => '选择城市',
                                'class' => '',
                            ));
                            ?>
                            <?php echo $form->error($model, 'city_id'); ?>                     
                        </li>
                        <li>
                            <?php echo CHtml::activeLabel($model, 'hospital_name'); ?>                                               
                            <?php echo $form->textField($model, 'hospital_name', array('name' => 'doctor[hospital_name]', 'placeholder' => '您所在的医院全称', 'maxlength' => 45)); ?>
                            <?php echo $form->error($model, 'hospital_name'); ?> 
                        </li>
                        <li>
                            <?php echo CHtml::activeLabel($model, 'hp_dept_name'); ?>                
                            <?php echo $form->textField($model, 'hp_dept_name', array('name' => 'doctor[hp_dept_name]', 'placeholder' => '您所在的科室', 'maxlength' => 45)); ?>
                            <?php echo $form->error($model, 'hp_dept_name'); ?> 
                        </li>
                        <li>
                            <?php echo CHtml::activeLabel($model, 'clinical_title'); ?>
                            <?php
                            echo $form->dropDownList($model, 'clinical_title', $model->loadOptionsClinicalTitle(), array(
                                'name' => 'doctor[clinical_title]',
                                'prompt' => '临床职称',
                                'class' => '',
                            ));
                            ?>
                            <?php echo $form->error($model, 'clinical_title'); ?>                     
                        </li>
                        <li>
                            <?php echo CHtml::activeLabel($model, 'academic_title'); ?>                               
                            <?php
                            echo $form->dropDownList($model, 'academic_title', $model->loadOptionsAcademicTitle(), array(
                                'name' => 'doctor[academic_title]',
                                'prompt' => '学术职称',
                                'class' => '',
                            ));
                            ?>
                            <?php echo $form->error($model, 'academic_title'); ?>                     
                        </li>
                        <li>
                            <?php //$form->hiddenField($model, 'terms', array('name' => 'doctor[terms]'));    ?>                    
                            <?php echo $form->checkBox($model, 'terms', array('name' => 'doctor[terms]')); ?>
                            <label for="doctor_terms" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-checkbox-on">同意名医主刀</label>
                            <a id="termslink" class="ui-link">《在线服务条款》</a>
                            <?php echo $form->error($model, 'terms'); ?>  
                        </li>
                        <li>
<!--                            <input id="btnSubmit" class="btn btn-yes btn-block" type="button" value="提交">-->
                            <a id="btnSubmit" class="btn btn-yes btn-block">提交</a>
                            <!--                <button id="btnSubmit" type="button" class="statusBar state-pedding">提交</button>-->
                        </li>
                    </ul>
                    <?php
                    $this->endWidget();
                    ?>
                </div>
            </div>
            <div id="termsShow" class="terms">
                <div>
                    <div>
                        <?php $this->renderPartial("//home/terms"); ?>
                    </div>
                    <div class="">
                        <a href="javascript:;" class="hideTerms btn btn-yes btn-block">确 认</a>
                    </div>
                </div>
            </div>
        </article>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#termslink").click(function () {
            $("#termsShow").show();
            $('#a1').scrollTop(0);
        });
        $(".hideTerms").click(function () {
            $("#termsShow").hide();
        });
        $("select#doctor_state_id").change(function () {
            $("select#doctor_city_id").attr("disabled", true);
            var stateId = $(this).val();
            var actionUrl = "<?php echo $urlLoadCity; ?>";// + stateId + "&prompt=选择城市";
            $.ajax({
                type: 'get',
                url: actionUrl,
                data: {'state': this.value, 'prompt': '选择城市'},
                cache: false,
                // dataType: "html",
                'success': function (data) {
                    $("select#doctor_city_id").html(data);
                    // jquery mobile fix.
                    captionText = $("select#doctor_city_id>option:first-child").text();
                    $("#doctor_city_id-button>span:first-child").text(captionText);
                },
                'error': function (data) {
                },
                complete: function () {
                    $("select#doctor_city_id").attr("disabled", false);
                    $("select#doctor_city_id").removeAttr("disabled");
                }
            });
            return false;
        });
    });
</script>