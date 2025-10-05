import CoreController from "../CoreController";
import HomePageController from "./HomePageController";
import GalleryPageController from "./GalleryPageController";
import VideoPageController from "./VideoPageController";
import ContactPageController from "./ContactPageController";
import DescriptionPageController from "./DescriptionPageController";

let routes = [
    {
        name: 'site.home_page',
        controller: HomePageController,
    },
    {
        name: 'site.gallery_page',
        controller: GalleryPageController,
    },
    {
        name: 'site.video_page',
        controller: VideoPageController,
    },
    {
        name: 'site.contact_page',
        controller: ContactPageController,
    },
    {
        name: 'site.biography_page',
        controller: DescriptionPageController,
    },
    {
        name: 'site.repertoire_page',
        controller: DescriptionPageController,
    },
];

$(document).ready(() => {
    let route = matchRoute();

    let core = new CoreController();

    core.baseCore.showFlashMsg();
    // core.siteMobileMenu();

    if (route) {
        new route.controller();
    }
});

let matchRoute = () => {
    for(let i in routes) {
        let route = routes[i];

        if (route.name === ROUTE_NAME) {
            return route;
        }
    }
};
