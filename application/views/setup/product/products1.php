<?= show_notification(); ?>

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
                            <div class="box-content-padless">

                                <?php if (!empty($products)): ?>
                                    <table class="table table-striped table-hover dataTable">
                                        <thead>
                                            <tr>
                                                <th>&nbsp;</th>
                                                <th>Product</th>
                                                <th>Sub Category</th>
                                                <th>Source</th>
                                                <th>Variety</th>
                                                <th>Status</th>
                                                <?php if ($this->user_auth_lib->have_perm('setup:edit_product')): ?>
                                                <th>Action</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sn = 0;
                                            foreach ($products as $product):
                                                ?>
                                                <tr>
                                                    <td class="img">
                                                        <?php if ($product->image_url !== ''): ?>
                                                            <img ng-src="<?=$product->image_url?>" width="40" height="40" src="<?=$product->image_url?>">
                                                       <?php endif; ?>
                                                        
                                                    </td>
                                                    <td>
                                                        <a href="<?= site_url('/setup/view_product/' . $product->product_id . '/'. trim(preg_replace('/[^A-Z0-9]+/i', '-', $product->product_name), '-')) ?>">
                                                            <?= ucfirst($product->product_name); ?>
                                                        </a>
                                                    </td>
                                                    <td> <?= ucfirst($product->sub_category); ?>  </td>
                                                    <td>
                                                        <?php
                                                        if (!empty($product->sources)):
                                                            foreach ($product->sources as $source):
                                                                ?>
                                                                <span class="label label-green"><?= $source->source ?></span>
                                                                <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                                <?php if ($this->user_auth_lib->have_perm('setup:edit_product')): ?>
                                                        <a href="#" onclick="return false;" ng-click="addSource('<?= $product->product_id; ?>')">add source</a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>

                                                        <?php
                                                        if (!empty($product->varieties)):
                                                            foreach ($product->varieties as $variety):
                                                                ?>
                                                                <span class="label label-green"><?= $variety->variety ?></span>
                                                                <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                                <?php if ($this->user_auth_lib->have_perm('setup:edit_product')): ?>
                                                        <a href="#" onclick="return false;" ng-click="addVariety('<?= $product->product_id; ?>')">add variety</a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span class="label label-<?= $product->status ? 'success' : 'warning'; ?>">
                                                            <?= $this->user_auth_lib->get_statuses()[$product->status] ?>
                                                        </span>
                                                    </td>
                                                    <?php if ($this->user_auth_lib->have_perm('setup:edit_product')): ?>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">Action <span class="caret"></span></a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a href="<?= site_url('/setup/edit_product/' . $product->product_id . '/'. trim(preg_replace('/[^A-Z0-9]+/i', '-', $product->product_name), '-')) ?>">
                                                                    Edit</a>
                                                                </li>
                                                                <li>
                                                                    <a href="<?= site_url('/setup/view_product/' . $product->product_id . '/'. trim(preg_replace('/[^A-Z0-9]+/i', '-', $product->product_name), '-')) ?>">
                                                                    View Details</a>
                                                                </li>
                                                                <li>
                                                                    <a class="ToggleProduct" data-enabled='<?= $product->status ?>' href="<?= site_url('setup/changeProductStatus/' . $product->product_id . '/' . $product->status) ?>"><?= $product->status ? 'Disable' : 'Enable'; ?></a>
                                                                </li>
                                                                <li>
                                                                    <a class="deleteProduct" href="<?= site_url('setup/deleteProduct/' . $product->product_id) ?>">Delete</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; ?>
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

</div>
<script src="/js/product.js" type="text/javascript"></script>