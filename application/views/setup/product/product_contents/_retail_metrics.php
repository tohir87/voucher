<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h5>Retail metrics</h5>
            </div>
            <div class="box-content-padless">
                <?php
                if (!empty($product->retail_metrics)):
                    foreach ($product->retail_metrics as $retail):
                        ?>
                        <?= $retail->metric ?> 
                        <?php if ($this->user_auth_lib->have_perm('setup:edit_product')): ?>
                            <a href="<?= site_url('/setup/removeProductMetrics/retail/' . $retail->product_retail_metric_id) ?>" class="remove_metric pull-right" data-title="<?= ucfirst($retail->metric) ?>" title="Click here to remove this metric">
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