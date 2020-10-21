import React, {useState, useEffect} from 'react';
import ReactDOM from 'react-dom';
import Axios from 'axios';

import Modal from 'react-modal';
import SlidingPane from 'react-sliding-pane';
import 'react-sliding-pane/dist/react-sliding-pane.css';

import HistoricFilters from './Pop/Historic/filters';
import HistoricCard from './Pop/Historic/card';
import VersionView from './Pop/Historic/view';

Modal.setAppElement('#app-body')
const modalStyles = {
    overlay: {
        zIndex: 9995,
        backgroundColor: 'rgba(0, 0, 0, 0.5)'
    },
    content : {
      border: 0,
      backgroundColor: 'transparent'
    }
};

export default function PopHistoric() {

    const [popId, setPopId] = useState(null);
    const [pop, setPop] = useState(null);
    const [versions, setVersions] = useState([]);
    const [currentVersion, setCurrentVersion] = useState(null);

    const [filters, setFilters] = useState({});
    const [page, setPage] = useState(1);

    const [showPanel, setShowPanel] = useState(false);
    const [changeVersionModal, setChangeVersionModal] = useState(false);
    const [selectedVersion, setSelectedVersion] = useState(null);

    useEffect(() => {
        if(!popId){
            const url = window.location.href.split("pop/historic/")
            setPopId(url[1]);
            fetchPops(url[1]);
        }else{
            fetchPops();
        }
    }, [filters, page])

    function fetchPops(id = null) {
        Axios.get(laroute.route('pop.historiclist', {id: id ? id : popId}), {
            params: {
                'page': page,
                ...filters
            }
        })
        .then(function (response) {
            const {data} = response;

            setPop(data.pop);
            setCurrentVersion(data.current_version);
            setVersions(data.historic);
        })
        .catch(function (error) {
            console.log(error)
        });
    }

    function handleFilters(filter) {
        setFilters(filter)
    }

    function handleViewVersion(version) {
        setSelectedVersion({
            ...version,
            uploads: pop.uploads,
            functions: pop.functions,
            processes: pop.processes,
        });
        setShowPanel(true);
    }

    function handleModalChangeVersion(version) {
        setSelectedVersion({
            ...version,
            uploads: pop.uploads,
            functions: pop.functions,
            processes: pop.processes,
        });
        setChangeVersionModal(true);
    }

    function handleChangeVersion() {
        //pop.version
        Axios.put(laroute.route('pop.version', {id: selectedVersion.id}))
        .then(function (response) {
            toastr.success("Versão atualizada com sucesso!", {"newestOnTop": false, "progressBar": true});
            setCurrentVersion(selectedVersion.id);

            setSelectedVersion(null);
            setChangeVersionModal(false);
        })
        .catch(function (error) {
            console.log(error)
        });
    }

    return (
        <>
            <HistoricFilters handleFilters={(filter) => handleFilters(filter)} />

            <div className="panel-body">
                {versions.total > 0 &&
                    versions.data.map(version => <HistoricCard
                        key={version.id}
                        currentVersion={version.id === currentVersion || version.id == currentVersion ? true : false}
                        version={version}
                        openVersion={(version) => handleViewVersion(version)}
                        changeVersion={(version) => handleModalChangeVersion(version)}
                    />)
                }

                {versions.last_page > 1 && (
                    <ul className="pagination">
                        {buildPaginate(versions.last_page).map(item => <li key={item} className="page-item"><button onClick={() => setPage(item)} className="page-link">{item}</button></li>)}
                    </ul>
                )}
            </div>

            {selectedVersion && (
                <SlidingPane
                    className='some-custom-class'
                    overlayClassName='slide-panel-aligna'
                    isOpen={showPanel}
                    title={selectedVersion ? `#${selectedVersion.pop_id}` : '#'}
                    subtitle={selectedVersion ? selectedVersion.title : ''}
                    onRequestClose={ () => setShowPanel(false)}
                >
                    <VersionView version={selectedVersion} />
                </SlidingPane>
            )}

            <Modal
            isOpen={changeVersionModal}
            contentLabel="Example Modal"
            style={modalStyles}
            >
                {selectedVersion && (
                    <div className="modal-dialog modal-simple modal-center">
                        <div className="modal-content">
                            <div className="modal-header">
                                <button type="button" className="close" onClick={() => changeVersionModal(false)}>
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h4 className="modal-title">Confirmação</h4>
                            </div>
                            <div className="modal-body">
                                <p>Você confirma a alteração de versão deste POP?</p>
                            </div>
                            <div className="modal-footer">
                                <button type="button" className="btn btn-default" onClick={() => changeVersionModal(false)}>Cancelar</button>
                                <button type="button" className="btn btn-primary" onClick={() => handleChangeVersion()}>Confirmar</button>
                            </div>
                        </div>
                    </div>
                )}
            </Modal>
        </>
    );
}

if (document.getElementById('popHistoric')) {
    ReactDOM.render(<PopHistoric />, document.getElementById('popHistoric'));
}
