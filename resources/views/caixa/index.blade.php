@extends('template')
@section('content')
    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Finanças</h5>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 pull-right">
            <button class="btn btn-primary pull-right g-insc-new">Novo</button>
        </div>
    </div>
    <!-- /Title -->

    <div class="row">
        <!-- Basic Table -->
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Filtros</h6>
                    </div>
                    <div class="pull-right">
                        <a href="#" class="pull-left inline-block full-screen mr-15">
                            <i class="zmdi zmdi-fullscreen"></i>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                    <div></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="table-wrap mt-40">
                            <div class="">
                                <table id="tb-caixa" class="table table-bordered table-striped table-hover display  pb-30">
                                    <thead>
                                        <tr>
                                            <th>Data</th>
                                            <th>Titulo</th>
                                            <th>Montante</th>
                                            <th>Saldo após movimentação</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Data</th>
                                            <th>Titulo</th>
                                            <th>Montante</th>
                                            <th>Saldo</th>
                                            <th>Ações</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Basic Table -->
    </div>
    <div class="modal fade" id="div-modal" role="dialog" aria-labelledby="myModalLabel">

    </div>
@endsection

@section('page-js-files')
    <script src="{{ url('app/script.js') }}"></script>

    <script>
        $('.g-insc-new').click(() => {
            console.log("click");
            openModel("/financas/create");
        });

        function openModel(url, data) {
            // $.blockUI({
            //     message: "<h2> Aguarde...</h2>"
            // });
            $("#div-modal").html("");
            $.get(url, data, function(response) {
                    $("#div-modal").html(response);
                    $("#div-modal").modal({
                        keyboard: false
                    }, "show");
                })
                .fail(function() {
                    // errormessage("Ocorreu um erro");
                })
                .always(function() {
                    // $.unblockUI();
                });
        }

        $(function() {
            openModel("/financas/create");
            var colunas = [{
                    "render": function(data, type, row) {
                        return `<div>${row.formatDate} </div>`;
                    },
                    "targets": 0,
                    "orderable": false
                },
                {
                    "render": function(data, type, row) {
                        return row.titulo;
                    },
                    "targets": 1
                }, {
                    "render": function(data, type, row) {
                        if (row.tipo_movimento == "ENTRADA") {
                            return '<span class="txt-success"> +' + " " + row.valor + " </span>";
                        }
                        return '<span class="txt-danger"> - ' + " " + row.valor + "</span>";
                    },
                    "targets": 2
                },
                {
                    "render": function(data, type, row) {
                        return row.currentValue.toFixed(2);;
                    },
                    "targets": 3
                },
                {
                    "render": function(data, type, row) {
                        return "";
                        // return `<button class="btn btn-success btn-icon-anim btn-square btn-sm" onClick="addPayment(${row.id})"><i class="fa fa-dollar"></i></button>`;
                    },
                    "targets": 4
                },
                // {
                //     "render": function(data, type, row) {
                //         var html = "";
                //         html += '<div class="div-action-table">' +
                //             '<div class="btn-group action-table">' +
                //             '<button data-toggle="dropdown" class="btn btn-default">' +
                //             '<em class="icon-options-vertical"></em></button>';
                //         html +=
                //             '<ul role="menu" class="dropdown-menu dropdown-table animated flipInX"  data-id="' +
                //             row.Id + '">';
                //         html += '<li><a class="sm-action-item" onclick="request_ver(this)">Ver</a></li>';
                //         html +=
                //             '<li><a class="sm-action-item" onclick="request_delete(this)">Eliminar</a></li>';
                //         html += "</ul>";
                //         html += '</div></div>';
                //         return html;
                //     },
                //     "targets": 1
                // }
            ];

            initTable(colunas, '/financas/lista', '#tb-caixa');

        });
    </script>
@endsection
