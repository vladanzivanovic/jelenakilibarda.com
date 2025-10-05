import categoryEditMapper from "../Mapper/CategoryEditMapper";

require ('../../../js/Validators/ValidationRuleHelper');

class CategoryEditValidator {
    constructor() {
        if (!CategoryEditValidator.instance) {
            this.mapper = categoryEditMapper;
            CategoryEditValidator.instance = this;
        }

        return CategoryEditValidator.instance;
    }

    validate() {
        let options;

        options = {
            rules: {
                wear_category: {
                    required: true,
                },
            },
        };

        for(const [locale, data] of Object.entries(LOCALES)) {
            options.rules[`${locale}_title`] = 'required';
        }

        $.extend(options, window.helpBlock);

        return $(this.mapper.form).validate(options);
    }
}

const categoryEditValidator = new CategoryEditValidator();

Object.freeze(categoryEditValidator);

export default categoryEditValidator;
