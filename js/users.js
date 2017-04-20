/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    $('body').delegate('.Toggle', 'click', function (e) {
        e.preventDefault();
        var h = this.href;
        var message = parseInt($(this).data('enabled')) ? 'If you disable this user, user \'ll no longer be able to log in, Are you sure you want to continue? ' : 'Are you sure you want to enable this user ?';
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
    $('body').delegate('.deleteUser', 'click', function (e) {
        e.preventDefault();
        var h = this.href;
        var message = 'Are you sure you want to delete this user ?';
        CTM.doConfirm({
            title: 'Confirm Delete',
            message: message,
            onAccept: function () {
                window.location = h;
            }
        });
    });
});

$('body').delegate('.edit_u', 'click', function (evt) {
    evt.preventDefault();

    $('#modal_edit_user').modal('show');
    $('#modal_edit_user').html('<div class="loaderBox"><img src="/img/gif-load.gif" ></div>');

    var page = $(this).attr("href");
    $.get(page, function (html) {

        $('#modal_edit_user').html('');
        $('#modal_edit_user').html(html);
        $('#modal_edit_market').modal('show').fadeIn();
    });
    return false;
});

$('body').delegate('.add_market', 'click', function (evt) {
    evt.preventDefault();

    $('#modal_assign_market').modal('show');
    $('#modal_assign_market').html('<div class="loaderBox"><img src="/img/gif-load.gif" ></div>');

    var page = $(this).attr("href");
    $.get(page, function (html) {

        $('#modal_assign_market').html('');
        $('#modal_assign_market').html(html);
        $('#market_id').select2();
        
//        $('.chzn-container').css('width', '30%');
//        $('.chzn-drop').css('width', '100%');
//        $('.chzn-search > input').css('width', '85%');
        
        $('#modal_assign_market').modal('show').fadeIn();
    });
    return false;
});