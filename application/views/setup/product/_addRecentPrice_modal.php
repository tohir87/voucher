<div class="modal hide fade" id="add_recent_price_modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Add Recent Price</h4>
    </div>

    <form name="frmadd" id="frmadd" method="post" action="<?= site_url('/market/addRecentPrice/' . $product->product_id . '/' . $this->uri->segment(4)) ?>" class="form-horizontal form-bordered">
        
        <div class="modal-body">
            <div class="control-group">
                <label for="group_id" class="control-label">Date to copy</label>
                <div class="controls">
                    <input required type="text" name="market_from" class="datepick" style="cursor: pointer" />
                </div>
             </div>
             <div class="control-group">
                <label for="market_id" class="control-label">Market</label>
                <div class="controls">
                    <select required name="market_id" id="market_id" class="select2-me input-large">
                        <option value="" selected>Select Market</option>
                        <?php if($markets):
                            foreach ($markets as $market): ?>
                        <option value="<?= $market->market_id ?>"><?= $market->market_name ?></option>
                            <?php endforeach;
                        endif; ?>
                    </select>
                </div>
             </div>
             <div class="control-group">
                <label for="group_id" class="control-label">Date to apply</label>
                <div class="controls">
                    <input required type="text" name="market_date" class="datepick" value="<?= date('d-m-Y') ?>" style="cursor: pointer" />
                </div>
             </div>
        </div>
        
        <div class="modal-footer" id="footer_modal">
            <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
            <input type="submit" class="btn btn-primary" value="Apply" />
        </div>
    
    </form>
</div>