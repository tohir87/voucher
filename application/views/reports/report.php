<script>
    var downloadUrl = '<?php site_url('/report/productReportDownload') ?>';
</script>
<link href="/css/angular-busy.min.css" rel="stylesheet" type="text/css"/>
<script src="/js/angular-busy.min.js"></script>
<script src="/js/angular-datatables-all.js" type="text/javascript"></script>
<script src="/js/analytics.js" type="text/javascript"></script>

<!-- Check if session message as message -->
<?= show_notification(); ?>

<div class="page-header">
    <div class="pull-left">
        <h1>Reports &AMP; Analytics</h1>
    </div>
</div>

<?php include '_report_tab.php'; ?>

<div ng-app="report" ng-controller="ListCtrl">

    <?php include '_filter_box.php'; ?>


    <div class="box">
        <div class="row-fluid">
            <div class="box">
                <div class="span12">
                    <div class="box box-bordered">
                        <div class="box-title">
                            <h3><i class="icon-calendar"></i>Report</h3>
                            <?php if($this->user_auth_lib->is_super_admin()): ?>
                            <a class="btn btn-success pull-right" ng-click="downloadResult()" style="margin-right: 5px"> 
                                <i class="icons icon-download-alt"></i> Download Excel
                            </a>
                            <?php endif; ?>
                        </div>
                        <div class="box-content nopadding"  cg-busy="employeesPromise">

                            <table class="table table-user table-hover table-nomargin table-condensed" datatable="ng" dt-options="dtOptions" dt-column-defs='dtColumnDefs'>
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th class='hidden-1024'>Market</th>
                                        <th class='hidden-480'>Source</th>
                                        <th class='hidden-480'>
                                            Wholesale 
                                        </th>
                                        <th class='hidden-480'>Retail</th>
                                        <th class='hidden-480'>Date</th>
                                        <?php if ($this->user_auth_lib->have_perm('setup:add_remark')): ?>
                                            <th class=''>&nbsp;</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody ng-cloak="">
                                    <tr ng-repeat="product in products track by $index">
                                        <td>{{product.product_name}}</td>
                                        <td>{{product.market_name}}</td>
                                        <td>{{product.source}} <span class="label label-orange">{{product.variety}}</span></td>
                                        <td>
                                            <table class="table">
                                                <tr ng-repeat="wholesale in product.wholesale">
                                                    <td>{{wholesale.metric}}</td>
                                                    <td title="price high">{{wholesale.price_high| currency : ''}}</td>
                                                    <td title="price low">{{wholesale.price_low| currency : ''}}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table class="table">
                                                <tr ng-repeat="retail in product.retail">
                                                    <td>{{retail.metric}}</td>
                                                    <td title="price high">{{retail.price_high| currency : ''}}</td>
                                                    <td title="price low">{{retail.price_low| currency : ''}}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            {{formatDate(product.market_date) | date:"dd-MMM-yyyy"}} 
                                        </td>
                                        <?php if ($this->user_auth_lib->have_perm('setup:add_remark')): ?>
                                            <td>
                                                <a title="Click here to edit remark" href="<?= site_url('/report/editRemark') ?>/{{product.market_price_id}}">
                                                    <i class="icons icon-edit"></i>
                                                </a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="modal hide fade" id="select_product" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title" id="myModalLabel">Missing Product</h4>
        </div>
        <div class="modal-body">
            <p>Pls, select a product</p>
        </div>
        <div class="modal-footer" id="footer_modal">
            <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Ok</button>
        </div>
    </div>


</div>