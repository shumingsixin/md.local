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
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/userUpload.js?ts=' . time(), CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/qiniu/js/jquery-1.9.1.min.js?ts=' . time(), CClientScript::POS_END);
?>
<?php
/*
 * $model UserDoctorProfileForm.
 */
$this->setPageID('pUserDoctorProfile');
$this->setPageTitle('实名认证');
$urlLogin = $this->createUrl('doctor/login');
$urlTermsPage = $this->createUrl('home/page', array('view' => 'terms'));
$urlLoadCity = $this->createUrl('/region/loadCities', array('state' => ''));
$urlSubmitProfile = $this->createUrl("doctor/ajaxProfile");
//$urlUploadFile = 'http://file.mingyizhudao.com/api/uploaddoctorcert'; //$this->createUrl("doctor/ajaxUploadCert");

$urlSendEmailForCert = $this->createUrl('doctor/sendEmailForCert');
$urlUploadFile = $this->createUrl('qiniu/ajaxDrCert');
$urlQiniuAjaxDrToken = $this->createUrl('qiniu/ajaxDrToken');


$urlSendEmailForCert = $this->createUrl('doctor/sendEmailForCert');
$urlReturn = $this->createUrl('doctor/view');
if (isset($output['id'])) {
    $urlDoctorCerts = 'http://192.168.31.119/file.myzd.com/api/loaddrcert?userId=' . $output['id']; //$this->createUrl('doctor/doctorCerts', array('id' => $output['id']));
    $urlDelectDoctorCert = 'http://192.168.31.119/file.myzd.com/api/deletedrcert?userId=' . $output['id'] . '&id='; //$this->createUrl('doctor/delectDoctorCert');
} else {
    $urlDoctorCerts = "";
    $urlDelectDoctorCert = "";
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
    <section class="active">
        <article class="active pad1" data-scroll="true">
            <div class="form-wrapper">
                <!-- file uploader -->
                <div class="">
                    <h4>请完成实名认证,认证后开通名医主刀账户</h4>
                    <div class="">
                        <label>上传医生职业证书或者手持工牌照</label>
                    </div>
                    <div>&nbsp;&nbsp;请确保图片内容清晰可见</div>
                    <?php
                    if ($output['isVerified']) {
                        echo '<p class="color-red mt10">您已通过实名认证,信息不可以再修改。</p>';
                    }
                    ?>
                    <div class="imglist mt10">
                        <ul class="filelist"></ul>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-wrapper mt20">
                        <div class="">
                            <div class="container">
                                <div class="text-left wrapper">
                                    <form id="booking-form" data-url-uploadfile="<?php echo $urlUploadFile; ?>" data-url-return="<?php echo $urlReturn; ?>" data-url-sendEmail="<?php echo $urlSendEmailForCert; ?>">
                                        <input id="userId" type="hidden" name="cert[user_id]" value="<?php echo $output['id'];  ?>" />
                                        <input type="hidden" id="domain" value="http://7xq939.com2.z0.glb.qiniucdn.com">
                                        <input type="hidden" id="uptoken_url" value="<?php echo $urlQiniuAjaxDrToken; ?>">
                                    </form>
                                </div>
                                <div class="body mt10">
                                    <div class="text-center">
                                        <div id="container">
                                            <a class="btn btn-default btn-lg " id="pickfiles" href="#" >
                                                <span>选择图片</span>
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
                                    <a class="btn btn-full bg-green color-white">上传</a>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="example">
                                <label class="color-red">示例:</label>
                                <div class="ui-grid-b">
                                    <div class="ui-block-a">
                                        <img src="<?php echo $urlResImage; ?>docexample1.png"/>
                                    </div>
                                    <div class="ui-block-b">
                                        <span>或</span>
                                    </div>
                                    <div class="ui-block-c">
                                        <img src="<?php echo $urlResImage; ?>docexample2.jpg"/>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
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
            <div id="successConfirm" class="confirm" style="top: 50%; left: 5%; right: 5%; border-radius: 3px; margin-top: -77.5px;">
                <div><div class="popup-title">提示</div>
                    <div class="popup-content">
                        <h4 class="text-center">提交成功，请耐心等待审核</h4>
                        <div class="mt20">
                            <a data-target="link" href="<?php echo $urlReturn; ?>" class="btn btn-yes btn-block">确定</a>
                        </div>
                    </div>
                </div>
                <div id="tag_close_popup" data-target="closePopup" class="icon cancel-circle"></div>
            </div>
            <div id="errorConfirm" class="confirm" style="top: 50%; left: 5%; right: 5%; border-radius: 3px; margin-top: -77.5px;">
                <div><div class="popup-title">提示</div>
                    <div class="popup-content">
                        <h4 class="text-center">提交失败！</h4>
                        <div class="confirmcontent"></div>
                        <div class="mt20">
                            <a data-target="link" href="" class="btn btn-yes btn-block">确定</a>
                        </div>
                    </div>
                </div>
                <div id="tag_close_popup" data-target="closePopup" class="icon cancel-circle"></div>
            </div>

            <div id="jingle_toast" class="toast"><a href="#" class="font-s18">取消!</a></div>
            <div id="jingle_popup_mask" style="opacity: 0.3;"></div>
        </article>
        <div id="imgConfirm" class="confirm" style="left: 0px; right: 0px;min-height: 50em;">
            <div class="pad2">
                <img src="">
            </div>
            <div id="tag_close_popup" class="icon cancel-circle"></div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var isVerified = '<?php echo $output['isVerified']; ?>';
        if (isVerified) {
            $(".uploadfile").hide();
        }
        $("#imgConfirm #tag_close_popup").click(function () {
            $(this).parents(".confirm").hide();
        });
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
        urlDoctorCerts = "<?php echo $urlDoctorCerts; ?>";
        $.ajax({
            url: urlDoctorCerts,
            success: function (data) {
                setImgHtml(data.results.files, isVerified);
            }
        });
    });
    function ajaxUploadFile() {
        var btnSubmit = $("#btnSubmit");
        disabledBtn(btnSubmit);
        //循环input
        var successCount = 0, inputCount = 0, backCount = 0;
        inputCount = $(".MultiFile-applied").length - 1;
        var data = {'doctor[id]': $("#doctor_id").val(), 'plugin': 'ajaxFileUpload'};
        $(".MultiFile-applied").attr("name", 'file');
        $(".MultiFile-applied").each(function () {
            if ($(this).val()) {
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
                        } else {
                            $("#errorConfirm .confirmcontent").text(data.error);
                            $("#errorConfirm").show();
                            $("#jingle_popup_mask").addClass("active");
                        }
                    },
                    error: function (data, status, e) {
                        //错误处理
                        //successCount++;
                        if (status == 'error') {
                            alert('上传失败!');
                        }
                    },
                    complete: function () {
                        backCount++;
                        if (inputCount == backCount) {
                            if (successCount == inputCount) {
                                J.hideMask();
                                sendEmailForCert();
                                $("#successConfirm").show();
                                $("#jingle_popup_mask").addClass("active");
                            } else {
                                $("#reloadConfirm").show();
                            }
                            $(this).attr('disabled', false);
                            J.hideMask();
                        }
                        enableBtn(btnSubmit);
                    }
                });
            }
        });
    }
    function setImgHtml(imgfiles, isVerified) {
        var innerHtml = '';
        if (imgfiles && imgfiles.length > 0) {
            for (var i = 0; i < imgfiles.length; i++) {
                var imgfile = imgfiles[i];
                var deleteHtml = '<div class="file-panel delete">删除</div>';
                if (isVerified) {
                    deleteHtml = '';
                }
                innerHtml +=
                        '<li id="' +
                        imgfile.id + '"><p class="imgWrap"><img src="' +
                        imgfile.thumbnailUrl + '" data-src="' +
                        imgfile.absFileUrl + '"></p>' + deleteHtml + '</li>';
            }
        } else {
            innerHtml += '';
        }
        $(".imglist .filelist").html(innerHtml);
        initDelete();
        $('.imgWrap img').click(function () {
            var imgUrl = $(this).attr("data-src");
            $("#imgConfirm img").attr('src', imgUrl);
            $("#imgConfirm").show();
        });
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
        J.showMask();
        urlDelectDoctorCert = '<?php echo $urlDelectDoctorCert ?>' + id;
        $.ajax({
            url: urlDelectDoctorCert,
            success: function (data) {
                if (data.status == 'ok') {
                    domLi.remove();
                    $("#jingle_toast a").text('删除成功!');
                    $("#jingle_toast").show();
                } else {
                    $("#errorConfirm .confirmcontent").text(data.error);
                    $("#errorConfirm").show();
                    $("#jingle_popup_mask").addClass("active");
                }
            },
            complete: function () {
                J.hideMask();
            }
        });
    }
    //发送邮件
    function sendEmailForCert() {
        $.ajax({
            url: '<?php echo $urlSendEmailForCert; ?>',
            type: 'post',
            success: function () {
                console.log("发送邮件成功");
            }
        });
    }
</script>