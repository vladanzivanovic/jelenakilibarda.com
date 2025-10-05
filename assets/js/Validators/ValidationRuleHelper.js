require('jquery-validation/dist/additional-methods');
require('./CustomMethods');

jQuery.extend(jQuery.validator.messages, {
    required: Translator.trans('field.not_blank', null, 'validators', LOCALE),
    remote: Translator.trans('field.email_exists', null, 'validators', LOCALE),
    email: Translator.trans('field.email', null, 'validators', LOCALE),
    url: Translator.trans('field.invalid_url', null, 'validators', LOCALE),
    date: Translator.trans('field.date_not_valid', null, 'validators', LOCALE),
    dateISO: Translator.trans('field.date_not_valid_iso', null, 'validators', LOCALE),
    number: Translator.trans('field.number_is_not_valid', null, 'validators', LOCALE),
    digits: Translator.trans('field.digits', null, 'validators', LOCALE),
    creditcard: Translator.trans('field.credit_card', null, 'validators', LOCALE),
    equalTo: Translator.trans('field.equal_to', null, 'validators', LOCALE),
    maxlength: $.validator.format(Translator.trans('field.max_length', {'limit': '{0}'}, 'validators', LOCALE)),
    minlength: $.validator.format(Translator.trans('field.min_length', {'limit': '{0}'}, 'validators', LOCALE)),
    alphanumeric: Translator.trans('field.alphanumeric', null, 'validators', LOCALE),
});

window.helpBlock = {
    errorElement: "em",
    errorPlacement: function (error, element) {
        // Add the `help-block` class to the error element
        error.addClass("help-block");
        element.addClass('input-error');
        const parent = element.parent();
        const nextElement = element.next();

        if (element.prop("type") === "checkbox") {

            const wrapperId = element.data('error-after');

            if (wrapperId) {
                error.insertAfter($(wrapperId));
            } else {
                error.insertAfter(element.parent("label"));
            }
        } else if (element.prop("type") === "radio") {
            let name = $(element).prop('name');
            let errorElement = $(`input[name="${name}"][data-show-error-after="yes"]`);

            error.insertAfter(errorElement.next());
        } else if (element.prop('nodeName') === 'SELECT') {
            if (nextElement.is('.bootstrap-select')) {
                error.insertAfter(element.next());
            } else if (element.hasClass('custom-select')) {
                error.insertAfter(element);
            } else if (element.data('showErrorElm')) {
                    $(element.data('showErrorElm')).append(error);
            } else {
                error.insertAfter(parent);
            }
        } else if (element.prop('id') === 'dropzone-input') {
            parent.parent().addClass('dropzone--error');
            error.insertAfter(parent);
        } else if (nextElement.hasClass('note-editor')) {
            error.insertAfter(nextElement);
            nextElement.addClass('input-error');
        } else {
            error.insertAfter(element);
        }
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass('input-error');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('input-error');
    },
    invalidHandler: function(form, validator) {
        var errors = validator.numberOfInvalids();
        if (errors) {
            let element = $(validator.errorList[0].element);
            const nextElement = element.next();

            if ((element.is(":visible") || nextElement.is('.note-editor')) && element.parents('.popup-content').length === 0) {
                $('html, body').animate({
                    scrollTop: $(validator.errorList[0].element).offset().top - 100
                }, 1000);

                element.focus();
            }
        }
    }
};