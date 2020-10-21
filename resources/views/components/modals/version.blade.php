<!-- Modal -->
<div class="modal fade" id="versionModal" aria-hidden="true" aria-labelledby="versionModal"
role="dialog" tabindex="-1">
    <div class="modal-dialog modal-simple modal-center">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Confirmação</h4>
        </div>
        <div class="modal-body">
        <p>Você confirma a alteração de versão deste POP?</p>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="refreshVersion()">Confirmar</button>
        </div>
    </div>
    </div>
</div>
<!-- End Modal -->

@push('scripts')
<script>
    let versionUrl;
    let itemHeader;
    $('#versionModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget) // Button that triggered the modal
        itemHeader = button.parent('.pop-item');
        versionUrl = button.data('url');
    })

    function refreshVersion() {
        axios.put(versionUrl, {
            _token: "{{ csrf_token() }}"
        })
        .then(function (response) {
            $('#versionModal').modal('hide');
            toastr.success("Versão alterada com sucesso!", {"newestOnTop": false, "progressBar": true});
            $('.version-flag').hide();
            itemHeader.find('.pop-header').append('<span class="badge badge-info version-flag">Versão atual</span>');
            // setTimeout(() => {
            //     location.reload();
            // }, 1000);
        })
        .catch(function (error) {
            toastr.error("Algo saiu errado... Por favor tente novamente!", {"newestOnTop": false, "progressBar": true});
        });
    }
</script>
@endpush
