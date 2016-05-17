<!DOCTYPE html> 
<html lang="zh" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta charset="utf-8" />
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="pragma" content="no-cache" />
        <title><?php echo $this->pageTitle; ?></title>
        <meta name="keywords" content="<?php echo $this->htmlMetaKeywords; ?>" />
        <meta name="description" content="<?php echo $this->htmlMetaDescription; ?>" />
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
        <!--<meta http-equiv="cache-control" max-age="600" />-->
        <link rel="shortcut icon" type="image/ico" href="http://myzd.oss-cn-hangzhou.aliyuncs.com/static/mobile/css/icons/favicon.ico" />
        <?php
        Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/Jingle.min.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/form.css?ts=' . time());
        Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/app.css');
        Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/md.css?ts=' . time());
//        Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/common.min.css?ts=' . time());

        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/lib/zepto.min.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/lib/iscroll.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/lib/template.min.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/lib/zepto.touch2mouse.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/lib/Jingle.custom.js?ts=' . time(), CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/lib/jsencrypt.js?ts=' . time(), CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/app/app.js', CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/main.js?ts=' . time(), CClientScript::POS_END);
//        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/common.min.js?ts=' . time(), CClientScript::POS_END);
        ?>
    </head>
    <body>
        <?php
        if ($this->showHeader()) {
            $this->renderPartial('//layouts/header');
        }
        ?>
        <!-- /header -->

        <?php
        echo $content;
        ?>  
        <!-- /content -->
        <?php
        if ($this->showFooter()) {
            //       $this->renderPartial('//layouts/footer');
        }
        ?>
        <!-- /footer -->
    </body>
</html>