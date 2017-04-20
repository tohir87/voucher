
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

<div ng-app="report" ng-controller="ListCtrl" ng-cloak="" cg-busy="productPromise">
    <?php include '_filter_box_2.php'; ?>


    <div class="row-fluid" ng-if="showContainer">
        <div class="span12">
            <div class="box">
                <div class="box-title">
                    <h3>Source/State Activity [All Markets]</h3>
                </div>
                <div class="box-content-padless">
                    <div id="pieContainer" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row-fluid" ng-if="showContainer">
        <div class="span6">
            <div class="box">
                <div class="box-title">
                    <h3>Oyingbo Market</h3>
                </div>
                <div class="box-content-padless">
                    <div id="pieContainer_1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="box">
                <div class="box-title">
                    <h3>Mile12 Market</h3>
                </div>
                <div class="box-content-padless">
                    <div id="pieContainer_2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row-fluid" ng-if="showContainer">
        <div class="span6">
            <div class="box">
                <div class="box-title">
                    <h3>Ketu Market</h3>
                </div>
                <div class="box-content-padless">
                    <div id="pieContainer_3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="box">
                <div class="box-title">
                    <h3>Iddo Market</h3>
                </div>
                <div class="box-content-padless">
                    <div id="pieContainer_4" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>
    
</div>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
