<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/js/qiniu/css/bootstrap.min.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/js/qiniu/css/main.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/js/qiniu/css/highlight.css');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/bootstrap.min.js?ts=' . time(), CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/plupload.full.min.js?ts=' . time(), CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/zh_CN.js?ts=' . time(), CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/ui.js?ts=' . time(), CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/qiniu.min.js?ts=' . time(), CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/highlight.js?ts=' . time(), CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/patientUpload.js?ts=' . time(), CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/jquery-1.9.1.min.js?ts=' . time(), CClientScript::POS_END);
?>

<?php
/*
 * $model PatientMRForm.
 */
$this->setPageID('pCreatePatientMR');
$this->setPageTitle('上传患者病历');
$urlLogin = $this->createUrl('doctor/login');
$patientId = $output['id'];
$user = $this->loadUser();
$urlSubmitMR = $this->createUrl("patient/ajaxCreatePatientMR");
//$urlUploadFile = 'http://file.mingyizhudao.com/api/uploadparientmr'; //$this->createUrl("patient/ajaxUploadMRFile");
$urlUploadFile = $this->createUrl('qiniu/ajaxPatienMr');
$urlQiniuAjaxToken = $this->createUrl('qiniu/ajaxPatientToken');
$urlReturn = $this->createUrl('patient/view', array('id' => $patientId));

$patientBookingId = Yii::app()->request->getQuery('patientBookingId', '');
$patientAjaxTask = $this->createUrl('patient/ajaxTask', array('id' => ''));

$type = Yii::app()->request->getQuery('type', 'create');
if ($type == 'update') {
    $urlReturn = $this->createUrl('patient/view', array('id' => $patientId, 'addBackBtn' => 1));
} else if ($type == 'create') {
    if ($output['returnUrl'] == '') {
        $urlReturn = $this->createUrl('patientbooking/create', array('pid' => $patientId, 'addBackBtn' => 1));
    } else {
        $urlReturn = $output['returnUrl'];
    }
}
if (isset($output['id'])) {
    $urlPatientMRFiles = 'http://192.168.31.119/file.myzd.com/api/loadpatientmr?userId=' . $user->id . '&patientId=' . $patientId . '&reportType=mr'; //$this->createUrl('patient/patientMRFiles', array('id' => $patientId));
    $urldelectPatientMRFile = 'http://192.168.31.119/file.myzd.com/api/deletepatientmr?userId=' . $user->id . '&id='; //$this->createUrl('patient/delectPatientMRFile');
} else {
    $urlPatientMRFiles = "";
    $urldelectPatientMRFile = "";
}

$urlResImage = Yii::app()->theme->baseUrl . "/images/";
?>
<style>
    .progressName{word-break: break-all; word-wrap:break-word;}
    .table-striped>tbody>tr:nth-child(odd)>td, .table-striped>tbody>tr:nth-child(odd)>th{background-color: #fff;}
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td{border-top: inherit;padding:0px;}
    tr .progressCancel{font-size: 30px;color: #FF1818;line-height: 22px;}
    #container{margin-bottom: 0px;}
    .btn-default{background-color: #19aea5!important;}
    .body .btn-default{border: inherit;color: #fff;}
    .btn{padding:3px 10px;}
</style>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="uploadMRFile_section" class="active">
        <article id="a1" class="active" data-scroll="true">
            <div class="mt20">
                <div class="grid">
                    <div class="col-1 ml10">上传影像资料：</div>
                    <?php if ($type == 'create') { ?>
                        <div class="col-0">
                            <a href="<?php echo $urlReturn; ?>" class="btn btn-yes mr10" data-ajax="false">跳过</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="imglist mt10">
                <ul class="filelist"></ul>
            </div>
            <div class="clearfix"></div>
            <div class="form-wrapper mt20">
                <div class="">
                    <div class="container">
                        <div class="text-left wrapper">
                            <form id="booking-form" data-url-uploadfile="<?php echo $urlUploadFile; ?>" data-url-return="<?php echo $urlReturn; ?>" data-patientBookingId="<?php echo $patientBookingId; ?>" data-patientAjaxTask="<?php echo $patientAjaxTask; ?>">
                                <input id="patientId" type="hidden" name="Booking[patient_id]" value="<?php echo $patientId; ?>" />
                                <input id="reportType" type="hidden" name="Booking[report_type]" value="mr" />
                                <input type="hidden" id="domain" value="http://7xq93p.com2.z0.glb.qiniucdn.com">
                                <input type="hidden" id="uptoken_url" value="<?php echo $urlQiniuAjaxToken; ?>">
                            </form>
                        </div>
                        <div class="body mt10">
                            <div class="text-center">
                                <div id="container">
                                    <a class="btn btn-default btn-lg " id="pickfiles" href="#" >
                                        <span>选择影像资料</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-12 mt10">
                                <table class="table table-striped table-hover text-left" style="display:none">
                                    <tbody id="fsUploadProgress">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="submitBtn" class="hide">
                            <button class="btn btn-full bg-green color-white">上传</button>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="example">
                        <label class="color-red">示例:</label>
                        <div class="ui-grid-b">
                            <div class="ui-block-a">
                                <img src="<?php echo $urlResImage; ?>patientexample1.jpg"/>
                            </div>
                            <div class="ui-block-b">
                                <span>或</span>
                            </div>
                            <div class="ui-block-c">
                                <img src="<?php echo $urlResImage; ?>patientexample2.jpg"/>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div id="deleteConfirm" class="confirm" style="top: 50%; left: 5%; right: 5%; border-radius: 3px; margin-top: -64.5px;">
                <div class="popup-title">提示</div>
                <div class="popup-content text-center">确定删除这张图片?</div>
                <div id="popup_btn_container">
                    <a class="cancel">取消</a>
                    <a class="delete">确定</a>
                </div>
            </div>
            <div id="jingle_toast" class="toast"><a href="#" class="font-s18">取消!</a></div>
        </article>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#btnSubmit").hide();
        $("#btnSubmit").click(function () {
            ajaxUploadFile();
        });
        $("#deleteConfirm .cancel").click(function () {
            $("#deleteConfirm").hide();
            $("#jingle_toast").show();
            setTimeout(function () {
                $("#jingle_toast").hide();
            }, 1000);
        });
        $("#deleteConfirm .delete").click(function () {
            $("#deleteConfirm").hide();
            id = $(this).attr("data-id");
            domId = "#" + id;
            domLi = $(domId);
            deleteImg(id, domLi);
            setTimeout(function () {
                $("#jingle_toast").hide();
            }, 2000);
        });
        //加载病人病历图片
        var urlPatientMRFiles = "<?php echo $urlPatientMRFiles; ?>";
        $.ajax({
            url: urlPatientMRFiles,
            success: function (data) {
                setImgHtml(data.results.files);
            }
        });
    });
    function ajaxUploadFile() {
        var btnSubmit = $("#btnSubmit");
        disabledBtn(btnSubmit);
        $(".MultiFile-applied").attr("name", 'file');
        var successCount = 0, inputCount = 0, backCount = 0;
        inputCount = $(".MultiFile-applied").length - 1;
        var data = {'patient[id]': $("#patient_id").val(), 'patient[report_type]': 'mr', 'plugin': 'ajaxFileUpload'};
        $(".MultiFile-applied").each(function () {
            if ($(this).val()) {
                var doctorId = $("#doctor_id").val();
                var fileId = $(this).attr("id");
                $.ajaxFileUpload({
                    url: '<?php echo $urlUploadFile; ?>',
                    secureuri: false, //是否安全提交
                    data: data, //提交时带上的参数
                    fileElementId: fileId, //input file 的id
                    type: 'post',
                    dataType: 'json',
                    success: function (data, status) {
                        if (status == 'success') {
                            successCount++;
                        }
                    },
                    error: function (data, status, e) {
                        //错误处理
                        if (status == 'error') {
                            alert('上传失败!');
                        }
                    },
                    complete: function () {
                        backCount++;
                        if (inputCount == backCount) {
                            if (successCount == inputCount) {
                                window.location.href = '<?php echo $urlReturn; ?>';
                            } else {
                                $("#reloadConfirm").show();
                            }
                            enableBtn(btnSubmit);
                        }
                    }
                });
            }
        });
    }
    function setImgHtml(imgfiles) {
        var innerHtml = '';
        if (imgfiles && imgfiles.length > 0) {
            for (i = 0; i < imgfiles.length; i++) {
                imgfile = imgfiles[i];
                innerHtml +=
                        '<li id="' +
                        imgfile.id + '"><p class="imgWrap"><img src="' +
                        imgfile.thumbnailUrl + '" data-src="' +
                        imgfile.absFileUrl + '"></p><div class="file-panel delete"><span class="">删除</span></div></li>';
            }
        } else {
            innerHtml += '';
        }
        $(".imglist .filelist").html(innerHtml);
        initDelete();
    }
    function initDelete() {
        $('.imglist .delete').click(function () {
            domLi = $(this).parents("li");
            id = domLi.attr("id");
            $("#deleteConfirm .delete").attr("data-id", id);
            $("#deleteConfirm").show();
        });
    }
    function deleteImg(id, domLi) {
        $(".ui-loader").show();
        urlDelectDoctorCert = '<?php echo $urldelectPatientMRFile ?>' + id;
        $.ajax({
            url: urlDelectDoctorCert,
            beforeSend: function () {

            },
            success: function (data) {
                if (data.status == 'ok') {
                    domLi.remove();
                    $("#jingle_toast a").text('删除成功!');
                    $("#jingle_toast").show();
                }
            },
            complete: function () {
                $(".ui-loader").hide();
            }
        });
    }
</script>
