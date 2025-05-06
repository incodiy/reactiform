import React, { useCallback } from 'react';
import { useDropzone } from 'react-dropzone';
import fileType from 'file-type/browser';
import { ErrorDisplay } from './ErrorDisplay';

const MultiFileUpload = ({ config }) => {
    const [files, setFiles] = useState([]);
    const [errors, setErrors] = useState([]);

    useEffect(() => {
        if(config.attributes['data-errors']) {
            setErrors(JSON.parse(config.attributes['data-errors']));
        }
    }, [config.attributes]);

    const validator = async (file) => {
        const errors = [];
        const maxSize = parseInt(config.max_size) * 1024 * 1024;
        
        // Size validation
        if(file.size > maxSize) {
            errors.push(`File ${file.name} exceeds size limit`);
        }
        
        // Type validation
        const type = await fileType.fromBlob(file);
        if(!file.type.match(config.accept.replace('*/*', ''))) {
            errors.push(`Invalid file type: ${file.name}`);
        }
        
        return errors;
    };

    const { getRootProps, getInputProps } = useDropzone({
        accept: config.accept,
        maxFiles: config.max_files,
        validator,
        onDrop: acceptedFiles => {
            setFiles(acceptedFiles.map(file => 
                Object.assign(file, {
                    preview: URL.createObjectURL(file)
                })
            ));
            setErrors([]);
        },
        onDropRejected: rejectedFiles => {
            setErrors(rejectedFiles.flatMap(f => f.errors));
        }
    });

    return (
        <div className="multifile-upload">
            {config.showLabel && <label>{config.label}</label>}
            
            <div {...getRootProps({ className: 'dropzone' })}>
                <input {...getInputProps()} />
                <p>Drag files here or click to upload</p>
                <em>(Max {config.max_files} files, {config.max_size})</em>
            </div>

            {errors.length > 0 && (
                <div className="upload-errors">
                    {errors.map((error, i) => (
                        <div key={i}>{error}</div>
                    ))}
                </div>
            )}

            {config.preview && (
                <div className="previews">
                    {files.map(file => (
                        <div key={file.name} className="preview-item">
                            <img src={file.preview} alt={file.name} />
                            <span>{file.name}</span>
                        </div>
                    ))}
                </div>
            )}
            
            <ErrorDisplay errors={errors} />
        </div>
    );
};

export default MultiFileUpload;