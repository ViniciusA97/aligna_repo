import React, {useState, useEffect} from 'react';
import ReactDOM from 'react-dom';
import Axios from 'axios';

import Modal from 'react-modal';
import SlidingPanel from 'react-sliding-side-panel';
// import SlidingPane from 'react-sliding-pane';
// import 'react-sliding-pane/dist/react-sliding-pane.css';

import PopFilters from './Pop/filters';
import PopCard from './Pop/card';
import PopView from './Pop/view';
import PopDelete from './Pop/delete';

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

function PopList() {
    const url = laroute.route('pop.list');
    console.log(url);
    const [pops, setPops] = useState([]);

    const [inputSearch, setInputSearch] = useState('');
    const [search, setSearch] = useState('');
    const [showFilters, setShowFilters] = useState(false);
    const [filters, setFilters] = useState({});
    const [page, setPage] = useState(1);

    const [showPanel, setShowPanel] = useState(false);
    const [selectedPop, setSelectedPop] = useState(null);
    const [deleteModal, setDeleteModal] = useState(false);

    function fetchPops() {
        const params = {
            'page': page,
            'search': search,
            ...filters
        }

        Axios.get(url, {
            params
        })
        .then(function (response) {
            const {data} = response;
            //console.log(response);
            setPops(data.pops);
        })
        .catch(function (error) {
            console.log(error)
        });
    }

    function handleSearch(value) {
        setInputSearch(value);

        if(value === '' || value.length > 2){
            setSearch(value);
            setPage(1);
        }
    }

    function handleFilters(values) {
        setFilters(values);
    }

    function buildPaginate(pages) {
        const listPages = []
        for(let i = 1; i <= pages; i++){
            listPages.push(i);
        }

        return listPages;
    }

    function handleViewPop(pop) {
        setSelectedPop(pop);
        setShowPanel(true);
    }

    function handleDeletePop(open, pop = {}, confirm = false) {
        // $('#deleteModal').modal('toggle');
        if(open){
            setDeleteModal(true);
            setSelectedPop(pop);
        }else{
            if(confirm) {
                fetchPops();
            }
            setDeleteModal(false);
            setSelectedPop(null);
        }
    }

    const serialize = (obj) => {
        const str = [];
        for (var p in obj)
            if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            }
        return str.join("&");
    }

    function handleBuildPDF() {
        const params = {
            'page': page,
            'search': search,
            ...filters
        }

        const queryString = serialize(params)
        window.open(`${url}?${queryString}&format=pdf`)
    }

    useEffect(() => {
        fetchPops();
    }, [search, filters, page])

    return (
        <>
            <div>
                Text
            </div>
            <div className="panel-heading panel-heading-search">
                <div className="panel-search">
                    <div className="input-search input-search-dark">
                        <input
                            type="text"
                            className="form-control w-full"
                            placeholder="Buscar..."
                            name="search"
                            autoComplete="false"
                            value={inputSearch}
                            onChange={el => handleSearch(el.target.value)}
                        />
                        <button className="input-search-btn">
                            <i className="icon wb-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                <div className="panel-actions">
                    <button type="button" onClick={() => handleBuildPDF()} style={{backgroundColor: 'transparent', border:0}}>
                        <i class="far fa-file-pdf" style={{
                        fontSize: '24px',
                        lineHeight: '42px'
                    }}></i></button>
                    <div className="dropdown">
                        <a className="panel-action" data-toggle="dropdown" href="#" aria-expanded="false">
                            Ordernar por<i className="icon glyphicon glyphicon-sort" aria-hidden="true"></i>
                        </a>
                        <div className="dropdown-menu dropdown-menu-bullet dropdown-menu-right" role="menu" x-placement="bottom-start">
                            <div className="dropdown-header" role="presentation">Crescente</div>
                            <a className="dropdown-item" href="#" onClick={() => handleFilters({'by': 'id', 'order': 'asc'})} role="menuitem"><i className="icon wb-sort-asc" aria-hidden="true"></i> ID</a>
                            <a className="dropdown-item" href="#" onClick={() => handleFilters({'by': 'title', 'order': 'asc'})} role="menuitem"><i className="icon wb-sort-asc" aria-hidden="true"></i> Título</a>
                            <a className="dropdown-item" href="#" onClick={() => handleFilters({'by': 'date', 'order': 'asc'})} role="menuitem"><i className="icon wb-sort-asc" aria-hidden="true"></i> Data</a>

                            <div className="dropdown-header" role="presentation">Decrescente</div>
                            <a className="dropdown-item" href="#" onClick={() => handleFilters({'by': 'id', 'order': 'desc'})} role="menuitem"><i className="icon wb-sort-des" aria-hidden="true"></i> ID</a>
                            <a className="dropdown-item" href="#" onClick={() => handleFilters({'by': 'title', 'order': 'desc'})} role="menuitem"><i className="icon wb-sort-des" aria-hidden="true"></i> Título</a>
                            <a className="dropdown-item" href="#" onClick={() => handleFilters({'by': 'date', 'order': 'desc'})} role="menuitem"><i className="icon wb-sort-des" aria-hidden="true"></i> Data</a>
                        </div>
                    </div>
                    <button type="button" className="panel-action icon glyphicon glyphicon-filter btn-transparent"
                        onClick={() => setShowFilters(!showFilters)}
                    ></button>
                </div>
            </div>

            {showFilters && <PopFilters
                doHideFilters={() => setShowFilters(false)}
                doFilters={(filters) => handleFilters(filters)}
            />}

            <div className="panel-body">
            {pops.total > 0 &&
                pops.data.map(pop => <PopCard
                    key={pop.id}
                    pop={pop}
                    openPop={(pop) => handleViewPop(pop)}
                    deletePop={(open, pop) => handleDeletePop(open, pop)}
                />)
            }

            {pops.last_page > 1 && (
                <ul className="pagination">
                    {buildPaginate(pops.last_page).map(item => <li key={item} className="page-item"><button onClick={() => setPage(item)} className="page-link">{item}</button></li>)}
                </ul>
            )}
            </div>

            {selectedPop && (
                <SlidingPanel
                    panelClassName='slide-panel-aligna'
                    type={'right'}
                    isOpen={showPanel}
                    size={40}
                    backdropClicked={() => setShowPanel(false)}
                >
                    <PopView pop={selectedPop} deletePop={(open, pop) => handleDeletePop(open, pop)} />
                </SlidingPanel>
            )}
            {/* {selectedPop && (
                <SlidingPane
                    className='some-custom-class'
                    overlayClassName='slide-panel-aligna'
                    isOpen={showPanel}
                    title={selectedPop ? `#${selectedPop.id}` : '#'}
                    subtitle={selectedPop ? selectedPop.title : ''}
                    onRequestClose={ () => setShowPanel(false)}
                >
                    <PopView pop={selectedPop} />
                </SlidingPane>
            )} */}

            <Modal
            isOpen={deleteModal}
            onRequestClose={() => handleDeletePop(false)}
            contentLabel="POP"
            style={modalStyles}
            >
                {selectedPop && <PopDelete
                    pop={selectedPop}
                    handleModal={(open, pop, confirm) => handleDeletePop(open, pop, confirm)}
                />}
            </Modal>
        </>
    );
}

export default PopList;

if (document.getElementById('popList')) {
    ReactDOM.render(<PopList />, document.getElementById('popList'));
}
