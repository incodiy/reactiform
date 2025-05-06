import { ErrorDisplay } from './ErrorDisplay';

const Button = ({ config }) => {
    const [errors, setErrors] = useState([]);

    useEffect(() => {
        if(config.attributes['data-errors']) {
            setErrors(JSON.parse(config.attributes['data-errors']));
        }
    }, [config.attributes]);

    return (
        <>
            <button 
                type={config.type}
                className={`btn ${config.class}`}
                {...config.attributes}
            >
                {config.label}
            </button>
            <ErrorDisplay errors={errors} />
        </>
    );
};

export default Button;