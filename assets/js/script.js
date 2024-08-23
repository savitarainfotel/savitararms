"use strict";

const $base_url = $('input[name="base_url"]').val();
const $tables = [];

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

const snackbar = (text) => {
    const options = {
        text: text, duration: 3000, pos: 'top-center'
    };

    Snackbar.show(options);
}

const showMessage = $('input[name="showMessage"]').val();
if(showMessage) snackbar(showMessage);

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

const getCookie = cname => {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');

    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }

    return false;
}

$('.show-password').hover(
    function() {
      const passwordInput = $(this).siblings('.password-input');
      passwordInput.attr('type', 'text');
    },
    function() {
      const passwordInput = $(this).siblings('.password-input');
      passwordInput.attr('type', 'password');
    }
);

if($(".toggle-password").length) {
    $(".toggle-password").click(function(){
        const input = $(this).siblings('input');
        input.attr('type', input.attr('type') === "password" ? "text" : "password");
    });
}

const addValidationMethods = () => {
    $.validator.addMethod('accept', function(value, element, param) {
        // Split the param string by comma to get the list of acceptable extensions
        let typeParam = typeof param === 'string' ? param.replace(/\s/g, '') : 'image/*',
            optionalValue = this.optional(element),
            i, file;
    
        // If the field is optional and no file is selected, validation passes
        if (optionalValue) {
            return optionalValue;
        }
    
        if ($(element).attr('type') === 'file') {
            typeParam = typeParam.split(/[,|]/);
            file = element.files;
    
            for (i = 0; i < file.length; i++) {
                // Get the file extension
                const extension = file[i].type.toLowerCase();

                // Check if the file extension is in the allowed list
                if ($.inArray(extension, typeParam) === -1) {
                    return false;
                }
            }
        }
        return true;
    }, $.validator.format("Please select valid file."));

    $.validator.addMethod('email_id', function(email, element, param) {
        if (email === "") {
            return true;
        }
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }, $.validator.format("Please enter a valid email address."));

    $.validator.addMethod('validate_mobile', function(mobile, element, param) {
        if (mobile === "") {
            return true;
        }
        const mobilePattern = /^\+?[1-9]\d{9,14}$/;
        return mobilePattern.test(mobile);
    }, $.validator.format("Please enter a valid mobile."));

    $.validator.addMethod('validate_password', function(password, element, param) {
        if (password === "") {
            return true;
        }
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
        return passwordPattern.test(password);
    }, $.validator.format("At least 8 characters, one uppercase, one lowercase, one number, and one special character."));
}

if($('.ajax-form').length){
    addValidationMethods();

    let rules;

    if(typeof rule == 'undefined') {
        const isProfileOrUpdate = window.location.href.includes('/profile') || window.location.href.includes('/users/edit/');

        rules = {
            password: {
                required: !isProfileOrUpdate,
                validate_password: true,
                maxlength: 50
            },
            confirm_password: {
                required: !isProfileOrUpdate,
                maxlength: 50,
                equalTo: "#password"
            },
            mobile: {
                required: true,
                validate_mobile: true,
                digits: true
            },
            otp: {
                required: true,
                digits: true,
                maxlength: 6,
                minlength: 6
            },
            email: {
                required: true,
                maxlength: 100,
                email: getCookie('dev') ? false : true,
                email_id: getCookie('dev') ? false : true
            },
            alternative_email: {
                maxlength: 100,
                email: true,
                email_id: true
            },
            alternative_contact_number: {
                validate_mobile: true,
                digits: true
            },
            name: {
                required: true,
                maxlength: 100
            }
        };
    } else {
        rules = rule;
    }

    $(".ajax-form").each(function() {
        $(this).validate({
            rules: rules,
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
}

if($('.datatable').length > 0) {
    $('.datatable').each(function(){
        const table = $(this).DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "stripeClasses": [],
            "pagingType": "simple_numbers",
            "lengthMenu": [[10, 20, 30, 40, 100, -1], [10, 20, 30, 40, 100, "All"]],
            "pageLength": 20,
            "processing": true,
            "serverSide": true,
            'language': {
                "search": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "searchPlaceholder": "Search...",
                "lengthMenu": "Results :  _MENU_",
                'loadingRecords': '&nbsp;',
                'processing': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin me-2"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>  Loading...',
                'paginate': {
                    'next': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
                    'previous': '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                }
            },
            "order": [],
            "ajax": {
                url: $(this).data('link') ?? $("input[name='dataTableUrl']").val(),
                type: "POST",
                data: function(data) {
                    data.csrf_token = $("input[name='csrf_hash']").val();
                    data.invite_id = $("[name='invite_id']").val();
                    data.export = $("input[name='data-export']").val();
                },
                complete: function(response) {
                    $('.bs-tooltip').tooltip();
                    
                    if(response.responseJSON && response.responseJSON.html) {
                        const isHTML = RegExp.prototype.test.bind(/(<([^>]+)>)/i);                    
                        if(!isHTML(response.responseJSON.html)){
                            const downloadLink = document.createElement("a");
                            const fileData = ['\ufeff'+response.responseJSON.html];
    
                            const blobObject = new Blob(fileData,{
                                type: "text/csv;charset=utf-8;"
                            });
    
                            const url = URL.createObjectURL(blobObject);
                            downloadLink.href = url;
                            downloadLink.download = response.responseJSON.file;
    
                            /*
                            * Actually download CSV
                            */
                            document.body.appendChild(downloadLink);
                            downloadLink.click();
                            document.body.removeChild(downloadLink);
                        }
                    }
                },
            },
            "columnDefs": [{
                "targets": "no-content",
                "orderable": false,
            }]
        });

        $tables.push(table);
    
        $(document).on('click', '.btn-export-csv', function(){
            $("input[name='data-export']").val(1);
            if(typeof table !== 'undefined'){
                table.draw();
            }
    
            setTimeout(() => {
                $("input[name='data-export']").val(0);
            }, 300);
        });
    
        $(document).on('click', '.delete-archive-item', function(e){
            e.preventDefault();
            const form = this.parentNode;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, do it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    submitForm(form).done(function(response) {
                        if(response.error === false) {
                            table.ajax.reload();
                        }
                    });
                }
            });
        });
    
        $(document).on('click', '.reload-ajax', function (e) {
            if(typeof table !== 'undefined'){
                const status = $(this).data('status') ?? 0;
                $("input[name='status']").val(status);
                table.ajax.reload();
            }
        });
    
        if(typeof table !== 'undefined'){
            multiCheck(table);
        }
    });
}

$(document).on('click', '.btn-modal-item', function(e){
    e.preventDefault();
    const title = $(this).data('modal-title');
    const form = this.parentNode;

    submitForm(form).done(function(response) {
        if(response.error === false) {
            $('#generalModal').find('.modal-title').html(title);
            $('#generalModal').find('.modal-body').html(response.data);
            $('#generalModal').modal('toggle');
        }
    });
});

$(document).on('click', '.tab-redirect', function(e){
    const href = $(this).attr('href');

    if(href) {
        window.location.href = href;
    }
});

$(document).on('click', '.btn-get-client-note', function (e) {
    e.preventDefault();
    const form = this.parentNode;

    submitForm(form).done(function(response) {
        if(response.error === false) {
            $('#clientNoteModal').find('form .notes').val(response.data.notes);
            $('#clientNoteModal').find('form').append(`<input type="hidden" name="note_id" class="reset-inputs" id="note_id" value="${response.data.note_id}" />`);
            $('#clientNoteModal').modal('show');
        }
    });
});

$(document).on('click', '.btn-get-permissions', function (e) {
    e.preventDefault();
    const form = this.parentNode;

    submitForm(form).done(function(response) {
        if(response.error === false) {
            $('#permissions-form').html(response.data);
            $('#permissionsModal').modal('toggle');
        }
    });
});

$(document).ready(function(){
    if($('.flatpickr').length) {
        $('.flatpickr').each(function(){
            flatpickr($(this), {
                dateFormat: "d/m/Y",
                maxDate: $(this).data('max-date')
            });
        });
    }

    if($('.flatpickr-time').length) {
        $('.flatpickr-time').each(function(){
            const _actual_edit_time = $(this).data('actual-time');
            flatpickr($(this), {
                enableTime: true,
                noCalendar: true,
                minuteIncrement: 1,
                dateFormat: "H:i",
                defaultDate: _actual_edit_time !== undefined && _actual_edit_time !== "" ? _actual_edit_time : new Date(),
                time_24hr: true
            });
        });
    }

    if($('.tom-select').length) {
        $('.tom-select').each(function(){
            const create = $(this).data('add');
            new TomSelect(this,{
                persist: false,
                createOnBlur: true,
                create: create
            });
        });
    }
});

const savePermissions = () => {
    const form = document.getElementById('save-permissions-form');

    submitForm(form).done(function(response) {
        if(response.error === false) {
            $("html, body").animate({scrollTop: 0}, 1000);
            setTimeout(() => {
                $('#permissionsModal').modal('toggle');
            }, 500);
        }
    });
}

$(document).on('click', "#checkall", function () {
    $('.checkall').not(this).prop('checked', this.checked);
});

$(document).on('click', ".ischeck", function () {
    const ischeck = $(this).data('id');
    $('.isscheck_'+ ischeck).prop('checked', this.checked);
});

const editors = [];

if(('.ckeditor-areas').length) {
    $('.ckeditor-areas').each(function() {
        const editor = CKEDITOR.replace($(this).prop('id'));

        // Add an input event listener to the CKEditor instance
        editor.on('change', function() {
            editor.updateElement();
        });

        editors[$(this).prop('id')] = editor;
    });
}

$(document).on('click', '.btn-add-follow-up', function (e) {
    e.preventDefault();

    const leadId = $(this).data('lead-id');
    $(`input[name="lead_id"]`).val(leadId);

    const quotations = $(this).data('quotations');

    if(quotations) {
        if(editors["package_quotation"]) editors["package_quotation"].setData(quotations.package.quotation);
        if(editors["airlines_quotation"]) editors["airlines_quotation"].setData(quotations.airlines.quotation);
    }
});

$(document).on('click', '.btn-view-follow-up', function (e) {
    e.preventDefault();

    const followUps = $(this).data('follow-ups');
    let html = '<p>No followup found</p>';

    if(followUps && followUps.length) {
        html = `<table class="table table-bordered"><thead><tr><th><b>Last followup</b></th><th><b>Description</b></th><th><b>Next followup</b></th></tr></thead><tbody>`
        followUps.forEach(({ id, next_follow_date, description, last_follow_date }) => {
            html += `<tr>
                        <td>${last_follow_date}</td>
                        <td>${description}</td>
                        <td>${next_follow_date}</td>
                    </tr>`;
        });
        html += '</tbody></table>';
    }

    $('#generalModal').find('.modal-title').html("Follow Up(s)");
    $('#generalModal').find('.modal-body').html(html);
    $('#generalModal').modal('toggle');
});

const app = {
    init() {
        this.cacheDOM();
        this.setupAria();
        this.nextButton();
        this.prevButton();
        this.validateForm();
        this.startOver();
        this.editForm();
        this.killEnterKey();
        this.handleStepClicks();
        addValidationMethods();
    },

    cacheDOM() {
        if ($('.multi-step-form').length === 0) return;
        this.$formParent = $('.multi-step-form');
        this.$form = this.$formParent.find('form');
        this.$formStepParents = this.$form.find('fieldset');

        this.$nextButton = this.$form.find('.btn-next');
        this.$prevButton = this.$form.find('.btn-prev');
        this.$editButton = this.$form.find('.btn-edit');
        this.$resetButton = this.$form.find('[type="reset"]');

        this.$stepsParent = $('.steps');
        this.$steps = this.$stepsParent.find('button');
    },

    htmlClasses: {
        activeClass: 'active',
        hiddenClass: 'hidden',
        visibleClass: 'visible',
        editFormClass: 'edit-form',
        animatedVisibleClass: 'animated fadeIn',
        animatedHiddenClass: 'animated fadeOut',
        animatingClass: 'animating'
    },

    setupAria() {
        // set first parent to visible
        this.$formStepParents.eq(0).attr('aria-hidden', false);

        // set all other parents to hidden
        this.$formStepParents.not(':first').attr('aria-hidden', true);

        // handle aria-expanded on next/prev buttons
        this.handleAriaExpanded();
    },

    nextButton() {
        this.$nextButton.on('click', (e) => {
            e.preventDefault();

            const $this = $(e.currentTarget),
                currentParent = $this.closest('fieldset'),
                nextParent = currentParent.next();

            if (this.checkForValidForm()) {
                currentParent.removeClass(this.htmlClasses.visibleClass);
                this.showNextStep(currentParent, nextParent);
            }
        });
    },

    prevButton() {
        this.$prevButton.on('click', (e) => {
            e.preventDefault();

            const $this = $(e.currentTarget),
                currentParent = $this.closest('fieldset'),
                prevParent = currentParent.prev();

            currentParent.removeClass(this.htmlClasses.visibleClass);
            this.showPrevStep(currentParent, prevParent);
        });
    },

    showNextStep(currentParent, nextParent) {
        currentParent
            .addClass(this.htmlClasses.hiddenClass)
            .attr('aria-hidden', true);

        nextParent
            .removeClass(this.htmlClasses.hiddenClass)
            .addClass(this.htmlClasses.visibleClass)
            .attr('aria-hidden', false)
            .find(':input').first().focus();

        this.handleState(nextParent.index());
        this.handleAriaExpanded();
    },

    showPrevStep(currentParent, prevParent) {
        currentParent
            .addClass(this.htmlClasses.hiddenClass)
            .attr('aria-hidden', true);

        prevParent
            .removeClass(this.htmlClasses.hiddenClass)
            .addClass(this.htmlClasses.visibleClass)
            .attr('aria-hidden', false)
            .find(':input').first().focus();

        this.handleState(prevParent.index());
        this.handleAriaExpanded();
    },

    handleAriaExpanded() {
        this.$nextButton.each((idx, item) => {
            const controls = $(item).attr('aria-controls');
            const expanded = $('#' + controls).attr('aria-hidden') === 'false';
            $(item).attr('aria-expanded', expanded);
        });

        this.$prevButton.each((idx, item) => {
            const controls = $(item).attr('aria-controls');
            const expanded = $('#' + controls).attr('aria-hidden') === 'false';
            $(item).attr('aria-expanded', expanded);
        });
    },

    validateForm() {
        const isProfileOrUpdate = window.location.href.includes('/profile') || window.location.href.includes('/users/edit/');

        const rules = {
            password: {
                required: !isProfileOrUpdate,
                maxlength: 50
            },
            confirm_password: {
                required: !isProfileOrUpdate,
                maxlength: 50,
                equalTo: "#password"
            },
            mobile: {
                required: true,
                validate_mobile: true,
                digits: true
            },
            otp: {
                required: true,
                digits: true,
                maxlength: 6,
                minlength: 6
            },
            email: {
                required: true,
                maxlength: 100,
                email: getCookie('dev') ? false : true,
                email_id: getCookie('dev') ? false : true
            },
            alternative_email: {
                maxlength: 100,
                email: true,
                email_id: true
            },
            alternative_contact_number: {
                validate_mobile: true,
                digits: true
            },
            name: {
                required: true,
                maxlength: 100
            }
        };

        this.$form.validate({
            ignore: ':hidden',
            rules: rules,
            errorElement: 'strong',
            errorClass: 'text-danger',
            errorPlacement: function (error, element) {
                const id = error.attr('id');
                if($(`#${id}`).length) $(`#${id}`).remove();
    
                error.appendTo(element.closest('.form-group'));
            },
            submitHandler: function (form) {
                submitForm(form);
            }
        });
    },

    checkForValidForm() {
        return this.$form.valid();
    },

    startOver() {
        const $parents = this.$formStepParents,
            $firstParent = this.$formStepParents.eq(0),
            $formParent = this.$formParent,
            $stepsParent = this.$stepsParent;

        this.$resetButton.on('click', () => {
            $parents
                .removeClass(this.htmlClasses.visibleClass)
                .addClass(this.htmlClasses.hiddenClass)
                .eq(0).removeClass(this.htmlClasses.hiddenClass)
                .addClass(this.htmlClasses.visibleClass);

            $formParent.removeClass(this.htmlClasses.editFormClass);

            this.handleState(0);
            this.setupAria();

            setTimeout(() => {
                $firstParent.focus();
            }, 200);
        });
    },

    handleState(step) {
        this.$steps.eq(step).prevAll().removeAttr('disabled');
        this.$steps.eq(step).addClass(this.htmlClasses.activeClass);

        if (step === 0) {
            this.$steps
                .removeClass(this.htmlClasses.activeClass)
                .attr('disabled', 'disabled');
            this.$steps.eq(0).addClass(this.htmlClasses.activeClass);
        }
    },

    editForm() {
        this.$editButton.on('click', () => {
            this.$formParent.toggleClass(this.htmlClasses.editFormClass);
            this.$formStepParents.attr('aria-hidden', false);
            this.$formStepParents.eq(0).find('input').eq(0).focus();
            this.handleAriaExpanded();
        });
    },

    killEnterKey() {
        $(document).on('keypress', ':input:not(textarea,button)', (event) => {
            return event.keyCode !== 13;
        });
    },

    handleStepClicks() {
        const $stepTriggers = this.$steps,
            $stepParents = this.$formStepParents;

        $stepTriggers.on('click', (e) => {
            e.preventDefault();

            const btnClickedIndex = $(e.currentTarget).index();

            $stepTriggers.nextAll()
                .removeClass(this.htmlClasses.activeClass)
                .attr('disabled', true);

            $(e.currentTarget)
                .addClass(this.htmlClasses.activeClass)
                .attr('disabled', false);

            $stepParents
                .removeClass(this.htmlClasses.visibleClass)
                .addClass(this.htmlClasses.hiddenClass)
                .attr('aria-hidden', true);

            $stepParents.eq(btnClickedIndex)
                .removeClass(this.htmlClasses.hiddenClass)
                .addClass(this.htmlClasses.visibleClass)
                .attr('aria-hidden', false)
                .focus();
        });
    }
};

$(document).ready(() => {
    if ($('.multi-step-form').length > 0) {
        app.init();
    }

    if ($('.callback-check').length > 0) {
        $('.callback-check').each(function() {
            $(this).focusout(function() {
                const value = $(this).val();

                if(value !== '') {
                    const href = $(this).data('href');
                    const existing = $(this).data('existing');
                    const form = $('<form>', { action: `${$base_url}${href}`, method: "get" });
                    form.append($('<input>', { type: 'text', name: 'item', value: value }));
                    form.append($('<input>', { type: 'text', name: 'existing', value: existing }));

                    submitForm(form);
                }
            });
        });
    }
});

$(document).on("click", ".quotation-pdf-preview", function(){
    const pdfContent = $(this).siblings('textarea').val();

    if(pdfContent !== '') {
        $.ajax({
            url: `${$base_url}leads/preview-quotation-pdf`,
            type: "post",
            data: {
                quotation: pdfContent
            },
            xhrFields: {
                responseType: 'blob'
            },
            beforeSend: function() {
                $('#iframe-pdf').html('Please wait pdf is loading...');
            },
            error: function(jqXHR) {
                $('#iframe-pdf').html("Something went wrong! Please go back & try again!");
            },
            success: function(data) {
                const blob = new Blob([data], { type: 'application/pdf' });
                const url = URL.createObjectURL(blob);
                $('#iframe-pdf').html(`<iframe style="height: 500px; width: 100%;" src="${url}" frameborder="0" id="iframe-pdf"></iframe>`);
            }
        });
    }
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