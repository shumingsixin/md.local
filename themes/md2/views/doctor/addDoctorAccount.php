<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('发出的预约');
$urlAddDoctorAccount = $this->createUrl('doctor/addDoctorAccount');
$urlAddAlipay = $this->createUrl('doctor/addAlipay');
$urlAddBankCard = $this->createUrl('doctor/addBankCard');
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="addAccount_section" class="active" data-init="true">
	<header>
		<nav class="left">
			<a href="#" class="color-000" data-target="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">我的账户</h1>
	</header>
	<article id="a1" class="active" data-scroll="true">
		<div class="pb20">
			<div class="text-center mt70 font-type">
				请您选择添加您的账户信息：
			</div>
			<div class="text-center mt70">
                                <a href="<?php echo $urlAddAlipay; ?>" data-target="link">
					<img src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg" />
				</a>
			</div>
			<div class="text-center mt70">
                                <a href="<?php echo $urlAddBankCard; ?>" data-target="link">
					<img src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg" />
				</a>
			</div>
			
		</div>
	</article>
			
</section>
</div>
