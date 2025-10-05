import biographyMapper from "../Mapper/BiographyMapper";

require ('../../../js/Validators/ValidationRuleHelper');

class VideoEditValidator {
    constructor() {
        if (!VideoEditValidator.instance) {
            this.mapper = biographyMapper;
            VideoEditValidator.instance = this;
        }

        return VideoEditValidator.instance;
    }

    validate() {
        let options;

        options = {
            rules: {
                // youtubeUrl: {
                //     required: true,
                // }
            },
        };

        for(const [locale, data] of Object.entries(LOCALES)) {
            options.rules[`title_${locale}`] = {
                required: true
            };
            options.rules[`description_${locale}`] = {
                required: true
            };
        }

        $.extend(options, window.helpBlock);

        return $(this.mapper.form).validate(options);
    }
}

const videoEditValidator = new VideoEditValidator();

Object.freeze(videoEditValidator);

export default videoEditValidator;
