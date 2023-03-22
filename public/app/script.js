//================================================= REQUEST AJAX CRUD ===============================================================================
function ajax_request(formData, controller, callback) {
    $.blockUI({
        baseZ: 2000,
        css: {
            border: "none",
            padding: "0px",
            backgroundColor: "#000",
            "-webkit-border-radius": "10px",
            "-moz-border-radius": "10px",
            opacity: 0.5,
            color: "#fff",
        },
        message: "<h2> Aguarde...</h2>",
    });

    $.ajax({
        type: "POST",
        data: formData,
        url: controller,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $.unblockUI();
            callback(data);
        },
        error: function () {
            $.unblockUI();
            errormessage(
                "Ocorreu um erro. Por favor contactar o administrador"
            );
        },
    });
}

var table;
function initTable(colunas, controller, tableId, dados) {
    // $.fn.dataTable.moment("DD/MM/YYYY HH:mm");
    // $.fn.dataTable.moment("DD/MM/YYYY");
    if (!tableId) {
        tableId = "#my-table";
    }
    //  tables = $(tableId).attr("class");
    table = $(tableId)
        .on("preXhr.dt", function (e, settings, data) {
            $(this).addClass("whirl");
            $(this).addClass("double-up");
        })
        .on("xhr.dt", function (e, settings, json, xhr) {
            $(this).removeClass("whirl");
            $(this).removeClass("double-up");
        })
        .DataTable({
            responsive: true,
            paging: true, // Table pagination
            ordering: false, // Column ordering
            info: true, // Bottom left status text
            //  'processing': true,
            language: {
                //"lengthMenu": "Display _MENU_ records per page",
                paginate: {
                    first: "Primeiro",
                    previous: "Anterior",
                    next: "Próximo",
                    last: "Último",
                },
                sInfo: "Apresentando página _PAGE_ de _PAGES_",
                infoFiltered: "(filtrado de _MAX_)",
                sSearch: "Pesquisar:",
                sLengthMenu: "_MENU_ items por página",
                sInfoEmpty: "",
                sZeroRecords: '<div class="empty-table">Vázio</div>',
                sProcessing: "Loading...",
            },
            ajax: {
                url: controller,
                type: "GET",
                dataType: "JSON",
                data: function (d) {
                    var form = $("#form-search");
                    var objForm = form.serialize();

                    return objForm;
                },
                dataSrc: function (json) {
                    // updateIn();
                    console.log("json");
                    console.log(json);
                    return json;
                    // return json.data;
                },
            },
            columnDefs: colunas,
            //order: [[ 1, 'desc' ]],
        })
        .on("draw", function () {
            $(window).resize();
        });
}

function reload_table() {
    table.ajax.reload();
}
