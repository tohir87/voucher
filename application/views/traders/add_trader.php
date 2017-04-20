<script src="/js/plugins/maskedinput/jquery.maskedinput.min.js"></script>
<script src="/js/traders.js"></script>
<?= show_notification();
?>

<script>
    var market_id_ = '<?= !empty($trader) ? $trader->market_id : ''; ?>';
    var selected_products_ = '<?= !empty($trader) ? json_encode($trader->products) : NULL; ?>';
</script>

<div class="page-header">
    <div class="pull-left">
        <a href="<?= $this->input->server('HTTP_REFERER'); ?>" class="btn btn-warning">
            <i class="icons icon-chevron-left"></i> Back
        </a>
        <h1>Market Traders</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>

<div class="row-fluid" ng-app="trader" ng-controller="traderCtrl">
    <div class="span12">
        <div class="box box-bordered">
            <div class="box-title">
                <h3><i class="icons icon-edit"></i> <?= $this->uri->segment(2) === 'edit_trader' ? 'Edit Trader Information' : 'New Trader Form'; ?> </h3>
            </div>
            <div class="box-content-padless">
                <form name="frmadd" id="frmadd" method="post" action="<?= $form_action; ?>" class="form-horizontal form-bordered">
                    <div class="control-group" style="margin-left: 0px">
                        <label for="first_name" class="control-label">First Name</label>
                        <div class="controls">
                            <input required type="text" placeholder="" class='input'  value="<?= isset($trader->first_name) ? $trader->first_name : ''; ?>" id="first_name" name="first_name">
                        </div>
                    </div>
                    <div class="control-group" style="margin-left: 0px">
                        <label for="last_name" class="control-label">Last Name</label>
                        <div class="controls">
                            <input required type="text" placeholder="" class='input'  value="<?= isset($trader->last_name) ? $trader->last_name : ''; ?>" id="last_name" name="last_name">
                        </div>
                    </div>
                    <div class="control-group" style="margin-left: 0px">
                        <label for="email" class="control-label">Gender</label>
                        <div class="controls">
                            <select required name="gender_id" id="gender_id" class="select2-me input-medium" >
                                <option value="" selected>Select Gender</option>
                                <option value="1" <?= (int) $trader->gender_id == 1 ? 'selected' : ''; ?>>Female</option>
                                <option value="2" <?= (int) $trader->gender_id == 2 ? 'selected' : ''; ?>>Male</option>

                            </select>
                        </div>
                    </div>
                    <div class="control-group" style="margin-left: 0px">
                        <label for="email" class="control-label">Market</label>
                        <div class="controls">
                            <select required name="market_id" id="market_id" ng-model="market_id" ng-change="loadMarketProducts()" class="select2-me input-medium" >
                                <option value="" selected>Select market</option>
                                <?php
                                if (!empty($markets)):
                                    foreach ($markets as $market):
                                        ?>
                                        <option value="<?= $market->market_id; ?>"><?= $market->market_name; ?></option>                     
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group" style="margin-left: 0px">
                        <label for="email" class="control-label">Email </label>
                        <div class="controls">
                            <input type="email" placeholder="Email Address" value="<?= isset($trader->email) ? $trader->email : ''; ?>" class='input' id="email" name="email">
                        </div>
                    </div>
                    <div class="control-group" style="margin-left: 0px">
                        <label for="email" class="control-label">Phone Number</label>
                        <div class="controls">
                            <input required type="text" placeholder="" class='input' value="<?= isset($trader->phone) ? $trader->phone : ''; ?>" id="phone" name="phone">
                        </div>
                    </div>
                    <div class="control-group" style="margin-left: 0px">
                        <label for="email" class="control-label">Alternative Phone</label>
                        <div class="controls">
                            <input type="text" placeholder="" class='input' id="phone2" name="phone2" value="<?= isset($trader->phone2) ? $trader->phone2 : ''; ?>">
                        </div>
                    </div>
                    <div class="control-group" style="margin-left: 0px">
                        <label for="email" class="control-label">Product</label>
                        <div class="controls">
                            <div ng-if="productStatus !== ''">
                                {{productStatus}}
                            </div>
                            <div class="input-xlarge" ng-if="productStatus === ''">
                                <select required name="product_id[]" id="product_id" multiple="multiple" class="chosen-select input-xxlarge" data-rule-required="true" chosenfy title="Select products">
                                    <option ng-repeat="product in products" value="{{product.id}}" ng-selected="selected_products.indexOf(product.id + '') > -1">
                                        {{product.name}}
                                    </option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="control-group" style="margin-left: 0px">
                        <label for="email" class="control-label">Distribution Channel</label>
                        <div class="controls">
                            <select required name="metric_type" id="metric_type" class="chosen-select">
                                <?php
                                if (!empty($supply_chains)):
                                    $sel = '';
                                    foreach ($supply_chains as $value => $chain):
                                        if ($trader->metric_type == $value):
                                            $sel = 'selected';
                                        else:
                                            $sel = '';
                                        endif;
                                        ?>
                                        <option value="<?= $value ?>" <?= $sel; ?>><?= $chain ?></option>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group" style="margin-left: 0px">
                        <label for="email" class="control-label">Shop No</label>
                        <div class="controls">
                            <input type="text" placeholder="" class='input' id="shop_no" name="shop_no" value="<?= isset($trader->shop_no) ? $trader->shop_no : ''; ?>" />
                        </div>
                    </div>
                    <div class="form-actions">
                        <button data-dismiss="modal" class="btn btn-warning btn-large" aria-hidden="true">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-large"> <?= $this->uri->segment(2) === 'edit_trader' ? 'Update' : 'Save'; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


