<!-- Modal -->
<div class="modal fade" id="viewPop" aria-hidden="true" aria-labelledby="viewPop"
role="dialog" tabindex="-1">
<div class="modal-dialog modal-simple modal-sidebar modal-lg modal-view-pop">
    <div class="modal-content">
    <div class="modal-header" style="flex-direction: column;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
        <h2 class="modal-title" id="pop-view-id" style="width:100%;">#</h2>
        <h4 class="modal-title" id="pop-view-title">Modal Title</h4>
    </div>
    <div class="modal-body pop-view-content">
        <div class="row">
            <div class="col-12">
                <h5>Descrição</h5>
                <div id="pop-view-description"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-4">
                <h5>PDCA</h5>
                <p id="pop-view-pdca"></p>
            </div>
            <div class="col-12 col-md-4">
                <h5>Status</h5>
                <p id="pop-view-status"></p>
            </div>
            <div class="col-12 col-md-4">
                <h5>Perfil</h5>
                <p id="pop-view-perfil"></p>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-12">
                <h5>Funções</h5>
                <ul id="pop-view-functions" style="display:flex; flex-direction:row; list-style:none; margin-left:0; padding-left:0;"></ul>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-12">
                <h5>Processos</h5>
                <ul id="pop-view-process" style="display:flex; flex-direction:row; list-style:none; margin-left:0; padding-left:0;"></ul>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-12 col-md-4">
                <h5>Frequência</h5>
                <p id="pop-view-recurrence" style="text-transform: capitalize;"></p>
            </div>
            <div class="col-12 col-md-4">
                <h5>Horas de Execução</h5>
                <p id="pop-view-hours"></p>
            </div>
            <div class="col-12 col-md-4">
                <h5>Data de termino</h5>
                <p id="pop-view-end_date"></p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h5>Anexos</h5>
                <ul id="pop-view-uploads" style="display:flex; flex-direction:column; list-style:none; margin-left:0; padding-left:0;"></ul>
            </div>
        </div>

        <hr>

        <div class="row justify-content-end">
            <div class="col-12 col-md-3">
                <a href="#" target="_blank" id="pop-view-pdf" class="btn btn-primary"><i class="icon wb-file" aria-hidden="true"></i> PDF</a>
            </div>
        </div>
    </div>

    </div>
</div>
</div>
<!-- End Modal -->

@push('scripts')
<script>
    let pdfUrl;
    $('#viewPop').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget) // Button that triggered the modal
        const url = button.data('url');
        pdfUrl = button.data('pdf');
        loadPop(url);
    })

    function loadPop(url) {
        axios.get(url)
        .then(function (response) {
            const {pop, version, recurrence, functions, processes, uploads} = response.data;

            $("#pop-view-pdf").attr('href', pdfUrl);
            $("#pop-view-id").html(`#${pop.id}`);
            $("#pop-view-title").html(version.title);
            $("#pop-view-description").html(version.description);
            $("#pop-view-pdca").html(version.pdca);
            $("#pop-view-status").html(version.status);
            $("#pop-view-perfil").html(version.perfil);

            $("#pop-view-functions").html('');
            functions.map(item => {
                $("#pop-view-functions").append(`<li style="padding: 0 5px 5px 0;"><p>${item.title}</p></li>`);
            });
            $("#pop-view-process").html('');
            processes.map(item => {
                $("#pop-view-process").append(`<li style="padding: 0 5px 5px 0;"><p>${item.title}</p></li>`);
            });

            $("#pop-view-recurrence").html(`${recurrence.rule.FREQ}, ${recurrence.rule.WHEN}`);
            $("#pop-view-hours").html(version.hours);
            $("#pop-view-end_date").html(recurrence.end_date);

            $("#pop-view-uploads").html('');
            uploads.map(item => {
                $("#pop-view-uploads").append(`<li style="padding: 5px 0;"><a href="${item.external_url}" target="_blank">${item.title}</a></li>`);
            })
        })
        .catch(function (error) {
            toastr.error("Algo saiu errado... Por favor tente novamente!", {"newestOnTop": false, "progressBar": true});
        });
    }
</script>
@endpush
