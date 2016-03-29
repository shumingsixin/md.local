<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.form.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.validate.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/contract.js', CClientScript::POS_END);
?>	
<?php
/*
 * $model PatientInfoForm.
 */
$this->setPageID('pContract');
$this->setPageTitle('专家签约');
$urlSubmit = $this->createUrl('doctor/ajaxContract');
$urlReturn = $this->createUrl('doctor/view');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="profile_section" class="active" data-init="true">
        <article id="a1" class="active" data-scroll="true">
            <div class="pb20">
                <div calss="form-wrapper">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'doctor-form',
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
                    <ul class="list">
                        <li>
                            <?php //echo CHtml::activeLabel($model, 'preferred_patient'); ?>   
                            <label for="DoctorContractForm_preferred_patient">希望收到的病例(疾病种类/手术种类)</label>
                            <?php echo $form->textArea($model, 'preferred_patient', array('placeholder' => '您想要获取哪种患者或病例？如果没有特殊要求，请填写“无”', 'maxlength' => 1000)); ?>
                            <?php echo $form->error($model, 'preferred_patient'); ?>   
                        </li>
                        <li class="hide">
                            <?php //$form->hiddenField($model, 'terms', array('name' => 'doctor[terms]'));    ?>                    
                            <label for="DoctorContractForm_terms" class="">同意名医主刀</label>
                            <a id="termslink" class="ui-link">《专家签约协议》</a>
                            <?php echo $form->checkBox($model, 'terms', array('checked' => 'checked')); ?>
                            <?php echo $form->error($model, 'terms'); ?>  
                        </li>
                        <li>
                            <div>
                                <a id="showTerms" href="javascript:void(0);" class="btn btn-yes btn-block">提交</a>
                            </div>
                        </li>
                    </ul>
                    <?php
                    $this->endWidget();
                    ?>           
                </div>
                <br />
                <div id="terms" class="terms">
                    <div>
                        <div>
                            <?php $this->renderPartial("//home/termsDoctorContract"); ?>
                        </div>
                        <div class="mt20">
                            <div class="ui-grid-a">
                                <div class="ui-block-a">
                                    <a href="javascript:void(0);" class="hideTerms btn btn-default btn-block" >取 消</a>
                                </div>
                                <div class="ui-block-b">
                                    <a id="btnSubmit" href="javascript:;" class="btn btn-yes btn-block">同 意</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <br/>
                    </div>
                </div>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        var scenarioType = '<?php echo $model->scenario; ?>';
        if (scenarioType == 'update') {
            $("#DoctorContractForm_terms").attr('checked', 'checked');
        }
    });
</script>
