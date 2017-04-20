<script>
    viewProduct_url = "<?php echo site_url('setup/view_product'); ?>/";
</script>

<?= show_notification(); ?>
<div class="page-header">
    <div class="pull-left">
        <a class="btn btn-warning" href="<?= site_url('/setup/products'); ?>">
            <i class="icons icon-chevron-left"></i> Back
        </a>
        <select class="select2-me input-xxlarge product">
            <option selected="selected"> &nbsp;</option>
            <?php
            if (!empty($products)) :
                $sel = '';
                foreach ($products as $p) :
                    if ($p->product_id == $this->uri->segment(3)) :
                        ?>
                        <option class="product" value="<?= $p->product_id; ?>" data-product_name="<?= trim(preg_replace('/[^A-Z0-9]+/i', '-', $p->product_name), '-') ?>" selected="selected"> <?= ucfirst($p->product_name); ?></option>
                    <?php else : ?>
                        <option class="product" value="<?= $p->product_id; ?>" data-product_name="<?= trim(preg_replace('/[^A-Z0-9]+/i', '-', $p->product_name), '-') ?>" > <?= ucfirst($p->product_name); ?></option> 
                    <?php
                    endif;
                endforeach;
            endif;
            ?>
        </select>
    </div>
    <div class="clearfix"></div>
</div>

<div class="row-fluid">
    <div class="span2">
        <div class="box">
            <div class="box-title" style="border:1px solid #CCCCCC;height:210px;padding:0;">
                <div class="row-fluid" style="height:180px;overflow:hidden">
                    <?php
                    if ($product->image_name != '') {
                        $product_pic_url = $product->image_url;
                    } else {
                        $product_pic_url = '/img/profile-default.jpg';
                    }
                    ?>
                    <img src="<?= $product_pic_url; ?>" />
                </div>
                <div class="row-fluid">
                    <?php if ($this->user_auth_lib->have_perm('setup:edit_product')): ?>
                        <div class="btn-group span12">
                            <a class="btn btn-primary dropdown-toggle span12" data-toggle="dropdown" href="#"><span class="caret"></span> Edit </a>
                            <ul class="dropdown-menu dropdown-primary">
                                <li>
                                    <a href="<?= site_url('/setup/edit_product_image/' . $this->uri->segment(3) . '/' . $this->uri->segment(4)); ?>">Edit Now</a>
                                </li>
                                <?php if ($product->image_name): ?>
                                    <li>
                                        <a href="<?= site_url('/setup/removeProductImage/' . $this->uri->segment(3)); ?>" class="remove_product_image">Remove Image</a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </div>
                    <?php endif; ?>
                </div>	
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h5>Sources</h5>
                    </div>
                    <div class="box-content-padless">
                        <?php
                        if (!empty($product->sources)):
                            foreach ($product->sources as $source):
                                ?>
                                <?= ucfirst($source->source) ?>
                                <?php if ($this->user_auth_lib->have_perm('setup:edit_product')): ?>
                                    <a href="<?= site_url('/setup/removeProductSouce/' . $source->product_source_id) ?>" class="remove_source pull-right" data-title="<?= ucfirst($source->source) ?>" title="Click here to remove this source">
                                        <i class="icons icon-trash"></i>
                                    </a>
                                <?php endif; ?>
                                <br>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="box">
                    <div class="box-title">
                        <h5>Varieties</h5>
                    </div>
                    <div class="box-content-padless">
                        <?php
                        if (!empty($product->varieties)):
                            foreach ($product->varieties as $variety):
                                ?>
                                <?= $variety->variety ?>
                                <?php if ($this->user_auth_lib->have_perm('setup:edit_product')): ?>
                                    <a href="<?= site_url('/setup/removeProductVariety/' . $variety->product_variety_id) ?>" class="remove_variety pull-right" data-title="<?= ucfirst($variety->variety) ?>" title="Click here to remove this variety">
                                        <i class="icons icon-trash"></i>
                                    </a>
                                <?php endif; ?>
                                <br>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'product_contents/_wholesale_metrics.php'; ?>
        <?php include 'product_contents/_retail_metrics.php'; ?>
        <?php include 'product_contents/_metrics_info.php'; ?>

    </div>

    <div class="span10">
        <div class="box box-bordered box-color">
            <div class="box-title">
                <h3><?= ucfirst($product->product_name); ?></h3>

                <?php if ((int) $product->status > 0) : ?>
                    <div class="btn-group pull-right" style="margin-right: 5px">
                        <a class="btn btn-primary btn-warning dropdown-toggle span12" data-toggle="dropdown" href="#"><span class="caret"></span> Add Price </a>
                        <ul class="dropdown-menu dropdown-primary">
                            <li>
                                <a href="<?= site_url('/market/addPrice/' . $product->product_id . '/' . $this->uri->segment(4)) ?>">New Price</a>
                            </li>
                            <?php if ($have_price): ?>
                                <li>
                                    <a class="addRecentPrice" href="#">Use Most Recent</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div class="box-content-padless">

                <div style="padding: 10px 10px">
                    <h3>Description</h3> 

                    <?= $product->product_desc ?>
                </div>

                <hr>

                <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <?php include '_view_product_filter.php'; ?>
                            <?php
                            if (!empty($prices)):
                                ?>

                                <div class="box-content-padless">
                                    <div class="alert alert-error hide" id="select_items_msg">
                                        <b>Please select at least one price to delete.</b>
                                    </div>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <?php if ($this->user_auth_lib->have_perm('market:delete_price')): ?>
                                                    <th>&nbsp;</th>
                                                <?php endif; ?>
                                                <th>Date</th>
                                                <th>Market</th>
                                                <th>Source</th>
                                                <th>Whole Sale</th>
                                                <th>Retail</th>
                                                <?php if ($this->user_auth_lib->have_perm('market:delete_price')): ?>
                                                    <th>&nbsp;</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($prices as $price): ?>
                                                <tr>
                                                    <?php if ($this->user_auth_lib->have_perm('market:delete_price')): ?>
                                                        <td>
                                                            <input type="checkbox" name="market_price_id[]" data-market_price_id="<?= $price->market_price_id; ?>" class="_item_checkbox" />
                                                        </td>
                                                    <?php endif; ?>
                                                    <td><?= date('d-M-Y', strtotime($price->market_date)) ?></td>
                                                    <td><?= $price->market_name ?></td>
                                                    <td>
                                                        <?= $price->source ?> 
                                                        <?php if ($price->variety): ?>
                                                            <span class="label label-orange"><?= $price->variety ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($price->wholesale)): ?>
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Metric</th>
                                                                        <th>High</th>
                                                                        <th>Low</th>
                                                                        <th>Ave</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($price->wholesale as $wholesale): ?>
                                                                        <tr>
                                                                            <td><?= $wholesale->metric ?></td>
                                                                            <td><?= number_format($wholesale->price_high, 2) ?></td>
                                                                            <td><?= number_format($wholesale->price_low, 2) ?></td>
                                                                            <td><?= number_format($wholesale->price_ave, 2) ?></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>

                                                                </tbody>

                                                            </table>
                                                        <?php endif;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($price->retail)): ?>
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Metric</th>
                                                                        <th>High</th>
                                                                        <th>Low</th>
                                                                        <th>Ave</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($price->retail as $retail): ?>
                                                                        <tr>
                                                                            <td><?= $retail->metric ?></td>
                                                                            <td><?= number_format($retail->price_high, 2) ?></td>
                                                                            <td><?= number_format($retail->price_low, 2) ?></td>
                                                                            <td><?= number_format($retail->price_ave, 2) ?></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>

                                                                </tbody>

                                                            </table>
                                                        <?php endif;
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php if ($this->user_auth_lib->have_perm('market:edit_price')): ?>
                                                            <a href="<?= site_url('/market/editMarketPrice/' . $price->market_price_id . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4)) ?>" title="Click here to edit this price"><i class="icons icon-edit"></i> </a>
                                                        <?php endif; ?>
                                                        <?php if ($this->user_auth_lib->have_perm('market:delete_price')): ?>
                                                            <a class="delete_price" href="<?= site_url('/market/deleteMarketPrice/' . $price->market_price_id) ?>" title="Click here to delete this price"><i class="icons icon-trash"></i> </a>
                                                        <?php endif; ?>
                                                    </td>

                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                </div>
                                <?php
                            else:
                                $link = site_url('/market/addPrice/' . $product->product_id);
                                echo show_no_data("No price has been added yet for this product. <a href={$link}>Click here to add price</a>");
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '_addRecentPrice_modal.php'; ?>

<div class="modal hide fade" id="delete_bulk_price_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <form method="POST" action="<?php echo site_url('/market/delete_bulk_price'); ?>" id="delete_price_frm">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title" id="myModalLabel">Delete Prices</h4>
        </div>
        <div class="modal-body">
            <p>
                Are you sure you want to delete the selected price(s)?
            </p>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="market_ids" id="market_ids" />
            <button data-dismiss="modal" class="btn" aria-hidden="true">Cancel</button>
            <button data-id_dept="" class="btn btn-primary" id="reset_password_btn">Delete</button>
        </div>
    </form>
</div>

<script src="/js/view_product.js"></script>