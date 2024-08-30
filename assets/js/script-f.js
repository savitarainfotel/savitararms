"use strict";

const ajax_error_message_rsp = function (jqXHR){
    switch (jqXHR.status) {
        case 0:
            return 'Not connect.\n Verify Network.';
        case 404:
            return 'Requested page not found. [404]';
        case 500:
            return 'Internal Server Error [500].';
        case 'parsererror':
            return 'Requested JSON parse failed.';
        case 'timeout':
            return 'Time out error.';
        case 'abort':
            return 'Ajax request aborted.';

        default:
            return 'Uncaught Error. Try reload the page.';
    }
}

const submitForm = (form) => {
  event.preventDefault();
  const deferred = $.Deferred();
  const method = $(form).attr('method').toLowerCase();
  const data = method === 'post' ? new FormData(form) : $(form).serialize();
  const submitBtn = $(form).find('[type="submit"]');
  const btnHtml = submitBtn.html();

  let allIsOk = true;

  $(form).find(".f-required").each(function () {
      const _label_txt = $(this).siblings("label").html();
      const _input_type = this.type;
      
      if(_input_type) {
          const _val = this.value.trim();
  
          if (_val == "") {
              allIsOk = false;
              const errorElement = $(`<strong id="${this.id}-error" class="text-danger">Please enter the ${_label_txt}</strong>`);
              const id = errorElement.attr('id');
              if($(`#${id}`).length) $(`#${id}`).remove();
              errorElement.appendTo($(this).closest('.form-group'));
          }
  
          // Add event listener to remove error message on input change
          $(this).on('input change', function () {
              const currentVal = $(this).val().trim();
              if (currentVal !== "") {
                  $(`#${this.id}-error`).remove();
              }
          });
      }
  });

  if(allIsOk) {
      $.ajax({
          url: $(form).attr('action'),
          type: method,
          data: data,
          dataType: 'json',
          processData: false,
          contentType: false,
          beforeSend: function() {
              $(form).find('.error-message').html('');
              submitBtn.prop('disabled', true).html(`<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin me-2"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg> Loading...`);
          },
          error: function(jqXHR) {
              snackbar(ajax_error_message_rsp(jqXHR));
          },
          success: function(result) {
              deferred.resolve(result);
              
              if(result.redirect) {
                  setTimeout(() => {
                      window.location.href = result.redirect;
                  }, 500);
              } else {
                  $(form).find('.error-message').html(result.message);
                  if(result.validate === true && typeof result.message === 'object') {
                      for (let error in result.message) {
                          const errorElement = $(`<strong id="${error}-error" class="text-danger">${result.message[error]}</strong>`);
                          const id = errorElement.attr('id');
                          if($(`#${id}`).length) $(`#${id}`).remove();
                          errorElement.appendTo($(`[name="${error}"]`).closest('.form-group'));
                      }
                  } else if(!result.validate && result.message) snackbar(result.message);

                  if(result.error === false && result.data && result.data.reloadTable) {
                      $.each($tables, function(key, table) {
                          const tableElement = table.table().node();
                          const tableId = $(tableElement).attr('id');

                          if(result.data.reloadTable === tableId) {
                              table.ajax.reload();
                          }
                      });
                      form.reset();
                  }
              }
          },
          complete: function() {
              setTimeout(() => {
                  submitBtn.prop('disabled', false).html(btnHtml);
              }, 100);
          }
      });
  }

  return deferred.promise();
};

$(".ajax-form").each(function() {
  $(this).validate({
      errorElement: 'strong',
      errorClass: 'text-danger',
      errorPlacement: function(error, element) {
          const id = error.attr('id');
          if($(`#${id}`).length) $(`#${id}`).remove();

          error.appendTo(element.closest('.form-group'));
      },
      submitHandler: function(form) {
          submitForm(form);
      }
  });
});

$(document).on('change', 'input[name="rating"]', function(){
  const userRating = parseInt($(this).val());

  if(userRating > minRating) {
      $('textarea[name=comments]').val("");
      $('.comment-section').addClass('d-none');
      $(this).closest('form').submit();
  } else {
      $('.comment-section').removeClass('d-none');
  }
});