$(document).ready(function() {
    var table = $('#history-workers');
    table.DataTable({
        columns: [
            {'title': 'Работник', data: 'worker_name'},
            {'title': 'Станок', data: 'machine_name'},
            {'title': 'Статус', data: 'status'},
            {'title': 'Начало работы', data: 'start_date'},
            {'title': 'Закончил', data: 'end_date'}
        ],
        ajax: {
            'url': '/api/worker-history/' + table.attr('data-id')
        },
        'processing': true,
        'serverSide': true,
        "aoColumnDefs": [
            {"bSortable": false, "aTargets": [0, 1, 2, 3, 4]},
            {"bSearchable": false, "aTargets": [0, 1, 2, 3, 4]}
        ],
        sDom: 'lrtip'
    });
});
