<div class="modal hide fade" id="add_product" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Add Product to <?= ucfirst($market_info->market_name)?> market</h4>
    </div>

    <form name="frmadd" id="frmadd" method="post" action="" class="form-horizontal form-bordered">
        <div class="modal-body nopadding" style="min-height: 200px">
               
                <div class="control-group">
                    <label for="product_id" class="control-label">Product (Select Multiple):</label>
                    <div class="controls">
                        <select required name="product_id[]" id="product_id" class="select2-me input-xlarge" multiple>
                            <?php
                            if (!empty($allProducts)):
                                foreach ($allProducts as $p):
                                    ?>
                                    <option value="<?= $p->product_id; ?>"><?= $p->product_name; ?></option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>
        </div>

        <div class="modal-footer" id="footer_modal">
            <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
            <input type="submit" class="btn btn-primary" value="Add" />
        </div>
    </form>
</div>