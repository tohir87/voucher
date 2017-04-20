<script> 
    var category_id_ = '';
    var sub_category_id_ = '';
</script>
<link href="/css/angular-busy.min.css" rel="stylesheet" type="text/css"/>
<script src="/js/angular-busy.min.js"></script>
<script src="/js/angular-datatables-all.js" type="text/javascript"></script>
<script src="/js/dirPagination.js"></script>

<div class="page-header">
    <div class="pull-left">
        <h1>New Product</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>

<div class="row-fluid" ng-app="products" ng-controller="productCtrl">
    <div class="span12">
        <div class="box box-bordered">
            <div class="box-title">
                <h3>&nbsp;</h3>
                <a class="btn btn-warning" href="<?= site_url('setup/products')?>">
                    <i class="icons icon-chevron-left"></i> Back
                </a>
            </div>
            <div class="box-content-padless">
                <form name="frmadd" id="frmadd" method="post" action="" enctype="multipart/form-data" class="form-horizontal form-bordered">
                    <div class="control-group">
                        <label for="sub_category_id" class="control-label">Category</label>
                        <div class="controls">
                            <select required name="category_id" id="category_id" class="select2-me input-xlarge" ng-model="product.category_id" ng-change="loadSubCategories();">
                                <option value="" selected>Category</option>
                                <?php
                                if (!empty($categories)):
                                    foreach ($categories as $sub):
                                        ?>
                                        <option value="<?= $sub->category_id; ?>"><?= $sub->category_name; ?></option>
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
                                    <option ng-repeat="sub in product.sub_categories" value="{{sub.sub_category_id}}">
                                        {{sub.sub_category}}
                                    </option>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="product_name" class="control-label">Product Name</label>
                        <div class="controls">
                            <input required type="text" placeholder="" class='input-xlarge' id="product_name" name="product_name">
                        </div>
                    </div>
                    <div class="control-group">
                        <label  class="control-label">In Season</label>
                        <div class="controls">
                            <select required name="season_id" id="season_id" class="select2-me input-large">
                                <option value="">Select</option>
                                <?php
                                foreach ($seasons as $id => $season):
                                    ?>
                                    <option value="<?= $id; ?>"><?= $season ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="product_desc" class="control-label">Description</label>
                        <div class="controls">
                            <textarea  id="product_desc" name="product_desc" class='ckeditor span12' rows="4"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="product_image" class="control-label">Product Image</label>
                        <div class="controls">
                            <input type="file"  id="product_image" name="userfile" />
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="reset" class="btn btn-warning btn-large">Reset</button>
                        <input type="submit" class="btn btn-success btn-large" value="Save Product" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/js/product.js" type="text/javascript"></script>