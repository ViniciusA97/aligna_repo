import React, {useEffect, useState} from 'react';
import Select from 'react-select';

const optionsDiasDaSemana = [
    { value: '7', label: 'Domingo' },
    { value: '1', label: 'Segunda-feira' },
    { value: '2', label: 'Terça-feira' },
    { value: '3', label: 'Quarta-feira' },
    { value: '4', label: 'Quinta-feira' },
    { value: '5', label: 'Sexta-feira' },
    { value: '6', label: 'Sábado' },
]

export default function Semanal({rule, handleBuildValues, selectStyles}) {
    const [loading, setLoading] = useState(true);
    const [rules, setRules] = useState([]);

    const [firstOption, setFirstOption] = useState('');
    const [secondOption, setSecondOption] = useState('');

    const handleSelectFirstOption = value => {
        setFirstOption(value);
    }

    const handleSelectSecondOption = value => {
        setSecondOption(value);
    }

    const handleSelectOption = value => {
        handleBuildValues(value);
    }

    useEffect(() => {
        if(rule){
            setRules(rule)
            setSecondOption(rule.eachWeeks)
        }

        setTimeout(()=> {
            setLoading(false)
        }, 1000)
    }, [rule])

    useEffect(() => {
        handleBuildValues({
            day: firstOption,
            eachWeeks: secondOption
        });
    }, [firstOption, secondOption])

    return (
       <>
        {!loading && (
            <div>
                <div style={{marginLeft: '-10px', marginBottom: 15}}>
                    <Select
                        isMulti
                        placeholder="Selecione"
                        options={optionsDiasDaSemana}
                        styles={selectStyles}
                        onChange={handleSelectFirstOption}
                        defaultValue={rules.day}
                    />
                </div>
                <div className="frequencia-option-row">
                    <span>A cada</span>
                    <input
                    type="number"
                    className="form-control"
                    onChange={(el) => handleSelectSecondOption(el.target.value)}
                    value={secondOption}
                    style={{maxWidth:'120px', margin: '0 10px'}} /> <span>semanas</span>
                </div>
            </div>
        )}
       </>
    );
}
