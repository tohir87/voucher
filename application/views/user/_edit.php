<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title" id="myModalLabel">Edit User</h4>
</div>

<form name="frmadd" id="frmadd" method="post" action="<?= site_url('/user/edit_user/' . $user_info->user_id) ?>" class="form-horizontal form-bordered">
    <div class="modal-body nopadding">
        <div class="control-group">
            <label for="first_name" class="control-label">First Name</label>
            <div class="controls">
                <input required type="text" placeholder="" class='input' id="first_name" name="first_name" value="<?= $user_info->first_name; ?>">
            </div>
        </div>
        <div class="control-group">
            <label for="last_name" class="control-label">Last Name</label>
            <div class="controls">
                <input required type="text" placeholder="" class='input' id="last_name" name="last_name" value="<?= $user_info->last_name; ?>">
            </div>
        </div>
        <div class="control-group">
            <label for="email" class="control-label">Email</label>
            <div class="controls">
                <input required type="email" placeholder="" class='input' id="email" name="email" value="<?= $user_info->email; ?>">
            </div>
        </div>

        <div class="control-group">
            <label for="email" class="control-label">User Type</label>
            <div class="controls">
                <select required name="user_type_id" id="user_type_id" class="select2-me input-medium">
                    <option value="" selected> Select User Type</option>
                    <option value="1" <?= $user_info->user_type_id == 1 ? 'selected' : '' ?>>Admin</option>
                    <option value="2" <?= $user_info->user_type_id == 2 ? 'selected' : '' ?>>User</option>
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer" id="footer_modal">
        <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
        <input type="submit" class="btn btn-primary" value="Update" />
    </div>
</form>