$(document).ready(function () {
  $('.dynamic-list-add').click(function () {
    $(this).parent().find('ul').append('<li><input type="text" name="' + $(this).parent().attr('name') + '"><a class="dynamic-list-remove" href="javascript:void(0)">Remove</a></li>');
  });
  $(document).on('click', '.dynamic-list-remove', function () {
    $(this).parent().remove();
  });

  $('.select-order-status').change(function () {
    var _this = this;
    $(this).attr('disabled', 'disabled');
    document.getElementsByName('printOrders')[0].contentWindow.location.reload();
    document.getElementsByName('printOrders2')[0].contentWindow.location.reload();
    $.ajax({
      url: '/a-panel/changeOrderStatus',
      method: 'post',
      data: {
        orderId: $(this).attr('order-id'),
        status: $(this).val()
      },
      success: function (res) {
        $(_this).removeAttr('disabled');
        try {
          var r = JSON.parse(res);
          if (!('status' in r) || (typeof r.status != 'string') || (r.status != 'success' && (r.status != 'error' || (('type' in r) && (typeof r.type == 'string') && r.type == 'reload_page')))) throw '';
          if (r.status == 'error') alert(('type' in r) && (typeof r.type == 'string') ? r.type : 'Error');
          else if (('color' in r) && typeof r.color == 'string') $(_this).parent().css('background', r.color);
        }
        catch (e) {
          window.location.reload();
        }
      }
    });
  });
});