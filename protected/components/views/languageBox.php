<?php echo CHtml::form(); ?>
<div id="langdrop">
    <?php echo CHtml::dropDownList('appLang', $currentLang, array(
        'zh_cn' => '中文', 'en' => 'English'), array('submit' => '')); ?>
</div>
<?php echo CHtml::endForm(); ?>