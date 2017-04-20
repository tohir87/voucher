<div class="modal hide fade" id="addProducts" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" ng-app="subproducts" ng-controller="productCtrl" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Add Products To Your Package</h4>
    </div>

    <form name="frmadd" id="frmadd" method="post" action="<?= site_url('/subscriber/add_product'); ?>" class="form-horizontal form-bordered">
        <div class="modal-body">
            <div class="control-group">
<!--                <div ng-repeat="status in data.products" style="margin-bottom: 10px; border: 1px solid #006dcc;">-->
                    <label for="source" class="control-label">Product</label>
                    <div class="controls">
                        <select required name="product_id[]" id="product_id" class="select2-me input-large">
                            <option value="" selected="selected">Select product</option>
                            <?php
                            if (!empty($products)):
                                foreach ($products as $product):
                                    if (!in_array($product->product_id, $idProducts)) :
                                        ?>
                                        <option value="<?= $product->product_id; ?>"><?= $product->product_name; ?></option>
                                        <?php
                                    endif;
                                endforeach;
                            endif;
                            ?>
                        </select>
<!--                        <a href="#" title="Remove this product" onclick="return false;" ng-click="removeItem($index)">
                            <i class="fa fa-fw fa-trash-o"></i> remove
                        </a>-->
                    </div>
                <!--</div>-->
            </div>

        </div>

        <div class="modal-footer" id="footer_modal">
<!--            <a title="Click here to add" class="btn btn-warning pull-right" onclick="return false;" ng-click="addItem()">
                <i class="icons icon-plus"></i>
                Add more
            </a>-->
            <button data-dismiss="modal" class="btn btn-default" aria-hidden="true">Cancel</button>
            <input type="submit" class="btn btn-primary" value="Save" />
        </div>
    </form>
</div>