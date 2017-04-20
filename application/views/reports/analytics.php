<style>
    .highcharts-tooltip span {
        height:auto;
        width:500px;
        overflow:auto;
        white-space:normal !important;
    }
</style>
<link href="/css/angular-busy.min.css" rel="stylesheet" type="text/css"/>
<script src="/js/angular-busy.min.js"></script>
<script src="/js/angular-datatables-all.js" type="text/javascript"></script>
<script src="/js/analytics.js" type="text/javascript"></script>

<!-- Check if session message as message -->
<?= show_notification(); ?>

<div class="page-header">
    <div class="pull-left">

        <h1>Analytics &AMP; Reports</h1>
    </div>
</div>

<?php include '_report_tab.php'; ?>

<div ng-app="report" ng-controller="ListCtrl">
    <?php include '_filter_box.php'; ?>



    <div class="row-fluid">
        <div class="box">
            <div class="box-title">
                <h3>&nbsp;</h3>
            </div>
            <div class="box-content-padless">
                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <div class="box">
                <div class="box-title">
                    <h3>Daily Average Prices</h3>
                </div>
                <div class="box-content-padless">
                    <div id="lineContainer" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    
        <div class="span6">
            <div class="box">
                <div class="box-title">
                    <h3>Distribution by Source</h3>
                </div>
                <div class="box-content-padless">
                    <div id="pieContainer" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row-fluid">
        <div class="span12">
            <div class="box">
            <div class="box-title">
                <h3>Across All Markets</h3>
            </div>
            <div class="box-content-padless">
                <div id="AllMarketContainer" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            </div>
        </div>
        </div>
    </div>
</div>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
