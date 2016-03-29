<?php
/*
 * $model DoctorForm.
 */
$this->setPageID('pMyBooking');
$this->setPageTitle('发出的预约');
$urlBankCard = $this->createUrl('doctor/bankCard');
$urldeleteBankCard = $this->createUrl('doctor/deleteBankCard');
?>

<div class="aside-container" data-position="left">
	
</div>

<div id="section_container">

<section id="updateBankCard_section" class="active" data-init="true">
	<header>
		<nav class="left">
			<a href="#" class="color-000" data-target="back" data-icon="previous"></a>
		</nav>
		<h1 class="title color-000">添加银行卡信息</h1>
	</header>
	<article id="a1" class="active" data-scroll="true">
		<div class="pb30 ml10 mr10">
                        <form id="btn_sub" action="<?php echo $urlBankCard; ?>" method="post">
				<ul class="list">
					<li>
						<label class="font-type">持卡人：</label>
						<input class="mt10" id="cardName" type="text" placeholder="某某某" />
					</li>
					<li>
						<label class="font-type">卡号：</label>
						<input class="mt10" type="text" placeholder="输入框" />
					</li>
					<li>
						<label class="font-type">省份：</label>
						<input class="mt10" type="text" placeholder="上海" />
					</li>
					<li>
						<label class="font-type">城市：</label>
						<input class="mt10" type="text" placeholder="深圳" />
					</li>
					<li>
						<label class="font-type">开户行：</label>
						<input class="mt10" type="text" placeholder="工商银行" />
					</li>
					<li>
						<label class="font-type">支行名称：</label>
						<select class="mt10">
							<option value=""></option>
							<option value="">中国银行</option>
							<option value="">中国农业银行</option>
						</select>
					</li>
				</ul>
				
				<div class="grid">
					<div class="col-1 text-center mt50">
                                                <a href="<?php echo $urldeleteBankCard; ?>" class="btn-green pl30 pr30 pt10 pb10 font-type text-center" data-target="link">删除</a>
					</div>
					<div class="col-1 text-center mt40 btn-none">
                                                <input type="button" id="btn_t_error" class="btn-green pl30 pr30 pt10 pb10 font-type text-center" value="保存" />
					</div>
				</div>
			</form>
			
		</div>
	</article>
			
</section>
</div>
