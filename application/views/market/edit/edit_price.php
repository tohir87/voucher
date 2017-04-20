<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4><?= $title ?> <br>
        <?= $product_info->market_name; ?> | <?= $product_info->product_name ?> | <?= date('d-M-Y', strtotime($product_info->market_date)); ?>
    </h4>
</div>

<form class="form form-horizontal form-bordered" method="post" action="<?= $form_action; ?>">
    <div class="modal-body">
        <div class="control-group">
            <label class="control-label">Price High</label>
            <div class="controls">
                <input required type="text" name="price_high" id="price_high" value="<?= $price[0]->price_high; ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Price Low</label>
            <div class="controls">
                <input required type="text" name="price_low" id="price_low" value="<?= $price[0]->price_low; ?>"/>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
        <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
    </div>
</form>