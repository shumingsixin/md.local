<?php
$this->setPageID('pEnquiry');
$this->setPageTitle('快速预约');
?>
<div id="<?php echo $this->getPageID(); ?>" data-role="page" data-title="<?php echo $this->getPageTitle(); ?>" <?php echo $this->createPageAttributes(); ?> data-nav-rel="#f-nav-enquiry">
    <div data-role="content" class="ui-content">
        <section class="m-panel sect-form">
            <div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'contact-enquiry-form',
                    'htmlOptions' => array('class' => 'enquiry-form'),
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'validateOnType' => true,
                        'validateOnDelay' => 500,
                        'errorCssClass' => 'error',
                    ),
                    'enableAjaxValidation' => false,
                        ));
                ?>

                <div class="ui-field-contain">
                    <?php echo $form->label($model, 'name'); ?>
                    <?php echo $form->textField($model, 'name', array('maxlength' => 45, 'data-clear-btn' => true, 'placeholder' => "患者的真实姓名")); ?>
                    <?php echo $form->error($model, 'name'); ?>
                </div>

                <div class="ui-field-contain">
                    <?php echo $form->label($model, 'age'); ?>
                    <?php
                    echo $form->dropDownList($model, 'age', $model->loadOptionsAge(), array(
                        'prompt' => '选择年龄',
                    ));
                    ?>
                    <?php echo $form->error($model, 'age'); ?>
                </div>

                <div class="ui-field-contain">
                    <?php echo $form->label($model, 'mobile'); ?>
                    <?php echo $form->textField($model, 'mobile', array('maxlength' => 11, 'data-clear-btn' => true, 'placeholder' => "您的手机号")); ?>
                    <?php echo $form->error($model, 'mobile'); ?>
                </div>

                <div class="ui-field-contain">
                    <?php echo $form->label($model, 'faculty_id'); ?>
                    <?php
                    echo $form->dropDownList($model, 'faculty_id', $model->loadOptionsFaculty(), array(
                        'prompt' => '选择科室',
                    ));
                    ?>
                    <?php echo $form->error($model, 'faculty_id'); ?>
                </div>

                <div class="ui-field-contain">
                    <?php echo $form->label($model, 'patient_condition'); ?>
                    <?php echo $form->textarea($model, 'patient_condition', array('maxlength' => 200, 'rows' => 8, 'placeholder' => "请填写您的咨询内容")); ?>
                    <?php echo $form->error($model, 'patient_condition'); ?>
                </div>

                <div class="ui-field-contain">
                    <?php
                    echo CHtml::ajaxSubmitButton('提交', CHtml::normalizeUrl(array('app/enquiry', 'render' => true)), array(
                        'dataType' => 'json',
                        'type' => 'post',
                        'beforeSend' => 'function(){$("#btnSubmitEnquiry").attr("disabled", true);}',
                        'success' => 'function(data) {                                               
                            var domForm = $("#contact-enquiry-form");
                            if(data.status=="true"){ 
                            var domSuccess=$("#form-result-success");
                            domSuccess.show();
                            domSuccess.popup("open");
                            domForm[0].reset();
                        }
                         else{
                            $.each(data, function(key, val) {
                            domForm.find("#"+key+"_em_").text(val);
                            domForm.find("#"+key+"_em_").show();
                        });
                        }       
                    }',
                        'complete' => 'function(){$("#btnSubmitEnquiry").attr("disabled", false);}'
                            ), array('id' => 'btnSubmitEnquiry', 'class' => 'btn-success', 'data-icon' => 'check', 'data-iconpos' => 'right'));
                    ?>
                </div>

                <?php
                $this->endWidget();
                ?> 
            </div>
        </section>
        <section class="m-panel mt1 sect-info">
            <div>
                <div class="ui-field-contain noborder tip">您也可以通过以下方式联系我们：</div>
                <div class="ui-field-contain noborder"><span class="label inline">电话：</span><span class="color-green">400-119-7900</span></div>
                <div class="ui-field-contain noborder"><span  class="label inline">邮箱：</span><span class="">service@mingyizhudao.com</span></div>
            </div>
        </section>
        <div id="form-result-success" class="ui-content" data-role="popup" style="display:none;color:#fff;background-color:rgba(0, 0, 0, 0.75);">
            <p>提交成功！</p><p>我们的名医助手会在第一时间与您确认预约的详情。</p>
        </div>
    </div>
</div>
