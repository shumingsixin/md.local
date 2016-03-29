<?php
$this->setPageID('pZhiTongChe');
$this->setPageTitle('手术直通车');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$showExpTeamBtn = Yii::app()->request->getQuery("showBtn", 1);
if ($this->isUserAgentApp()) {
    $this->show_header = false;
    $this->show_footer = false;
    $showExpTeamBtn = 0;        
}
?>
<div id="<?php echo $this->getPageID(); ?>" class="home-page" data-role="page" data-title="<?php echo $this->getPageTitle(); ?>" <?php echo $this->createPageAttributes(); ?> data-nav-rel="#f-nav-home">    
    <div data-role="content" id="zhitongche">
        <div class="page row">
            <section class="page-section">
                <div class="section-body pt10 desc">
                    <div>名医主刀为有手术需求的患者提供的一项快速、便捷、高效、安全的服务。旨在帮助广大有手术需求的患者，第一时间预约全国知名专家，安排入院手术。</div>

                </div>
            </section>
            <section class="page-section">
                <div class="section-body">
                    <div class="zhitongche-title pt40">流 程</div>
                    <div class="step">
                        <div class="ui-grid-a">
                            <div class="ui-block-a"></div>
                            <div class="ui-block-b">
                                <div class="introduce-title step1">提交资料</div>
                                <div class="introduce-content bg-right">用户可以通过我们的微信公众平台、网站APP、邮箱以及人工客服的帮助，提交您的相关资料。</div>
                            </div>
                            <div class="ui-block-a">
                                <div class="introduce-title pull-right step2">术前会诊</div>
                                <div class="clearfix"></div>
                                <div class="introduce-content bg-left">确认专家的治疗意见和方案，并及时反馈给患者，根据具体病情安排专家面诊。</div>
                            </div>
                            <div class="ui-block-a"></div>
                            <div class="ui-block-b">
                                <div class="introduce-title step3">安排手术</div>
                                <div class="introduce-content bg-right">根据需求协助进行术前安排，检查完毕后48小时内直通手术室。</div>
                            </div>
                            <div class="ui-block-a">
                                <div class="introduce-title pull-right step4">术后回访</div>
                                <div class="clearfix"></div>
                                <div class="introduce-content bg-left">挂号随访、安排复诊。</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="page-section">
                <div class="section-body">
                    <div class="zhitongche-title pt40">优 势</div>
                    <div class="long">
                        <div class="ui-grid-a">
                            <div class="ui-block-a"></div>
                            <div class="ui-block-b">
                                <div class="introduce-title step1">权威专家</div>
                                <div class="introduce-content">国内权威顶尖专家一对一服务，不误诊，不拖延，确保看好病。</div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="ui-block-a mt-20">
                                <div class="introduce-title pull-right step2">高效便捷</div>
                                <div class="clearfix"></div>
                                <div class="introduce-content">省去床位等候时间，免去奔波代价，由名医主刀顾问高效沟通，检查完毕后48小时直通手术室。</div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="ui-block-a"></div>
                            <div class="ui-block-b mt-20">
                                <div class="introduce-title step3">贴心服务</div>
                                <div class="introduce-content">挂号、检查、咨询，一站式安排术后随访，节约时间，减少奔波劳苦。</div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="ui-block-a mt-20">
                                <div class="introduce-title pull-right step4">安全保障</div>
                                <div class="clearfix"></div>
                                <div class="introduce-content">顶级专家 权威三甲医院。</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="page-section">
                <div class="section-body qa">
                    <div class="zhitongche-title pt20">常见<br/>问题</div>
                    <div>
                        <div class="question"><span class="qtitle">Q1</span> 手术直通车的费用</div>
                        <div class="answer"><span>答: 手术产生的费用发生在医院，根据医院标准收取治疗费用（可用医保）。</span></div>
                    </div>
                    <div>
                        <div class="question"><span class="qtitle">Q2</span> 就诊通道是否能比别人更快入院？</div>
                        <div class="answer"><span>答: 通过手术直通车，可以大大缩短专家会诊和病床等待的时间。检查完毕后，48小时直通手术室。</span></div>
                    </div>
                    <div>
                        <div class="question"><span class="qtitle">Q3</span> 我想约的名医这里没有展示怎么办？</div>
                        <div class="answer"><span>答: 可以网上提交预约并注明专家姓名和所在医院科室，我们的工作人员将第一时间为您预约指定专家，6个小时内给您回复。</span></div>
                    </div>
                </div>
            </section>
            <?php if ($showExpTeamBtn == 1): ?>
                <section class="page-section">
                    <div class="section-body pt30 btn-eteam">
                        <a class="ui-btn" href="<?php echo $this->createUrl('expertteam/index'); ?>">找专家团队</a>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </div>
</div>
