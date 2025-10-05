import dt from 'datatables.net-dt';
import NotificationService from "../../../../js/NotificationService";

export default (() => {
    let Public = {},
        Private = {};

    Private.tableRef = $('#data-table');
    Private.notification = NotificationService();


    Public.init = () => {
        Private.tableRef.DataTable( {
            serverSide: true,
            ajax: {
                url: Routing.generate('admin.get_product_list'),
                type: 'POST'
            },
            columns: [
                { data: 'codes', name: 'codes', title: 'Šifre' },
                { data: 'title', name: 'title', title: 'Naziv' },
                { data: 'price', name: 'price', title: 'Cena', type: "num" },
                { data: 'discount', name: 'discount', title: 'Popust', type: "num" },
                { data: 'sizes', name: 'sizes', title: 'Dostupne veličine' },
                { data: 'redeemed_sizes', name: 'redeemed_sizes', title: 'Otkupljene veličine' },
                { data: 'extra_status_text', name: 'extra_status', title: 'Stanje' },
                { data: 'status_text', name: 'status', title: 'Status', width: '200px', render: function (data, type, row, meta) {
                    const checkedAttr = row.status === 2 ? 'checked' : '';

                    let html = CAN_EDIT ? `<p class="status-text">${data}</p><input type="checkbox" class="set-active-product" data-id="${row.id}" ${checkedAttr}/>` : `<p class="status-text">${data}</p>`;

                    if (row.status === 3) {
                        html = `<p class="status-text">${data}</p>`;
                    }

                    return type === 'display' ? html : data;
                } },
                { data: 'position_text', name: 'show_home_page', title: 'Početna stranica', width: '200px', render: function (data, type, row, meta) {
                    let html = '';

                    if (data) {
                        html = `<p class="status-text d-block letter-capitalize">${Translator.trans(data, null, 'messages', LOCALE)}</p>`
                    }
;
                    return type === 'display' ? html : data;
                } },
                { data: 'id', searchable: false, orderable: false, render: function (data, type, row, meta) {
                    const editLink = CAN_EDIT ? `<a class="btn btn-link" href="${Routing.generate('admin.edit_product_page', {id: data})}">Izmeni</a> ` : '';
                    const removeButton = CAN_REMOVE ?`<button class="btn btn-danger remove-item-button" data-id="${data}">Ukloni</button>` : '';

                        return type === 'display' ?
                            editLink+removeButton :
                            data;
                    } },
            ],
            order: [[0, 'desc']],
            pageLength: 100,
        })
            .on('search.dt', () => {
                Private.notification.showLoadingMessage();
            })
            .on('draw', () => {
                Private.notification.remove();
            });
    };

    Public.reload = () => {
        Private.tableRef.DataTable().ajax.reload(null, false);
    };

    return Public;
});
