class CategoryEditMapper {
    constructor() {
        if (!CategoryEditMapper.instance) {
            this.form = '#edit_form';
            this.parent = '#parent_category';
            this.submitBtn = '#category_submit';
            this.position = '#position';
            this.parentCategory = '#parent_category';

            for(const [locale, data] of Object.entries(LOCALES)) {
                this[`title_${locale}`] = '#title_'+locale;
            }

            CategoryEditMapper.instance = this;
        }

        return CategoryEditMapper.instance;
    }
}

const categoryEditMapper = new CategoryEditMapper();

Object.freeze(categoryEditMapper);

export default categoryEditMapper;
