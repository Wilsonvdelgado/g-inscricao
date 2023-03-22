<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 class="modal-title">Pagamento </h5>
        </div>
        {!! Form::open(['url' => '#', 'id' => 'form-create', 'novalidate' => 'novalidate']) !!}
        <div class="modal-body">
            {{ Form::hidden('inscrito', $inscrito) }}
            {{ Form::hidden('prestacao', $prestacao) }}
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        {!! Form::label('valor', 'Valor', ['class' => 'control-label mb-10']) !!}<span class="text-danger">*</span>
                        {!! Form::number('valor', null, ['class' => 'form-control', 'autofocus', 'required']) !!}
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        {!! Form::label('date', 'Data do pagamento', ['class' => 'control-label mb-10']) !!}<span class="text-danger">*</span>
                        {!! Form::date('date', null, ['class' => 'form-control', 'autofocus', 'required']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        {!! Form::label('descricao', 'Descrição', ['class' => 'control-label mb-10']) !!}<span class="text-danger">*</span>
                        {!! Form::text('descricao', $descricao, ['class' => 'form-control', 'required']) !!}
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
        var today = new Date().toISOString().split('T')[0];
        document.getElementsByName("date")[0].setAttribute('max', today);

        $("#form-create").validate({
            rules: {
                valor: "required",
                descricao: "required",
                date: "required"
            },

            messages: {
                valor: "Obrigatório",
                descricao: "Obrigatório",
                date: "Obrigatório"
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
                    url: "/payment",
                    data: $(this).serialize(),
                })
                .done(function(data) {
                    console.log(data);
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
            // console.log(formData);
            // ajax_request(formData, '/payment', function(data) {

            //     if (data === true) {
            //         $('#div-modal').modal("hide");
            //         // sucessmessage(data.Message);
            //         // reload_table();
            //     }
            //     // } else errormessage(data.Message);
            // });
            return false;
        });

    });
</script>
