import React from 'react';

import ReactTooltip from 'react-tooltip';
import {statusPreenchimentoIcon, statusExecucaoColors, getFirstLetter} from '../../utils/labels';

export default function PopCard({pop, openPop, deletePop}) {
    const historicUrl = laroute.route('pop.historic', {id:pop.id});
    const editUrl = laroute.route('pop.edit', {id:pop.id});
    const duplicateUrl = laroute.route('pop.duplicate', {id:pop.id});

    return (
        <>
            <div className="pop-item">
                <div className="pop-content">
                    <div className="pop-header">
                        {pop.resume ? (
                            <h5 onClick={() => openPop(pop)} data-tip={pop.resume}>{pop.title}</h5>
                        ) : (
                            <h5 onClick={() => openPop(pop)}>{pop.title}</h5>
                        )}
                    </div>
                    <div className="pop-infos">
                        <ul>
                            {pop.status_preenchimento ? (
                                <li data-tip={pop.status_preenchimento}><i className={statusPreenchimentoIcon(pop.status_preenchimento)}></i></li>
                            ) : (
                                <li></li>
                            ) }
                            {pop.pdca ? (
                                <li data-tip={pop.pdca}>{getFirstLetter(pop.pdca)}</li>
                            ) : (
                                <li></li>
                            )}
                            {pop.status_execucao ? (
                                <li data-tip={pop.status_execucao}><span className="status_exercucao_label" style={{ backgroundColor: (statusExecucaoColors(pop.status_execucao)) }}></span></li>
                            ) : (<li></li>)}
                            {pop.perfil ? (
                                <li data-tip={pop.perfil}>{getFirstLetter(pop.perfil)}</li>
                            ) : (
                                <li></li>
                            )}
                        </ul>
                    </div>
                </div>
                <div className="pop-actions">
                    <div className="dropdown">
                        <button className="prop-action-dropdown" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i className="icon wb-more-vertical" aria-hidden="true"></i>
                        </button>
                        <div className="dropdown-menu dropdown-menu-bullet dropdown-menu-right" role="menu" x-placement="bottom-start">
                            <a className="dropdown-item" href={historicUrl} role="menuitem"><i className="icon wb-time" aria-hidden="true"></i> Histórico</a>
                            <a className="dropdown-item" href={editUrl} role="menuitem"><i className="icon wb-edit" aria-hidden="true"></i> Editar</a>
                            <a className="dropdown-item" href={duplicateUrl} role="menuitem"><i className="icon wb-copy" aria-hidden="true"></i> Duplicar</a>
                            <a className="dropdown-item" href="#" onClick={() => deletePop(true, pop)} role="menuitem"><i className="icon wb-trash" aria-hidden="true"></i> Excluir</a>
                        </div>
                    </div>
                </div>
            </div>
            <ReactTooltip place="top" />
        </>
    );
}
