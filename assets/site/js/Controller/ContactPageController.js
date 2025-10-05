import contactPageMapper from "../Mapper/ContactPageMapper";
import contactPageValidation from "../Validators/ContactPageValidation";
import ContactPageHandler from "../Handler/ContactPageHandler";

class ContactPageController {
    constructor() {
        this.mapper = contactPageMapper;
        this.validator = contactPageValidation;
        this.handler = new ContactPageHandler();

        this.validator.validate();

        this.registerEvents();
    }

    registerEvents() {
        $(this.mapper.submitBtn).on('click touchend', e => {
            e.preventDefault();
            e.stopPropagation();

            this.handler.save();
        });
    }
}

export default ContactPageController;
