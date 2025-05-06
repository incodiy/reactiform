import { ErrorDisplay } from './ErrorDisplay';

const TextareaInput = ({ config }) => {
    const [errors, setErrors] = useState([]);

    useEffect(() => {
        if(config.attributes['data-errors']) {
            setErrors(JSON.parse(config.attributes['data-errors']));
        }
    }, [config.attributes]);

    return (
        <div className="form-group">
            {config.showLabel && <label htmlFor={config.attributes.id}>{config.label}</label>}
            <textarea 
                name={config.name} 
                rows={config.rows}
                {...config.attributes} 
            />
            <ErrorDisplay errors={errors} />
        </div>
    );
};

export default TextareaInput;