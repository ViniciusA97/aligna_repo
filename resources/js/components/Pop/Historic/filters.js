import React, {useState} from 'react';
import {format} from 'date-fns';
import ptBr from 'date-fns/locale/pt-BR';

import DatePicker, { registerLocale, setDefaultLocale } from  "react-datepicker";
registerLocale('pt-BR', ptBr)
import "react-datepicker/dist/react-datepicker.css";

const inputStyle = {
    width: '38px',
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
    justifyContent: 'center'
}

export default function HistoricFilters({handleFilters}) {
    const [showFilters, setShowFilters] = useState(false);
    const [startDate, setStartDate] = useState(null);
    const [endDate, setEndDate] = useState(null);

    function handleClearFilters() {
        handleFilters();
        setStartDate(null);
        setEndDate(null);
    }

    return (
        <>
            <div className="panel-heading panel-heading-search">
                <div className="panel-actions" style={{marginRight: 0}}>
                    <button type="button" onClick={() => setShowFilters(!showFilters)}
                    className="panel-action icon glyphicon glyphicon-filter" style={{border: 0}}></button>
                </div>
            </div>

            {showFilters && (
                <div id="filters-panel" className="panel" style={{margin: '0 30px', backgroundColor: '#f1f4f5', borderRadius: 0, zIndex: 1200}}>
                    <div className="panel-heading">
                        <h3 className="panel-title">Filtrar por</h3>
                        <div className="panel-actions panel-actions-keep">
                            <a className="panel-action icon wb-close" onClick={() => setShowFilters(false)}></a>
                        </div>
                    </div>
                    <div className="panel-body">
                        <div className="form-row">
                            <div className="form-group col-xs-12 col-md-6">
                                <div className="input-daterange datepicker" style={{display: 'flex', flexDirection: 'row', justifyContent: 'flex-start'}}>
                                    <div className="input-group" style={{maxWidth: '225px'}}>
                                        <span className="input-group-addon" style={inputStyle}>
                                            <i className="icon wb-calendar" aria-hidden="true"></i>
                                        </span>
                                        <DatePicker
                                            dateFormat="dd/MM/yyyy"
                                            locale="pt-BR"
                                            selected={startDate}
                                            onChange={date => setStartDate(date)}
                                            selectsStart
                                            startDate={startDate}
                                            endDate={endDate}
                                            className="form-control"
                                        />
                                    </div>
                                    <div className="input-group">
                                        <span className="input-group-addon" style={inputStyle}>até</span>
                                        <DatePicker
                                            dateFormat="dd/MM/yyyy"
                                            locale="pt-BR"
                                            selected={endDate}
                                            onChange={date => setEndDate(date)}
                                            selectsEnd
                                            startDate={startDate}
                                            endDate={endDate}
                                            minDate={startDate}
                                            className="form-control"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div className="form-group col-xs-12 col-md-6" style={{display: 'flex', justifyContent: 'flex-end', alignItems: 'flex-end'}}>
                                <button type="button" className="btn" style={{marginRight: '10px'}}
                                    onClick={() => handleClearFilters()}
                                >Limpar Filtros</button>
                                <button type="button" className="btn btn-secondary"
                                    onClick={() => handleFilters({
                                        start: format(startDate, 'dd/MM/yyyy'),
                                        end: format(endDate, 'dd/MM/yyyy')
                                    })}
                                >Aplicar Filtros</button>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
}
