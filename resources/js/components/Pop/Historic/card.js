import React from 'react';
import {format} from 'date-fns';

export default function HistoricCard({currentVersion, version, openVersion, changeVersion}) {
  return (
    <div className="pop-item" style={{padding: '10px 40px 10px 15px', marginBottom: '30px'}}>
        <div className="pop-col">
            <div className="pop-header" style={{justifyContent: 'flex-start', marginBottom: '10px'}}>
                <h3 onClick={() => openVersion(version)} style={{flexGrow: 'initial', marginRight: '5px', marginBottom: 0, cursor: 'pointer'}}>
                    {version.title}
                </h3>

                {currentVersion && <span className="badge badge-info version-flag">Versão atual</span>}

            </div>
            <div className="pop-description" dangerouslySetInnerHTML={{ __html: version.description }} />
        </div>

        <div className="pop-col" style={{alignItems: 'flex-end'}}>
            <h4>Salvo por</h4>
            <p className="blue-grey-500">{version.created_by.name}</p>
        </div>
        <div className="pop-col mr-0" style={{alignItems: 'flex-end'}}>
            <h4>Salvo em</h4>
            <p className="blue-grey-500">{format(new Date(version.updated_at) ,'dd/MM/yyyy')}</p>
        </div>

        {!currentVersion && <button className="btn protip btn-revert-historic"
            data-pt-title="Tornar essa versão como Atual"
            data-pt-position="top" data-pt-size="tiny" data-pt-scheme="dark"
            type="button"
            onClick={() => changeVersion(version)}
        >
            <i className="icon wb-refresh"></i>
        </button>}
    </div>
  );
}
