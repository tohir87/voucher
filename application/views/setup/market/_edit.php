<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title" id="myModalLabel">Edit Market</h4>
</div>

<form name="frmadd" id="frmadd" method="post" action="<?= site_url('/market/edit_market/' . $market_info->market_id) ?>" class="form-horizontal form-bordered">
    <div class="modal-body nopadding">
        <div class="control-group">
            <label for="market_name" class="control-label">Market Name</label>
            <div class="controls">
                <input required type="text" placeholder="" class='input' id="market_name" name="market_name" value="<?= $market_info->market_name; ?>">
            </div>
        </div>

        <div class="control-group">
            <label for="group_id" class="control-label">State</label>
            <div class="controls">
                <select required name="state_id" id="state_id">
                    <option value="" selected>Select State</option>
                    <?php
                    if (!empty($states)):
                        $sel = '';
                        foreach ($states as $state):
                            if ($market_info->state_id == $state->StateID):
                                $sel = 'selected';
                            else:
                                $sel = '';
                            endif;
                            ?>
                            <option value="<?= $state->StateID; ?>" <?= $sel; ?>><?= $state->StateName; ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label for="location" class="control-label">Location</label>
            <div class="controls">
                <input type="text" placeholder="" class='input' id="location" name="location" value="<?= $market_info->location; ?>">
            </div>
        </div>
    </div>

    <div class="modal-footer" id="footer_modal">
        <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
        <input type="submit" class="btn btn-primary" value="Update" />
    </div>
</form>