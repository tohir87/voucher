<?= show_notification();
?>

<div class="page-header">
    <div class="pull-left">
        <h1>Upload</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>


<div class="row-fluid">
    <div class="span6">
        <div class="box box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-bar-chart"></i>
                    ...
                </h3>

            </div>
            <div class="box-content-padless">
                <form id="uploadfrm" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                    <div class="control-group">
                        <label class="control-label">Provider</label>
                        <div class="controls">
                            <select required id="provider_id" name="provider_id" >
                                <option value="">Select Provider</option>
                                <?php
                                if (!empty($providers)):
                                    foreach ($providers as $provider):
                                        ?>
                                <option value="<?= $provider->provider_id; ?>" ><?= $provider->provider_name; ?></option>                             
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Amount</label>
                        <div class="controls">
                            <input required type="text" name="amount" id="amount" placeholder="100" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">File</label>
                        <div class="controls">
                            <input required type="file" name="userfile" />
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-large">Upload</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $(function () {
        $('.Toggle').click(function (e) {
            e.preventDefault();
            var h = this.href;
            var message = parseInt($(this).data('enabled')) ? 'If you disable this category, you \'ll no longer be able to assign products to it, Are you sure you want to continue? ' : 'Are you sure you want to enable this category ?';
            CTM.doConfirm({
                title: 'Confirm Status Change',
                message: message,
                onAccept: function () {
                    window.location = h;
                }
            });
        });
    });


    var classApp = angular.module('categories', []);

    classApp.controller('categCtrl', function ($scope) {

        $scope.data = {categories: []};

        $scope.blankResult = {};

        $scope.addItem = function () {
            $scope.data.categories.push(angular.copy($scope.blankResult));
        };



        $scope.removeItem = function (idx) {
            if ($scope.data.categories.length > 0) {
                $scope.data.categories.splice(idx, 1);
            }
            $scope.check();
        };

        $scope.check = function () {
            if ($scope.data.categories.length == 0) {
                $scope.addItem();
            }
        };

        $scope.check();



    });
</script>