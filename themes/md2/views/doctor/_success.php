<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pSuccess');
$this->setPageTitle('提交成功');
$urlDocView = $this->createUrl('doctor/view');
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="account_section" class="active">
        <article class="active" data-scroll="true">
            <div class="text-center mt20">    
                <h4>恭喜您提交成功！</h4>
                <br/>
                <a class="btn btn-yes btn-block" data-target="link"  href="<?php echo $urlDocView; ?>">返回个人中心</a>
            </div>
        </article>
    </section>
</div>