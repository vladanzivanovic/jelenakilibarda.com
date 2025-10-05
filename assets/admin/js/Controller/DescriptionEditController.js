import SummerNote from "../Services/SummerNote";
import descriptionEditMapper from "../Mapper/DescriptionEditMapper";
import DescriptionHandler from "../Handler/DescriptionHandler";
import DropZone from "../../../js/Services/DropZoneService";
import descriptionValidator from "../Validators/DescriptionValidator";
require ('select2/dist/js/select2.full.min');

class DescriptionEditController {
    constructor() {
        this.mapper = descriptionEditMapper;
        this.summernote = new SummerNote();
        this.handler = new DescriptionHandler();
        this.dropZone = DropZone();
        this.validator = descriptionValidator;

        this.dropZone.init($('[data-files="description"]'));

        for(const [locale, data] of Object.entries(LOCALES)) {
            let description = $(this.mapper[`desc_${locale}`]);

            this.summernote.initialize(
                description,
                this.summernote.createCallBacksSummernote(description, 'description')
            );
        }
        $('.dropdown-toggle').dropdown();

        if (IS_EDIT) {
            this.dropZone.setFiles(IMAGES, 'description');
        }

        this.validator.validate();

        this.registerEvents();
    }

    registerEvents()
    {
        $(this.mapper.submitBtn).on('click touchend', (e) => {
            e.preventDefault();
            e.stopPropagation();

            this.handler.save();
        });
    }
}

export default DescriptionEditController;
