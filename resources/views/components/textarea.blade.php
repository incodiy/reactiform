@once
    @push('scripts')
        <script type="module">
            import TextareaInput from '/js/vendor/reactiform/Components/Form/TextareaInput.jsx';
            window.TextareaInputComponent = (props) => <TextareaInput {...props} />;
        </script>
    @endpush
@endonce

<div data-react-component="TextareaInput" data-props="{{ json_encode($config) }}"></div>