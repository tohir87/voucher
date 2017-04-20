<div class="modal hide fade modal-full" id="new_w_metric" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Add New Metric</h4>
    </div>

    <form name="frmadd" id="frmadd" method="post" action="" class="form-horizontal form-bordered">
        <div class="modal-body nopadding">
            <div ng-repeat="status in data.varieties" style="margin-bottom: 10px; border: 2px solid #006dcc;">
                <div class="control-group" style="margin-left: 30px">
                    <label for="variety" class="control-label">Metric</label>
                    <div class="controls">
                        <input required type="text" placeholder="" class='input' id="variety" name="metric[]">
                    </div>
                </div>
                <div class="control-group" style="margin-left: 30px">
                    <label for="description" class="control-label">Description</label>
                    <div class="controls">
                        <input type="text" placeholder="" class='input' id="description" name="description[]">
                        <a href="#" title="Remove this category" onclick="return false;" ng-click="removeItem($index)">
                            <i class="fa fa-fw fa-trash-o"></i> remove
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer" id="footer_modal">
            <a title="Click here to add" class="btn btn-warning pull-right" onclick="return false;" ng-click="addItem()">
                <i class="icons icon-plus"></i>
                Add more
            </a>
            <button data-dismiss="modal" class="btn btn-default" aria-hidden="true">Cancel</button>
            <input type="submit" class="btn btn-primary" value="Save" />
        </div>
    </form>
</div>


<!-- Add sub category to metric-->

<div class="modal hide fade" id="new_w_metric_sub" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Assign Metric</h4>
    </div>

    <form name="frmadd" id="frmadd" method="post" action="<?= site_url('setup/metric_wholesale_category') ?>" class="form-horizontal form-bordered">
        <div class="modal-body nopadding">
            <div class="control-group" style="margin-left: 30px">
                <label for="sub_category_id" class="control-label">Category</label>
                <div class="controls">
                    <select required name="category_id[]" id="sub_category_id" multiple="multiple" class="select2-me input-large">
                         <?php
                        if (!empty($categories)):
                            foreach ($categories as $sub):
                                ?>
                                <option value="<?= $sub->category_id ?>"><?= $sub->category_name ?></option>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>
            </div>

            <!--</div>-->
        </div>

        <div class="modal-footer" id="footer_modal">
            <input type="hidden" name="whosale_metric_id" id="whosale_metric_id" value="{{metric_id}}">
            <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
            <input type="submit" class="btn btn-primary" value="Add" />
        </div>
    </form>
</div>

 <!-- View sub categories-->
 
 <div class="modal hide fade" id="view_sub_category" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Metric Categories</h4>
    </div>

    <div class="modal-body">
        <div class="box">
            <div class="box-content-padless">
                <table class="table table-condensed table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Category</th>
                            <?php if ($this->user_auth_lib->have_perm('setup:edit_metric')): ?>
                            <th>Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="sub in sub_categories">
                            <td>{{$index + 1}}</td>
                            <td>{{sub.category_name}}</td>
                            <?php if ($this->user_auth_lib->have_perm('setup:edit_metric')): ?>
                            <td><a href="<?= site_url('setup/deleteMetricWsSubCategory')?>/{{sub.metric_wholesale_category_id}}" class="DeleteSubCategory">delete</a></td>
                            <?php endif; ?>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
    </div>

</div>