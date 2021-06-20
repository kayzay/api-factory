$(document).ready(function() {
    var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
        keyboard: false
    });
    var loader = {
        show: function () {
            $('.spinner-border').css('visibility', 'visible')
        },
        hidden: function () {
            $('.spinner-border').css('visibility', 'hidden')
        }
    };
    var linkSow = $("input[name=r_show_list]").val(),
        linkHistory =  $("input[name=history]").val(),
     selectedmMchines = {
        worker_id: '',
        machines_id: ''
    };
    var dt = $('#workers').DataTable({
   columns: [
            {'title': '#', data: 'id'},
            {'title': 'name', data: 'name'},
            {
                "class": "",
                "orderable": false,
                "data": "",
                "defaultContent": ""
            }
        ],
        ajax: '/api/workers',
        paging: false,
        sDom: 'lrtip',
        rowCallback: function(row, data, index) {
            $td = $(row).children().last();
            var _linkHistory = linkHistory.replace("number", data.id);

            $td.html(
                "<button class='btn btn-secondary details-control'>Список станков</button>" +
                "<button class='btn btn-warning show-modal' style='margin-right: 1rem;'>Добавить станок</button>" +
                "<a href='" + _linkHistory + "' class='btn  btn-info' target='_blank'>История</a>"
            );
        },
        "columnDefs": [
            { "width": "10%", "targets": 0 },
            { "width": "40%", "targets": 1 },
            { "width": "40%", "targets": 2 }
        ]
    });


    var detailRows = [];

    $('#workers tbody').on('click', '.details-control', function () {
        var tr = $(this).parent().closest('tr');
        var row = dt.row(tr);
        var idx = $.inArray(tr.attr('id'), detailRows);

        if (row.child.isShown()) {
            tr.removeClass('details');
            row.child.hide();

            detailRows.splice(idx, 1);
        }
        else {
            tr.addClass('details');
            loader.show();
            selectedmMchines.worker_id = row.data().id;
            $.ajax({
                url: linkSow.replace("number",  row.data().id),
                success: function(data) {
                    row.child(format(data.data)).show();
                    loader.hidden();
                }});
            // Add to the 'open' array
            if (idx === -1) {
                detailRows.push(tr.attr('id'));
            }

        }
    });

// On each draw, loop over the `detailRows` array and show any child rows
    dt.on('draw', function () {
        $.each(detailRows, function (i, id) {
            $('#' + id + ' td.details-control').trigger('click');
        });
    });

    $('table').on('click', '.show-modal', function (e) {
        var tr = $(this).parent().closest('tr');
        var row = dt.row(tr);

        selectedmMchines.worker_id = row.data().id;

        $('.form-select option').remove();

        var ajaxLink = $("input[name=show_list]").val();
        ajaxLink = ajaxLink.replace("number",  row.data().id);
        loader.show();
       $.ajax({
            url: ajaxLink,
            success: function(data) {
                var select = document.getElementsByClassName('form-select')[0];
                var mess =  $('p.mess'),
                    list = Object.keys(data.data);
                mess.css('display', 'none');
                if (list.length) {
                    select.style.display = 'block';
                    list.map(function (p1) {
                        var opt = document.createElement('option');
                        opt.value = p1;
                        opt.innerHTML = data.data[p1];
                        select.appendChild(opt);
                    });
                } else {
                    select.style.display = 'none';
                    mess.css('display', 'block');
                    mess.text('Сободных станков нет');
                }
                loader.hidden();
                myModal.show();
            }});
    });

    $('table').on('click', '.removed', function (e) {

        var ajaxLink = $("input[name=remove_queue]").val();
        ajaxLink = ajaxLink.replace("number", this.getAttribute('data-id'));
        loader.show();
        $.ajax({
            url: ajaxLink,
            type: 'DELETE',
            success: function(result) {
                if (result.status == '1')
                    changeTable(selectedmMchines.worker_id);
                loader.hidden();
            }
        });

    });

    $('.add-to-list').on('click', function () {
        selectedmMchines.machines_id = $('.form-select').val();
        var ajaxLink = $("input[name=add_to_list]").val();
        $.ajax({
            url: ajaxLink,
            type: 'POST',
            data: selectedmMchines,
            success: function(data) {
                changeTable(selectedmMchines.worker_id);
                myModal.hide();
            }
        });
    });

function changeTable(worker_id) {
    var tr = $("#id_" + worker_id).parent();;
    if (tr.length) {
        $.ajax({
            url: linkSow.replace("number", worker_id),
            success: function(data) {
                tr.find(".tb-info").remove();
                tr.append(format(data.data)).show();
            }});
    }
}

function format(d) {
        var  id = selectedmMchines.worker_id;

        var table = "<table class='table tb-info' id='id_" + id + "'>" +
            "<tr>" +
            "<th>Станки</th>" +
            "<th></th>" +
            "</tr>" +
            "{content}" +
            "</table>";
        var tr = '';
        d.map(function (p1) {
            tr += "<tr>" +
                "<td>" + p1.name + "</td>" +
                "<td>" +
                "<button type='button' class='btn btn-danger removed' data-id='"+p1.queue_id+"'>Освободить станок</button>" +
                "</td>" +
                "</tr>";
        });
        if (tr === '') {
            tr+= "<tr colspan='2'>" +
                "<td>Не где не работает</td>" +
                "</tr>";
        }
        return table.replace("{content}", tr);
    }
});

