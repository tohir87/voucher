$(function () {
    $('body').delegate('.Toggle', 'click', function (e) {
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

$(function () {
    $('.DeleteSubCategory').click(function (e) {
        e.preventDefault();
        var h = this.href;
        var message = 'If you delete this sub category, you \'ll no longer be able to assign products to it, Are you sure you want to continue? ';
        CTM.doConfirm({
            title: 'Confirm Status Change',
            message: message,
            onAccept: function () {
                window.location = h;
            }
        });
    });
});

    $('body').delegate('.edit_category', 'click', function (evt) {
        evt.preventDefault();

        $('#modal_edit_category').modal('show');
        $('#modal_edit_category').html('<div class="loaderBox"><img src="/img/gif-load.gif" ></div>');

        var page = $(this).attr("href");
        $.get(page, function (html) {

            $('#modal_edit_category').html('');
            $('#modal_edit_category').html(html);
            $('#modal_edit_category').modal('show').fadeIn();
        });
        return false;
    });


var classApp = angular.module('categories', ['app.Ctm', 'cgBusy']);

classApp.controller('categCtrl', function ($scope, $http, SiteUrl) {

    var getSiteUrl = function () {
        return window.location.protocol + '//' + window.location.host + '/';
    };

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

    $scope.showSubCategory = function (category_id) {
        console.log(category_id);
        $scope.category_id = category_id;

        $scope.myPromise = $http.get(getSiteUrl() + "setup/json_get_sub_categories/" + category_id)
                .success(function (response) {
                    $scope.sub_categories = response;
                });

    };

    $scope.check();

});