import countryEditMapper from "../Mapper/CountryEditMapper";

require ('../../../js/Validators/ValidationRuleHelper');

class CountryEditValidator {
    constructor() {
        this.mapper = countryEditMapper;

        if (!CountryEditValidator.instance) {
            CountryEditValidator.instance = this;
        }

        return CountryEditValidator.instance;
    }

    validate() {
        let options;

        options = {
            rules: {
                code: {
                    required: true,
                    maxlength: 2
                },
                currency: {
                    isSelectBoxEmpty: true
                },
            },
        };

        for(const [locale, data] of Object.entries(LOCALES)) {
            options.rules[`title_${locale}`] = 'required';
        }

        $.extend(options, window.helpBlock);

        return $(this.mapper.form).validate(options);
    }
}

const countryEditValidator = new CountryEditValidator();

Object.freeze(countryEditValidator);

export default countryEditValidator;
