<div class="modal hide fade" id="new_user" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="row_fluid"> 
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title" id="myModalLabel">Add New User</h4>
        </div>

        <form name="frmadd" id="frmadd" method="post" action="" class="form-horizontal form-bordered">
            <div class="modal-body nopadding">
                <div class="control-group" style="margin-left: 30px">
                    <label for="first_name" class="control-label">First Name</label>
                    <div class="controls">
                        <input required type="text" placeholder="" class='input'  value="" id="first_name" name="first_name">
                    </div>
                </div>
                <div class="control-group" style="margin-left: 30px">
                    <label for="last_name" class="control-label">Last Name</label>
                    <div class="controls">
                        <input required type="text" placeholder="" class='input'  value="" id="last_name" name="last_name">
                    </div>
                </div>
                <div class="control-group" style="margin-left: 30px">
                    <label for="email" class="control-label">Email</label>
                    <div class="controls">
                        <input required type="email" placeholder="" class='input' id="email" name="email">
                    </div>
                </div>
                <div class="control-group" style="margin-left: 30px">
                    <label for="email" class="control-label">User Type</label>
                    <div class="controls">
                        <select required name="user_type_id" id="user_type_id" class="select2-me input-medium">
                            <option value="" selected> Select User Type</option>
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="footer_modal">
                <button data-dismiss="modal" class="btn btn-default" aria-hidden="true">Cancel</button>
                <input type="submit" class="btn btn-primary" value="Save User" />
            </div>
        </form>
    </div>
</div>