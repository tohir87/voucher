<div class="modal hide fade" id="add_variety" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Add Product Variety</h4>
    </div>

    <form name="frmadd" id="frmadd" method="post" action="<?= site_url('/setup/add_product_variety')?>" class="form-horizontal form-bordered">
        <div class="modal-body nopadding">
            <div class="control-group" style="margin-left: 30px">
                <label for="group_id" class="control-label">Variety</label>
                <div class="controls">
                    <select required name="variety_id[]" id="variety_id" class="select2-me input-xlarge" multiple>
                        <?php
                        if (!empty($sources)):
                            foreach ($varieties as $variety):
                                ?>
                                <option value="<?= $variety->variety_id; ?>"><?= $variety->variety; ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="modal-footer" id="footer_modal">
            <input type="hidden" id="variety_product_id" name="product_id" value="" />
            <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
            <input type="submit" class="btn btn-primary" value="Add" />
        </div>
    </form>
</div>