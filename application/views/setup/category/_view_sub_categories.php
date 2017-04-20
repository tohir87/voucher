<div class="modal hide fade modal-full" id="view_sub_category" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Sub Categories</h4>
    </div>

    <div class="modal-body">
        <div class="box">
            <div class="box-title">
                <!--                <a href="#new_sub_category" data-toggle='modal' class="btn btn-primary pull-right">
                                    <i class="icons icon-plus-sign"></i> Add Sub category
                                </a>-->
            </div>
            <div class="box-content-padless">
                <table class="table table-condensed table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Sub category</th>
                            <th>Description</th>
                            <?php if ($this->user_auth_lib->have_perm('setup:edit_category')): ?>
                                <th>Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="sub in sub_categories">
                            <td>{{$index + 1}}</td>
                            <td>{{sub.sub_category}}</td>
                            <td>{{sub.description}}</td>
                            <?php if ($this->user_auth_lib->have_perm('setup:edit_category')): ?>
                            <td> 
                                <a href="<?= site_url('setup/deleteSubCategory') ?>/{{sub.sub_category_id}}" class="DeleteSubCategory" title="Click here to delete this sub category">
                                    <i class="icons icon-trash"></i> delete
                                </a>|
                                <a href="<?= site_url('setup/editSubCategory') ?>/{{sub.sub_category_id}}" title="Click here to edit this sub category">
                                    <i class="icons icon-edit"></i> edit
                                </a>
                            </td>
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

<div class="modal hide fade" id="new_sub_category" aria-hidden="true" role="dialog" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">New Sub Categories</h4>
    </div>
    <form class="form-horizontal" method="post" action="<?= site_url('setup/add_sub_categories') ?>">
        <div class="modal-body">
            <div class="control-group">
                <label for="category_name" class="control-label">Sub Category Name</label>
                <div class="controls">
                    <input required type="text" placeholder="" class='input' id="category_name" name="sub_category">
                </div>
            </div>
            <div class="control-group">
                <label for="category_desc" class="control-label">Description</label>
                <div class="controls">
                    <input type="text" placeholder="" class='input-xlarge' id="category_desc" name="description">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="category_id" value="{{category_id}}" />
            <button type="submit" class="btn btn-primary" >Add</button>
            <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
        </div>
    </form>
</div>