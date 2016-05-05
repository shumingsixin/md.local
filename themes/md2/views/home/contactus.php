<?php
$this->setPageID('pContactus');
$this->setPageTitle('联系我们');
?>
<div id="<?php echo $this->getPageID(); ?>" data-role="page" data-title="<?php echo $this->getPageTitle(); ?>" <?php echo $this->createPageAttributes(); ?> data-nav-rel="#f-nav-contactus">
    <div data-role="content" class="ui-content">
        <section class="m-panel sect-info">
            <div>
                <div class="ui-field-contain noborder tip">您可以通过以下方式联系我们：</div>
                <div class="ui-field-contain noborder"><span class="label inline">电话：</span><span class="color-green">400-6277-120</span></div>
                <div class="ui-field-contain noborder"><span  class="label inline">邮箱：</span><span class="">service@mingyizhudao.com</span></div>
            </div>
        </section>
        <section class="m-panel mt1 sect-form">
            <div>
                <div class="tip">您也可以留下你的的手机号及咨询内容，我们会第一时间联系你：</div>
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'contactus-form',
                    'enableClientValidation' => true,
                    'htmlOptions' => array('class' => 'contactus-form'),
                    'clientOptions' => array(
                        'validateOnSubmit' => false,
                    ),
                    'enableAjaxValidation' => true,
                        ));
                ?>

                <div class="ui-field-contain">
                    <?php echo $form->label($model, 'mobile'); ?>
                    <?php echo $form->textField($model, 'mobile', array('maxlength' => 11, 'data-clear-btn' => true, 'placeholder' => "您的手机号")); ?>
                    <?php echo $form->error($model, 'mobile'); ?>
                </div>

                <div class="ui-field-contain">
                    <?php echo $form->label($model, 'message'); ?>
                    <?php echo $form->textarea($model, 'message', array('maxlength'=>200, 'rows' => 8, 'placeholder' => "请填写您的咨询内容")); ?>
                    <?php echo $form->error($model, 'message'); ?>
                </div>
                
                <div class="ui-field-contain">
                    <?php echo CHtml::submitButton('提交', array('data-icon' => 'check')); ?>
                </div>
                <?php
                $this->endWidget();
                ?> 
            </div>
        </section>
        <section class="m-panel mt1 sect-wx">
            <div class="text-center">
                <div class="ui-field-contain noborder tip">关注我们的微信公众号：</div>
                <div class="ui-field-contain noborder tip"><span class="color-green">“名医主刀”</span></div>
                <div><img class="qrcode" src="<?php echo Yii::app()->baseUrl; ?>/resource/wx/wx_qrcode_344x344.jpg" /></div>
            </div>
        </section>        
        <section class="m-panel mt1 sect-aboutus">
            <div>
                <a class="ui-btn ui-btn-corner-all" href="<?php echo $this->createUrl('app/page', array('view' => 'aboutus', 'addBackBtn' => 1)); ?>" data-transition="slide">关于我们</a>
            </div>

        </section>
    </div>

</div>