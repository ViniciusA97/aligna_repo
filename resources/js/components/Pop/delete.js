import React from 'react';
import Axios from 'axios';

export default function PopDelete({pop, handleModal}) {

    function handleDelete() {
        Axios.delete(laroute.route('pop.delete', {id:pop.id}))
        .then(function (response) {
            toastr.success("Item excluido com sucesso!", {"newestOnTop": false, "progressBar": true});
            handleModal(false, null, true)
        })
        .catch(function (error) {
            console.log(error)
        });
    }

  return (
        <div className="modal-dialog modal-simple modal-center">
            <div className="modal-content">
                <div className="modal-header">
                    <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 className="modal-title">Confirmação</h4>
                </div>
                <div className="modal-body">
                    <p>Você confirma a exclusão deste item?</p>
                </div>
                <div className="modal-footer">
                    <button type="button" className="btn btn-default" onClick={() => handleModal(false, null, false)} data-dismiss="modal">Cancelar</button>
                    <button type="button" className="btn btn-primary" onClick={() => handleDelete()}>Confirmar</button>
                </div>
            </div>
        </div>
  );
}
