<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('发出的预约');
$urlMain = $this->createUrl('doctor/main');
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="paySuccess_section" class="active" data-init="true">
	<header>
		<h1 class="title color-000">支付成功</h1>
		<nav class="right">
                    <a href="<?php echo $urlMain; ?>" class="color-000" data-target="link" data-icon="close"></a>
		</nav>
	</header>

	<article class="active" data-scroll="true">
		<div class="pb20">
			<div class="grid ml30 mr30 mt40 font-type">
				<div class="col-0 w10 color-green" data-icon="checkmark">
				</div>
				<div class="col-0 w90">
					订单201510140234支付成功！
				</div>
			</div>
			<div class="grid vertical mt40 ml10 mr10 b-success">
				<div class="col-0 grid ml10 mr10 mt20 mb20">
					<div class="col-0 color-green w30">
						患者姓名：
					</div>
					<div class="col-0 w70">
						某某某
					</div>
				</div>
				<div class="col-0 grid ml10 mr10 mb20">
					<div class="col-0 color-green w30">
						订单详情：
					</div>
					<div class="col-0 line-h w70">
						如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
						如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
						如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
					</div>
				</div>
				<div class="col-0 grid ml10 mr10 mb20">
					<div class="col-0 color-green w30">
						支付金额：
					</div>
					<div class="col-0 w70">
						1000元
					</div>
				</div>
			</div>
			
		</div>
	</article>
			
</section>
</div>
