require('magnific-popup');

class DescriptionPageController {
    constructor() {
        $(".lightbox-gallery-2").magnificPopup({
            gallery: {
                enabled: true
            },
            mainClass: "mfp-fade"
        });
    }
}

export default DescriptionPageController;
