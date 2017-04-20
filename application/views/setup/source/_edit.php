<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title" id="myModalLabel">Edit Source</h4>
</div>

<form name="frmedit" id="frmedit" method="post" action="<?= site_url('/setup/edit_source/' . $source_info->source_id) ?>" class="form-horizontal form-bordered">
    <div class="modal-body nopadding">

        <div class="control-group" style="margin-left: 30px">
            <label for="source" class="control-label">Source Name</label>
            <div class="controls">
                <input required type="text" placeholder="" class='input' id="source" name="source" value="<?=$source_info->source; ?>">
            </div>
        </div>
        <div class="control-group" style="margin-left: 30px">
            <label for="description" class="control-label">Description</label>
            <div class="controls">
                <input type="text" placeholder="" class='input' id="description" name="description" value="<?= $source_info->description; ?>">
            </div>
        </div>
    </div>

    <div class="modal-footer" id="footer_modal">
        <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
        <input type="submit" class="btn btn-primary" value="Update" />
    </div>
</form>