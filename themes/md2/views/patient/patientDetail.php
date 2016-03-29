<?php
/*
 * $model PatientMRForm.
 */
$this->setPageID('pCreatePatientMR');
$this->setPageTitle('修改患者病历');
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="patinalDetail_section" class="active" data-init="true">
	<header>
		<nav class="left">
			<a href="#" class="color-000" data-rel="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">患者详情</h1>
	</header>
	<article id="a1" class="active" data-scroll="true">
		<div class="pb20 mt20">
			<div class="ml10 mr10 mt20">
				<div class="font-20 mb20">
					病情描述：
				</div>
				<div class="mb20">
					李小白 | 男 | 19岁 | 上海
				</div>
				<div class="mb30 line-h">
					如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
					如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
					如果你没有办法的话，那就去海的那边，那里会有一处无忧无虑的小村。
				</div>
			</div>
			<div class="bg-img h30"></div>
			<div class="ml10 mr10 mt10">
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
				<div class="mt50 text-center color-gray">
					(后期可以在"我的患者"里修改、选择就诊意向。)
				</div>
			</div>
		</div>
	</article>
			
</section>
    
</div>
