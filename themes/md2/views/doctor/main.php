<?php
$urlCreate = $this->createUrl('patient/create');
$urlView = $this->createUrl('doctor/mainSection');
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">
    <section id="main_section" class="active" data-init="true">
	<header class="bg-green">
		<h1 class="title color-fff">手术直通车</h1>
	</header>
	<article class="active" data-scroll="true">
		<div class="ml30 mr30">
			<a href="<?php echo $urlCreate; ?>" data-target="link" class="color-000 font-type">
				<div class=" a-type mt50 h150 b-r p-a text-center middle grid">
					创建患者
				</div>
			</a>
			<a href="<?php echo $urlView; ?>" data-target="link" class="color-000 font-type">
				<div class=" a-type mt50 h150 b-r p-a text-center middle grid">
					个人中心
				</div>
			</a>
		</div>
	</article>
</section>
</div>