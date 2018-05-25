(function($) {
  $('[data-delete=record]').on('click', function(e) {
    e.preventDefault();

    var target = $(this).data('target');

    if (target) {
      $.ajax({
        url: target,
        type: 'DELETE',
        dataType: 'json',
        success: function(res) {
          if (res.success) {
            alert(res.message);
            window.location.reload();
          } else {
            alert(res.message);
          }
        },
        error: function() {
          alert('Cannot perform this action');
        }
      })
    }
  });
})(jQuery);