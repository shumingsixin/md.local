<?php
Yii::app()->clientScript->registerCssFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/webuploader/css/webuploader.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/js/webuploader/css/webuploader.custom.css');
//Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/bootstrap.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/jquery.form.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/jquery.validate.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/js/webuploader/js/webuploader.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom/booking.js', CClientScript::POS_END);
?>
<style>
    .ui-field-contain a.ui-link{position: absolute;margin: 20px 0 0 141px;z-index: 99;font-size: 16px;}
    #tipPage-popup.ui-popup-container{max-width: 375px;width: 100%;bottom:16em!important;top:auto!important;}
    .ui-popup-container{max-width: 375px;width: 100%;bottom:16em!important;top:auto!important;position: fixed;}
    #uploader .queueList{max-height:160px;overflow-y:scroll;overflow-x:hidden;}
</style>
<div id="uploader">
    <div class="queueList">
        <div id="dndArea" class="placeholder">
            <!-- btn 选择图片 -->
            <div id="filePicker"></div>
        <!-- <p>或将照片拖到这里，单次最多可选10张</p>-->
        </div>
        <ul class="filelist"></ul>
    </div>
    <div class="statusBar clearfix" style="display:none;">
        <div class="progress" style="display: none;">
            <span class="text">0%</span>
            <span class="percentage" style="width: 0%;"></span>
        </div>
        <div class="info">共0张（0B），已上传0张</div>
        <div class="">
            <!-- btn 继续添加 -->
            <div id="filePicker2" class="pull-right"></div>                          

        </div>
    </div>
    <!--一开始就显示提交按钮就注释上面的提交 取消下面的注释 -->
    <!-- <div class="statusBar uploadBtn">提交</div>-->
</div>