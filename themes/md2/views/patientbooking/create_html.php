<?php //Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . "/css/user.css" . "?v=" . time());                                                   ?>	
<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pCreatePatientMR');
$this->setPageTitle('就诊信息');
$urlLogin = $this->createUrl('doctor/login');
?>
<style>
    .ui-controlgroup-controls .ui-btn{color:#333;background-color: #f2f2f2;border-color: #f2f2f2;}
    .ui-radio .ui-btn.ui-radio-on:after{height: 18px;width: 18px;border-width: 6px;}
    .pl30{padding-left: 30px;}
    #booking_disdesc{margin-top: 15px;}
</style>
<div id="<?php echo $this->getPageID(); ?>" class="dr-view wheat" data-role="page" data-title="<?php echo $this->getPageTitle(); ?>" data-add-back-btn="true" data-back-btn-text="返回">
    <div data-role="content">
        <div>
            <form class="form-horizontal" method="post" id="booking-form" role="form">
                <div data-role="fieldcontain">
                    <div class="ui-field-contain">
                        <label for="booking_dis" class="">第一步:</label>
                        <div class="ui-controlgroup-controls pl30">
                            <fieldset data-role="controlgroup">
                                <input type="radio" name="step1" id="calldoc" value="1" checked="checked"/>
                                <label for="calldoc">邀请名医过来</label>
                                <input type="radio" name="step1" id="referral" value="2"/>
                                <label for="referral">希望转诊治疗</label>
                            </fieldset>
                        </div>
                        <div class="errorMessage" id="booking_dis_em_" style=""></div>
                    </div>
                    <div class="ui-field-contain">
                        <label for="booking_patient_condition" class="">第二步:</label>
                        <div>
                            <textarea name="booking[patient_condition]" id="patient_condition" placeholder="请简要表述您的需求。例如：北京--北京协和医院--口腔科--王力宏教授来我院完成该例手术。如无明确需求，名医主刀会为您寻找该领域三甲医院副主任医生级别以上的医生前来就诊。"></textarea>
                        </div>
                        <div class="errorMessage" id="booking_patient_condition_em_" style=""></div>
                    </div>

                    <div class="ui-field-contain">
                        <input id="btnSubmit" class="btn-success statusBar uploadBtn state-pedding" data-icon="check" data-iconpos="right" type="submit" name="yt0" value="提交">
                    </div>
                </div>
            </form>
        </div>

        <div class="mt30"></div>
    </div>  	
</div>
