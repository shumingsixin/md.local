<?php
/*
 * $model PatientMRForm.
 */
$this->setPageID('pCreatePatientMR');
$this->setPageTitle('修改患者病历');
$urlSaveMRFile = $this->createUrl('patient/saveMRFile');
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="uploadCase_section" class="active" data-init="true">
	<header>
		<nav class="left">
			<a href="#" class="color-000" data-target="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">上传病例</h1>
		<nav class="right">
			<a href="#intention_section" class="color-000" data-target="section">跳过</a>
		</nav>
	</header>

	<article class="active" data-scroll="true">
		<div class="ml10 mr10 mt20 mb20">
                        <form action="<?php echo $urlSaveMRFile; ?>" method="post">
				<div class="font-type mb20">
					请您上传患者的相关病历资料：
				</div>
				<div class="mb20">
					图片需清晰可见(最多9张)
				</div>
				<div class="grid vertical mb20">
					<div class="grid col-1 mb20">
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
					<div class="col-1 grid">
						<div class="col-0 w33 text-center">
							<a href="#">
								<img class="w-100 h100" src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg" />
							</a>
						</div>
					</div>
				</div>
				<div class="b-d pt10 pl10 pr10 pb10">
					<div class="mb20">
						示例(如CT、磁共振、病理报告等)
					</div>
					<div class="grid">
						<div class="col-0 w50 text-center">
                                                        <img class="w-100 h100" src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg" />
						</div>
						<div class="col-0 w50 text-center">
							<img class="w-100 h100" src="<?php echo Yii::app()->theme->baseUrl;?>/images/city-nanjing.jpg" />
						</div>
					</div>
				</div>
				<div class="text-center mt40 btn-none">
                                        <input type="submit" class="btn-green pl50 pr50 pt10 pb10 font-type h50 text-center" value="下一步" />
				</div>
			</form>
			
		</div>
		
	</article>
	
</section>
    
</div>
