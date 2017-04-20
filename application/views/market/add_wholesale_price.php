<div class="page-header">
    <div class="pull-left">
        <a class="btn btn-warning" href="<?= site_url('/market/editMarketPrice/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/'. $this->uri->segment(5)); ?>">
            <i class="icons icon-chevron-left"></i> Back
        </a>
        <h1> 
        <?= $product_info->market_name; ?> | <?= $title ?> | <?= date('d-M-Y', strtotime($product_info->market_date)); ?></h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>


<div class="row-fluid">
    <div class="span12">
        <div class="box box-bordered">
            <div class="box-title">
                <h3> <img ng-src="<?= $product_details->image_url ?>" width="40" height="40" src="<?= $product_details->image_url ?>">
                    <?= ucfirst($product_details->product_name) ?></h3>
            </div>
            <div class="box-content-padless">
                <form method="post" class="form-horizontal">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <?php if ($toEnable == 'wholesale'): ?>
                                    <th>WHOLESALE PRICE</th>
                                <?php else: ?>
                                    <th>RETAIL PRICE</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php if ($toEnable == 'wholesale'): ?>
                                    <td>
                                        <table class="table">
                                            <?php
                                            if (!empty($product_w_metrics)):
                                                foreach ($product_w_metrics as $wm):
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $wm->metric ?>
                                                            <input type="hidden" name="metric_whole_sale_id[]" value="<?= $wm->metric_wholesale_id; ?>" />
                                                        </td>
                                                        <td>
                                                            <div class="input-prepend">
                                                                <span class="add-on">N</span>
                                                                <input type="text" name="price_wholesale_high[]" class="input-small" placeholder="High" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-prepend">
                                                                <span class="add-on">N</span>
                                                                <input type="text" name="price_wholesale_low[]" class="input-small" placeholder="Low" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </table>
                                    </td>
                                <?php else: ?>
                                    <td>
                                        <table class="table" >
                                            <?php
                                            if (!empty($product_r_metrics)):
                                                foreach ($product_r_metrics as $rm):
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $rm->metric ?>
                                                            <input type="hidden" name="metric_retail_id[]" value="<?= $rm->metric_retail_id; ?>" />
                                                        </td>
                                                        <td>

                                                            <div class="input-prepend">
                                                                <span class="add-on">N</span>
                                                                <input type="text" name="price_retail_high[]" class="input-small" placeholder="High" />
                                                            </div>

                                                        </td>
                                                        <td>

                                                            <div class="input-prepend">
                                                                <span class="add-on">N</span>
                                                                <input type="text" name="price_retail_low[]" class="input-small" placeholder="Low" />
                                                            </div>

                                                        </td>
                                                    </tr>
                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </table>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-actions">
                        <button type="submit"  class="btn btn-primary btn-large">Add Price</button>
                        <button type="submit"  class="btn btn-danger btn-large">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>