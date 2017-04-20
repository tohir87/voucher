<?php
$p_remark = strlen($price_info->remark) > 0 ? json_decode($price_info->remark) : [];
?>

<div class="page-header">
    <div class="pull-left">
        <a class="btn btn-warning" href="<?= site_url('/report'); ?>">
            <i class="icons icon-chevron-left"></i> Back
        </a>

    </div>
    <div class="clearfix"></div>
    <div class="pull-left">
        <h1>Update Remark</h1>
    </div>
</div>

<div class="box">
    <div class="box-content nopadding">

        <div class="box box-bordered">
            <form class="form-horizontal form-bordered" method="post" action="">
                <div class="box-title">
                    <h3><?= $price_info->product_name ?> &nbsp; [<?= ucfirst($price_info->market_name) ?> Market ]&nbsp;
                        | <?= date('d-M-Y', strtotime($price_info->market_date)); ?></h3>
                </div>
                <div class="box-content-padless">
                    <div class="control-group">
                        <label class="control-label">Date Range</label>
                        <div class="controls">
                            <input type="text" class="datepick" name="date_from" value="<?= date('d-m-Y', strtotime($price_info->market_date))?>" /> To 
                            <input type="text" class="datepick" name="date_to" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" >Remark</label>
                        <div class="controls">
                            <select name="remark[]" id="remark" class="select2-me input-large" multiple>
                                
                                <?php
                                if (!empty($remarks)):
                                    $sel = '';
                                    foreach ($remarks as $remark):
                                        if (in_array($remark->remark_id, $p_remark)):
                                            $sel = 'selected';
                                        else:
                                            $sel = '';
                                        endif;
                                        ?>
                                        <option value="<?= $remark->remark_id; ?>" <?=$sel;?>><?= $remark->subject; ?></option>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                            <span class="muted">Note: <i>Ctrl + Click</i> to select multiple remarks</span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Activity</label>
                        <div class="controls">
                            <textarea name="activity" rows="4" style="width: 80%"><?= $price_info->activity; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary btn-large">Update</button>
                            <button type="reset" class="btn btn-warning btn-large">Reset</button>


                        </div>
                    </div>
                </div>


        </div>
        </form>
    </div>
</div>
