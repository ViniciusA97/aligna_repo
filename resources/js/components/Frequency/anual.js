import React, {useEffect, useState} from 'react';
import Select from 'react-select';

const optionsMesDias = [
    { value: 'last', label: 'Último dia' },
    { value: '1', label: '1' },
    { value: '2', label: '2' },
    { value: '3', label: '3' },
    { value: '4', label: '4' },
    { value: '5', label: '5' },
    { value: '6', label: '6' },
    { value: '7', label: '7' },
    { value: '8', label: '8' },
    { value: '9', label: '9' },
    { value: '10', label: '10' },
    { value: '11', label: '11' },
    { value: '12', label: '12' },
    { value: '13', label: '13' },
    { value: '14', label: '14' },
    { value: '15', label: '15' },
    { value: '16', label: '16' },
    { value: '17', label: '17' },
    { value: '18', label: '18' },
    { value: '19', label: '19' },
    { value: '20', label: '20' },
    { value: '21', label: '21' },
    { value: '22', label: '22' },
    { value: '23', label: '23' },
    { value: '24', label: '24' },
    { value: '25', label: '25' },
    { value: '26', label: '26' },
    { value: '27', label: '27' },
    { value: '28', label: '28' },
    { value: '29', label: '29' },
    { value: '30', label: '30' },
    { value: '31', label: '31' },
]

const optionsMeses = [
    { value: '1', label: 'Janeiro' },
    { value: '2', label: 'Fevereiro' },
    { value: '3', label: 'Março' },
    { value: '4', label: 'Abril' },
    { value: '5', label: 'Maio' },
    { value: '6', label: 'Junho' },
    { value: '7', label: 'Julho' },
    { value: '8', label: 'Agosto' },
    { value: '9', label: 'Setembro' },
    { value: '10', label: 'Outubro' },
    { value: '11', label: 'Novembro' },
    { value: '12', label: 'Dezembro' },
]

const optionsSemana = [
    { value: '1', label: '1°' },
    { value: '2', label: '2°' },
    { value: '3', label: '3°' },
    { value: '4', label: '4°' },
]

const optionsDiasDaSemana = [
    { value: '7', label: 'Domingo' },
    { value: '1', label: 'Segunda-feira' },
    { value: '2', label: 'Terça-feira' },
    { value: '3', label: 'Quarta-feira' },
    { value: '4', label: 'Quinta-feira' },
    { value: '5', label: 'Sexta-feira' },
    { value: '6', label: 'Sábado' },
]

export default function Anual({rule, handleBuildValues, selectSmStyles, selectMdStyles, selectLgStyles}) {
    const [loading, setLoading] = useState(true);
    const [optionRadio, setOptionRadio] = useState('first');

    const [firstOptionValues, setFirstOptionValues] = useState({'first': '', 'second': ''});
    const [secondOptionValues, setSecondOptionValues] = useState({'first': '', 'second': '', 'third': ''});

    const handleChangeFirstOptionA = value => setFirstOptionValues({...firstOptionValues, 'first': value})
    const handleChangeFirstOptionB = value => setFirstOptionValues({...firstOptionValues, 'second': value})

    const handleChangeSecondOptionA = value => setSecondOptionValues({...secondOptionValues, 'first': value})
    const handleChangeSecondOptionB = value => setSecondOptionValues({...secondOptionValues, 'second': value})
    const handleChangeSecondOptionC = value => setSecondOptionValues({...secondOptionValues, 'third': value})


    useEffect(() => {
        if(rule) {
            setOptionRadio(rule.option);

            setTimeout(() => {
                handleBuildValues({
                    option: rule.option,
                    values: rule.values
                })
                setLoading(false);
            }, 500)
        }else{
            setLoading(false);
        }
    }, [])

    useEffect(() => {
        handleBuildValues({
            option: optionRadio,
            values: optionRadio === 'first' ? firstOptionValues : secondOptionValues
        })
    }, [firstOptionValues, secondOptionValues])

  return (
    <>
        {!loading && (
            <>
                <div className="frequencia-option-row">
                    <div className="radio-custom radio-primary">
                        <input type="radio" id="inputRadioFirst" onChange={() => setOptionRadio('first')} checked={optionRadio === 'first'} />
                        <label htmlFor="inputRadioFirst">No dia</label>
                    </div>
                    {optionRadio === 'first' && (
                        <>
                            <Select
                                placeholder=""
                                options={optionsMesDias}
                                styles={selectMdStyles}
                                onChange={handleChangeFirstOptionA}
                                defaultValue={rule && rule.option === 'first' ? rule.values.first : ''}
                            />
                            <Select
                                placeholder=""
                                options={optionsMeses}
                                styles={selectMdStyles}
                                onChange={handleChangeFirstOptionB}
                                defaultValue={rule && rule.option === 'first' ? rule.values.second : ''}
                            />
                        </>
                    )}
                </div>
                <div className="frequencia-option-row">
                    <div className="radio-custom radio-primary">
                        <input type="radio" id="inputRadioSecond" onChange={() => setOptionRadio('second')} checked={optionRadio === 'second'} />
                        <label htmlFor="inputRadioSecond">No (a)</label>
                    </div>
                    {optionRadio === 'second' && (
                        <>
                            <Select
                                placeholder=""
                                options={optionsSemana}
                                styles={selectSmStyles}
                                onChange={handleChangeSecondOptionA}
                                defaultValue={rule && rule.option === 'second' ? rule.values.first : ''}
                            />
                            <Select
                                placeholder=""
                                options={optionsDiasDaSemana}
                                styles={selectLgStyles}
                                onChange={handleChangeSecondOptionB}
                                defaultValue={rule && rule.option === 'second' ? rule.values.second : ''}
                            />
                            <Select
                                placeholder=""
                                options={optionsMeses}
                                styles={selectMdStyles}
                                onChange={handleChangeSecondOptionC}
                                defaultValue={rule && rule.option === 'second' ? rule.values.third : ''}
                            />
                        </>
                    )}
                </div>
            </>
        )}
    </>
  );
}
