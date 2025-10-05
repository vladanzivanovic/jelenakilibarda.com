require ('../../../js/Validators/ValidationRuleHelper');

class AboutUsEditValidator {
    constructor() {
        if (!AboutUsEditValidator.instance) {
            AboutUsEditValidator.instance = this;
        }

        return AboutUsEditValidator.instance;
    }

    validate(form) {
        let options;

        options = {
            ignore: '',
            rules: {},
        };

        for(const [locale, data] of Object.entries(LOCALES)) {
            options.rules[`${locale}_description`] = 'setErrorIfSummernoteIsEmpty';
        }

        $.extend(options, window.helpBlock);

        return $(form).validate(options);
    }
}

const aboutUsEditValidator = new AboutUsEditValidator();

Object.freeze(aboutUsEditValidator);

export default aboutUsEditValidator;
