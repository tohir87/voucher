<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <span><b>Metrics Info</b></span>
                <a class="pull-right" href="#metricInfo" data-toggle="modal" title="Add Metric Information">
                    <i class="icons icon-plus-sign"></i> Add
                </a>
            </div>
            <div class="box-content-padless">
                <?php
                if (!empty($product->metrics_info)):
                    foreach ($product->metrics_info as $info):
                        ?>
                <b><i><?= $metric_types[$info->metric_type] ?> </i></b><br>
                        <?= $info->info; ?> <br>
                        <a href="<?= site_url('product/edit_metric_info/' . $info->product_metric_info_id);?>" class="edit_metric" title="Edit metric info"><i class="icons icon-edit"></i></a> | 
                        <a href="<?= site_url('product/delete_metric_info/' . $info->product_metric_info_id);?>" class="delete_metric_info" title="Delete metric info"><i class="icons icon-trash"></i></a>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>  
        </div>
    </div>
</div>

<div class="modal hide fade" id="metricInfo" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <form method="POST" class="form-horizontal" action="<?= site_url('/product/addMetricInfo'); ?>">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title" id="myModalLabel">Metric Information</h4>
        </div>
        <div class="modal-body">
            <div class="control-group">
                <label class="control-label">Metric Type</label>
                <div class="controls">
                    <select required class="select2-me input-medium" name="metric_type">
                        <option value="">Select Metric Type</option>
                        <?php
                        if (!empty($metric_types)):
                            foreach ($metric_types as $value => $metric):
                                ?>
                                <option value="<?= $value; ?>"><?= $metric; ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Metric Info</label>
                <div class="controls">
                    <textarea required name="metric_info" id="metric_info" rows="3" style="width: 90%"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="product_id" value="<?= $this->uri->segment(3); ?>" />
            <button data-dismiss="modal" class="btn btn-danger" aria-hidden="true">Cancel</button>
            <button class="btn btn-primary">Save</button>
        </div>
    </form>
</div>