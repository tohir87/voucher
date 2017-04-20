<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title" id="myModalLabel">Edit Category</h4>
</div>

<form name="frmadd" id="frmadd" method="post" action="<?= site_url('/setup/edit_category/'.$category_info->category_id) ?>" class="form-horizontal form-bordered">
    <div class="modal-body nopadding">
            <div class="control-group" style="margin-left: 30px">
                <label for="group_id" class="control-label">Group</label>
                <div class="controls">
                    <select required name="group_id" id="group_id">
                        <option value="" selected>Select Group</option>
                        <?php
                        if (!empty($groups)):
                            $sel = '';
                            foreach ($groups as $group):
                            if ($category_info->group_id == $group->group_id):
                                $sel = 'selected';
                            else:
                                $sel = '';
                            endif;
                                ?>
                                <option value="<?= $group->group_id; ?>" <?= $sel; ?>><?= $group->group_name; ?></option>
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
                    <input required type="text" placeholder="" class='input' id="category_name" name="category_name" value="<?= $category_info->category_name ?>">
                </div>
            </div>
            <div class="control-group" style="margin-left: 30px">
                <label for="category_desc" class="control-label">Description</label>
                <div class="controls">
                    <input type="text" placeholder="" class='input' id="category_desc" name="category_desc" value="<?= $category_info->category_desc ?>">
                </div>
            </div>
    </div>

    <div class="modal-footer" id="footer_modal">
        <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
        <input type="submit" class="btn btn-primary" value="Update" />
    </div>
</form>