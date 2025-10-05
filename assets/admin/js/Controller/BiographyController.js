import SummerNote from "../Services/SummerNote";
import DropZone from "../../../js/Services/DropZoneService";
import biographyMapper from "../Mapper/BiographyMapper";
import BiographyService from "../Services/BiographyService";
import biographyValidator from "../Validators/DescriptionValidator";
import BiographyHandler from "../Handler/BiographyHandler";

class BiographyController {
    constructor() {
        this.mapper = biographyMapper;
        this.service = new BiographyService();
        this.validator = biographyValidator;
        this.dropZone = DropZone();
        this.handler = new BiographyHandler();
        this.summernote = new SummerNote();

        this.dropZone.init($('[data-files="biography"]'));

        for(const [locale, data] of Object.entries(LOCALES)) {
            let description = $(this.mapper[`description_${locale}`]);

            this.summernote.initialize(
                description,
                this.summernote.createCallBacksSummernote(description, 'biography')
            );
        }
        $('.dropdown-toggle').dropdown();

        if (IS_EDIT) {
            this.dropZone.setFiles(IMAGES, 'biography');
        }

        this.validator.validate();

        this.registerEvents();
    }

    registerEvents()
    {
        $(this.mapper.submitBtn).on('click', (e) => {
            this.handler.save();
        });
    }
}

export default BiographyController;
