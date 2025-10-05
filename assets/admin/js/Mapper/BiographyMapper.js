class BiographyMapper {
    constructor() {
        if (!BiographyMapper.instance) {
            this.form = '#edit_form';
            this.submitBtn = '#submit_btn';

            for(const [locale, data] of Object.entries(LOCALES)) {
                this[`description_${locale}`] = '#description_'+locale;
            }

            BiographyMapper.instance = this;
        }

        return BiographyMapper.instance;
    }
}

const biographyMapper = new BiographyMapper();
Object.freeze(biographyMapper);
export default biographyMapper;
