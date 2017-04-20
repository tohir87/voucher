$(function () {
    $('.remove_source').click(function (e) {
        e.preventDefault();
        var h = this.href;
        var _title = $(this).data('title');

        var message = 'Are you sure you want to remove this source? ';
        CTM.doConfirm({
            title: 'Remove ' + _title,
            message: message,
            onAccept: function () {
                window.location = h;
            }
        });
    });
});
$(function () {
    $('.remove_variety').click(function (e) {
        e.preventDefault();
        var h = this.href;
        var _title = $(this).data('title');

        var message = 'Are you sure you want to remove this variety? ';
        CTM.doConfirm({
            title: 'Remove ' + _title,
            message: message,
            onAccept: function () {
                window.location = h;
            }
        });
    });
});
$(function () {
    $('.remove_metric').click(function (e) {
        e.preventDefault();
        var h = this.href;
        var _title = $(this).data('title');

        var message = 'Are you sure you want to remove this metric? ';
        CTM.doConfirm({
            title: 'Remove ' + _title,
            message: message,
            onAccept: function () {
                window.location = h;
            }
        });
    });
});
$(function () {
    $('.remove_product_image').click(function (e) {
        e.preventDefault();
        var h = this.href;

        var message = 'Are you sure you want to remove this product image? ';
        CTM.doConfirm({
            title: 'Remove Image ',
            message: message,
            onAccept: function () {
                window.location = h;
            }
        });
    });
});

$(function () {
    $('body').delegate('.delete_price', 'click', function (e) {
        e.preventDefault();
        var h = this.href;
        var message = 'Are you sure you want to delete prices for this market?';
        CTM.doConfirm({
            title: 'Confirm Delete',
            message: message,
            onAccept: function () {
                window.location = h;
            }
        });
    });
});

$(function () {
    $('body').delegate('.delete_metric_info', 'click', function (e) {
        e.preventDefault();
        var h = this.href;
        var message = 'Are you sure you want to delete this metric information?';
        CTM.doConfirm({
            title: 'Confirm Delete',
            message: message,
            onAccept: function () {
                window.location = h;
            }
        });
    });
});

$('.addRecentPrice').click(function () {
    $("#add_recent_price_modal").modal();
});

$('.delete_bulk_prices').click(function (e) {
    e.preventDefault();
    var items = get_selected_items();

    if (!items.length) {
        $('#select_items_msg').show();
        return true;
    }

    $('#select_items_msg').hide();
    $('#market_ids').val(items);
    $("#delete_bulk_price_modal").modal();
});

$('.product').change(function () {
    var product_id = $(this).val();
    var product_name = $(this).find(':selected').attr('data-product_name');
    window.location.href = viewProduct_url + product_id + '/' + product_name;
});

$('body').delegate('.market_fil', 'change', function (e) {
    e.preventDefault();
    var market_id = $(this).val();
    var url_ = $(this).find(':selected').attr('data-url');
    window.location.href = url_ + '/' + market_id;
});

function get_selected_items() {

    var items = [];
    var i = 0;
    $('._item_checkbox').each(function () {
        if ($(this).is(':checked')) {
            items[i] = $(this).data('market_price_id');
            i++;
        }
    });

    return items;
}