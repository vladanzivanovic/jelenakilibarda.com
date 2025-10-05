import paymentEditMapper from "../Mapper/PaymentEditMapper";

require ('../../../js/Validators/ValidationRuleHelper');

class PaymentEditValidator {
    constructor() {
        this.mapper = paymentEditMapper;

        if (!PaymentEditValidator.instance) {
            PaymentEditValidator.instance = this;
        }

        return PaymentEditValidator.instance;
    }

    validate() {
        let options;

        options = {
            rules: {
                'shipping[]': 'isMultiSelectBoxEmpty',
                'payment_type': 'required',
            },
        };

        for(const [locale, data] of Object.entries(LOCALES)) {
            options.rules[`title_${locale}`] = 'required';
            options.rules[`description_${locale}`] = 'required';
        }

        $.extend(options, window.helpBlock);

        return $(this.mapper.form).validate(options);
    }
}

const paymentEditValidator = new PaymentEditValidator();

Object.freeze(paymentEditValidator);

export default paymentEditValidator;
