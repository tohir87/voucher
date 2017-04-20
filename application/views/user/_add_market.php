<div class="row_fluid"> 
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Assign Market to User</h4>
    </div>
    
    <?php  //var_dump($markets); ?>

    <form name="frmadd" id="frmadd" method="post" action="<?= site_url('/user/assign_market/'.$user_id); ?>" class="form-horizontal form-bordered">
        <div class="modal-body nopadding">
            <div class="control-group">
                <label for="market_id" class="control-label">Select Market</label>
                <div class="controls">
                    <select name="market_id[]" id="market_id" class="select2-me input-xlarge" multiple>
                        <?php
                        if (!empty($markets)):
                            $sel = '';
                            foreach ($markets as $market):
                            if (!empty($assigned_markets)):
                                foreach($assigned_markets as $aMarket):
                                    if ($aMarket->market_id == $market->market_id):
                                        echo $sel = 'selected';
                                    else:
                                        $sel = '';
                                    endif;
                                endforeach;
                            endif;
                                ?>
                                <option value="<?= $market->market_id; ?>" <?= $sel; ?>><?= $market->market_name; ?></option>
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
            <input type="submit" class="btn btn-primary" value="Assign Market" />
        </div>
    </form>
</div>