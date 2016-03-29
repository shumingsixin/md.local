<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('发出的预约');
$urlCreatePatient = $this->createUrl('patient/create', array('addBackBtn' => 1));
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="yyTwo_section" class="active" data-init="true">
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
				<div class="grid font-type ml30 mr30 mt20 mb20">
					<div data-icon="star-2" class="col-0 w10 text-center color-yellow"></div>
					<div class="col-0 w90 color-green">
						感谢您完成了一例手术！
					</div>
				</div>
				<div class="ml10 mr10">
					如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
					如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
					如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
				</div>
				
				<div class="bg-img w100 h30 text-center mt20">
						<span class="label bg-fff color-000 b-gray font-20">就诊意向</span>
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
					<span class="label bg-fff color-000 b-gray font-20">患者资料</span>
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
