<?php
/*
 * $model PatientMRForm.
 */
$this->setPageID('pCreatePatientMR');
$this->setPageTitle('修改患者病历');
$urlSuccess = $this->createUrl('patient/success');
$urlPatientDetail = $this->createUrl('patient/patientDetail');
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="intention_section" class="active" data-init="true">
	<header>
		<nav class="left">
			<a href="#" class="color-000" data-target="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">就诊意向</h1>
	</header>

	<article class="active" data-scroll="true">
		<div class="ml10 mr10 mt20 mb20">
                        <form action="<?php echo $urlSuccess; ?>" method="post">
				<div class="font-type mb30">
					就诊方式：
				</div>
				<div class="grid mb30">
					<div class="col-0 w50">
						<div data-checkbox="checked">
							邀请专家过来
						</div>
					</div>
					<div class="col-0 w50">
						<div data-checkbox="unchecked">
							希望转诊治疗
						</div>
					</div>
				</div>
				<div class="font-type mb10">
					意向就诊时间：
				</div>
				<div>
					<label>最早：</label>
					<input class="mt10" type="date">
				</div>
				<div class="mb30">
					<label>最晚：</label>
					<input class="mt10" type="date">
				</div>
				<div>
					<label class="font-type">补充说明：</label>
					<textarea class="mt10" style="height:90px;" placeholder="请简要表述您的需求。例如：
北京协和医院--甲状腺外科--刘跃武来我院。
如无明确需求，请填写无。
名医主刀会为您需找该领域三甲医院副主任医师级别以上的医师前来就诊。
					"></textarea>
				</div>
				<div class="grid">
					<div class="col-0 text-center mt40 w60">
                                                <a href="<?php echo $urlPatientDetail; ?>" data-target="link">
							<div class="btn-green pt10 pb10 font-type h50 text-center w90">暂没想好，先保存</div>
						</a>
					</div>
					<div class="col-0 text-center mt40 w40 btn-none">
                                                <input type="submit" class="btn-green pt10 pb10 font-type h50 text-center w90" value="提交预约" />
					</div>
				</div>
			</form>
			
		</div>
		
	</article>
	
</section>
    
</div>
