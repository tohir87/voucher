<div class="row-fluid">
    <div class="well">
        <form method="post" class="form-horizontal">

            <div class="span12 ">
                <select ng-model="data.source" class="select2-me input-medium">
                    <option value="0">Select Source</option>
                    <?php
                    if (!empty($sources)):
                        foreach ($sources as $source):
                            ?>
                            <option value="<?= $source->source_id; ?>"><?= $source->source; ?></option>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </select>  <span class="error"><b>{{data.source_err}}</b></span>               &nbsp;
                <button type="button" class="btn btn-primary" ng-click="getSourceProducts()">Go</button>
            </div>
        </form>
    </div>
</div>