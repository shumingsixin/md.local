<?php ?>
<?php
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$this->show_footer = false;
$this->show_header = false;
?>
<style>
    section.active{top:0px;}
    #myzd_article .resourcesIcon{
        background: url('<?php echo $urlResImage; ?>event/resources.png') no-repeat;
        background-size: 21px 21px;
        padding-left: 25px;
        background-position-y: 1px;
    }
    #myzd_article .serviceIcon{
        background: url('<?php echo $urlResImage; ?>event/service.png') no-repeat;
        background-size: 21px 21px;
        padding-left: 25px;
        background-position-y: 1px;
    }
    #myzd_article .circularIcon{
        background: url('<?php echo $urlResImage; ?>event/circular.png') no-repeat;
        background-size: 21px 21px;
        padding-left: 25px;
        background-position-y: 1px;
    }
</style>
<div id="section_container" <?php echo $this->createPageAttributes(); ?> >
    <section id="" class="active" data-init="true">
        <article id="myzd_article" class="active" data-scroll="true">
            <div class="text-justify">
                <div class="pl10 pr10">
                    <div class="mt20 mb10">
                        <span class="font-w800">名医主刀</span>
                        <span>国内最大的移动医疗手术预约平台，旨在为有手术需求的患者提供专业、高效、安全的手术医疗预约服务。帮助广大有手术需求的患者，在第一时间预约全国知名专家，安排入院手术。</span>
                    </div>
                    <div class="bt-gray2 pt10 pb10">
                        <span class="font-w800">总部</span>
                        <span>坐落于上海，现设北京、杭州、天津、广州、南京、成都等分部，业务范围覆盖全国。平台汇聚了国内外顶级名医资源和闲置床位资源，并利用互联网技术实现医患精准匹配，医疗资源优化配置，帮助患者解决“好看病，看好病”的切实需求。</span>
                    </div>
                </div>
                <div class="h10p bg-gray2"></div>
                <div class="pl10 pr10">
                    <div class="mt20 color-green resourcesIcon">
                        汇聚国内外顶级名医资源
                    </div>
                    <div>
                        名医主刀不仅签约了两万余名三甲医院副主任级别及以上的医生，还与工程院院士级别的顶尖专家团队有合作。签约医生涵盖不同的科室，能让更多患者通过这一平台精准对接到擅长相关疾病的专家，从而节省了在不同医院门诊排队的时间，并减少患者乱投医而产生的额外费用。
                    </div>
                    <div class="mt20">
                        <div class="color-green serviceIcon">
                            细致、专业的医疗服务
                        </div>
                        <div>
                            患者只需要通过名医主刀的服务平台上传自己的病历资料，名医主刀将邀请三甲医院的专家，对患者的病历进行线下会诊，给出具体的治疗方案。患者可以根据专家给出的治疗方案，在名医助手的安排下，进行后期的手术治疗。
                        </div>
                    </div>
                    <div class="mt20 mb50">
                        <div class="color-green circularIcon">
                            做手术就找名医主刀
                        </div>
                        <div>
                            通过名医主刀，患者不仅可以获得专家细致、专业的诊疗服务，还可以缩短治疗的等候时间。在三甲医院等待床位有时需要长达三个月，但在名医主刀，经过对医疗资源的优化配置，可以缩短为一个星期，能极大程度的避免因为手术延迟而耽误病情。
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </section>
</div>