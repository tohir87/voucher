<?= show_notification();
?>
<link href="/css/angular-busy.min.css" rel="stylesheet" type="text/css"/>
<script src="/js/angular-busy.min.js"></script>
<script src="/js/angular-datatables-all.js" type="text/javascript"></script>
<script src="/js/dirPagination.js"></script>

<div class="page-header">
    <div class="pull-left">
        <h1>Change Password</h1>
    </div>
    <div class="clearfix"></div>
    <div class="pull-left">

    </div>
</div>

<div class="row-fluid" ng-app="password">
    <div class="span12">
        <div class="box box-bordered">
            <div class="box-title">
                &nbsp;
            </div>
            <div class="box-content nopadding" ng-controller="passCtrl">
                <form class=" form-horizontal form-bordered" method="post" action="">
                    <div class="control-group">
                        <label class="control-label">Current Password</label>
                        <div class="controls">
                            <input ng-required="true" type="password" name="current_password" id="current_password" class="input-large" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">New Password</label>
                        <div class="controls">
                            <input ng-required="true" type="password" name="new_password" ng-model="new_password" class="input-large" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Confirm Password</label>
                        <div class="controls">
                            <input ng-required="true" type="password" name="new_password2" ng-model="new_password2" class="input-large" />
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="reset" class="btn btn-warning btn-large">Reset</button>
                        <button type="submit" class="btn btn-primary btn-large" ng-disabled="new_password !== new_password2">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var passApp = angular.module('password', ['app.Ctm', 'cgBusy']);

    passApp.controller('passCtrl', function ($scope) {

        $scope.current_password = '';
        $scope.new_password = '';
        $scope.new_password2 = '';

    });
</script>