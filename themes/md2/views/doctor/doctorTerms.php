<?php
/*
 * $model UserDoctorMobileLoginForm.
 */
$this->setPageID('pContrat');
$this->setPageTitle('医生顾问协议');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$urlDoctorView = $this->createUrl('doctor/view');
$urlAjaxDoctorTerms = $this->createUrl('doctor/ajaxDoctorTerms');
$urlReturn = $returnUrl;
?>
<div id="section_container">
    <style>
        #terms{display: block;position: relative;}
    </style>
    <section id="createPatinal_section" class="active" data-init="true">
        <article id="terms_section" class="active" data-scroll="true">
            <div id="terms" class="terms">
                <div>
                    <div>
                        <?php $this->renderPartial("//home/doctorContract"); ?>
                    </div>
                    <div class="mt20">
                        <?php if ($teamDoctor == 0) { ?>
                            <div class="ui-grid-a">
                                <div class="ui-block-a">
                                    <a href="<?php echo $urlDoctorView; ?>" class="hideTerms btn btn-default btn-block" >取 消</a>
                                </div>
                                <div class="ui-block-b">
                                    <a id="agreeDoctorTerms" class="btn btn-yes btn-block">同 意</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php } else { ?>
                            <div>
                                <a class="hideTerms btn btn-default btn-block" >已同意</a>
                            </div>
                        <?php } ?>
                    </div>
                    <br/>
                </div>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        $('#agreeDoctorTerms').tap(function (e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo $urlAjaxDoctorTerms; ?>',
                success: function (data) {
                    //console.log(data);
                    if (data.status == 'ok') {
                        J.showToast('操作成功', '', 1000);
                        setTimeout(function () {
                            location.href = '<?php echo $urlReturn; ?>';
                        }, 1000);

                    }
                }

            });
        });
    });
</script>