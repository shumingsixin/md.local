<?php ?>
<?php
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$urlKaTeEr = $this->createUrl('home/page', array('view' => 'kataer'));
$urlLuJinsong = $this->createUrl('home/page', array('view' => 'lujinsong'));
$urlRenShancheng = $this->createUrl('home/page', array('view' => 'renshancheng'));
$urlMillionWelfare = $this->createUrl('home/page', array('view' => 'millionWelfare'));
$urlForbes = $this->createUrl('home/page', array('view' => 'forbes'));
$urlDiDoctor = $this->createUrl('home/page', array('view' => 'diDoctor'));
$this->show_footer = false;
$this->show_header = false;
?>
<style>
    #findView_section{top:0px;}
    #findView_article{background-color: #EAEFF1;}
</style>
<div id="section_container" <?php echo $this->createPageAttributes(); ?> >
    <section id="findView_section" class="active" data-init="true">
        <article id="findView_article" class="active" data-scroll="true">
            <div>
                <div>
                    <a href="<?php echo $urlKaTeEr; ?>">
                        <img src="<?php echo $urlResImage; ?>event/kataer/kataerwangzi.jpg" class="w100">
                    </a>
                </div>
                <div class="pad10 text-center bg-white">
                    卡塔尔王子中国寻医记
                </div>
                <div class="mt10">
                    <a href="<?php echo $urlLuJinsong; ?>">
                        <img src="<?php echo $urlResImage; ?>event/lujinsong/lujinsong.jpg" class="w100">
                    </a>
                </div>
                <div class="pad10 text-center bg-white">
                    医生访谈陆劲松
                </div>
                <div class="mt10">
                    <a href="<?php echo $urlRenShancheng; ?>">
                        <img src="<?php echo $urlResImage; ?>event/renshancheng/renshancheng.jpg" class="w100">
                    </a>
                </div>
                <div class="pad10 text-center bg-white">
                    医生访谈任善成
                </div>
                <div class="mt10">
                    <a href="<?php echo $urlMillionWelfare; ?>">
                        <img src="<?php echo $urlResImage; ?>event/millionWelfare/millionWelfare.jpg" class="w100">
                    </a>
                </div>
                <div class="pad10 text-center bg-white">
                    百万公益冬日暖阳
                </div>
                <div class="mt10">
                    <a href="<?php echo $urlForbes; ?>">
                        <img src="<?php echo $urlResImage; ?>event/forbes/forbes.png" class="w100">
                    </a>
                </div>
                <div class="pad10 text-center bg-white">
                    名医主刀CEO入选亚洲年轻领袖榜单
                </div>
                <div class="mt10">
                    <a href="<?php echo $urlDiDoctor; ?>">
                        <img src="<?php echo $urlResImage; ?>event/diDoctor/diDoctor.png" class="w100">
                    </a>
                </div>
                <div class="pad10 text-center bg-white">
                    一键呼叫专家医生，随车上门问诊
                </div>
            </div>
        </article>
    </section>
</div>