@extends('template')

@section('content')
    <style>
        .g-order>i {
            color: #878787;
        }

        .g-order {
            cursor: pointer;
        }

        .g-order-selected {
            color: #0c0c0c !important;
        }

        .btn-change-status {
            cursor: pointer;
        }
    </style>
    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Inscritos</h5>
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
                        <a href="{{ url('/inscritos/export') }}" title="Exportar" class="pull-left inline-block mr-15 btn-export"
                            target="_blank">
                            <i class="fa fa-file-text"></i>
                        </a>
                        <a href="#" class="pull-left inline-block mr-15 btn-refresh">
                            <i class="zmdi zmdi-refresh-sync"></i>
                        </a>
                        <a href="#" class="pull-left inline-block full-screen mr-15">
                            <i class="zmdi zmdi-fullscreen"></i>
                        </a>
                    </div>
                    <div class="clearfix"></div>

                    <form id="form-search" action="" class="form-search">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="checkbox checkbox-primary">
                                    <input id="pagamento_completo" name="pagamento_completo" type="checkbox">
                                    <label for="pagamento_completo">
                                        Pagamento Completo
                                    </label>
                                </div>
                                <input type="hidden" id="orderColumn" name="orderColumn">
                                <input type="hidden" id="orderType" name="orderType">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="table-wrap">
                            <div class="">
                                <table id="tb-subscribes"
                                    class="table table-bordered table-striped table-hover display  pb-30">
                                    <thead>

                                        <tr>
                                            <th data-name="name" class="g-order">Nome
                                                <i class="fa fa-sort pull-right"></i>
                                            </th>
                                            <th>Paróquia</th>
                                            <th data-name="data_inscricao" class="g-order">Data Inscrição
                                                <i class="fa fa-sort pull-right"></i>
                                            </th>
                                            <th>1ª prestação</th>
                                            <th>2ª prestação</th>
                                            <th>Total pago</th>
                                            <th width="20px">Estado</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Paróquia</th>
                                            <th>Data inscrição</th>
                                            <th>1ª prestação</th>
                                            <th>2ª prestação</th>
                                            <th>Total pago</th>
                                            <th width="20px">Estado</th>
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
    <script src="{{ url('app_script/script.js') }}"></script>
    <script src="{{ url('template/blockui/blockui.js') }}"></script>

    <script>
        $(function() {
            var orderColumn = null;
            var orderType = null;
            var scrollIndex = 0;

            function getTyeOrder(currentOrderColumn) {
                if (orderColumn != currentOrderColumn) {
                    return "ASC";
                }

                return orderType == "ASC" ? "DESC" : "ASC";
            }

            $('.g-order').click(function() {

                var currentOrder = $(this).data("name");
                orderType = getTyeOrder(currentOrder);
                orderColumn = currentOrder;
                $('#orderColumn').val(currentOrder);
                $('#orderType').val(orderType);

                const icon = $(this).find('i');
                $('.g-order').find('i').removeClass('fa-sort-asc');
                $('.g-order').find('i').removeClass('fa-sort-desc');
                $('.g-order').find('i').removeClass('g-order-selected');
                $('.g-order').find('i').removeClass('fa-sort');
                $('.g-order').find('i').addClass('fa-sort');
                icon.addClass(orderType == "ASC" ? 'fa-sort-asc g-order-selected' :
                    'fa-sort-desc g-order-selected');
                reload_table();
            });

            $('#pagamento_completo').change(function(){
                reload_table();
            });
        });

        function changeStatus(id) {
            openModel("/inscritos/changeStatus/" + id);
        }


        function addPayment(id) {
            openModel("/addpayment", {
                id
            })
        }

        function showDetail(id) {
            openModel("/inscritos/details/" + id);
        }

        function openModel(url, data) {
            // $.blockUI({
            //     message: "<h2> Aguarde...</h2>"
            // });
            $("#div-modal").html("");
            $.get(url, data, function(response) {
                    console.log("show modal");
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

        $('.btn-refresh').click(function() {
            console.log("refresh");
            reload_table();
        });

        $('.btn-export').click(function(e){
            e.preventDefault();
            let url = $(this).attr("href");

            if($("#pagamento_completo").prop("checked") == true){
                url = url  + "?pagamento_completo=on";
            }
            window.open(url, '_blank').focus();
        });

        $(function() {

            var colunas = [{
                    "render": function(data, type, row) {
                        return `<div>${row.nome}</div>`;
                    },
                    "targets": 0,
                    // "orderable": false
                },
                {
                    "render": function(data, type, row) {
                        return row.paroquia;
                    },
                    "targets": 1
                },
                {
                    "render": function(data, type, row) {
                        return row.format_data_inscricao;
                    },
                    "targets": 2
                },
                {
                    "render": function(data, type, row) {
                        if (row.prestacao_1) {
                            return row.prestacao_1;
                        }
                        return `<button class="btn btn-default btn-square btn-sm" onClick="addPayment(${row.id})"><i class="fa fa-dollar"></i></button>`;
                    },
                    "targets": 3
                },
                {
                    "render": function(data, type, row) {
                        if (row.prestacao_2) {
                            return row.prestacao_2;
                        }
                        return `<button class="btn btn-default btn-square btn-sm" onClick="addPayment(${row.id})"><i class="fa fa-dollar"></i></button>`;
                    },
                    "targets": 4
                },
                {
                    "render": function(data, type, row) {
                        const percentage = row.completedPayment ?
                            `<br/><span class="txt-success"><span>P${row.pacote_id} (completo)</span></span>` :
                            `<br/><span class="txt-warning">P${row.pacote_id} (incompleto)</span>`;
                        const notification = row.notification ?
                            `<i class="fa fa-bell txt-success" title="${row.notification}"></i>` : "";
                        return row.total_pago + percentage + notification;
                    },
                    "targets": 5
                },
                {
                    "render": function(data, type, row) {
                        if (row.estado == 'EM_ANALISE') {
                            return `<span class="label label-default btn-change-status" onClick="changeStatus(${row.id})">Em análise</span>
                         `;
                        }
                        if (row.estado == 'VALIDADO') {
                            return `<span class="label label-success btn-change-status" onClick="changeStatus(${row.id})">Validado</span>`;
                        }
                        if (row.estado == 'NAO_ACEITE') {
                            return `<span class="label label-danger btn-change-status" onClick="changeStatus(${row.id})">Não aceite</span>`;
                        }
                        return "";

                    },
                    "targets": 6
                }, {
                    "render": function(data, type, row) {
                        return `<button class="btn btn-primary btn-icon-anim btn-square btn-sm" onClick="showDetail(${row.id})"><i class="icon-user"></i></button>`;
                    },
                    "targets": 7
                },
            ];

            initTable(colunas, '/inscritos/lista', '#tb-subscribes');

            // changeStatus(7237);

        });
    </script>
@endsection
