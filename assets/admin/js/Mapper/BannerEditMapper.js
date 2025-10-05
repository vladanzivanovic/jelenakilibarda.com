class BannerEditMapper {
    constructor() {
        if (!BannerEditMapper.instance) {
            this.form = $('#edit_form');
            this.submitBtn = $('#banner_submit');

            for(const [locale, data] of Object.entries(LOCALES)) {
                this[`description_${locale}`] = '#description_'+locale;
                this[`button_${locale}`] = '#button_'+locale;
                this[`link_${locale}`] = '#link_'+locale;
            }

            BannerEditMapper.instance = this;
        }

        return BannerEditMapper.instance;
    }
}

const bannerEditMapper = new BannerEditMapper();

Object.freeze(bannerEditMapper);

export default bannerEditMapper;
