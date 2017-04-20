$(function () {
    $('body').delegate('.Toggle', 'click', function (e) {
        e.preventDefault();
        var h = this.href;
        var message = parseInt($(this).data('enabled')) ? 'If you disable this source, you \'ll no longer be able to assign products to it, Are you sure you want to continue? ' : 'Are you sure you want to enable this source ?';
        CTM.doConfirm({
            title: 'Confirm Status Change',
            message: message,
            onAccept: function () {
                window.location = h;
            }
        });
    });
});

$('body').delegate('.edit_source', 'click', function (evt) {
    evt.preventDefault();

    $('#modal_edit_source').modal('show');
    $('#modal_edit_source').html('<div class="loaderBox"><img src="/img/gif-load.gif" ></div>');

    var page = $(this).attr("href");
    $.get(page, function (html) {

        $('#modal_edit_source').html('');
        $('#modal_edit_source').html(html);
        $('#modal_edit_source').modal('show').fadeIn();
    });
    return false;
});

var classApp = angular.module('sources', ['app.Ctm', 'cgBusy']);

classApp.controller('sourceCtrl', function ($scope, $http, SiteUrl) {

    var getSiteUrl = function () {
        return window.location.protocol + '//' + window.location.host + '/';
    };

    $scope.data = {sources: []};

    $scope.blankResult = {};

    $scope.addItem = function () {
        $scope.data.sources.push(angular.copy($scope.blankResult));
    };

    $scope.removeItem = function (idx) {
        if ($scope.data.sources.length > 0) {
            $scope.data.sources.splice(idx, 1);
        }
        $scope.check();
    };

    $scope.check = function () {
        if ($scope.data.sources.length == 0) {
            $scope.addItem();
        }
    };

    $scope.showSubCategory = function (category_id) {
        console.log(category_id);
        $scope.category_id = category_id;

        $scope.myPromise = $http.get(getSiteUrl() + "setup/json_get_sub_sources/" + category_id)
                .success(function (response) {
                    $scope.sub_sources = response;
                });

    };

    $scope.check();

});