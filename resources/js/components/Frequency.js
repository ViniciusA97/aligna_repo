import React, {useEffect, useState} from 'react';
import ReactDOM from 'react-dom';
import Axios from 'axios';

import Diario from './Frequency/diario';
import Semanal from './Frequency/semanal';
import Mensal from './Frequency/mensal';
import Anual from './Frequency/anual';

const selectStyles = {
    indicatorSeparator: styles => ({...styles, backgroundColor: 'transparent'}),
    placeholder: styles => ({...styles, color: '#a2aeb9', fontSize: '14px', fontWeight: '300'}),
    option: styles => ({...styles, color: '#76838f', fontSize: '14px', fontWeight: '300'}),
    singleValue: styles => ({...styles, color: '#76838f', fontSize: '14px', fontWeight: '300'}),
    multiValue: styles => ({...styles, color: '#76838f', fontSize: '14px', fontWeight: '300'}),
};

const selectSmStyles = {
    control: styles => ({ ...styles, backgroundColor: 'white', minWidth: '80px', borderColor: '#e4eaec', margin: '0 10px' }),
    ...selectStyles
}

const selectMdStyles = {
    control: styles => ({ ...styles, backgroundColor: 'white', minWidth: '120px', borderColor: '#e4eaec', margin: '0 10px' }),
    ...selectStyles
}

const selectLgStyles = {
    control: styles => ({ ...styles, backgroundColor: 'white', minWidth: '160px', maxWidth:'360px', borderColor: '#e4eaec', margin: '0 10px' }),
    ...selectStyles
}

export default function Frequency() {
    const [loading, setLoading] = useState(true);
    const [option, setOption] = useState('diario');
    const [frequencia, setFrequencia] = useState('');
    const [rule, setRule] = useState(null);

    function handleSelectionOption(value) {
        setOption(value);
        setFrequencia('');
    }

    function handleBuildFrequency(value) {
        setFrequencia({
            freq: option,
            values: value
        });
    }

    useEffect(() => {
        const url = window.location.href.split("pop/edit/");
        if(url.length > 1) {
            Axios.get( laroute.route('pop.show', {id: url[1]}) )
            .then(function (response) {
                const {data} = response;
                if(data.recurrence){
                    setFrequencia({
                        freq: data.recurrence.rule.FREQ,
                        values: data.recurrence.rule.WHEN
                    });
                    setOption(data.recurrence.rule.FREQ);
                    setRule(data.recurrence.rule.WHEN);
                }
                setTimeout(() => {
                    setLoading(false);
                }, 500);
            })
            .catch(function (error) {
                console.log(error)
            });
        }else{
            setLoading(false);
        }
    }, [])

    return (
        <>
            {!loading && (
                <>
                    <input type="hidden" name="frequencia" defaultValue={frequencia !== '' ? JSON.stringify(frequencia) : ''} />
                    <div className="row">
                        <div className="form-group col-12">
                            <label className="form-control-label">Frequencia *</label>
                            <br />
                            <div className="btn-group btn-group-md" aria-label="Large button group" role="group">
                            <button onClick={() => handleSelectionOption('diario')} type="button" className={`btn ${option === 'diario' ? 'btn-primary' : 'btn-outline btn-default'}`}>
                                {option === 'diario' && <i className="icon wb-check text-active" aria-hidden="true"></i>}Diário
                            </button>
                            <button onClick={() => handleSelectionOption('semanal')} type="button" className={`btn ${option === 'semanal' ? 'btn-primary' : 'btn-outline btn-default'}`}>
                                {option === 'semanal' && <i className="icon wb-check text-active" aria-hidden="true"></i>}Semanal
                            </button>
                            <button onClick={() => handleSelectionOption('mensal')} type="button" className={`btn ${option === 'mensal' ? 'btn-primary' : 'btn-outline btn-default'}`}>
                                {option === 'mensal' && <i className="icon wb-check text-active" aria-hidden="true"></i>}Mensal
                            </button>
                            <button onClick={() => handleSelectionOption('anual')} type="button" className={`btn ${option === 'anual' ? 'btn-primary' : 'btn-outline btn-default'}`}>
                                {option === 'anual' && <i className="icon wb-check text-active" aria-hidden="true"></i>}Anual
                            </button>
                            </div>
                        </div>
                    </div>

                    <div className="row">
                        <div className="form-group col-12">
                            <div className="frequencia-options">
                                {option === 'diario' && <Diario handleBuildValues={(value) => handleBuildFrequency(value)} rule={rule} />}
                                {option === 'semanal' && (<Semanal handleBuildValues={(value) => handleBuildFrequency(value)} rule={rule} selectStyles={selectLgStyles} />)}
                                {option === 'mensal' && (<Mensal handleBuildValues={(value) => handleBuildFrequency(value)} rule={rule} selectSmStyles={selectSmStyles} selectMdStyles={selectMdStyles} selectLgStyles={selectLgStyles} />)}
                                {option === 'anual' && (<Anual handleBuildValues={(value) => handleBuildFrequency(value)} rule={rule} selectSmStyles={selectSmStyles} selectMdStyles={selectMdStyles} selectLgStyles={selectLgStyles} />)}
                            </div>
                        </div>
                    </div>
                </>
            )}
        </>
    );
}

if (document.getElementById('frequencyBox')) {
    ReactDOM.render(<Frequency />, document.getElementById('frequencyBox'));
}
