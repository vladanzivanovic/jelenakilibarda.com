import 'webpack-jquery-ui';

class SortableFactory {
    constructor() {
        this.defaultOptions = {
            forcePlaceholderSize: true,
            placeholder: "placeholder"
        }
    }

    create(elm, options)
    {
        options = {...this.defaultOptions, ...options};

        elm.sortable(options);
    }
}

export default SortableFactory;
