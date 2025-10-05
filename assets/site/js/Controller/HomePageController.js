require('magnific-popup');

class HomePageController {
    constructor() {
        $(".lightbox-gallery-2").magnificPopup({
            gallery: {
                enabled: true
            },
            mainClass: "mfp-fade"
        });
        $(".lightbox-video-1").magnificPopup({
            gallery: {
                enabled: true,
            },
            type: 'iframe',
            mainClass: "mfp-fade",
            preloader: false,
        });
    }
}

export default HomePageController;
