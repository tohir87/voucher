<div class="modal hide fade" id="add_metric" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Assign Metric</h4>
    </div>

    <form name="frmadd" id="frmadd" method="post" action="<?= site_url('/setup/add_product_metrics')?>" class="form-horizontal form-bordered">
        <div class="modal-body nopadding">
            <div class="control-group">
                <label for="group_id" class="control-label">Wholesale</label>
                <div class="controls">
                    <select name="metric_wholesale_id[]" id="metric_wholesale_id" class="select2-me input-xlarge" multiple>
                        <?php
                        if (!empty($wholesale_metrics)):
                            foreach ($wholesale_metrics as $metric):
                                ?>
                                <option value="<?= $metric->metric_wholesale_id; ?>"><?= $metric->metric; ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label for="group_id" class="control-label">Retail</label>
                <div class="controls">
                    <select name="metric_retail_id[]" id="metric_retail_id" class="select2-me input-xlarge" multiple>
                        <?php
                        if (!empty($retail_metrics)):
                            foreach ($retail_metrics as $metric):
                                ?>
                                <option value="<?= $metric->metric_retail_id; ?>"><?= $metric->metric; ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="modal-footer" id="footer_modal">
            <input type="hidden" id="metric_product_id" name="product_id" value="" />
            <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
            <input type="submit" class="btn btn-primary" value="Assign" />
        </div>
    </form>
</div>