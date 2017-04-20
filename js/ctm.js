/* global angular, BASE_URL */

$(document).ready(function () {

    /************** Loader *****************/

    $('a').click(function () {

        var href = $(this).attr('href');
        //var blank = $(this).attr('target');

        if (typeof href !== 'undefined') {
            return true;
        }

        if (typeof href !== 'undefined') {
            if (href !== '') {
                var fs = href.substring(0, 4);
                if (fs === 'http') {
                    show_loader();
                }
            }
        }
    });

    hide_loader();

});

function show_loader() {
//    $('body').addClass('body_op');
//    $('#loader').show();
}

function load_loader() {
    $('#pay_loader').modal();
}

function hide_loader() {
    $('body').removeClass('body_op');
    $('#loader').hide();
}

var CTM = CTM || {};


CTM.doConfirm = function (params) {
    params = params || {};
    var defaults = {
        title: 'Confirm',
        message: 'Are you sure?',
        cancelText: 'Cancel',
        acceptText: 'OK',
        onAccept: null,
        onCancel: null,
        closeOnConfirm: true,
        fade: true
    };
    var mParams = jQuery.extend({}, defaults, params);

    var html = "<div id='tbConfirmModal' class=\"modal hide\"><div class=\"modal-header\"><button type=\"button\" class=\"tbCancelBtn close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button><h3></h3></div><div class=\"modal-body\"></div><div class=\"modal-footer\"><a href=\"#\" class=\"btn btn-warning tbCancelBtn\" data-dismiss='modal'></a><a href=\"#\" class=\"btn btn-primary tbAcceptBtn\"></a></div></div>";


    $('#tbConfirmModal').remove();
    $('body').append(html);

    var $confirm = $('#tbConfirmModal');
    //title
    $confirm.find('.modal-header h3').html(mParams.title);
    //body
    $confirm.find('.modal-body').html(mParams.message);
    //cancel button
    $confirm.find('.btn.tbCancelBtn').text(mParams.cancelText);
    //accept button
    $confirm.find('.btn.tbAcceptBtn').text(mParams.acceptText);

    if (typeof mParams.onAccept === 'function') {
        $confirm.find('.tbAcceptBtn')
                .click(mParams.onAccept);
    }

    if (typeof mParams.onCancel === 'function') {
        $confirm.find('.tbCancelBtn').click(mParams.onCancel);
    }

    if (mParams.closeOnConfirm) {
        $confirm.find('.tbAcceptBtn').attr('data-dismiss', 'modal');
    }

    if (mParams.fade) {
        $confirm.addClass('fade');
    }

    $confirm.modal();
};

if (angular) {
    var TBASE_APP = angular.module('app.Ctm', [])
            .config(function ($httpProvider) {
                // Use x-www-form-urlencoded Content-Type
                $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
                // Override $http service's default transformRequest
                $httpProvider.defaults.transformRequest = [function (data) {
                        return angular.isObject(data) && String(data) !== '[object File]' ? jQuery.param(data).replace(/\+/g, '%20') : data;
                    }];
            }).factory('SiteUrl', function () {

        return {
            get: function (path) {
                if (!window.SITE_URL) {
                    window.SITE_URL = '//' + window.location.host;
                    if (window.location.port !== '') {
                        window.SITE_URL += ":" + window.location.port;
                    }

                    window.SITE_URL += '/';
                }

                if (path.indexOf('/') === 0) {
                    path = path.substr(1);
                }

                return window.SITE_URL + path;
            }
        };
    }).filter('arrayFy', function () {
        return function (object, keyName) {
            var arr = [];
            keyName = keyName || '_key';

            angular.forEach(object, function (obj, key) {
                if (!angular.isObject(obj)) {
                    obj = {_val: obj};
                }
                obj[keyName] = key;
                arr.push(obj);
            });
            return arr;
        };
    }).directive('tbConfirm', function ($parse) {
        return {
            restrict: 'AC',
            link: function (scope, elem, attrs) {
                elem.click(function (e) {
                    e.preventDefault();
                    var options = {};
                    angular.forEach(attrs, function (val, name) {
                        if (name.match(/^confirm/)) {
                            name = name.replace(/^confirm/, '');
                            name = name[0].toLowerCase() + name.substr(1);
                            options[name] = val;
                        }
                    });

                    var callables = ['onAccept', 'onCancel'];
                    angular.forEach(callables, function (name) {
                        if (options.hasOwnProperty(name)) {
                            var k = $parse(options[name]);
                            options[name] = function () {
                                k(scope);
                                try {
                                    scope.$apply();
                                } catch (e) {

                                }
                            };
                        }
                    });


                    console.log(options);
                    CTM.doConfirm(options);
                });
            }
        };
    }).directive('chosenfy', function ($timeout) {

        return {
            restrict: 'A',
            scope: {
                resultProcess: '=process'
            },
            link: function (scope, element, attrs) {
                $timeout(function () {
                    var search = (element.attr("data-nosearch") === "true") ? true : false,
                            opt = {};
                    if (search) {
                        opt.disable_search_threshold = 9999999;
                    }
                    
                    if (attrs.chosenWidth){
                        opt.width = attrs.chosenWidth;
                    }


                    if (attrs.remoteUrl && attrs.remoteUrl !== '') {
                        element.ajaxChosen({
                            type: attrs.remoteUrlMethod || 'GET',
                            url: attrs.remoteUrl,
                            dataType: 'json',
                            minTermLength: 2
                        }, function (data) {
                            //console.log('Result Process: ', scope.resultProcess);
                            if (scope.resultProcess && (typeof scope.resultProcess === 'function')) {
                                return scope.resultProcess(data);
                            }

                            var results = [];
                            $.each(data, function (i, val) {
                                results.push({value: val.value, text: val.text});
                            });
                            return results;
                        }, opt);
                    } else {
                        element.chosen(opt);
                    }


                    setTimeout(function () {
                        if ($('.chzn-container').length > 0) {
                            element.attr('style', 'display:visible; position:absolute; clip:rect(0,0,0,0)');
                        }
                    }, 100);

                }, 100);
            }
        };
    }).directive('datepick', function ($timeout) {

        return {
            link: function (scope, element) {
                $timeout(function () {
                    element.datepicker();
                }, 50);
            }
        };
    }).directive('eatclick', function () {
        return {
            link: function (scope, element) {
                element.click(function (e) {
                    e.preventDefault();
                });
            }
        };
    })
    
    .directive('popover', function ($timeout) {
        return {
            link: function (scope, element) {
//                element.click(function (e) {
//                    e.preventDefault();
//                });
                
                $timeout(function(){
                    element.popover();
                }, 50);
            }
        };
    })
    
    ;


}

CTM.filePicker = function (callback) {
    var callbackName = 'fileUploaded_' + Date.now();
    window[callbackName] = function (data) {
        callback(data);
        $('#bpopupModal').bPopup().close();
    };
    $('.popup-content').html('');
    var options = {
        content: 'iframe',
        contentContainer: '.popup-content',
        loadUrl: '/document_center/file_select/' + callbackName
    };
    var styles = {width: '768px', height: '500px', maxWidth: '100%', maxHeight: '80%'};
    $('#bpopupModal')
            .css(styles)
            .bPopup(options);
};

//handle popups
$(function () {
    if ($('#bpopupModal').length < 1) {
        $('body').append('<div id="bpopupModal"><span class="button b-close"><span>X</span></span><div class="popup-content"></div></div>');
    }
    $('.bpopup').each(function (i, el) {
        var b = $(el);
        var options = {
            content: 'iframe',
            contentContainer: '.popup-content'
        };
        jQuery.extend(options, b.data());

        if (!options.hasOwnProperty('loadUrl') && el.hasAttribute('href')) {
            options.loadUrl = el.href;
        }

        b.click(function (e) {
            e.preventDefault();
//            console.log(options);
            var styles = {width: 'auto', height: 'auto'};

            if (options.hasOwnProperty('width')) {
                styles.width = parseFloat(options.width) ? options.width + 'px' : options.width;
            }

            if (options.hasOwnProperty('height')) {
                styles.height = parseFloat(options.height) ? options.height + 'px' : options.height;
            }


            $('#bpopupModal')
                    .css(styles)
                    .bPopup(options)
                    ;
        });
    });
});