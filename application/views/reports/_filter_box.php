<div class="row-fluid">
    <div class="well">
        <form method="post" class="form-horizontal">

            <div class="span12 ">
                <select ng-model="data.market" class="select2-me input-medium">
<!--                    <option value="0" selected>All Markets</option>-->
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
                &nbsp;
                <select required ng-model="data.product" class="select2-me input-medium" ng-change="loadVariety()">
                    <?php if ($this->user_auth_lib->get('access_level') != USER_TYPE_SUBSCRIBER): ?>
                    <option value="0" selected>All Products</option>
                    <?php endif; ?>
                    <?php
                    if (!empty($products)):
                        foreach ($products as $product):
                            ?>
                            <option value="<?= $product->product_id; ?>"><?= ucfirst($product->product_name); ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>
                &nbsp;
                <select ng-model="data.variety" class="input-medium">
                    <option value="0" selected>All Varieties</option>
                    <option ng-repeat="v in varieties" value="{{v.variety_id}}">{{v.variety}}</option>
                </select>
                
                &nbsp;
                <?php if ($type == 'analytics'): ?>
                <select ng-model="data.metric_wholesale_id" class="input-small">
                    <option value="0" selected>All Metrics</option>
                    <option ng-repeat="m in wholesale_metrics" value="{{m.metric_wholesale_id}}">{{m.metric}}</option>
                </select>
                <?php endif; ?>
                <?php if ($type == 'retail-analytics'): ?>
                <select ng-model="data.metric_retail_id" class="input-small">
                    <option value="0" selected>All Metrics</option>
                    <option ng-repeat="m in retail_metrics" value="{{m.metric_retail_id}}">{{m.metric}}</option>
                </select>
                <?php endif; ?>
                &nbsp;
                <input type="text" ng-model="data.startDate" placeholder="Start Date" class="datepick input-medium" style="cursor: pointer" />
                &nbsp;
                <input type="text" ng-model="data.endDate" placeholder="End Date" class="datepick input-medium" style="cursor: pointer" />
                &nbsp;
                <button type="button" class="btn btn-primary" <?php if ($type == 'analytics'): ?> ng-click="analyseResult()" <?php elseif($type == 'retail-analytics'): ?> ng-click="analyseRetail()" <?php else: ?> ng-click="filterResult()" <?php endif; ?>>Go</button>
            </div>
        </form>
    </div>
</div>