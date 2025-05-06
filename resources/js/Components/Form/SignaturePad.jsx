import React, { useRef } from 'react';
import SignatureCanvas from 'react-signature-canvas';
import { ErrorDisplay } from './ErrorDisplay';

/**
    // Contoh validasi di controller
    $request->validate([
        'signature' => [
            'required',
            function ($attribute, $value, $fail) {
                if (!preg_match('/^data:image\/(png|jpeg);base64/', $value)) {
                    $fail('Invalid signature format');
                }
            }
        ]
    ]); 
 */
const SignatureInput = ({ config }) => {
    const sigPad = useRef();
    const [isSigned, setIsSigned] = useState(false);

    const clear = () => {
        sigPad.current.clear();
        setIsSigned(false);
    };

    const save = () => {
        const dataURL = sigPad.current.toDataURL();
        document.getElementById(`hidden-${config.name}`).value = dataURL;
        setIsSigned(true);
    };

    const [errors, setErrors] = useState([]);

    useEffect(() => {
        if(config.attributes['data-errors']) {
            setErrors(JSON.parse(config.attributes['data-errors']));
        }
    }, [config.attributes]);

    return (
        <div className="signature-wrapper">
            {config.showLabel && <label>{config.label}</label>}
            
            <div className="signature-container" 
                 style={{ 
                     backgroundColor: config.background,
                     maxWidth: config.max_width + 'px'
                 }}>
                <SignatureCanvas
                    ref={sigPad}
                    penColor={config.pen_color}
                    canvasProps={{ className: 'signature-canvas' }}
                    onEnd={save}
                />
            </div>
            
            <div className="signature-controls">
                <button type="button" onClick={clear}>
                    {config.clear_button_text || 'Clear Signature'}
                </button>
                <span className="signature-status">
                    {isSigned ? '✓' : '✖'}
                </span>
            </div>
            
            <input
                type="hidden"
                id={`hidden-${config.name}`}
                name={config.name}
            />

            <ErrorDisplay errors={errors} />
        </div>
    );
};

export default SignatureInput;
// This component uses the react-signature-canvas library to create a signature pad.