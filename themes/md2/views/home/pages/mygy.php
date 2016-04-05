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
                            名医公益联盟是由名医主刀倡导发起，联合公益组织、公益医生共建出一种新的，可持续的公益模式。此公益模式获得了国内主流媒体、公益明星的极大关注和支持。
                        </div>
                    </div>
                    <div class="ml10 mr10 mt20 mb20 text-indent-2">
                        名医主刀组织国内同有“解患者之难”抱负的公益医生，为病患提供公益手术服务。救助形式不限，哪里有最紧急的病痛，哪里最需要名医联盟的力量，名医君就在哪里。名医公益联盟的所有名医君，均是来自国内三甲医院的专家、主任医生。
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
                                    <img src="http://mingyizhudao.com/resource/doctor/avatar/03022.jpg" class="">
                                </div>
                                <div class="col-1"></div>
                            </div>
                            <div>史占军</div>
                            <div class="font-s12">创伤骨科</div>
                            <div class="font-s12 line-h13e">男方医科大学男方医院</div>
                        </div>
                        <div class="col-1 w33 b-gray1 ml3 mr3 pb10">
                            <div class="grid mt10">
                                <div class="col-1"></div>
                                <div class="col-0 imgDiv">
                                    <img src="http://mingyizhudao.com/resource/doctor/avatar/03022.jpg" class="">
                                </div>
                                <div class="col-1"></div>
                            </div>
                            <div>史占军</div>
                            <div class="font-s12">创伤骨科</div>
                            <div class="font-s12 line-h13e">男方医科大学男方医院</div>
                        </div>
                        <div class="col-1 w33 b-gray1 ml6 pb10">
                            <div class="grid mt10">
                                <div class="col-1"></div>
                                <div class="col-0 imgDiv">
                                    <img src="http://mingyizhudao.com/resource/doctor/avatar/03022.jpg" class="">
                                </div>
                                <div class="col-1"></div>
                            </div>
                            <div>史占军</div>
                            <div class="font-s12">创伤骨科</div>
                            <div class="font-s12 line-h13e">男方医科大学男方医院</div>
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
        $('#joinMygy_article').scroll(function () {
            if ($('#joinMygy_article').scrollTop() > 0) {
                $('#joinMygy_header').removeClass('hide');
            } else {
                $('#joinMygy_header').addClass('hide');
            }

        });
    });
</script>