<?php
/*
 * $model UserDoctorProfileForm.
 */
$this->setPageID('pUserDoctorProfile');
$this->setPageTitle('个人信息');
$urlUpdateDoctorReal = $this->createUrl('doctor/updateDoctorReal');
?>
<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="realName_section" class="active" data-init="true">
	<header>
		<nav class="left">
			<a href="#" class="color-000" data-target="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">实名认证</h1>
	</header>
	<article id="a1" class="active" data-scroll="true">
		<div class="pb20">
			<div class="font-type ml10 mt20">
				您已提交认证资料，名医助手正在审核：
			</div>
			<div class="text-center mt80">
				<img src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg" />
			</div>
			<div class="text-center mt80">
                                <a href="<?php echo $urlUpdateDoctorReal; ?>" class="btn-green pl50 pr50 pt10 pb10 font-type h50 text-center" data-target="link">修改</a>
			</div>
		</div>
	</article>
			
</section>
    
</div>

