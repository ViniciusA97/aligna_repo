import React from 'react';

export default function VersionView({version}) {
    const urlPdf = laroute.route('pop.pdf');

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

    function handleBuilFrequency(rule) {
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

    return (
        <>
        {version && (
                <>
                    <h4 className="modal-title">{version.title}</h4>
                    <div className="modal-body pop-view-content">
                    <div className="row">
                        <div className="col-12">
                            <h5>Descrição</h5>
                            <div dangerouslySetInnerHTML={{ __html: version.description }} />
                        </div>
                    </div>

                    <div className="row">
                        <div className="col-12 col-md-3">
                            <h5>PDCA</h5>
                            <p>{version.pdca}</p>
                        </div>
                        <div className="col-12 col-md-3">
                            <h5>Perfil</h5>
                            <p>{version.perfil}</p>
                        </div>
                        <div className="col-12 col-md-3">
                            <h5>Status de Preenchimento</h5>
                            <p>{version.status_preenchimento}</p>
                        </div>
                        <div className="col-12 col-md-3">
                            <h5>Status de Execução</h5>
                            <p>{version.status_execucao}</p>
                        </div>
                    </div>

                    <hr />

                    <div className="row">
                        <div className="col-12">
                            <h5>Funções</h5>
                            <ul className="pop-items-row">
                                {version.functions.map(item => (
                                    <li key={item.id}>{item.title}</li>
                                ))}
                            </ul>
                        </div>
                    </div>

                    <hr />

                    <div className="row">
                        <div className="col-12">
                            <h5>Processos</h5>
                            <ul className="pop-items-row">
                                {version.processes.map(item => (
                                    <li key={item.id}>{item.title}</li>
                                ))}
                            </ul>
                        </div>
                    </div>

                    <hr />

                    <div className="row">
                        <div className="col-12 col-md-4">
                            <h5>Frequência</h5>
                            <p>
                                {handleBuilFrequency(version.recurrence.rrule)}
                            </p>
                        </div>
                        <div className="col-12 col-md-4">
                            <h5>Horas de Execução</h5>
                            <p>{version.hours}</p>
                        </div>
                        <div className="col-12 col-md-4">
                            <h5>Data de início</h5>
                            <p>{version.recurrence.start_date}</p>
                        </div>
                    </div>

                    <div className="row">
                        <div className="col-12">
                            <h5>Anexos</h5>
                            <ul className="pop-items-list">
                                {version.uploads.map(item => (
                                    <li key={item.id}>
                                        <a href={item.external_url} target="_blank">
                                            {item.title}
                                        </a>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    </div>

                    <hr />

                    <div className="row justify-content-end">
                        <div className="col-12 col-md-3">
                            <a href={urlPdf.replace('{id}',version.pop_id)} target="_blank" id="pop-view-pdf" className="btn btn-primary"><i className="icon wb-file" aria-hidden="true"></i> PDF</a>
                        </div>
                    </div>
                </div>
                </>
        )}
        </>
    );
}
