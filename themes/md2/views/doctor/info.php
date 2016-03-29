<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('发出的预约');
$urlDoctorInfo = $this->createUrl('doctor/doctorInfo');
$urlDoctorRealInfo = $this->createUrl('doctor/doctorRealInfo');
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="information_section" class="active" data-init="true">
	<header>
		<nav class="left">
			<a href="#" class="color-000" data-target="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">个人信息</h1>
	</header>
	<article id="a1" class="active" data-scroll="true">
		<div class="pb20">
			<ul class="list">
				<li>
                                        <a href="<?php echo $urlDoctorInfo; ?>" data-target="link">
						<div class="grid font-type">
							<div class="col-0 w30 text-right color-green" data-icon="list">
							</div>
							<div class="col-0 w40 text-center">
								基本信息
							</div>
							<div class="col-0 w30 text-center" data-icon="next">
							</div>
						</div>
					</a>
				</li>
				<li>
                                        <a href="<?php echo $urlDoctorRealInfo; ?>" data-target="link">
						<div class="grid font-type">
							<div class="col-0 w30 text-right color-green" data-icon="spinner">
							</div>
							<div class="col-0 w40 text-center">
								实名认证
							</div>
							<div class="col-0 w30 text-center" data-icon="next">
							</div>
						</div>
					</a>
				</li>
			</ul>
		</div>
	</article>
			
</section>
</div>
