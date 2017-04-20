<div class="box-title">
    <div class="btn-group bulk_action pull-right" style="margin-right: 5px">
        <a class="btn btn-warning dropdown-toggle" data-toggle="dropdown" href="#">Bulk Action <span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li>
                <a href="#" class="delete_bulk_prices">Delete Prices</a>
            </li>
        </ul>
    </div>
    <h3 style="font-weight: 300">Filter By Market:</h3>
    <select name="market_fil" id="market_fil" class="select2-me input-medium market_fil">
        <option selected> Select Market</option>
        <?php
        if (!empty($markets)):
            $sel = '';
            foreach ($markets as $market):
                if ($market->market_id == $this->uri->segment(5)) :
                    $sel = 'selected';
                else:
                    $sel = '';
                endif;
                ?>
                <option value="<?= $market->market_id; ?>" data-url="<?= site_url('setup/view_product/' . $this->uri->segment(3) . '/' . $this->uri->segment(4)); ?>" <?= $sel; ?>><?= $market->market_name; ?></option>                                 
                <?php
            endforeach;
        endif;
        ?>
    </select>
</div>