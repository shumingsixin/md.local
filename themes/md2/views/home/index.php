<?php
/**
 * $data.
 */
$this->setPageID('pMobile');
$this->setPageTitle('名医主刀');

$urlApiAppNav1 = $this->createAbsoluteUrl('/api/list', array('model' => 'appnav1'));

$urlHospital = $this->createUrl('hospital/index', array('addBackBtn' => 1));
$urlOverseas = $this->createUrl('overseas/index', array('addBackBtn' => 1));

$furl = $this->createUrl('faculty/view');
$tUrl = $this->createUrl('expertteam/view');
$urlResImage = Yii::app()->theme->baseUrl . "/images/";
?>

<div id="<?php echo $this->getPageID(); ?>" class="home-page" data-home="true" data-role="page" data-title="<?php echo $this->getPageTitle(); ?>" data-nav-rel="#f-nav-home">  
    <div data-role="content" class="padtop1 bordertop">

        Home Page.
        <?php 
        //var_dump(Yii::app()->user->isDoctor());
        //var_dump(Yii::app()->user);?>

    </div>     
    <script>
        $(document).ready(function () {
        });
    </script>
</div>
