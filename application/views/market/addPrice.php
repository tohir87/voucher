<link href="/css/angular-busy.min.css" rel="stylesheet" type="text/css"/>
<script src="/js/angular-busy.min.js"></script>
<script src="/js/angular-datatables-all.js" type="text/javascript"></script>
<script src="/js/dirPagination.js"></script>

<div class="page-header">
    <div class="pull-left">
        <a class="btn btn-warning" href="<?= site_url('/setup/view_product/' . $this->uri->segment(3) . '/' . $this->uri->segment(4)); ?>">
            <i class="icons icon-chevron-left"></i> Back
        </a>
        <h1> <img ng-src="<?= $product_details->image_url ?>" width="40" height="40" src="<?= $product_details->image_url ?>">
            <?= ucfirst($product_details->product_name) ?></h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>

<div class="box" ng-app="market" ng-controller="priceCtrl">
    <div class="box-content nopadding">

        <div class="box box-bordered">
            <form class="form-horizontal form-bordered" method="post" action="">
                <div class="box-title">
                    Date : <input required type="text" name="market_date" class="datepick" value="<?= date('d-m-Y') ?>" style="cursor: pointer" />
                    <span class="pull-right">Activity: <textarea name="activity" rows="3" style="width: 400px; margin-right: 5px"></textarea></span>
                       

                </div>
                <div class="box-content-padless">
                    <div ng-repeat="status in data.prices" style="margin-bottom: 10px; border: 2px solid #006dcc;">
                        <table class="table">
                            <tr>
                                <td>
                                    <label>Markets</label>
                                </td>
                                <td>
                                    <select required name="market_id[{{$index}}]" class="select2-me input-medium">
                                        <option value="" selected>Select Market</option>
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
                                </td>
                                <td>
                                    <label>Source</label>
                                </td>
                                <td>
                                    <select required name="source_id[{{$index}}]" class="select2-me input-medium">
                                        <option value="" selected>Select Source</option>
                                        <?php
                                        if (!empty($product_sources)):
                                            foreach ($product_sources as $source):
                                                ?>
                                                <option value="<?= $source->source_id; ?>"><?= $source->source; ?></option>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                    
                                    &nbsp;<a title="Click hre to add new product source" href="#" onclick="return false;" ng-click="addSource('<?= $product_details->product_id ?>')"> <i class="icons icon-plus"></i> Add New Source</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label >Variety</label>
                                </td>
                                <td>
                                    <select name="variety_id[{{$index}}]" class="select2-me input-medium">
                                        <option value="" selected>Select Variety</option>
                                        <?php
                                        if (!empty($product_varieties)):
                                            foreach ($product_varieties as $variety):
                                                ?>
                                                <option value="<?= $variety->variety_id; ?>"><?= $variety->variety; ?></option>
                                                <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                    
                                </td>
                                <td>
                                    <label >Remark</label>
                                </td>
                                <td>
                                    <select name="remark[{{$index}}][]" id="remark" class="select2-me input-large" multiple>
                                        <?php if(!empty($remarks)):
                                            foreach($remarks as $remark): ?>
                                        <option value="<?= $remark->remark_id; ?>"><?= $remark->subject; ?></option>
                                            <?php endforeach;
                                        endif; ?>
                                    </select>
                                    <span class="muted">Note: <i>Ctrl + Click</i> to select multiple remarks</span>
                                </td>
                            </tr>
                        </table>

                        <?php include '_metrics.php'; ?>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input type="hidden" name="product_id" value="<?= $product_details->product_id ?>" />
                            <button type="submit" class="btn btn-primary btn-large">Submit</button>
                            <button type="reset" class="btn btn-warning btn-large">Reset</button>

                            <a ng-if="!disable_add_btn" class="btn btn-success pull-right" href="#" onclick="return false;" ng-click="addPrice()" style="margin-right: 5px;">
                                Add More
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include APPPATH . 'views/setup/product/_add_source.php'; ?>
<script src="/js/market.js"></script>