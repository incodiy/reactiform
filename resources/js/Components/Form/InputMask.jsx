import InputMask from 'react-input-mask';
import { ErrorDisplay } from './ErrorDisplay';

const MaskedInput = ({ config }) => {
    const [errors, setErrors] = useState([]);

    useEffect(() => {
        if(config.attributes['data-errors']) {
            setErrors(JSON.parse(config.attributes['data-errors']));
        }
    }, [config.attributes]);
    
    return (
        <div className="form-group">
            {config.showLabel && (
                <label htmlFor={config.attributes.id}>
                    {config.label}
                    {config.show_mask_format && (
                        <span className="mask-format">({config.mask_pattern})</span>
                    )}
                </label>
            )}
            
            <InputMask
                mask={config.mask_pattern}
                placeholder={config.placeholder_char}
                maskChar={config.placeholder_char}
                {...config.attributes}
            >
                {(inputProps) => <input {...inputProps} />}
            </InputMask>
            
            <ErrorDisplay errors={errors} />
        </div>
    );
};

export default MaskedInput;