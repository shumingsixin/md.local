<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('发出的预约');
$urlAlipay = $this->createUrl('doctor/alipay');
$urlDeleteAlipay = $this->createUrl('doctor/deleteAlipay');
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="updateAlipay_section" class="active" data-init="true">
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
				<div class="grid">
					<div class="col-1 text-center mt50">
                                                <a href="<?php echo $urlAlipay; ?>" class="btn-green pl30 pr30 pt10 pb10 font-type text-center" data-target="link">删除</a>
					</div>
					<div class="col-1 text-center mt40 btn-none">
                                                <input type="submit" class="btn-green pl30 pr30 pt10 pb10 font-type text-center" value="保存" />
					</div>
				</div>
			</form>
			
		</div>
	</article>
			
</section>
</div>
