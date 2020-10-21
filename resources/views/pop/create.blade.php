@extends('layouts.default')

@section('header')
    @parent
<div class="page-header">
    <h1 class="page-title">Criar POP</h1>
</div>
@endsection


@section('content')

<div class="panel-body container-fluid">
    @if ($errors->any())
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger">
                    <p>Preencha todos os campos <b>obrigatórios *</b>.</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('action_error'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning">
                    <p>{{ session('action_error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('pop.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-12 col-md-7">
                <div class="row">
                    <div class="form-group col-12">
                        <label class="form-control-label" for="inputTitle">Título do Procedimento *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="inputTitle" name="title"
                        placeholder="Título" autocomplete="off" value="{{ old('title') }}" />
                        @error('title')
                        <small class="invalid-feedback">
                            O campo Título do Procedimento é obrigatório.
                        </small>
                        @enderror
                    </div>
                </div><!-- end row-->

                <div class="row">
                    <div class="form-group col-12">
                        <label class="form-control-label" for="inputResume">Resumo</label>
                        <input type="text" class="form-control @error('resume') is-invalid @enderror" id="inputResume" name="resume"
                        placeholder="Resumo" autocomplete="off" value="{{ old('resume') }}" />
                        @error('resume')
                        <small class="invalid-feedback">
                            O campo Resumo é obrigatório.
                        </small>
                        @enderror
                    </div>
                </div><!-- end row-->

                <div class="row">
                    <div class="form-group col-12">
                        <label class="form-control-label" for="inputDescription">Detalhamento</label>
                        @error('description')
                        <small class="invalid-feedback" style="width: 100%; display:block;">
                            O campo detalhamento é obrigatório.
                        </small>
                        @enderror
                        <textarea name="description" id="inputDescription">{{ old('description') }}</textarea>
                    </div>
                </div><!-- end row-->

                <div class="row">
                    <div class="form-group col-12">
                        <label class="form-control-label">Anexos</label>
                        <div class="upload-form" id="exampleUploadForm">
                            <input type="file" id="inputUpload" name="files[]" multiple="" />
                            <div class="uploader-inline">
                                <p class="upload-instructions">Selecione ou arraste arquivos</p>
                            </div>
                            <div class="file-wrap container-fluid">
                                <div class="file-list row"></div>
                            </div>
                        </div>
                        <input type="hidden" name="files_uploaded" id="filesUploaded">
                    </div>
                </div><!-- end row-->
            </div><!--end col-left-->

            <div class="col-12 col-md-5">
                <div class="row">
                    <div class="form-group col-12 col-md-6">
                        <label class="form-control-label" for="selectPDCA">PDCA</label>
                        <select id="selectPDCA" name="pdca" class="form-control @error('pdca') is-invalid @enderror">
                            <option selected value="">Selecione</option>
                            @foreach ($data->pdca as $item)
                                <option value="{{$item}}" {{ (collect(old('pdca'))->contains($item)) ? 'selected':'' }}>{{$item}}</option>
                            @endforeach
                        </select>

                        @error('pdca')
                        <small class="invalid-feedback">
                            O campo PDCA é obrigatório.
                        </small>
                        @enderror
                    </div><!-- end col -->

                    <div class="form-group col-12 col-md-6">
                        <label class="form-control-label" for="selectPerfil">Perfil</label>
                        <select id="selectPerfil" name="perfil" class="form-control @error('perfil') is-invalid @enderror">
                            <option selected value="">Selecione</option>
                            @foreach ($data->perfil as $item)
                                <option value="{{$item}}" {{ (collect(old('perfil'))->contains($item)) ? 'selected':'' }}>{{$item}}</option>
                            @endforeach
                        </select>

                        @error('perfil')
                            <small class="invalid-feedback">
                                O campo Perfil é obrigatório.
                            </small>
                        @enderror
                    </div><!-- end col -->
                </div>

                <div class="row">
                    <div class="form-group col-12 col-md-6">
                        <label class="form-control-label" for="selectStatus">Status de Preenchimento</label>
                        <select id="selectStatus" name="status_preenchimento" class="form-control @error('status_preenchimento') is-invalid @enderror">
                            @foreach ($data->status['preenchimento'] as $item)
                                <option value="{{$item}}" {{ (collect(old('status_preenchimento'))->contains($item)) ? 'selected': '' }}>{{$item}}</option>
                            @endforeach
                        </select>

                        @error('status')
                            <small class="invalid-feedback">
                                O campo Status de Preenchimento é obrigatório.
                            </small>
                        @enderror
                    </div><!-- end col -->

                    <div class="form-group col-12 col-md-6">
                        <label class="form-control-label" for="selectStatusExecucao">Status de Execução</label>
                        <select id="selectStatusExecucao" name="status_execucao" class="form-control @error('status_execucao') is-invalid @enderror">
                            <option selected value="">Selecione</option>
                            @foreach ($data->status['execucao'] as $item)
                                <option value="{{$item}}" {{ (collect(old('status_execucao'))->contains($item)) ? 'selected':'' }}>{{$item}}</option>
                            @endforeach
                        </select>

                        @error('status')
                            <small class="invalid-feedback">
                                O campo Status de Execução é obrigatório.
                            </small>
                        @enderror
                    </div><!-- end col -->
                </div><!-- end row-->

                <div class="row">
                    <div class="form-group col-12">
                        <label class="form-control-label" for="inputFunctions">Funções</label>
                        <select id="inputFunctions" name="functions" data-placeholder="Selecione as funções" class="form-control @error('functions') is-invalid @enderror" data-plugin="select2">
                            @foreach ($data->functions as $item)
                                <option value="{{$item->id}}" {{ (collect(old('functions'))->contains($item->id)) ? 'selected':'' }}>{{$item->title}}</option>
                            @endforeach
                        </select>
                        <!-- <select id="inputFunctions" name="functions[]" data-placeholder="Selecione as funções" class="form-control @error('functions') is-invalid @enderror" multiple="multiple" data-plugin="select2">
                            @foreach ($data->functions as $item)
                                <option value="{{$item->id}}" {{ (collect(old('functions'))->contains($item->id)) ? 'selected':'' }}>{{$item->title}}</option>
                            @endforeach
                        </select> -->

                        @error('functions')
                            <small class="invalid-feedback">
                                O campo Funções é obrigatório.
                            </small>
                        @enderror
                    </div>

                    <div class="form-group col-12">
                        <label class="form-control-label" for="inputProcess">Processos</label>
                        <select id="inputProcess" name="process" data-placeholder="Selecione os Processos" class="form-control @error('process') is-invalid @enderror" data-plugin="select2">
                            @foreach ($data->process as $item)
                                <option value="{{$item->id}}" {{ (collect(old('process'))->contains($item->id)) ? 'selected':'' }}>{{$item->title}}</option>
                            @endforeach
                        </select>
                        <!-- <select id="inputProcess" name="process[]" data-placeholder="Selecione os Processos" class="form-control @error('process') is-invalid @enderror" multiple="multiple" data-plugin="select2">
                            @foreach ($data->process as $item)
                                <option value="{{$item->id}}" {{ (collect(old('process'))->contains($item->id)) ? 'selected':'' }}>{{$item->title}}</option>
                            @endforeach
                        </select> -->

                        @error('process')
                            <small class="invalid-feedback">
                                O campo Processos é obrigatório.
                            </small>
                        @enderror
                    </div>
                </div><!-- end row-->

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="inputHrsExecucao">Horas de execução</label>
                            <input type="text" value="{{ old('hours') }}" class="form-control time @error('hours') is-invalid @enderror" name="hours" id="inputHrsExecucao">

                            @error('hours')
                                <small class="invalid-feedback">
                                    O campo Horas de execução é obrigatório.
                                </small>
                            @enderror
                        </div><!-- end col -->
                    </div><!-- end col -->

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="inputTermino">Data de Início</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="icon wb-calendar" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="text" value="{{ old('start_date') }}" class="form-control datepicker @error('start_date') is-invalid @enderror" name="start_date">

                                @error('start_date')
                                    <small class="invalid-feedback">
                                        O campo Data de Início é obrigatório.
                                    </small>
                                @enderror
                            </div>
                        </div><!-- end col -->
                    </div>
                </div><!-- end row-->

                <div class="row">
                    <div class="col-12 col-md-8">
                        <div id="frequencyBox"></div>
                        @error('frequencia')
                            <small class="invalid-feedback" style="display:block !important;">
                                O campo Frequencia de execução é obrigatório.
                            </small>
                        @enderror
                    </div><!-- end col-->
                </div>

            </div><!-- end col-right-->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-secondary">Salvar</button>
                </div>
            </div>
        </div>

    </form>
</div>


@endsection


@push('styles')
<link rel="stylesheet" href="{{ asset("assets/global/vendor/summernote/summernote.min.css?v4.0.2") }}">
<link rel="stylesheet" href="{{ asset("assets/global/vendor/select2/select2.css") }}">
<link rel="stylesheet" href="{{ asset("assets/global/vendor/blueimp-file-upload/jquery.fileupload.css") }}">
<link rel="stylesheet" href="{{ asset("assets/global/vendor/jquery-labelauty/jquery-labelauty.min.css?v4.0.2") }}">
<link rel="stylesheet" href="{{ asset("assets/global/vendor/clockpicker/clockpicker.min.css?v4.0.2") }}">
<link rel="stylesheet" href="{{ asset("assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css?v4.0.2") }}">
@endpush

@push('plugins')
<script src="{{ asset("assets/global/vendor/summernote/summernote.min.js?v4.0.2") }}"></script>
<script src="{{ asset("assets/global/vendor/select2/select2.full.min.js") }}"></script>
<script src="{{ asset("assets/global/vendor/jquery-ui/jquery-ui.js") }}"></script>
<script src="{{ asset("assets/global/vendor/blueimp-tmpl/tmpl.js") }}"></script>
<script src="{{ asset("assets/global/vendor/blueimp-canvas-to-blob/canvas-to-blob.js") }}"></script>
<script src="{{ asset("assets/global/vendor/blueimp-load-image/load-image.all.min.js") }}"></script>
<script src="{{ asset("assets/global/vendor/blueimp-file-upload/jquery.fileupload.js") }}"></script>
<script src="{{ asset("assets/global/vendor/blueimp-file-upload/jquery.fileupload-process.js") }}"></script>
<script src="{{ asset("assets/global/vendor/blueimp-file-upload/jquery.fileupload-image.js") }}"></script>
<script src="{{ asset("assets/global/vendor/blueimp-file-upload/jquery.fileupload-audio.js") }}"></script>
<script src="{{ asset("assets/global/vendor/blueimp-file-upload/jquery.fileupload-video.js") }}"></script>
<script src="{{ asset("assets/global/vendor/blueimp-file-upload/jquery.fileupload-validate.js") }}"></script>
<script src="{{ asset("assets/global/vendor/blueimp-file-upload/jquery.fileupload-ui.js") }}"></script>
<script src="{{ asset("assets/global/vendor/jquery-labelauty/jquery-labelauty.js?v4.0.2") }}"></script>
<script src="{{ asset("assets/global/vendor/clockpicker/bootstrap-clockpicker.min.js?v4.0.2") }}"></script>
<script src="{{ asset("assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js?v4.0.2") }}"></script>
@endpush

@push('scripts')
<script src="{{ asset("assets/global/js/Plugin/select2.js") }}"></script>
<script src="{{ asset("assets/global/js/Plugin/jquery-labelauty.js?v4.0.2") }}"></script>
<script src="{{ asset("assets/global/js/Plugin/clockpicker.js?v4.0.2") }}"></script>
<script src="{{ asset("assets/global/js/Plugin/bootstrap-datepicker.js?v4.0.2") }}"></script>
<script>
const uploadUrl = "{{ route('upload.store') }}";
const _token = "{{ csrf_token() }}";
</script>
<script src="{{ asset("assets/js/Uploads.js") }}"></script>
<script>
    $('#inputDescription').summernote({
        tabsize: 2,
        height: 200
    });

    $.fn.datepicker.dates['pt-br'] = {
        days: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
        daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
        daysMin: ["Do", "Se", "Te", "Qu", "Qui", "Se", "Sa"],
        months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
        monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
        today: "Hoje",
        clear: "Limpar",
        format: "dd/mm/yyyy",
        titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
        weekStart: 0
    };
    $('.datepicker').datepicker({
        language: 'pt-br'
    });

    function buildCalendar() {
        $('#inlineDatepicker').datepicker({
            language: 'pt-br'
        });
        $("#inlineDatepicker").on("changeDate", function (event) {
            $("#inputHiddenInline").val($("#inlineDatepicker").datepicker('getFormattedDate'));
        });
    }

</script>
@endpush
