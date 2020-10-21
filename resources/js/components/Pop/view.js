import React, {useEffect, useState} from 'react';
import Axios from 'axios';

export default function PopView({pop, deletePop}) {
    const url = laroute.route('pop.show');
    const urlPdf = laroute.route('pop.pdf');

    const [loading, setLoading] = useState(true);
    const [selectedPop, setSelectedPop] = useState(null);

    const historicUrl = laroute.route('pop.historic', {id:pop.id});
    const editUrl = laroute.route('pop.edit', {id:pop.id});
    const duplicateUrl = laroute.route('pop.duplicate', {id:pop.id});

    useEffect(() => {
        Axios.get(`${url.replace('{id}',pop.id)}`)
        .then(function (response) {
            const {data} = response;

            setSelectedPop(data);
            setLoading(false);
        })
        .catch(function (error) {
            console.log(error)
        });
    }, [])

    function handleBuildMensal(rule) {
        let mensalRule = '';

        if(rule.option === 'first') {
            mensalRule = `No dia ${rule.values.first.label} de cada mês, a cada ${rule.values.eachMonths} meses`;
        }else{
            mensalRule = `No(a) ${rule.values.first.label} ${rule.values.second.label} de cada mês, a cada ${rule.values.eachMonths} meses`;
        }

        return mensalRule;
    }

    function handleBuildAnual(rule) {
        let anualRule = '';

        if(rule.option === 'first') {
            anualRule = `No dia ${rule.values.first.label} de ${rule.values.second.label}`;
        }else{
            anualRule = `No(a) ${rule.values.first.label} ${rule.values.second.label} de ${rule.values.third.label}`
        }

        return anualRule;
    }

    function handleBuildFrequency(rule) {
        let freqRule = '';

        switch(rule.FREQ) {
            case 'diario':
                freqRule = `A cada ${rule.WHEN} dias`;
                break;

            case 'semanal':
                let days = '';
                rule.WHEN.day.map((item, index) => days = `${days}${index > 0 ? ',' : ''} ${item.label}`);
                freqRule = `Em toda(o): ${days}, a cada ${rule.WHEN.eachWeeks} semanas`;
                break;

            case 'mensal':
                freqRule = handleBuildMensal(rule.WHEN);
                break;

            case 'anual':
                freqRule = handleBuildAnual(rule.WHEN);
                break;

        }

        return freqRule;
    }

    function handleHoursMaks(hours) {
        let time = '';
        // if(Number(hours) === hours && hours % 1 !== 0) {
        if(hours.toString().includes(".")) {
            time = hours.toString().replace(".", ":");
        }else{
            time = `${hours}:00`
        }

        return hours < 10 ? `0${time}` : time
    }

    return (
        <>
        {!loading && selectedPop && (
                <>
                    <div className="modal-body pop-view-content">
                        <div className="row">
                            <div className="col-8 col-md-10">
                                <ul className="pop-actions-list">
                                    <li><a href={editUrl}><i className="icon wb-edit"></i></a></li>
                                    <li><a href={duplicateUrl}><i className="icon wb-copy"></i></a></li>
                                    <li><a href={historicUrl}><i className="icon wb-time"></i></a></li>
                                    <li><button onClick={() => deletePop(true, pop)}><i className="icon wb-trash"></i></button></li>
                                </ul>
                            </div>
                            <div className="col-4 col-md-2">
                                <ul className="pop-actions-list">
                                    <li><a href={urlPdf.replace('{id}',pop.id)} target="_blank" id="pop-view-pdf"><i className="icon wb-file" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-12">
                                <h4>Título</h4>
                                <p>{selectedPop.version.title}</p>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-12">
                                <h4>Resumo</h4>
                                <p>{selectedPop.version.resume || ''}</p>
                            </div>
                        </div>

                        <div className="row">
                            <div className="col-12 col-md-6">
                                <ul className="card-aligna-list">
                                    <li>
                                        <h5>Funções</h5>
                                        <ul className="pop-items-row">
                                            {selectedPop.functions && selectedPop.functions.map(item => (
                                                <li key={item.id}>{item.title}</li>
                                            ))}
                                        </ul>
                                    </li>
                                    <li>
                                        <h5>Processos</h5>
                                        <ul className="pop-items-row">
                                            {selectedPop.processes && selectedPop.processes.map(item => (
                                                <li key={item.id}>{item.title}</li>
                                            ))}
                                        </ul>
                                    </li>
                                    <li>
                                        <h5>PDCA</h5>
                                        <p>{selectedPop.version.pdca || ''}</p>
                                    </li>
                                    <li>
                                        <h5>Perfil</h5>
                                        <p>{selectedPop.version.perfil || ''}</p>
                                    </li>
                                </ul>
                            </div>

                            <div className="col-12 col-md-6">
                                <ul className="card-aligna-list">
                                    <li>
                                        <h5>Preenchimento</h5>
                                        <p>{selectedPop.version.status_preenchimento || ''}</p>
                                    </li>
                                    <li>
                                        <h5>Execução</h5>
                                        <p>{selectedPop.version.status_execucao || ''}</p>
                                    </li>
                                    <li>
                                        <h5>Frequência</h5>
                                        <p>
                                            {selectedPop.recurrence ? handleBuildFrequency(selectedPop.recurrence.rule) : ''}
                                        </p>
                                    </li>
                                    <li>
                                        <h5>Data de início</h5>
                                        <p>{selectedPop.recurrence ? selectedPop.recurrence.start_date : ''}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div className="row">
                            <div className="col-12">
                                <h4>Descrição</h4>
                                {selectedPop.version.description && <div dangerouslySetInnerHTML={{ __html: selectedPop.version.description }} />}
                            </div>
                        </div>

                        <div className="row">
                            <div className="col-12">
                                <h4>Anexos</h4>
                                <ul className="pop-items-list">
                                    {selectedPop.uploads && selectedPop.uploads.map(item => (
                                        <li key={item.id}>
                                            <a href={item.external_url} target="_blank">
                                                {item.title}
                                            </a>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </div>

                        {/* <div className="row justify-content-end">
                            <div className="col-12 col-md-3">
                                <a href={urlPdf.replace('{id}',pop.id)} target="_blank" id="pop-view-pdf" className="btn btn-primary"><i className="icon wb-file" aria-hidden="true"></i> PDF</a>
                            </div>
                        </div> */}
                    </div>
                </>
        )}
        </>
    );
}
