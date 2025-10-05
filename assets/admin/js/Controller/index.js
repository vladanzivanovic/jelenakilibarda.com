import CoreController from "../../../js/CoreController";
import SliderEditController from "./SliderEditController";
import SliderController from "./SliderController";
import SettingsPageController from "./SettingsPageController";
import BlogController from "./BlogController";
import BlogEditController from "./BlogEditController";
import DescriptionController from "./DescriptionController";
import DescriptionEditController from "./DescriptionEditController";
import CatalogController from "./CatalogController";
import CatalogEditController from "./CatalogEditController";
import BiographyController from "./BiographyController";
import VideoController from "./VideoController";
import VideoEditPageController from "./VideoEditPageController";
import LoginPageController from "./LoginPageController";

let routes = [
    {
        name: 'admin.dashboard',
        controller: SettingsPageController,
    },
    {
        name: 'admin.add_slider_page',
        controller: SliderEditController,
    },
    {
        name: 'admin.sliders',
        controller: SliderController,
    },
    {
        name: 'admin.edit_slider_page',
        controller: SliderEditController,
    },
    {
        name: 'admin.settings_page',
        controller: SettingsPageController,
    },
    {
        name: 'admin.add_blog_page',
        controller: BlogEditController,
    },
    {
        name: 'admin.blog',
        controller: BlogController,
    },
    {
        name: 'admin.edit_blog_page',
        controller: BlogEditController,
    },
    {
        name: 'admin.save_catalog_page',
        controller: CatalogEditController,
    },
    {
        name: 'admin.login',
        controller: LoginPageController,
    },
    {
        name: 'admin.descriptions',
        controller: DescriptionController,
    },
    {
        name: 'admin.add_description_page',
        controller: DescriptionEditController,
    },
    {
        name: 'admin.edit_description_page',
        controller: DescriptionEditController,
    },
    {
        name: 'admin.biography',
        controller: BiographyController,
    },
    {
        name: 'admin.video_page',
        controller: VideoController,
    },
    {
        name: 'admin.add_video_page',
        controller: VideoEditPageController,
    },
    {
        name: 'admin.edit_video_page',
        controller: VideoEditPageController,
    },
];

$(document).ready(() => {
    let route = matchRoute();

    let core = new CoreController();

    core.showFlashMsg();
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
