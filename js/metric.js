$(function () {
    $('body').delegate('.Toggle', 'click', function (e) {
        e.preventDefault();
        var h = this.href;
        var message = 'Are you sure you want to delete this metric ?';
        CTM.doConfirm({
            title: 'Confirm Delete',
            message: message,
            onAccept: function () {
                window.location = h;
            }
        });
    });
});

$('body').delegate('.edit_metric', 'click', function (evt) {
    evt.preventDefault();

    $('#modal_edit_metric').modal('show');
    $('#modal_edit_metric').html('<div class="loaderBox"><img src="/img/gif-load.gif" ></div>');

    var page = $(this).attr("href");
    $.get(page, function (html) {

        $('#modal_edit_metric').html('');
        $('#modal_edit_metric').html(html);
        $('#modal_edit_metric').modal('show').fadeIn();
    });
    return false;
});

var classApp = angular.module('metrics', ['app.Ctm', 'cgBusy']);

classApp.controller('wholesaleCtrl', function ($scope, $http, SiteUrl) {

    $scope.metric_id = '';

    var getSiteUrl = function () {
        return window.location.protocol + '//' + window.location.host + '/';
    };

    $scope.data = {varieties: []};

    $scope.blankResult = {};

    $scope.addItem = function () {
        $scope.data.varieties.push(angular.copy($scope.blankResult));
    };

    $scope.removeItem = function (idx) {
        if ($scope.data.varieties.length > 0) {
            $scope.data.sources.splice(idx, 1);
        }
        $scope.check();
    };

    $scope.check = function () {
        if ($scope.data.varieties.length == 0) {
            $scope.addItem();
        }
    };

    $scope.addSubCategory = function (id_) {
        $scope.metric_id = id_;
    };

    $scope.showSubCategory = function (metric_wholesale_id, table_name) {
        $scope.myPromise = $http.get(getSiteUrl() + "setup/json_metric_ws_categories/" + metric_wholesale_id + '/' + table_name)
                .success(function (response) {
                    $scope.sub_categories = response;
                });

    };

    $scope.check();

});