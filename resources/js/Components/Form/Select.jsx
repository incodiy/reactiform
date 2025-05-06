import React from 'react';
import { ErrorDisplay } from './ErrorDisplay';

// const Select = ({ config }) => {
//     return (
//         <div className="form-group">
//             <label htmlFor={config.attributes.id}>{config.label}</label>
//             <select
//                 name={config.name}
//                 {...config.attributes}
//             >
//                 {config.options.map((option, index) => (
//                     <option key={index} value={option.value}>
//                         {option.label}
//                     </option>
//                 ))}
//             </select>
//         </div>
//     );
// };

// const Select = ({ config }) => {
//     return (
//         <div className="form-group">
//             {config.showLabel && (
//                 <label htmlFor={config.attributes.id}>
//                     {config.label}
//                 </label>
//             )}
//             <select
//                 name={config.name}
//                 {...config.attributes}
//             >
//                 {config.options.map((option, index) => (
//                     <option key={index} value={option.value}>
//                         {option.label}
//                     </option>
//                 ))}
//             </select>
//         </div>
//     );
// };

// const Select = ({ config }) => {
//     // Handle multiple selection
//     const selectProps = {
//         name: config.name,
//         multiple: config.multiple || false,
//         ...config.attributes,
//     };

//     return (
//         <div className="form-group">
//             {config.showLabel && (
//                 <label htmlFor={config.attributes.id}>{config.label}</label>
//             )}
//             <select {...selectProps}>
//                 {config.options.map((option, index) => (
//                     <option 
//                         key={index} 
//                         value={option.value}
//                         selected={option.selected}
//                     >
//                         {option.label}
//                     </option>
//                 ))}
//             </select>
            
//             {/* Tampilkan info multiple selection */}
//             {config.multiple && (
//                 <div className="form-help">
//                     Hold Ctrl/Cmd to select multiple options
//                 </div>
//             )}
//         </div>
//     );
// };

// export default Select;

const Select = ({ config }) => {
    const [errors, setErrors] = useState([]);

    useEffect(() => {
        if(config.attributes['data-errors']) {
            setErrors(JSON.parse(config.attributes['data-errors']));
        }
    }, [config.attributes]);
    
    // Handle multiple selection
    const isMultiple = config.attributes.multiple || false;
    
    // Get selected values from options
    const selectedValues = config.options
        .filter(option => option.selected && option.value !== '')
        .map(option => option.value);

    // Prepare select props
    const selectProps = {
        name: config.name,
        id: config.attributes.id,
        multiple: isMultiple,
        value: isMultiple ? selectedValues : selectedValues[0] || '',
        ...config.attributes
    };

    return (
        <div className="form-group">
            {config.showLabel && (
                <label htmlFor={config.attributes.id}>
                    {config.label}
                    {isMultiple && config.attributes.required && (
                        <span className="required-asterisk">*</span>
                    )}
                </label>
            )}
            
            <select {...selectProps}>
                {config.options.map((option, index) => (
                    <option 
                        key={index} 
                        value={option.value}
                        disabled={option.value === ''}
                    >
                        {option.label || '-- Select --'}
                    </option>
                ))}
            </select>
            
            {isMultiple && (
                <div className="form-help-text">
                    {config.attributes['data-help'] || 'Hold Ctrl/Cmd to select multiple options'}
                </div>
            )}
            <ErrorDisplay errors={errors} />
        </div>
    );
};

export default Select;