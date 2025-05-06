import Slider from 'rc-slider';
import 'rc-slider/assets/index.css';
import { ErrorDisplay } from './ErrorDisplay';

const RangeInput = ({ config }) => {
    const [value, setValue] = useState(config.default_value);
    const [errors, setErrors] = useState([]);

    useEffect(() => {
        if(config.attributes['data-errors']) {
            setErrors(JSON.parse(config.attributes['data-errors']));
        }
    }, [config.attributes]);

    return (
        <div className="form-group range-slider">
            {config.showLabel && (
                <label htmlFor={config.attributes.id}>
                    {config.label} ({value})
                </label>
            )}
            
            <Slider
                min={config.min}
                max={config.max}
                step={config.step}
                value={value}
                onChange={setValue}
                marks={config.ticks.reduce((acc, tick) => {
                    acc[tick] = { label: tick };
                    return acc;
                }, {})}
                {...config.attributes}
            />
            
            <input type="hidden" name={config.name} value={value} />
            
            <ErrorDisplay errors={errors} />
        </div>
    );
};

export default RangeInput;