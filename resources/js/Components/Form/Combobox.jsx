import React, { useState, useEffect } from 'react';
import Select from 'react-select';
import AsyncSelect from 'react-select/async';
import { ErrorDisplay } from './ErrorDisplay';

const Combobox = ({ config }) => {
    const [options, setOptions] = useState(config.options);
    const [value, setValue] = useState(null);
    const [errors, setErrors] = useState([]);

    useEffect(() => {
        if(config.attributes['data-errors']) {
            setErrors(JSON.parse(config.attributes['data-errors']));
        }
    }, [config.attributes]);

    const loadOptions = async (inputValue) => {
        if(config.async_source) {
            const response = await axios.get(config.async_source, {
                params: { q: inputValue }
            });
            return response.data;
        }
        return options.filter(option =>
            option.label.toLowerCase().includes(inputValue.toLowerCase())
        );
    };

    return (
        <div className="combobox-wrapper">
            {config.showLabel && (
                <label>{config.label}</label>
            )}
            
            {config.async_source ? (
                <AsyncSelect
                    isMulti={config.tags}
                    isCreatable={config.creatable}
                    defaultOptions
                    loadOptions={loadOptions}
                    minInputLength={config.min_chars}
                    onChange={setValue}
                    {...config.attributes}
                />
            ) : (
                <Select
                    isMulti={config.tags}
                    options={options}
                    onChange={setValue}
                    {...config.attributes}
                />
            )}
            
            <input type="hidden" 
                name={config.name} 
                value={value ? JSON.stringify(value) : ''} 
            />
            
            <ErrorDisplay errors={errors} />
        </div>
    );
};

export default Combobox;