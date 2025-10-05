import baseFormMapper from "./BaseFormMapper";

class DescriptionEditMapper {
    constructor() {
        if (!DescriptionEditMapper.instance) {
            this.typeBox = '#description_select_box';

            for(const [locale, data] of Object.entries(LOCALES)) {
                this[`desc_${locale}`] = '#description_'+locale;
            }

            DescriptionEditMapper.instance = Object.assign(this, baseFormMapper);
        }

        return DescriptionEditMapper.instance;
    }
}

const descriptionEditMapper = new DescriptionEditMapper();

Object.freeze(descriptionEditMapper);

export default descriptionEditMapper;
