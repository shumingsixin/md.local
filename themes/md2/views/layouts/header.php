<?php
$urlDocView = $this->createUrl('doctor/view');
?>
<header>
    <?php
    if (isset($addBackBtn) && $addBackBtn == true) {
        echo '<nav class="left"><a href="#" class="color-000" data-target="back" data-icon="previous"></a></nav>';
    } else {
        echo '<nav class="left" style="display:none;"><a href="#" class="color-000" data-target="back" data-icon="previous"></a></nav>';
    }
    ?>
    <h1 class="title color-000"><?php echo $this->pageTitle; ?></h1>
    <nav class="right">
        <a class="header-user" data-target="link" data-icon="user" href="<?php echo $urlDocView ?>"><i class="icon user"></i></a>
    </nav>
</header>