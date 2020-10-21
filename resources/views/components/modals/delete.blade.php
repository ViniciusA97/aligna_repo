<!-- Modal -->
<div class="modal fade" id="deleteModal" aria-hidden="true" aria-labelledby="deleteModal"
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
        <p>Você confirma a exclusão deste item?</p>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="deleteItem()">Confirmar</button>
        </div>
    </div>
    </div>
</div>
<!-- End Modal -->

@push('scripts')
<script>
    let deleteUrl;
    let removedItem;
    $('#deleteModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget) // Button that triggered the modal
        removedItem = button.parents('.item-main');
        deleteUrl = button.data('url');
        if(button.data('redirect')){
            removedItem = "redirect";
        }
    })

    function deleteItem() {
        axios.delete(deleteUrl, {
            _token: "{{ csrf_token() }}"
        })
        .then(function (response) {
            $('#deleteModal').modal('hide');
            toastr.success("Item excluido com sucesso!", {"newestOnTop": false, "progressBar": true});
            if(removedItem == 'redirect'){
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }else{
              removedItem.remove();
            }
        })
        .catch(function (error) {
            toastr.error("Algo saiu errado... Por favor tente novamente!", {"newestOnTop": false, "progressBar": true});
        });
    }
</script>
@endpush
