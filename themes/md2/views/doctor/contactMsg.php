<?php
/*
 * $model DoctorForm.
 */

$urlMyzd = $this->createUrl('doctor/myzd');
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">
        <section id="contact_section" class="active" data-init="true">
	<header>
		<nav class="left">
			<a href="#" class="color-000" onclick="back();" data-target="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">联系我们</h1>
	</header>

	<article class="active" data-scroll="true">
		<div class="pb20 ml10 mr10 mt10">
                    <form action="<?php echo $urlMyzd; ?>" method="post">
			<div class="font-type">
				让每一位患者在名医主刀看好病是我们的宗旨。
			</div>
			<div class="font-type mt10">
				欢迎您把宝贵的意见和建议告诉我们：
			</div>
			<div class="mt20">
				<textarea style="height:300px;"></textarea>
			</div>
			<div class="text-center mt40">
                                <a href="#myzd_section" class="btn-green pl50 pr50 pt10 pb10 font-type" data-target="scetion">提交</a>
			</div>
                    </form>
		</div>
	</article>
			
</section>
     
</div>
<script>
    function back(){
        self.location=document.referrer;
    }
</script>