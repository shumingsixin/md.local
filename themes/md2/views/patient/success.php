<?php
/*
 * $model PatientMRForm.
 */
$this->setPageID('pCreatePatientMR');
$this->setPageTitle('修改患者病历');
$urlView = $this->createUrl('patientbooking/view', array('id'=>1));
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="success_section" class="active" data-init="true">
	<header>
		<nav class="left">
			<a href="#" class="color-000" data-target="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">提交成功</h1>
	</header>

	<article class="active" data-scroll="true">
		<div class="ml10 mr10 mt50 mb20">
			<div class="grid pt50 mb50 font-type">
				<div class="col-0 w30 text-center color-green" data-icon="checkmark"></div>
				<div class="col-0 w70">
					您的预约提交成功！
				</div>
			</div>
			<div class="font-type mb50">
				名医助手会尽快确认，并在第一时间联系您，请保持手机通畅。
			</div>
			<div class="text-center">
                            <a href="<?php echo $urlView; ?>" class="btn-green pl50 pr50 pt10 pb10 font-type h50 text-center" data-target="link">查看</a>
			</div>
		</div>
		
	</article>
	
</section>
    
</div>
