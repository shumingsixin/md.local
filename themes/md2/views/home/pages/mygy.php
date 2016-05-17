<?php ?>
<?php
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$this->show_footer = false;
$this->show_header = false;
?>
<style>
    .mt-20{margin-top: -10px;}

    body{letter-spacing: 0px;}
    header{line-height:inherit;}
    

    section.active{top:0px;}
    #joinMygy_header .joinBtn{border: 1px solid #06C1AE;padding: 3px 40px;border-radius: 5px;}
    #joinMygy_article .grayTriangle{background: url('<?php echo $urlResImage; ?>grayTriangle.png') no-repeat;background-size: 12px 22px;padding-right: 20px;background-position-x: 100%;}
    #joinMygy_article .introDiv{position: relative;top: -5px;}
    #joinMygy_article .intro{box-shadow: 2px 2px 15px rgba(0,0,0,0.3);padding: 0px 10px;background-color: #06C1AE;color: #fff;font-size: 16px;}
    #joinMygy_article .introBorder{box-shadow: 2px 2px 15px rgba(0,0,0,0.3);}
    #joinMygy_article .greenLine{width: 5px;height: 18px;background-color: #06C1AE;border-radius: 3px;}
    #joinMygy_article .imgDiv{width: 60px;height: 60px;border-radius: 50%;border: 1px solid #cccccc;overflow: hidden}
    #joinMygy_article .mydsIcon{background: url('<?php echo $urlResImage; ?>mygy/myds.png') no-repeat;background-position-x:100%;background-size:65px;}
</style>
<header id="joinMygy_header" class="hide">
    <div class="grid w100">
        <div class="col-1"></div>
        <div class="col-0 color-green pt5 pb5">
            <div class="joinBtn">立即加入</div>
        </div>
        <div class="col-1"></div>
    </div>
</header>
<div id="section_container" <?php echo $this->createPageAttributes(); ?> >
    <section id="" class="active" data-init="true">
        <article id="joinMygy_article" class="active" data-scroll="true">
            <div class="text-justify">
                <div class="ml10 mr10 mt30">
                    <div class="introBorder">
                        <div class="grid introDiv">
                            <div class="col-0 w20p"></div>
                            <div class="col-0 intro">
                                简介
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="p10">
                            名医公益联盟是名医主刀倡导发起，并联合公益组织、医生共建的一种可持续公益模式，旨在让更多患者有机会接受更好的治疗。作为国内最大的移动医疗手术平台，名医主刀每天都能接触到大量需要手术的患者。在沟通中，我们注意到其中不少患者家境贫寒，难以全部承担平台服务费用。名医主刀虽然是新生企业，但“仁爱”一直是我们的初心，我们希望通过名医公益联盟，汇聚社会的爱心力量，让更多贫困的患者也能找到名医进行手术。名医公益联盟中，既有饱含仁爱之心的名医，也有有着丰富救助经验的公益组织。通过对资源的整合和优化配置，让患者好看病、看好病。做手术找名医主刀，做手术遇到困难找名医公益联盟。
                        </div>
                    </div>
                    <div class="ml10 mr10 mt20 mb20 text-indent-2">
                        名医公益联盟里有着来自国内三甲医院的主任、副主任医师，他/她们秉承“解患者之难”的初心，哪里有紧急的病情，哪里需要名医公益联盟的救助，他/她们就在哪里，为患者提供公益手术服务。
                    </div>
                </div>
                <div class="h10p bg-gray"></div>
                <div class="ml10 mr10 mb20 mt10">
                    <div class="grid">
                        <div class="col-0 pt2"><div class="greenLine"></div></div>
                        <div class="col-1 pl10">名医君</div>
                        <div class="col-0 grayTriangle">全部</div>
                    </div>
                    <div class="grid text-center mt10">
                        <div class="col-1 w33 b-gray1 mr6 pb10">
                            <div class="grid mt10">
                                <div class="col-1"></div>
                                <div class="col-0 imgDiv">
                                    <img src="http://7xtetc.com1.z0.glb.clouddn.com/60E4CB6914FEC60539366533DA8E64DA" class="">
                                </div>
                                <div class="col-1"></div>
                            </div>
                            <div>陈欣欣</div>
                            <div class="font-s12">心脏中心</div>
                            <div class="font-s12 line-h13e">广州市妇女儿童医疗中心</div>
                        </div>
                        <div class="col-1 w33 b-gray1 ml3 mr3 pb10">
                            <div class="grid mt10">
                                <div class="col-1"></div>
                                <div class="col-0 imgDiv">
                                    <img src="http://7xtetc.com1.z0.glb.clouddn.com/2287A85971D58C0DE7E038E904A13ECB" class="">
                                </div>
                                <div class="col-1"></div>
                            </div>
                            <div>唐家广</div>
                            <div class="font-s12">脊柱外科</div>
                            <div class="font-s12 line-h13e">北京304医院</div>
                        </div>
                        <div class="col-1 w33 b-gray1 ml6 pb10">
                            <div class="grid mt10">
                                <div class="col-1"></div>
                                <div class="col-0 imgDiv">
                                    <img src="http://7xtetc.com1.z0.glb.clouddn.com/F1060759BAAB7A08A1317DFB19151DC9" class="">
                                </div>
                                <div class="col-1"></div>
                            </div>
                            <div>梁益建</div>
                            <div class="font-s12">骨科</div>
                            <div class="font-s12 line-h13e">成都市第三人民医院</div>
                        </div>
                    </div>
                    <div class="grid text-center mt10">
                        <div class="col-1 w33 b-gray1 mr6 pb10">
                            <div class="grid mt10">
                                <div class="col-1"></div>
                                <div class="col-0 imgDiv">
                                    <img src="http://7xtetc.com1.z0.glb.clouddn.com/0EC486B26D0327DFC88933D4FA2D505A" class="">
                                </div>
                                <div class="col-1"></div>
                            </div>
                            <div>王明刚</div>
                            <div class="font-s12">普外科</div>
                            <div class="font-s12 line-h13e">北京朝阳医院</div>
                        </div>
                        <div class="col-1 w33 b-gray1 ml3 mr3 pb10">
                            <div class="grid mt10">
                                <div class="col-1"></div>
                                <div class="col-0 imgDiv">
                                    <img src="http://7xtetc.com1.z0.glb.clouddn.com/7D946D135ECEFA3EFFFC409C5EC806B2" class="">
                                </div>
                                <div class="col-1"></div>
                            </div>
                            <div>张旭</div>
                            <div class="font-s12">泌尿外科</div>
                            <div class="font-s12 line-h13e">北京301医院</div>
                        </div>
                        <div class="col-1 w33 b-gray1 ml6 pb10">
                            <div class="grid mt10">
                                <div class="col-1"></div>
                                <div class="col-0 imgDiv">
                                    <img src="http://7xtetc.com1.z0.glb.clouddn.com/7CCF23013A2B6456AF4AB2F599DC3D2F" class="">
                                </div>
                                <div class="col-1"></div>
                            </div>
                            <div>余新光</div>
                            <div class="font-s12">神经外科</div>
                            <div class="font-s12 line-h13e">北京301医院</div>
                        </div>
                    </div>
                </div>
                <div class="h10p bg-gray"></div>
                <div class="ml10 mr10 mt10 mb20">
                    <div class="grid">
                        <div class="col-0 pt2"><div class="greenLine"></div></div>
                        <div class="col-1 pl10">
                            名医公益大使
                        </div>
                    </div>
                    <div class="mt20">
                        他们曾有人与病魔抗争曾有人是病患的家属；她们也为人妻，为人母。在名医公益联盟的平台中，他们并非是公众眼里的明星，只是心存善意的公益人。
                    </div>
                    <div class="b-gray1 p5 mydsIcon mt15">
                        <div class="grid">
                            <div class="col-0 mr5">
                                <img src="<?php echo $urlResImage; ?>mygy/langyongchun.png" class="w110p">
                            </div>
                            <div class="col-1">
                                <div class="pt5">
                                    郎永淳先生
                                </div>
                                <div class="mt10 pr10">
                                    “爱永纯”健康中国基金发起人，原中国中央电视台新闻播音员、主持人，名医公益联盟启动仪式的主持人
                                </div>
                            </div>
                        </div>
                        <div class="mt10">
                            <span class="color-yellow2">寄语：</span>站上舞台是公益活动的主持人，回归生活，希望能够继续主持公益。
                        </div>
                    </div>
                    <div class="b-gray1 p5 mydsIcon mt15">
                        <div class="grid">
                            <div class="col-0 mr5">
                                <img src="<?php echo $urlResImage; ?>mygy/wangyan.png" class="w110p">
                            </div>
                            <div class="col-1">
                                <div class="pt5">
                                    王艳女士
                                </div>
                                <div class="mt10 pr10">
                                    <div>
                                        中国内地女演员
                                    </div>
                                    <div>
                                        曾获“中国品牌女性公益奖”
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt10">
                            <span class="color-yellow2">寄语：</span>以一己之力帮助更多的手术患者，让公益的力量肩负起生命的希望。
                        </div>
                    </div>
                    <div class="b-gray1 p5 mydsIcon mt15">
                        <div class="grid">
                            <div class="col-0 mr5">
                                <img src="<?php echo $urlResImage; ?>mygy/qianjing.png" class="w110p">
                            </div>
                            <div class="col-1">
                                <div class="pt5">
                                    钱婧女士
                                </div>
                                <div class="mt10 pr10">
                                    主持人、便道，暖阳基金发起人，大型原创健康公益节目《超级诊疗室》总制片人，名医公益联盟启动仪式主持人
                                </div>
                            </div>
                        </div>
                        <div class="mt10">
                            <span class="color-yellow2">寄语：</span>解决大病手术患者的问题，除了表达爱心外，首先我们要行动起来。
                        </div>
                    </div>
                    <div class="b-gray1 p5 mydsIcon mt15">
                        <div class="grid">
                            <div class="col-0 mr5">
                                <img src="<?php echo $urlResImage; ?>mygy/qiaozhen.png" class="w110p">
                            </div>
                            <div class="col-1">
                                <div class="pt5">
                                    乔榛先生
                                </div>
                                <div class="mt10 pr10">
                                    中国著名配音演员、导演
                                </div>
                            </div>
                        </div>
                        <div class="mt10">
                            <span class="color-yellow2">寄语：</span>我也曾是和病魔斗争过的病人。可以感同身受到其中的痛苦。希望名医公益联盟的发起，能够聚集成强大的能量，帮助到更多的手术患者。
                        </div>
                    </div>
                </div>
                <div class="h10p bg-gray"></div>
                <div class="mt10 ml10 mr10">
                    <div class="grid">
                        <div class="col-0 pt2"><div class="greenLine"></div></div>
                        <div class="col-1 pl10">
                            联盟公益组织
                        </div>
                    </div>
                    <div class="grid text-center mt10">
                        <div class="col-1 w33">
                            <div>
                                <img src="<?php echo $urlResImage; ?>mygy/yanrantianshi.png" class="w43p">
                            </div>
                            <div>
                                嫣然天使基金
                            </div>
                        </div>
                        <div class="col-1 w33">
                            <div class="pt18">
                                <img src="<?php echo $urlResImage; ?>mygy/nuanyang.png" class="w81p">
                            </div>
                            <div>
                                暖阳基金
                            </div>
                        </div>
                        <div class="col-1 w33">
                            <div class="pt3">
                                <img src="<?php echo $urlResImage; ?>mygy/chunhui.png" class="w56p">
                            </div>
                            <div>
                                大病救助基金
                            </div>
                        </div>
                    </div>
                    <div class="grid text-center mt10 mb50">
                        <div class="col-1 w50">
                            <div class="pt1">
                                <img src="<?php echo $urlResImage; ?>mygy/childrenFund.png" class="w30p">
                            </div>
                            <div>
                                中国少年儿童基金会
                            </div>
                        </div>
                        <div class="col-1 w50">
                            <div>
                                <img src="<?php echo $urlResImage; ?>mygy/womanHelth.png" class="w25p">
                            </div>
                            <div>
                                关注女性健康基金会
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
//        $('#joinMygy_article').scroll(function () {
//            if ($('#joinMygy_article').scrollTop() > 0) {
//                $('#joinMygy_header').removeClass('hide');
//            } else {
//                $('#joinMygy_header').addClass('hide');
//            }
//
//        });
    });
</script>