import BaseCoreController from "../../js/CoreController";
import loader from "./Dom/LoaderDom";
import coreMapper from "./Mapper/CoreMapper";
import GdprService from "./Service/GdprService";

require('gdpr-cookie/gdpr-cookie');

class CoreController {
    constructor() {
        this.baseCore = new BaseCoreController();
        this.mapper = coreMapper;
        // this.registrationValidator = registrationValidator;
        // this.resetPasswordValidator = resetPasswordValidator;
        this.gdprService = new GdprService();

        loader;

        this.registerEvents();

        this.gdprService.init();
    }

    registerEvents() {
    }
}

export default CoreController;
