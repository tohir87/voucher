<script src="/js/plugins/maskedinput/jquery.maskedinput.min.js"></script>
<div class="page-header">
    <div class="clearfix"></div>
    <div class="pull-left">
        <h1>Add Exemption</h1>
    </div>
</div>

<div class="box">
    <div class="box-content nopadding" ng-app="trader" ng-controller="traderCtrl">

        <div class="box box-bordered">
            <form class="form-horizontal form-bordered" method="post" action="">
                <div class="box-title">
                    <h3>&nbsp;</h3>
                </div>
                <div class="box-content-padless">
                    <div class="control-group">
                        <label class="control-label">Date Range</label>
                        <div class="controls">
                            Start Date <input required type="text" class="datepick" name="date_from" /> End Date
                            <input required type="text" class="datepick" name="date_to" />
                        </div>
                    </div>
                    <div class="control-group" style="margin-left: 0px">
                        <label for="email" class="control-label">Market</label>
                        <div class="controls">
                            <select required name="market_id" id="market_id" ng-model="market_id" class="select2-me input-medium" >
                                <option value="" selected>Select market</option>
                                <?php
                                if (!empty($markets)):
                                    foreach ($markets as $market):
                                        ?>
                                        <option value="<?= $market->market_id; ?>"><?= $market->market_name; ?></option>                     
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                   
                    <div class="control-group">
                        <label class="control-label">Activity</label>
                        <div class="controls">
                            <textarea name="activity" rows="4" style="width: 80%"></textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary btn-large">Update</button>
                            <button type="reset" class="btn btn-warning btn-large">Reset</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="row-fluid">
    <div class="box box-bordered">
        <div class="box-title">
            <h3>Exemptions</h3>
        </div>
        <div class="box-content-padless">
            <?php if (!empty($exemptions)): ?>
                <table class="table table-hover table-condensed dataTable">
                    <thead>
                        <tr>
                            <th style="width: 120px">Date</th>
                            <th style="width: 120px">Market</th>
                            <!--<th>Product</th>-->
                            <th>Activity</th>
                            <th style="width: 120px">Officer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($exemptions as $ex): ?>
                            <tr>
                                <td><?= date('d-M-Y', strtotime($ex->exemption_date)); ?></td>
                                <td><?= $ex->market_name ?></td>
                                <!--<td><?= $ex->product_name ?></td>-->
                                <td><?= $ex->activity ?></td>
                                <td><?= $ex->first_name . ' ' . $ex->last_name ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php
            else:
                echo show_no_data('No exception found');
            endif;
            ?>
        </div>
    </div>
</div>

<script src="/js/traders.js"></script>