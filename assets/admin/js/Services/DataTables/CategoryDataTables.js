import dt from 'datatables.net-dt';
import AppHelperService from "../../../../js/Helper/AppHelperService";

export default (() => {
    let Public = {},
        Private = {};

    Private.tableRef = $('#data-table');

    Public.init = () => {
        let options = {
            serverSide: true,
            ajax: {
                url: Routing.generate('admin.get_category_list'),
                type: 'POST'
            },
            columns: [
                { data: 'id', name: 'id', title: 'Id' },
                { data: 'title', name: 'title', title: 'Naziv' },
                { data: 'parent', name: 'parent', title: 'Glavna kategorija' },
                { data: 'status_text', name: 'status', title: 'Status', width: '200px', render: function (data, type, row, meta) {
                        const checkedAttr = row.status === 2 ? 'checked' : '';

                        let html = CAN_EDIT ? `<p class="status-text">${data}</p><input type="checkbox" class="set-active" data-id="${row.id}" ${checkedAttr}/>` : `<p class="status-text">${data}</p>`;

                        if (row.status === 3) {
                            html = `<p class="status-text">${data}</p>`;
                        }

                        return type === 'display' ? html : data;
                    } },
                { data: 'wear', name: 'wear', title: 'Tip', render: function (data, type, row, meta) {
                    return Translator.trans(data, null, 'messages', LOCALE).toUpperCase();
                }},
                { data: 'slug', orderable: false, render: function (data, type, row, meta) {
                    const editLink = CAN_EDIT ? `<a class="btn btn-outline-primary" href="${AppHelperService.generateLocalizedUrl('admin.edit_category_page', {slug: data})}">Izmeni</a> ` : '';
                    const removeButton = CAN_REMOVE ?`<button class="btn btn-outline-danger remove-item-button" data-slug="${data}">Ukloni</button>` : '';

                        return type === 'display' ?
                            editLink+removeButton :
                            data;
                }},
            ],
            order: [[0, 'desc']],
            pageLength: 100,
        };

        Private.tableRef.DataTable(options);
    };

    Public.reload = () => {
        Private.tableRef.DataTable().ajax.reload(null, false);
    };

    return Public;
});
