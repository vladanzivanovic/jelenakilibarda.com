import DropZoneService from "../../../js/Services/DropZoneService";
import BannerHandler from "../Handler/BannerHandler";
import bannerEditValidator from "../Validators/BannerEditValidator";
import bannerEditMapper from "../Mapper/BannerEditMapper";

class BannerEditController {
    constructor() {
        this.mapper = bannerEditMapper;
        this.validator = bannerEditValidator;

        this.dropZoneBanner = DropZoneService();
        this.dropZoneBannerMobile = DropZoneService();
        this.dropZoneBanner.init($('[data-files="banner"]'));
        this.dropZoneBannerMobile.init($('[data-files="banner_mobile"]'));

        if (IS_EDIT) {
            this.dropZoneBanner.setFiles(IMAGES.desktop, 'banner');
            if (IMAGES.mobile) {
                this.dropZoneBannerMobile.setFiles(IMAGES.mobile, 'banner_mobile');
            }
        }

        this.validator.validate(this.mapper.form);

        this.registerEvents();

        $('#banner-select-box').trigger('change');
    }

    registerEvents() {
        this.mapper.submitBtn.on('click touchend', e => {
            const handler = new BannerHandler();

            handler.save(this.mapper);
        });

        $(document).on('change', '#banner-select-box', e => {
            const type = $(e.currentTarget).val();

            if (type == 2 || type == 3) {
                $('.links').fadeOut();
                $('.links').addClass('hide');

                return;
            }

            if (type == 4) {
                $('.btn-text').fadeOut();
                $('.btn-text').addClass('hide');

                return;
            }

            $('.links').fadeIn();
            $('.links').removeClass('hide');

            $('.btn-text').fadeIn();
            $('.btn-text').removeClass('hide');
        });
    }
}

export default BannerEditController;
