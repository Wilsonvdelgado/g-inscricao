<style>
    .time {
        width: 100% !important;
    }

    .show-file {
        cursor: pointer;
    }
</style>
<div class="modal-dialog modal-lg modal-g-insc" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 class="modal-title">Detalhes - {{ $data->nome }} </h5>
        </div>
        <div class="modal-body">
            <div class="container-fluid pt-25">

                <!-- Row -->
                <div class="row">
                    <div class="col-lg-3 col-xs-12">
                        <div class="panel panel-default card-view  pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body  pa-0">
                                    <div class="profile-box">
                                        <div class="profile-cover-pic">
                                            <div class="profile-image-overlay"></div>
                                        </div>
                                        <div class="profile-info text-center">
                                            <div class="profile-img-wrap">
                                                <img class="inline-block mb-10"
                                                    src="{{ URL::asset('/assets/user-placeholder.jpg') }}"
                                                    alt="user" />
                                            </div>
                                            <h5 class="block mt-10 mb-5 weight-500 capitalize-font txt-danger">
                                                {{ $data->nome }}</h5>
                                            <h6 class="block capitalize-font pb-20">
                                                {{ $data->responsabilidade_pastoral }}</h6>
                                        </div>
                                        <div class="social-info">
                                            <div class="row">
                                                <div class="col-xs-12 text-center">
                                                    <span class="counts block head-font"><span
                                                            class="counter-anim">{{ $data->total_pago }}</span></span>
                                                    <span class="counts-text block">Total pago</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pb-0">
                                    <div class="tab-struct custom-tab-1">
                                        <ul role="tablist" class="nav nav-tabs nav-tabs-responsive" id="myTabs_8">
                                            <li class="active" role="presentation"><a data-toggle="tab"
                                                    id="profile_tab_dados_gerais" role="tab"
                                                    href="#tab_dados_gerais"
                                                    aria-expanded="false"><span>Dados</span></a></li>
                                            <li role="presentation" class="next">
                                                <a data-toggle="tab" id="earning_tab_8" role="tab"
                                                    href="#tab_pagamentos"
                                                    aria-expanded="false"><span>Pagamentos</span></a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent_8">
                                            <div id="tab_dados_gerais" class="tab-pane fade active in" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="followers-wrap">
                                                            <ul class="followers-list-wrap">
                                                                <li class="follow-list">
                                                                    <div class="follo-body">
                                                                        <div class="follo-data">
                                                                            <div class="user-data">
                                                                                <span
                                                                                    class="name block capitalize-font">Nome:
                                                                                    {{ $data->nome }}
                                                                                </span>
                                                                                <span class="time block txt-grey">Data
                                                                                    incrição:
                                                                                    {{ $data->data_inscricao }}</span>
                                                                                <span class="time block txt-grey">
                                                                                    Sexo: {{ $data->sexo }} / Data
                                                                                    nascimento:
                                                                                    {{ $data->data_nascimento }}</span>
                                                                            </div>
                                                                            <div class="clearfix"></div>
                                                                        </div>
                                                                        <div class="follo-data">
                                                                            <div class="user-data">
                                                                                <span class="time block txt-grey">Pais
                                                                                    de residência:
                                                                                    {{ $data->pais_residencia }} / Ilha:
                                                                                    {{ $data->ilha }} / Paróquia:
                                                                                    {{ $data->paroquia }}
                                                                                </span>
                                                                            </div>
                                                                            <div class="clearfix"></div>
                                                                        </div>
                                                                        <div class="follo-data">
                                                                            <div class="user-data">
                                                                                <span
                                                                                    class="time block txt-grey">Escolaridade:
                                                                                    {{ $data->escolaridade }} /
                                                                                    Profissão:
                                                                                    {{ $data->profissao }}
                                                                                </span>
                                                                            </div>
                                                                            <div class="clearfix"></div>
                                                                        </div>
                                                                        <div class="follo-data">
                                                                            <div class="user-data">
                                                                                <span
                                                                                    class="name block capitalize-font">Contato</span>
                                                                                <span
                                                                                    class="time block txt-grey">Telemóvel:
                                                                                    {{ $data->telemovel }} / Email:
                                                                                    {{ $data->email }}
                                                                                </span>
                                                                            </div>
                                                                            <div class="clearfix"></div>
                                                                        </div>

                                                                        <div class="follo-data">
                                                                            <div class="user-data">
                                                                                <span
                                                                                    class="name block capitalize-font">Responsabilidade
                                                                                    pastoral:
                                                                                    {{ $data->responsabilidade_pastoral }}
                                                                                </span>
                                                                                <span
                                                                                    class="time block txt-grey">Pertence
                                                                                    a algum grupo:
                                                                                    {{ $data->pertence_a_grupo_religioso }}
                                                                                    {{ $data->grupo }}
                                                                                </span>
                                                                                <span class="time block txt-grey">
                                                                                    Necessidade especial:
                                                                                    {{ $data->tem_necessidade_especial }}
                                                                                    {{ $data->necessidade_especial }}
                                                                                </span>

                                                                            </div>
                                                                            <div class="clearfix"></div>
                                                                        </div>

                                                                        <div class="follo-data">
                                                                            <div class="user-data">
                                                                                <span
                                                                                    class="name block capitalize-font">Estado:
                                                                                    {{ $data->estado_description }}
                                                                                </span>

                                                                            </div>
                                                                            <div class="clearfix"></div>
                                                                        </div>
                                                                        <div class="table-wrap sm-data-box-2">
                                                                            <div class="table-responsive">
                                                                                <table
                                                                                    class="table  top-countries mb-0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td
                                                                                                data-url={{ $data->passaport }}>
                                                                                                <i class="fa fa-file-pdf-o fa-lg show-file"
                                                                                                    style="color: #ff2a00"></i>
                                                                                                <span
                                                                                                    class="country-name txt-dark pl-15 show-file">Documento 1</span>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td
                                                                                                data-url={{ $data->bi_cni }}>
                                                                                                <i class="fa fa-file-pdf-o fa-lg show-file"
                                                                                                    style="color: #ff2a00"></i>
                                                                                                <span
                                                                                                    class="country-name txt-dark pl-15 show-file">Documento 2
                                                                                                   </span>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td
                                                                                                data-url={{ $data->comprovativo_pagamento }}>
                                                                                                <i class="fa fa-file-pdf-o fa-lg show-file"
                                                                                                    style="color: #ff2a00"></i>
                                                                                                <span
                                                                                                    class="country-name txt-dark pl-15 show-file">Docuemnto 3
                                                                                                 </span>
                                                                                            </td>
                                                                                        </tr>

                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                            <div id="tab_pagamentos" class="tab-pane fade" role="tabpanel">
                                                <!-- Row -->
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <form id="example-advanced-form" action="#">
                                                            <div class="table-wrap">
                                                                <div class="table-responsive">
                                                                    <table
                                                                        class="table table-striped display product-overview"
                                                                        id="datable_1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Data</th>
                                                                                <th>Descrição</th>
                                                                                <th>Montante</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tfoot>
                                                                            <tr>
                                                                                <th colspan="2">Total:</th>
                                                                                <th>{{ $data->total_pago }}</th>
                                                                            </tr>
                                                                        </tfoot>

                                                                        <tbody>
                                                                            @foreach ($data->listPayments as $payment)
                                                                                <tr>
                                                                                    <td>{{ $payment->formatDate }}</td>
                                                                                    <td>
                                                                                        {{ $payment->titulo }}
                                                                                    </td>
                                                                                    <td>{{ $payment->valor }}</td>
                                                                                </tr>
                                                                            @endForeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>
</div>


{{-- <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-default card-view panel-refresh">
            <div class="refresh-container" style="display: none;">
                <div class="la-anim-1"></div>
            </div>
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="panel-title txt-dark">Pagamentos</h6>
                </div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <hr class="light-grey-hr row mt-10 mb-15">
                    <div class="label-chatrs">
                        <div class="">
                            <span
                                class="clabels clabels-lg inline-block bg-blue mr-10 pull-left"></span>
                            <span
                                class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                                <span class="block font-15 weight-500 mb-5">44.46%organic</span>
                                <span class="block txt-grey">356visits</span>
                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}




<style>
    @media (min-width: 992px) {
        /* .modal-lg {
            width: 900px;
        } */


    }

    /* 1200px */
    @media (min-width: 922px) {
        .modal-g-insc {
            width: 90%;

        }
    }

    /* width: 900px; */
</style>
<script>
    // $(function() {


    // });

    $('.show-file').click(function() {

        console.log("ssssss");

        const url = $(this).parent().data("url");
        console.log(url);
        window.open(url, '_blank');
    });
</script>
