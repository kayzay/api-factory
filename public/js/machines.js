$(document).ready(function() {
    var loader = {
        show: function () {
            $('.spinner-border').css('visibility', 'visible')
        },
        hidden: function () {
            $('.spinner-border').css('visibility', 'hidden')
        }
    },
     linkSow = $("input[name=r_show_list]").val(),
     linkHistory =  $("input[name=history]").val();
    
    var dt = $('#machines').DataTable({
        columns: [
            {'title': '#', data: 'id',  width: "10%"},
            {'title': 'name', data: 'name', width: "50%"},
            {
                "class": "",
                "orderable": false,
                "data": "",
                "defaultContent": ""
            }
        ],
        ajax: 'api/machines',
        paging: false,
        sDom: 'lrtip',
        rowCallback: function(row, data, index) {
            $td = $(row).children().last();

            var _linkHistory = linkHistory.replace("number", data.id);
            
            $td.html(
                "<button class='btn btn-secondary details-control'>Кто работает за станком</button>" +
                "<a href='" + _linkHistory + "' class='btn  btn-info' target='_blank'>История</a>"
            );
        }
    });
    var detailRows = [];
    $('#machines tbody').on('click', '.details-control', function () {
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


    function format(d) {
        var table = "<table class='table tb-info'>" +
            "<tr>" +
            "<th>Работник</th>" +
            "<th></th>" +
            "</tr>" +
            "{content}" +
            "</table>";
        var tr = '';
        d.map(function (p1) {
            tr += "<tr>" +
                "<td>" + p1.name + "</td>" +
                "</tr>";
        });
        if (tr === '') {
            tr+= "<tr colspan='2'>" +
                "<td>Свободен</td>" +
                "</tr>";
        }
        return table.replace("{content}", tr);
    }
});
