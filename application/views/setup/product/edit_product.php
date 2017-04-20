<script>
    var category_id_ = '<?= $product_detail->category_id; ?>';
    var sub_category_id_ = '<?= $product_detail->sub_category_id; ?>';
</script>
<link href="/css/angular-busy.min.css" rel="stylesheet" type="text/css"/>
<script src="/js/angular-busy.min.js"></script>
<script src="/js/angular-datatables-all.js" type="text/javascript"></script>
<script src="/js/dirPagination.js"></script>

<div class="page-header">
    <div class="pull-left">
        <a href="<?= $this->input->server('HTTP_REFERER'); ?>" class="btn btn-warning">
            <i class="icons icon-chevron-left"></i> Back
        </a>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>
<div class="row-fluid" ng-app="products" ng-controller="productCtrl">
    <div class="span12">
        <div class="box box-bordered">
            <div class="box-title">
                <h3>Edit Product</h3>
            </div>
            <div class="box-content-padless">
                <form class="form-horizontal form-bordered" method="post" action="">
                    <div class="control-group">
                        <label for="category_id" class="control-label">Category</label>
                        <div class="controls">
                            <select required id="category_id" class="select2-me input-large" ng-model="product.category_id" ng-change="loadSubCategories();">
                                <option value="">Select Category</option>
                                <?php
                                if (!empty($categories)):
                                    $sel = '';
                                    foreach ($categories as $category):
                                        ?>
                                        <option value="<?= $category->category_id; ?>"><?= $category->category_name; ?></option>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="sub_category_id" class="control-label">Sub Category</label>
                        <div class="controls" id="states_container">
                            <div ng-if="subCatStatus !== ''">
                                {{subCatStatus}}
                            </div>

                            <div class="input-xlarge" ng-if="subCatStatus === ''">
                                <select required name="sub_category_id" id="sub_category_id" class="chosen-select input-xxlarge" data-rule-required="true" chosenfy ng-model="product.sub_category_id">
                                    <option value="" selected>Select Sub Category</option>
                                    <option ng-repeat="sub in product.sub_categories" value="{{sub.sub_category_id}}" ng-selected="product.sub_category_id.indexOf(sub.sub_category_id + '') > -1">
                                        {{sub.sub_category}}
                                    </option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="product_name" class="control-label">Product Name</label>
                        <div class="controls">
                            <input required type="text" placeholder="" class='input-xlarge' id="product_name" name="product_name" value="<?= $product_detail->product_name ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label  class="control-label">In Season</label>
                        <div class="controls">
                            <select required name="season_id" id="season_id" class="select2-me input-large">
                                <option value="">Select</option>
                                <?php
                                $sel = '';
                                foreach ($seasons as $id => $season):
                                    if ($product_detail->season_id == $id):
                                        $sel = ' selected';
                                    else:
                                        $sel = '';
                                    endif;
                                    ?>
                                    <option value="<?= $id; ?>" <?= $sel; ?>><?= $season ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="product_desc" class="control-label">Description</label>
                        <div class="controls">
                            <textarea  id="product_desc" name="product_desc" class='ckeditor span12' rows="4"><?= $product_detail->product_desc ?></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success btn-large" >Update</button>
                        <button type="reset"  class="btn btn-warning  btn-large" >Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/js/product.js" type="text/javascript"></script>