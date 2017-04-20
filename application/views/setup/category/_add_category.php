<div class="modal hide fade modal-full" id="new_category" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Add New Category</h4>
    </div>

    <form name="frmadd" id="frmadd" method="post" action="" class="form-horizontal form-bordered">
        <div class="modal-body nopadding">
            <div ng-repeat="status in data.categories" style="margin-bottom: 10px; border: 2px solid #006dcc;">
                <div class="control-group" style="margin-left: 30px">
                    <label for="group_id" class="control-label">Group</label>
                    <div class="controls">
                        <select required name="group_id[]" id="group_id">
                            <option value="" selected>Select Group</option>
                            <?php
                            if (!empty($groups)):
                                foreach ($groups as $group):
                                    ?>
                                    <option value="<?= $group->group_id; ?>"><?= $group->group_name; ?></option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="control-group" style="margin-left: 30px">
                    <label for="category_name" class="control-label">Category Name</label>
                    <div class="controls">
                        <input required type="text" placeholder="" class='input' id="category_name" name="category_name[]">
                    </div>
                </div>
                <div class="control-group" style="margin-left: 30px">
                    <label for="category_desc" class="control-label">Description</label>
                    <div class="controls">
                        <input type="text" placeholder="" class='input' id="category_desc" name="category_desc[]">
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
            <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
            <input type="submit" class="btn btn-primary" value="Save" />
        </div>
    </form>
</div>