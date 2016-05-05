<?php ?>
<?php
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$this->show_footer = false;
$this->show_header = false;
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?> >
    <section id="newList_section" class="active" data-init="true">
        <article id="newList_article" class="active" data-scroll="true">
            <div class="pl10 pr10 text-justify">
                <div class="text-indent-2 mt20">
                    中国最具投资价值企业50强评选由清科集团发起，是投资界首个专注高成长企业的年度评选活动，自2006年发布以来，已成功举办十届，被誉为“行业投资风向标”。
                </div>
                <div class="text-indent-2 mt10">
                    2015年12月2日，在第六届中国高成长企业CEO峰会上，第十届“中国最具投资价值企业50强”评选榜单（以下简称V50榜单）正式发布。该榜自2006年以来，至今已举办十年之久，是投资界首个专注高成长企业的年度评选活动，被誉为“行业投资风向标”。与往届不同的是，本届“中国最具投资价值企业50强”榜单评选首次根据企业发展的不同阶段与规模，将企业榜细分为“新芽榜”和“风云榜”。
                </div>
                <div class="mt10">
                    <img src="<?php echo $urlResImage; ?>event/newList/newList.png">
                </div>
                <div class="mt20 mb50 text-center">
                    <div class="grid color-white">
                        <div class="col-1"></div>
                        <div id="like" class="col-0 w90p addLike pt55">
                            123
                        </div>
                        <div class="col-1">
                        </div>
                    </div>
                    <div class="mt5 color-black6 grid">
                        <div class="col-1"></div>
                        <div class="col-0 pl2">
                            赞一下
                        </div>
                        <div class="col-1"></div>
                    </div>
                </div>
            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        $('#like').click(function () {
            alert(123);
        });
    });
</script>