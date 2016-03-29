<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/ajaxfileupload.js', CClientScript::POS_END);
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
$urlUploadFile = 'http://file.mingyizhudao.com/api/uploaddoctorcert'; //$this->createUrl("doctor/ajaxUploadCert");
$urlSendEmailForCert = $this->createUrl('doctor/sendEmailForCert');
$urlReturn = $this->createUrl('doctor/view');
if (isset($output['id'])) {
    $urlDoctorCerts = 'http://file.mingyizhudao.com/api/loaddrcert?userId=' . $output['id']; //$this->createUrl('doctor/doctorCerts', array('id' => $output['id']));
    $urlDelectDoctorCert = 'http://file.mingyizhudao.com/api/deletedrcert?userId=' . $output['id'] . '&id='; //$this->createUrl('doctor/delectDoctorCert');
} else {
    $urlDoctorCerts = "";
    $urlDelectDoctorCert = "";
}

$urlResImage = Yii::app()->theme->baseUrl . "/images/";
?>
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
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'doctor-form',
                            // Please note: When you enable ajax validation, make sure the corresponding
                            // controller action is handling ajax validation correctly.
                            // There is a call to performAjaxValidation() commented in generated controller code.
                            // See class documentation of CActiveForm for details on this.
                            'htmlOptions' => array('class' => "form-horizontal", 'role' => 'form', 'autocomplete' => 'off', "enctype" => "multipart/form-data"),
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                                'validateOnType' => true,
                                'validateOnDelay' => 500,
                                'errorCssClass' => 'error',
                            ),
                            'enableAjaxValidation' => false,
                        ));
                        echo CHtml::hiddenField("doctor[id]", $output['id']);
                        ?>
                        <div class="">    
                            <div class="uploadfile text-center">
                                <?php
                                $this->widget('CMultiFileUpload', array(
                                    //'model' => $model,
                                    'attribute' => 'file',
                                    'id' => "btn-addfiles",
                                    'name' => 'file', //$_FILES['BookingFiles'].
                                    'accept' => 'jpeg|jpg|png',
                                    'options' => array(
                                        'afterFileSelect' => 'function(e, v, m){ var inputCount = $(".MultiFile-applied").length;if (inputCount == 0) {$("#btnSubmit").removeClass("btn-block");} else {$("#btnSubmit").addClass("btn-block");} }',
                                        'afterFileRemove' => 'function(e, v, m){ var inputCount = $(".MultiFile-applied").length - 1;if (inputCount == 0) {$("#btnSubmit").removeClass("btn-block");} else {$("#btnSubmit").addClass("btn-block");} }',
                                    ),
                                    'denied' => '请上传jpg、png格式',
                                    'duplicate' => '该文件已被选择',
                                    'max' => 8, // max 8 files
                                    //'htmlOptions' => array(),
                                    'value' => '上传病历',
                                    'selected' => '已选文件',
                                        //'file'=>'文件'
                                ));
                                ?>

                            </div>
                        </div>
                        <div class="mt30">
                            <div class="col-sm-6 col-sm-offset-3">
                                <button id="btnSubmit" type="button" class="btn btn-lg btn-yes" name="">上&nbsp;传</button>       
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <?php
                        $this->endWidget();
                        ?>
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
                <div class="popup-content">确定删除这张图片?</div>
                <div id="popup_btn_container">
                    <a class="cancel" data-icon="close"><i class="icon close"></i>取消</a>
                    <a class="delete" data-icon="checkmark"><i class="icon checkmark"></i>确定</a>
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

            <div id="jingle_toast" class="toast"><a href="#">取消!</a></div>
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
        $("#imgConfirm #tag_close_popup").click(function(){
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
            $("#imgConfirm img").attr('src',imgUrl);
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