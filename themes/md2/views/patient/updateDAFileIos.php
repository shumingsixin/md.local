<?php
Yii::app()->clientScript->registerCssFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/webuploader/css/webuploader.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/js/webuploader/css/webuploader.custom.css');
Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/webuploader/js/webuploader.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/uploadMRFile.js?ts=' . time(), CClientScript::POS_END);
?>	
<?php
/*
 * $model PatientMRForm.
 */
$this->setPageID('pCreatePatientMR');
$this->setPageTitle('上传出院小结');
$patientId = $output['id'];
$user = $this->loadUser();
$urlUploadFile = 'http://file.mingyizhudao.com/api/uploadparientmr'; //$this->createUrl("patient/ajaxUploadMRFile");
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
        <article id="a1" class="active" data-scroll="true">
            <div class="form-wrapper mt10">
                <form id="patient-form" data-url-uploadfile="<?php echo $urlUploadFile; ?>" data-url-return="<?php echo $urlReturn; ?>">
                    <input id="patientId" type="hidden" name="patient[id]" value="<?php echo $patientId; ?>" />
                    <input id="reportType" type="hidden" name="patient[report_type]" value="da" />
                </form>
                <div class="pl10 pr10">
                    <div>
                        上传影像资料：
                    </div>
                    <div class="mt20">    
                        <!--图片上传区域 -->
                        <div id="uploader" class="wu-example">
                            <div class="imglist">
                                <ul class="filelist"></ul>
                            </div>
                            <div class="queueList">
                                <div id="dndArea" class="placeholder">
                                    <div id="filePicker"></div>
                                    <!-- <p>或将照片拖到这里，单次最多可选10张</p>-->
                                </div>
                            </div>
                            <div class="statusBar" style="display:none; padding-bottom: 40px;">
                                <div class="progress">
                                    <span class="text">0%</span>
                                    <span class="percentage"></span>
                                </div>
                                <div class="info"></div>
                                <div class="">
                                    <!-- btn 继续添加 -->
                                    <div id="filePicker2" class="pull-right"></div>                                
                                </div>
                                <div class="clearfix"></div>
                                <div class="mt20">
<!--                                    <input id="btnSubmit" class="statusBar uploadBtn state-pedding btn btn-yes btn-block" type="button" name="yt0" value="提交">-->
                                    <a id="btnSubmit" class="statusBar uploadBtn state-pedding btn btn-yes btn-block">提交</a>
                                </div>
                            </div>
                            <!--一开始就显示提交按钮就注释上面的提交 取消下面的注释 -->
                            <!--                         <div class="statusBar uploadBtn">提交</div>-->
                        </div>

                    </div>
                </div>
            </div>
            <div class="mt30"></div>
        </article>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var urlPatientMRFiles = "<?php echo $urlPatientMRFiles; ?>";
        $.ajax({
            url: urlPatientMRFiles,
            success: function (data) {
                setImgHtml(data.results);
            }
        });
    });
    function setImgHtml(files) {
        var innerHtml = '';
        var imgfiles = files.files;
        if (imgfiles && imgfiles.length > 0) {
            for (i = 0; i < imgfiles.length; i++) {
                var imgfile = imgfiles[i];
                innerHtml +=
                        '<li id="' +
                        imgfile.id + '"><p class="imgWrap"><img src="' +
                        imgfile.thumbnailUrl + '" data-src="' +
                        imgfile.absFileUrl + '"></p><div class="file-panel delete">删除</div></li>';
            }
        } else {
            innerHtml += '';
        }
        $(".imglist .filelist").html(innerHtml);
        initDelete();
    }
    function initDelete() {
        $('.imglist .delete').tap(function () {
            domLi = $(this).parents("li");
            id = domLi.attr("id");
            J.confirm('提示', '确定删除这张图片?', function () {
                deleteImg(id, domLi);
            }, function () {
                J.showToast('取消', '', 1000);
            });
        });
    }
    function deleteImg(id, domLi) {
        J.showMask();
        var urldelectPatientMRFile = '<?php echo $urldelectPatientMRFile ?>' + id;
        $.ajax({
            url: urldelectPatientMRFile,
            beforeSend: function () {

            },
            success: function (data) {
                if (data.status == 'ok') {
                    domLi.remove();
                    J.showToast('删除成功!', '', 1000);
                } else {
                    //console.log(data.error);
                    J.showToast(data.error, '', 3000);
                }
            },
            complete: function () {
                J.hideMask();
            }
        });
    }
</script>