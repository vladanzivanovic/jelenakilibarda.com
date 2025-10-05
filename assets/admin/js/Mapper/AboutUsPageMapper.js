class AboutUsPageMapper {
    constructor() {
        this.form = '#edit_form';

        for(const [locale, data] of Object.entries(LOCALES)) {
            this[`desc_${locale}`] = '#about_us_description_'+locale;
        }

        this.submitBtn = '#about_us_submit';

        if (!AboutUsPageMapper.instance) {
            AboutUsPageMapper.instance = this;
        }

        return AboutUsPageMapper.instance;
    }
}

const aboutUsPageMapper = new AboutUsPageMapper();

Object.freeze(aboutUsPageMapper);

export default aboutUsPageMapper;
