<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('发出的预约');
$urlPaySuccess = $this->createUrl('patientbooking/paySuccess');
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="pay_section" class="active" data-init="true">
	<header>
		<nav class="left">
			<a href="#" class="color-000" data-target="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">选择支付方式</h1>
	</header>

	<article class="active" data-scroll="true">
		<div class="pb20">
                    <form action="<?php echo $urlPaySuccess; ?>" method="post">
			<div class="grid vertical mt40">
				<div class="col-1 grid mb40">
					<div class="col-1 text-center w30">
						<a href="#" class="button w90 btn-fff">招商银行</a>
					</div>
					<div class="col-1 text-center w30">
						<a href="#" class="button w90 btn-fff">招商银行</a>
					</div>
					<div class="col-1 text-center w30">
						<a href="#" class="button w90 btn-fff">微信</a>
					</div>
				</div>
				<div class="col-1 grid mb40">
					<div class="col-1 text-center w30">
						<a href="#" class="button w90 btn-fff">招商银行</a>
					</div>
					<div class="col-1 text-center w30">
						<a href="#" class="button w90 btn-fff">招商银行</a>
					</div>
					<div class="col-1 text-center w30">
						<a href="#" class="button w90 btn-fff">支付宝</a>
					</div>
				</div>
				<div class="col-1 grid mb40">
					<div class="col-1 text-center w30">
						<a href="#" class="button w90 btn-fff">招商银行</a>
					</div>
					<div class="col-1 text-center w30">
						<a href="#" class="button w90 btn-fff">招商银行</a>
					</div>
					<div class="col-1 text-center w30">
						<a href="#" class="button w90 btn-fff">支付宝</a>
					</div>
				</div>
				<div class="col-1 grid mb40">
					<div class="col-1 text-center w30">
						<a href="#" class="button w90 btn-fff">支付宝</a>
					</div>
					<div class="col-1 text-center w30">
						<a href="#" class="button w90 btn-fff">微信</a>
					</div>
					<div class="col-1 text-center w30">
					</div>
				</div>
			</div>
			<div class="text-center mt40 btn-none">
                            <input type="submit" class="btn-green pl50 pr50 pt10 pb10 font-type h50 text-center" value="支付" />
			</div>
                    </form>
		</div>
	</article>
			
</section>
</div>
