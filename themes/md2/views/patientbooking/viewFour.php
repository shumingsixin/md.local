<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('发出的预约');
$urlPay = $this->createUrl('patientbooking/pay');
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="yyFour_section" class="active" data-init="true">
	<header>
		<nav class="left">
			<a href="#" class="color-000" data-target="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">预约详情</h1>
		<nav class="right">
			<a href="#" data-target="section" data-icon="share"></a>
		</nav>
	</header>

	<article class="active" data-scroll="true">
		<div class="pb20">
			<form>
				<div class="color-green font-type ml10 mr10 mt20 mb20">
					名医主刀反馈：
				</div>
				<div class="ml10 mr10">
					如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
					如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
					如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
				</div>
				
				<div class="grid ml10 mr10 b-gray mt30 mb30 font-type">
					<div class="col-0 text-center w60 pt20 pb20">
						手术预约金：1000元
					</div>
					<div class="col-0 w40 text-center">
                                            <a href="<?php echo $urlPay; ?>" class="color-fff" data-target="link">
							<div class="pt20 pb20 bg-green">
								确认并支付
							</div>
						</a>
					</div>
				</div>
				
				<div class="bg-img w100 h30 text-center mt20">
					<span class="label bg-green color-fff font-20">就诊意向</span>
				</div>
				<div class="ml10 mr10">
					<div class="mb10">
					邀请专家过来
					</div>
					<div class="mb10">
						2015年10月1日-2015年10月15日
					</div>
					<div class="line-h">
						如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
						如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
						如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
					</div>
				</div>
				
				<div class="bg-img w100 h30 text-center mt20">
					<span class="label bg-green color-fff font-20">患者资料</span>
				</div>
				<div class="ml10 mr10">
					<div class="mt10 mb10">
						李小白 | 男 | 19岁 | 上海
					</div>
					<div class="mb20">
						如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
						如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
						如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
					</div>
					<div class="font-20 mb20">
						影像资料：
					</div>
					<div class="grid mb20">
						<div class="col-0 w33 text-center">
							<img class="w-100 h100" src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg" />
						</div>
						<div class="col-0 w33 text-center">
							<img class="w-100 h100" src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg" />
						</div>
						<div class="col-0 w33 text-center">
							<img class="w-100 h100" src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg" />
						</div>
					</div>
				</div>
			</form>
		</div>
	</article>
			
</section>
</div>
