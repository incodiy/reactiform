import React, { useState } from 'react';
import ReactQuill from 'react-quill';
import 'react-quill/dist/quill.snow.css';
import { ErrorDisplay } from './ErrorDisplay';

const RichTextEditor = ({ config }) => {
    const [errors, setErrors] = useState([]);

    useEffect(() => {
        if(config.attributes['data-errors']) {
            setErrors(JSON.parse(config.attributes['data-errors']));
        }
    }, [config.attributes]);
    
    const [content, setContent] = useState(config.content || '');
    const [isUploading, setIsUploading] = useState(false);

    const imageHandler = async () => {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.click();
        
        input.onchange = async () => {
            const file = input.files[0];
            setIsUploading(true);
            
            try {
                const formData = new FormData();
                formData.append('file', file);
                
                const response = await axios.post(config.upload_handler, formData);
                const url = response.data.url;
                
                const quill = quillRef.current.getEditor();
                const range = quill.getSelection();
                quill.insertEmbed(range.index, 'image', url);
            } catch (error) {
                console.error('Upload failed:', error);
            }
            setIsUploading(false);
        };
    };

    const modules = {
        toolbar: {
            container: config.toolbar,
            handlers: { image: imageHandler }
        }
    };

    return (
        <div className="richtext-wrapper">
            {config.showLabel && (
                <label htmlFor={config.attributes.id}>{config.label}</label>
            )}
            
            <ReactQuill
                theme="snow"
                value={content}
                onChange={setContent}
                modules={modules}
                {...config.attributes}
            />
            
            {isUploading && <div className="upload-status">Uploading...</div>}
            <input type="hidden" name={config.name} value={content} />
            
            <ErrorDisplay errors={errors} />
        </div>
    );
};

export default RichTextEditor;