import SummerNote from "../Services/SummerNote";
import DropZone from "../../../js/Services/DropZoneService";
import biographyMapper from "../Mapper/BiographyMapper";
import BiographyService from "../Services/BiographyService";
import biographyValidator from "../Validators/DescriptionValidator";
import BiographyHandler from "../Handler/BiographyHandler";
import CatalogDataTables from "../Services/DataTables/CatalogDataTables";
import NotificationService from "../../../js/NotificationService";
import ConfirmationModalService from "../Services/ConfirmationModalService";
import CatalogHandler from "../Handler/CatalogHandler";
import VideoDataTables from "../Services/DataTables/VideoDataTables";
import VideoHandler from "../Handler/VideoHandler";

const Private = Symbol('private');

class VideoController {
    constructor() {
        if (CAN_VIEW) {
            VideoDataTables().init();
        }
        this.notification = NotificationService();
        this.handler = new VideoHandler();

        this[Private](this.handler).registerEvents();
    }

    /**
     *
     * @param {VideoHandler} handler
     * @returns {{}}
     */
    [Private](handler) {
        let Private = {};

        Private.registerEvents = () => {
            $(document).on('click touchend', '.remove-item-button', e => {
                const id = e.currentTarget.dataset.id;
                const buttons = [
                    {type: 'button', text: 'Obriši', 'class': 'btn btn-primary remove-item', 'data-id': id, 'data-dismiss': "modal"},
                ];
                const title = 'Da li ste sigurni da želite obrišete video?';
                const confirmModal = new ConfirmationModalService(title, buttons);

                confirmModal.trigger('show');
            });

            $(document).on('click touchend', '.remove-item', e => {
                const id = e.currentTarget.dataset.id;

                handler.remove(id);
            });


            $(document).on('change', '.set-active-item', e => {
                const id = e.currentTarget.dataset.id;
                const status = e.currentTarget.checked ? 2 : 1;

                handler.changeStatus(e.currentTarget, id, status);
            });
        }

        return Private;
    }
}

export default VideoController;
