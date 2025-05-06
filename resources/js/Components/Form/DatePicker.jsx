import DatePicker from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';
import { ErrorDisplay } from './ErrorDisplay';

const DateInput = ({ config }) => {
    const [startDate, setStartDate] = useState(config.selected ? new Date(config.selected) : null);
    const [errors, setErrors] = useState([]);

    useEffect(() => {
        if(config.attributes['data-errors']) {
            setErrors(JSON.parse(config.attributes['data-errors']));
        }
    }, [config.attributes]);
    
    return (
        <div className="form-group">
            {config.showLabel && (
                <label htmlFor={config.attributes.id}>{config.label}</label>
            )}
            
            <DatePicker
                selected={startDate}
                onChange={(date) => setStartDate(date)}
                minDate={config.min_date ? new Date(config.min_date) : null}
                maxDate={config.max_date ? new Date(config.max_date) : null}
                showTimeSelect={config.show_time}
                timeIntervals={config.time_intervals}
                dateFormat={config.show_time ? 
                    `${config.date_format} ${config.time_format}` : 
                    config.date_format}
                className="form-control"
                {...config.attributes}
            />
            
            <ErrorDisplay errors={errors} />
        </div>
    );
};

export default DateInput;