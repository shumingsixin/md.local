<?php
/*
 * $model UserDoctorProfileForm.
 */
$this->setPageID('pUserDoctorProfile');
$this->setPageTitle('个人信息');
$urlDoctorRealInfo = $this->createUrl('doctor/doctorRealInfo');
?>
<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="realNameOne_section" class="active" data-init="true">
	<header>
		<nav class="left">
			<a href="#" class="color-000" data-target="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">实名认证</h1>
	</header>
	<article id="a1" class="active" data-scroll="true">
		<div class="pb20">
                    <form action="<?php echo $urlDoctorRealInfo; ?>" method="post">
			<div class="font-type ml10 mr10 mt20">
				请您完成实名认证，认证后开通名医主刀账户。
			</div>
			
			<div class="font-type ml10 mr10 mt10">
				上传医生执业证书或者手持工牌照：
			</div>
			
			<div class="text-center mt20">
				<img src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg" />
			</div>
			
			<div class="grid ml10 mr10 mt20">
				<div class="col-0 w30">
					<img class="w-100" src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg" />
				</div>
				<div class="col-0 w70">
					请确保图片内容清晰可见
				</div>
			</div>
			
			<div class="grid vertical mt50 ml10 mr10">
				<div class="col-0 font-type mb10">
					示例：
				</div>
				<div class="col-0 text-center">
					<img src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg" />
				</div>
			</div>
			
			<div class="text-center mt30">
                                <input type="submit" class="btn-green pl50 pr50 pt10 pb10 font-type h50 text-center" value="提交" />
			</div>
                    </form>
		</div>
	</article>
			
</section>
    
</div>

