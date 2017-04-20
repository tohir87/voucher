<table class="table">
    <thead>
        <tr>
            <th>WHOLESALE PRICE</th>
            <th>RETAIL PRICE</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <table class="table">
                    <?php
                    if (!empty($product_w_metrics)):
                        foreach ($product_w_metrics as $wm):
                            ?>
                            <tr>
                                <td>
                                    <?= $wm->metric ?>
                                    <input type="hidden" name="metric_whole_sale_id[{{$index}}][]" value="<?= $wm->metric_wholesale_id; ?>" />
                                </td>
                                <td>
                                    <div class="input-prepend">
                                        <span class="add-on">N</span>
                                        <input type="text" name="price_wholesale_high[{{$index}}][]" id="price_wholesale_high_{{$index}}" class="input-small" placeholder="High" />
                                    </div>
                                </td>
                                <td>
                                    <div class="input-prepend">
                                        <span class="add-on">N</span>
                                        <input type="text" name="price_wholesale_low[{{$index}}][]" id="price_wholesale_low_{{$index}}" class="input-small" placeholder="Low" />
                                    </div>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </table>
            </td>
            <td>
                <table class="table" >
                    <?php
                    if (!empty($product_r_metrics)):
                        foreach ($product_r_metrics as $rm):
                            ?>
                            <tr>
                                <td>
                                    <?= $rm->metric ?>
                                    <input type="hidden" name="metric_retail_id[{{$index}}][]" value="<?= $rm->metric_retail_id; ?>" />
                                </td>
                                <td>

                                    <div class="input-prepend">
                                        <span class="add-on">N</span>
                                        <input type="text" name="price_retail_high[{{$index}}][]" class="input-small" placeholder="High" />
                                    </div>

                                </td>
                                <td>

                                    <div class="input-prepend">
                                        <span class="add-on">N</span>
                                        <input type="text" name="price_retail_low[{{$index}}][]" class="input-small" placeholder="Low" />
                                    </div>

                                </td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </table>
            </td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td><a class="btn btn-danger pull-right" href="#" onclick="return false;" ng-click="removePrice($index)">remove</a></td>
        </tr>
    </tbody>
</table>