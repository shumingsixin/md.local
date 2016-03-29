<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('发出的预约');
$urlAddDoctorAccount = $this->createUrl('doctor/addDoctorAccount');
$urlUpdateBankCard = $this->createUrl('doctor/updateBankCard');
$urlUpdateAlipay = $this->createUrl('doctor/updateAlipay');
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="account_section" class="active" data-init="true">
	<header>
		<nav class="left">
			<a href="#" class="color-000" data-target="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">我的账户</h1>
		<nav class="right">
                    <a href="<?php echo $urlAddDoctorAccount; ?>" class="color-000" data-target="link">
				添加账户
			</a>
		</nav>
	</header>
	<article id="a1" class="active" data-scroll="true">
		<div class="pb20">
			<div class="b-gray-b">
				<div class="mt20 ml10 mb20 font-type">
				您关联的账户有：
				</div>
			</div>
			
			<div class="grid b-leftGreen ml10 mt20 mb20 mr10">
				<div class="col-0 w20">
					<img src="#" />
				</div>
				<div class="col-0 w80 grid vertical">
					<div class="col-0 grid mt20 mb20">
						<div class="col-0 font-type w60">
							浦发银行
						</div>
						<div class="col-0 w40 text-right pr10">
                                                        <a href="<?php echo $urlUpdateBankCard; ?>" class="color-red" data-target="link">
								修改
							</a>
						</div>
					</div>
					<div class="col-1 mb20">
						尾号9090 某某某
					</div>
				</div>
			</div>
			
			<div class="grid b-leftGreen ml10 mt20 mb20 mr10">
				<div class="col-0 w20">
					<img src="#" />
				</div>
				<div class="col-0 w80 grid vertical">
					<div class="col-0 grid mt20 mb20">
						<div class="col-0 font-type w60">
							支付宝
						</div>
						<div class="col-0 w40 text-right pr10">
                                                        <a href="<?php echo $urlUpdateAlipay; ?>" class="color-red" data-target="link">
								修改
							</a>
						</div>
					</div>
					<div class="col-1 mb20">
						账号：123@163.com
					</div>
				</div>
			</div>
		</div>
	</article>
			
</section>
</div>
