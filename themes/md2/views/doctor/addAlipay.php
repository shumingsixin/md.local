<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('发出的预约');
$urlAddDoctorAccount = $this->createUrl('doctor/addDoctorAccount');
$urlAddAlipay = $this->createUrl('doctor/addAlipay');
$urlAlipay = $this->createUrl('doctor/alipay');
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="addAlipay_section" class="active" data-init="true">
	<header>
		<nav class="left">
			<a href="#" class="color-000" data-target="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">添加支付宝账户</h1>
	</header>
	<article id="a1" class="active" data-scroll="true">
		<div class="pb20">
                    <form action="<?php echo $urlAlipay; ?>" method="post">
				<div class="mt70 font-type ml10">
					请填写您的支付宝账户：
				</div>
				<div class="text-center mt50 ml10 mr10">
					<input id="input-img" type="text" class="h60" placeholder="12345@163.com" />
				</div>
				<div class="text-center mt80">
                                    <input type="submit" class="btn-green pl50 pr50 pt10 pb10 font-type h50 text-center" value="确认" />
				</div>
			</form>
			
		</div>
	</article>
			
</section>
</div>
