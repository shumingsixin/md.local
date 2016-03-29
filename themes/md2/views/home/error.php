<style>.page-container-full{background-color: #fff;}</style>
<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - 访问错误';

?>

<h3 class="strong">访问错误</h3>
<br />
<div class="alert alert-danger h4" role="alert">您所访问的页面不存在。</div>
<div class="mt-sm-50"><a class="btn btn-success" rel="external" href="<?php echo $this->getHomeUrl();?>"><i class="glyphicon glyphicon-arrow-left">&nbsp;</i>返回<?php echo Yii::app()->name;?>首页</a></div>