<?= show_notification(); ?>
<script>
    var category_id_ = '';
    var sub_category_id_ = '';
    window.productConfig = window.productConfig || {};
    window.productConfig.statuses = <?= json_encode($this->user_auth_lib->get_statuses()); ?>;
    window.productConfig.canEdit = <?= json_encode(!!$this->user_auth_lib->have_perm('setup:edit_product')); ?>;
</script>

<link href="/css/angular-busy.min.css" rel="stylesheet" type="text/css"/>
<script src="/js/angular-busy.min.js"></script>
<script src="/js/angular-datatables-all.js" type="text/javascript"></script>
<script src="/js/dirPagination.js"></script>

<div class="page-header">
    <div class="pull-left">
        <h1>Setup</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>

<div class="box" ng-app="products" ng-controller="productCtrl">
    <div class="box-content nopadding">
        <?php include APPPATH . 'views/setup/_setup_tab.php'; ?>

        <div class="tab-content"> 
            <div class="tab-pane active" id="userList">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="icon-bar-chart"></i>
                                    Products
                                </h3>
                                <?php if ($this->user_auth_lib->have_perm('setup:add_product')): ?>
                                    <a href="<?= site_url('setup/add_product') ?>" class="btn btn-primary pull-right" style="margin-right: 10px">
                                        <i class="icons icon-plus-sign"></i> New Product
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="box-content-padless" cg-busy="productPromise">

                                <?php if (!empty($products)): ?>
                                    <table class="table table-user table-hover table-nomargin" datatable="ng" dt-options="dtOptions" dt-column-defs='dtColumnDefs'>
                                        <thead>
                                            <tr>
                                                <th>&nbsp;</th>
                                                <th>Product</th>
                                                <th style="width: 282px;" class="hidden-1024">Source</th>
                                                <th style="width: 282px;" class="hidden-1024">Variety</th>
                                                <th class="hidden-350">Wholesale Metrics</th>
                                                <th class="hidden-350">Retail Metrics</th>
                                                <th>Status</th>
                                                <th ng-if="config.canEdit">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody ng-cloak="">
                                            <tr ng-repeat="product in products">
                                                <td class="img">
                                                    <img ng-src="{{product.image_url}}" width="40" height="40" src="{{product.image_url}}">

                                                </td>
                                                <td>
                                                    <a href="<?= site_url('/setup/view_product') ?>/{{product.product_id}}/{{product.product_name_f}}">
                                                        {{product.product_name}}
                                                    </a><br>
                                                    <span class="muted">{{product.sub_category}}</span>
                                                </td>
                                                <td class="hidden-1024">
                                                    <div ng-repeat="source in product.sources" class="label label-success">
                                                        {{source.source}}
                                                    </div>
                                                    <a href="#" onclick="return false;" ng-click="addSource(product.product_id)">add source</a>
                                                </td>
                                                <td class="hidden-1024">
                                                    <span ng-repeat="v in product.varieties" class="label label-success">
                                                        {{v.variety}}
                                                    </span>
                                                    <a ng-if="config.canEdit" href="#" onclick="return false;" ng-click="addVariety(product.product_id)">add variety</a>

                                                </td>
                                                <td class="hidden-350"> 
                                                 <span ng-repeat="w in product.wholesale_metrics" class="label label-info">
                                                        {{w.metric}}
                                                    </span>
                                                    <a ng-if="config.canEdit" href="#" onclick="return false;" ng-click="addMetric(product.product_id)">add metric</a>
                                                </td>
                                                <td class="hidden-350"> 
                                                 <span ng-repeat="r in product.retail_metrics" class="label label-inverse">
                                                        {{r.metric}}
                                                    </span>
                                                    <a ng-if="config.canEdit" href="#" onclick="return false;" ng-click="addMetric(product.product_id)">add metric</a>
                                                </td>
                                                <td>
                                                    <span class="label label-{{product.status > 0 ? 'success' : 'warning'}}">
                                                        {{config.statuses[product.status]}}
                                                    </span>
                                                </td>
                                                <td ng-if="config.canEdit">
                                                    <div class="btn-group">
                                                        <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="#" onclick="return false;" ng-click="addMetric(product.product_id)">
                                                                    Add Metrics</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= site_url('/setup/edit_product') ?>/{{product.product_id}}/{{product.product_name_f}}">
                                                                    Edit</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?= site_url('/setup/view_product') ?>/{{product.product_id}}/{{product.product_name_f}}">
                                                                    View Details</a>
                                                            </li>
                                                            <li>
                                                                <a class="ToggleProduct" data-enabled="{{product.status}}" href="<?= site_url('setup/changeProductStatus') ?>/{{product.product_id}}/{{product.status}}">
                                                                    {{product.status > 0 ? 'Disable' : 'Enable'}}
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="deleteProduct" href="<?= site_url('setup/deleteProduct') ?>/{{product.product_id}}">Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php
                                else:
                                    echo show_no_data('No products found.');
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '_add_source.php'; ?>
    <?php include '_add_variety.php'; ?>
    <?php include '_add_metrics.php'; ?>

</div>
<script src="/js/product.js" type="text/javascript"></script>