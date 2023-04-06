<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 class="modal-title">Alterar estado </h5>
        </div>
        {!! Form::open(['url' => '#', 'id' => 'form-create', 'novalidate' => 'novalidate']) !!}
        <div class="modal-body">
            {{ Form::hidden('inscrito', $inscrito) }}
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {!! Form::label('estado', 'Estado', ['class' => 'control-label mb-10']) !!}<span class="text-danger">*</span>
                        {!! Form::select('estado', $list, null, [
                            'placeholder' => 'Selecione uma opção...',
                            'class' => 'form-control g-estado-select',
                            'required',
                        ]) !!}
                    </div>
                </div>

            </div>

            <div class="row g-motivo" style="display: none">
                <div class="col-lg-12">
                    <div class="form-group">
                        {!! Form::label('motivo', 'Motivo', ['class' => 'control-label mb-10']) !!}<span class="text-danger">*</span>
                        {!! Form::text('motivo', null, ['class' => 'form-control', 'required']) !!}
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
</div>
<script>
    $(function() {
        $("#form-create").validate({
            rules: {
                estado: "required",
            },

            messages: {
                estado: "Obrigatório"
            },
            showErrors: function(errorMap, errorList) {
                this.defaultShowErrors();
                $("#form-create label.error").each(function(el) {
                    $(this).attr("style",
                        "color:red !important;");
                });
            },
        });

        $('.g-estado-select').change(function(e) {
            const value = e.target.value;
            if (value === "NAO_ACEITE") {
                $('.g-motivo').show();
            } else {
                $('.g-motivo').hide();
            }
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
                    method: "PUT",
                    url: "/inscritos/saveChangeStatus",
                    data: $(this).serialize(),
                })
                .done(function(data) {
                    if (data?.error) {
                        $.alert({
                            title: 'Erro!',
                            theme: "modern",
                            type: "red",
                            content: "Ocorreu um erro",
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
                                message = message + el + '<br/>';
                            });
                        }
                    } else {
                        message = "Ocorreu um erro";
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
