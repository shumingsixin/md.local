<?php
$showHeader = Yii::app()->request->getQuery('header', 1);
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$this->show_footer = false;
$this->show_header = false;
?>
<style>
    #millionWelfare_section{top:0px;}
</style>
<div id="section_container" <?php echo $this->createPageAttributes(); ?> >
    <section id="millionWelfare_section" class="active" data-init="true">
        <article id="millionWelfare_article" class="active" data-scroll="true">
            <div class="font-s14">
                <div class="pl15 pr15 mt26">
                    <div>
                        <img src="<?php echo $urlResImage; ?>/event/millionWelfare/gongyi.png" class="w100">
                    </div>
                    <div class=" mt16 font-s21 color-black5">名医主刀--百万公益金</div>
                    <div class="mt21 font-s12">2015-12-09<span class="color-blue ml7">来源:名医主刀</span></div>
                </div>
                <div class="mt16 bb-gray3"></div>
                <div class="pl15 pr15">
                    <div class="mt26 font-s16 color-black">
                        "名医主义"--名医主刀旗下医疗公益项目
                    </div>
                    <div class="color-black6">
                        <div class="mt16">
                            通过整合全国优质医疗资源
                        </div>
                        <div class="mt10">
                            借助资本力量和品牌影响力
                        </div>
                        <div class="mt10">
                            为有手术需求的患者提供公益支持和帮助
                        </div>
                        <div class="mt10">
                            如果你还在为找不到专家而发愁
                        </div>
                        <div class="mt10">
                            如果你还在为等不到床位而苦恼
                        </div>
                        <div class="mt10">
                            如果你还在为手术费用而烦忧
                        </div>
                        <div class="mt26 grid">
                            <div class="col-1"></div>
                            <div class="col-0 yellowTitle">
                                "名医主义"将为手术患者提供
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="pl20 pr20">
                            <img src="<?php echo $urlResImage; ?>/event/millionWelfare/lineFour.png" class="w100">
                        </div>
                        <div class="grid">
                            <div class="col-1 w24">
                                <span class="redTable">专家资源</span>
                            </div>
                            <div class="col-1 w24 text-center">
                                <span class="redTable">床位资源</span>
                            </div>
                            <div class="col-1 w24 text-center">
                                <span class="redTable">保险服务</span>
                            </div>
                            <div class="col-1 w28 text-right">
                                <span class="redTable">100万公益金</span>
                            </div>
                        </div>
                        <div class="mt16 bb-gray3"></div>
                        <div class="color-green4 mt16">
                            <div class="text-center">
                                百万基金将用于
                            </div>
                            <div class="text-center">
                                为患者提供手术治疗的专家费用
                            </div>
                            <div class="text-center">
                                每位患者可获得“一万”元专家手术费的资助
                            </div>
                            <div class="text-center">
                                若患者情况特殊还可向百万基金申请额外增资
                            </div>
                            <div class="stepImg mt30">
                                <div class="grid pt10">
                                    <div class="col-1"></div>
                                    <div class="col-0 color-white">如何申请百万公益金?</div>
                                    <div class="col-1"></div>
                                </div>
                                <div class="grid pt64 color-white">
                                    <div class="col-1 w50 plStep">
                                        STEP1
                                    </div>
                                    <div class="col-1 w50 text-right prStep">
                                        STEP2
                                    </div>
                                </div>
                            </div>
                            <div class="mb20 grid font-s12">
                                <div class="col-1 w40">
                                    <div>1.网站</div>
                                    <div>2.APP</div>
                                    <div>3.微信公众号(在搜索栏中输入"名医主刀"即可)</div>
                                    <div>4.服务热线400-119-7900</div>
                                </div>
                                <div class="col-0 w20"></div>
                                <div class="col-1 w40">
                                    <div>"名医主义"评估委员会将</div>
                                    <div>对您提交的病例和申请进行审核</div>
                                    <div>审核通过后客服会立即联系您</div>
                                    <div>为您尽快安排手术</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </section>
</div>