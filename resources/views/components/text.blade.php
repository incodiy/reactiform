@once
    @push('scripts')
        <script type="module">
            import TextInput from '/js/vendor/reactiform/Components/Form/TextInput.jsx';
            window.TextInputComponent = (props) => <TextInput {...props} />;
        </script>
    @endpush
@endonce

<div data-react-component="TextInput" data-props="{{ json_encode($config) }}"></div>