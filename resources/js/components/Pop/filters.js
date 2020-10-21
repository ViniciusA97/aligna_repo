import React, {useEffect, useState} from 'react';
import Select from 'react-select';
import Axios from 'axios';

export default function PopFilters({ doHideFilters, doFilters }) {
    const url = laroute.route('pop.selects');

    const [loading, setLoading] = useState(true);
    const [selects, setSelects] = useState({});
    const [filters, setFilters] = useState({});

    useEffect(() => {
        Axios.get(url)
        .then(function (response) {
            const {data} = response;

            const selectsList = {
                'process': [{'value': {'process': ''}, 'label': 'Selecione'}],
                'pdca': [{'value': {'pdca': ''}, 'label': 'Selecione'}],
                'status_preenchimento': [{'value': {'status_preenchimento': ''}, 'label': 'Selecione'}],
                'status_execucao': [{'value': {'status_execucao': ''}, 'label': 'Selecione'}],
                'functions': [{'value': {'function': ''}, 'label': 'Selecione'}],
                'perfil': [{'value': {'perfil': ''}, 'label': 'Selecione'}],
            }

            data.process.map(item => selectsList.process.push({'value': {'process': item.id}, 'label': item.title}));
            data.functions.map(item => selectsList.functions.push({'value': {'function': item.id}, 'label': item.title}));

            data.pdca.map(item => selectsList.pdca.push({'value': {'pdca': item}, 'label': item}));
            data.perfil.map(item => selectsList.perfil.push({'value': {'perfil': item}, 'label': item}));

            data.status.preenchimento.map(item => selectsList.status_preenchimento.push({'value': {'status_preenchimento': item}, 'label': item}));
            data.status.execucao.map(item => selectsList.status_execucao.push({'value': {'status_execucao': item}, 'label': item}));

            setSelects(selectsList);
            setLoading(false);
        })
        .catch(function (error) {
            console.log(error)
        });
    }, [])

    const handleSelectChange = (value) => {
        setFilters({...filters, ...value.value})
    }

    function handleResetFilters() {
        setFilters({});
        doFilters({})
    }

    return (
        <>
            {!loading && (
            <div id="filters-panel" className="panel panel-with-bg">
                <div className="panel-heading">
                    <h3 className="panel-title">Filtrar por</h3>
                    <div className="panel-actions panel-actions-keep">
                        <button className="panel-action icon wb-close toggle-filters btn-transparent"
                            onClick={() => doHideFilters()}
                        ></button>
                    </div>
                </div>
                <div className="panel-body">
                    <div className="form-row">
                        <div className="form-group col-xs-12 col-md-3">
                            <label className="form-control-label">Processo</label>
                            <Select
                                placeholder="Selecione"
                                options={selects.process}
                                onChange={handleSelectChange}
                            />
                        </div>
                        <div className="form-group col-xs-12 col-md-3">
                            <label className="form-control-label">PDCA</label>
                            <Select
                                placeholder="Selecione"
                                options={selects.pdca}
                                onChange={handleSelectChange}
                            />
                        </div>
                        <div className="form-group col-xs-12 col-md-3">
                            <label className="form-control-label">Status de Preenchimento</label>
                            <Select
                                placeholder="Selecione"
                                options={selects.status_preenchimento}
                                onChange={handleSelectChange}
                            />
                        </div>
                        <div className="form-group col-xs-12 col-md-3">
                            <label className="form-control-label">Status de Execução</label>
                            <Select
                                placeholder="Selecione"
                                options={selects.status_execucao}
                                onChange={handleSelectChange}
                            />
                        </div>
                    </div>

                    <div className="form-row">
                        <div className="form-group col-xs-12 col-md-4">
                            <label className="form-control-label">Função</label>
                            <Select
                                placeholder="Selecione"
                                options={selects.functions}
                                onChange={handleSelectChange}
                            />
                        </div>
                        <div className="form-group col-xs-12 col-md-4">
                            <label className="form-control-label">Perfil</label>
                            <Select
                                placeholder="Selecione"
                                options={selects.perfil}
                                onChange={handleSelectChange}
                            />
                        </div>
                        <div className="form-group col-xs-12 col-md-4 panel-with-bg-footer">
                            <button className="btn btn-transparent" onClick={() => handleResetFilters()}>Limpar Filtros</button>
                            <button className="btn btn-secondary" onClick={() => doFilters(filters)}>Aplicar Filtros</button>
                        </div>
                    </div>
                </div>
            </div>
            )}
        </>
    );
}
