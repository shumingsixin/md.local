<?php
/*
 * $model UserDoctorProfileForm.
 */
$this->setPageID('pUserDoctorProfile');
$this->setPageTitle('个人信息');
$urlDoctorInfo = $this->createUrl('doctor/doctorInfo');
?>
<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="informationTwo_section" class="active" data-init="true">
	<header>
		<nav class="left">
			<a href="#" class="color-000" data-target="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">个人信息</h1>
	</header>
	<article id="a1" class="active" data-scroll="true">
		<div class="pb20">
                    <form id="btn_sub" action="<?php echo $urlDoctorInfo; ?>" method="post">
			<ul class="list">
				<li>
					<label class="font-type">姓名</label>
					<input class="mt10" id="name" type="text" placeholder="输入框" />
				</li>
				<li>
					<label class="font-type">省份</label>
					<select class="mt10">
						<option value=""></option>
						<option value="0">北京</option>
						<option value="1">上海</option>
					</select>
				</li>
				<li>
					<label class="font-type">医院</label>
					<input class="mt10" type="text" placeholder="输入框" />
				</li>
				<li>
					<label class="font-type">科室</label>
					<input class="mt10" type="text" placeholder="输入框" />
				</li>
				<li>
					<label class="font-type">医学职称</label>
					<select class="mt10">
						<option value=""></option>
						<option value="0">北京</option>
						<option value="1">上海</option>
					</select>
				</li>
				<li>
					<label class="font-type">学术职称</label>
					<select class="mt10">
						<option value=""></option>
						<option value="0">北京</option>
						<option value="1">上海</option>
					</select>
				</li>
			</ul>
			<div class="text-center mt60 btn-none">
                                <input type="button" id="btn_t_error" class="btn-green pl50 pr50 pt10 pb10 font-type h50 text-center" value="保存" />
			</div>
                        </form>
		</div>
	</article>
			
</section>
    
</div>

