<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h5>Wholesale metrics</h5>
            </div>
            <div class="box-content-padless">
                <?php
                if (!empty($product->wholesale_metrics)):
                    foreach ($product->wholesale_metrics as $w_sale):
                        ?>
                        <?= $w_sale->metric ?>
                        <?php if ($this->user_auth_lib->have_perm('setup:edit_product')): ?>
                            <a href="<?= site_url('/setup/removeProductMetrics/wholesale/' . $w_sale->product_wholesale_metric_id) ?>" class="remove_metric pull-right" data-title="<?= ucfirst($w_sale->metric) ?>" title="Click here to remove this metric">
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