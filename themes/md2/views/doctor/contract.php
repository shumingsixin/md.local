<?php
/*
 * $model UserDoctorMobileLoginForm.
 */
$this->setPageID('pContrat');
$this->setPageTitle('专家签约');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$urlDoctorView = $this->createUrl('doctor/view');
$urlDoctorDrView = $this->createUrl('doctor/drView', array('addBackBtn' => 1));
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <style>
        #terms{display: block;position: relative;}
    </style>
    <section id="createPatinal_section" class="active" data-init="true">
        <article id="terms_section" class="active" data-scroll="true">
            <div id="terms" class="terms">
                <div>
                    <div>
                        <?php $this->renderPartial("//home/termsDoctorContract"); ?>
                    </div>
                    <div class="mt20">
                        <div class="ui-grid-a">
                            <div class="ui-block-a">
                                <a href="<?php echo $urlDoctorView; ?>" class="hideTerms btn btn-default btn-block" >取 消</a>
                            </div>
                            <div class="ui-block-b">
                                <a href="<?php echo $urlDoctorDrView; ?>" class="btn btn-yes btn-block">同 意</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <br/>
                </div>
            </div>
        </article>
    </section>
</div>
