import { ErrorDisplay } from './ErrorDisplay';

const CheckboxGroup = ({ config }) => {
    const [errors, setErrors] = useState([]);

    useEffect(() => {
        if(config.attributes['data-errors']) {
            setErrors(JSON.parse(config.attributes['data-errors']));
        }
    }, [config.attributes]);

    return (
        <div className="form-group">
            {config.showLabel && <label>{config.label}</label>}
            <div className={`checkbox-group ${config.stacked ? 'stacked' : 'inline'}`}>
                {config.options.map((option, index) => (
                    <div key={index} className="checkbox-item">
                        <input 
                            type="checkbox" 
                            id={`${config.attributes.id}-${index}`}
                            name={config.name} 
                            value={option.value}
                            {...config.attributes}
                        />
                        <label htmlFor={`${config.attributes.id}-${index}`}>
                            {option.label}
                        </label>
                    </div>
                ))}
            </div>
            
            <ErrorDisplay errors={errors} />
        </div>
    );
};

export default CheckboxGroup;