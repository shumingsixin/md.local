<?php
/*
 * $model DoctorForm.
 */

?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">
        <section id="successOne_section" class="active" data-init="true">
	<header>
		<nav class="left">
                    <a href="#" class="color-000" onclick="back();" data-target="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">提交成功</h1>
	</header>

	<article class="active" data-scroll="true">
		<div class="ml10 mr10 mt150 mb20">
			<div class="font-type">
				名医助手会尽快确认，并在第一时间联系您，请保持手机通畅！
			</div>
			<div class="font-type mt30 text-center">
				谢谢！
			</div>
		</div>
		
	</article>
	
</section>
     
</div>
<script>
    function back(){
        self.location=document.referrer;
    }
</script>