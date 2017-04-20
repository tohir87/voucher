<?= show_notification();
?>
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


<div class="box">
    <div class="box-content nopadding">
        <?php include APPPATH . 'views/setup/_setup_tab.php'; ?>
        <a class="btn btn-warning" href="<?= site_url('setup/markets') ?>">
            <i class="icons icon-chevron-left"></i> Back
        </a>
        <select id="cboMarket" class="select2-me input-xxlarge" >
            <?php
            if (!empty($markets)):
                $sel = '';
                foreach ($markets as $market):
                    if ($market->market_id == $this->uri->segment(4)):
                        $sel = 'selected';
                    else:
                        $sel = '';
                    endif;
                    ?>
                    <option value="<?= $market->market_id; ?>" <?= $sel; ?>><?= $market->market_name ?></option>
                    <?php
                endforeach;
            endif;
            ?>
            <option></option>
        </select>
        <div class="tab-content"> 
            <div class="tab-pane active" id="userList">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="icon-bar-chart"></i>
                                    Products in <?= $market_info->market_name ?> Market.
                                </h3>
                                <?php if ($this->user_auth_lib->have_perm('setup:add_market')): ?>
                                    <a href="#" onclick="return false;" class="btn btn-primary add_product pull-right" style="margin-right: 10px">
                                        <i class="icons icon-plus-sign"></i> Add Product
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
                                                <th>...</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($products as $product):
                                                ?>
                                                <tr>
                                                    <td class="img" style="width: 50px">
                                                        <img width="40" height="40" src="<?= $product->image_url ?>" alt="<?= $product->product_name; ?>">

                                                    </td>
                                                    <td>
                                                        <a href="<?= site_url('/setup/view_product/'. $product->product_id . '/' . $product->product_name); ?>">
                                                            <?= $product->product_name; ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a title="Delete product from market" href="<?= site_url('/setup/deleteMarketProduct/' . $product->market_product_id) ?>" class="delete_product">
                                                            <i class="icons icon-trash"></i>
                                                            Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <?php
                                else:
                                    echo show_no_data("No product found in {$market_info->market_name} market.");
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '_add_product.php'; ?>

    <div class="modal hide fade" id="modal_edit_market" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" ></div>

</div>

<script>
    $(function () {
        $('body').delegate('.delete_product', 'click', function (e) {
            e.preventDefault();
            var h = this.href;
            var message = 'Are you sure you want to delete this product ?';
            CTM.doConfirm({
                title: 'Confirm Delete',
                message: message,
                onAccept: function () {
                    window.location = h;
                }
            });
        });
    });

    $('#cboMarket').change(function (e) {
        e.preventDefault();
        var market_id = $(this).val();
        if (market_id.trim() === '') {
            return false;
        }
        window.location.href = '<?php echo site_url('/setup/markets/products/'); ?>/' + market_id;
    });


    $('body').delegate('.add_product', 'click', function (evt) {
        evt.preventDefault();
        $('.chzn-container').css('width', '30%');
        $('.chzn-drop').css('width', '100%');
        $('.chzn-search > input').css('width', '85%');
        $('#add_product').modal('show');
        $('#modal_edit_market').html('<div class="loaderBox"><img src="/img/gif-load.gif" ></div>');


        return false;
    });
</script>