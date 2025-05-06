import { ErrorDisplay } from './ErrorDisplay';

const FileInput = ({ config }) => {
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
                type="file"
                name={config.name}
                multiple={config.multiple}
                accept={config.accept}
                {...config.attributes}
            />
            
            <ErrorDisplay errors={errors} />
        </div>
    );
};

export default FileInput;