$(function () {
//    $('.Toggle').click(function (e) {
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

$('body').delegate('.edit_variety', 'click', function (evt) {
    evt.preventDefault();

    $('#modal_edit_variety').modal('show');
    $('#modal_edit_variety').html('<div class="loaderBox"><img src="/img/gif-load.gif" ></div>');

    var page = $(this).attr("href");
    $.get(page, function (html) {

        $('#modal_edit_variety').html('');
        $('#modal_edit_variety').html(html);
        $('#modal_edit_variety').modal('show').fadeIn();
    });
    return false;
});


var classApp = angular.module('varieties', ['app.Ctm', 'cgBusy']);

classApp.controller('varietyCtrl', function ($scope, $http, SiteUrl) {

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
            $scope.data.varieties.splice(idx, 1);
        }
        $scope.check();
    };

    $scope.check = function () {
        if ($scope.data.varieties.length == 0) {
            $scope.addItem();
        }
    };

    $scope.check();

});