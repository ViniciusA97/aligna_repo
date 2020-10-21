<div class="panel nav-tabs-horizontal" data-plugin="tabs" style="border:1px solid #f1f4f5; border-radius:6px; margin-top:20px;">
    <div class="panel-heading">
        <h4 class="panel-title">Anexos</h4>
    </div>
    <ul class="nav nav-tabs nav-tabs-line" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#exampleTopHome" aria-controls="exampleTopHome" role="tab" aria-expanded="true" aria-selected="true">
                <i class="icon wb-list" aria-hidden="true"></i>Listar Anexos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#exampleTopComponents" aria-controls="exampleTopComponents" role="tab" aria-selected="false">
                <i class="icon wb-plus" aria-hidden="true"></i>Novo Anexo
            </a>
        </li>
    </ul>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane active" id="exampleTopHome" role="tabpanel">
                <div class="row" id="uploads-list">

                @foreach ($data->pop->uploads as $item)
                <div class="col-xs-12 col-md-3 item-main">
                    <div class="card" style="border:1px solid #f1f4f5; border-radius:6px;">
                        @if(strpos($item->mine,'image') !== false)
                        <div class="card-cover-img" style="background-image: url( {{ $item->external_url }} );"></div>
                        @else
                        <div class="card-cover-img"></div>
                        @endif
                        <div class="card-block">
                            <h5 class="card-title" style="margin-bottom:2px;">{{$item->title}}</h5>
                            <p class="card-text" style="font-size:11px">{{$item->created_at->format('d/m/Y H:i:s')}}</p>
                            <a href="{{$item->external_url}}" target="_blank" style="padding-left: 0;" class="btn btn-pure btn-default icon wb-download protip" data-pt-title="Visualizar" data-pt-position="top" data-pt-size="tiny" data-pt-scheme="dark"></a>
                            <button type="button" data-target="#deleteModal" data-url="{{ route('upload.delete', $item->id) }}" data-toggle="modal" class="btn btn-pure btn-default icon wb-trash protip" data-pt-title="Excluir" data-pt-position="top" data-pt-size="tiny" data-pt-scheme="dark"></button>
                        </div>
                    </div>
                </div>
                @endforeach
                </div>
            </div>
            <div class="tab-pane" id="exampleTopComponents" role="tabpanel">
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
        </div>
    </div>
</div>

@component('components.modals.delete')
    Deletar
@endcomponent
