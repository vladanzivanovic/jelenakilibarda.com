import currencyEditMapper from "../Mapper/CurrencyEditMapper";

require ('../../../js/Validators/ValidationRuleHelper');

class CurrencyEditValidator {
    constructor() {
        this.mapper = currencyEditMapper;

        if (!CurrencyEditValidator.instance) {
            CurrencyEditValidator.instance = this;
        }

        return CurrencyEditValidator.instance;
    }

    validate() {
        let options;

        options = {
            rules: {
                exchange_rate: {
                    required: true,
                },
                code: {
                    required: true,
                    maxlength: 3
                }
            },
        };

        $.extend(options, window.helpBlock);

        return $(this.mapper.form).validate(options);
    }
}

const currencyEditValidator = new CurrencyEditValidator();

Object.freeze(currencyEditValidator);

export default currencyEditValidator;