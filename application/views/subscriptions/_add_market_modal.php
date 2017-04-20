<div class="modal hide fade" id="addMarket" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Add Market To Your Package</h4>
    </div>

    <form name="frmadd" id="frmadd" method="post" action="<?= site_url('/subscriber/add_market');?>" class="form-horizontal form-bordered">
        <div class="modal-body nopadding">
            <div class="control-group">
                
                    <label for="source" class="control-label">Market</label>
                    <div class="controls">
                        <select required name="market_id" id="market_id" class="select2-me input-large">
                            <option value="" selected="selected">Select market</option>
                            <?php
                            if (!empty($markets)):
                                foreach ($markets as $market):
                                if (!in_array($market->market_id, $idMarket)) :
                                    ?>
                                    <option value="<?= $market->market_id; ?>"><?= $market->market_name; ?></option>
                                    <?php
                                    endif;
                                endforeach;
                            endif;
                            ?>
                        </select>
                      
                    </div>
            </div>

        </div>

        <div class="modal-footer" id="footer_modal">
            <button data-dismiss="modal" class="btn btn-default" aria-hidden="true">Cancel</button>
            <input type="submit" class="btn btn-primary" value="Add" />
        </div>
    </form>
</div>