import React, {useState, useEffect} from 'react';

export default function Diario({handleBuildValues, rule}) {
    const [inputValue, setInputValue] = useState(null);

    useEffect(() => {
        if(rule)
            setInputValue(rule)
    }, [rule])

    function handleInput(value) {
        setInputValue(value)
        handleBuildValues(value)
    }

    return (
        <div className="frequencia-option-row">
            <span>A cada</span>
            <input
            type="number"
            className="form-control"
            onChange={(el) => handleInput(el.target.value)}
            value={inputValue}
            style={{maxWidth:'120px', margin: '0 10px'}} /> <span>dias</span>
        </div>
    );
}
