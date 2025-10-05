import descriptionEditMapper from "../Mapper/DescriptionEditMapper";

require ('../../../js/Validators/ValidationRuleHelper');

class DescriptionValidator {
    constructor() {
        if (!DescriptionValidator.instance) {
            this.mapper = descriptionEditMapper;
            DescriptionValidator.instance = this;
        }

        return DescriptionValidator.instance;
    }

    validate() {
        let options;

        options = {
            ignore: '',
            rules: {},
        };

        for(const [locale, data] of Object.entries(LOCALES)) {
            options.rules[`description_${locale}`] = {
                setErrorIfSummernoteIsEmpty: true
            };
        }

        $.extend(options, window.helpBlock);

        return $(this.mapper.form).validate(options);
    }
}

const descriptionValidator = new DescriptionValidator();

Object.freeze(descriptionValidator);

export default descriptionValidator;
