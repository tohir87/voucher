<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!isset($activity_bar)) {
    $activity_bar = true;
}

if ($activity_bar == true) {
    $content_vlass = 'span12';
} else {
    $content_vlass = 'span12';
}

$isMinimal = FALSE;
$showSideBar = FALSE;
?>
<?php include 'header.php'; ?>
<body style="overflow-x: hidden">

    <div class="wrap" id="loader">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>

    <?php
    if (!$isMinimal) {
        include 'top_menu.php';
    }
    ?>


    <div class="container-fluid" id="content">
        
        <div id="main">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="<?php echo $content_vlass; ?>">
                        <!-- Check for Internet connectivity -->
                        <div class="show_content"> </div>
                        <?php
                        if (is_callable($page_content)) {
                            call_user_func($page_content);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!$isMinimal): ?>
        <?php include 'footer.php'; ?>
    <?php endif; ?>

    <div class="modal hide fade modal-full" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="pay_loader" style="z-index: 4000px">

        <div class="loaderBox" style="margin-top:10px; margin-buttom:10px">
            <p align="center"><img src="/img/ctm_logo_sm.png" ></p>
            <p align="center">&nbsp;processing...</p>
            <p align="center"><img src="/img/gif-load.gif" ></p>
        </div>
    </div>
</body>
</html>