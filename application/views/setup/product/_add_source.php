<div class="modal hide fade" id="add_source" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Add Product Source</h4>
    </div>

    <form name="frmadd" id="frmadd" method="post" action="<?= site_url('/setup/add_product_source')?>" class="form-horizontal form-bordered">
        <div class="modal-body nopadding">
            <div class="control-group" style="margin-left: 30px">
                <label for="group_id" class="control-label">Source</label>
                <div class="controls">
                    <select required name="source_id[]" id="source_id" class="select2-me input-xlarge" multiple>
                        <?php
                        if (!empty($sources)):
                            foreach ($sources as $source):
                                ?>
                                <option value="<?= $source->source_id; ?>"><?= $source->source; ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="modal-footer" id="footer_modal">
            <input type="hidden" id="source_product_id" name="product_id" value="" />
            <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
            <input type="submit" class="btn btn-primary" value="Add" />
        </div>
    </form>
</div>