export const ErrorDisplay = ({ errors }) => {
    if(!errors || errors.length === 0) return null;
    
    return (
        <div className="form-errors">
            {errors.map((error, index) => (
                <div key={index} className="error-message">{error}</div>
            ))}
        </div>
    );
};