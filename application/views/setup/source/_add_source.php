<div class="modal hide fade modal-full" id="new_source" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Add New Source</h4>
    </div>

    <form name="frmadd" id="frmadd" method="post" action="" class="form-horizontal form-bordered">
        <div class="modal-body nopadding">
            <div ng-repeat="status in data.sources" style="margin-bottom: 10px; border: 2px solid #006dcc;">
                <div class="control-group" style="margin-left: 30px">
                    <label for="source" class="control-label">Source Name</label>
                    <div class="controls">
                        <input required type="text" placeholder="" class='input' id="source" name="source[]">
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