<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/ajaxfileupload.js', CClientScript::POS_END);
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
$urlUploadFile = 'http://file.mingyizhudao.com/api/uploadparientmr'; //$this->createUrl("patient/ajaxUploadMRFile");
$urlReturn = $this->createUrl('patient/view', array('id' => $patientId));

$type = Yii::app()->request->getQuery('type', 'create');
if ($type == 'update') {
    $urlReturn = $this->createUrl('patient/view', array('id' => $patientId));
} else if ($type == 'create') {
    if ($output['returnUrl'] == '') {
        $urlReturn = $this->createUrl('patientbooking/create', array('pid' => $patientId));
    } else {
        $urlReturn = $output['returnUrl'];
    }
}
if (isset($output['id'])) {
    $urlPatientMRFiles = 'http://file.mingyizhudao.com/api/loadpatientmr?userId=' . $user->id . '&patientId=' . $patientId . '&reportType=mr'; //$this->createUrl('patient/patientMRFiles', array('id' => $patientId));
    $urldelectPatientMRFile = 'http://file.mingyizhudao.com/api/deletepatientmr?userId=' . $user->id . '&id='; //$this->createUrl('patient/delectPatientMRFile');
} else {
    $urlPatientMRFiles = "";
    $urldelectPatientMRFile = "";
}

$urlResImage = Yii::app()->theme->baseUrl . "/images/";
?>
<style>
    .uploadfile:before{content: '选择影像资料';}
</style>
<div id="section_container" <?php echo $this->createPageAttributes(); ?>>
    <section id="uploadMRFile_section" class="active">
        <article id="a1" class="active" data-scroll="true">
            <div class="mt20">
                <label for="btn-addfiles">
                    <span class="ml10">上传影像资料：</span>
                    <?php if ($type == 'create') { ?>
                        <a href="<?php echo $urlReturn; ?>" class="pull-right btn btn-yes mr10" data-ajax="false">跳过</a>
                    <?php } ?>
                </label>
            </div>
            <div class="imglist mt10">
                <ul class="filelist"></ul>
            </div>
            <div class="clearfix"></div>
            <div class="form-wrapper mt20">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'patient-form',
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
                echo CHtml::hiddenField("patient[id]", $output['id']);
                echo CHtml::hiddenField("patient[type]", $type);
                ?>
                <div class="">    
                    <div class="uploadfile text-center">
                        <?php
                        $this->widget('CMultiFileUpload', array(
                            //'model' => $model,
                            'attribute' => 'files',
                            'id' => "btn-addfiles",
                            'name' => 'file', //$_FILES['BookingFiles'].
                            'accept' => 'jpeg|jpg|png',
                            'options' => array(
                                'afterFileSelect' => 'function(e, v, m){ var inputCount = $(".MultiFile-applied").length;if (inputCount == 0) {$("#btnSubmit").removeClass("btn-block");} else {$("#btnSubmit").addClass("btn-block");} }',
                                //'onFileSelect'=>'function(e, v, m){ alert("afterFileSelect - "+v) }',
                                //'onFileAppend'=>'function(e, v, m){ alert("onFileAppend - "+v) }',
                                // 'afterFileAppend'=>'function(e, v, m){ alert("afterFileAppend - "+v) }',
                                // 'onFileRemove'=>'function(e, v, m){ alert("onFileRemove - "+v) }',
                                'afterFileRemove' => 'function(e, v, m){ var inputCount = $(".MultiFile-applied").length - 1;if (inputCount == 0) {$("#btnSubmit").removeClass("btn-block");} else {$("#btnSubmit").addClass("btn-block");} }',
                            ),
                            'denied' => '请上传jpg、png格式',
                            'duplicate' => '该文件已被选择',
                            'max' => 8, // max 8 files
                            //'htmlOptions' => array(),
                            'value' => '选择影像资料',
                            'selected' => '已选文件',
                                //'file'=>'文件'
                        ));
                        ?>

                    </div>
                </div>
                <div class="mt30">
                    <div class="col-sm-6 col-sm-offset-3">
                        <button id="btnSubmit" type="button" class="btn btn btn-yes" name="">上&nbsp;传</button>       
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
                <div class="popup-content">确定删除这张图片?</div>
                <div id="popup_btn_container">
                    <a class="cancel" data-icon="close"><i class="icon close"></i>取消</a>
                    <a class="delete" data-icon="checkmark"><i class="icon checkmark"></i>确定</a>
                </div>
            </div>
            <div id="jingle_toast" class="toast"><a href="#">取消!</a></div>
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
