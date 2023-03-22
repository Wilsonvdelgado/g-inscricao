{{-- <link rel="stylesheet" href="{{ url('template/select2/select2.css') }}"> --}}





<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 class="modal-title">Pagamento </h5>
        </div>
        {!! Form::open(['url' => '#', 'id' => 'form-create', 'novalidate' => 'novalidate']) !!}
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {!! Form::label('title', 'Título', ['class' => 'control-label mb-10']) !!}<span class="text-danger">*</span>
                        {!! Form::text('title', null, ['class' => 'form-control', 'autofocus', 'required']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        {!! Form::label('valor', 'Valor', ['class' => 'control-label mb-10']) !!}<span class="text-danger">*</span>
                        {!! Form::number('valor', null, ['class' => 'form-control', 'autofocus', 'required']) !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        {!! Form::label('date', 'Data pagamento', ['class' => 'control-label mb-10']) !!}<span class="text-danger">*</span>
                        {!! Form::date('date', null, ['class' => 'form-control', 'autofocus', 'required']) !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        {!! Form::label('type', 'Tipo movimento', ['class' => 'control-label mb-10']) !!}<span class="text-danger">*</span>
                        {!! Form::select('type', $types, null, [
                            'placeholder' => 'Selecione uma opção...',
                            'class' => 'form-control',
                            'required',
                        ]) !!}
                    </div>
                </div>

            </div>
            <div id="id-devolucao">
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox checkbox-primary">
                            <input id="devolucao_check" name="devolucao_check" type="checkbox">
                            <label for="devolucao_check">
                                Devolução de dinheiro do inscrito
                            </label>
                        </div>
                    </div>
                </div>

                <div id="div-inscrito" class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('inscrito', 'Inscrito', ['class' => 'control-label mb-10']) !!}<span class="text-danger">*</span>
                            {!! Form::select('inscrito', $list, null, [
                                'placeholder' => 'Selecione uma opção...',
                                'class' => ' select2',
                            ]) !!}
                        </div>

                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {!! Form::label('description', 'Descrição', ['class' => 'control-label mb-10']) !!}<span class="text-danger">*</span>
                        {!! Form::text('description', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> Registar</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>


<script>
    $(function() {
        var today = new Date().toISOString().split('T')[0];
        document.getElementsByName("date")[0].setAttribute('max', today);

        $('.select2').selectize();

        $('#div-inscrito').hide();
        $('#id-devolucao').hide();

        $('#devolucao_check').change(function(e) {
            console.log(e.target.value);
            const check = $(this).is(':checked');

            if (check) {
                $('#div-inscrito').show();
            } else {
                $('#div-inscrito').hide();
            }
        });

        $('#type').change(function(e) {
            if (e.target.value == "SAIDA") {
                $('#id-devolucao').show();
            } else {
                $('#id-devolucao').hide();
            }
        });

        $("#form-create").validate({
            rules: {
                title: "required",
                valor: "required",
                description: "required",
                date: "required",
                type: "required",
            },

            messages: {
                title: "Obrigatório",
                valor: "Obrigatório",
                description: "Obrigatório",
                date: "Obrigatório",
                type: "Obrigatório"
            },
            showErrors: function(errorMap, errorList) {
                this.defaultShowErrors();
                $("#form-create label.error").each(function(el) {
                    $(this).attr("style",
                        "color:red !important;");
                });
            },
        });

        $('#form-create').submit(function(event) {
            event.preventDefault();
            const form = $('#form-create');
            var validator = form.validate();
            var isValid = validator.form();

            if (!isValid) {
                return false;
            }

            $.ajax({
                    method: "POST",
                    url: "/financas/store",
                    data: $(this).serialize(),
                })
                .done(function(data) {
                    console.log(data);
                    if (data?.error) {
                        $.alert({
                            title: 'Erro!',
                            theme: "modern",
                            type: "red",
                            content: data.error,
                        });
                        return;
                    }
                    $('#div-modal').modal('hide');

                    $.alert({
                        title: 'Sucesso!',
                        content: '',
                        autoClose: 'close|0',
                        buttons: {
                            close: {
                                text: 'Ok',
                            }
                        }
                    });
                    reload_table();
                })
                .fail(function(data, textStatus) {
                    const errorMessage = data.responseJSON.errorMessage;
                    let message = "";
                    if (errorMessage) {
                        message = errorMessage;
                    } else if (data.responseJSON.errors) {
                        const responseData = data.responseJSON.errors;
                        for (const key in responseData) {
                            responseData[key].forEach(function(el) {
                                message = message + el + '<br />';
                            });
                        }
                    } else {
                        message = data.error;
                    }

                    $.alert({
                        title: 'Erro!',
                        theme: "modern",
                        type: "red",
                        content: message,
                    });
                });

            return false;
        });

    });
</script>
