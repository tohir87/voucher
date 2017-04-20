<!-- Check if session message as message -->
<?= show_notification(); ?>

<div class="page-header">
    <div class="pull-left">
        <a href="<?= site_url('/setup/view_product/' . $this->uri->segment(4) . '/' . $this->uri->segment(5)) ?>" class="btn btn-warning">
            <i class="icons icon-chevron-left"></i>
            Back
        </a>
        <h1><?= $product_info->market_name; ?> | <?php echo "{$product_name}" ?> | <?= date('d-M-Y', strtotime($product_info->market_date)); ?></h1>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="box box-bordered box-color">
            <div class="box-title">
                <h3>Wholesale</h3>
                <a class="btn btn-warning pull-right" href="<?= site_url('/market/add_wholesale_price/' . $this->uri->segment(3) . '/' . $product_id . '/' . $product_name) ?>" style="margin-right: 5px">Add Wholesale Price</a>
            </div>
            <div class="box-content-padless">
                <?php if (!empty($wholesale_prices)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 25%">Metric</th>
                                <th style="width: 20%">Price High</th>
                                <th style="width: 20%">Price Low</th>
                                <th style="width: 20%">Average</th>
                                <th style="width: 15%">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($wholesale_prices as $wholesale): ?>
                                <tr>
                                    <td><?= $wholesale->metric ?></td>
                                    <td><?= number_format($wholesale->price_high, 2); ?></td>
                                    <td><?= number_format($wholesale->price_low, 2); ?></td>
                                    <td><?= number_format($wholesale->price_ave, 2); ?></td>
                                    <td>
                                        <a class="edit_p" title="Click here to edit this price" href="<?= site_url('/market/edit_wholesale_price/' . $wholesale->id . '/' . $product_id. '/'.  $product_name . '/'  . $this->uri->segment(3)) ?>">
                                            <i class="icons icon-edit"></i> Edit</a> |
                                        <a title="Click here to delete this price" href="<?= site_url('/market/delete_wholesale_price/' . $wholesale->id) ?>" class='confirm_del'>
                                            <i  class="icons icon-trash"></i> Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>

<div class="row-fluid">
    <div class="span12">
        <div class="box box-bordered box-color">
            <div class="box-title">
                <h3>Retail</h3>
                <a class="btn btn-warning pull-right" href="<?= site_url('/market/add_retail_price/' . $this->uri->segment(3) . '/' . $product_id . '/' . $product_name) ?>" style="margin-right: 5px">Add Retail Price</a>
            </div>
            <div class="box-content-padless">
                <?php if (!empty($retail_prices)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 25%">Metric</th>
                                <th style="width: 20%">Price High</th>
                                <th style="width: 20%">Price Low</th>
                                <th style="width: 20%">Average</th>
                                <th style="width: 15%">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($retail_prices as $retail): ?>
                                <tr>
                                    <td><?= $retail->metric ?></td>
                                    <td><?= number_format($retail->price_high, 2); ?></td>
                                    <td><?= number_format($retail->price_low, 2); ?></td>
                                    <td><?= number_format($retail->price_ave, 2); ?></td>
                                    <td>
                                        <a class="edit_p" title="Click here to edit this price" href="<?= site_url('/market/edit_retail_price/' . $retail->id . '/' . $product_id . '/' . $product_name . '/'  . $this->uri->segment(3)) ?>">
                                            <i class="icons icon-edit"></i> Edit</a> |
                                        <a class="confirm_del" title="Click here to delete this price" href="<?= site_url('/market/delete_retail_price/' . $retail->id) ?>">
                                            <i class="icons icon-trash"></i> Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

 <div class="modal hide fade" id="modal_edit_price" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" ></div>

<script>
    $(function () {
        $('body').delegate('.confirm_del', 'click', function (e) {
            e.preventDefault();
            var h = this.href;
            var message = 'Are you sure you want to delete this price ?';
            CTM.doConfirm({
                title: 'Confirm Price Delete',
                message: message,
                onAccept: function () {
                    window.location = h;
                }
            });
        });
    });

    $('body').delegate('.edit_p', 'click', function (evt) {
        evt.preventDefault();

        $('#modal_edit_price').modal('show');
        $('#modal_edit_price').html('<div class="loaderBox"><img src="/img/gif-load.gif" ></div>');

        var page = $(this).attr("href");
        $.get(page, function (html) {

            $('#modal_edit_price').html('');
            $('#modal_edit_price').html(html);
            $('#modal_edit_price').modal('show').fadeIn();
        });
        return false;
    });
</script>