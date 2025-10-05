import dt from 'datatables.net-dt';
import AppHelperService from "../../../../js/Helper/AppHelperService";

export default (() => {
    let Public = {},
        Private = {};

    Private.tableRef = $('#data-table');

    Public.init = () => {
        Private.tableRef.DataTable( {
            serverSide: true,
            ajax: {
                url: Routing.generate(`admin.get_${ROUTE_SUB_NAME}_tags_list`),
                type: 'POST'
            },
            columns: [
                { data: 'id', name: 'id', title: 'Id' },
                { data: 'name', name: 'name', title: 'Naziv' },
                { data: 'id', orderable: false, render: function (data, type, row, meta) {
                    const editLink = CAN_EDIT ? `<a class="btn btn-outline-primary" href="${Routing.generate(`admin.edit_${ROUTE_SUB_NAME}_tag_page`, {id: data})}">Izmeni</a> ` : '';
                    const removeButton = CAN_REMOVE ?`<button class="btn btn-outline-danger remove-item-button" data-id="${data}">Ukloni</button>` : '';

                        return type === 'display' ?
                            editLink+removeButton :
                            data;
                    } },
            ],
            order: [[0, 'desc']],
            pageLength: 100,
        });
    };

    Public.reload = () => {
        Private.tableRef.DataTable().ajax.reload(null, false);
    };

    return Public;
});