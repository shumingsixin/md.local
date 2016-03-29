<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('发出的预约');
$urlViewTwo = $this->createUrl('patientbooking/viewTwo');
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="yyOne_section" class="active" data-init="true">
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
                    <form action="<?php echo $urlViewTwo; ?>" method="post">
				<div class="grid font-type ml10 mr10 mt20 mb20">
					<div data-icon="checkmark" class="col-0 w10 text-center color-green"></div>
					<div class="col-0 w90 color-green">
						已支付手术预约金：
					</div>
				</div>
				<div class="ml10 mr10">
					如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
					如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
					如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
				</div>
				
				<div class="text-center mt40 mb40">
					<a href="#" class="btn-green pt10 pb10 pl10 pr10 font-type h50 text-center" data-target="section">上传出院小结</a>
				</div>
				
				<div class="grid ml10 mr10">
					<div class="col-0 w70">
						<img src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg">
					</div>
					<div class="col-0 w30 text-center mt50 btn-none">
                                            <input type="submit" class="btn-green pl10 pr10 pt10 pb10 font-type h50 text-center" value="提交" />
					</div>
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
							<a href="#" class="btn_alert">
                                                                <img class="w-100 h100" src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg" />
                                                        </a>
						</div>
						<div class="col-0 w33 text-center">
							<a href="#" class="btn_alert">
                                                                <img class="w-100 h100" src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg" />
                                                        </a>
						</div>
						<div class="col-0 w33 text-center">
							<a href="#" class="btn_alert">
                                                                <img class="w-100 h100" src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg" />
                                                        </a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</article>
			
</section>
</div>
