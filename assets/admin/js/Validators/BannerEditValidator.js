require ('../../../js/Validators/ValidationRuleHelper');

class BannerEditValidator {
    constructor() {
        if (!BannerEditValidator.instance) {
            BannerEditValidator.instance = this;
        }

        return BannerEditValidator.instance;
    }

    validate(form) {
        let options;

        options = {
            rules: {
                position: 'required',
                banner: {
                    dropZoneHasImage: true,
                    dropZoneHasMainImage: true,
                },
                banner_mobile: {
                    dropZoneHasImage: true,
                    dropZoneHasMainImage: true,
                }
            },
        };

        for(const [locale, data] of Object.entries(LOCALES)) {
            options.rules[`${locale}_button`] = {required: true};
            options.rules[`${locale}_link`] = {required: true};
        }

        $.extend(options, window.helpBlock);

        return form.validate(options);
    }
}

const bannerEditValidator = new BannerEditValidator();

Object.freeze(bannerEditValidator);

export default bannerEditValidator;
