import productEditMapper from "../Mapper/ProductEditMapper";

require ('../../../js/Validators/ValidationRuleHelper');

class ProductEditValidator {
    constructor() {
        this.mapper = productEditMapper;

        if (!ProductEditValidator.instance) {
            ProductEditValidator.instance = this;
        }

        return ProductEditValidator.instance;
    }

    validate() {
        let options;

        options = {
            rules: {
                'categories[]': 'isMultiSelectBoxEmpty',
                'sizes[]': 'isMultiSelectBoxEmpty',
                code: {
                    required: true,
                },
                art: {
                    required: true,
                },
                price: {
                    required: true,
                    number: true,
                },
                discount: 'number',
                heel_height: 'number',
                color: 'isSelectBoxEmpty',
                // 'cleaning[]': 'required',
                product: {
                    dropZoneHasImage: true,
                    dropZoneHasMainImage: true,
                }
            },
        };

        for(const [locale, data] of Object.entries(LOCALES)) {
            options.rules[`title_${locale}`] = 'required';
            options.rules[`short_description_${locale}`] = 'required';
            options.rules[`description_${locale}`] = 'required';
            options.rules[`remark_${locale}`] = 'required';
            options.rules[`structure_${locale}`] = 'required';
        }

        $.extend(options, window.helpBlock);

        return $(this.mapper.form).validate(options);
    }
}

const productEditValidator = new ProductEditValidator();

Object.freeze(productEditValidator);

export default productEditValidator;
