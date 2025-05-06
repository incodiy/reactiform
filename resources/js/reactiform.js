import { lazy } from 'react';

const RichTextEditor = lazy(() => import('./Components/Form/RichTextEditor'));
const Combobox = lazy(() => import('./Components/Form/Combobox'));
const MultiFileUpload = lazy(() => import('./Components/Form/MultiFileUpload'));

export {
    RichTextEditor,
    Combobox,
    MultiFileUpload
};