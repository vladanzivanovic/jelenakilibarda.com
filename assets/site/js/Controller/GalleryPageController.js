require('magnific-popup');

class GalleryPageController {
    constructor() {
        $(".lightbox-gallery-2").magnificPopup({
            gallery: {
                enabled: true
            },
            mainClass: "mfp-fade"
        });
    }
}

export default GalleryPageController;
