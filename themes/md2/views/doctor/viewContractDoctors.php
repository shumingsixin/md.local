<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/viewContractDoctors.js?ts=' . time(), CClientScript::POS_END);
?>
<?php
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
$state = Yii::app()->request->getQuery('state', '');
$disease_sub_category = Yii::app()->request->getQuery('disease_sub_category', '');
$page = Yii::app()->request->getQuery('page', '');
$urlAjaxContractDoctor = $this->createUrl('doctor/ajaxContractDoctor');
$urlViewContractDoctors = $this->createUrl('doctor/viewContractDoctors');
$urlState = $this->createUrl('doctor/ajaxStateList');
$urlDept = $this->createUrl('doctor/ajaxDeptList');
$urlDoctorView = $this->createUrl('doctor/viewDoctor', array('id' => ''));

$this->show_footer = false;
?>
<style>
    #jingle_popup{
        text-align: inherit;
    }
</style>
<header class="bg-green">
    <h1 class="title">签约专家</h1>
</header>
<nav id="contractDoctors_nav" class="header-secondary bg-white">
    <div class="grid w100 font-s16 color-black6">
        <div id="stateSelect" class="col-1 w50 br-gray bb-gray grid middle grayImg">
            <span id="stateTitle" data-dept="">全部</span><img src="<?php echo $urlResImage; ?>gray.png">
        </div>
        <div id="deptSelect" class="col-1 w50 bb-gray grid middle grayImg">
            <span id="deptTitle" data-disease="">科室</span><img src="<?php echo $urlResImage; ?>gray.png">
        </div>
    </div>
</nav>
<div id="section_container" <?php echo $this->createPageAttributes(); ?> >
    <section id="contractDoctors_section" class="active" data-init="true">
        <article id="contractDoctors_article" class="active" data-scroll="true">
            <div id="docPage">

            </div>
        </article>
    </section>
</div>
<script>
    $(document).ready(function () {
        J.showMask();

        //请求医生
        $requestDoc = '<?php echo $urlAjaxContractDoctor; ?>';

        //签约专家访问地址
        $requestViewContractDoctors = '<?php echo $urlViewContractDoctors; ?>';

        //预约页面
        $requestDoctorView = '<?php echo $urlDoctorView; ?>';

        $condition = new Array();
        $condition["state"] = '<?php echo $state ?>';
        $condition["disease_sub_category"] = '<?php echo $disease_sub_category; ?>';
        $condition["page"] = '<?php echo $page == '' ? 1 : $page; ?>';

        var urlAjaxLoadDoctor = '<?php echo $urlAjaxContractDoctor; ?>?getcount=1';
        //J.showMask();
        $.ajax({
            url: urlAjaxLoadDoctor,
            success: function (data) {
                //构造json
                var structureData = structure_data(data);
                //解密
                var returnData = do_decrypt(structureData, privkey);
                //解析数据
                returnData = analysis_data(returnData);
                readyDoc(returnData);
            }
        });

        //ajax异步加载科室
        $deptHtml = '';
        var urlloadDiseaseCategory = '<?php echo $urlDept; ?>';
        $.ajax({
            url: urlloadDiseaseCategory,
            success: function (data) {
                //构造json
                var structureData = structure_data(data);
                //解密
                var returnData = do_decrypt(structureData, privkey);
                //解析数据
                returnData = analysis_data(returnData);
                $deptHtml = readyDept(returnData);
            }
        });

        //ajax异步加载地区
        $stateHtml = ''
        var requestState = '<?php echo $urlState; ?>';
        $.ajax({
            url: requestState,
            success: function (data) {
                //构造json
                var structureData = structure_data(data);
                //解密
                var returnData = do_decrypt(structureData, privkey);
                //解析数据
                returnData = analysis_data(returnData);
                $stateHtml = readyState(returnData);
            },
            error: function (data) {
                console.log(data);
            }
        });

        function readyDept(data) {
            var results = data.results;
            var innerHtml = '<div class="grid color-black" style="margin-top:93px;height:315px;">' +
                    '<div id="highDept" class="col-1 w50" data-scroll="true" style="height:315px;width: 50%;">' +
                    '<ul class="list">';
            if (results.length > 0) {
                for (var i = 0; i < results.length; i++) {
                    //第一个为白色
                    if (i == 0) {
                        innerHtml += '<li class="aDept bg-white" data-dept="' + results[i].id + '">' + results[i].name + '</li>';
                    } else {
                        innerHtml += '<li class="aDept" data-dept="' + results[i].id + '">' + results[i].name + '</li>';
                    }
                }
                innerHtml += '</ul></div><div id="secondDept" class="col-1 w50" data-scroll="true" data- style="height:315px;">'
                for (var i = 0; i < results.length; i++) {
                    var subCat = results[i].subCat;
                    //第一个不隐藏
                    if (i == 0) {
                        innerHtml += '<ul class="bDept list" data-dept="' + results[i].id + '">';
                    } else {
                        innerHtml += '<ul class="bDept list hide" data-dept="' + results[i].id + '">';
                    }
                    if (subCat.length > 0) {
                        for (var j = 0; j < subCat.length; j++) {
                            innerHtml += '<li class="cDept" data-dept="' + subCat[j].id + '">' + subCat[j].name + '</li>';
                        }
                    }
                    innerHtml += '</ul>';
                }
            }
            innerHtml += '</div></div>';
            return innerHtml;
        }

        function readyState(data) {
            var stateList = data.results.stateList;
            var innerHtml = '<div data-scroll="true" style="height:315px;margin-top:93px;"><ul class="list">'
                    + '<li class="state" data-state="">全部</li>';
            //console.log(stateList(1));
            for (var s in stateList) {
                innerHtml += '<li class="state" data-state="' + s + '">' + stateList[s] + '</li>';
            }
            innerHtml += '</ul></div>';
            return innerHtml;
        }

    });
</script>