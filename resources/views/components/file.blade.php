@once
    @push('scripts')
        <script type="module">
            import FileInput from '/js/vendor/reactiform/Components/Form/FileInput.jsx';
            window.FileInputComponent = (props) => <FileInput {...props} />;
        </script>
    @endpush
@endonce

<div data-react-component="FileInput" data-props="{{ json_encode($config) }}"></div>