import { ErrorDisplay } from './ErrorDisplay';

const TextInput = ({ config }) => {
    const [errors, setErrors] = useState([]);

    useEffect(() => {
        if(config.attributes['data-errors']) {
            setErrors(JSON.parse(config.attributes['data-errors']));
        }
    }, [config.attributes]);
    
    return (
        <div className="form-group">
            {config.showLabel && <label htmlFor={config.attributes.id}>{config.label}</label>}
            <input 
                type={config.inputType} 
                name={config.name} 
                {...config.attributes} 
            />
            <ErrorDisplay errors={errors} />
        </div>
    );
};

export default TextInput;