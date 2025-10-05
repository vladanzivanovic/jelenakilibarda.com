class Select2Service {
    getAllOptions(element) {
        let data = [];
        const adapter = element.data().select2.dataAdapter;

        element.children().each(function () {
            if (!$(this).is('option') && !$(this).is('optgroup')) {
                return true;
            }
            data.push(adapter.item($(this)));
        });

        return data;
    }

    updateOptions(element) {
        element.trigger('change');
    }
}

export default Select2Service