<div class="modal hide fade" id="add_remark" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Add New Remark</h4>
    </div>

    <form name="frmadd" id="frmadd" method="post" action="" class="form-horizontal form-bordered">
        <div class="modal-body nopadding">
            <div style="margin-bottom: 10px; border: 2px solid #006dcc;">
                <div class="control-group" style="margin-left: 30px">
                    <label for="source" class="control-label">Subject</label>
                    <div class="controls">
                        <input required type="text" placeholder="" class='input' id="subject" name="subject">
                    </div>
                </div>
                <div class="control-group" style="margin-left: 30px">
                    <label for="description" class="control-label">Remark</label>
                    <div class="controls">
                        <textarea required name="remark" style="width: 80%" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer" id="footer_modal">
            <button data-dismiss="modal" class="btn btn-warning" aria-hidden="true">Cancel</button>
            <input type="submit" class="btn btn-primary" value="Save" />
        </div>
    </form>
</div>