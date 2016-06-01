<?php
//Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/js/qiniu/css/bootstrap.min.css');
//Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/js/qiniu/css/main.css');
//Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/js/qiniu/css/highlight.css');
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/bootstrap.min.js?ts=' . time(), CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/plupload.full.min.js?ts=' . time(), CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/zh_CN.js?ts=' . time(), CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/ui.js?ts=' . time(), CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/qiniu.min.js?ts=' . time(), CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/highlight.js?ts=' . time(), CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/patientUpload.js?ts=' . time(), CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/jquery-1.9.1.min.js?ts=' . time(), CClientScript::POS_END);

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/js/qiniu/css/common.min.css?ts=' . time());
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/custom.min.js?ts=' . time(), CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/summaryUpload.min.js?ts=' . time(), CClientScript::POS_END);
?>

<?php
/*
 * $model PatientMRForm.
 */
$this->setPageID('pCreatePatientMR');
$this->setPageTitle('上传出院小结');
$patientId = $output['id'];
$user = $this->loadUser();
//$urlUploadFile = 'http://file.mingyizhudao.com/api/uploadparientmr'; //$this->createUrl("patient/ajaxUploadMRFile");
$urlUploadFile = $this->createUrl('qiniu/ajaxPatienMr');
$urlQiniuAjaxToken = $this->createUrl('qiniu/ajaxPatientToken');
$urlPatientAjaxDrTask = $this->createUrl('patient/ajaxDrTask');
$bookingId = Yii::app()->request->getQuery('bookingid', '');
$urlReturn = $this->createUrl('order/orderView', array('bookingid' => $bookingId, 'addBackBtn' => 1));
if (isset($output['id'])) {
    $urlPatientMRFiles = 'http://file.mingyizhudao.com/api/loadpatientmr?userId=' . $user->id . '&patientId=' . $patientId . '&reportType=da'; //$this->createUrl('patient/patientMRFiles', array('id' => $patientId));
    $urldelectPatientMRFile = 'http://file.mingyizhudao.com/api/deletepatientmr?userId=' . $user->id . '&id='; //$this->createUrl('patient/delectPatientMRFile');
} else {
    $urlPatientMRFiles = "";
    $urldelectPatientMRFile = "";
}

$urlResImage = Yii::app()->theme->baseUrl . "/images/";
?>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="uploadMRFile_section" class="active">
        <article id="" class="active android_article" data-scroll="true">
            <div class="mt20 pl10 pr10">
                <div>
                    上传影像资料
                </div>
                <div class="imglist mt10">
                    <ul class="filelist"></ul>
                </div>
                <div class="clearfix"></div>
                <div class="form-wrapper mt20">
                    <div class="">
                        <div class="container">
                            <div class="text-left wrapper">
                                <form id="booking-form" data-url-uploadfile="<?php echo $urlUploadFile; ?>" data-url-return="<?php echo $urlReturn; ?>" data-ajaxDrTask="<?php echo $urlPatientAjaxDrTask; ?>" data-patientbookingid="<?php echo $bookingId; ?>">
                                    <input id="patientId" type="hidden" name="Booking[patient_id]" value="<?php echo $patientId; ?>" />
                                    <input id="reportType" type="hidden" name="Booking[report_type]" value="da" />
                                    <input type="hidden" id="domain" value="http://mr.file.mingyizhudao.com">
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
                </div>
                <div id="deleteConfirm" class="confirm" style="top: 50%; left: 5%; right: 5%; border-radius: 3px; margin-top: -64.5px;">
                    <div class="popup-title">提示</div>
                    <div class="popup-content text-center">确定删除这张图片?</div>
                    <div id="popup_btn_container">
                        <a class="cancel">取消</a>
                        <a class="delete">确定</a>
                    </div>
                </div>
                <div id="jingle_toast" class="toast"><a href="#">取消!</a></div>
            </div>
        </article>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
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
